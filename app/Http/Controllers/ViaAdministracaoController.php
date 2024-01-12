<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ViaAdministracao;

class ViaAdministracaoController extends Controller
{
    public function index()
    {
        $viaAdministracoes = ViaAdministracao::paginate(8);
        return view('parametrizacao.medicamentos.via_administracao.index', ['viaAdministracoes' => $viaAdministracoes]);
    }

    public function create()
    {
        return view('parametrizacao.medicamentos.via_administracao.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'descricao' => 'required|string|max:255',
        ]);

        ViaAdministracao::create([
            'descricao' => $request->descricao,
        ]);

        return redirect()->route('via_administracaoIndex')->with('success', 'Via de Administração cadastrada com sucesso!');
    }

    public function destroy($id)
    {
        $viaAdministracao = ViaAdministracao::findOrFail($id);

        // Verifica se o registro existe antes de tentar excluir
        if ($viaAdministracao) {
            $viaAdministracao->delete();
            return redirect()->route('via_administracaoIndex')->with('successDelete', 'Via de Administração excluída com sucesso!');
        }

        return redirect()->route('via_administracaoIndex')->with('error', 'Não foi possível encontrar a Via de Administração para exclusão.');
    }

    public function edit($id)
    {
        $viaAdministracao = ViaAdministracao::findOrFail($id);

        return view('parametrizacao.medicamentos.via_administracao.edit', compact('viaAdministracao'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'descricao' => 'required|string|max:255',
        ]);

        $viaAdministracao = ViaAdministracao::findOrFail($id);

        $viaAdministracao->update([
            'descricao' => $request->descricao,
        ]);

        return redirect()->route('via_administracaoIndex')->with('success', 'Via de Administração atualizada com sucesso!');
    }


}
