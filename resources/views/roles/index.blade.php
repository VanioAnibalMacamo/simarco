@extends('adminlte::page')

@section('title', 'Roles')

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
    <h1>Roles</h1>
@stop

@section('content')
<div class="d-flex flex-row-reverse align-items-end mb-3">
    <a href="{{ route('roles.create') }}" class="btn btn-primary mb-3">Adicionar</a>
</div>
    <div class="card">
        <div class="card-body p-0">

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Permissões</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                        <tr>
                            <td>{{ $role->id }}</td>
                            <td>{{ $role->name }}</td>
                            <td>
                                @if($role->permissions->isNotEmpty())
                                    @foreach($role->permissions as $permission)
                                        <span class="badge bg-primary">{{ $permission->name }}</span>
                                    @endforeach
                                @else
                                    <span class="badge bg-danger">Nenhuma permissão</span>
                                @endif
                            </td>
                            <td>
                               <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-info btn-sm"><i class="fas fa-pencil-alt"></i></a>

                                @if($role->name !== 'admin')
                                    <form id="form-delete-{{ $role->id }}" action="{{ route('roles.destroy', $role->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="confirmDelete(event, '{{ $role->name }}', {{ $role->id }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @else
                                    <button class="btn btn-danger btn-sm" disabled title="A role admin não pode ser excluída">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                @endif
                            </td>

                        </tr>
                    @endforeach

                    @if ($roles->count())
                        {{ $roles->links('pagination::bootstrap-4') }}
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

        function confirmDelete(event, roleName, roleId) {
            event.preventDefault();

            Swal.fire({
                title: 'Tem certeza que deseja excluir a role ' + roleName + '?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sim, excluir!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-delete-' + roleId).submit();
                }
            });
        }
    </script>
@stop
