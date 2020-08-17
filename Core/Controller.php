<?php
if ( ! defined('APP_PATH')) exit("Access denied");

class Controller {
    public $model;
    public $view;
    public $data = array();
    public $library;

    public function __construct() {
        $this->view = new View();
        $this->model = new Model();
        $this->library = new Library();
    }

    function index() {
        
    }
}