<?php

class Router
{
    //Récupère la page courante et renvoie son nom/chemin,méthode controleur liée
    private string $route;
    private array $params = [];

    public function __construct()
    {
        $this->route = isset($_GET["page"]) ? $_GET["page"] : "accueil";
        $this->params = $_GET;
    }

    public function getPage(): string
    {
        return $this->route;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function getPath(): string
    {
        $pagePath = PAGES . $this->route . ".php"; // le chemin complet de la page
        if (!file_exists($pagePath)) {
            header("location:index.php?page=404"); // on redirige vers 404.php
        }
        return $pagePath;
    }

    public function getControllerMethod()
    {
        if (array_key_exists($this->route, ROUTES)) { //choix de la page dans le tableau associatif
            return ROUTES[$this->route];
        }
        return NOT_FOUND_ROUTE; // on affiche la page 404 sans rediriger => l'utilisateur voit toujours l'url qu'il a ciblée
    }
}
