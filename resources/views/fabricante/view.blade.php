@extends('adminlte::page')

@section('title', 'Visualizar Fabricante')

@section('content_header')
    <h1>Visualizar Fabricante</h1>
@stop

@section('content')
    <!-- general form elements -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Dados do Fabricante</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <div class="card-body">
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" class="form-control" id="nome" name='nome' value="{{ $fabricante->nome }}" readonly>
            </div>

        <div class="row">
                    <div class="form-group col-md-6">
                <label for="endereco">Endereço</label>
                <input type="text" class="form-control" id="endereco" name='endereco' value="{{ $fabricante->endereco }}" readonly>
            </div>
            <div class="form-group col-md-6">
                <label for="contacto">Contacto</label>
                <input type="text" class="form-control" id="contacto" name='contacto' value="{{ $fabricante->contacto }}" readonly>
            </div>
        </div>
    </div>
        <div class="card-footer">
            <a href="{{ url('/fabricanteIndex') }}" type="button" class="btn btn-warning">Voltar</a>
        </div>
    </div>
    <!-- /.card -->
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
