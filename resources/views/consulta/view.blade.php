@extends('adminlte::page')

@section('title', 'Visualizar Consulta')

@section('content_header')
    <h1>Visualizar Consulta</h1>
@stop

@section('content')
    <!-- general form elements -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Dados da Consulta</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <div class="card-body">
            <div class="row">
            <div class="form-group">
                <label for="data_consulta col-md-4">Data da Consulta</label>
                <input type="text" class="form-control" id="data_consulta" name='data_consulta' value="{{ $consulta->data_consulta }}" readonly>
            </div>
            <div class="form-group col-md-4">
                <label for="duracao">Duração</label>
                <input type="text" class="form-control" id="duracao" name='duracao' value="{{ $consulta->duracao }}" readonly>
            </div>
            <div class="form-group col-md-4">
                <label for="id_status">Status da Consulta</label>
                <input type="text" class="form-control" id="id_status" name='id_status' value="{{ $consulta->statusConsulta->descricao }}" readonly>
            </div>
            <div class="form-group col-md-4">
                <label for="observacoes">Observações</label>
                <textarea class="form-control" id="observacoes" name='observacoes' readonly>{{ $consulta->observacoes }}</textarea>
            </div>
        </div>

            <div class="form-group col-md-4">
                <label for="numero_identificacao">Número de Identificação</label>
                <input type="text" class="form-control" id="numero_identificacao" name='numero_identificacao' value="{{ $consulta->numero_identificacao }}" readonly>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ url('/consultaIndex') }}" type="button" class="btn btn-warning">Voltar</a>
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
