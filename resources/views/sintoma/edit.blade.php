@extends('adminlte::page')

@section('title', 'Editar Sintoma')

@section('content_header')
    <h1>Editar Sintoma</h1>
@stop

@section('content')
    <!-- General form elements -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Dados do Sintoma</h3>
        </div>
        <!-- /.card-header -->
        <!-- Form start -->
        <form action="{{ route('sintoma.update', ['id' => $sintoma->id]) }}" method="POST" enctype="multipart/form-data">
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
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="descricao">Descrição do Sintoma</label>
                        <textarea class="form-control" id="descricao" name='descricao' required>{{ $sintoma->descricao }}</textarea>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="gravidade_id">Gravidade do Sintoma</label>
                        <select class="form-control" id="gravidade_id" name="gravidade_id" required>
                            <option value="">Selecione a gravidade</option>
                            @foreach ($gravidades as $gravidade)
                                <option value="{{ $gravidade->id }}"
                                    {{ $sintoma->gravidade_id == $gravidade->id ? 'selected' : '' }}>
                                    {{ $gravidade->descricao }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="duracao">Duração do Sintoma</label>
                        <input type="text" class="form-control" id="duracao" name='duracao'
                            value="{{ $sintoma->duracao }}" required>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="consulta_id">Paciente relacionado à Consulta</label>
                        <select class="form-control" id="consulta_id" name="consulta_id">
                            @foreach ($consultas as $consulta)
                                @if ($consulta->paciente)
                                    <option value="{{ $consulta->id }}"
                                        {{ $sintoma->consulta_id == $consulta->id ? 'selected' : '' }}>
                                        {{ $consulta->paciente->nome }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <input type="submit" class="btn btn-primary" value='Atualizar'>
                <a href="{{ route('sintoma.index') }}" type="button" class="btn btn-warning">Cancelar</a>
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
@stop
