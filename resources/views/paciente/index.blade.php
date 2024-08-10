@extends('adminlte::page')

@section('title', 'Paciente')

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
    <h1>Pacientes</h1>
@stop

@section('content')

<div class="d-flex flex-row-reverse align-items-end mb-3">
    <a href="{{ url('pacienteCreate') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Adicionar
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Nome</th>
                    <th>Data Nascimento</th>
                    <th>Genero</th>
                    <th>Telefone</th>
                    <th>Empresa</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $count = 0;
                @endphp

                @foreach ($pacientes as $paciente)
                    @php
                        $count++;
                    @endphp
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $paciente->nome }}</td>
                        <td>{{ $paciente->data_nascimento }}</td>
                        <td>{{ ucfirst($paciente->genero) }}</td>
                        <td>{{ $paciente->telefone }}</td>
                        <td>
                            @if ($paciente->empresa)
                                <span class="badge badge-success">
                                     {{ $paciente->empresa->nome }}
                                </span>
                            @else
                                <span class="badge badge-danger">Não registrada</span>
                            @endif
                        </td>
                        <td>
                            <a class="btn btn-primary btn-sm d-inline" href="{{ url('visualizar_paciente', $paciente->id) }}"><i class="fas fa-eye"></i></a>
                            <a class="btn btn-info btn-sm d-inline" href="{{ url('update_paciente', $paciente->id) }}"><i class="fas fa-pencil-alt"></i></a>

                            <form id="form-excluir-{{ $paciente->id }}" action="{{ route('pacientes.delete', ['id' => $paciente->id]) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="confirmDelete(event, '{{ $paciente->nome }}', {{ $paciente->id }})"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Paginação -->
        @if ($pacientes->hasPages())
            <div class="d-flex justify-content-center">
                {{ $pacientes->links('pagination::bootstrap-4') }}
            </div>
        @endif
    </div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
    <script>
        setTimeout(function() {
            document.querySelector('.alert').remove();
        }, 5000);
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(event, nome, formId) {
            event.preventDefault();

            Swal.fire({
                title: 'Tem certeza que deseja excluir o Paciente ' + nome + '?',
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
