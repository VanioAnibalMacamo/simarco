<?php

namespace App\Http\Controllers;

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

    public function create()
    {
        $statusConsultas = StatusConsulta::all();
        $medicos = Medico::all();
        $pacientes = Paciente::all();
        $formasPagamento = FormaPagamentoEnum::getConstants();

        return view('consulta.create', compact('statusConsultas', 'medicos', 'pacientes', 'formasPagamento'));
    }


    public function saveConsulta(Request $request)
    {
        /*
        $request->validate([
            'data_consulta' => 'required|date',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fim' => 'required|date_format:H:i|after:hora_inicio',
            'observacoes' => 'nullable|string',
            'id_medico' => 'required|exists:medicos,id',
            'id_paciente' => 'required|exists:pacientes,id',
            'id_status' => 'required|integer', // Validação para campo inteiro
            //'forma_pagamento' => 'required|in:' . implode(',', FormaPagamentoEnum::getConstants()), // Validação de forma de pagamento usando a enumeração
        ]);
        */



        Consulta::create([
            'data_consulta' => $request->input('data_consulta'),
            'hora_inicio' => $request->input('hora_inicio'),
            'hora_fim' => $request->input('hora_fim'),
            'observacoes' => $request->input('observacoes'),
            'medico_id' => $request->input('id_medico'),
            'paciente_id' => $request->input('id_paciente'),
            'id_status' => $request->input('id_status'),
            //consulta->forma_pagamento = FormaPagamentoEnum::fromValue($request->input('forma_pagamento'));
        ]);

        return redirect('/consultaIndex')->with('success', 'Consulta salva com sucesso!');
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
