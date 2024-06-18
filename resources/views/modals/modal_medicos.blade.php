<!-- resources/views/modals/modal_medicos.blade.php -->
<div class="modal fade" id="medicosModal" tabindex="-1" role="dialog" aria-labelledby="medicosModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="medicosModalLabel">Selecione o Médico</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Card de Médico 1 -->
                    <div class="col-md-4">
                        <div class="card">
                            <img class="card-img-top" src="url_do_medico_1.jpg" alt="Médico 1">
                            <div class="card-body">
                                <h5 class="card-title">Dr. Nome Médico 1</h5>
                                <p class="card-text">Especialidade: Especialidade 1</p>
                                <p class="card-text">Preço: $100</p>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#disponibilidadeModal" data-medico-nome="Dr. Nome Médico 1" data-especialidade="Especialidade 1" data-dismiss="modal">Ver Disponibilidade</button>
                            </div>
                        </div>
                    </div>
                    <!-- Card de Médico 2 -->
                    <div class="col-md-4">
                        <div class="card">
                            <img class="card-img-top" src="url_do_medico_2.jpg" alt="Médico 2">
                            <div class="card-body">
                                <h5 class="card-title">Dr. Nome Médico 2</h5>
                                <p class="card-text">Especialidade: Especialidade 2</p>
                                <p class="card-text">Preço: $150</p>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#disponibilidadeModal" data-medico-nome="Dr. Nome Médico 2" data-especialidade="Especialidade 2" data-dismiss="modal">Ver Disponibilidade</button>
                            </div>
                        </div>
                    </div>
                    <!-- Adicione mais cards conforme necessário -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
