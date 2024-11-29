<?php

namespace App\Controller;

use Core\Controller;
use Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class PreguntasController extends Controller{
      
    protected $email;
    private string $url;
    public function __construct()
    {
        
    $this->email= new PHPMailer(true);
    $this->url=URL;
    }

    public function questionProccess() {
        // Decodifica los datos que vienen del cliente (front-end)
        $datajsEncode = json_decode(file_get_contents("php://input",true));
    
        // Ruta al archivo JSON donde se encuentran las respuestas correctas
        $path= $this->url."App/Model/answers.json";
        // Decodifica el archivo JSON que contiene las respuestas válidas
        $answersValidateJson = json_decode(file_get_contents($path), true);
    
        // Inicializa el puntaje
        $score = 0;
        $correctAnswerArray=[];
        // Inicializa la respuesta por defecto
        $response = [
            "status" => "error",
            "message" => "Respuesta no válida.",
           
        ];
      

        // Recorre las respuestas del usuario y las compara con las respuestas correctas
        foreach ($datajsEncode as $keyData => $userAnswers) {
            // Asegúrate de que el grupo de respuestas existe en las respuestas correctas
            $totalQuestion = count($answersValidateJson[$keyData]);
            $key = $keyData;
            if (isset($answersValidateJson[$keyData])) {
                foreach ($userAnswers as $questionKey => $userAnswer) {
                    // Verifica si existe la respuesta correspondiente en el archivo JSON
                    if (isset($answersValidateJson[$keyData][$questionKey])) {
                        $correctAnswer = $answersValidateJson[$keyData][$questionKey];
                        $correctAnswerArray[$keyData][$questionKey]= $correctAnswer;
                        // Compara las respuestas ignorando mayúsculas y espacios en blanco adicionales
                        if (trim(strtolower($userAnswer)) === trim(strtolower($correctAnswer))) {
                            $score++;
                        }
                    }
                }
            }
        }
    
        // Actualiza la respuesta con el puntaje obtenido
        $response["status"] = "success";
        $response["message"] ="ok";
       
        $_SESSION['questionSend']=array(
        "total_preguntas"=>$totalQuestion,
        "score"=>$score,
        "pregunta"=>$key,
        "preguntas_usuario"=>$datajsEncode,
        "preguntas_corregidas"=>$correctAnswerArray
    );
        // Muestra el resultado final

        echo json_encode($response);
    }

    public function end(){
          // Ruta al archivo JSON donde se encuentran las respuestas correctas
          $path= $this->url."App/Model/question.json";
    
    
          // Decodifica el archivo JSON que contiene las respuestas válidas
          $questionJson = json_decode(file_get_contents($path), true);
      
        $questionsUser= $_SESSION['questionSend']['preguntas_usuario'];
       $questionResponse = $_SESSION['questionSend']['preguntas_corregidas'];
      
       $questionsToRender =[];
       foreach ($questionResponse as $key => $valuec) {
        
                foreach ($questionsUser as $key => $valuej) {
          

            foreach ($questionJson[$key] as $key => $value) {
                $id=$value['id'];
                $answer = "answer_".$id;
                $questionsToRender[]=[
                    "question"=> $value['question'],
                    "answerSelected"=>$valuej->$answer,
                    "answer"=>$valuec[$answer],
                 

                ];
                            
                }
        }
        
        
        }
    
          $information=array(
          //  "total"=>$_SESSION['questionSend']['total_preguntas'],
          "questions"=>$questionsToRender,
          "score"=>$_SESSION['questionSend']['score'],
          "total"=>$_SESSION['questionSend']['total_preguntas'],
              "scripts"=>['question']
          );
         $this->render('end-question',$information);
    }



    public function test(){
        $information=array(
            "link"=>$_GET['id'],
            "scripts"=>['question']
        );
       $this->render('question',$information);
    }
   
    public function resultado(){
        $information=[

        ];
        $this->render('preview',$information);
    }

    public function sendQuestionEmail(){
        $email=$_POST['email'];
        // Ruta al archivo JSON donde se encuentran las respuestas correctas
        $path= $this->url."App/Model/question.json";
    
        // Decodifica el archivo JSON que contiene las respuestas válidas
        $questionJson = json_decode(file_get_contents($path), true);
    
      $questionsUser= $_SESSION['questionSend']['preguntas_usuario'];
     $questionResponse = $_SESSION['questionSend']['preguntas_corregidas'];
        $emailContent ="
        <h1 class='mt-2 text-danger'>Test de Conocimiento Resultado</h1>
        <div class='mt-2' id='question-container'>

        <code class='mx-5 fs-4'>calificacion de:". $_SESSION['questionSend']['score'] ."/".$_SESSION['questionSend']['total_preguntas']."</code>
        <ul class='mb-5 list-group'>
        
     ";
     foreach ($questionResponse as $key => $valuec) {
      
              foreach ($questionsUser as $key => $valuej) {
        

          foreach ($questionJson[$key] as $key => $value) {
              $id=$value['id'];
              $answer = "answer_".$id;
              
              $emailContent .= "
                 <li class='list-group-item'>
                    <h4 class='py-2 text-danger'>". $value['question']."</h4>
                       <ul class='list-group '>
                          <li class='list-group-item '>
                                <span class='p-2 fas fa-question rounded-circle bg-warning text-light'></span>
                             <span class='text-secondary fw-bold'>respuesta seleccionada: ".$valuej->$answer."</span>
                             </li>
  
                             <li class='list-group-item '>
                                <span class='p-2 fas fa-check rounded-circle bg-success text-light'></span>
                                <span class='text-success fw-bold'>respuesta correcta: ".$valuec[$answer]."</span>
                             </li>
                       </ul>
                 </li>
              </ul>
      </div>";
              
    }
      }
      
      
      }
      
        // Cerramos la lista de preguntas
        $emailContent .= "</ul></div>";

     
      try {
            //Server settings
            $this->email->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
            $this->email->isSMTP();                                            //Send using SMTP
            $this->email->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $this->email->SMTPAuth   = true;                                   //Enable SMTP authentication
            $this->email->Username   = EMAILPRUEBA;                     //SMTP username
            $this->email->Password   = 'cvrg ygaq ywhq szjr';                               //SMTP password
            $this->email->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
            $this->email->Port       = 587;
            // Configuración del correo
        $this->email->setFrom(EMAILPRUEBA, "Jordan");
        $this->email->addAddress($email); // Destinatario
        $this->email->addReplyTo(EMAILPRUEBA, 'Information');
        
        // Contenido del correo
        $this->email->isHTML(true);
        $this->email->Subject = "Resultados del Test de Conocimiento";
        $this->email->Body = $emailContent;

        // Codificación y envío
        $this->email->CharSet = 'UTF-8';
        $this->email->Encoding = 'base64';
        $this->email->send();

        // Guardar un mensaje de éxito en la sesión
        $_SESSION['mensaje'] = "Correo enviado exitosamente a $email";
        
        // Redirigir a la página de resultados
        header("Location: {$this->url}Preguntas/resultado");
        exit();  // Es importante detener la ejecución del script después de un header
    } catch (Exception $e) {
        // Guardar un mensaje de error en la sesión
        $_SESSION['mensaje'] = "Error al enviar el correo: {$this->email->ErrorInfo}";
        
        // Redirigir a la página de resultados con error
        header("Location: {$this->url}Preguntas/resultado");
        exit();  // Detener la ejecución del script después del header
    }


    }

   
}

