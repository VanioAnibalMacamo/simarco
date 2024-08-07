@extends('adminlte::page')

@section('title', 'Visualizar Agendamento')

@section('content_header')
    <h1>Visualizar Consultas</h1>
@stop

@section('content')
    <!-- general form elements -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Detalhes da Consulta</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="paciente_nome">Nome do Paciente</label>
                    <input type="text" class="form-control" id="paciente_nome" name='paciente_nome' value="{{ $agendamento->paciente->nome }}" readonly>
                </div>
                <div class="form-group col-md-6">
                    <label for="status_consulta">Status da Consulta</label>
                    <input type="text" class="form-control" id="status_consulta" name='status_consulta'
                           value="{{ $consulta ? ($prescricao ? 'Prescrita' : ($diagnostico ? 'Diagnosticada' : 'Realizada')) : 'Agendada' }}" readonly>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label for="medico_nome">Nome do Médico</label>
                    <input type="text" class="form-control" id="medico_nome" name='medico_nome' value="{{ $agendamento->disponibilidades[0]->medico->nome }}" readonly>
                </div>
                <div class="form-group col-md-6">
                    <label for="especialidade">Especialidade</label>
                    <input type="text" class="form-control" id="especialidade" name='especialidade' value="{{ $agendamento->disponibilidades[0]->medico->especialidade->descricao ?? 'Não definida' }}" readonly>
                </div>
            </div>

            @if($consulta)
                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="data_consulta">Data da Consulta</label>
                        <input type="text" class="form-control" id="data_consulta" name='data_consulta'
                            value="{{ \Carbon\Carbon::parse($consulta->data_consulta)->format('d/m/Y') }}" readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="hora_inicio">Hora de Início</label>
                        <input type="text" class="form-control" id="hora_inicio" name="hora_inicio"
                            value="{{ \Carbon\Carbon::parse($consulta->hora_inicio)->format('H:i') }}" readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="hora_fim">Hora de Fim</label>
                        <input type="text" class="form-control" id="hora_fim" name="hora_fim"
                            value="{{ \Carbon\Carbon::parse($consulta->hora_fim)->format('H:i') }}" readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="duracao">Duração</label>
                        <input type="text" class="form-control" id="duracao" name='duracao'
                            value="{{ $consulta->duracaoFormatada }}" readonly>
                    </div>
                </div>

                <!-- Novos campos adicionados -->
                <div class="row mt-3">
                    <div class="form-group col-md-4">
                        <label for="formaPagamento">Forma de Pagamento</label>
                        <input type="text" class="form-control" id="formaPagamento" name="formaPagamento"
                            value="{{ $consulta->formaPagamento }}" readonly>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="empresa">Empresa</label>
                        <input type="text" class="form-control" id="empresa" name="empresa"
                            value="{{ $consulta->empresa }}" readonly>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="codigoFuncionario">Código do Funcionário</label>
                        <input type="text" class="form-control" id="codigoFuncionario" name="codigoFuncionario"
                            value="{{ $consulta->codigo_funcionario }}" readonly>
                    </div>
                </div>


                <div class="row mt-3">
                    <div class="form-group col-md-12">
                        <label for="observacoes">Observações</label>
                        <textarea class="form-control h-100" id="observacoes" name='observacoes' readonly>{{ $consulta->observacoes }}</textarea>
                    </div>
                </div>
            @endif

            @if ($diagnostico)
                <!-- Seção para exibir diagnósticos -->
                <div class="row mt-4">
                    <div class="form-group col-md-12">
                        <label for="descricao">Diagnósticos relacionados a consulta</label>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Descrição do Diagnóstico</th>
                                    <th>Observações do Diagnóstico</th>
                                    <th>Data do Diagnóstico</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $diagnostico->descricao }}</td>
                                    <td>{{ $diagnostico->observacoes }}</td>
                                    <td>{{ \Carbon\Carbon::parse($diagnostico->data_diagnostico)->format('d/m/Y') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            @if ($prescricao)
                <!-- Seção para exibir prescrição -->
                <div class="row mt-4">
                    <div class="form-group col-md-12">
                        <label for="medicamentos">Medicamentos Prescritos</label>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Comprimido</th>
                                    <th>Dosagem</th>
                                    <th>Data da Prescrição</th>
                                    <th>Observações da Prescrição</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($prescricao->medicamentos as $medicamento)
                                    <tr>
                                        <td>{{ $medicamento->nome_medicamento }}</td>
                                        <td>{{ $medicamento->pivot->dosagem }}</td>
                                        <td>{{ \Carbon\Carbon::parse($prescricao->data_prescricao)->format('d/m/Y') }}</td>
                                        <td>{{ $prescricao->observacoes }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
        <div class="card-footer">
            <a href="{{ route('agendamentosMarcados') }}" type="button" class="btn btn-warning">Voltar</a>
            <!--
            <a href="{{ route('videoconferencia', $agendamento->id) }}" type="button" class="btn btn-primary">Teleconsulta</a>
            -->
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
