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


function is_permitted($module=null) {
    $model = new Model();
    $role = isset($_SESSION['role_id']) ? $_SESSION['role_id']: 0;
    $user = isset($_SESSION['user_id']) ? $_SESSION['user_id']: 0;
    $per_model = $model->load('permission');
    $permission = false;
    try {
        if($user && $role) {
            $permission = $per_model->getIsPermittedByRole($module, $role);
        } else {
            $permission = false;
        }
    } catch(Exception $e) {
        $permission = false;
    }
    return $permission;
}

function clear_messages() {
    $_SESSION['success_message'] = null;
    $_SESSION['error_message'] = null;
}

function passwor_encrypt($password=NULL) {
    return $password;
}