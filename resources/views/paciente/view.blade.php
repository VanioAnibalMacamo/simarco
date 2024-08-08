@extends('adminlte::page')

@section('title', 'Visualizar Paciente')

@section('content_header')
    <h1>Visualizar Paciente</h1>
@stop

@section('content')
    <!-- general form elements -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Dados do Paciente</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <div class="card-body">
            <div class="form-group">
                <label for="nome">Nome Completo</label>
                <input type="text" class="form-control" id="nome" name='nome' value="{{ $paciente->nome }}" readonly>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="data_nascimento">Data de Nascimento</label>
                    <input type="text" class="form-control" id="data_nascimento" name='data_nascimento' value="{{ $paciente->data_nascimento }}" readonly>
                </div>
                <div class="form-group col-md-4">
                    <label for="genero">Gênero</label>
                    <input type="text" class="form-control" id="genero" name="genero" value="{{ $paciente->genero }}" readonly>
                </div>
                <div class="form-group col-md-4">
                    <label for="numero_identificacao">Número de Identificação</label>
                    <input type="text" class="form-control" id="numero_identificacao" name='numero_identificacao' value="{{ $paciente->numero_identificacao }}" readonly>
                </div>
                <div class="form-group col-md-4">
                    <label for="endereco">Endereço</label>
                    <input type="text" class="form-control" id="endereco" name='endereco' value="{{ $paciente->endereco }}" readonly>
                </div>
                <div class="form-group col-md-4">
                    <label for="telefone">Telefone</label>
                    <input type="text" class="form-control" id="telefone" name='telefone' value="{{ $paciente->telefone }}" readonly>
                </div>
                <div class="form-group col-md-4">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name='email' value="{{ $paciente->email }}" readonly>
                </div>
                <div class="form-group col-md-4">
                    <label for="empresa_id">Empresa</label>
                    <input type="text" class="form-control" id="empresa_id" name="empresa_id" value="{{ $paciente->empresa ? $paciente->empresa->nome : 'Não especificado' }}" readonly>
                </div>
                <div class="form-group col-md-4">
                    <label for="codigoFuncionario">Código do Funcionário</label>
                    <input type="text" class="form-control" id="codigoFuncionario" name="codigoFuncionario" value="{{ $paciente->codigo_funcionario }}" readonly>
                </div>
                <div class="form-group col-md-4">
                    <label for="cartao_seguro_saude">Cartão de Seguro de Saúde</label>
                    @if ($paciente->cartao_seguro_saude)
                        @php
                            $fileName = pathinfo($paciente->cartao_seguro_saude, PATHINFO_FILENAME);
                            $fileNameDisplay = strlen($fileName) > 40 ? substr($fileName, 0, 40) . '...' : $fileName;
                        @endphp
                        <div class="mt-2">
                            <a href="{{ route('paciente.downloadCartao', $paciente->id) }}" class="btn btn-primary">
                                {{ $fileNameDisplay }}
                            </a>
                        </div>
                    @else
                        <div class="mt-2">
                            <span class="badge badge-danger">
                                Nenhum cartão de seguro de saúde disponível.
                            </span>
                        </div>
                    @endif
                </div>

            </div>
        </div>
        <div class="card-footer">
            <a href="{{ url('/pacienteIndex') }}" type="button" class="btn btn-warning">Voltar</a>
        </div>
    </div>
    <!-- /.card -->
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
