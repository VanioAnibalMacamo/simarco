<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agendamento;
use App\Models\Disponibilidade;
use App\Models\Paciente;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB; // Importe corretamente a Facade DB

class AgendamentosController extends Controller
{
    public function store(Request $request)
    {
        // Verifica se o paciente está selecionado
        if (empty($request->paciente_id)) {
            return redirect()->back()->with('error', 'Por favor, selecione um paciente.');
        }

        // Validação dos campos
        $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'disponibilidade_id' => 'required|exists:disponibilidades,id',
            'dia' => 'required|date',
        ]);

        // Crie o agendamento
        $agendamento = Agendamento::create([
            'dia' => $request->dia,
            'paciente_id' => $request->paciente_id,
        ]);

        // Associe a disponibilidade ao agendamento
        $agendamento->disponibilidades()->attach($request->disponibilidade_id);

        return redirect()->back()->with('success', 'Agendamento criado com sucesso!');
    }
}
