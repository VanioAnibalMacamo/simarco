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
        $request->validate([
            'data_prescricao' => 'required|date',
            'observacoes' => 'nullable|string',
            'consulta_id' => 'required|exists:consultas,id',
            'medicamentos' => 'required|array',
            'dosagens' => 'required|array',
        ]);

        // Verifica se a consulta já possui uma prescrição associada
        if (Prescricao::where('consulta_id', $request->input('consulta_id'))->exists()) {
            return redirect('/prescricaoIndex')->with('error', 'Esta consulta já possui uma prescrição associada.');
        }

        // Cria a instância da Prescricao
        $prescricao = Prescricao::create([
            'data_prescricao' => $request->input('data_prescricao'),
            'observacoes' => $request->input('observacoes'),
            'consulta_id' => $request->input('consulta_id'),
        ]);

        // Obtém os medicamentos e dosagens selecionados
        $medicamentosSelecionados = $request->input('medicamentos');
        $dosagens = $request->input('dosagens');

        // Associa os medicamentos e dosagens à prescrição
        foreach ($medicamentosSelecionados as $medicamentoId) {
            $prescricao->medicamentos()->attach($medicamentoId, ['dosagem' => $dosagens[$medicamentoId]]);
        }

        return redirect('/prescricaoIndex')->with('success', 'Prescrição médica salva com sucesso!');
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
            //'consulta_id' => 'required|exists:consultas,id',
            'medicamentos' => 'required|array',
            'dosagens' => 'required|array',
        ]);

        $prescricao = Prescricao::find($id);

        if (!$prescricao) {
            return redirect('/prescricaoIndex')->with('error', 'Prescrição não encontrada.');
        }

        $prescricao->update([
            'data_prescricao' => $request->input('data_prescricao'),
            'observacoes' => $request->input('observacoes'),
           // 'consulta_id' => $request->input('consulta_id'),
        ]);

        // Sincronize os medicamentos e dosagens na tabela pivot
        $medicamentosSelecionados = $request->input('medicamentos');
        $dosagens = $request->input('dosagens');

        $prescricao->medicamentos()->sync([]);

        foreach ($medicamentosSelecionados as $medicamentoId) {
            $prescricao->medicamentos()->attach($medicamentoId, ['dosagem' => $dosagens[$medicamentoId]]);
        }

        return redirect('/prescricaoIndex')->with('success', 'Prescrição médica actualizada com sucesso.');
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
