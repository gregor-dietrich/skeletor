<?php

session_start();

require __DIR__ . "/src/System/init.php";

if (isset($_SERVER['PATH_INFO'])) {
    $pathInfo = $_SERVER['PATH_INFO'];
} else {
    header("Location: index.php/");
}

require __DIR__ . "/src/System/routes.php";

if (isset($routes[$pathInfo])) {
    $route = $routes[$pathInfo];
    $controller = $container->make($route['controller']);
    $method = $route['method'];
    $controller->$method();
}
