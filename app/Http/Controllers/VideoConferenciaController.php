<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agendamento;
use App\Models\Medicamento;
use App\Models\Paciente;
use App\Models\Consulta;
use App\Models\Diagnostico;
use App\Models\Prescricao;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class VideoConferenciaController extends Controller
{
    // Função para carregar a view de videoconferência
    public function index()
{
    // Obtém o primeiro agendamento com o paciente
    $agendamento = Agendamento::with('paciente')->first();

    // Buscar medicamentos disponíveis
    $medicamentos = Medicamento::all();

    return view('video_conferencia.videoconferencia', compact('agendamento', 'medicamentos'));
}


    // Função para lidar com a videoconferência e salvar diagnóstico e prescrição
    public function videoconferencia($id)
    {
        $agendamento = Agendamento::with('paciente', 'disponibilidades.medico.especialidade')->findOrFail($id);

        // Buscar medicamentos disponíveis
        $medicamentos = Medicamento::all();

        return view('video_conferencia.videoconferencia', compact('agendamento', 'medicamentos'));
    }

    public function salvarConsulta(Request $request, $agendamentoId)
    {
        // Log dos dados recebidos
        Log::info('Dados recebidos para salvar a consulta:', $request->all());

        // Buscar o agendamento pelo ID
        $agendamento = Agendamento::with('paciente', 'disponibilidades.medico')->findOrFail($agendamentoId);
        Log::info('Agendamento encontrado:', ['agendamento_id' => $agendamentoId, 'data' => $agendamento]);

        // Validação dos dados recebidos
        $validatedData = $request->validate([
            'diagnostico.descricao' => 'required|string',
            'diagnostico.observacoes' => 'nullable|string',
            'prescricao.medicamentos' => 'array',
            'prescricao.dosagens' => 'nullable|array',
            'prescricao.instrucoes' => 'nullable|array',
        ]);
        Log::info('Dados validados:', $validatedData);

        // Inicializa variáveis para os caminhos das fotos
        $foto1Path = null;
        $foto2Path = null;

        // Nome do paciente
        $pacienteNome = preg_replace('/[^A-Za-z0-9\-]/', '_', $agendamento->paciente->nome);

        // Define o diretório de armazenamento com base no nome do paciente e data/hora atual
        $pacienteDiretorio = 'fotos_consultas/' . $pacienteNome . '_' . date('Ymd_His');

        // Processa foto_1
        if ($request->hasFile('foto_1')) {
            $foto1 = $request->file('foto_1');
            $foto1Nome = $pacienteNome . '_foto1.' . $foto1->getClientOriginalExtension();
            $foto1Path = $foto1->storeAs($pacienteDiretorio, $foto1Nome, 'public'); // 'public' usa o storage público
        }

        // Processa foto_2
        if ($request->hasFile('foto_2')) {
            $foto2 = $request->file('foto_2');
            $foto2Nome = $pacienteNome . '_foto2.' . $foto2->getClientOriginalExtension();
            $foto2Path = $foto2->storeAs($pacienteDiretorio, $foto2Nome, 'public'); // 'public' usa o storage público
        }

        // Criar a consulta com dados do agendamento
        $consulta = Consulta::create([
            'data_consulta' => $agendamento->dia, // Usando a data do agendamento
            'hora_inicio' => $agendamento->horario, // Usando a hora do agendamento
            'hora_fim' => now(), // Defina a hora de fim conforme sua lógica
            'medico_id' => $agendamento->disponibilidades[0]->medico_id, // Médico do agendamento
            'paciente_id' => $agendamento->paciente_id,
            'agendamento_id' => $agendamento->id,
            'foto_1' => $foto1Path, // Caminho da foto 1
            'foto_2' => $foto2Path, // Caminho da foto 2
        ]);

        Log::info('Consulta criada:', ['consulta_id' => $consulta->id]);

        // Criar o diagnóstico associado à consulta
        if (isset($validatedData['diagnostico'])) {
            $diagnosticoData = array_merge($validatedData['diagnostico'], [
                'consulta_id' => $consulta->id,
                'data_diagnostico' => now(),
            ]);
            Diagnostico::create($diagnosticoData);
            Log::info('Diagnóstico criado:', $diagnosticoData);
        }

        // Criar a prescrição associada à consulta
        if (isset($validatedData['prescricao'])) {
            $prescricaoData = array_merge($validatedData['prescricao'], [
                'consulta_id' => $consulta->id,
                'data_prescricao' => now(),
            ]);
            $prescricao = Prescricao::create($prescricaoData);
            Log::info('Prescrição criada:', $prescricaoData);

            // Associar os medicamentos à prescrição
            if (isset($validatedData['prescricao']['medicamentos'])) {
                foreach ($validatedData['prescricao']['medicamentos'] as $medicamentoId) {
                    $prescricao->medicamentos()->attach($medicamentoId, [
                        'dosagem' => $validatedData['prescricao']['dosagens'][$medicamentoId] ?? null,
                        'instrucoes' => $validatedData['prescricao']['instrucoes'][$medicamentoId] ?? null,
                    ]);
                    Log::info('Medicamento associado à prescrição:', [
                        'medicamento_id' => $medicamentoId,
                        'dosagem' => $validatedData['prescricao']['dosagens'][$medicamentoId] ?? null,
                        'instrucoes' => $validatedData['prescricao']['instrucoes'][$medicamentoId] ?? null,
                    ]);
                }
            }
        }

        Log::info('Consulta salva com sucesso:', ['consulta_id' => $consulta->id]);
        return redirect()->route('agendamentosMarcados')->with('success', 'Consulta salva com sucesso!');
    }

    /*
    public function salvarConsulta(Request $request, $agendamentoId)
    {
        // Log dos dados recebidos
        Log::info('Dados recebidos para salvar a consulta:', $request->all());

        // Buscar o agendamento pelo ID
        $agendamento = Agendamento::with('paciente', 'disponibilidades.medico')->findOrFail($agendamentoId);
        Log::info('Agendamento encontrado:', ['agendamento_id' => $agendamentoId, 'data' => $agendamento]);

        // Validação dos dados recebidos
        $validatedData = $request->validate([
            'diagnostico.descricao' => 'required|string',
            'diagnostico.observacoes' => 'nullable|string',
            'prescricao.medicamentos' => 'array',
            'prescricao.dosagens' => 'nullable|array',
            'prescricao.instrucoes' => 'nullable|array',
        ]);
        Log::info('Dados validados:', $validatedData);

        // Inicializa variáveis para as fotos
        $foto1Path = null;
        $foto2Path = null;

        //$paciente = Paciente::find($request->input('id_paciente'));
        $pacienteNome = $request->input('paciente_nome');

          // Nome do paciente
          $pacienteNome = preg_replace('/[^A-Za-z0-9\-]/', '_',  $pacienteNome);

          // Define o diretório
          $pacienteDiretorio = 'public/fotos_consultas/' . $pacienteNome . '_' . date('Ymd_His');

          if (!Storage::exists($pacienteDiretorio)) {
              Storage::makeDirectory($pacienteDiretorio);
          }

        // Processa foto_1
        if ($request->hasFile('foto_1')) {
            $foto1 = $request->file('foto_1');
            $foto1Nome = $pacienteNome . '_foto1.' . $foto1->getClientOriginalExtension();
            $foto1Path = $foto1->storeAs($pacienteDiretorio, $foto1Nome);
        }

        // Processa foto_2
        if ($request->hasFile('foto_2')) {
            $foto2 = $request->file('foto_2');
            $foto2Nome = $pacienteNome . '_foto2.' . $foto2->getClientOriginalExtension();
            $foto2Path = $foto2->storeAs($pacienteDiretorio, $foto2Nome);
        }


        // Criar a consulta com dados do agendamento
        $consulta = Consulta::create([
            'data_consulta' => $agendamento->dia, // Usando a data do agendamento
            'hora_inicio' => $agendamento->horario, // Usando a hora do agendamento
            'hora_fim' => now(), // Defina a hora de fim conforme sua lógica
            'medico_id' => $agendamento->disponibilidades[0]->medico_id, // Médico do agendamento
            'paciente_id' => $agendamento->paciente_id,
            'agendamento_id' => $agendamento->id,
            'foto_1' => $foto1Path,
            'foto_2' => $foto2Path,
        ]);

        Log::info('Consulta criada:', ['consulta_id' => $consulta->id]);

        // Criar o diagnóstico associado à consulta
        if (isset($validatedData['diagnostico'])) {
            $diagnosticoData = array_merge($validatedData['diagnostico'], [
                'consulta_id' => $consulta->id,
                'data_diagnostico' => now(), // Aqui você define a data_diagnostico como a data atual
            ]);
            Diagnostico::create($diagnosticoData);
            Log::info('Diagnóstico criado:', $diagnosticoData);
        }

        // Criar a prescrição associada à consulta
        if (isset($validatedData['prescricao'])) {
            $prescricaoData = array_merge($validatedData['prescricao'], [
                'consulta_id' => $consulta->id,
                'data_prescricao' => now(), // Definir a data_prescricao como a data atual
            ]);
            $prescricao = Prescricao::create($prescricaoData);
            Log::info('Prescrição criada:', $prescricaoData);

            // Associar os medicamentos à prescrição
            if (isset($validatedData['prescricao']['medicamentos'])) {
                foreach ($validatedData['prescricao']['medicamentos'] as $medicamentoId) {
                    $prescricao->medicamentos()->attach($medicamentoId, [
                        'dosagem' => $validatedData['prescricao']['dosagens'][$medicamentoId] ?? null,
                        'instrucoes' => $validatedData['prescricao']['instrucoes'][$medicamentoId] ?? null,
                    ]);
                    Log::info('Medicamento associado à prescrição:', [
                        'medicamento_id' => $medicamentoId,
                        'dosagem' => $validatedData['prescricao']['dosagens'][$medicamentoId] ?? null,
                        'instrucoes' => $validatedData['prescricao']['instrucoes'][$medicamentoId] ?? null,
                    ]);
                }
            }
        }

        // Redirecionar ou retornar uma resposta de sucesso
        Log::info('Consulta salva com sucesso:', ['consulta_id' => $consulta->id]);
        return redirect()->route('agendamentosMarcados')->with('success', 'Consulta salva com sucesso!');

    }
*/
}
