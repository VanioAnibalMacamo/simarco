<?php

namespace App\Http\Controllers;

use App\Mail\PrescricaoMailable;
use Illuminate\Http\Request;
use App\Models\Prescricao;
use App\Models\Consulta;
use App\Models\Medicamento;
use App\Models\Diagnostico;
use Mail;
use Storage;
use PDF;

class PrescricaoController extends Controller
{
    public function index()
    {
        $prescricoes = Prescricao::paginate(8);
        return view('prescricao.index', compact('prescricoes'));
    }

    private function getConsultaHora($pacienteId)
    {
        // Buscar a última consulta associada ao paciente
        $consultas = Consulta::where('paciente_id', $pacienteId)
            ->orderBy('data_consulta', 'desc')
            ->orderBy('hora_inicio', 'desc')
            ->first();

        if ($consultas) {
            return $consultas->hora_inicio;
        }

        return null;
    }
    public function create($consultaId)
    {
        // Buscar a consulta específica pelo ID
        $consultas = Consulta::find($consultaId);
        $medicamentos = Medicamento::all();


        // Se há um diagnóstico associado à consulta, você pode recuperá-lo
        $diagnostico = Diagnostico::where('consulta_id', $consultaId)->first();
// Obter a hora da consulta associada ao paciente
$horaConsulta = $this->getConsultaHora($consultas->paciente_id);

        return view('prescricao.create', compact('consultas', 'medicamentos', 'diagnostico', 'horaConsulta'));
    }

    public function savePrescricao(Request $request)
    {
        // Recupere os nomes dos medicamentos selecionados
        $medicamentoIds = $request->input('medicamentos');
        $medicamentos = Medicamento::whereIn('id', $medicamentoIds)->pluck('nome_medicamento', 'id');

        $validator = \Validator::make($request->all(), [
            'data_prescricao' => 'required|date',
           
            'consulta_id' => 'required|exists:consultas,id',
            'medicamentos' => 'required|array',
            'medicamentos.*' => 'exists:medicamentos,id',
            'dosagens' => ['array', function ($attribute, $value, $fail) use ($medicamentos) {
                foreach ($medicamentos as $medicamentoId => $medicamentoNome) {
                    if (!isset($value[$medicamentoId])) {
                        $fail("A dosagem para o medicamento '{$medicamentoNome}' é obrigatória.");
                    }
                }
            }],
            'instrucoes' => ['array', function ($attribute, $value, $fail) use ($medicamentos) {
                foreach ($medicamentos as $medicamentoId => $medicamentoNome) {
                    if (!isset($value[$medicamentoId])) {
                        $fail("A instrução para o medicamento '{$medicamentoNome}' é obrigatória.");
                    }
                }
            }],
            'dosagens.*' => 'nullable|string',
            'instrucoes.*' => 'nullable|string',
        ]);

        // Verifica se a validação falhou
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if (Prescricao::where('consulta_id', $request->input('consulta_id'))->exists()) {
            return redirect()->back()->with('error', 'Esta consulta já possui uma prescrição associada.')->withInput();
        }

        $prescricao = Prescricao::create([
            'data_prescricao' => $request->input('data_prescricao'),
          
            'consulta_id' => $request->input('consulta_id'),
        ]);

        $medicamentosSelecionados = $request->input('medicamentos');
        $dosagens = $request->input('dosagens');
        $instrucoes = $request->input('instrucoes');

        foreach ($medicamentosSelecionados as $medicamentoId) {
            if (isset($dosagens[$medicamentoId]) && isset($instrucoes[$medicamentoId])) {
                $prescricao->medicamentos()->attach($medicamentoId, [
                    'dosagem' => $dosagens[$medicamentoId],
                    'instrucoes' => $instrucoes[$medicamentoId],
                ]);
            }
        }
  // Gere e envie o PDF
  $this->generateAndSendPdf($prescricao);

  // Redireciona com a mensagem de sucesso
  return redirect('/agendamentosMarcados')->with('success', 'Prescrição médica salva com sucesso! A receita foi enviada para o e-mail do paciente.');
    }


    private function generateAndSendPdf($prescricao)
{
    // Recupera a consulta associada à prescrição
    $consulta = $prescricao->consulta;
    $paciente = $consulta->paciente;
    $medicamentos = $prescricao->medicamentos;

    // Obter informações adicionais
    $medico = $consulta->medico; // Recupera o médico da consulta

    // Gere o PDF usando a view específica e os dados necessários
    $pdf = PDF::loadView('prescricao.receita_pdf.pdf', [
        'prescricao' => $prescricao,
        'paciente' => $paciente,
        'medicamentos' => $medicamentos,
        'consulta' => $consulta,
        'medico' => $medico, // Adiciona o médico aos dados passados para a view
    ]);

    // Crie o nome do arquivo PDF
    $dataPrescricao = \Carbon\Carbon::parse($prescricao->data_prescricao)->format('d-m-Y');
    $nomePaciente = preg_replace('/[^a-zA-Z0-9]/', '_', $paciente->nome); // Substitui caracteres não alfanuméricos por _
    $nomeArquivo = "Prescricao_Consulta_{$dataPrescricao}_{$nomePaciente}.pdf";

    // Defina o caminho da pasta onde os PDFs serão salvos
    $directoryPath = 'public/prescricoes';

    // Crie a pasta caso ela não exista
    if (!Storage::exists($directoryPath)) {
        Storage::makeDirectory($directoryPath);
    }

    // Caminho completo para salvar o PDF
    $pdfPath = storage_path("app/{$directoryPath}/{$nomeArquivo}");

    // Salve o PDF no armazenamento
    $pdf->save($pdfPath);

    // Envie o PDF por e-mail
    Mail::to($paciente->email)->send(new PrescricaoMailable($prescricao, $paciente, $consulta, $pdfPath));

    // Opcional: Remover o arquivo PDF do armazenamento após o envio, se necessário
    if (file_exists($pdfPath)) {
        unlink($pdfPath);
    }
}

    public function edit($id)
    {

        $prescricao = Prescricao::with('consulta')->findOrFail($id);
        $consultas = Consulta::all();
        $medicamentos = Medicamento::all();
        return view('prescricao.edit', compact('prescricao', 'consultas', 'medicamentos'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'data_prescricao' => 'required|date',
           
            'medicamentos' => 'required|array',
            'dosagens' => ['array', function ($attribute, $value, $fail) use ($request) {
                foreach ($request->input('medicamentos') as $medicamentoId) {
                    if (!isset($value[$medicamentoId])) {
                        $fail("A dosagem para o medicamento com ID {$medicamentoId} é obrigatória.");
                    }
                }
            }],
            'instrucoes' => ['array', function ($attribute, $value, $fail) use ($request) {
                foreach ($request->input('medicamentos') as $medicamentoId) {
                    if (!isset($value[$medicamentoId])) {
                        $fail("A instrução para o medicamento com ID {$medicamentoId} é obrigatória.");
                    }
                }
            }],
            'dosagens.*' => 'nullable|string',
            'instrucoes.*' => 'nullable|string',
        ]);

        $prescricao = Prescricao::find($id);

        if (!$prescricao) {
            return redirect('/prescricaoIndex')->with('error', 'Prescrição não encontrada.');
        }

        $prescricao->update([
            'data_prescricao' => $request->input('data_prescricao'),
           
        ]);

        // Sincronize os medicamentos e suas informações na tabela pivot
        $medicamentosSelecionados = $request->input('medicamentos');
        $dosagens = $request->input('dosagens');
        $instrucoes = $request->input('instrucoes');

        // Sincronize medicamentos e limpe a tabela pivot
        $prescricao->medicamentos()->sync([]);

        foreach ($medicamentosSelecionados as $medicamentoId) {
            $prescricao->medicamentos()->attach($medicamentoId, [
                'dosagem' => $dosagens[$medicamentoId] ?? null,
                'instrucoes' => $instrucoes[$medicamentoId] ?? null,
            ]);
        }

        return redirect('/prescricaoIndex')->with('success', 'Prescrição médica atualizada com sucesso.');
    }


   /* public function show($id)
    {
        $prescricao = Prescricao::with('consulta')->findOrFail($id);
        $consulta = $prescricao->consulta;  // Carrega a consulta associada à prescrição


        return view('prescricao.view', compact('prescricao', 'consulta'));
    }*/
    public function show($id)
    {
        $prescricao = Prescricao::with('consulta.medico', 'consulta.paciente')->findOrFail($id);
        $consulta = $prescricao->consulta;  // Carrega a consulta associada à prescrição
        $paciente = $consulta->paciente;    // Carrega o paciente associado à consulta
    
        return view('prescricao.view', compact('prescricao', 'consulta', 'paciente'));
    }
    

    public function delete($id)
    {
        $prescricao = Prescricao::findOrFail($id);
        $prescricao->delete();

        return redirect('/prescricaoIndex')->with('successDelete', 'Prescrição médica excluída com sucesso!');
    }
}
