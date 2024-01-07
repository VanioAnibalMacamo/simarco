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
                <div class="form-group">
                    <label for="data_consulta">Data da Consulta</label>
                    <input type="date" class="form-control" id="data_consulta" name='data_consulta' value="{{ $consulta->data_consulta }}">
                </div>
                <div class="form-group">
                    <label for="duracao">Duração</label>
                    <input type="text" class="form-control" id="duracao" name='duracao' value="{{ $consulta->duracao }}">
                </div>
                <div class="form-group">
                    <label for="id_status">Status da Consulta</label>
                    <select class="form-control" id="id_status" name="id_status">
                        @foreach ($statusConsultas as $statusConsulta)
                            <option value="{{ $statusConsulta->id }}" {{ $consulta->id_status == $statusConsulta->id ? 'selected' : '' }}>
                                {{ $statusConsulta->descricao }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="observacoes">Observações</label>
                    <textarea class="form-control" id="observacoes" name="observacoes">{{ $consulta->observacoes }}</textarea>
                </div>
                <div class="form-group">
                    <label for="numero_identificacao">Número de Identificação</label>
                    <input type="text" class="form-control" id="numero_identificacao" name='numero_identificacao' value="{{ $consulta->numero_identificacao }}">
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
