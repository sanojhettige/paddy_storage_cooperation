<?php
if ( ! defined('APP_PATH')) exit("Access denied");

function upload_file($file) {
    $uploadFile = UPLOAD_PATH . basename($_FILES[$file]["name"]);

    if(move_uploaded_file($_FILES["tmp_name"], $uploadFile)) {
        return basename($_FILES[$file]["name"]);
    }
    return flse;
}

function get_post($name, $defVal = null) {
    if(isset($_POST[$name])) {
        return $_POST[$name];
    }

    return $defVal;
}