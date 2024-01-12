@extends('adminlte::page')

@section('title', 'Editar Fabricante')

@section('content_header')
    <h1>Editar Fabricante</h1>
@stop

@section('content')
    <!-- general form elements -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Dados do Fabricante</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="{{ route('fabricantes.update', ['id' => $fabricante->id]) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card-body">
                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input type="text" class="form-control" id="nome" name='nome' value="{{ $fabricante->nome }}">
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                    <label for="endereco">Endereço</label>
                    <input type="text" class="form-control" id="endereco" name='endereco' value="{{ $fabricante->endereco }}">
                </div>
                <div class="form-group col-md-6">
                    <label for="contacto">Contacto</label>
                    <input type="text" class="form-control" id="contacto" name='contacto' value="{{ $fabricante->contacto }}">
                </div>
            </div>
        </div>
            <div class="card-footer">
                <input type="submit" class="btn btn-primary" value='Atualizar'>
                <a href="{{ url('/fabricanteIndex') }}" type="button" class="btn btn-warning">Cancelar</a>
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
