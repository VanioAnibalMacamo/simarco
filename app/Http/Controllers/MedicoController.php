<?php

namespace App\Http\Controllers;

use App\Enums\DisponibilidadeEnum;
use App\Enums\GeneroEnum;
use App\Models\Especialidade;
use App\Models\Medico;
use Illuminate\Http\Request;



class MedicoController extends Controller
{
    public function index()
    {
        $medicos = Medico::paginate(8);
        return view('medico.index', ['medicos' => $medicos]);
    }

    public function create()
    {
        $especialidades = Especialidade::all();
        $disponibilidades = DisponibilidadeEnum::getConstants();
        $generos = GeneroEnum::getConstants();

        return view('medico.create', compact('especialidades', 'disponibilidades', 'generos'));
    }

    public function saveMedico(Request $request)
    {

        $request->validate([
            'nome' => 'required|string|max:255',
            'especialidade_id' => 'required|exists:especialidades,id',
            'numero_identificacao' => 'required|string|max:50',
            'disponibilidade' => 'required|string|max:255',
            'genero' => 'required|in:' . implode(',', GeneroEnum::getConstants()),
        ]);

        Medico::create([
            'nome' => $request->input('nome'),
            'especialidade_id' => $request->input('especialidade_id'),
            'numero_identificacao' => $request->input('numero_identificacao'),
            'disponibilidade' => $request->input('disponibilidade'),
            'genero' => $request->input('genero'),
        ]);

        return redirect('/medicoIndex')->with('success', 'Médico salvo com sucesso!');
    }

    public function delete($id)
    {
        $medico = Medico::findOrFail($id);
        $medico->delete();

        return redirect('/medicoIndex')->with('successDelete', 'Médico excluído com sucesso!');
    }

    public function show($id)
    {
        $medico = Medico::findOrFail($id);

        return view('medico.view', ['medico' => $medico]);
    }

    public function edit($id)
    {
        $medico = Medico::findOrFail($id);
        $especialidades = Especialidade::all();
        $disponibilidades = DisponibilidadeEnum::getConstants();
        $generos = GeneroEnum::getConstants();

        return view('medico.edit', compact('medico', 'especialidades', 'disponibilidades', 'generos'));
    }




    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'especialidade_id' => 'required|exists:especialidades,id',
            'numero_identificacao' => 'required|string|max:255',
            'disponibilidade' => 'required|string|max:255',
            'genero' => 'required|in:' . implode(',', GeneroEnum::getConstants()),
        ]);

        $medico = Medico::findOrFail($id);
        $medico->update($request->all());

        return redirect('/medicoIndex')->with('success', 'Médico atualizado com sucesso!');
    }


    public function especialidades()
    {
        $especialidades = Especialidade::all(); // Obtém todas as especialidades do banco de dados

        return view('medico.especialidades', ['especialidades' => $especialidades]);
    }

    public function medicos($idEspecialidade)
    {
        // Lógica para obter os médicos da especialidade com o ID fornecido
        $medicos = Medico::where('especialidade_id', $idEspecialidade)->get();

        return view('medico.medicos', ['medicos' => $medicos]);
    }

    public function showDisponibilidade($id)
    {
        $medico = Medico::findOrFail($id);
        // Por enquanto, apenas simule as disponibilidades
        $disponibilidades = [
            (object)[
                'data' => '01/01/2024',
                'horario' => '10:00 - 12:00'
            ],
            (object)[
                'data' => '02/01/2024',
                'horario' => '14:00 - 16:00'
            ]
        ];
        return view('medico.disponibilidades', compact('medico', 'disponibilidades'));
    }
}
