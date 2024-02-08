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
use Twilio\Rest\Client; // Importa a classe Client do Twilio


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

        return view('consulta.create', compact('statusConsultas', 'medicos', 'pacientes'));
    }

    public function saveConsulta(Request $request)
    {
        $request->validate([
            'data_consulta' => 'required|date',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fim' => 'required|date_format:H:i|after:hora_inicio',
            'observacoes' => 'nullable|string',
            'id_medico' => 'required|exists:medicos,id',
            'id_paciente' => 'required|exists:pacientes,id',
            'id_status' => 'required|exists:status_consultas,id',
        ]);

        try {
            DB::beginTransaction();

            $horaInicio = \Carbon\Carbon::createFromFormat('H:i', $request->input('hora_inicio'))->format('H:i');
            $horaFim = \Carbon\Carbon::createFromFormat('H:i', $request->input('hora_fim'))->format('H:i');

            $consulta = Consulta::create([
                'data_consulta' => $request->input('data_consulta'),
                'hora_inicio' => $horaInicio,
                'hora_fim' => $horaFim,
                'observacoes' => $request->input('observacoes'),
                'medico_id' => $request->input('id_medico'),
                'paciente_id' => $request->input('id_paciente'),
                'id_status' => $request->input('id_status'),
            ]);

            // Log das informações da consulta e do paciente
            Log::info('Consulta criada com sucesso.', [
                'consulta_id' => $consulta->id,
                'data_consulta' => $consulta->data_consulta,
                'hora_inicio' => $consulta->hora_inicio,
                'hora_fim' => $consulta->hora_fim,
                'observacoes' => $consulta->observacoes,
                'medico_id' => $consulta->medico_id,
                'paciente_id' => $consulta->paciente_id,
                'id_status' => $consulta->id_status,
                'paciente_email' => $consulta->paciente->email,
            ]);

            // Obtém o paciente associado à consulta
            $paciente = Paciente::find($request->input('id_paciente'));

            // Envia o e-mail de notificação de consulta marcada para o paciente
            if ($paciente) {
                Mail::to($paciente->email)->send(new ConsultaMarcadaMail($consulta));

                // Log para verificar se o e-mail foi enviado
                Log::info('E-mail de consulta marcada enviado para: ' . $paciente->email);
            }

            // Enviar SMS para o paciente
            if ($paciente && $paciente->telefone) {
                $twilio = new Client(
                    env('TWILIO_SID'),
                    env('TWILIO_AUTH_TOKEN')
                );

                $twilio->messages->create($paciente->telefone, [
                    'from' => env('TWILIO_FROM'),



                    'body' => '
Olá ' . $consulta->paciente->nome . ',
Sua consulta foi marcada com sucesso. Abaixo estão os detalhes:
Data da Consulta: ' . $consulta->data_consulta . '
Hora de Início: ' . $consulta->hora_inicio . '
Hora de Fim: ' . $consulta->hora_fim . '
Médico: ' . $consulta->medico->nome . '
Observações: ' . $consulta->observacoes . '
Obrigado por usar nosso serviço!
',

                ]);


                Log::info('SMS de consulta marcada enviado para: ' . $paciente->telefone);
            }


            DB::commit();

            return redirect('/consultaIndex')->with('success', 'Consulta salva com sucesso!');
        } catch (\Exception $e) {
            DB::rollback();

            Log::error('Erro ao salvar a consulta. ' . $e->getMessage());

            return redirect('/consultaIndex')->with('error', 'Erro ao salvar a consulta. Por favor, tente novamente.');
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
