@extends('adminlte::page')

@section('title', 'Editar Via de Administração')

@section('content_header')
    <h1>Editar Via de Administração</h1>
@stop

@section('content')
    <!-- general form elements -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Via de Administração</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="{{ url('via_administracao/update', $viaAdministracao->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="descricao">Descrição</label>
                    <input type="text" class="form-control" id="descricao" name='descricao' placeholder="Digite a Descrição" value="{{ $viaAdministracao->descricao }}">
                </div>
            </div>
            <div class="card-footer">
                <input type="submit" class="btn btn-primary" value='Actualizar'>
                <a href="{{ url('/via_administracao') }}" type="button" class="btn btn-warning">Cancelar</a>
            </div>
        </form>
    </div>
    <!-- /.card -->
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
