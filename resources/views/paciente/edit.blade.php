@extends('adminlte::page')

@section('title', 'Editar Paciente')

@section('content_header')
    <h1>Editar Paciente</h1>
@stop

@section('content')
    <!-- general form elements -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Dados do Paciente</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="{{ route('pacientes.update', ['id' => $paciente->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="form-row">
                <div class="form- col-md-4">
                    <label for="nome">Nome Completo</label>
                    <input type="text" class="form-control" id="nome" name='nome' value="{{ $paciente->nome }}">
                </div>
                <div class="form-group col-md-4">
                    <label for="data_nascimento">Data de Nascimento</label>
                    <input type="date" class="form-control" id="data_nascimento" name='data_nascimento' value="{{ $paciente->data_nascimento }}">
                </div>
                <div class="form-group col-md-4">
                    <label for="genero">Gênero</label>
                    <select class="form-control" id="genero" name="genero">
                        <option value="masculino" {{ $paciente->genero == 'masculino' ? 'selected' : '' }}>Masculino</option>
                        <option value="feminino" {{ $paciente->genero == 'feminino' ? 'selected' : '' }}>Feminino</option>
                        <option value="outro" {{ $paciente->genero == 'outro' ? 'selected' : '' }}>Outro</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="numero_identificacao">Número de Identificação</label>
                    <input type="text" class="form-control" id="numero_identificacao" name='numero_identificacao' value="{{ $paciente->numero_identificacao }}">
                </div>
                <div class="form-group col-md-4">
                    <label for="endereco">Endereço</label>
                    <input type="text" class="form-control" id="endereco" name='endereco' value="{{ $paciente->endereco }}">
                </div>
                <div class="form-group col-md-4">
                    <label for="telefone">Telefone</label>
                    <input type="text" class="form-control" id="telefone" name='telefone' value="{{ $paciente->telefone }}">
                </div>
                <div class="form-group col-md-4">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name='email' value="{{ $paciente->email }}">
                </div>
            </div>
              
            </div>
            <div class="card-footer">
                <input type="submit" class="btn btn-primary" value='Actualizar'>
                <a href="{{ url('/pacienteIndex') }}" type="button" class="btn btn-warning">Cancelar</a>
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
