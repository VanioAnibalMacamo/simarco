@extends('adminlte::page')

@section('title', 'Visualizar Sintoma')

@section('content_header')
    <h1>Visualizar Sintoma</h1>
@stop

@section('content')
    <!-- General form elements -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Dados do Sintoma</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="descricao">Descrição do Sintoma</label>
                    <input type="text" class="form-control" id="descricao" name='descricao'
                        value="{{ $sintoma->descricao }}" readonly>
                </div>

                <div class="form-group col-md-6">
                    <label for="gravidade">Gravidade do Sintoma</label>
                    <input type="text" class="form-control" id="gravidade" name='gravidade'
                        value="{{ $sintoma->gravidade->descricao }}" readonly>
                </div>
            </div>

            <div class="form-group">
                <label for="duracao">Duração do Sintoma</label>
                <input type="text" class="form-control" id="duracao" name='duracao' value="{{ $sintoma->duracao }}"
                    readonly>
            </div>

            <div class="form-group">
                <label for="consulta_id">Consulta relacionada</label>
                <input type="text" class="form-control" id="consulta_id" name='consulta_id'
                    value="{{ $sintoma->consulta->paciente->nome }}" readonly>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('sintoma.index') }}" type="button" class="btn btn-warning">Voltar</a>
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
