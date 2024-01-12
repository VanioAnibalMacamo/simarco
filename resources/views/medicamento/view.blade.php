@extends('adminlte::page')

@section('title', 'Visualizar Medicamento')

@section('content_header')
    <h1>Visualizar Medicamento</h1>
@stop

@section('content')
    <!-- general form elements -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Dados do Medicamento</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <div class="card-body">
            <div class="form-group">
                <label for="nome_medicamento">Nome do Medicamento</label>
                <input type="text" class="form-control" id="nome_medicamento" name='nome_medicamento' value="{{ $medicamento->nome_medicamento }}" readonly>
            </div>

            <div class="row">
                <div class="form-group col-md-4">
                    <label for="substancias_quimicas">Substâncias Químicas</label>
                    <input type="text" class="form-control" id="substancias_quimicas" name='substancias_quimicas' value="{{ $medicamento->substancias_quimicas }}" readonly>
                </div>

                <div class="form-group col-md-4">
                    <label for="numero_registo">Número de Registro</label>
                    <input type="text" class="form-control" id="numero_registo" name='numero_registo' value="{{ $medicamento->numero_registo }}" readonly>
                </div>

                <div class="form-group col-md-4">
                    <label for="fabricante">Fabricante</label>
                    <input type="text" class="form-control" id="fabricante" name='fabricante' value="{{ $medicamento->fabricante->nome }}" readonly>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-4">
                    <label for="dosagem">Dosagem</label>
                    <input type="text" class="form-control" id="dosagem" name='dosagem' value="{{ $medicamento->dosagem }}" readonly>
                </div>

                <div class="form-group col-md-4">
                    <label for="preco">Preço</label>
                    <input type="text" class="form-control" id="preco" name='preco' value="{{ $medicamento->preco }}" readonly>
                </div>

                <div class="form-group col-md-4">
                    <label for="data_fabricacao">Data de Fabricação</label>
                    <input type="text" class="form-control" id="data_fabricacao" name='data_fabricacao' value="{{ $medicamento->data_fabricacao }}" readonly>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-4">
                    <label for="forma_farmaceutica">Forma Farmacêutica</label>
                    <input type="text" class="form-control" id="forma_farmaceutica" name='forma_farmaceutica' value="{{ $medicamento->formaFarmaceutica->descricao }}" readonly>
                </div>

                <div class="form-group col-md-4">
                    <label for="disponibilidade">Disponibilidade</label>
                    <input type="text" class="form-control" id="disponibilidade" name='disponibilidade' value="{{ ucfirst($medicamento->disponibilidade) }}" readonly>
                </div>

                <div class="form-group col-md-4">
                    <label for="data_validade">Data de Validade</label>
                    <input type="text" class="form-control" id="data_validade" name='data_validade' value="{{ $medicamento->data_validade }}" readonly>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="via_administracao">Via de Administração</label>
                    <input type="text" class="form-control" id="via_administracao" name="via_administracao" value="{{ optional($medicamento->viaAdministracao)->descricao }}" readonly>
                </div>
            </div>
            
            
            

            <div class="row">
                    
                
                <div class="form-group col-md-4">
                    <label for="indicacoes">Indicações</label>
                    <textarea class="form-control" id="indicacoes" name='indicacoes' readonly>{{ $medicamento->indicacoes }}</textarea>
                </div>
            
                <div class="form-group col-md-4">
                    <label for="contraindicacoes">Contraindicações</label>
                    <textarea class="form-control" id="contraindicacoes" name='contraindicacoes' readonly>{{ $medicamento->contraindicacoes }}</textarea>
                </div>
          
            
            <div class="form-group col-md-4">
                <label for="efeitos_colaterais">Efeitos Colaterais</label>
                <textarea class="form-control" id="efeitos_colaterais" name='efeitos_colaterais' readonly>{{ $medicamento->efeitos_colaterais }}</textarea>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-4">
                <label for="instrucoes_uso">Instruções de Uso</label>
                <textarea class="form-control" id="instrucoes_uso" name='instrucoes_uso' readonly>{{ $medicamento->instrucoes_uso }}</textarea>
            </div>

          
                <div class="form-group col-md-4">
                    <label for="armazenamento">Armazenamento</label>
                    <textarea class="form-control" id="armazenamento" name='armazenamento' readonly>{{ $medicamento->armazenamento }}</textarea>
                </div>
            </div>
            
            <div class="row">
                
            </div>
        
          

            <div class="card-footer">
                <a href="{{ url('/medicamentoIndex') }}" type="button" class="btn btn-warning">Voltar</a>
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
