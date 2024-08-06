
@extends('adminlte::page')

@section('title', 'Disponibilidades do Médico')

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
    <h1>Disponibilidades do {{ $medico->especialidade->descricao }} {{ $medico->nome }}</h1>
@stop

@section('content')

<div class="d-flex flex-row-reverse align-items-end mb-3">
    <a href="{{ route('disponibilidade.create', ['medico_id' => $medico->id]) }}"
       class="btn btn-primary {{ $todosDiasPreenchidos ? 'disabled' : '' }}">
        <i class="fas fa-plus"></i> Adicionar
    </a>
</div>

<div class="card card-primary">
    <div class="card-body">
        @if ($disponibilidades->isEmpty())
            <div class="alert alert-info">
                Nenhuma disponibilidade para este médico.
            </div>
        @else
            <div class="card card-primary">
                <div class="card-body">
                    <div class="row">
                        @foreach ($disponibilidades as $disponibilidade)
                        <div class="col-md-3 mb-3">
                            <div class="card">
                                <div class="card-body">
                                <h5 class="card-title">Dia da Semana: <strong>{{ $disponibilidade->dia_semana }}</strong></h5>

                                    <br>
                                    <br>
                                    <div class="mt-3">
                                        <a href="{{ route('disponibilidade.edit', ['id' => $disponibilidade->id]) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>
                                        <form action="{{ route('disponibilidade.delete', ['id' => $disponibilidade->id]) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i> Excluir
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
        <div class="col-md-6">
            <a href="{{ url('/disponibilidadeIndex') }}" class="btn btn-warning">Voltar</a>
        </div>
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
