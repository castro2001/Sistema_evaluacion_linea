<!-- BARRA DE PROGRESO -->
<div class="container">
<div class="mx-auto w-50">


    <div class="mt-5 progress">
      <div id="progressbar" class="progress-bar" role="progressbar" aria-label="Basic example" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
    </div>

    <div class="p-3 mt-4 mb-5 rounded shadow bg-body">
    <!-- PREGUNTAS -->
          <section class="" data-preguntas="<?=$link ?>">
          <span class="mb-2 text-danger fs-4">Preguntas - <b> <?=str_replace('-',' ',ucwords($link) ) ?></b></span>
          
           <div class="mt-2" id="question-container"></div>
          </section>
        
          
    </div>

<!-- BUTTONS CONTROL -->
<div class="d-flex justify-content-around">
              <button   class=" btn btn-outline-dark" id="prevButton" disabled>
                <i class="fa fa-angle-left" aria-hidden="true"></i>
              </button>
          <div id="countdown-container">
            
          </div>
             
              
              <button  class=" btn btn-outline-dark" id="nextButton" disabled>
                <i class="fa fa-angle-right" aria-hidden="true"></i>
              </button>
          </div>



</div>

<!-- MODAL -->



</div>



<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Deseas Finalizar?</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Recuerda que una vez finalizado no podrás cambiar ninguna de las
        respuestas</p>
        <form method="post" id="formulario_preguntas" class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrars</button>
          <button type="submit" class="btn btn-primary">Finalizar</button>
        </form>


      </div>
    </div>
  </div>
</div>



