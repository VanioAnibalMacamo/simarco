@extends('adminlte::page')

@section('title', 'Disponibilidades')

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
    <h1>Disponibilidades</h1>
@stop

@section('content')


<div class="card">
    <div class="card-body p-0">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Nome</th>
                    <th>Especialidade</th>
                    <th>Disponibilidade</th>
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
                        <td>{{ ucfirst($medico->disponibilidade)}}</td>
                        <td>
                            <a class="btn btn-primary btn-sm d-inline" href="{{ route('visualizar_disponibilidades', ['id' => $medico->id]) }}"><i class="fas fa-eye"></i></a>
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

@stop
