<?php

namespace App\Controller;

use Core\Controller;

class HomeController extends Controller{

    public function view(){
        $information=array(
            "scripts"=>['card',]
        );
       $this->render('home',$information);
    }

  
  

}

