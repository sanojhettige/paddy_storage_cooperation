<?php

class Error extends Controller {

    function index() {
        $this->view->render("errors/404", "template", $this->data);
    }

    function not_allowed() {
        $this->view->render("errors/404", "template", $this->data);
    }
}