@extends('adminlte::page')

@section('title', 'Editar Especialidade')

@section('content_header')
    <h1>Editar Especialidade</h1>
@stop

@section('content')
    <div class="card card-primary">
        <div class="card-body">
            <form action="{{ route('especialidades.update', $especialidade->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="descricao">Descrição</label>
                        <input type="text" class="form-control" id="descricao" name="descricao" value="{{ $especialidade->descricao }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="preco">Preço</label>
                        <input type="number" class="form-control" id="preco" name="preco" value="{{ $especialidade->preco }}" required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="imagemAtual">Imagem Atual</label><br>
                        @if ($especialidade->imagem)
                        <img src="{{ asset('images/especialidades/' . $especialidade->imagem) }}" style="max-width: 200px;" alt="Imagem Atual">
                        @endif
                    </div>
                    <div class="col-md-6">
                        <label for="imagemNova">Nova Imagem</label><br>
                        <input type="file" class="form-control-file" id="imagem" name="imagem" accept="image/png, image/jpeg">
                        <div id="imagePreview" class="card" style="width: 200px;">
                            <img class="card-img-top" src="#" alt="Preview da Nova Imagem">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </form>

        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Página de edição carregada'); </script>
    <script>
        document.getElementById('imagem').addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('imagePreview').innerHTML = '<img class="card-img-top" src="' + e.target.result + '" alt="Preview da Imagem">';
                }
                reader.readAsDataURL(file);
            }
        });
    </script>

@stop
