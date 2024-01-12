<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FormaFarmaceutica;

class FormaFarmaceuticaController extends Controller
{
    public function index()
    {
        $formasFarmaceuticas = FormaFarmaceutica::paginate(8);
        return view('parametrizacao.medicamentos.forma_farmaceutica.index', ['formasFarmaceuticas' => $formasFarmaceuticas]);
    }

    public function create()
    {
        return view('parametrizacao.medicamentos.forma_farmaceutica.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'descricao' => 'required|string|max:255',
        ]);

        FormaFarmaceutica::create([
            'descricao' => $request->descricao,
        ]);

        return redirect()->route('forma_farmaceutica.index')->with('success', 'Forma Farmacêutica cadastrada com sucesso!');
    }

    public function edit($id)
    {
        $formaFarmaceutica = FormaFarmaceutica::findOrFail($id);
        return view('parametrizacao.medicamentos.forma_farmaceutica.edit', compact('formaFarmaceutica'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'descricao' => 'required|string|max:255',
        ]);

        $formaFarmaceutica = FormaFarmaceutica::findOrFail($id);

        $formaFarmaceutica->update([
            'descricao' => $request->descricao,
        ]);

        return redirect()->route('forma_farmaceutica.index')->with('success', 'Forma Farmacêutica atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $formaFarmaceutica = FormaFarmaceutica::findOrFail($id);

        if ($formaFarmaceutica) {
            $formaFarmaceutica->delete();
            return redirect()->route('forma_farmaceutica.index')->with('successDelete', 'Forma Farmacêutica excluída com sucesso!');
        }

        return redirect()->route('forma_farmaceutica.index')->with('error', 'Não foi possível encontrar a Forma Farmacêutica para exclusão.');
    }
}
