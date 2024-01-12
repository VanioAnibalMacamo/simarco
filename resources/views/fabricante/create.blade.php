@extends('adminlte::page')

@section('title', 'Cadastrar Fabricante')

@section('content_header')
    <h1>Cadastrar Fabricante</h1>
@stop

@section('content')
    <!-- general form elements -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Dados do Fabricante</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="{{ url('saveFabricante') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                
                    <div class="form-group">
                       
                            <div>
                    <label for="nome">Nome</label>
                    <input type="text" class="form-control" id="nome" name='nome' placeholder="Digite o nome do Fabricante...">
                </div>
            
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="endereco">Endereço</label>
                    <input type="text" class="form-control" id="endereco" name='endereco' placeholder="Digite o endereço do Fabricante...">
                </div>
            
                <div class="form-group col-md-6">
                    <label for="contacto">Contacto</label>
                    <input type="text" class="form-control" id="contacto" name='contacto' placeholder="Digite o contacto do Fabricante...">
                </div>
            </div>
        </div>
            <div class="card-footer">
                <input type="submit" class="btn btn-primary" value='Salvar'>
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
