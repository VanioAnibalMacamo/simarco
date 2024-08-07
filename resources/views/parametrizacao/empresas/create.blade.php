@extends('adminlte::page')

@section('title', 'Cadastrar Empresa')

@section('content_header')
    <h1>Cadastrar Nova Empresa</h1>
@stop

@section('content')
    <!-- General form elements -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Dados da Empresa</h3>
        </div>
        <!-- /.card-header -->
        <!-- Form start -->
        <form action="{{ route('empresas.store') }}" method="POST">
            @csrf

            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Erro!</strong> Existem alguns problemas com os dados inseridos.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nome">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sigla">Sigla</label>
                            <input type="text" class="form-control" id="sigla" name="sigla" placeholder="Sigla">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nuit">NUIT</label>
                            <input type="text" class="form-control" id="nuit" name="nuit" placeholder="NUIT">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="contacto1">Contacto 1</label>
                            <input type="text" class="form-control" id="contacto1" name="contacto1" placeholder="Contacto 1">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="contacto2">Contacto 2</label>
                            <input type="text" class="form-control" id="contacto2" name="contacto2" placeholder="Contacto 2">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="localizacao">Localização</label>
                    <input type="text" class="form-control" id="localizacao" name="localizacao" placeholder="Localização">
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="{{ url('/empresas') }}" type="button" class="btn btn-warning">Cancelar</a>
            </div>
        </form>
    </div>
    <!-- /.card -->
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        console.log('Página de criação de empresa carregada!');
    </script>
@stop
