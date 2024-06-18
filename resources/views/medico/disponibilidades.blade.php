<!-- resources/views/medicos/disponibilidade.blade.php -->
@extends('adminlte::page')

@section('title', 'Disponibilidade do Médico')

@section('content_header')
    <h1>Disponibilidade do Médico: {{ $medico->nome }}</h1>
@stop

@section('content')
    <div class="card card-primary">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <h5>{{ $medico->nome }}</h5>
                    <p>Especialidade: {{ $medico->especialidade->descricao }}</p>
                </div>
                @foreach($disponibilidades as $disponibilidade)
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Dia: {{ $disponibilidade->data }}</h5>
                                <p class="card-text">Horários: {{ $disponibilidade->horario }}</p>
                                <button type="button" class="btn btn-primary">Agendar</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="card-footer text-right">
                <a href="{{ url('/pacienteTipoConsulta') }}" type="button" class="btn btn-warning">Voltar</a>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Disponibilidade carregada'); </script>
@stop
