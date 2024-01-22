@extends('adminlte::page')

@section('title', 'Visualizar Diagnóstico')

@section('content_header')
    <h1>Visualizar Diagnóstico</h1>
@stop

@section('content')
    <!-- General form elements -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Dados do Diagnóstico</h3>
        </div>
        <!-- /.card-header -->
        <!-- Form start -->
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="data_diagnostico">Data do Diagnóstico</label>
                    <input type="text" class="form-control" id="data_diagnostico" name='data_diagnostico'
                        value="{{ $diagnostico->data_diagnostico }}" readonly>
                </div>
                <div class="form-group col-md-6">
                    <label for="consulta_id">Consulta Relacionada</label>
                    <input type="text" class="form-control"
                        value="{{ $diagnostico->consulta->data }} - {{ $diagnostico->consulta->paciente->nome }}" readonly>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="descricao">Descrição</label>
                    <textarea class="form-control h-100" id="descricao" name='descricao' readonly>{{ $diagnostico->descricao }}</textarea>
                </div>
                <div class="form-group col-md-6">
                    <label for="observacoes">Observações</label>
                    <textarea class="form-control h-100" id="observacoes" name='observacoes' readonly>{{ $diagnostico->observacoes }}</textarea>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ url('/diagnosticoIndex') }}" type="button" class="btn btn-warning">Voltar</a>
        </div>
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
