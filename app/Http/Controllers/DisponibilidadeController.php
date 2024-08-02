<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Disponibilidade;
use App\Models\Medico;

class DisponibilidadeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $disponibilidades = Disponibilidade::paginate(8);
        $medicos = Medico::paginate(8);
        return view('parametrizacao.medico.disponibilidade.index', compact('disponibilidades','medicos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($medico_id)
    {
        $medico = Medico::find($medico_id);
        return view('parametrizacao.medico.disponibilidade.create', compact('medico_id', 'medico'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
                return redirect()->back()
                    ->with('error', 'Já existe uma disponibilidade cadastrada para este médico neste dia da semana.');
            }

            Disponibilidade::create([
                'medico_id' => $request->medico_id_hidden,
                'dia_semana' => $request->dia_semana,
            ]);

            return redirect()->route('visualizar_disponibilidades', ['id' => $request->medico_id_hidden])
                ->with('success', 'Disponibilidade criada com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Ocorreu um erro ao criar a disponibilidade: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Disponibilidade  $disponibilidade
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $disponibilidade = Disponibilidade::findOrFail($id);
        return view('parametrizacao.medico.disponibilidade.edit', compact('disponibilidade'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Disponibilidade  $disponibilidade
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'dia_semana' => 'required',
        ]);

        $disponibilidade = Disponibilidade::findOrFail($id);
        $disponibilidade->update($request->only('dia_semana'));

        return redirect()->route('disponibilidade.index')
            ->with('success', 'Disponibilidade atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Disponibilidade  $disponibilidade
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
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