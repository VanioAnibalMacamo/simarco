<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Especialidade;

class EspecialidadeController extends Controller
{
    /*
    public function index()
    {
        $especialidades = Especialidade::paginate(8);
        return view('parametrizacao.medico.especialidade.index',['especialidades' => $especialidades]);
    }
        */

    public function index()
    {
        $especialidades = Especialidade::paginate(8);
        return view('parametrizacao.medico.especialidade.index', ['especialidades' => $especialidades]);
    }

    public function showModal()
    {
        $especialidades = Especialidade::all();
        return view('modals.modal_especialidades', ['especialidades' => $especialidades]);
    }

    public function create()
    {
        return view('parametrizacao.medico.especialidade.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'descricao' => 'required|string|max:255',
            'preco' => 'required|numeric|min:0',
            'imagem' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Adiciona a validação para a imagem
        ]);

        // Obter o nome da imagem
        $imagemNome = $request->file('imagem')->getClientOriginalName();

        // Salvar a imagem no diretório de imagens
        $request->file('imagem')->move(public_path('images/especialidades'), $imagemNome);

        // Salvar o nome da imagem e outros dados no banco de dados
        Especialidade::create([
            'descricao' => $request->input('descricao'),
            'preco' => $request->input('preco'),
            'imagem' => $imagemNome,
        ]);

        return redirect('/especialidadeIndex')->with('success', 'Especialidade salva com sucesso!'.$imagemNome);
    }

    public function edit($id)
    {
        $especialidade = Especialidade::findOrFail($id);

        return view('parametrizacao.medico.especialidade.edit', ['especialidade' => $especialidade]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'descricao' => 'required|string|max:255',
            'preco' => 'required|numeric|min:0',
            'imagem' => 'nullable|image|mimes:jpeg,png|max:2048', // Novas regras para a imagem
        ]);

        $especialidade = Especialidade::findOrFail($id);
        $especialidade->descricao = $request->input('descricao');
        $especialidade->preco = $request->input('preco');

        // Verifica se foi enviada uma nova imagem
        if ($request->hasFile('imagem')) {
            // Remove a imagem atual, se existir
            if ($especialidade->imagem) {
                $caminhoImagemAtual = public_path('images/especialidades/') . $especialidade->imagem;
                if (file_exists($caminhoImagemAtual)) {
                    unlink($caminhoImagemAtual);
                }
            }

            // Obtém e salva a nova imagem
            $novaImagem = $request->file('imagem');
            $nomeImagem = $novaImagem->getClientOriginalName();
            $novaImagem->move(public_path('images/especialidades/'), $nomeImagem);
            $especialidade->imagem = $nomeImagem;
        }

        $especialidade->save();

        return redirect('/especialidadeIndex')->with('success', 'Especialidade actualizada com sucesso!');
    }

    public function destroy($id)
    {
        $especialidade = Especialidade::findOrFail($id);
        $especialidade->delete();

        return redirect('/especialidadeIndex')->with('successDelete', 'Especialidade excluída com sucesso!');
    }

    public function show($id)
    {
        $especialidade = Especialidade::findOrFail($id);

        return view('especialidade.view', ['especialidade' => $especialidade]);
    }

}


