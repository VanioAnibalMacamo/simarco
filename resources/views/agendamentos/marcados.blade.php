@extends('adminlte::page')

@section('title', 'Consultas Agendadas')

@section('content_header')
@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif
<h1>Consultas Agendadas</h1>
@stop

@section('content')
<div class="d-flex flex-row-reverse align-items-end mb-3">
    <a href="{{ route('medico.especialidades') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Adicionar
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Paciente</th>
                    <th>Médico</th>
                    <th>Especialidade</th>
                    <th>Data</th>
                    <th>Hora</th>

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
                                                        @endphp
                                                        <tr>
                                                            <td>{{ $count }}</td>
                                                            <td>{{ $agendamento->paciente->nome }}</td>
                                                            <td>{{ $disponibilidade->medico->nome }}</td>
                                                            <td>{{ $disponibilidade->medico->especialidade->descricao ?? 'Não definida' }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($agendamento->dia)->format('d/m/Y') }}</td>

                                                            <td>{{ \Carbon\Carbon::createFromFormat('H:i:s', $agendamento->horario)->format('H:i') }}</td>
                                           
                                                            <td>
                                                                <!-- Ícone de visualizar detalhes com margem à direita -->
                                                                <a class="btn btn-success btn-sm d-inline mr-2" href="{{ route('agendamentos.show', $agendamento->id) }}" title="Visualizar Detalhes">
        <i class="fas fa-eye"></i>
    </a>

                                                                <!-- Ícone de iniciar videoconferência com cor verde -->
                                                                <a class="btn btn-primary btn-sm d-inline" href="{{ route('videoconferencia') }}"
                                                                    title="Iniciar Videoconferência">
                                                                    <i class="fas fa-video"></i>
                                                                </a>
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
@stop

@section('js')
<script> console.log('Tabela de Agendamentos Carregada!'); </script>
@stop