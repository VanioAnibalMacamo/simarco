@extends('adminlte::page')

@section('title', 'Editar Empresa')

@section('content_header')
    <h1>Editar Empresa</h1>
@stop

@section('content')
    <!-- general form elements -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Dados da Empresa</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="{{ route('empresas.update', ['empresa' => $empresa->id]) }}" method="POST">
            @csrf
            @method('PUT')
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
                            <input type="text" class="form-control" id="nome" name="nome" value="{{ $empresa->nome }}" placeholder="Nome">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sigla">Sigla</label>
                            <input type="text" class="form-control" id="sigla" name="sigla" value="{{ $empresa->sigla }}" placeholder="Sigla">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nuit">NUIT</label>
                            <input type="text" class="form-control" id="nuit" name="nuit" value="{{ $empresa->nuit }}" placeholder="NUIT">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $empresa->email }}" placeholder="Email">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="contacto1">Contacto 1</label>
                            <input type="text" class="form-control" id="contacto1" name="contacto1" value="{{ $empresa->contacto1 }}" placeholder="Contacto 1">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="contacto2">Contacto 2</label>
                            <input type="text" class="form-control" id="contacto2" name="contacto2" value="{{ $empresa->contacto2 }}" placeholder="Contacto 2">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="localizacao">Localização</label>
                    <input type="text" class="form-control" id="localizacao" name="localizacao" value="{{ $empresa->localizacao }}" placeholder="Localização">
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <input type="submit" class="btn btn-primary" value="Atualizar">
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
    <script> console.log('Página de edição de empresa carregada!'); </script>
@stop
