@extends('adminlte::page')

@section('title', 'Visualizar Agendamento')

@section('content_header')
    <h1>Visualizar Agendamento</h1>
@stop

@section('content')
    <!-- general form elements -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Detalhes do Agendamento</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <div class="card-body">
            <div class="form-group">
                <label for="paciente_nome">Nome do Paciente</label>
                <input type="text" class="form-control" id="paciente_nome" name='paciente_nome' value="{{ $agendamento->paciente->nome }}" readonly>
            </div>
            <div class="form-group">
                <label for="medico_nome">Nome do Médico</label>
                <input type="text" class="form-control" id="medico_nome" name='medico_nome' value="{{ $agendamento->disponibilidades[0]->medico->nome }}" readonly>
            </div>
            <div class="form-group">
                <label for="especialidade">Especialidade</label>
                <input type="text" class="form-control" id="especialidade" name='especialidade' value="{{ $agendamento->disponibilidades[0]->medico->especialidade->descricao ?? 'Não definida' }}" readonly>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="data">Data</label>
                    <input type="text" class="form-control" id="data" name='data' value="{{ \Carbon\Carbon::parse($agendamento->dia)->format('d/m/Y') }}" readonly>
                </div>
                <div class="form-group col-md-6">
                    <label for="hora">Hora</label>
                    <input type="text" class="form-control" id="hora" name='hora' value="{{ \Carbon\Carbon::createFromFormat('H:i:s', $agendamento->horario)->format('H:i') }}" readonly>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('agendamentosMarcados') }}" type="button" class="btn btn-warning">Voltar</a>
            <a  href="{{ route('videoconferencia', $agendamento->id) }}" type="button" class="btn btn-primary">Teleconsulta</a>
        </div>

    </div>
    <!-- /.card -->
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Visualizar Agendamento Carregado!'); </script>
@stop
