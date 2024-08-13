@extends('adminlte::page')

@section('title', 'Permissões')

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
    <h1>Permissões</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body p-0">
            <!--
                <a href="{{ route('permissions.create') }}" class="btn btn-primary mb-3">Adicionar Permissão</a>
            -->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <!--
                            <th>Ações</th>
                        -->
                    </tr>
                </thead>
                <tbody>
                    @foreach ($permissions as $permission)
                        <tr>
                            <td>{{ $permission->id }}</td>
                            <td>
                                <span class="badge badge-primary">{{ $permission->name }}</span>
                            </td>
                            <!--
                                <td>
                                    <a href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-info btn-sm"><i class="fas fa-pencil-alt"></i> Editar</a>

                                    <form id="form-delete-{{ $permission->id }}" action="{{ route('permissions.destroy', $permission->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="confirmDelete(event, '{{ $permission->name }}', {{ $permission->id }})"><i class="fas fa-trash"></i> Excluir</button>
                                    </form>
                                </td>
                            -->
                        </tr>
                    @endforeach

                    @if ($permissions->count())
                        {{ $permissions->links('pagination::bootstrap-4') }}
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        setTimeout(function() {
            document.querySelector('.alert').remove();
        }, 5000);

        function confirmDelete(event, permissionName, permissionId) {
            event.preventDefault();

            Swal.fire({
                title: 'Tem certeza que deseja excluir a permissão ' + permissionName + '?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sim, excluir!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-delete-' + permissionId).submit();
                }
            });
        }
    </script>
@stop
