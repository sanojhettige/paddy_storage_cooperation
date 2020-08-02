<?php

class Error extends Controller {

    function index() {
        $this->view->render("errors/404.php", "template.php", $data);
    }
}