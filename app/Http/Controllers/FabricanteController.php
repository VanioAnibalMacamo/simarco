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
        return view('fabricante.create');
    }

    public function saveFabricante(Request $request)
    {
        $request->validate([
            'nome' => 'required|string',
            'endereco' => 'required|string',
            'contacto' => 'required|string',
        ]);

        Fabricante::create([
            'nome' => $request->input('nome'),
            'endereco' => $request->input('endereco'),
            'contacto' => $request->input('contacto'),
        ]);

        return redirect('/fabricanteIndex')->with('success', 'Fabricante criado com sucesso!');
    }

    public function edit($id)
    {
        $fabricante = Fabricante::findOrFail($id);
        return view('fabricante.edit', compact('fabricante'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string',
            'endereco' => 'required|string',
            'contacto' => 'required|string',
        ]);

        $fabricante = Fabricante::findOrFail($id);
        $fabricante->update([
            'nome' => $request->input('nome'),
            'endereco' => $request->input('endereco'),
            'contacto' => $request->input('contacto'),
        ]);

        return redirect('/fabricanteIndex')->with('success', 'Fabricante atualizado com sucesso!');
    }

    public function show($id)
    {
        $fabricante = Fabricante::findOrFail($id);
        return view('fabricante.view', ['fabricante' => $fabricante]);
    }

    public function delete($id)
    {
        $fabricante = Fabricante::findOrFail($id);
        $fabricante->delete();

        return redirect('/fabricanteIndex')->with('successDelete', 'Fabricante excluído com sucesso!');
    }
}
