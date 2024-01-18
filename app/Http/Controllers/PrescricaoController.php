<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prescricao;
use App\Models\Consulta;
use App\Models\Medicamento;

class PrescricaoController extends Controller
{
    public function index()
    {
        $prescricoes = Prescricao::paginate(8);
        return view('prescricao.index', compact('prescricoes'));
    }

    public function create()
    {

        // Buscar todas as consultas para o dropdown
        $consultas = Consulta::all();
        $medicamentos = Medicamento::all();
        return view('prescricao.create', compact('consultas','medicamentos'));
    }

    public function savePrescricao(Request $request)
    {
        $request->validate([
            'data_prescricao' => 'required|date',
            'observacoes' => 'nullable|string',
            'consulta_id' => 'required|exists:consultas,id',
            'medicamentos' => 'required|array', // Validar se a entrada de medicamentos é um array
            'dosagens' => 'required|array', // Validar se a entrada de dosagens é um array
        ]);

        // Crie a instância da Prescricao
        $prescricao = Prescricao::create([
            'data_prescricao' => $request->input('data_prescricao'),
            'observacoes' => $request->input('observacoes'),
            'consulta_id' => $request->input('consulta_id'),
        ]);

        // Obtenha os medicamentos e dosagens selecionados
        $medicamentosSelecionados = $request->input('medicamentos');
        $dosagens = $request->input('dosagens');

        // Associe os medicamentos e dosagens à prescrição
        foreach ($medicamentosSelecionados as $medicamentoId) {
            $prescricao->medicamentos()->attach($medicamentoId, ['dosagem' => $dosagens[$medicamentoId]]);
        }

        return redirect('/prescricaoIndex')->with('success', 'Prescrição médica salva com sucesso!');
    }


    public function edit($id)
    {

        $prescricao = Prescricao::with('consulta')->findOrFail($id);
        // Buscar todas as consultas para o dropdown
        $consultas = Consulta::all();
        return view('prescricao.edit', compact('prescricao', 'consultas'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'data_prescricao' => 'required|date',
            'observacoes' => 'nullable|string',
            'consulta_id' => 'required|exists:consultas,id',
        ]);

        $prescricao = Prescricao::findOrFail($id);

        $prescricao->update([
            'data_prescricao' => $request->input('data_prescricao'),
            'observacoes' => $request->input('observacoes'),
        ]);

        return redirect('/prescricaoIndex')->with('success', 'Prescrição médica atualizada com sucesso!');
    }

    public function show($id)
    {
        $prescricao = Prescricao::findOrFail($id);
        return view('prescricao.view', compact('prescricao'));
    }

    public function delete($id)
    {
        $prescricao = Prescricao::findOrFail($id);
        $prescricao->delete();

        return redirect('/prescricaoIndex')->with('successDelete', 'Prescrição médica excluída com sucesso!');
    }
}
