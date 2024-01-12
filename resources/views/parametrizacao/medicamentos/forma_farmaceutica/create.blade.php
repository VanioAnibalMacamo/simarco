@extends('adminlte::page')

@section('title', 'Cadastrar Forma Farmacêutica')

@section('content_header')
    <h1>Cadastrar Forma Farmacêutica</h1>
@stop

@section('content')
    <!-- general form elements -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Forma Farmacêutica</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="{{ url('forma_farmaceutica/store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="descricao">Descrição</label>
                    <input type="text" class="form-control" id="descricao" name='descricao' placeholder="Digite a Descrição">
                </div>
            </div>
            <div class="card-footer">
                <input type="submit" class="btn btn-primary" value='Salvar'>
                <a href="{{ url('/forma_farmaceutica') }}" type="button" class="btn btn-warning">Cancelar</a>
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
