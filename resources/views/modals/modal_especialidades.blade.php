<!-- resources/views/modals/modal_especialidades.blade.php -->
<div class="modal fade" id="especialidadesModal" tabindex="-1" role="dialog" aria-labelledby="especialidadesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="especialidadesModalLabel">Selecione a Especialidade</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    @foreach($especialidades as $especialidade)
                        <div class="col-md-4">
                            <div class="card">
                                <img class="card-img-top" src="url_da_imagem_{{ $especialidade->id }}.jpg" alt="{{ $especialidade->descricao }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $especialidade->descricao }}</h5>
                                    <p class="card-text">Preço: {{ $especialidade->preco }}mts</p>
                                    <a href="{{ route('especialidades.medicos', ['id' => $especialidade->id]) }}" class="btn btn-primary">Ver Médicos</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

