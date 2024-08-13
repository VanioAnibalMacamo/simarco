@extends('adminlte::page')

@section('title', 'Criar Role')

@section('content_header')
    <h1>Criar Role</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('roles.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Nome da Role</label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="permissions">Permissões</label>
                    <div class="row">
                        @foreach($permissions as $permission)
                            <div class="col-md-6 mb-3">@extends('adminlte::page')

                                @section('title', 'Criar Role')

                                @section('content_header')
                                    <h1>Criar Role</h1>
                                @stop

                                @section('content')
                                    <div class="card">
                                        <div class="card-body">
                                            <form action="{{ route('roles.store') }}" method="POST">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="name">Nome da Role</label>
                                                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" required>
                                                    @error('name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label for="permissions">Permissões</label>
                                                    <div class="row">
                                                        @foreach($permissions as $permission)
                                                            <div class="col-md-3 mb-3">
                                                                <div class="form-check">
                                                                    <input
                                                                        type="checkbox"
                                                                        name="permissions[]"
                                                                        value="{{ $permission->id }}"
                                                                        id="permission-{{ $permission->id }}"
                                                                        class="form-check-input">
                                                                    <label class="form-check-label" for="permission-{{ $permission->id }}">
                                                                        <span class="badge badge-primary">
                                                                            {{ $permission->name }}
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary">Criar Role</button>
                                                    <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancelar</a>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @stop

                                @section('css')
                                    <link rel="stylesheet" href="/css/admin_custom.css">
                                    <style>
                                        .form-check {
                                            margin-bottom: 1rem;
                                        }
                                    </style>
                                @stop

                                @section('js')
                                    <script>
                                        // Adicione scripts específicos se necessário
                                    </script>
                                @stop

                                <div class="form-check">
                                    <input
                                        type="checkbox"
                                        name="permissions[]"
                                        value="{{ $permission->id }}"
                                        id="permission-{{ $permission->id }}"
                                        class="form-check-input">
                                    <label class="form-check-label" for="permission-{{ $permission->id }}">
                                        <span class="badge badge-primary">
                                            {{ $permission->name }}
                                        </span>
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Criar</button>
                    <a href="{{ route('roles.index') }}" "btn btn-warning">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <style>
        .form-check {
            margin-bottom: 1rem;
        }
    </style>
@stop

@section('js')
    <script>
        // Adicione scripts específicos se necessário
    </script>
@stop
