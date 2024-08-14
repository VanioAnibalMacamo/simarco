@extends('adminlte::page')

@section('title', 'Consultas Agendadas')

@section('content_header')
<h1>Consultas</h1>
    @if (session('success'))
         <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
@stop

@section('content')

<div class="d-flex flex-row-reverse align-items-end mb-3">
    <a href="{{ route('marcar_consulta_especialidades') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Agendar
    </a>
</div>

<div class="mb-3">
    <input type="text" id="searchInput" class="form-control border-primary" placeholder="Pesquisar...">
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-striped" id="agendamentosTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Paciente</th>
                    <th>Médico</th>
                    <th>Especialidade</th>
                    <th>Data</th>
                    <th>Estado</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @php
                $count = 0;
                @endphp

                @foreach($agendamentos as $agendamento)
                    @foreach($agendamento->disponibilidades as $disponibilidade)
                        @php
                            $count++;
                            $consulta = $agendamento->consulta;
                            $prescricao = $consulta ? $consulta->prescricao : null;
                            $diagnostico = $consulta ? $consulta->diagnostico : null;

                            if ($prescricao) {
                                $estado = 'Prescrita';
                                $estadoClass = 'bg-info'; // Cor para Prescrita
                            } elseif ($diagnostico) {
                                $estado = 'Diagnosticada';
                                $estadoClass = 'bg-primary'; // Cor para Diagnosticada
                            } elseif ($consulta) {
                                $estado = 'Realizada';
                                $estadoClass = 'bg-success'; // Cor para Realizada
                            } else {
                                $estado = 'Agendada';
                                $estadoClass = 'bg-warning'; // Cor para Agendada
                            }
                        @endphp
                        <tr>
                            <td>{{ $count }}</td>
                            <td>{{ $agendamento->paciente->nome }}</td>
                            <td>{{ $disponibilidade->medico->nome }}</td>
                            <td>{{ $disponibilidade->medico->especialidade->descricao ?? 'Não definida' }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($agendamento->dia)->format('d/m/Y') }}
                                {{ \Carbon\Carbon::parse($agendamento->horario)->format('H:i') }}
                            </td>
                            <td>
                                <!-- Estado da consulta -->
                                <span class="badge {{ $estadoClass }}">{{ $estado }}</span>
                            </td>
                            <td class="actions">
                                <a class="btn btn-success btn-sm d-inline mr-2" href="{{ route('agendamentos.show', $agendamento->id) }}" title="Visualizar Detalhes"><i class="fas fa-eye"></i></a>

                                @if ($estado === 'Agendada')
                                    @can('start consultas')
                                        <a class="btn btn-primary btn-sm d-inline" href="{{ route('videoconferencia', $agendamento->id) }}" title="Iniciar teleconsulta"><i class="fas fa-video"></i></a>
                                    @elseif (auth()->user()->id === $disponibilidade->medico->id || auth()->user()->id === $agendamento->paciente->id)
                                        <a class="btn btn-primary btn-sm d-inline" href="{{ route('videoconferencia', $agendamento->id) }}" title="Iniciar teleconsulta"><i class="fas fa-video"></i></a>
                                    @endif
                                @endif

                                @if ($consulta)
                                    @if ($prescricao)
                                        @if (!$diagnostico)
                                            <a class="btn btn-info btn-sm d-inline" href="{{ route('diagnosticoCreate', ['consultaId' => $consulta->id]) }}" title="Diagnosticar"><i class="fas fa-stethoscope"></i></a>
                                        @endif
                                    @else
                                        @if ($diagnostico)
                                            <a class="btn btn-secondary btn-sm d-inline" href="{{ route('prescricaoCreate', ['consultaId' => $consulta->id]) }}" title="Prescrever"><i class="fas fa-prescription-bottle-alt"></i></a>
                                        @else
                                            <a class="btn btn-info btn-sm d-inline" href="{{ route('diagnosticoCreate', ['consultaId' => $consulta->id]) }}" title="Diagnosticar"><i class="fas fa-stethoscope"></i></a>
                                        @endif
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @endforeach

            </tbody>
        </table>

        @if ($agendamentos->hasPages())
            <div class="pagination-wrapper d-flex justify-content-center mt-3">
                {{ $agendamentos->links('pagination::bootstrap-4') }}
            </div>
        @endif

    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
<style>
    .actions .btn {
        display: none;
    }
    tr:hover .actions .btn {
        display: inline-block;
    }
    #searchInput {
        border-color: #007bff; /* Borda azul */
    }
</style>
@stop

@section('js')
<script>
    console.log('Tabela de Agendamentos Carregada!');

    // Função para filtrar a tabela
    document.getElementById('searchInput').addEventListener('input', function() {
        var query = this.value.toLowerCase();
        var rows = document.querySelectorAll('#agendamentosTable tbody tr');

        rows.forEach(function(row) {
            var text = row.innerText.toLowerCase();
            row.style.display = text.includes(query) ? '' : 'none';
        });
    });

    setTimeout(function() {
        document.querySelector('.alert').remove();
    }, 5000);
</script>
@stop
