@extends('adminlte::page')

@section('title', 'Editar Medicamento')

@section('content_header')
    <h1>Editar Medicamento</h1>
@stop

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Dados do Medicamento</h3>
        </div>
       
            <form action="{{ route('medicamentos.update', ['id' => $medicamento->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card-body">
                
                    <div class="form-group">
                        <label for="nome_medicamento">Nome do Medicamento</label>
                        <input type="text" class="form-control" id="nome_medicamento" name='nome_medicamento' value="{{ $medicamento->nome_medicamento }}">
                    </div>
                    <div class="row">
                    <div class="form-group col-md-4">
                        <label for="substancias_quimicas">Substâncias Químicas</label>
                        <input type="text" class="form-control" id="substancias_quimicas" name='substancias_quimicas' value="{{ $medicamento->substancias_quimicas }}">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="numero_registo">Número de Registro</label>
                        <input type="text" class="form-control" id="numero_registo" name='numero_registo' value="{{ $medicamento->numero_registo }}">
                    </div>
                

                
                    <div class="form-group col-md-4">
                        <label for="fabricante_id">Fabricante</label>
                        <select class="form-control" id="fabricante_id" name="fabricante_id">
                            <option value="">Selecione um Fabricante</option>
                            @foreach ($fabricantes as $fabricante)
                                <option value="{{ $fabricante->id }}" {{ $fabricante->id == $medicamento->fabricante_id ? 'selected' : '' }}>
                                    {{ $fabricante->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="dosagem">Dosagem</label>
                        <input type="text" class="form-control" id="dosagem" name='dosagem' value="{{ $medicamento->dosagem }}">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="preco">Preço</label>
                        <input type="text" class="form-control" id="preco" name='preco' value="{{ $medicamento->preco }}">
                    </div>
                

               
                    <div class="form-group col-md-4">
                        <label for="data_fabricacao">Data de Fabricação</label>
                        <input type="date" class="form-control" id="data_fabricacao" name='data_fabricacao' value="{{ $medicamento->data_fabricacao }}">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="forma_farmaceutica">Forma Farmacêutica</label>
                        <select class="form-control" id="forma_farmaceutica" name="forma_farmaceutica">
                            <option value="">Selecione a Forma Farmacêutica</option>
                            @foreach ($formasFarmaceuticas as $forma)
                                <option value="{{ $forma->id }}" {{ ($forma->id == $medicamento->forma_farmaceutica_id) ? 'selected' : '' }}>
                                    {{ $forma->descricao }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group col-md-4">
                        <label for="disponibilidade">Disponibilidade</label>
                        <select class="form-control" id="disponibilidade" name="disponibilidade">
                            <option value="">Selecione a Disponibilidade</option>
                            @foreach ($disponibilidades as $disponibilidade)
                                <option value="{{ $disponibilidade }}" {{ $disponibilidade == $medicamento->disponibilidade ? 'selected' : '' }}>
                                    {{ ucfirst($disponibilidade) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="data_validade">Data de Validade</label>
                        <input type="date" class="form-control" id="data_validade" name='data_validade' value="{{ $medicamento->data_validade }}">
                    </div>
                    
                    <div class="form-group col-md-4">
                        <label for="via_administracao">Via de Administração</label>
                        <select class="form-control" id="via_administracao" name="via_administracao">
                            <option value="">Selecione a Via de Administração</option>
                            @foreach ($viasAdministracao as $via)
                                <option value="{{ $via->id }}" {{ $via->id == $medicamento->via_administracao_id ? 'selected' : '' }}>
                                    {{ $via->descricao }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
               
                <!-- Continue organizando os campos restantes como no código anterior -->
                <div class="row">
                    
                
                    <div class="form-group col-md-4">
                        <label for="indicacoes">Indicações</label>
                        <textarea class="form-control" id="indicacoes" name='indicacoes' placeholder="Digite as indicações...">{{ $medicamento->indicacoes }}</textarea>
                    </div>
                
                    <div class="form-group col-md-4">
                        <label for="contraindicacoes">Contraindicações</label>
                        <textarea class="form-control" id="contraindicacoes" name='contraindicacoes' placeholder="Digite as contraindicações...">{{ $medicamento->contraindicacoes }}</textarea>
                    </div>
              
                
                <div class="form-group col-md-4">
                    <label for="efeitos_colaterais">Efeitos Colaterais</label>
                    <textarea class="form-control" id="efeitos_colaterais" name='efeitos_colaterais' placeholder="Digite os efeitos colaterais...">{{ $medicamento->efeitos_colaterais }}</textarea>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-4">
                    <label for="instrucoes_uso">Instruções de Uso</label>
                    <textarea class="form-control" id="instrucoes_uso" name='instrucoes_uso' placeholder="Digite as instruções de uso...">{{ $medicamento->instrucoes_uso }}</textarea>
                </div>

              
                    <div class="form-group col-md-4">
                        <label for="armazenamento">Armazenamento</label>
                        <textarea class="form-control" id="armazenamento" name='armazenamento' placeholder="Digite as instruções de armazenamento...">{{ $medicamento->armazenamento }}</textarea>
                    </div>
                </div>
                
                <div class="row">
                    
                </div>
            </div>

            <div class="card-footer">
                <input type="submit" class="btn btn-primary" value='Salvar'>
                <a href="{{ url('/medicamentoIndex') }}" type="button" class="btn btn-warning">Cancelar</a>
            </div>
        </form>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
