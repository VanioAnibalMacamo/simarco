<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consulta;
use App\Models\StatusConsulta;
use App\Models\Paciente;
use App\Models\Medico;

class ConsultaController extends Controller
{
    public function index()
    {
        $consultas = Consulta::with('statusConsulta', 'medicos', 'pacientes')->paginate(8);
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
            'id_status' => 'required|exists:status_consultas,id',
            'observacoes' => 'nullable|string',
            'id_medico' => 'required|exists:medicos,id',
            'id_paciente' => 'required|exists:pacientes,id',
        ]);

        $horaInicio = \Carbon\Carbon::createFromFormat('H:i', $request->input('hora_inicio'))->format('H:i');
        $horaFim = \Carbon\Carbon::createFromFormat('H:i', $request->input('hora_fim'))->format('H:i');

        $consulta = Consulta::create([
            'data_consulta' => $request->input('data_consulta'),
            'hora_inicio' => $horaInicio,
            'hora_fim' => $horaFim,
            'id_status' => $request->input('id_status'),
            'observacoes' => $request->input('observacoes'),
        ]);

        $consulta->medicos()->attach($request->input('id_medico'));
        $consulta->pacientes()->attach($request->input('id_paciente'));

        return redirect('/consultaIndex')->with('success', 'Consulta salva com sucesso!');
    }

    public function delete($id)
    {
        $consulta = Consulta::findOrFail($id);
        $consulta->medicos()->detach();
        $consulta->pacientes()->detach();
        $consulta->delete();

        return redirect('/consultaIndex')->with('successDelete', 'Consulta excluída com sucesso!');
    }

    public function show($id)
    {
        $consulta = Consulta::findOrFail($id);
        $statusConsulta = $consulta->statusConsulta;

        return view('consulta.view', compact('consulta', 'statusConsulta'));
    }

    public function edit($id)
    {
        $consulta = Consulta::findOrFail($id);
        $statusConsultas = StatusConsulta::all();
        $pacientes = Paciente::all();
        $medicos = Medico::all();

        return view('consulta.edit', compact('consulta', 'statusConsultas', 'pacientes', 'medicos'));
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

            $consulta->medicos()->detach();
            $consulta->pacientes()->detach();

            $consulta->medicos()->attach($request->input('id_medico'));
            $consulta->pacientes()->attach($request->input('id_paciente'));

            $horaInicio = \Carbon\Carbon::createFromFormat('H:i', $request->input('hora_inicio'))->format('H:i');
            $horaFim = \Carbon\Carbon::createFromFormat('H:i', $request->input('hora_fim'))->format('H:i');

            $consulta->update([
                'data_consulta' => $request->input('data_consulta'),
                'hora_inicio' => $horaInicio,
                'hora_fim' => $horaFim,
                'id_status' => $request->input('id_status'),
                'observacoes' => $request->input('observacoes'),
            ]);
        } catch (\Exception $e) {
            return redirect('/consultaIndex')->with('error', 'Erro ao atualizar a consulta. Por favor, verifique os dados e tente novamente.');
        }

        return redirect('/consultaIndex')->with('success', 'Consulta atualizada com sucesso!');
    }
}
