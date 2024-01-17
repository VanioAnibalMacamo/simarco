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
                    <div class="form-group col-md-5">
                        <label for="data_diagnostico">Data do Diagnóstico</label>
                        <input type="date" class="form-control" id="data_diagnostico" name='data_diagnostico'>
                    </div>
                     
                    <div class="form-group col-md-5">
                        <label for="consulta_id">Paciente relacionado à Consulta</label>
                        <select class="form-control" id="consulta_id" name="consulta_id">
                            <option value="">Selecione uma consulta</option>
                            @foreach ($consultas as $consulta)
                                @if ($consulta->paciente)
                                    <option value="{{ $consulta->id }}">{{ $consulta->data }} - {{ $consulta->paciente->nome }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="form-group col-md-5">
                        <label for="descricao">Descrição</label>
                        <textarea class="form-control h-100" id="descricao" name='descricao' placeholder="Digite a descrição do diagnóstico..."></textarea>
                    </div>
                    <div class="form-group col-md-5">
                        <label for="observacoes">Observações</label>
                        <textarea class="form-control h-100" id="observacoes" name='observacoes' placeholder="Digite as observações do diagnóstico..."></textarea>
                    </div>

                </div>
               </div>
            <div class="card-footer">
                <input type="submit" class="btn btn-primary" value='Salvar'>
                <a href="{{ url('/diagnosticoIndex') }}" type="button" class="btn btn-warning">Cancelar</a>
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
