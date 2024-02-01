@extends('adminlte::page')

@section('title', 'Cadastrar Sintoma')

@section('content_header')
    <h1>Cadastrar Sintoma</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
@stop

@section('content')
    <!-- General form elements -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Dados do Sintoma</h3>
        </div>
        <!-- /.card-header -->
        <!-- Form start -->
        <form action="{{ route('sintoma.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row">

                    <div class="form-group  col-md-6">
                        <label for="duracao">Duração do Sintoma</label>
                        <input type="text" class="form-control" id="duracao" name='duracao'
                            placeholder="Informe a duração do sintoma" required>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="descricao">Descrição do Sintoma</label>
                        <textarea class="form-control" id="descricao" name='descricao' placeholder="Digite a descrição do sintoma..." required></textarea>
                    </div>


                    <div class="form-group col-md-6">
                        <label for="gravidade_id">Gravidade do Sintoma</label>
                        <select class="form-control" id="gravidade_id" name="gravidade_id" required>
                            <option value="">Selecione a gravidade</option>
                            @foreach ($gravidades as $gravidade)
                                <option value="{{ $gravidade->id }}">{{ $gravidade->descricao }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="consulta_id">Paciente relacionado à Consulta</label>
                        <select class="form-control" id="consulta_id" name="consulta_id">
                            @foreach ($consultas as $consulta)
                                @if ($consulta->paciente)
                                    <option value="{{ $consulta->id }}">
                                        {{ $consulta->paciente->nome }}
                                    </option>
                                @endif
                            @endforeach

                        </select>
                    </div>
                </div>




            </div>

            <div class="card-footer">
                <input type="submit" class="btn btn-primary" value='Salvar'>
                <a href="javascript:history.back();" class="btn btn-warning">Cancelar</a>
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
        console.log('Hi!');
    </script>

    <script>
        setTimeout(function() {
            document.querySelector('.alert').remove();
        }, 5000);
    </script>
@stop
