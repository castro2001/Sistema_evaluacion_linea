
<section class="container">
    

<div class="p-3 mt-4 mb-5 rounded shadow bg-body">
    <!-- PREGUNTAS -->
          <section class="" data-preguntas="<?=$link ?>">
          <h1 class="mt-2 text-danger">Test de Conocimiento Resultado</h1>
          
           <div class="mt-2" id="question-container">

              <code class="mx-5 fs-4">calificacion de: <?= $score ?>/<?=$total?></code>
              <?php foreach($questions as $answer):?>
           <ul class="mb-5 list-group" >
               <li class="list-group-item">
                  <h4 class="py-2 text-danger"><?=$answer['question'] ?></h4>
                     <ul class="list-group ">
                        <li class="list-group-item ">
                              <span class="p-2 fas fa-question rounded-circle bg-warning text-light"></span>
                           <span class="text-secondary fw-bold">respuesta seleccionada: <?=$answer['answerSelected'] ?> </span>
                           </li>

                           <li class="list-group-item ">
                              <span class="p-2 fas fa-check rounded-circle bg-success text-light"></span>
                              <span class="text-success fw-bold">respuesta correcta: <?=$answer['answer'] ?> </span>
                           </li>
                     </ul>
               </li>

               
            
            </ul>

      
                  <?php endforeach?>
          </section>
        
     
    </div>



</section>
