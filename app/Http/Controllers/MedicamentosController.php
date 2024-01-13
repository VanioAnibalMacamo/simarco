<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medicamento;
use App\Models\FormaFarmaceutica;
use App\Models\ViaAdministracao;
use App\Models\Fabricante;
use Illuminate\Support\Facades\Log;
use App\Enums\Disponibilidade_medicamentos;

class MedicamentosController extends Controller
{
    public function index()
    {
        $medicamentos = Medicamento::paginate(10);
        return view('medicamento.index', compact('medicamentos'));
    }

    public function create()
    {
        $formasFarmaceuticas = FormaFarmaceutica::all();
        $viasAdministracao = ViaAdministracao::all();
        $fabricantes = Fabricante::all();
        $disponibilidades = Disponibilidade_medicamentos::getConstants();

        return view('medicamento.create', compact('formasFarmaceuticas', 'viasAdministracao', 'fabricantes', 'disponibilidades'));
    }

    public function saveMedicamento(Request $request)
    {
        Log::info('Forma Farmaceutica ID: ' . $request->input('forma_farmaceutica'));

        // Adicione validações conforme necessário
        $request->validate([
            'nome_medicamento' => 'required|string|max:255',
            'substancias_quimicas' => 'required|string',
            'forma_farmaceutica' => 'required|exists:formas_farmaceuticas,id',
            'dosagem' => 'required|string',
            'via_administracao' => 'required|exists:via_administracaos,id',
            'fabricante_id' => 'required|exists:fabricantes,id',
            'numero_registo' => 'required|string|max:255',
            'data_fabricacao' => 'required|date',
            'data_validade' => 'required|date|after:today',
            'indicacoes' => 'required|string',
            'contraindicacoes' => 'required|string',
            'efeitos_colaterais' => 'required|string',
            'instrucoes_uso' => 'required|string',
            'armazenamento' => 'required|string',
            'preco' => 'required|numeric|min:0',
            'disponibilidade' => 'required|in:disponivel,indisponivel',
        ]);

        // Crie um novo Medicamento com base nos dados do formulário
        Medicamento::create([

            'nome_medicamento' => $request->input('nome_medicamento'),
            'substancias_quimicas' => $request->input('substancias_quimicas'),
            'forma_farmaceutica_id' => $request->input('forma_farmaceutica'),
            'dosagem' => $request->input('dosagem'),
            'via_administracao_id' => $request->input('via_administracao'),
            'fabricante_id' => $request->input('fabricante_id'),
            'numero_registo' => $request->input('numero_registo'),
            'data_fabricacao' => $request->input('data_fabricacao'),
            'data_validade' => $request->input('data_validade'),
            'indicacoes' => $request->input('indicacoes'),
            'contraindicacoes' => $request->input('contraindicacoes'),
            'efeitos_colaterais' => $request->input('efeitos_colaterais'),
            'instrucoes_uso' => $request->input('instrucoes_uso'),
            'armazenamento' => $request->input('armazenamento'),
            'preco' => $request->input('preco'),
            'disponibilidade' => $request->input('disponibilidade'),
        ]);

        return redirect('/medicamentoIndex')->with('success', 'Medicamento criado com sucesso!');
    }


    public function edit($id)
    {
        $medicamento = Medicamento::findOrFail($id);
        $formasFarmaceuticas = FormaFarmaceutica::all();
        $viasAdministracao = ViaAdministracao::all();
        $fabricantes = Fabricante::all();
        $disponibilidades = Disponibilidade_medicamentos::getConstants();

        return view('medicamento.edit', compact('medicamento', 'formasFarmaceuticas', 'viasAdministracao', 'fabricantes', 'disponibilidades'));
    }

    public function update(Request $request, $id)
    {
        // Adicione validações conforme necessário
        $request->validate([
            'nome_medicamento' => 'required|string|max:255',
            'substancias_quimicas' => 'required|string',
            'forma_farmaceutica' => 'required|exists:formas_farmaceuticas,id',
            'dosagem' => 'required|string',
            'via_administracao' => 'required|exists:via_administracaos,id',
            'fabricante_id' => 'required|exists:fabricantes,id',
            'numero_registo' => 'required|string|max:255',
            'data_fabricacao' => 'required|date',
            'data_validade' => 'required|date|after:today',
            'indicacoes' => 'required|string',
            'contraindicacoes' => 'required|string',
            'efeitos_colaterais' => 'required|string',
            'instrucoes_uso' => 'required|string',
            'armazenamento' => 'required|string',
            'preco' => 'required|numeric|min:0',
            'disponibilidade' => 'required|in:disponivel,indisponivel',
        ]);

        $medicamento = Medicamento::findOrFail($id);

        // Atualize o Medicamento com base nos dados do formulário
        $medicamento->update([
            'nome_medicamento' => $request->input('nome_medicamento'),
            'substancias_quimicas' => $request->input('substancias_quimicas'),
            'forma_farmaceutica_id' => $request->input('forma_farmaceutica'),
            'dosagem' => $request->input('dosagem'),
            'via_administracao_id' => $request->input('via_administracao'),
            'fabricante_id' => $request->input('fabricante_id'),
            'numero_registo' => $request->input('numero_registo'),
            'data_fabricacao' => $request->input('data_fabricacao'),
            'data_validade' => $request->input('data_validade'),
            'indicacoes' => $request->input('indicacoes'),
            'contraindicacoes' => $request->input('contraindicacoes'),
            'efeitos_colaterais' => $request->input('efeitos_colaterais'),
            'instrucoes_uso' => $request->input('instrucoes_uso'),
            'armazenamento' => $request->input('armazenamento'),
            'preco' => $request->input('preco'),
            'disponibilidade' => $request->input('disponibilidade'),
        ]);

        return redirect('/medicamentoIndex')->with('success', 'Medicamento atualizado com sucesso!');
    }

    public function show($id)
    {
        $medicamento = Medicamento::findOrFail($id);
        return view('medicamento.view', compact('medicamento'));
    }

    public function delete($id)
    {
        $medicamento = Medicamento::findOrFail($id);
        $medicamento->delete();

        return redirect('/medicamentoIndex')->with('successDelete', 'Medicamento excluído com sucesso!');
    }
}
