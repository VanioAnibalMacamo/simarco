@extends('adminlte::page')

@section('title', 'Cadastrar Consulta')

@section('content_header')
    <h1>Cadastrar Consulta</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('successDelete'))
        <div class="alert alert-danger">{{ session('successDelete') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
@stop

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Dados da Consulta</h3>
        </div>
        <form id="consultaForm" action="{{ url('saveConsulta') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="id_medico">Médico Responsável</label>
                        <select class="form-control" id="id_medico" name="id_medico" {{ old('id_medico', $medico_id) ? 'disabled' : '' }}>
                            <option value="">Selecione um médico</option>
                            @foreach ($medicos as $medico)
                                <option value="{{ $medico->id }}" {{ $medico->id == old('id_medico', $medico_id) ? 'selected' : '' }}>
                                    {{ $medico->nome }}
                                </option>
                            @endforeach
                        </select>
                        <input type="hidden" name="id_medico" value="{{ old('id_medico', $medico_id) }}">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="id_paciente">Paciente</label>
                        <select class="form-control" id="id_paciente" name="id_paciente" {{ old('id_paciente', $paciente_id) ? 'disabled' : '' }}>
                            <option value="">Selecione um paciente</option>
                            @foreach ($pacientes as $paciente)
                                <option value="{{ $paciente->id }}" {{ $paciente->id == old('id_paciente', $paciente_id) ? 'selected' : '' }}>
                                    {{ $paciente->nome }}
                                </option>
                            @endforeach
                        </select>
                        <input type="hidden" name="id_paciente" value="{{ old('id_paciente', $paciente_id) }}">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="data_consulta">Data da Consulta</label>
                        <input type="text" class="form-control" id="data_consulta" name="data_consulta" value="{{ old('data_consulta', $data_consulta) }}" {{ old('data_consulta', $data_consulta) ? 'readonly' : '' }}>
                        @if (old('data_consulta', $data_consulta))
                            <input type="hidden" name="data_consulta" value="{{ old('data_consulta', $data_consulta) }}">
                        @endif
                    </div>
                    <div class="form-group col-md-4">
                        <label for="hora_inicio">Hora de Início</label>
                        <input type="time" class="form-control" id="hora_inicio" name="hora_inicio" value="{{ old('hora_inicio', $hora_inicio) }}" {{ old('hora_inicio', $hora_inicio) ? 'readonly' : '' }}>
                        @if (old('hora_inicio', $hora_inicio))
                            <input type="hidden" name="hora_inicio" value="{{ old('hora_inicio', $hora_inicio) }}">
                        @endif
                    </div>
                    <div class="form-group col-md-4">
                        <label for="hora_fim">Hora de Fim</label>
                        <input type="time" class="form-control" id="hora_fim" name="hora_fim" value="{{ old('hora_fim', $hora_fim) }}" {{ old('hora_fim', $hora_fim) ? 'readonly' : '' }}>
                        @if (old('hora_fim', $hora_fim))
                            <input type="hidden" name="hora_fim" value="{{ old('hora_fim', $hora_fim) }}">
                        @endif
                    </div>
                </div>

             

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="foto_1">Foto 1 (opcional)</label>
                        <input type="file" class="form-control" id="foto_1" name="foto_1">
                        <div id="foto_1_preview" class="mt-2"></div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="foto_2">Foto 2 (opcional)</label>
                        <input type="file" class="form-control" id="foto_2" name="foto_2">
                        <div id="foto_2_preview" class="mt-2"></div>
                    </div>
                </div>
                <div class="row">
                   

                <!-- Campos ocultos para dados desativados -->
                <input type="hidden" id="hidden_data_consulta" name="hidden_data_consulta" value="{{ old('hidden_data_consulta') }}">
                <input type="hidden" id="hidden_hora_inicio" name="hidden_hora_inicio" value="{{ old('hidden_hora_inicio') }}">
                <input type="hidden" id="hidden_hora_fim" name="hidden_hora_fim" value="{{ old('hidden_hora_fim') }}">
                <input type="hidden" id="hidden_id_paciente" name="hidden_id_paciente" value="{{ old('hidden_id_paciente') }}">
                <input type="hidden" id="hidden_id_medico" name="hidden_id_medico" value="{{ old('hidden_id_medico') }}">
                <input type="hidden" name="agendamento_id" value="{{ $agendamento_id }}">

            </div>
            <div class="card-footer">
                <input type="submit" class="btn btn-primary" value='Salvar'>
                <a href="{{ url('/consultaIndex') }}" type="button" class="btn btn-warning">Cancelar</a>
            </div>
        </form>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
 
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Preencher campos a partir da URL (já existente)
        const urlParams = new URLSearchParams(window.location.search);
        const pacienteId = urlParams.get('paciente_id');
        const medicoId = urlParams.get('medico_id');
        const dataConsulta = urlParams.get('data_consulta');
        const horaInicio = urlParams.get('hora_inicio');

        if (pacienteId && medicoId && dataConsulta && horaInicio) {
            document.getElementById('data_consulta').value = dataConsulta;
            document.getElementById('hora_inicio').value = horaInicio;

            const [hora, minuto] = horaInicio.split(':').map(Number);
            const horaInicioObj = new Date();
            horaInicioObj.setHours(hora, minuto, 0, 0);
            const horaFimObj = new Date(horaInicioObj.getTime() + 30 * 60 * 1000);
            const horaFim = `${horaFimObj.getHours().toString().padStart(2, '0')}:${horaFimObj.getMinutes().toString().padStart(2, '0')}`;

            document.getElementById('hora_fim').value = horaFim;
            document.getElementById('id_paciente').value = pacienteId;
            document.getElementById('id_medico').value = medicoId;

            document.getElementById('hidden_data_consulta').value = dataConsulta;
            document.getElementById('hidden_hora_inicio').value = horaInicio;
            document.getElementById('hidden_hora_fim').value = horaFim;
            document.getElementById('hidden_id_paciente').value = pacienteId;
            document.getElementById('hidden_id_medico').value = medicoId;

            document.getElementById('data_consulta').disabled = true;
            document.getElementById('hora_inicio').disabled = true;
            document.getElementById('hora_fim').disabled = true;
            document.getElementById('id_paciente').disabled = true;
            document.getElementById('id_medico').disabled = true;
        }

        // Função para mostrar pré-visualizações das imagens
        function previewFile(inputId, previewId) {
            const fileInput = document.getElementById(inputId);
            const previewContainer = document.getElementById(previewId);
            
            fileInput.addEventListener('change', function(event) {
                const files = event.target.files;
                previewContainer.innerHTML = ''; // Limpa pré-visualização existente

                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.style.width = '100px'; // Ajuste o tamanho conforme necessário
                        img.style.height = '100px'; // Ajuste o tamanho conforme necessário
                        img.style.marginRight = '10px';
                        previewContainer.appendChild(img);
                    };

                    reader.readAsDataURL(file);
                }
            });
        }

        // Inicializa pré-visualização para os campos de foto
        previewFile('foto_1', 'foto_1_preview');
        previewFile('foto_2', 'foto_2_preview');
    });
</script>

@stop
