@extends('adminlte::page')

@section('title', 'Editar Consulta')

@section('content_header')
    <h1>Editar Consulta</h1>
@stop

@section('content')
    <!-- general form elements -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Dados da Consulta</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="{{ route('consultas.update', ['id' => $consulta->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="data_consulta">Data da Consulta</label>
                        <input type="date" class="form-control" id="data_consulta" name='data_consulta' value="{{ $consulta->data_consulta }}">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="hora_inicio">Hora de Início</label>
                        <input type="time" class="form-control" id="hora_inicio" name="hora_inicio" value="{{ $consulta->hora_inicio }}">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="hora_fim">Hora de Fim</label>
                        <input type="time" class="form-control" id="hora_fim" name="hora_fim" value="{{ $consulta->hora_fim }}">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="observacoes">Observações</label>
                        <textarea class="form-control h-98" id="observacoes" name='observacoes' placeholder="Digite as observações da consulta...">{{ $consulta->observacoes }}</textarea>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="id_status">Status da Consulta</label>
                        <select class="form-control" id="id_status" name="id_status">
                            @foreach ($statusConsultas as $statusConsulta)
                                <option value="{{ $statusConsulta->id }}" {{ $consulta->statusConsulta && $consulta->statusConsulta->id == $statusConsulta->id ? 'selected' : '' }}>
                                    {{ $statusConsulta->descricao }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group col-md-4">
                        <label for="id_paciente">Paciente</label>
                        <select class="form-control" id="id_paciente" name="id_paciente">
                            @foreach ($pacientes as $paciente)
                                <option value="{{ $paciente->id }}" {{ $consulta->paciente && $consulta->paciente->id == $paciente->id ? 'selected' : '' }}>
                                    {{ $paciente->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group col-md-4">
                        <label for="id_medico">Médico Responsável</label>
                        <select class="form-control" id="id_medico" name="id_medico">
                            @foreach ($medicos as $medico)
                                <option value="{{ $medico->id }}" {{ $consulta->medico && $consulta->medico->id == $medico->id ? 'selected' : '' }}>
                                    {{ $medico->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
            </div>
            <div class="card-footer">
                <input type="submit" class="btn btn-primary" value='Atualizar'>
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
