<?php

namespace App\Http\Controllers;

use App\Enums\DisponibilidadeEnum;
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

        return view('medico.create', compact('especialidades', 'disponibilidades'));
    }





    // MedicoController.php
    public function saveMedico(Request $request)
    {

        $request->validate([
            'nome' => 'required|string|max:255',
            'especialidade_id' => 'required|exists:especialidades,id',
            'numero_identificacao' => 'required|string|max:50',
            'disponibilidade' => 'required|string|max:255',
        ]);

        Medico::create([
            'nome' => $request->input('nome'),
            'especialidade_id' => $request->input('especialidade_id'),
            'numero_identificacao' => $request->input('numero_identificacao'),
            'disponibilidade' => $request->input('disponibilidade'),
        ]);

        return redirect('/medicoIndex')->with('success', 'Médico salvo com sucesso!');
    }

    public function delete($id)
    {
        $medico = Medico::findOrFail($id);
        $medico->delete();

        return redirect('/medicoIndex')->with('successDelete', 'Paciente excluído com sucesso!');
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

        return view('medico.edit', compact('medico', 'especialidades', 'disponibilidades'));
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'especialidade_id' => 'required|exists:especialidades,id',
            'numero_identificacao' => 'required|string|max:255',
            'disponibilidade' => 'required|string|max:255',
        ]);

        $medico = Medico::findOrFail($id);
        $medico->update($request->all());

        return redirect('/medicoIndex')->with('success', 'Paciente atualizado com sucesso!');
    }
}
