<?php

namespace App\Http\Controllers;

use App\Enums\FormaPagamentoEnum;
use App\Models\Agendamento;
use App\Models\Medico;
use App\Models\Paciente;
use App\Models\StatusConsulta;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Consulta;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class ConsultaController extends Controller
{
    public function index()
    {
        $consultas = Consulta::with('medico', 'paciente')->paginate(8);
        return view('consulta.index', compact('consultas'));
    }

    public function create(Request $request)
    {
        $medicos = Medico::all();
        $pacientes = Paciente::all();
        $formasPagamento = FormaPagamentoEnum::getValues();

        // Obter parâmetros da URL
        $agendamento_id = $request->query('agendamento_id');
        $paciente_id = $request->query('paciente_id');
        $medico_id = $request->query('medico_id');
        $data_consulta = $request->query('data_consulta');
        $hora_inicio = $request->query('hora_inicio');

        // Log dos parâmetros recebidos
        \Log::info('Dados recebidos para criação da consulta:', [
            'paciente_id' => $paciente_id,
            'medico_id' => $medico_id,
            'data_consulta' => $data_consulta,
            'hora_inicio' => $hora_inicio,
        ]);

        // Obter o agendamento correspondente, se existir
        $agendamento = Agendamento::where('paciente_id', $paciente_id)
            ->whereHas('disponibilidades', function ($query) use ($medico_id) {
                $query->where('medico_id', $medico_id);
            })
            ->first();

        // Definir data_consulta
        $data_consulta = $agendamento ? $agendamento->dia->format('d/m/Y') : $data_consulta;

        // Calcular hora_fim, se hora_inicio for fornecida
        $hora_fim = null;
        if ($hora_inicio) {
            try {
                $hora_inicio_obj = Carbon::createFromFormat('H:i', $hora_inicio);
                $hora_fim_obj = $hora_inicio_obj->copy()->addMinutes(30);
                $hora_fim = $hora_fim_obj->format('H:i');
            } catch (\Exception $e) {
                \Log::error('Erro ao calcular hora_fim: ' . $e->getMessage());
            }
        }

        return view('consulta.create', compact(
            'medicos',
            'pacientes',
            'formasPagamento',
            'paciente_id',
            'medico_id',
            'data_consulta',
            'hora_inicio',
            'hora_fim',
            'agendamento_id'
        ));
    }

    public function saveConsulta(Request $request)
{
    $request->validate([
        'data_consulta' => 'required|date_format:d/m/Y',
        'hora_inicio' => 'required|date_format:H:i',
        'hora_fim' => 'required|date_format:H:i|after:hora_inicio',
        'id_medico' => 'required|exists:medicos,id',
        'id_paciente' => 'required|exists:pacientes,id',
        'agendamento_id' => 'required|exists:agendamentos,id',
        'foto_1' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'foto_2' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'descricao' => 'nullable|string',
        'observacoes' => 'nullable|string',
        'medicamentos' => 'nullable|array',
        'medicamentos.*' => 'exists:medicamentos,id',
        'dosagens' => 'nullable|array',
        'instrucoes' => 'nullable|array',
        'dosagens.*' => 'nullable|string',
        'instrucoes.*' => 'nullable|string',
    ]);

    $paciente = Paciente::find($request->input('id_paciente'));

    try {
        // Formata os dados
        $data_consulta = Carbon::createFromFormat('d/m/Y', $request->input('data_consulta'))->format('Y-m-d');
        $hora_inicio = Carbon::createFromFormat('H:i', $request->input('hora_inicio'))->format('H:i:s');
        $hora_inicio_formatada = Carbon::createFromFormat('H:i:s', $hora_inicio)->format('H-i'); // Formata hora para nome de diretório
        $hora_inicio_formatada = preg_replace('/[^A-Za-z0-9\-]/', '_', $hora_inicio_formatada);

        // Nome do paciente
        $pacienteNome = preg_replace('/[^A-Za-z0-9\-]/', '_', $paciente->nome);

        // Define o diretório
        $pacienteDiretorio = 'public/fotos_consultas/' . $pacienteNome . '_' . $data_consulta . '_' . $hora_inicio_formatada;
        if (!Storage::exists($pacienteDiretorio)) {
            Storage::makeDirectory($pacienteDiretorio);
        }

        // Inicializa variáveis para as fotos
        $foto1Path = null;
        $foto2Path = null;

        // Processa foto_1
        if ($request->hasFile('foto_1')) {
            $foto1 = $request->file('foto_1');
            $foto1Nome = $pacienteNome . '_foto1.' . $foto1->getClientOriginalExtension();
            $foto1Path = $foto1->storeAs($pacienteDiretorio, $foto1Nome);
        }

        // Processa foto_2
        if ($request->hasFile('foto_2')) {
            $foto2 = $request->file('foto_2');
            $foto2Nome = $pacienteNome . '_foto2.' . $foto2->getClientOriginalExtension();
            $foto2Path = $foto2->storeAs($pacienteDiretorio, $foto2Nome);
        }

        // Cria a consulta
        $consulta = Consulta::create([
            'data_consulta' => $data_consulta,
            'hora_inicio' => $hora_inicio,
            'hora_fim' => $request->input('hora_fim'),
            'medico_id' => $request->input('id_medico'),
            'paciente_id' => $request->input('id_paciente'),
            'agendamento_id' => $request->input('agendamento_id'),
            'foto_1' => $foto1Path,
            'foto_2' => $foto2Path,
        ]);

        // Atualiza o agendamento
        $agendamento = Agendamento::find($request->input('agendamento_id'));
        $agendamento->update(['consulta_id' => $consulta->id]);

        // Salva diagnóstico, se fornecido
        if ($request->has('descricao') || $request->has('observacoes')) {
            $diagnostico = new Diagnostico([
                'data_diagnostico' => now(),
                'consulta_id' => $consulta->id,
                'descricao' => $request->input('descricao'),
                'observacoes' => $request->input('observacoes'),
            ]);
            $diagnostico->save();
        }

        // Salva prescrição, se medicamentos forem fornecidos
        if ($request->has('medicamentos')) {
            $prescricao = new Prescricao([
                'data_prescricao' => now(),
                'consulta_id' => $consulta->id,
            ]);
            $prescricao->save();

            $medicamentosSelecionados = $request->input('medicamentos');
            $dosagens = $request->input('dosagens');
            $instrucoes = $request->input('instrucoes');

            foreach ($medicamentosSelecionados as $medicamentoId) {
                if (isset($dosagens[$medicamentoId]) && isset($instrucoes[$medicamentoId])) {
                    $prescricao->medicamentos()->attach($medicamentoId, [
                        'dosagem' => $dosagens[$medicamentoId],
                        'instrucoes' => $instrucoes[$medicamentoId],
                    ]);
                }
            }
        }

        return redirect('/agendamentosMarcados')->with('success', 'Consulta salva com sucesso!');
    } catch (\Exception $e) {
        \Log::error('Erro ao salvar a consulta.', [
            'error_message' => $e->getMessage(),
            'error_trace' => $e->getTraceAsString(),
        ]);

        return redirect('/agendamentosMarcados')->with('error', 'Erro ao salvar a consulta. Por favor, verifique os dados e tente novamente.');
    }
}

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'data_consulta' => 'required|date',
                'hora_inicio' => 'required|date_format:H:i',
                'hora_fim' => 'required|date_format:H:i|after:hora_inicio',
                'observacoes' => 'nullable|string',
                'medico_id' => 'required|exists:medicos,id',
                'paciente_id' => 'required|exists:pacientes,id',
                'forma_pagamento' => 'nullable|in:' . implode(',', FormaPagamentoEnum::getValues()),

            ]);

            $consulta = Consulta::findOrFail($id);

            // Atualiza os dados da consulta
            $consulta->update([
                'data_consulta' => Carbon::createFromFormat('d/m/Y', $request->input('data_consulta'))->format('Y-m-d'),
                'hora_inicio' => Carbon::createFromFormat('H:i', $request->input('hora_inicio'))->format('H:i:s'),
                'hora_fim' => Carbon::createFromFormat('H:i', $request->input('hora_fim'))->format('H:i:s'),
                'observacoes' => $request->input('observacoes'),
                'medico_id' => $request->input('medico_id'),
                'paciente_id' => $request->input('paciente_id'),
                'forma_pagamento' => FormaPagamentoEnum::from($request->input('forma_pagamento'))->value,
                'empresa' => $request->input('empresa'),
                'codigo_funcionario' => $request->input('codigo_funcionario')
            ]);

            // Atualiza o arquivo se fornecido
            if ($request->hasFile('cartao_seguro_saude')) {
                $pathPrincipal = storage_path('app/public/consultas/cartao_saude');
                $originalFileName = $request->file('cartao_seguro_saude')->getClientOriginalName();
                $nomePaciente = $request->input('nome_paciente');
                $dataConsulta = $request->input('data_consulta');
                $horaInicio = $request->input('hora_inicio');
                $horaFim = $request->input('hora_fim');
                $nomeArquivo = "{$nomePaciente}_{$dataConsulta}_{$horaInicio}_{$horaFim}_{$originalFileName}";

                $request->file('cartao_seguro_saude')->storeAs('public/consultas/cartao_saude', $nomeArquivo);

                // Atualiza o nome do arquivo na consulta
                $consulta->update(['cartao_seguro_saude' => $nomeArquivo]);
            }

            return redirect('/consultaIndex')->with('success', 'Consulta atualizada com sucesso!');
        } catch (\Exception $e) {
            \Log::error('Erro ao atualizar a consulta.', [
                'error_message' => $e->getMessage(),
                'error_trace' => $e->getTraceAsString(),
            ]);

            return redirect('/consultaIndex')->with('error', 'Erro ao atualizar a consulta. Por favor, verifique os dados e tente novamente.');
        }
    }
    public function getConsultaHora($pacienteId)
{
    // Buscar a última consulta associada ao paciente
    $consultas = Consulta::where('paciente_id', $pacienteId)
        ->orderBy('data_consulta', 'desc')
        ->orderBy('hora_inicio', 'desc')
        ->first();

    if ($consultas) {
        return $consultas->hora_inicio;
    }

    return null;
}


   

}
