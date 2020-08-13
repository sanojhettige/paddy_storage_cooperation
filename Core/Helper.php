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
    $role = get_user_role();
    $user = get_user_id();
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

function sale_status($id=null) {
    $arr =  array(
        array(
            "id"=>1,
            "name"=>"Pending",
        ),
        array(
            "id"=>2,
            "name"=>"Completed",
        )
    );

    if($id > 0) {
        $status = filter_array($arr, $id, 'id');
        return isset($status[0]) ? $status[0]['name']: "";
    } else {
        return $arr;
    }
}



function transfer_status($id=null) {
    $arr =  array(
        array(
            "id"=>1,
            "name"=>"Pending",
        ),
        array(
            "id"=>2,
            "name"=>"Issued",
        ),
        array(
            "id"=>3,
            "name"=>"Collected",
        )
    );

    if($id > 0) {
        $status = filter_array($arr, $id, 'id');
        return isset($status[0]) ? $status[0]['name']: "";
    } else {
        return $arr;
    }
}


function filter_array($array=null,$term=null, $field='id'){
    $matches = array();
    foreach($array as $a){
        if($a[$field] == $term)
            $matches[]=$a;
    }
    return $matches;
}



function get_user_role() {
    return (get_session("role_id")) ? get_session("role_id"): null;
}
function get_assigned_center() {
    return (get_session('assigned_center')) ? get_session('assigned_center'): null;
}
function get_user_id() {
    return (get_session('user_id')) ? get_session('user_id'): null;
}
function formatCurrency($dollars){
    return 'Rs '.sprintf('%0.2f', $dollars);
  }

  function get_session($name=null) {
    if(isset($_SESSION[$name])) {
        return $_SESSION[$name];
    }

    return null;
}