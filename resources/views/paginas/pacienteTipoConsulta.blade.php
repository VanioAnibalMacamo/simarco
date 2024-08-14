@extends('adminlte::page')

@section('title', 'Cadastrar Paciente')

@section('content_header')
    <h1>Selecione o Tipo de Consulta</h1>
@stop

@section('content')
    <div class="row">

        <div class="col-md-6 d-flex">
            <div class="card flex-fill">
                <div class="card-header bg-success">
                    <h3 class="card-title">Consulta Presencial</h3>
                </div>
                <div class="card-body d-flex flex-column">
                    <p class="flex-grow-1">Marque uma consulta presencial e visite nosso consultório para um atendimento mais detalhado.</p>
                </div>
                <div class="card-footer">
                    <a href="#" class="btn btn-success">Marcar Consulta Presencial</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 d-flex">
            <div class="card flex-fill">
                <div class="card-header bg-primary">
                    <h3 class="card-title">Consulta Online</h3>
                </div>
                <div class="card-body d-flex flex-column">
                    <p class="flex-grow-1">Opte por uma consulta online e receba atendimento no conforto da sua casa.</p>
                </div>
                <div class="card-footer">
                    <!-- Botão para abrir o modal -->
                    <button type="button" class="btn btn-primary" onclick="window.location.href='{{ route('marcar_consulta_especialidades') }}'">
                        Marcar Consulta Online
                    </button>
                </div>
            </div>
        </div>
    </div>


@stop

@section('css')
    <style>
        .card {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .card-body {
            flex-grow: 1;
        }

        .card-title {
            font-size: 1.5rem;
        }

        .btn {
            width: 100%;
        }

        .modal-dialog {
            max-width: 80%;
        }
    </style>
@stop




