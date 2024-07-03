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
        // Exibir uma lista das disponibilidades
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
        $medicos = Medico::All();
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
            'hora_inicio' => 'required',
            'hora_fim' => 'required',
            'estado' => 'required',
            'medico_id_hidden' => 'required',
        ]);

        try {
            // Verificar se já existe uma disponibilidade para o médico no mesmo dia e intervalo de horário
            $existente = Disponibilidade::where('medico_id', $request->medico_id_hidden)
                ->where('dia_semana', $request->dia_semana)
                ->where('estado', 'Activa')
                ->where(function ($query) use ($request) {
                    $query->where(function ($query) use ($request) {
                        $query->where('hora_inicio', '>=', $request->hora_inicio)
                            ->where('hora_inicio', '<', $request->hora_fim);
                    })
                    ->orWhere(function ($query) use ($request) {
                        $query->where('hora_fim', '>', $request->hora_inicio)
                            ->where('hora_fim', '<=', $request->hora_fim);
                    })
                    ->orWhere(function ($query) use ($request) {
                        $query->where('hora_inicio', '<=', $request->hora_inicio)
                            ->where('hora_fim', '>=', $request->hora_fim);
                    });
                })
                ->exists();

            if ($existente) {
                return redirect()->back()
                    ->with('error', 'Já existe uma disponibilidade cadastrada para este médico neste intervalo de horário e dia da semana.');
            }

            // Criar uma nova disponibilidade
            Disponibilidade::create([
                'dia_semana' => $request->dia_semana,
                'hora_inicio' => $request->hora_inicio,
                'hora_fim' => $request->hora_fim,
                'estado' => $request->estado,
                'medico_id' => $request->medico_id_hidden,
            ]);

            // Após a validação, se não houver erros, redirecione com uma mensagem de sucesso
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
        // Encontrar a disponibilidade pelo ID e exibir o formulário de edição
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
        // Validar os dados do formulário
        $request->validate([
            'dia_semana' => 'required',
            'hora_inicio' => 'required',
            'hora_fim' => 'required',
            'estado' => 'required',
            'medico_id' => 'required',
        ]);

        // Atualizar a disponibilidade
        $disponibilidade = Disponibilidade::findOrFail($id);
        $disponibilidade->update($request->all());

        return redirect()->route('disponibilidadeIndex')
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
        // Excluir a disponibilidade
        $disponibilidade = Disponibilidade::findOrFail($id);
        $disponibilidade->delete();

        return redirect()->route('disponibilidadeIndex')
            ->with('successDelete', 'Disponibilidade excluída com sucesso.');
    }


    public function visualizarDisponibilidades($id)
    {
        $medico = Medico::findOrFail($id);
        $disponibilidades = $medico->disponibilidades()
                                    ->orderBy('dia_semana')
                                    ->orderBy('hora_inicio')
                                    ->get();

        return view('parametrizacao.medico.disponibilidade.view', compact('medico', 'disponibilidades'));
    }

}
