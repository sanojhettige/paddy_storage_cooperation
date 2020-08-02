<?php

$routes = explode("/", $_SERVER["REQUEST_URI"]);

if(!empty($routes[1])) {
    $controller = $routes[1];
}

if(!empty($routes[2])) {
    $method = $routes[2];
}

if(!empty($routes[3])) {
    $params = $routes[3];
}

