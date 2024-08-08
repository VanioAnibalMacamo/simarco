<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;
use App\Models\Paciente;
use App\Enums\GeneroEnum;
use Illuminate\Support\Facades\File;

class PacienteController extends Controller
{
    public function index()
    {
        $pacientes = Paciente::paginate(8);
        return view('paciente.index', ['pacientes' => $pacientes]);
    }

    public function create()
    {
        $empresas = Empresa::all(); // Obtém todas as empresas cadastradas
        $generos = GeneroEnum::getConstants(); // Obtém os gêneros

        // Passa as empresas e gêneros para a view
        return view('paciente.create', compact('empresas', 'generos'));
    }

    public function savePaciente(Request $request)
    {
        // Validação dos dados do formulário
        $request->validate([
            'nome' => 'required|string|max:255',
            'data_nascimento' => 'required|date',
            'genero' => 'required|in:masculino,feminino,outro',
            'numero_identificacao' => 'required|string|max:255',
            'endereco' => 'required|string|max:255',
            'telefone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'empresa_id' => 'nullable|exists:empresas,id',
            'codigoFuncionario' => 'nullable|string',
            'cartao_seguro_saude' => 'nullable|file|mimes:pdf,jpg,jpeg,png' // Validação para o arquivo
        ]);

        // Cria um novo paciente com base nos dados do formulário
        $paciente = Paciente::create([
            'nome' => $request->input('nome'),
            'data_nascimento' => $request->input('data_nascimento'),
            'genero' => $request->input('genero'),
            'numero_identificacao' => $request->input('numero_identificacao'),
            'endereco' => $request->input('endereco'),
            'telefone' => $request->input('telefone'),
            'email' => $request->input('email'),
            'empresa_id' => $request->input('empresa_id'),
            'codigo_funcionario' => $request->input('codigoFuncionario'),
            'agendamento_id' => $request->input('agendamento_id')
        ]);

        // Verifica e cria as pastas necessárias
        $pastaPrincipal = 'consultas';
        $pastaCartaoSaude = 'cartao_saude';
        $pathPrincipal = storage_path("app/public/{$pastaPrincipal}");
        $pathCartaoSaude = "{$pathPrincipal}/{$pastaCartaoSaude}";

        if (!File::exists($pathPrincipal)) {
            File::makeDirectory($pathPrincipal, 0755, true);
        }

        if (!File::exists($pathCartaoSaude)) {
            File::makeDirectory($pathCartaoSaude, 0755, true);
        }

        // Faz o upload do arquivo se ele existir
        if ($request->hasFile('cartao_seguro_saude')) {
            $nomePaciente = $paciente->nome; // Nome do paciente
            $dataConsulta = $request->input('data_consulta');
            $horaInicio = $request->input('hora_inicio');
            $horaFim = $request->input('hora_fim');
            $originalFile = $request->file('cartao_seguro_saude');
            $originalFileName = pathinfo($originalFile->getClientOriginalName(), PATHINFO_FILENAME);
            $extensao = $originalFile->getClientOriginalExtension();

            // Limpa caracteres indesejados do nome do arquivo
            $nomePaciente = preg_replace('/[^a-zA-Z0-9_\- ]/', '_', $nomePaciente); // Remove caracteres especiais
            $dataConsulta = preg_replace('/[^a-zA-Z0-9_\- ]/', '_', $dataConsulta);
            $horaInicio = preg_replace('/[^a-zA-Z0-9_\- ]/', '_', $horaInicio);
            $horaFim = preg_replace('/[^a-zA-Z0-9_\- ]/', '_', $horaFim);

            $nomeArquivo = "{$nomePaciente}_{$dataConsulta}_{$horaInicio}_{$horaFim}_{$originalFileName}.{$extensao}";

            // Armazena o arquivo com o novo nome
            $originalFile->storeAs("public/{$pastaPrincipal}/{$pastaCartaoSaude}", $nomeArquivo);

            // Atualiza o nome do arquivo no paciente
            $paciente->update(['cartao_seguro_saude' => $nomeArquivo]);
        }

        // Redireciona para a página desejada após salvar o paciente
        return redirect('/pacienteIndex')->with('success', 'Paciente salvo com sucesso!');
    }

    public function delete($id)
    {
        $paciente = Paciente::findOrFail($id);
        $paciente->delete();

        return redirect('/pacienteIndex')->with('successDelete', 'Paciente excluído com sucesso!');
    }

    public function show($id)
    {
        $paciente = Paciente::findOrFail($id);
        return view('paciente.view', ['paciente' => $paciente]);
    }

    public function edit($id)
    {
        $paciente = Paciente::findOrFail($id);
        $empresas = Empresa::all(); // Obtém todas as empresas cadastradas
        $generos = GeneroEnum::getConstants(); // Obtém os gêneros

        // Passa o paciente, empresas e gêneros para a view
        return view('paciente.edit', compact('paciente', 'empresas', 'generos'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'data_nascimento' => 'required|date',
            'genero' => 'required|in:masculino,feminino,outro',
            'numero_identificacao' => 'required|string|max:255',
            'endereco' => 'required|string|max:255',
            'telefone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'empresa_id' => 'nullable|exists:empresas,id',
            'codigoFuncionario' => 'nullable|string|max:255',
            'cartao_seguro_saude' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        $paciente = Paciente::findOrFail($id);

        // Atualiza todos os campos, exceto o arquivo e o campo `codigo_funcionario`
        $paciente->update($request->except('cartao_seguro_saude', 'codigoFuncionario'));

        // Atualiza o campo `codigo_funcionario` separadamente
        if ($request->has('codigoFuncionario')) {
            $paciente->update(['codigo_funcionario' => $request->input('codigoFuncionario')]);
        }

        // Faz o upload do arquivo se ele existir
        if ($request->hasFile('cartao_seguro_saude')) {
            $nomePaciente = $paciente->nome;
            $originalFile = $request->file('cartao_seguro_saude');
            $originalFileName = pathinfo($originalFile->getClientOriginalName(), PATHINFO_FILENAME);
            $extensao = $originalFile->getClientOriginalExtension();

            // Limpa caracteres indesejados do nome do arquivo
            $nomePaciente = preg_replace('/[^a-zA-Z0-9_\- ]/', '_', $nomePaciente);
            $nomeArquivo = "{$nomePaciente}_{$originalFileName}.{$extensao}";

            // Armazena o arquivo com o novo nome
            $originalFile->storeAs("public/consultas/cartao_saude", $nomeArquivo);

            // Atualiza o nome do arquivo no paciente
            $paciente->update(['cartao_seguro_saude' => $nomeArquivo]);
        }

        return redirect('/pacienteIndex')->with('success', 'Paciente atualizado com sucesso!');
    }


    private function verificarCriarPasta($caminho)
    {
        if (!File::exists($caminho)) {
            File::makeDirectory($caminho, 0755, true);
        }
    }
}
