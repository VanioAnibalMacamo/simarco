<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prescricao;
use App\Models\Consulta;
use App\Models\Medicamento;
use App\Models\Diagnostico;

class PrescricaoController extends Controller
{
    public function index()
    {
        $prescricoes = Prescricao::paginate(8);
        return view('prescricao.index', compact('prescricoes'));
    }


    public function create($consultaId)
    {
        // Buscar a consulta específica pelo ID
        $consultas = Consulta::find($consultaId);
        $medicamentos = Medicamento::all();

        // Se há um diagnóstico associado à consulta, você pode recuperá-lo
        $diagnostico = Diagnostico::where('consulta_id', $consultaId)->first();

        return view('prescricao.create', compact('consultas', 'medicamentos', 'diagnostico'));
    }

    public function savePrescricao(Request $request)
    {
        // Recupere os nomes dos medicamentos selecionados
        $medicamentoIds = $request->input('medicamentos');
        $medicamentos = Medicamento::whereIn('id', $medicamentoIds)->pluck('nome_medicamento', 'id');

        $validator = \Validator::make($request->all(), [
            'data_prescricao' => 'required|date',
            'observacoes' => 'nullable|string',
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
            'observacoes' => $request->input('observacoes'),
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

        return redirect('/agendamentosMarcados')->with('success', 'Prescrição médica salva com sucesso!');
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
            'observacoes' => 'nullable|string',
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
            'observacoes' => $request->input('observacoes'),
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


    public function show($id)
    {
        $prescricao = Prescricao::with('consulta')->findOrFail($id);
        $consulta = $prescricao->consulta;  // Carrega a consulta associada à prescrição


        return view('prescricao.view', compact('prescricao', 'consulta'));
    }


    public function delete($id)
    {
        $prescricao = Prescricao::findOrFail($id);
        $prescricao->delete();

        return redirect('/prescricaoIndex')->with('successDelete', 'Prescrição médica excluída com sucesso!');
    }
}
