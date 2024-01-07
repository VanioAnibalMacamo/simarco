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

<div class="d-flex flex-row-reverse align-items-end mb-3">
    <a href="{{ url('consultaCreate') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Adicionar
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Data_consulta</th>
                    <th>Duracao</th>
                    <th>Status Consulta</th>
                    <th>observacoes</th> 
                    <th>Número de Identificação</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $count = 0;
                @endphp

                @foreach ($consultas as $consulta)
                    @php
                        $count++;
                    @endphp
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $consulta->data_consulta }}</td>
                        <td>{{ $consulta->duracao }}</td>
                        <td>{{ $consulta->statusConsulta->descricao }}</td>
                        <td>{{ $consulta->observacoes }}</td> 
                        <td>{{ $consulta->numero_identificacao }}</td> 
                        <td>
                            <a class="btn btn-primary btn-sm d-inline" href="{{ url('visualizar_consulta', $consulta->id) }}"><i class="fas fa-eye"></i></a>
                            <a class="btn btn-info btn-sm d-inline" href="{{ url('update_consulta', $consulta->id) }}"><i class="fas fa-pencil-alt"></i></a>

                            <form id="form-excluir-{{ $consulta->id }}" action="{{ route('consultas.delete', ['id' => $consulta->id]) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="confirmDelete(event, '{{ $consulta->numero_identificacao }}', {{ $consulta->id }})"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach

                @if ($count > 1)
                    {{ $consultas->links('pagination::bootstrap-4') }}
                @endif
            </tbody>
        </table>
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
                title: 'Tem certeza que deseja excluir a consulta ' + nome + '?',
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
