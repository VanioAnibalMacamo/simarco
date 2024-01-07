@extends('adminlte::page')

@section('title', 'Cadastrar Consulta')

@section('content_header')
    <h1>Cadastrar Consulta</h1>
@stop

@section('content')
    <!-- general form elements -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Dados da Consulta</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="{{ url('saveConsulta') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="data_consulta">Data da Consulta</label>
                    <input type="date" class="form-control" id="data_consulta" name='data_consulta'>
                </div>
                <div class="form-group">
                    <label for="duracao">Duração</label>
                    <input type="text" class="form-control" id="duracao" name='duracao' placeholder="Digite a duração da consulta...">
                </div>
                <div class="form-group">
                    <label for="id_status">Status da Consulta</label>
                    <select class="form-control" id="id_status" name="id_status">
                        <option value="">Selecione um Status</option>
                        @foreach ($statusConsultas as $status)
                            <option value="{{ $status->id }}">{{ $status->descricao }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="observacoes">Observações</label>
                    <textarea class="form-control" id="observacoes" name='observacoes' placeholder="Digite as observações da consulta..."></textarea>
                </div>
                <div class="form-group">
                    <label for="numero_identificacao">Número de Identificação</label>
                    <input type="text" class="form-control" id="numero_identificacao" name='numero_identificacao' placeholder="Digite o número de identificação...">
                </div>
            </div>
            <div class="card-footer">
                <input type="submit" class="btn btn-primary" value='Salvar'>
                <a href="{{ url('/consultaIndex') }}" type="button" class="btn btn-warning">Cancelar</a>
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
