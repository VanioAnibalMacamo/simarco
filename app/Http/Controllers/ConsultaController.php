<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consulta;
use App\Enums\DisponibilidadeEnum;
use App\Models\StatusConsulta;

class ConsultaController extends Controller
{
    public function index()
    {
        $consultas = Consulta::paginate(8);
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
            'duracao' => 'required|string|max:255',
            'id_status' => 'required|exists:status_consultas,id',
            'observacoes' => 'nullable|string',
            'numero_identificacao' => 'required|string|max:50',
        ]);

        Consulta::create([
            'data_consulta' => $request->input('data_consulta'),
            'duracao' => $request->input('duracao'),
            'id_status' => $request->input('id_status'),
            'observacoes' => $request->input('observacoes'),
            'numero_identificacao' => $request->input('numero_identificacao'),
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

        return view('consulta.view', ['consulta' => $consulta]);
    }

    public function edit($id)
    {
        $consulta = Consulta::findOrFail($id);
        $statusConsultas = StatusConsulta::all();
        $disponibilidades = DisponibilidadeEnum::getConstants();


        return view('consulta.edit', compact('consulta', 'statusConsultas', 'disponibilidades'));
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
