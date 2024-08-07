@extends('adminlte::page')

@section('title', 'Consulta')

@section('content_header')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('successDelete'))
        <div class="alert alert-danger">{{ session('successDelete') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <h1>Consultas</h1>
@stop

@section('content')
    <!--
        <div class="d-flex flex-row-reverse align-items-end mb-3">
            <a href="{{ url('consultaCreate') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Adicionar
            </a>
        </div>
    -->
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Data e Hora da Consulta</th>
                        <th>Status</th>
                        <th>Medico Responsável</th>
                        <th>Paciente</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($consultas as $consulta)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($consulta->data_consulta)->format('d/m/Y') . ' ' . \Carbon\Carbon::parse($consulta->hora_inicio)->format('H:i') }}</td>
                            @php
                                // Escolher o status dinamicamente com base na presença ou ausência de diagnóstico e prescrição
                                if (isset($consulta->diagnostico) && isset($consulta->prescricao)) {
                                    $statusId = 3;
                                } elseif (isset($consulta->diagnostico)) {
                                    $statusId = 2;
                                } elseif (isset($consulta->prescricao)) {
                                    $statusId = 3;
                                } else {
                                    $statusId = 1;
                                }
                                $statusText = \App\Models\StatusConsulta::find($statusId)->descricao;
                            @endphp
                            <td>{{ $statusText }}</td>
                            <td>{{ $consulta->medico->nome }}</td>
                            <td>{{ $consulta->paciente->nome }}</td>
                            <td>
                                <a class="btn btn-primary btn-sm d-inline" href="{{ url('visualizar_consulta', $consulta->id) }}"><i class="fas fa-eye"></i></a>
                                <a class="btn btn-info btn-sm d-inline" href="{{ url('update_consulta', $consulta->id) }}"><i class="fas fa-pencil-alt"></i></a>
                                <!--
                                    <form id="form-excluir-{{ $consulta->id }}" action="{{ route('consultas.delete', ['id' => $consulta->id]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="confirmDelete(event, '{{ $consulta->numero_identificacao }}', '{{ $consulta->paciente->nome }}', {{ $consulta->id }})"><i class="fas fa-trash"></i></button>
                                    </form>
                                -->
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- Paginação -->
            <div class="d-flex justify-content-center">
                {{ $consultas->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        console.log('Hi!');
    </script>
    <script>
        setTimeout(function() {
            document.querySelector('.alert').remove();
        }, 5000);
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(event, nome, paciente, formId) {
            event.preventDefault();

            Swal.fire({
                title: 'Tem certeza que deseja excluir a consulta do paciente ' + paciente + ' ' + nome + '?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sim, excluir!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-excluir-' + formId).submit();
                }
            });
        }
    </script>
@stop
