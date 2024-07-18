@extends('adminlte::page')

@section('title', 'Médicos')

@section('content_header')
    <h1>Médicos</h1>
@stop

@section('content')
    <div class="card card-primary">
        <div class="card-body">
            <div class="row">
                @forelse($medicos as $medico)
                    <div class="col-md-4">
                        <div class="card">
                        @php
                        $imagemMedico = $medico->imagem ? asset('images/medicos/' . $medico->imagem) : asset('images/medicos/medico.jpg');
                        @endphp
                        
                        <img class="card-img-top" src="{{ $imagemMedico }}" alt="{{ $medico->nome }}" style="max-width: 200px;">

                            <div class="card-body">
                                <h5 class="card-title">{{ $medico->nome }}</h5>
                                <p class="card-text">Especialidade: {{ $medico->especialidade->descricao }}</p>
                                <a href="{{ route('medicos.disponibilidade', ['id' => $medico->id]) }}" class="btn btn-primary">Ver Disponibilidade</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-md-12">
                        <p>Não há médicos disponíveis no momento.</p>
                    </div>
                @endforelse
            </div>
            <div class="card-footer text-right">
                <button type="button" class="btn btn-warning" onclick="window.history.back();">Voltar</button>
            </div>
        </div>
    </div>

    @isset($disponibilidades)
        <div class="card card-secondary mt-3">
            <div class="card-header">
                <h3 class="card-title">Disponibilidade do Médico: {{ $medico->nome }}</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($disponibilidades as $disponibilidade)
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Dia: {{ $disponibilidade->data }}</h5>
                                    <p class="card-text">Horários: {{ $disponibilidade->horario }}</p>
                                    <button type="button" class="btn btn-primary">Agendar</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="card-footer text-right">
                <button type="button" class="btn btn-secondary" onclick="window.history.back();">Fechar</button>
            </div>
        </div>
    @endisset
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
