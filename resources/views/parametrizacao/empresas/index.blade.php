@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Empresas</h1>
        <a href="{{ route('empresas.create') }}" class="btn btn-primary">Criar Nova Empresa</a>

        @if ($message = Session::get('success'))
            <div class="alert alert-success mt-2">
                {{ $message }}
            </div>
        @endif

        <table class="table table-bordered mt-2">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Sigla</th>
                <th>NUIT</th>
                <th>Email</th>
                <th>Contacto 1</th>
                <th>Contacto 2</th>
                <th>Localização</th>
                <th width="280px">Ações</th>
            </tr>
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
                        <form action="{{ route('empresas.destroy',$empresa->id) }}" method="POST">
                            <a class="btn btn-info" href="{{ route('empresas.show',$empresa->id) }}">Mostrar</a>
                            <a class="btn btn-primary" href="{{ route('empresas.edit',$empresa->id) }}">Editar</a>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Deletar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
