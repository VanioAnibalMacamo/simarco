@extends('adminlte::page')

@section('title', 'Cadastrar Prescrição Médica')

@section('content_header')
    <h1>Cadastrar Prescrição Médica</h1>
@stop

@section('content')
    <!-- General form elements -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Dados da Prescrição Médica</h3>
        </div>
        <!-- /.card-header -->
        <!-- Form start -->
        <form action="{{ url('savePrescricao') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-4">
                    <label for="data_prescricao">Data da Prescrição</label>
                    <input type="date" class="form-control" id="data_prescricao" name='data_prescricao' required>
                </div>
                
                <div class="form-group col-md-4">
                    <label for="dosagem">Dosagem</label>
                    <input type="text" class="form-control" id="dosagem" name='dosagem' placeholder="Ex: 500mg, 1 comprimido, etc." required>
                </div>
               
                <div class="form-group col-md-4">
                    <label for="consulta_id">Paciente</label>
                    <select class="form-control" id="consulta_id" name="consulta_id">
                        <option value="">Selecione uma consulta</option>
                        @foreach ($consultas as $consulta)
                            @if ($consulta->paciente)
                                <option value="{{ $consulta->id }}">{{ $consulta->data }} - {{ $consulta->paciente->nome }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="observacoes">Observações</label>
                <textarea  class="form-control h-100" id="observacoes" name='observacoes' placeholder="Digite as observações..."></textarea>
            </div>
                <div class="form-group">
                    <label for="medicamentos">Medicamentos a Tomar</label>
                    <textarea  class="form-control h-100" id="medicamentos" name='medicamentos' placeholder="Digite os medicamentos a tomar..."></textarea>
                </div>
            </div>
            <div class="card-footer">
                <input type="submit" class="btn btn-primary" value='Salvar'>
                <a href="{{ url('/prescricaoIndex') }}" type="button" class="btn btn-warning">Cancelar</a>
            </div>
        </form>
    </div>
    <!-- /.card -->
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
