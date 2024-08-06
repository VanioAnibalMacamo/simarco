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
        // Encontrar a disponibilidade pelo ID
        $disponibilidade = Disponibilidade::findOrFail($id);

        // Encontrar o médico associado a esta disponibilidade
        $medico = Medico::findOrFail($disponibilidade->medico_id);

        // Retornar a view com as variáveis necessárias
        return view('parametrizacao.medico.disponibilidade.edit', compact('disponibilidade', 'medico'));
    }


    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'dia_semana' => 'required',
        ]);

        // Encontre a disponibilidade pelo ID
        $disponibilidade = Disponibilidade::findOrFail($id);

        // Atualize a disponibilidade
        $disponibilidade->update($request->only('dia_semana'));

        // Encontre o médico associado à disponibilidade
        $medicoId = $disponibilidade->medico_id;

        // Redirecione para a rota `visualizar_disponibilidades` com o ID do médico
        return redirect()->route('visualizar_disponibilidades', ['id' => $medicoId])
            ->with('success', 'Disponibilidade atualizada com sucesso.');
    }


    public function destroy($id): RedirectResponse
    {
        // Encontrar a disponibilidade que será excluída
        $disponibilidade = Disponibilidade::findOrFail($id);

        // Obter o ID do médico associado à disponibilidade
        $medicoId = $disponibilidade->medico_id;

        // Excluir a disponibilidade
        $disponibilidade->delete();

        // Redirecionar para a rota `visualizar_disponibilidades` com o ID do médico
        return redirect()->route('visualizar_disponibilidades', ['id' => $medicoId])
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
