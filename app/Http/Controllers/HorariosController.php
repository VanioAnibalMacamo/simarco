<?php

namespace App\Http\Controllers;

use App\Models\Disponibilidade;
use App\Models\Paciente;
use App\Models\Agendamento;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HorariosController extends Controller
{
    public function index(Request $request, $disponibilidadeId)
{
    // Verificar se o paciente foi selecionado
    $pacienteId = $request->input('paciente_id');
    if (!$pacienteId) {
        return redirect()->back()->with('error', 'Paciente não selecionado.');
    }

    // Obter a disponibilidade selecionada
    $disponibilidade = Disponibilidade::findOrFail($disponibilidadeId);

    // Obter o parâmetro 'dia'
    $dia = $request->input('dia');
    if (!$dia) {
        return redirect()->back()->with('error', 'Dia não especificado.');
    }

    // Gerar os horários disponíveis das 08:00 às 15:30, com intervalos de 30 minutos
    $horarios = [];
    $horaInicio = Carbon::createFromTimeString('08:00:00');
    $horaFim = Carbon::createFromTimeString('15:30:00');

    while ($horaInicio < $horaFim) {
        $horaFimIntervalo = $horaInicio->copy()->addMinutes(30)->format('H:i');
        $inicioIntervalo = $horaInicio->format('H:i');
        
        // Ajusta o horário final para começar 1 minuto após o horário de início do intervalo
        $horaInicio = $horaInicio->copy()->addMinutes(31); 

        if ($horaInicio > $horaFim) {
            break; // Para se ultrapassar o horário limite
        }
        
        $horarios[] = [
            'start' => $inicioIntervalo,
            'end' => $horaFimIntervalo,
        ];
    }

    return view('horarios.index', compact('disponibilidade', 'pacienteId', 'horarios', 'dia'));
}

    public function store(Request $request)
    {
        // Validar e armazenar o agendamento
        $request->validate([
            'disponibilidade_id' => 'required|exists:disponibilidades,id',
            'paciente_id' => 'required|exists:pacientes,id',
            'hora' => 'required',
        ]);

        // Criar o agendamento
        Agendamento::create([
            'disponibilidade_id' => $request->input('disponibilidade_id'),
            'paciente_id' => $request->input('paciente_id'),
            'hora' => $request->input('hora'),
        ]);

        return redirect()->route('horarios.index', ['disponibilidade' => $request->input('disponibilidade_id')])
                         ->with('success', 'Agendamento criado com sucesso.');
    }
}
