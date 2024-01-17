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
                <div class="form-group col-md-4">
                <label for="data_prescricao">Data da Prescrição</label>
                <input type="text" class="form-control" id="data_prescricao" name='data_prescricao' value="{{ $prescricao->data_prescricao }}" readonly>
            </div>
            
            <div class="form-group col-md-4">
                <label for="dosagem">Dosagem</label>
                <input type="text" class="form-control" id="dosagem" name='dosagem' value="{{ $prescricao->dosagem }}" readonly>
            </div>
            <div class="form-group col-md-4">
                <label for="consulta_id">Paciente relacionado à Consulta</label>
                <input type="text" class="form-control" id="consulta_id" name='consulta_id' value="{{ $prescricao->consulta->data }} - {{ $prescricao->consulta->paciente->nome }}" readonly>
            </div>
           </div>

            <div class="form-group">
                <label for="observacoes">Observações</label>
                <textarea class="form-control" id="observacoes" name='observacoes' readonly>{{ $prescricao->observacoes }}</textarea>
            </div>

            <div class="form-group">
                <label for="medicamentos">Medicamentos a Tomar</label>
                <textarea class="form-control" id="medicamentos" name='medicamentos' readonly>{{ $prescricao->medicamentos }}</textarea>
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
    <script> console.log('Hi!'); </script>
@stop