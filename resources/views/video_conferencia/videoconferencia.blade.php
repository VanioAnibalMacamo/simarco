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
            <!-- Videoconferência -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Videoconferência</h3>
                </div>
                <div class="card-body" id="meet">
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
            </div>

            <!-- Formulário para salvar consulta -->
            <form action="{{ route('salvarConsulta', $agendamento->id) }}" method="POST">
                @csrf

                <!-- Diagnóstico -->
                <div class="card card-primary mt-4">
                    <div class="card-header">
                        <h3 class="card-title">Diagnóstico</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="diagnostico[descricao]">Descrição do Diagnóstico</label>
                            <textarea name="diagnostico[descricao]" id="descricao" class="form-control" rows="3" placeholder="Digite a descrição..." required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="diagnostico[observacoes]">Observações</label>
                            <textarea name="diagnostico[observacoes]" id="observacoes_diagnostico" class="form-control" rows="3" placeholder="Digite as observações..."></textarea>
                        </div>
                    </div>
                </div>

                <!-- Prescrição -->
                <div class="card card-primary mt-4">
                    <div class="card-header">
                        <h3 class="card-title">Prescrição</h3>
                    </div>
                    <div class="card-body">
                        <label>Medicamentos</label>
                        <div class="row">
                            @foreach ($medicamentos as $medicamento)
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="prescricao[medicamentos][]" value="{{ $medicamento->id }}" id="medicamento_{{ $medicamento->id }}">
                                        <label class="form-check-label" for="medicamento_{{ $medicamento->id }}">
                                            {{ $medicamento->nome_medicamento }}
                                        </label>

                                        <!-- Campo para Dosagem -->
                                        <input type="text" class="form-control mt-2" id="dosagem_{{ $medicamento->id }}" name="prescricao[dosagens][{{ $medicamento->id }}]" placeholder="Dosagem">

                                        <!-- Campo para Instruções -->
                                        <input type="text" class="form-control mt-2" id="instrucoes_{{ $medicamento->id }}" name="prescricao[instrucoes][{{ $medicamento->id }}]" placeholder="Instruções">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <a href="{{ url()->previous() }}" class="btn btn-warning">
                        <i class="fas fa-arrow-left"></i> Voltar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-calendar-check"></i> Salvar Consulta
                    </button>
                </div>
            </form>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Teleconsulta carregada!'); </script>
@stop
