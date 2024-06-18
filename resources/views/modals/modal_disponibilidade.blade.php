<!-- resources/views/modals/modal_disponibilidade.blade.php -->
<div class="modal fade" id="disponibilidadeModal" tabindex="-1" role="dialog" aria-labelledby="disponibilidadeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="disponibilidadeModalLabel">Disponibilidade do Médico</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <h5 id="medicoNome"></h5>
                        <p id="medicoEspecialidade"></p>
                    </div>
                    <!-- Card de Disponibilidade 1 -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Dia: 01/01/2024</h5>
                                <p class="card-text">Horários: 10:00 - 12:00</p>
                                <button type="button" class="btn btn-primary">Agendar</button>
                            </div>
                        </div>
                    </div>
                    <!-- Card de Disponibilidade 2 -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Dia: 02/01/2024</h5>
                                <p class="card-text">Horários: 14:00 - 16:00</p>
                                <button type="button" class="btn btn-primary">Agendar</button>
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
