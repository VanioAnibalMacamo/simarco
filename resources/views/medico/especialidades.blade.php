@extends('adminlte::page')

@section('title', 'Especialidades dos Médicos')

@section('content_header')
    <h1>Especialidades dos Médicos</h1>
@stop

@section('content')
    <div class="card card-primary">
        <div class="card-body">
            <div class="row">
                @forelse($especialidades as $especialidade)
                    <div class="col-md-4">
                        <div class="card">
                            <img class="card-img-top" src="{{ asset('images/medicos/especialidades.jpg') }}" alt="{{ $especialidade->descricao }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $especialidade->descricao }}</h5>
                                <p class="card-text">Preço: {{ $especialidade->preco }}mts</p>
                                <a href="{{ route('medico.medicos', ['idEspecialidade' => $especialidade->id]) }}" class="btn btn-primary {{ $especialidade->medicos->isEmpty() ? 'disabled' : '' }}">
                                    Ver Médicos
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-md-12">
                        <p>Não há especialidades disponíveis no momento.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    <div class="card-footer text-right">
        <a href="{{ url('/pacienteTipoConsulta') }}" type="button" class="btn btn-warning">Voltar</a>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
