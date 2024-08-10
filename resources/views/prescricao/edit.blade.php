@extends('adminlte::page')

@section('title', 'Editar Prescrição Médica')

@section('content_header')
    <h1>Editar Prescrição Médica</h1>
@stop

@section('content')
    <!-- General form elements -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Dados da Prescrição Médica</h3>
        </div>
        <!-- /.card-header -->
        <!-- Form start -->
        <form action="{{ route('prescricoes.update', ['id' => $prescricao->id]) }}" method="POST"
            enctype="multipart/form-data">
            @method('PUT')
            @csrf

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="data_prescricao">Data da Prescrição</label>
                        <input type="date" class="form-control" id="data_prescricao" name='data_prescricao'
                            value="{{ old('data_prescricao', $prescricao->data_prescricao) }}" required>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="consulta_id">Paciente relacionado à Consulta</label>
                        <select class="form-control" id="consulta_id" name="consulta_id" disabled>
                            <option value="">Selecione uma consulta</option>
                            @foreach ($consultas as $consulta)
                                @if ($consulta->paciente)
                                    <option value="{{ $consulta->id }}"
                                        {{ $prescricao->consulta_id == $consulta->id ? 'selected' : '' }}>
                                        {{ $consulta->paciente->nome }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>Medicamentos</label>
                    <div class="row">
                        @foreach ($medicamentos as $medicamento)
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="medicamentos[]"
                                        value="{{ $medicamento->id }}"
                                        {{ in_array($medicamento->id, $prescricao->medicamentos->pluck('id')->toArray()) ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ $medicamento->nome_medicamento }}</label>
                                    <input type="text" class="form-control" id="dosagem_{{ $medicamento->id }}"
                                        name="dosagens[{{ $medicamento->id }}]" placeholder="Dosagem"
                                        value="{{ old('dosagens.' . $medicamento->id, $prescricao->medicamentos->where('id', $medicamento->id)->first() ? $prescricao->medicamentos->where('id', $medicamento->id)->first()->pivot->dosagem : '') }}">
                                    <input type="text" class="form-control mt-2" id="instrucoes_{{ $medicamento->id }}"
                                        name="instrucoes[{{ $medicamento->id }}]" placeholder="Instruções"
                                        value="{{ old('instrucoes.' . $medicamento->id, $prescricao->medicamentos->where('id', $medicamento->id)->first() ? $prescricao->medicamentos->where('id', $medicamento->id)->first()->pivot->instrucoes : '') }}">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

             

            </div>

            <div class="card-footer">
                <input type="submit" class="btn btn-primary" value='Actualizar'>
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
    <script>
        console.log('Hi!');
    </script>
@stop
