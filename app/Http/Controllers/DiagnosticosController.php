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

    public function create($consultaId)
    {
        // Buscar a consulta específica pelo ID
        $consulta = Consulta::find($consultaId);

        // Verificar se a consulta foi encontrada
        if (!$consulta) {
            // Tratar o caso em que a consulta não foi encontrada
            abort(404, 'Consulta não encontrada');
        }

        return view('diagnostico.create', compact('consulta'));
    }

    public function saveDiagnostico(Request $request)
    {
           // Validação dos dados do formulário


        // Criação de um novo diagnóstico com base nos dados do formulário
        $diagnostico = new Diagnostico([
            'data_diagnostico' => $request->input('data_diagnostico'),
            'consulta_id' => $request->input('consulta_id'),
            'descricao' => $request->input('descricao'),
            'observacoes' => $request->input('observacoes'),
        ]);

        $diagnostico->save();

        // Redireciona para a página desejada após o salvamento
        return redirect()->route('diagnosticoIndex')->with('success', 'Diagnóstico cadastrado com sucesso!');
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

        return redirect()->route('diagnosticoIndex')->with('success', 'Diagnóstico actualizado com sucesso.');
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
