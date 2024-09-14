<main class="mt-3 pt-3">

    <div class="container">
        <div class="left">
        <div class="calendar">
            <div class="month">
                <i class="fa fa-angle-left prev"></i>
                <div class="date"></div>
                <i class="fa fa-angle-right next"></i>
            </div>
            <div class="weekdays">
                <div>Dom</div>
                <div>Seg</div>
                <div>Ter</div>
                <div>Qua</div>
                <div>Qui</div>
                <div>Sex</div>
                <div>Sab</div>
            </div>
            <div class="days">
                <!--sera adicionado com js-->
            </div>
            <div class="goto-today">
                <div class="goto">
                    <input type="text" placeholder="mm/YYYY" class="date-input">
                    <button class="goto-btn">go</button>
                </div>
                <button class="today-btn">Hoje</button>
            </div>
        </div>
    </div>
        <div class="right">
        <div class="today-date">
            <div class="event-day"></div>
            <div class="event-date"></div>
        </div>
        <div class="events"></div>
        <!--we will add events through js-->
        <div class="add-event-wrapper">
            <div class="add-event-header">
                <div class="title">Adicionar Evento</div>
                <i class="fas fa-times close"></i>
            </div>
            
            <div class="add-event-body">
                
                <form id='formEventosAgenda' action='' method='post'>
                    <div class="add-event-input">
                    <input 
                        type="text" 
                        placeholder="Nome do Evento"
                        class="event-name"
                        name='nomeEvento'
                    />
                    </div>
                    <div class="add-event-input">
                        <input 
                            type="text" 
                            placeholder="Inicio do evento"
                            class="event-time-from"
                            name='inicioEvento'
                            id='inicioEvento'
                        />
                    </div>
                    <div class="add-event-input">
                        <input 
                            type="text" 
                            placeholder="Final do evento"
                            class="event-time-to"
                            name='finalEvento'
                            id='finalEvento'
                        />
                    </div>
                </form>
                
            </div>
            
            <div class="add-event-footer">
                <button type='button' class="add-event-btn">Adicionar</button>
            </div>
        </div>
    </div>
        <button class="add-event">
            <i class="fas fa-plus"></i>
        </button>
    </div>
    
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <!--<h5 class="modal-title" id="exampleModalLabel">Modal title</h5>-->
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            <div class="modal-body">
                <form id='formAtualizarEvento'>
                    <div class='row'>
                        <div class='col-12'>
                            <label class='form-label'>Titulo</label>
                            <input class='form-control' type='text' name='titulo'/>
                        </div>
                        <div class='col-6'>
                            <label class='form-label'>Inicio</label>
                            <input class='form-control' type='text' name='inicio'/>
                        </div>
                        <div class='col-6'>
                            <label class='form-label'>Fim</label>
                            <input class='form-control' type='text' name='fim'/>
                        </div>
                        <div class='col-12'>
                            <label class='form-label'>Descrição</label>
                            <textarea class='form-control' type='text' name='descricao'></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
  </div>
    </div>
    
</main>