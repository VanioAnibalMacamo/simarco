<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Especialidade;

class EspecialidadeController extends Controller
{
    /*
    public function index()
    {
        $especialidades = Especialidade::paginate(8);
        return view('parametrizacao.medico.especialidade.index',['especialidades' => $especialidades]);
    }
        */

    public function index()
    {
        $especialidades = Especialidade::paginate(8);
        return view('parametrizacao.medico.especialidade.index', ['especialidades' => $especialidades]);
    }

    public function showModal()
    {
        $especialidades = Especialidade::all();
        return view('modals.modal_especialidades', ['especialidades' => $especialidades]);
    }

    public function create()
    {
        return view('parametrizacao.medico.especialidade.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'descricao' => 'required|string|max:255',
        ]);

        Especialidade::create([
            'descricao' => $request->input('descricao'),
        ]);

        return redirect('/especialidadeIndex')->with('success', 'Especialidade salva com sucesso!');
    }

    public function edit($id)
    {
        $especialidade = Especialidade::findOrFail($id);

        return view('parametrizacao.medico.especialidade.edit', ['especialidade' => $especialidade]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'descricao' => 'required|string|max:255',
        ]);

        $especialidade = Especialidade::findOrFail($id);
        $especialidade->update($request->all());

        return redirect('/especialidadeIndex')->with('success', 'Especialidade atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $especialidade = Especialidade::findOrFail($id);
        $especialidade->delete();

        return redirect('/especialidadeIndex')->with('successDelete', 'Especialidade excluída com sucesso!');
    }

    public function show($id)
    {
        $especialidade = Especialidade::findOrFail($id);

        return view('especialidade.view', ['especialidade' => $especialidade]);
    }

}


