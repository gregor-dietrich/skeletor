<?php
$routes = [
    '/' => [
        'controller' => 'postsController',
        'method' => 'index'
    ],
    '/dashboard' => [
        'controller' => 'loginController',
        'method' => 'dashboard'
    ],
    '/dashboard/posts' => [
        'controller' => 'postsController',
        'method' => 'admin_index'
    ],
    '/dashboard/posts/add' => [
        'controller' => 'postsController',
        'method' => 'add'
    ],
    '/dashboard/posts/edit' => [
        'controller' => 'postsController',
        'method' => 'edit'
    ],
    '/login' => [
        'controller' => 'loginController',
        'method' => 'login'
    ],
    '/logout' => [
        'controller' => 'loginController',
        'method' => 'logout'
    ],
    '/post' => [
        'controller' => 'postsController',
        'method' => 'show'
    ],
];
?>