<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gravidade;

class GravidadeController extends Controller
{
    public function index()
    {
        $gravidades = Gravidade::paginate(8);
        return view('parametrizacao.sintoma.gravidade.index', compact('gravidades'));
    }

    public function create()
    {
        return view('parametrizacao.sintoma.gravidade.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'descricao' => 'required|string|unique:gravidades',
        ]);

        Gravidade::create([
            'descricao' => $request->input('descricao'),
        ]);

        return redirect()->route('gravidadeIndex')->with('success', 'Gravidade criada com sucesso!');
    }

    public function edit($id)
    {
        $gravidade = Gravidade::findOrFail($id);
        return view('parametrizacao.sintoma.gravidade.edit', compact('gravidade'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'descricao' => 'required|string|unique:gravidades,descricao,' . $id,
        ]);

        $gravidade = Gravidade::find($id);

        if (!$gravidade) {
            return redirect()->route('gravidadeIndex')->with('error', 'Gravidade não encontrada.');
        }

        $gravidade->update([
            'descricao' => $request->input('descricao'),
        ]);

        return redirect()->route('gravidadeIndex')->with('success', 'Gravidade atualizada com sucesso.');
    }

    public function destroy($id)
    {
        $gravidade = Gravidade::findOrFail($id);
        $gravidade->delete();

        return redirect()->route('gravidadeIndex')->with('successDelete', 'Gravidade excluída com sucesso!');
    }
}
