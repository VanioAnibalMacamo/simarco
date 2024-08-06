@extends('adminlte::page')

@section('title', 'Editar Disponibilidade')

@section('content_header')
@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif
@if (session('successDelete'))
    <div class="alert alert-danger">{{ session('successDelete') }}</div>
@endif
<h1>Editar Disponibilidade</h1>
@stop

@section('content')
<div class="card card-primary">
    <div class="card-body">
        <form action="{{ route('disponibilidade.update', $disponibilidade->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group row">
                <div class="col-md-6">
                    <label for="dia_semana">Dia da Semana:</label>
                    <select name="dia_semana" id="dia_semana" class="form-control">
                        <option value="" disabled>Selecione o dia da semana</option>
                        <option value="Segunda" {{ $disponibilidade->dia_semana == 'Segunda' ? 'selected' : '' }}>Segunda</option>
                        <option value="Terça" {{ $disponibilidade->dia_semana == 'Terça' ? 'selected' : '' }}>Terça</option>
                        <option value="Quarta" {{ $disponibilidade->dia_semana == 'Quarta' ? 'selected' : '' }}>Quarta</option>
                        <option value="Quinta" {{ $disponibilidade->dia_semana == 'Quinta' ? 'selected' : '' }}>Quinta</option>
                        <option value="Sexta" {{ $disponibilidade->dia_semana == 'Sexta' ? 'selected' : '' }}>Sexta</option>
                    </select>

                    <div class="form-group mt-3">
                        <label for="medico_id">Médico:</label>
                        <strong>
                            <p>{{ $medico->nome }}</p>
                        </strong>
                        <input type="hidden" name="medico_id_hidden" value="{{ $medico->id }}">
                    </div>

                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                        <a href="{{ route('disponibilidade.create', ['medico_id' => $medico->id]) }}" class="btn btn-warning">Voltar</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script> console.log('Formulário de edição carregado'); </script>
@stop
