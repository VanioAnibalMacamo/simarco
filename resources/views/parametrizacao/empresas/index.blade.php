@extends('adminlte::page')

@section('title', 'Empresas')

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
    <h1>Empresas</h1>
@stop

@section('content')

    <div class="d-flex flex-row-reverse align-items-end mb-3">
        <a href="{{ route('empresas.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Criar Nova Empresa
        </a>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Sigla</th>
                        <th>NUIT</th>
                        <th>Email</th>
                        <th>Contacto 1</th>
                        <th>Contacto 2</th>
                        <th>Localização</th>
                        <th style="width: 150px">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($empresas as $empresa)
                        <tr>
                            <td>{{ $empresa->id }}</td>
                            <td>{{ $empresa->nome }}</td>
                            <td>{{ $empresa->sigla }}</td>
                            <td>{{ $empresa->nuit }}</td>
                            <td>{{ $empresa->email }}</td>
                            <td>{{ $empresa->contacto1 }}</td>
                            <td>{{ $empresa->contacto2 }}</td>
                            <td>{{ $empresa->localizacao }}</td>
                            <td>
                                <a class="btn btn-info btn-sm" href="{{ route('empresas.show', $empresa->id) }}">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a class="btn btn-primary btn-sm" href="{{ route('empresas.edit', $empresa->id) }}">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <form id="form-delete-{{ $empresa->id }}"
                                      action="{{ route('empresas.destroy', $empresa->id) }}"
                                      method="POST"
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-danger btn-sm"
                                            onclick="confirmDelete(event, '{{ $empresa->nome }}', {{ $empresa->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $empresas->links('pagination::bootstrap-4') }}
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(event, nome, formId) {
            event.preventDefault();
            Swal.fire({
                title: 'Tem certeza que deseja excluir a empresa ' + nome + '?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sim, excluir!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-delete-' + formId).submit();
                }
            });
        }
    </script>
@stop
