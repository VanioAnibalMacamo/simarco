@extends('adminlte::page')

@section('title', 'Medico')

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
    <h1>Medicos</h1>
@stop

@section('content')

<div class="d-flex flex-row-reverse align-items-end mb-3">
    <a href="{{ url('medicoCreate') }}" class="btn btn-primary">
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
                    <th>Especialidade</th>
                    <th>Número de Identificação</th>
                    <th>Disponibilidade</th> 
                    <th>Gênero</th> 
                    
                </tr>
            </thead>
            <tbody>
                @php
                    $count = 0;
                @endphp

                @foreach ($medicos as $medico)
                    @php
                        $count++;
                    @endphp
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $medico->nome }}</td>
                        <td>{{ $medico->especialidade->descricao }}</td>
                        <td>{{ $medico->numero_identificacao }}</td> 
                        <td>{{ $medico->disponibilidade }}</td> 
                        <td>{{ $medico->genero }}</td> 
                       
                        <td>
                            <a class="btn btn-primary btn-sm d-inline" href="{{ url('visualizar_medico', $medico->id) }}"><i class="fas fa-eye"></i></a>
                            <a class="btn btn-info btn-sm d-inline" href="{{ url('update_medico', $medico->id) }}"><i class="fas fa-pencil-alt"></i></a>

                            <form id="form-excluir-{{ $medico->id }}" action="{{ route('medicos.delete', ['id' => $medico->id]) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="confirmDelete(event, '{{ $medico->nome }}', {{ $medico->id }})"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach

                @if ($count > 1)
                    {{ $medicos->links('pagination::bootstrap-4') }}
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
