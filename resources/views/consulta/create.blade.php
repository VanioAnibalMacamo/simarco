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
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="data_consulta">Data da Consulta</label>
                        <input type="date" class="form-control" id="data_consulta" name='data_consulta'>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="hora_inicio">Hora de Início</label>
                        <input type="time" class="form-control" id="hora_inicio" name="hora_inicio">
                    </div>
                   
                    <div class="form-group col-md-4">
                        <label for="observacoes">Observações</label>
                        <textarea class="form-control h-100" id="observacoes" name='observacoes' placeholder="Digite as observações da consulta..."></textarea>
                    </div>
                </div>
                <div class="row">
                <div class="form-group col-md-4">
                    <label for="id_status">Status da Consulta</label>
                    <select class="form-control" id="id_status" name="id_status">
                        <option value="">Selecione um Status</option>
                        @foreach ($statusConsultas as $status)
                            <option value="{{ $status->id }}">{{ $status->descricao }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group col-md-4">
                    <label for="hora_fim">Hora de Fim</label>
                    <input type="time" class="form-control" id="hora_fim" name="hora_fim">
                </div>
                
                
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
