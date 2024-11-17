<?php
require_once CLASSES . '/Router.php';
require_once CLASSES . '/AppController.php';
class Kernel
{

    // private string $pagePath = '';
    private Router $router;

    public function __construct()
    {
        $this->router = new Router();
    }

    public function bootstrap() //Permet d'accéder a la methode de contrôleur de x
    {
        // $router = new Router();

        $controller = new AppController();
        $controllerMethod = $this->router->getControllerMethod();
        //Paremètres GET de l'URL
        $params = $this->router->getParams();
        if (method_exists($controller, $controllerMethod)) { // instance, nom de la methode (ex si home existe, alors sur controleur on appelle la méthode home)
            // $controller->$controllerMethod(); //appel de la méthode du controller
            $controller->$controllerMethod($params);
        } else {
            $controller->notFound($params);
        }
    }
}
