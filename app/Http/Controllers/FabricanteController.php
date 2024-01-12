<?php

namespace App\Http\Controllers;

use App\Models\Fabricante;
use Illuminate\Http\Request;

class FabricanteController extends Controller
{
    public function index()
    {
        $fabricantes = Fabricante::paginate(8);
        return view('fabricante.index', ['fabricantes' => $fabricantes]);
    }

    public function create()
    {
        //  lógica de criação
        return view('fabricante.create');
    }

    public function saveFabricante(Request $request)
    {
        //  lógica de validação e salvamento
        Fabricante::create($request->all());

        return redirect('/fabricanteIndex')->with('success', 'Fabricante salvo com sucesso!');
    }

    public function delete($id)
    {
        $fabricante = Fabricante::findOrFail($id);
        $fabricante->delete();

        return redirect('/fabricanteIndex')->with('successDelete', 'Fabricante excluído com sucesso!');
    }

    public function show($id)
    {
        $fabricante = Fabricante::findOrFail($id);

        return view('fabricante.view', ['fabricante' => $fabricante]);
    }

    public function edit($id)
    {
        $fabricante = Fabricante::findOrFail($id);

        return view('fabricante.edit', ['fabricante' => $fabricante]);
    }

    public function update(Request $request, $id)
    {
        //  lógica de validação e atualização 
        $fabricante = Fabricante::findOrFail($id);
        $fabricante->update($request->all());

        return redirect('/fabricanteIndex')->with('success', 'Fabricante atualizado com sucesso!');
    }
}
