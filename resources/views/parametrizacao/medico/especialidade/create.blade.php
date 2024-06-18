@extends('adminlte::page')

@section('title', 'Especialidades')

@section('content_header')
    <h1>Formulário</h1>
@stop

@section('content')
<div class="card card-primary">
    <div class="card-body">
        <form action="{{ route('saveEspecialidade') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="descricao">Descrição</label>
                    <input type="text" class="form-control" id="descricao" name="descricao" placeholder="Digite a Descrição" required>
                </div>
                <div class="col-md-6">
                    <label for="preco">Preço</label>
                    <input type="number" class="form-control" id="preco" name="preco" placeholder="Digite o Preço" required>
                </div>
            </div>
            <div class="form-group">
                <label for="imagem">Imagem</label>
                <input type="file" class="form-control-file" id="imagem" name="imagem" accept="image/png, image/jpeg" required>
            </div>
            <div class="form-group">
                <div id="imagePreview" class="card" style="width: 200px;">
                    <img class="card-img-top" src="#" alt="Preview da Imagem">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
    </div>
</div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Formulário carregado'); </script>

    <script>
        document.getElementById('imagem').addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewImage = document.getElementById('imagePreview').querySelector('img');
                    previewImage.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
@stop
