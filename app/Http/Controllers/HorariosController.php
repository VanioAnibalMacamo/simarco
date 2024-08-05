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
        \Log::info('Dados recebidos para agendamento: ', $request->all());

        // Validar e armazenar o agendamento
        $request->validate([
            'disponibilidade_id' => 'required|exists:disponibilidades,id',
            'paciente_id' => 'required|exists:pacientes,id',
            'dia' => 'required|date_format:d/m/Y', // Ajustado para o formato recebido
            'horario' => 'required|date_format:H:i', // Validação do formato da hora
        ]);

        try {
            // Converte a data para o formato de banco de dados
            $data = Carbon::createFromFormat('d/m/Y', $request->dia)->format('Y-m-d');

            // Converte o horário para o formato de banco de dados (incluindo segundos)
            $horario = Carbon::createFromFormat('H:i', $request->horario)->format('H:i:s');

            \Log::info('Data convertida: ' . $data);
            \Log::info('Horário convertido: ' . $horario);

            // Crie o agendamento
            $agendamento = Agendamento::create([
                'disponibilidade_id' => $request->input('disponibilidade_id'),
                'paciente_id' => $request->input('paciente_id'),
                'dia' => $data,
                'horario' => $horario,
            ]);

            \Log::info('Agendamento criado com sucesso.', ['agendamento_id' => $agendamento->id, 'horario' => $agendamento->horario]);
            return redirect()->back()->with('success', 'Agendamento criado com sucesso!');
        } catch (\Exception $e) {
            \Log::error('Erro ao criar agendamento: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erro ao criar o agendamento.');
        }
    }
}
