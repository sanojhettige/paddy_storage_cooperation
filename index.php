<?php
if(!isset($_SESSION)) {
    session_start();
}

require_once "App/Config/config.php";
require_once "Core/Controller.php";
require_once "Core/Model.php";
require_once "Core/View.php";
require_once "Core/Library.php";
require_once "Core/App.php";

require_once "Core/Helper.php";

App::start();