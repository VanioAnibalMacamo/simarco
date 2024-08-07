@extends('adminlte::page')

@section('title', 'Visualizar Empresa')

@section('content_header')
    <h1>Visualizar Empresa</h1>
@stop

@section('content')
    <!-- general form elements -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Dados da Empresa</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <div class="card-body">
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" value="{{ $empresa->nome }}" readonly>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="sigla">Sigla</label>
                    <input type="text" class="form-control" id="sigla" name="sigla" value="{{ $empresa->sigla }}" readonly>
                </div>
                <div class="form-group col-md-6">
                    <label for="nuit">NUIT</label>
                    <input type="text" class="form-control" id="nuit" name="nuit" value="{{ $empresa->nuit }}" readonly>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ $empresa->email }}" readonly>
                </div>
                <div class="form-group col-md-6">
                    <label for="contacto1">Contacto 1</label>
                    <input type="text" class="form-control" id="contacto1" name="contacto1" value="{{ $empresa->contacto1 }}" readonly>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="contacto2">Contacto 2</label>
                    <input type="text" class="form-control" id="contacto2" name="contacto2" value="{{ $empresa->contacto2 }}" readonly>
                </div>
                <div class="form-group col-md-6">
                    <label for="localizacao">Localização</label>
                    <input type="text" class="form-control" id="localizacao" name="localizacao" value="{{ $empresa->localizacao }}" readonly>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ url('/empresas') }}" type="button" class="btn btn-warning">Voltar</a>
        </div>
    </div>
    <!-- /.card -->
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Página de visualização de empresa carregada!'); </script>
@stop
