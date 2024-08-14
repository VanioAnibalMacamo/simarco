@extends('adminlte::page')

@section('title', 'Cadastrar Usuário')

@section('content_header')
    <h1>Cadastrar Usuário</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
@stop

@section('content')
    <!-- General form elements -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Dados do Usuário</h3>
        </div>
        <!-- /.card-header -->
        <!-- Form start -->
        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="name">Nome</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="Informe o nome do usuário" required>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="Informe o email do usuário" required>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="role">Função</label>
                        <select name="role" class="form-control" id="role" required>
                            <option value="">Selecione uma função</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label>Tipo</label><br>
                        <div class="form-check">
                            <input type="radio" id="nenhum" name="type" value="nenhum" class="form-check-input" checked>
                            <label for="nenhum" class="form-check-label">Nenhum</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" id="medico" name="type" value="medico" class="form-check-input">
                            <label for="medico" class="form-check-label">Médico</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" id="paciente" name="type" value="paciente" class="form-check-input">
                            <label for="paciente" class="form-check-label">Paciente</label>
                        </div>
                    </div>

                    <!-- Combobox do Médico -->
                    <div class="form-group col-md-6" id="medico-select" style="display: none;">
                        <label for="medico_id">Selecione um Médico</label>
                        <select name="medico_id" class="form-control" id="medico_id">
                            <option value="">Selecione um médico</option>
                            @foreach ($medicos as $medico)
                                <option value="{{ $medico->id }}">{{ $medico->nome }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Combobox do Paciente -->
                    <div class="form-group col-md-6" id="paciente-select" style="display: none;">
                        <label for="paciente_id">Selecione um Paciente</label>
                        <select name="paciente_id" class="form-control" id="paciente_id">
                            <option value="">Selecione um paciente</option>
                            @foreach ($pacientes as $paciente)
                                <option value="{{ $paciente->id }}">{{ $paciente->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Criar Usuário</button>
                <a href="javascript:history.back();" class="btn btn-warning">Cancelar</a>
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
        document.addEventListener('DOMContentLoaded', function() {
            const medicoRadio = document.getElementById('medico');
            const pacienteRadio = document.getElementById('paciente');
            const nenhumRadio = document.getElementById('nenhum');

            const medicoSelect = document.getElementById('medico-select');
            const pacienteSelect = document.getElementById('paciente-select');

            medicoRadio.addEventListener('change', function() {
                medicoSelect.style.display = 'block';
                pacienteSelect.style.display = 'none';
            });

            pacienteRadio.addEventListener('change', function() {
                medicoSelect.style.display = 'none';
                pacienteSelect.style.display = 'block';
            });

            nenhumRadio.addEventListener('change', function() {
                medicoSelect.style.display = 'none';
                pacienteSelect.style.display = 'none';
            });

            // Defina o estado inicial dos comboboxes com base na seleção de rádio inicial
            if (nenhumRadio.checked) {
                medicoSelect.style.display = 'none';
                pacienteSelect.style.display = 'none';
            } else if (medicoRadio.checked) {
                medicoSelect.style.display = 'block';
                pacienteSelect.style.display = 'none';
            } else if (pacienteRadio.checked) {
                medicoSelect.style.display = 'none';
                pacienteSelect.style.display = 'block';
            }
        });
    </script>
@stop
