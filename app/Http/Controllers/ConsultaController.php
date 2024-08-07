<?php

namespace App\Http\Controllers;

use App\Enums\FormaPagamentoEnum;
use App\Models\Agendamento;
use App\Models\Medico;
use App\Models\Paciente;
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
        $validPaymentOptions = FormaPagamentoEnum::getValues();

        $request->validate([
            'data_consulta' => 'required|date_format:d/m/Y',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fim' => 'required|date_format:H:i|after:hora_inicio',
            'observacoes' => 'nullable|string',
            'id_medico' => 'required|exists:medicos,id',
            'id_paciente' => 'required|exists:pacientes,id',
            'agendamento_id' => 'required|exists:agendamentos,id',
            'formaPagamento' => 'nullable|in:' . implode(',', $validPaymentOptions),
            'empresa' => 'nullable|string',
            'codigoFuncionario' => 'nullable|string',
            'cartao_seguro_saude' => 'nullable|file|mimes:pdf,jpg,jpeg,png' // Validação para o arquivo
        ]);

        // Verifica a forma de pagamento
        $formaPagamento = $request->input('formaPagamento');
        if ($formaPagamento == 'Via Seguro de Saude' && !$request->hasFile('cartao_seguro_saude')) {
            return back()->with(['error' => 'O upload do documento é obrigatório para "Via Seguro de Saude".'])->withInput();
        }

        try {
            // Formata os dados
            $data_consulta = Carbon::createFromFormat('d/m/Y', $request->input('data_consulta'))->format('Y-m-d');
            $hora_inicio = Carbon::createFromFormat('H:i', $request->input('hora_inicio'))->format('H:i:s');
            $hora_fim = Carbon::createFromFormat('H:i', $request->input('hora_fim'))->format('H:i:s');

            // Cria a consulta
            $consulta = Consulta::create([
                'data_consulta' => $data_consulta,
                'hora_inicio' => $hora_inicio,
                'hora_fim' => $hora_fim,
                'observacoes' => $request->input('observacoes'),
                'medico_id' => $request->input('id_medico'),
                'paciente_id' => $request->input('id_paciente'),
                'forma_pagamento' => FormaPagamentoEnum::from($request->input('formaPagamento'))->value,
                'empresa' => $request->input('empresa'),
                'codigo_funcionario' => $request->input('codigoFuncionario'),
                'agendamento_id' => $request->input('agendamento_id')
            ]);

            // Verifica e cria as pastas necessárias
            $pastaPrincipal = 'consultas';
            $pastaCartaoSaude = 'cartao_saude';
            $pathPrincipal = storage_path("app/public/{$pastaPrincipal}");
            $pathCartaoSaude = "{$pathPrincipal}/{$pastaCartaoSaude}";

            if (!File::exists($pathPrincipal)) {
                File::makeDirectory($pathPrincipal, 0755, true);
            }

            if (!File::exists($pathCartaoSaude)) {
                File::makeDirectory($pathCartaoSaude, 0755, true);
            }

            // Faz o upload do arquivo se ele existir
            if ($request->hasFile('cartao_seguro_saude')) {
                $paciente = Paciente::find($request->input('id_paciente'));
                $nomePaciente = $paciente ? $paciente->nome : 'PacienteDesconhecido'; // Nome do paciente
                $dataConsulta = $request->input('data_consulta');
                $horaInicio = $request->input('hora_inicio');
                $horaFim = $request->input('hora_fim');
                $originalFile = $request->file('cartao_seguro_saude');
                $originalFileName = pathinfo($originalFile->getClientOriginalName(), PATHINFO_FILENAME);
                $extensao = $originalFile->getClientOriginalExtension();

                // Limpa caracteres indesejados do nome do arquivo
                $nomePaciente = preg_replace('/[^a-zA-Z0-9_\- ]/', '_', $nomePaciente); // Remove caracteres especiais
                $dataConsulta = preg_replace('/[^a-zA-Z0-9_\- ]/', '_', $dataConsulta);
                $horaInicio = preg_replace('/[^a-zA-Z0-9_\- ]/', '_', $horaInicio);
                $horaFim = preg_replace('/[^a-zA-Z0-9_\- ]/', '_', $horaFim);

                $nomeArquivo = "{$nomePaciente}_{$dataConsulta}_{$horaInicio}_{$horaFim}_{$originalFileName}.{$extensao}";

                // Armazena o arquivo com o novo nome
                $originalFile->storeAs("public/{$pastaPrincipal}/{$pastaCartaoSaude}", $nomeArquivo);

                // Atualiza o nome do arquivo na consulta
                $consulta->update(['cartao_seguro_saude' => $nomeArquivo]);
            }

            // Atualiza o agendamento
            $agendamento = Agendamento::find($request->input('agendamento_id'));
            $agendamento->update([
                'consulta_id' => $consulta->id
            ]);

            return redirect('/consultaIndex')->with('success', 'Consulta salva com sucesso!');
        } catch (\Exception $e) {
            \Log::error('Erro ao salvar a consulta.', [
                'error_message' => $e->getMessage(),
                'error_trace' => $e->getTraceAsString(),
            ]);

            return redirect('/consultaIndex')->with('error', 'Erro ao salvar a consulta. Por favor, verifique os dados e tente novamente.');
        }
    }

    public function delete($id)
    {
        $consulta = Consulta::findOrFail($id);
        $consulta->delete();

        return redirect('/consultaIndex')->with('successDelete', 'Consulta excluída com sucesso!');
    }

    public function show($id)
    {
        $consulta = Consulta::with(['medico', 'paciente', 'diagnostico', 'prescricao'])->findOrFail($id);
        $statusConsulta = $consulta->statusConsulta;
        $consulta->load('paciente');
        $consulta->load('medico');
        $diagnostico = $consulta->diagnostico;
        $prescricao = $consulta->prescricao;

        return view('consulta.view', compact('consulta', 'statusConsulta', 'diagnostico', 'prescricao'));
    }

    public function edit($id)
    {
        $consulta = Consulta::findOrFail($id);
        $statusConsultas = StatusConsulta::all();
        $pacientes = Paciente::all();
        $medicos = Medico::all();
        $diagnostico = $consulta->diagnostico;
        $prescricao = $consulta->prescricao;

        return view('consulta.edit', compact('consulta',  'pacientes', 'medicos', 'diagnostico', 'prescricao'));
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
                'empresa' => 'nullable|string',
                'codigo_funcionario' => 'nullable|string',
                'cartao_seguro_saude' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
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

    // Função para verificar e criar pastas
    private function verificarCriarPasta($caminho)
    {
        if (!File::exists($caminho)) {
            File::makeDirectory($caminho, 0755, true);
        }
    }
}
