<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;

class EmpresaController extends Controller
{
    public function index()
    {
        $empresas = Empresa::all();
        return view('parametrizacao.empresas.index', compact('empresas'));
    }

    public function create()
    {
        return view('parametrizacao.empresas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required',
            'sigla' => 'nullable',
            'nuit' => 'required|unique:empresas',
            'email' => 'required|unique:empresas',
            'contacto1' => 'required',
            'contacto2' => 'nullable',
            'localizacao' => 'nullable',
        ]);

        Empresa::create($request->all());

        return redirect()->route('parametrizacao.empresas.index')->with('success', 'Empresa criada com sucesso.');
    }

    public function show(Empresa $empresa)
    {
        return view('parametrizacao.empresas.show', compact('empresa'));
    }

    public function edit(Empresa $empresa)
    {
        return view('parametrizacao.empresas.edit', compact('empresa'));
    }

    public function update(Request $request, Empresa $empresa)
    {
        $request->validate([
            'nome' => 'required',
            'sigla' => 'nullable',
            'nuit' => 'required|unique:empresas,nuit,'.$empresa->id,
            'email' => 'required|unique:empresas,email,'.$empresa->id,
            'contacto1' => 'required',
            'contacto2' => 'nullable',
            'localizacao' => 'nullable',
        ]);

        $empresa->update($request->all());

        return redirect()->route('parametrizacao.empresas.index')->with('success', 'Empresa atualizada com sucesso.');
    }

    public function destroy(Empresa $empresa)
    {
        $empresa->delete();

        return redirect()->route('parametrizacao.empresas.index')->with('success', 'Empresa deletada com sucesso.');
    }
}
