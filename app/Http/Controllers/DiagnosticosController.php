<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Diagnostico;
use App\Models\Consulta;
use App\Models\Paciente;
use Illuminate\Support\Facades\Log;

class DiagnosticosController extends Controller
{
    public function index()
    {
        $diagnosticos = Diagnostico::paginate(8);
        return view('diagnostico.index', compact('diagnosticos'));
    }

    public function create()
    {
        // Buscar todas as consultas para o dropdown
        $consultas = Consulta::all();
        return view('diagnostico.create', compact('consultas'));
    }
    public function createWithPaciente(Request $request, $pacienteId)
    {
        $paciente = Paciente::find($pacienteId);
        $consultas = Consulta::all();

        return view('diagnostico.create', compact('consultas', 'paciente'));
    }
    public function saveDiagnostico(Request $request)
    {
        try {
            $request->validate([
                'data_diagnostico' => 'required|date',
                'descricao' => 'required|string',
                'observacoes' => 'nullable|string',
                'consulta_id' => 'required|exists:consultas,id',
            ]);

            Diagnostico::create([
                'data_diagnostico' => $request->input('data_diagnostico'),
                'descricao' => $request->input('descricao'),
                'observacoes' => $request->input('observacoes'),
                'consulta_id' => $request->input('consulta_id'),
            ]);

            // Adicionar logs para verificar os dados em caso de erro
            Log::info('Diagnóstico salvo com sucesso.', [
                'data_diagnostico' => $request->input('data_diagnostico'),
                'descricao' => $request->input('descricao'),
                'observacoes' => $request->input('observacoes'),
                'consulta_id' => $request->input('consulta_id'),
            ]);

            return redirect('/diagnosticoIndex')->with('success', 'Diagnóstico salvo com sucesso.');
        } catch (\Exception $e) {
            // Registrar mensagens de erro
            Log::error('Erro ao salvar diagnóstico: ' . $e->getMessage());

            // Lidar com o erro conforme necessário
            return redirect()->back()->with('error', 'Ocorreu um erro ao salvar o diagnóstico.');
        }
    }

    public function edit($id)
    {
        $diagnostico = Diagnostico::with('consulta')->findOrFail($id);
        // Buscar todas as consultas para o dropdown
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
        return view('diagnostico.view', compact('diagnostico'));
    }

    public function delete($id)
    {
        $diagnostico = Diagnostico::findOrFail($id);
        $diagnostico->delete();

        return redirect()->route('diagnosticoIndex')->with('successDelete', 'Diagnóstico excluído com sucesso.');
    }
}
