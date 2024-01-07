<?php

namespace App\Http\Controllers;

use App\Models\StatusConsulta;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function index()
    {
        $status = StatusConsulta::paginate(8);
        return view('parametrizacao.consulta.statusconsulta.index', ['status' => $status]);
    }

    public function create()
    {
        return view('parametrizacao.consulta.statusconsulta.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'descricao' => 'required|string|max:255',
        ]);

        StatusConsulta::create([
            'descricao' => $request->input('descricao'),
        ]);

        return redirect('/statusIndex')->with('success', 'Status foi salvo com sucesso!');
    }

    public function edit($id)
    {
        $status = StatusConsulta::findOrFail($id);

        return view('parametrizacao.consulta.statusconsulta.edit', ['status' => $status]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'descricao' => 'required|string|max:255',
        ]);

        $status = StatusConsulta::findOrFail($id);
        $status->update($request->all());

        return redirect('/statusIndex')->with('success', 'Status  atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $status = StatusConsulta::findOrFail($id);
        $status->delete();

        return redirect('/statusIndex')->with('successDelete', 'Status excluído com sucesso!');
    }

    public function show($id)
    {
        $status = StatusConsulta::findOrFail($id);

        return view('status.view', ['status' => $status]);
    }
}
