@extends('adminlte::page')

@section('title', 'Visualizar Prescrição Médica')

@section('content_header')
    <h1>Visualizar Prescrição Médica</h1>
@stop

@section('content')
    <!-- General form elements -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Dados da Prescrição Médica</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="data_prescricao">Data da Prescrição</label>
                    <input type="text" class="form-control" id="data_prescricao" name='data_prescricao'
                        value="{{ $prescricao->data_prescricao }}" readonly>
                </div>

                <div class="form-group col-md-6">
                    <label for="consulta_id">Paciente relacionado à Consulta</label>
                    <input type="text" class="form-control" id="consulta_id" name='consulta_id'
                        value="{{ $prescricao->consulta->paciente->nome }}" readonly>
                </div>

            </div>

           

            <div class="form-group">
                <label for="medicamentos">Medicamentos Prescritos</label>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Comprimido</th>
                            <th>Dosagem</th>
                        <th>Instruções</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($prescricao->medicamentos as $medicamento)
                            <tr>
                                <td>{{ $medicamento->nome_medicamento }}</td>
                                <td>{{ $medicamento->pivot->dosagem }}</td>
                                <td>{{ $medicamento->pivot->instrucoes }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ url('/prescricaoIndex') }}" type="button" class="btn btn-warning">Voltar</a>
        </div>
    </div>
    <!-- /.card -->
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        console.log('Hi!');
    </script>
@stop
