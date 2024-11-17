<?php

abstract class AbstractController

{
    public function __construct() {}
    protected function render($page, $params = null)
    {
        $pagePath = PAGES . "/" . $page . ".php";

        console_log("PagePath : " . $pagePath);
        console_log("Page : " . $page);

        if (!file_exists($pagePath)) {
            header("Location: index.php?page=" . NOT_FOUND_ROUTE);
        }

        if ($params !== null) {
            extract($params);
        }

        // var_dump($_SESSION);

        // echo "LoggedIn directly inside render: " . var_export($loggedIn, true);

        // echo "LoggedIn ? " . (isset($_SESSION['email']) && isset($_SESSION['roles']) && isset($_SESSION['idUtilisateur']) && isset($_SESSION['session_id']));


        include TEMPLATES . '/base.php';
    }
}
