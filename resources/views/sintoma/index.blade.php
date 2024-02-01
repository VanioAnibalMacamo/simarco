@extends('adminlte::page')

@section('title', 'Sintomas')

@section('content_header')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if (session('successDelete'))
        <div class="alert alert-danger">{{ session('successDelete') }}</div>
    @endif
    <h1>Sintomas</h1>
@stop

@section('content')

    <div class="d-flex flex-row-reverse align-items-end mb-3">
        <a href="{{ route('sintoma.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Adicionar
        </a>
    </div>


    <div class="card">
        <div class="card-body p-0">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Data da Consulta</th>
                        <th>Nome do Paciente</th>
                        <th>Gravidade</th>
                        <th>Duração</th>


                    </tr>
                </thead>
                <tbody>
                    @php
                        $count = 0;
                    @endphp

                    @foreach ($sintomas as $sintoma)
                        @php
                            $count++;
                        @endphp
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $sintoma->consulta->data_consulta }}</td>
                            <td>{{ $sintoma->consulta->paciente->nome }}</td>
                            <td>{{ $sintoma->gravidade->descricao }}</td>
                            <td>{{ $sintoma->duracao }}</td>

                            <td>
                                <a class="btn btn-primary btn-sm d-inline mr-1"
                                    href="{{ route('sintoma.show', ['id' => $sintoma->id]) }}">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <a class="btn btn-info btn-sm d-inline mr-1"
                                    href="{{ route('sintoma.edit', ['id' => $sintoma->id]) }}">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>

                                <form id="form-excluir-sintoma-{{ $sintoma->id }}"
                                    action="{{ route('sintoma.delete', ['id' => $sintoma->id]) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="confirmDeleteSintoma(event, '{{ $sintoma->descricao }}', {{ $sintoma->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>


                        </tr>
                    @endforeach

                    @if ($count > 1)
                        {{ $sintomas->links('pagination::bootstrap-4') }}
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
        function confirmDeleteSintoma(event, descricaoSintoma, formId) {
            event.preventDefault();

            Swal.fire({
                title: 'Tem certeza que deseja excluir o sintoma "' + descricaoSintoma + '"?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sim, excluir!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-excluir-sintoma-' + formId).submit();
                }
            });
        }
    </script>
@stop
