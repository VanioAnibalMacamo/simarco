@extends('adminlte::page')

@section('title', 'Diagnósticos')

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
    <h1>Diagnósticos</h1>
@stop

@section('content')
    <div class="d-flex flex-row-reverse align-items-end mb-3">
        <a href="{{ url('diagnosticoCreate') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Adicionar
        </a>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Data do Diagnóstico</th>
                        <th>Paciente Diagnosticado</th>
                        <th>Descrição</th>
                       
                        
                        <!-- Add more columns as necessary -->
                    </tr>
                </thead>
                <tbody>
                    @php
                        $count = 0;
                    @endphp

                    @foreach ($diagnosticos as $diagnostico)
                        @php
                            $count++;
                        @endphp
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $diagnostico->data_diagnostico }}</td>
                            <td>{{ $diagnostico->consulta->paciente->nome }}</td>
                            <td>{{ $diagnostico->descricao }}</td>
                            
                           
                            <!-- Add more cells as necessary -->
                            <td>
                                <a class="btn btn-primary btn-sm d-inline" href="{{ url('visualizar_diagnostico', $diagnostico->id) }}"><i class="fas fa-eye"></i></a>
                                <a class="btn btn-info btn-sm d-inline" href="{{ url('update_diagnostico', $diagnostico->id) }}"><i class="fas fa-pencil-alt"></i></a>

                                <form id="form-excluir-{{ $diagnostico->id }}" action="{{ route('diagnosticos.delete', ['id' => $diagnostico->id]) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="confirmDelete(event, '{{ $diagnostico->descricao }}', {{ $diagnostico->id }})"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                    @if ($count > 1)
                        {{ $diagnosticos->links('pagination::bootstrap-4') }}
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
       function confirmDelete(event, formId) {
            event.preventDefault();

            Swal.fire({
                title: 'Tem certeza que deseja excluir o diagnóstico  do paciente"' + '"?',
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
