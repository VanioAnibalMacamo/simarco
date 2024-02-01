<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gravidade;

class GravidadeController extends Controller
{
    public function index()
    {
        $gravidades = Gravidade::paginate(8);
        return view('parametrizacao.sintoma.gravidade.index', ['gravidades' => $gravidades]);
    }

    public function create()
    {
        return view('parametrizacao.sintoma.gravidade.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'descricao' => 'required|string|max:255|unique:gravidades',
        ]);

        Gravidade::create([
            'descricao' => $request->input('descricao'),
        ]);

        return redirect('/gravidadeIndex')->with('success', 'Gravidade criada com sucesso!');
    }

    public function edit($id)
    {
        $gravidade = Gravidade::findOrFail($id);

        return view('parametrizacao.sintoma.gravidade.edit', ['gravidade' => $gravidade]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'descricao' => 'required|string|max:255|unique:gravidades,descricao,' . $id,
        ]);

        $gravidade = Gravidade::findOrFail($id);
        $gravidade->update([
            'descricao' => $request->input('descricao'),
        ]);

        return redirect('/gravidadeIndex')->with('success', 'Gravidade atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $gravidade = Gravidade::findOrFail($id);

        // Verifique se existem sintomas referenciando esta gravidade
        $sintomasRelacionados = $gravidade->sintomas;

        if ($sintomasRelacionados->isEmpty()) {
            // Se não houver sintomas, exclua a gravidade
            $gravidade->delete();
            return redirect('/gravidadeIndex')->with('successDelete', 'Gravidade excluída com sucesso!');
        } else {
            // Se houver sintomas, exiba uma mensagem de erro ou redirecione para uma página informando sobre os sintomas relacionados.
            return redirect('/gravidadeIndex')->with('error', 'Existem sintomas relacionados a esta gravidade. Exclua os sintomas antes de excluir a gravidade.');
        }
    }


    public function show($id)
    {
        $gravidade = Gravidade::findOrFail($id);

        return view('parametrizacao.sintoma.gravidade.view', ['gravidade' => $gravidade]);
    }
}
