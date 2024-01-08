<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consulta;
use App\Models\StatusConsulta;
use App\Enums\StatusConsultaEnum;

class ConsultaController extends Controller
{
    public function index()
    {
        $consultas = Consulta::with('statusConsulta')->paginate(8);
        return view('consulta.index', ['consultas' => $consultas]);
    }


    public function create()
    {
        $statusConsultas = StatusConsulta::all();
        return view('consulta.create', compact('statusConsultas'));
    }

    public function saveConsulta(Request $request)
    {
        $request->validate([
            'data_consulta' => 'required|date',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fim' => 'required|date_format:H:i|after:hora_inicio',
            'id_status' => 'required|exists:status_consultas,id',
            'observacoes' => 'nullable|string',
        ]);

        // Cria a consulta
        Consulta::create([
            'data_consulta' => $request->input('data_consulta'),
            'hora_inicio' => $request->input('hora_inicio'),
            'hora_fim' => $request->input('hora_fim'),
            'id_status' => $request->input('id_status'),
            'observacoes' => $request->input('observacoes'),
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
        $consulta = Consulta::findOrFail($id);
        $statusConsulta = $consulta->statusConsulta;

        return view('consulta.view', ['consulta' => $consulta, 'statusConsulta' => $statusConsulta]);
    }

    public function edit($id)
    {
        $consulta = Consulta::findOrFail($id);
        $statusConsultas = StatusConsulta::all();



        return view('consulta.edit', compact('consulta', 'statusConsultas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'data_consulta' => 'required|date',
            'duracao' => 'required|string|max:255',
            'id_status' => 'required|exists:status_consultas,id',
            'observacoes' => 'nullable|string',
            'numero_identificacao' => 'required|string|max:50',
        ]);

        $consulta = Consulta::findOrFail($id);
        $consulta->update($request->all());

        return redirect('/consultaIndex')->with('success', 'Consulta atualizada com sucesso!');
    }
}
