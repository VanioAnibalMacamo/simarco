<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Diagnostico;
use App\Models\Consulta;
use App\Models\StatusConsulta;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class DiagnosticosController extends Controller
{
    public function index()
    {
        $diagnosticos = Diagnostico::paginate(8);
        return view('diagnostico.index', compact('diagnosticos'));
    }

    public function create($consultaId)
    {
        $consulta = Consulta::find($consultaId);

        if (!$consulta) {
            abort(404, 'Consulta não encontrada');
        }

        $diagnosticoExistente = Diagnostico::where('consulta_id', $consulta->id)->first();

        if ($diagnosticoExistente) {
            return redirect('/consultaIndex?id=' . $diagnosticoExistente->id)
                ->with('error', 'Esta consulta já possui um diagnóstico associado.');
        }

        return view('diagnostico.create', compact('consulta'));
    }

    public function saveDiagnostico(Request $request)
    {
        $request->validate([
            'data_diagnostico' => 'required|date',
            'consulta_id' => 'required|exists:consultas,id',
            'descricao' => 'required|string',
            'observacoes' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $consulta = Consulta::find($request->input('consulta_id'));

            // Obtém o novo status dinamicamente com base na existência de um diagnóstico
            $novoStatus = $consulta->diagnostico ? StatusConsulta::find(2) : StatusConsulta::find(1);

            // Verifica se o novo status foi encontrado
            if (!$novoStatus) {
                throw new \Exception('Novo status não encontrado.');
            }

            $diagnostico = new Diagnostico([
                'data_diagnostico' => $request->input('data_diagnostico'),
                'consulta_id' => $request->input('consulta_id'),
                'descricao' => $request->input('descricao'),
                'observacoes' => $request->input('observacoes'),
            ]);

            $diagnostico->save();

            Log::info('Status antes de atualizar: ' . $consulta->statusConsulta->descricao);

            // Atualizar o status da consulta
            $consulta->statusConsulta()->associate($novoStatus);
            $consulta->save();

            Log::info('Status depois de atualizar: ' . $consulta->statusConsulta->descricao);

            DB::commit();

            return redirect()->route('prescricaoCreate', ['consultaId' => $consulta->id])
                ->with('success', 'Diagnóstico cadastrado com sucesso!');
        } catch (\Exception $e) {
            DB::rollback();

            Log::error('Erro ao salvar o diagnóstico. ' . $e->getMessage());

            return redirect('/consultaIndex')->with('error', 'Erro ao salvar o diagnóstico. Por favor, tente novamente.');
        }
    }

    public function edit($id)
    {
        $diagnostico = Diagnostico::with('consulta')->findOrFail($id);
        $consultas = Consulta::all();

        return view('diagnostico.edit', compact('diagnostico', 'consultas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'data_diagnostico' => 'required|date',
            'descricao' => 'required|string',
            'observacoes' => 'nullable|string',
            'consulta_id' => 'required|exists:consultas,id',
        ]);

        $diagnostico = Diagnostico::findOrFail($id);
        $diagnostico->update($request->all());

        return redirect()->route('diagnosticoIndex')->with('success', 'Diagnóstico atualizado com sucesso.');
    }

    public function show($id)
    {
        $diagnostico = Diagnostico::with('consulta')->findOrFail($id);
        $consulta = $diagnostico->consulta;

        return view('diagnostico.view', compact('diagnostico', 'consulta'));
    }

    public function delete($id)
    {
        $diagnostico = Diagnostico::findOrFail($id);
        $diagnostico->delete();

        return redirect()->route('diagnosticoIndex')->with('successDelete', 'Diagnóstico excluído com sucesso.');
    }
}
