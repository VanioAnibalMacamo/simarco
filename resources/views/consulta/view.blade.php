@extends('adminlte::page')

@section('title', 'Visualizar Consulta')

@section('content_header')
    <h1>Visualizar Consulta</h1>
@stop

@section('content')
    <!-- General form elements -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Dados da Consulta</h3>
        </div>
        <!-- /.card-header -->
        <!-- Form start -->
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="data_consulta">Data da Consulta</label>
                    <input type="text" class="form-control" id="data_consulta" name='data_consulta'
                        value="{{ $consulta->data_consulta }}" readonly>
                </div>
                <div class="form-group col-md-4">
                    <label for="hora_inicio">Hora de Início</label>
                    <input type="text" class="form-control" id="hora_inicio" name="hora_inicio"
                        value="{{ $consulta->hora_inicio }}" readonly>
                </div>
                <div class="form-group col-md-4">
                    <label for="hora_fim">Hora de Fim</label>
                    <input type="text" class="form-control" id="hora_fim" name="hora_fim"
                        value="{{ $consulta->hora_fim }}" readonly>
                </div>
                <div class="form-group col-md-4">
                    <label for="duracao">Duração</label>
                    <input type="text" class="form-control" id="duracao" name='duracao'
                        value="{{ $consulta->duracaoFormatada }}" readonly>
                </div>
                <div class="form-group col-md-4">
                    <label for="id_paciente">Paciente</label>
                    <input type="text" class="form-control" value="{{ $consulta->paciente->nome }}" readonly>
                </div>

                <div class="form-group col-md-4">
                    <label for="id_medico">Médico Responsável</label>
                    <input type="text" class="form-control" value="{{ $consulta->medico->nome }}" readonly>

                </div>



                <div class="form-group col-md-4">
                    <label for="id_status">Status da Consulta</label>
                    <input type="text" class="form-control" id="id_status" name='id_status'
                        value="{{ $consulta->statusConsulta->descricao }}" readonly>
                </div>

                <div class="form-group col-md-8">
                    <label for="observacoes">Observações</label>
                    <textarea class="form-control h-100" id="observacoes" name='observacoes' readonly>{{ $consulta->observacoes }}</textarea>
                </div>

            </div>
            <div class="espacamento" style="margin-top: 30px"></div>


            @if (isset($diagnostico))
                <!-- Seção para exibir diagnósticos -->
                <div class="form-group">
                    <label for="descricao">Diagnósticos relacionados a consulta</label>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Descrição do Diagnóstico</th>
                                <th>Observações do Diagnóstico</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $diagnostico->descricao }}</td>
                                <td>{{ $diagnostico->observacoes }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @endif


            @if ($prescricao)
                <!-- Seção para exibir prescrição -->
                <div class="form-group mt-10">
                    <label for="medicamentos">Medicamentos Prescritos</label>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Comprimido</th>
                                <th>Dosagem</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($prescricao->medicamentos as $medicamento)
                                <tr>
                                    <td>{{ $medicamento->nome_medicamento }}</td>
                                    <td>{{ $medicamento->pivot->dosagem }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

        </div>
        <div class="card-footer">
            <a href="{{ url('/consultaIndex') }}" type="button" class="btn btn-warning">Voltar</a>
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
