<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agendamento;
use App\Models\Disponibilidade;
use App\Models\Paciente;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class AgendamentosController extends Controller
{

    public function agendamentosMarcados()
    {

        return view('agendamentos.marcados');
    }

    public function store(Request $request)
    {
        \Log::info('Dados recebidos para agendamento: ', $request->all());

        // Verifica se o paciente está selecionado
        if (empty($request->paciente_id)) {
            return redirect()->back()->with('error', 'Por favor, selecione um paciente.');
        }

        // Validação dos campos
        $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'dia' => 'required|date_format:d/m/Y', // Ajustado para o formato recebido
            'horario' => 'required|date_format:H:i', // Validação do formato da hora
            'disponibilidade_id' => 'required|exists:disponibilidades,id' // Validação da disponibilidade
        ]);

        try {
            // Converte a data para o formato de banco de dados
            $data = Carbon::createFromFormat('d/m/Y', $request->dia)->format('Y-m-d');

            // Converte o horário para o formato de banco de dados (incluindo segundos)
            $horario = Carbon::createFromFormat('H:i', $request->horario)->format('H:i:s');

            \Log::info('Data convertida: ' . $data);
            \Log::info('Horário convertido: ' . $horario);

            // Cria o agendamento
            $agendamento = Agendamento::create([
                'dia' => $data,
                'paciente_id' => $request->paciente_id,
                'horario' => $horario
            ]);

            \Log::info('Agendamento criado com sucesso.', ['agendamento_id' => $agendamento->id, 'horario' => $agendamento->horario]);

            // Associa a disponibilidade ao agendamento
            $disponibilidadeId = $request->input('disponibilidade_id');
            if ($disponibilidadeId) {
                $agendamento->disponibilidades()->attach($disponibilidadeId);
                \Log::info('Associação com a tabela pivot realizada com sucesso.', [
                    'agendamento_id' => $agendamento->id,
                    'disponibilidade_id' => $disponibilidadeId,
                ]);
            } else {
                \Log::warning('Nenhuma disponibilidade selecionada para associar ao agendamento.');
            }

            return redirect()->back()->with('success', 'Agendamento criado com sucesso!');
        } catch (\Exception $e) {
            \Log::error('Erro ao criar agendamento: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erro ao criar o agendamento.');
        }
    }
}