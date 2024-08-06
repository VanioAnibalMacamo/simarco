@extends('adminlte::page')

@section('title', 'Teleconsulta')

@section('content_header')

@stop

@section('content')
    <!-- Informações da Teleconsulta -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Teleconsulta</h3>
        </div>
        <div class="card-body" id="meet">
            <div class="row">
                <div class="col-md-6">
                    <ul class="list-group">
                        <li class="list-group-item"><strong>Paciente:</strong> {{ $agendamento->paciente->nome }}</li>
                        <li class="list-group-item"><strong>Especialidade:</strong> {{ $agendamento->disponibilidades[0]->medico->especialidade->descricao ?? 'Não definida' }}</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <ul class="list-group">
                        <li class="list-group-item"><strong>Médico:</strong> {{ $agendamento->disponibilidades[0]->medico->nome }}</li>
                        <li class="list-group-item">
                            <strong>Dia:</strong> {{ \Carbon\Carbon::parse($agendamento->dia)->format('d/m/Y') }}
                            <strong>Hora:</strong> {{ \Carbon\Carbon::createFromFormat('H:i:s', $agendamento->horario)->format('H:i') }}
                        </li>
                    </ul>
                </div>
            </div>
           <br>

            <script src="https://meet.jit.si/external_api.js"></script>
            <script>
                const domain = 'meet.jit.si';
                const options = {
                    roomName: 'Teleconsulta',
                    width: '100%',
                    height: 500,
                    parentNode: document.querySelector('#meet')
                };
                const api = new JitsiMeetExternalAPI(domain, options);
            </script>
        </div>
        <div class="card-footer">
            <a href="{{ url()->previous() }}" class="btn btn-warning">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>
    </div>

@stop


@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
