@extends('adminlte::page')

@section('title', 'Criar Disponibilidade')

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
<h1>Criar Nova Disponibilidade</h1>
@stop

@section('content')
<div class="card card-primary">
    <div class="card-body">
        <form action="{{ route('disponibilidade.store') }}" method="POST">
            @csrf

            <div class="form-group row">
                <div class="col-md-6">
                    <label for="dia_semana">Dia da Semana:</label>
                    <select name="dia_semana" id="dia_semana" class="form-control">
                        <option value="" disabled selected>Selecione o dia da semana</option>
                        <option value="Segunda">Segunda</option>
                        <option value="Terça">Terça</option>
                        <option value="Quarta">Quarta</option>
                        <option value="Quinta">Quinta</option>
                        <option value="Sexta">Sexta</option>
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
                        <a href="{{ route('disponibilidade.create', ['medico_id' => $medico_id]) }}"
                            class="btn btn-warning">Voltar</a>
                    </div>
                </div>
                <!--
                    <div class="col-md-6">
                    <label for="hora_inicio">Hora de Início:</label>
                    <input type="time" id="hora_inicio" name="hora_inicio" class="form-control">
                </div>
            </div>
-->
                <!--
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="hora_fim">Hora de Fim:</label>
                    <input type="time" id="hora_fim" name="hora_fim" class="form-control">
                </div>

                <div class="col-md-6">
                    <label for="estado">Estado:</label>
                    <select name="estado" id="estado" class="form-control">
                        <option value="Activa">Activa</option>
                        <option value="Inactiva">Inactiva</option>
                    </select>
                </div>
            </div>
-->



        </form>
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script> console.log('Formulário carregado'); </script>
@stop