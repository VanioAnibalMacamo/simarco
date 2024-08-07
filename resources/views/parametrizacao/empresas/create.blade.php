@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Criar Nova Empresa</h1>

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

        <form action="{{ route('empresas.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Nome:</strong>
                        <input type="text" name="nome" class="form-control" placeholder="Nome">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Sigla:</strong>
                        <input type="text" name="sigla" class="form-control" placeholder="Sigla">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>NUIT:</strong>
                        <input type="text" name="nuit" class="form-control" placeholder="NUIT">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Email:</strong>
                        <input type="email" name="email" class="form-control" placeholder="Email">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Contacto 1:</strong>
                        <input type="text" name="contacto1" class="form-control" placeholder="Contacto 1">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Contacto 2:</strong>
                        <input type="text" name="contacto2" class="form-control" placeholder="Contacto 2">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Localização:</strong>
                        <input type="text" name="localizacao" class="form-control" placeholder="Localização">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </div>
            </div>
        </form>
    </div>
@endsection
