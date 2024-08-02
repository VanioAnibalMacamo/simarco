@extends('adminlte::page')

@section('title', 'Escolher Horário')

@section('content_header')
    <h1>Escolher Horário para Disponibilidade em {{ $disponibilidade->dia_semana }}</h1>
@stop

@section('content')
    <div class="card card-primary">
        <div class="card-body">
            <form action="{{ route('agendamentos.store') }}" method="POST">
                @csrf
                <input type="hidden" name="disponibilidade_id" value="{{ $disponibilidade->id }}">
                <input type="hidden" name="paciente_id" value="{{ $pacienteId }}">
                <input type="hidden" name="dia" value="{{ $dia }}">

                <div class="row">
                    @if(empty($horarios))
                        <div class="col-md-12">
                            <div class="alert alert-info" role="alert">
                                Não há horários disponíveis para este dia.
                            </div>
                        </div>
                    @else
                        @foreach($horarios as $horario)
                            <div class="col-md-4 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Horário: {{ $horario['start'] }} - {{ $horario['end'] }}</h5>
                                        <!-- Formulário de agendamento -->
                                        <form action="{{ route('agendamentos.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="disponibilidade_id" value="{{ $disponibilidade->id }}">
                                            <input type="hidden" name="paciente_id" value="{{ $pacienteId }}">
                                            <input type="hidden" name="horario" value="{{ $horario['start'] }}">
                                            <br>
                                            <br>
                                            <button type="submit" class="btn btn-primary">Agendar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                <!-- Botão "Voltar" para retornar à página anterior -->
                <a href="javascript:history.back()" class="btn btn-warning">Voltar</a>
            </form>
        </div>
    </div>
@stop

@section('js')
    <script>
        setTimeout(function () {
            document.querySelectorAll('.alert').forEach(function (alert) {
                alert.remove();
            });
        }, 5000);
    </script>
@stop
