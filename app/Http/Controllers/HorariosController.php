<?php

namespace App\Http\Controllers;

use App\Enums\FormaPagamentoEnum;
use App\Models\Disponibilidade;
use App\Models\Agendamento;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class HorariosController extends Controller
{
    public function index(Request $request, $disponibilidadeId)
    {
        $formaPagamento = $request->input('formaPagamento');

        $pacienteId = $request->input('paciente_id');
        if (!$pacienteId) {
            return redirect()->back()->with('error', 'Paciente não selecionado.');
        }

        // Buscar a disponibilidade com o médico e sua especialidade
        $disponibilidade = Disponibilidade::with('medico.especialidade')->findOrFail($disponibilidadeId);

        $dia = $request->input('dia');
        if (!$dia) {
            return redirect()->back()->with('error', 'Dia não especificado.');
        }

        // Dentro do método index:
$horarios = [];
$horaInicio = Carbon::createFromTimeString('08:00:00');
$horaFim = Carbon::createFromTimeString('15:30:00');

$agendamentos = Agendamento::where('dia', Carbon::createFromFormat('d/m/Y', $dia)->format('Y-m-d'))
    ->whereHas('disponibilidades', function ($query) use ($disponibilidadeId) {
        $query->where('disponibilidade_id', $disponibilidadeId);
    })
    ->pluck('horario')
    ->map(function ($horario) {
        return Carbon::createFromFormat('H:i:s', $horario)->format('H:i');
    })
    ->toArray();

while ($horaInicio < $horaFim) {
    $horaFimIntervalo = $horaInicio->copy()->addMinutes(30)->format('H:i');
    $inicioIntervalo = $horaInicio->format('H:i');
    $horaInicio = $horaInicio->copy()->addMinutes(31);
    if ($horaInicio > $horaFim) {
        break;
    }

    $horarios[] = [
        'start' => $inicioIntervalo,
        'end' => $horaFimIntervalo,
        'isBooked' => in_array($inicioIntervalo, $agendamentos), // Verifica se o horário está agendado
    ];
}

return view('horarios.index', [
    'disponibilidade' => $disponibilidade,
    'pacienteId' => $pacienteId,
    'horarios' => $horarios,
    'dia' => $dia,
    'formaPagamento' => $formaPagamento
]);

    }

    public function store(Request $request)
    {
        $validPaymentOptions = FormaPagamentoEnum::getValues();
      
        Log::info('Dados recebidos para agendamento: ', $request->all());

        $request->validate([
            'disponibilidade_id' => 'required|exists:disponibilidades,id',
            'paciente_id' => 'required|exists:pacientes,id',
            'dia' => 'required|date_format:d/m/Y',
            'horario' => 'required|date_format:H:i',
            'forma_pagamento' => 'required|in:' . implode(',', $validPaymentOptions), // Validando forma de pagamento
        ]);

        try {
            $data = Carbon::createFromFormat('d/m/Y', $request->dia)->format('Y-m-d');
            $horario = Carbon::createFromFormat('H:i', $request->horario)->format('H:i:s');

            Log::info('Data convertida: ' . $data);
            Log::info('Horário convertido: ' . $horario);

            $agendamento = Agendamento::create([
                'paciente_id' => $request->input('paciente_id'),
                'dia' => $data,
                'horario' => $horario,
                'forma_pagamento' => $request->input('forma_pagamento'), // Salvando forma de pagamento
            
            ]);

            Log::info('Agendamento criado com sucesso.', ['agendamento_id' => $agendamento->id, 'horario' => $agendamento->horario]);

            Log::info('Tentando associar disponibilidade ao agendamento.', [
                'agendamento_id' => $agendamento->id,
                'disponibilidade_id' => $request->input('disponibilidade_id'),
            ]);

            try {
                $disponibilidadeId = $request->input('disponibilidade_id');
                $agendamento->disponibilidades()->attach($disponibilidadeId);

                Log::info('Associação com a tabela pivot realizada com sucesso.', [
                    'agendamento_id' => $agendamento->id,
                    'disponibilidade_id' => $disponibilidadeId,
                ]);
            } catch (\Exception $e) {
                Log::error('Erro ao associar disponibilidade ao agendamento: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Erro ao associar disponibilidade ao agendamento.');
            }

            return redirect()->back()->with('success', 'Agendamento criado com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao criar agendamento: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erro ao criar o agendamento.');
        }
    }
}
