@extends('adminlte::page')

@section('title', 'Cadastrar Paciente')

@section('content_header')
    <h1> Cadastrar Paciente</h1>
@stop

@section('content')
    <!-- general form elements -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Dados do Paciente</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="{{ url('savePaciente') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="nome">Nome Completo</label>
                    <input type="text" class="form-control" id="nome" name='nome' placeholder="Digite o nome do Paciente...">
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="data_nascimento">Data de Nascimento</label>
                        <input type="date" class="form-control" id="data_nascimento" name='data_nascimento'>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="genero">Gênero</label>
                        <select class="form-control" id="genero" name="genero">
                            <option value="">Selecione um Gênero</option>
                            @foreach ($generos as $value)
                                <option value="{{ $value }}">{{ ucfirst($value) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="numero_identificacao">Número de Identificação</label>
                        <input type="text" class="form-control" id="numero_identificacao" name='numero_identificacao' placeholder="Ex: 123456789">
                    </div>
                </div>
                <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="endereco">Endereço</label>
                    <input type="text" class="form-control" id="endereco" name='endereco' placeholder="Digite o endereço do Paciente...">
                </div>
                <div class="form-group col-md-4">
                    <label for="telefone">Telefone</label>
                    <input type="text" class="form-control" id="telefone" name='telefone' placeholder="Digite o número de telefone do Paciente...">
                </div>
                <div class="form-group col-md-4">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name='email' placeholder="Digite o email do Paciente...">
                </div>
            </div>

            <hr>
            <div class="row">
            <div class="row">
                    <div class="form-group col-md-6">
                        <label for="empresa_id">Empresa</label>
                        <select class="form-control" id="empresa_id" name="empresa_id">
                            <option value="">Selecione uma Empresa</option>
                            @foreach ($empresas as $empresa)
                                <option value="{{ $empresa->id }}">{{ $empresa->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                <div class="form-group col-md-6">
                    <label for="codigoFuncionario">Código do Funcionário</label>
                    <input type="text" class="form-control" id="codigoFuncionario" name="codigoFuncionario" placeholder="Digite o código do funcionário" value="{{ old('codigoFuncionario') }}">
                </div>
            </div>

                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="cartao_seguro_saude">Cartão de Seguro de Saúde</label>
                        <input type="file" class="form-control-file" id="cartao_seguro_saude" name="cartao_seguro_saude">
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <input type="submit" class="btn btn-primary" value='Salvar'>
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
