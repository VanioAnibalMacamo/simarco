@extends('adminlte::page')

@section('title', 'Editar Gravidade')

@section('content_header')
    <h1>Editar Gravidade</h1>
@stop

@section('content')
    <!-- General form elements -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Gravidade</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="{{ route('gravidade.update', $gravidade->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') <!-- Adicione esta linha -->

            <div class="card-body">
                <div class="form-group">
                    <label for="descricao">Descrição</label>
                    <input type="text" class="form-control" id="descricao" name='descricao'
                        placeholder="Digite a Descrição" value="{{ old('descricao', $gravidade->descricao) }}">
                </div>
            </div>
            <div class="card-footer">
                <input type="submit" class="btn btn-primary" value='Atualizar'>
                <a href="{{ url('/gravidadeIndex') }}" type="button" class="btn btn-warning">Cancelar</a>
            </div>
        </form>
    </div>
    <!-- /.card -->
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        console.log('Hi!');
    </script>
@stop
