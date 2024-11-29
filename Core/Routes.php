<?php
namespace Core;

use App\Controller\HomeController;


class Routes {
    private $listWhite;

    public function __construct()
    {
        //session_start();  // Ensure that the session is started
        $this->getUrl();
    }

public function getUrl() {
    $this->listWhite = array(
        "Home","Preguntas"
    );

 
        // User is logged in
        // Redirect to the default viaew (e.g., Administrador) if no specific view is requested
        if (!isset($_GET['views'])) {
            // Redirect to the default view if no view is provided
            $controller = new HomeController(); // Replace with your default controller
            call_user_func(array($controller, 'view')); // Default method for logged-in users
            //return;
        } else {
            // Check for the requested view
            $controller = $_GET['views'];
            $method = isset($_GET['action']) ? $_GET['action'] : null;

            // Check if the requested view is in the white list
            if (in_array($controller, $this->listWhite)) {
                if (file_exists(__DIR__ . "/../App/Controller/" . $controller . "Controller.php")) {
                    $controllerName = ucwords($controller . "Controller");
                    $controllerClass = "App\\Controller\\" . $controllerName;

                    if (class_exists($controllerClass)) {
                        $controllerInstance = new $controllerClass();

                        // Default method if none provided
                        if (!$method) {
                            $method = "view_" . $controller;
                        }

                        if (method_exists($controllerInstance, $method)) {
                            call_user_func(array($controllerInstance, $method));
                        } else {
                            echo "Método no definido 405";
                        }
                    }
                } else {
                    echo "Archivo no disponible";
                }
            } else {
                echo "Controller no definido 404";
            }
        }

}

}
