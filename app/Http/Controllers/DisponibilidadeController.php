<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Disponibilidade;
use App\Models\Medico;
use Illuminate\Http\RedirectResponse;

class DisponibilidadeController extends Controller
{
    public function index()
    {
        $disponibilidades = Disponibilidade::paginate(8);
        $medicos = Medico::paginate(8);
        return view('parametrizacao.medico.disponibilidade.index', compact('disponibilidades', 'medicos'));
    }

    public function create($medico_id)
    {
        $medico = Medico::find($medico_id);
        return view('parametrizacao.medico.disponibilidade.create', compact('medico_id', 'medico'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'dia_semana' => 'required',
            'medico_id_hidden' => 'required',
        ]);

        try {
            $existente = Disponibilidade::where('medico_id', $request->medico_id_hidden)
                ->where('dia_semana', $request->dia_semana)
                ->exists();

            if ($existente) {
                return redirect()->route('disponibilidade.create', ['medico_id' => $request->medico_id_hidden])
                    ->with('error', 'Já existe uma disponibilidade cadastrada para este médico neste dia da semana.');
            }

            Disponibilidade::create([
                'medico_id' => $request->medico_id_hidden,
                'dia_semana' => $request->dia_semana,
            ]);

            return redirect()->route('visualizar_disponibilidades', ['id' => $request->medico_id_hidden])
                ->with('success', 'Disponibilidade criada com sucesso.');
        } catch (\Exception $e) {
            return redirect()->route('disponibilidade.create', ['medico_id' => $request->medico_id_hidden])
                ->with('error', 'Ocorreu um erro ao criar a disponibilidade: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $disponibilidade = Disponibilidade::findOrFail($id);
        return view('parametrizacao.medico.disponibilidade.edit', compact('disponibilidade'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'dia_semana' => 'required',
        ]);

        $disponibilidade = Disponibilidade::findOrFail($id);
        $disponibilidade->update($request->only('dia_semana'));

        return redirect()->route('disponibilidade.index')
            ->with('success', 'Disponibilidade atualizada com sucesso.');
    }

    public function destroy($id): RedirectResponse
    {
        $disponibilidade = Disponibilidade::findOrFail($id);
        $disponibilidade->delete();

        return redirect()->route('disponibilidade.index')
            ->with('successDelete', 'Disponibilidade excluída com sucesso.');
    }

    public function visualizarDisponibilidades($id)
    {
        $medico = Medico::findOrFail($id);
        $disponibilidades = $medico->disponibilidades()
            ->orderBy('dia_semana')
            ->get();

        return view('parametrizacao.medico.disponibilidade.view', compact('medico', 'disponibilidades'));
    }
}
