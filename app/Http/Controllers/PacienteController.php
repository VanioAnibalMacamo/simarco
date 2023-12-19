<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paciente;

class PacienteController extends Controller
{
    public function index()
    {
        $pacientes = Paciente::paginate(8);
        return view('paciente.index',['pacientes' => $pacientes]);
    }
    
    public function create()
    {
        return view('paciente.create'); 
    }

    public function savePaciente(Request $request)
    {
        // Validação dos dados do formulário
        $request->validate([
            'nome' => 'required|string|max:255',
            'data_nascimento' => 'required|date',
            'genero' => 'required|in:masculino,feminino,outro',
            'numero_identificacao' => 'required|string|max:255',
            'endereco' => 'required|string|max:255',
            'telefone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
        ]);

        // Cria um novo paciente com base nos dados do formulário
        Paciente::create([
            'nome' => $request->input('nome'),
            'data_nascimento' => $request->input('data_nascimento'),
            'genero' => $request->input('genero'),
            'numero_identificacao' => $request->input('numero_identificacao'),
            'endereco' => $request->input('endereco'),
            'telefone' => $request->input('telefone'),
            'email' => $request->input('email'),
        ]);

        // Redireciona para a página desejada após salvar o paciente
        return redirect('/pacienteIndex')->with('success', 'Paciente salvo com sucesso!');
    }

    public function delete($id)
    {
        $paciente = Paciente::findOrFail($id);
        $paciente->delete();
    
        return redirect('/pacienteIndex')->with('successDelete', 'Paciente excluído com sucesso!');
    }
    
    public function show($id)
    {
        $paciente = Paciente::findOrFail($id);

        return view('paciente.view', ['paciente' => $paciente]);
    }
    
    public function edit($id)
    {
        $paciente = Paciente::findOrFail($id);

        return view('paciente.edit', ['paciente' => $paciente]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'data_nascimento' => 'required|date',
            'genero' => 'required|in:masculino,feminino,outro',
            'numero_identificacao' => 'required|string|max:255',
            'endereco' => 'required|string|max:255',
            'telefone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
        ]);

        $paciente = Paciente::findOrFail($id);
        $paciente->update($request->all());

        return redirect('/pacienteIndex')->with('success', 'Paciente atualizado com sucesso!');
    }


}
