@extends('adminlte::page')

@section('title', 'Cadastrar Diagnóstico')

@section('content_header')
    <h1>Cadastrar Diagnóstico</h1>
@stop

@section('content')
    <!-- general form elements -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Dados do Diagnóstico</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="{{ url('saveDiagnostico') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="data_diagnostico">Data do Diagnóstico</label>
                        <input type="date" class="form-control" id="data_diagnostico" name='data_diagnostico'>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="consulta_id">Paciente relacionado à Consulta</label>
                            <!-- Esse input apenas tem a função de guardar o id da consulta,
                                por isso está com hidden porque o utilizador nao deve ver isso.
                            -->
                            <input type="text" class="form-control" id="consulta_id" name="consulta_id" value="{{ $consulta->id }}" hidden>

                            <select class="form-control" id="consulta_id" name="consulta_id" disabled>
                                    @if ($consulta->paciente)
                                        <option value="{{ $consulta->id }}">
                                          {{ $consulta->paciente->nome }}
                                        </option>
                                    @endif
                            </select>

                    </div>



                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="descricao">Descrição</label>
                        <textarea class="form-control h-100" id="descricao" name='descricao' placeholder="Digite a descrição do diagnóstico..."></textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="observacoes">Observações</label>
                        <textarea class="form-control h-100" id="observacoes" name='observacoes' placeholder="Digite as observações do diagnóstico..."></textarea>
                    </div>

                </div>
               </div>
            <div class="card-footer">
                <input type="submit" class="btn btn-primary" value='Salvar'>
                <a href="javascript:history.back();" class="btn btn-warning">Cancelar</a>
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

    <script>
        // Obtém a referência do elemento de input pelo ID
        var inputDate = document.getElementById('data_diagnostico');

        // Obtém a data atual
        var hoje = new Date();

        // Formata a data no formato YYYY-MM-DD
        var dataFormatada = hoje.toISOString().split('T')[0];

        // Define a data atual como valor padrão
        inputDate.value = dataFormatada;
    </script>
@stop
