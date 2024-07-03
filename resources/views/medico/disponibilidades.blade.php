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
                @if(empty($proximasDisponibilidades))
                    <div class="col-md-12">
                        <div class="alert alert-info" role="alert">
                            O médico não está disponível nos próximos 30 dias.
                        </div>
                    </div>
                @else
                    @foreach($proximasDisponibilidades as $disponibilidade)
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Dia: {{ $disponibilidade->data }}</h5>
                                    <p class="card-text">Horários: {{ $disponibilidade->hora_inicio }} - {{ $disponibilidade->hora_fim }}</p>
                                    <button type="button" class="btn btn-primary">Agendar</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="card-footer text-right">
                <a href="{{ url()->previous() }}" type="button" class="btn btn-warning">Voltar</a>
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
