@extends('adminlte::page')

@section('title', 'Disponibilidade do Médico')

@section('content_header')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <h1>Disponibilidade do Médico {{ $medico->especialidade->descricao }}: {{ $medico->nome }}</h1>
@stop

@section('content')
    <div class="card card-primary">
        <div class="card-body">
            <!-- Combobox de Pacientes -->
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="paciente">Selecionar Paciente:</label>
                        <select class="form-control" id="paciente">
                            <option value="" disabled selected>Selecione o paciente</option>
                            @foreach($pacientes as $paciente)
                                <option value="{{ $paciente->id }}">{{ $paciente->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
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
                                    <p class="card-text"></p>
                                    <!-- Formulário de redirecionamento para escolher horários -->
                                    <form action="{{ route('horarios.index', ['disponibilidade' => $disponibilidade->id]) }}" method="GET" class="availability-form">
                                        @csrf
                                        <input type="hidden" name="paciente_id" id="paciente_id" value="">
                                        <input type="hidden" name="disponibilidade_id" value="{{ $disponibilidade->id }}">
                                        <input type="hidden" name="dia" value="{{ $disponibilidade->data }}">
                                        <button type="submit" class="btn btn-success agendar-btn">Selecionar</button>
                                    </form>
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

@section('js')
    <script>
        $(document).ready(function() {
            $('#paciente').change(function() {
                var selectedPacienteId = $(this).val();
                $('#paciente_id').val(selectedPacienteId);
            });
        });

        setTimeout(function() {
            document.querySelectorAll('.alert').forEach(function (alert) {
                alert.remove();
            });
        }, 5000);
    </script>
@stop
