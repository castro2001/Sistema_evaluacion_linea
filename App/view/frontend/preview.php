<section class="container">




<div class="mx-auto w-50">

<?php if(!empty($_SESSION['mensaje'] )): ?>
<div class="mt-2 alert alert-warning alert-dismissible fade show" role="alert">
  <strong><?= $_SESSION['mensaje']  ?></strong> 
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif ?>

    <div class="p-3 mt-4 mb-5 rounded shadow bg-body ">
    <!-- PREGUNTAS -->
          <section class="" data-preguntas="<?=$link ?>">
          <h1 class="mt-1 text-danger">Resultado Test de Conocimiento</h1>
          
            <form action="<? URL ?>Preguntas/sendQuestionEmail" method="post" class="alert alert-primary">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Ingrese su correo electronico</label>
                    <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>

                <a class="mt-4 btn btn-info" href="<? URL ?>Preguntas/end">ver resultado</a>
                <button class="mt-4 btn btn-primary" type="submit">Enviar</button>
            </form>
      
          </section>
        
          

    </div>

</section>
