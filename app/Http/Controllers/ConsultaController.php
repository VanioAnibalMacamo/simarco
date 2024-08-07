<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Consulta;
use App\Models\StatusConsulta;
use App\Models\Paciente;
use App\Models\Medico;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConsultaMarcadaMail; // Importa a classe de e-mail
use App\Notifications\ConsultaMarcadaSMS;
use App\Enums\FormaPagamentoEnum;


class ConsultaController extends Controller
{
    public function index()
    {
        $consultas = Consulta::with('statusConsulta', 'medico', 'paciente')->paginate(8);
        return view('consulta.index', compact('consultas'));
    }


    public function create(Request $request)
    {
        $statusConsultas = StatusConsulta::all();
        $medicos = Medico::all();
        $pacientes = Paciente::all();
        $formasPagamento = FormaPagamentoEnum::getConstants();

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
            'statusConsultas',
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
        // Log dos dados recebidos
        \Log::info('Dados recebidos para salvar a consulta:', $request->only([
            'data_consulta',
            'hora_inicio',
            'hora_fim',
            'observacoes',
            'id_medico',
            'id_paciente',
            'id_status',
            'agendamento_id',
            'formaPagamento',
            'empresa',
            'codigoFuncionario'
        ]));

        // Validação dos dados
        $request->validate([
            'data_consulta' => 'required|date_format:d/m/Y',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fim' => 'required|date_format:H:i|after:hora_inicio',
            'observacoes' => 'nullable|string',
            'id_medico' => 'required|exists:medicos,id',
            'id_paciente' => 'required|exists:pacientes,id',
            'id_status' => 'required|integer',
            'agendamento_id' => 'required|exists:agendamentos,id',
            'formaPagamento' => 'nullable|string',
            'empresa' => 'nullable|string',
            'codigoFuncionario' => 'nullable|string'
        ]);

        try {
            // Converter data e hora para o formato do banco de dados
            $data_consulta = Carbon::createFromFormat('d/m/Y', $request->input('data_consulta'))->format('Y-m-d');
            $hora_inicio = Carbon::createFromFormat('H:i', $request->input('hora_inicio'))->format('H:i:s');
            $hora_fim = Carbon::createFromFormat('H:i', $request->input('hora_fim'))->format('H:i:s');

            // Log dos dados formatados
            \Log::info('Dados formatados para salvar a consulta:', [
                'data_consulta' => $data_consulta,
                'hora_inicio' => $hora_inicio,
                'hora_fim' => $hora_fim,
            ]);

            // Verificar se a data_consulta não é null
            if (empty($data_consulta)) {
                \Log::error('O campo data_consulta está vazio.');
                return redirect('/consultaIndex')->with('error', 'O campo data_consulta não pode estar vazio.');
            }

            // Criar a consulta
            $consulta = Consulta::create([
                'data_consulta' => $data_consulta,
                'hora_inicio' => $hora_inicio,
                'hora_fim' => $hora_fim,
                'observacoes' => $request->input('observacoes'),
                'medico_id' => $request->input('id_medico'),
                'paciente_id' => $request->input('id_paciente'),
                'id_status' => $request->input('id_status'),
                'formaPagamento' => $request->input('formaPagamento'),
                'empresa' => $request->input('empresa'),
                'codigoFuncionario' => $request->input('codigoFuncionario'),
                'agendamento_id' => $request->input('agendamento_id')
            ]);

            // Actualizar o agendamento com o ID da consulta
            $agendamento = Agendamento::find($request->input('agendamento_id'));
            $agendamento->update([
                'consulta_id' => $consulta->id
            ]);

            return redirect('/consultaIndex')->with('success', 'Consulta salva com sucesso!');
        } catch (\Exception $e) {
            // Log de erro detalhado
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
        $consulta = Consulta::with(['statusConsulta', 'medico', 'paciente', 'diagnostico', 'prescricao'])->findOrFail($id);
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

        return view('consulta.edit', compact('consulta', 'statusConsultas', 'pacientes', 'medicos', 'diagnostico', 'prescricao'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'data_consulta' => 'required|date',
                'hora_inicio' => 'required|date_format:H:i',
                'hora_fim' => 'required|date_format:H:i',
                'id_status' => 'required|exists:status_consultas,id',
                'observacoes' => 'nullable|string',
                'id_medico' => 'required|exists:medicos,id',
                'id_paciente' => 'required|exists:pacientes,id',
            ]);

            if (\Carbon\Carbon::createFromFormat('H:i', $request->input('hora_fim'))->lte(\Carbon\Carbon::createFromFormat('H:i', $request->input('hora_inicio')))) {
                throw new \Exception('A hora fim deve ser maior que a hora início.');
            }

            $consulta = Consulta::findOrFail($id);
            $consulta->medico()->dissociate();
            $consulta->paciente()->dissociate();
            $consulta->medico()->associate($request->input('id_medico'));
            $consulta->paciente()->associate($request->input('id_paciente'));

            $horaInicio = \Carbon\Carbon::createFromFormat('H:i', $request->input('hora_inicio'))->format('H:i');
            $horaFim = \Carbon\Carbon::createFromFormat('H:i', $request->input('hora_fim'))->format('H:i');

            $consulta->update([
                'data_consulta' => $request->input('data_consulta'),
                'hora_inicio' => $horaInicio,
                'hora_fim' => $horaFim,
                'id_status' => $request->input('id_status'),
                'observacoes' => $request->input('observacoes'),
            ]);

            Log::info('Consulta atualizada com sucesso.', ['consulta_id' => $consulta->id]);
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar a consulta.', [
                'consulta_id' => $id,
                'error_message' => $e->getMessage(),
                'error_trace' => $e->getTraceAsString(),
            ]);

            return redirect('/consultaIndex')->with('error', 'Erro ao atualizar a consulta. Por favor, verifique os dados e tente novamente.');
        }

        return redirect('/consultaIndex')->with('success', 'Consulta atualizada com sucesso!');
    }
}
