@extends('adminlte::page')

@section('title', 'Visualizar Médico')

@section('content_header')
    <h1>Visualizar Médico</h1>
@stop

@section('content')
    <!-- general form elements -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Dados do Médico</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <div class="card-body">
            <div class="form-group">
                <label for="nome">Nome Completo</label>
                <input type="text" class="form-control" id="nome" name='nome' value="{{ $medico->nome }}" readonly>
            </div>
            <div class="form-group col-md-4">
                <label for="especialidade_id">Especialidade</label>
                <input type="text" class="form-control" id="especialidade_id" name="especialidade_id" value="{{ $medico->especialidade->nome }}" readonly>
            </div>
            <div class="form-group col-md-4">
                <label for="numero_identificacao">Número de Identificação</label>
                <input type="text" class="form-control" id="numero_identificacao" name='numero_identificacao' value="{{ $medico->numero_identificacao }}" readonly>
            </div>
            <div class="form-group">
                <label for="endereco">Disponibilidade</label>
                <input type="text" class="form-control" id="endereco" name='endereco' value="{{ $medico->endereco }}" readonly>
            </div>
        
        </div>
        <div class="card-footer">
            <a href="{{ url('/medicoIndex') }}" type="button" class="btn btn-warning">Voltar</a>
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
