@extends('adminlte::page')

@section('title', 'Cadastrar Medico')

@section('content_header')
    <h1> Cadastrar Medico</h1>
@stop

@section('content')
    <!-- general form elements -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Dados do Medico</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="{{ url('saveMedico') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="nome">Nome Completo</label>
                    <input type="text" class="form-control" id="nome" name='nome' placeholder="Digite o nome do Medico...">
                </div>
                <div class="form-row">
                    
                    <div class="form-group col-md-4">
                        <label for="especialidade_id">Especialidade</label>
                        <select class="form-control" id="especialidade_id" name="especialidade_id">
                            <option value="">Selecione uma Especialidade</option>
                            @foreach($especialidades as $especialidade)
                                <option value="{{ $especialidade->id }}">{{ $especialidade->descricao }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    
                    <div class="form-group col-md-4">
                        <label for="numero_identificacao">Número de Identificação</label>
                        <input type="text" class="form-control" id="numero_identificacao" name='numero_identificacao' placeholder="Ex: 123456789">
                    </div>
                </div>
                <div class="form-group">
                    <label for="endereco">Disponibilidade</label>
                    <input type="text" class="form-control" id="endereco" name='endereco' placeholder="Disponibilidade">
                </div>
               
            </div>
            <div class="card-footer">
                <input type="submit" class="btn btn-primary" value='Salvar'>
                <a href="{{ url('/medicoIndex') }}" type="button" class="btn btn-warning">Cancelar</a>
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
