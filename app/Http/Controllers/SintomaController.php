<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sintoma;
use App\Models\Consulta;
use App\Models\Gravidade;

class SintomaController extends Controller
{
    public function index()
    {
        $sintomas = Sintoma::paginate(8);
        return view('sintoma.index', compact('sintomas'));
    }

    public function create()
    {
        $consultas = Consulta::all();
        $gravidades = Gravidade::all();

        return view('sintoma.create', compact('consultas', 'gravidades'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'descricao' => 'required|string',
            'gravidade_id' => 'required|exists:gravidades,id',
            'duracao' => 'required|string',
            'consulta_id' => 'required|exists:consultas,id',
        ]);

        Sintoma::create([
            'descricao' => $request->input('descricao'),
            'gravidade_id' => $request->input('gravidade_id'),
            'duracao' => $request->input('duracao'),
            'consulta_id' => $request->input('consulta_id'),
        ]);

        return redirect()->route('sintoma.index')->with('success', 'Sintoma criado com sucesso!');
    }

    public function edit($id)
    {
        $sintoma = Sintoma::findOrFail($id);
        $consultas = Consulta::all();
        $gravidades = Gravidade::all();

        return view('sintoma.edit', compact('sintoma', 'consultas', 'gravidades'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'descricao' => 'required|string',
            'gravidade_id' => 'required|exists:gravidades,id',
            'duracao' => 'required|string',
            'consulta_id' => 'required|exists:consultas,id',
        ]);

        $sintoma = Sintoma::find($id);

        if (!$sintoma) {
            return redirect()->route('sintoma.index')->with('error', 'Sintoma não encontrado.');
        }

        $sintoma->update([
            'descricao' => $request->input('descricao'),
            'gravidade_id' => $request->input('gravidade_id'),
            'duracao' => $request->input('duracao'),
            'consulta_id' => $request->input('consulta_id'),
        ]);

        return redirect()->route('sintoma.index')->with('success', 'Sintoma atualizado com sucesso.');
    }

    public function show($id)
    {
        $sintoma = Sintoma::with('consulta', 'gravidade')->findOrFail($id);
        $consulta = $sintoma->consulta;

        return view('sintoma.view', compact('sintoma', 'consulta'));
    }

    public function delete($id)
    {
        $sintoma = Sintoma::findOrFail($id);
        $sintoma->delete();

        return redirect()->route('sintoma.index')->with('successDelete', 'Sintoma excluído com sucesso!');
    }
}
