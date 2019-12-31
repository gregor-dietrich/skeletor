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
    '/dashboard/posts/delete' => [
        'controller' => 'postsController',
        'method' => 'delete'
    ],
    '/dashboard/posts/edit' => [
        'controller' => 'postsController',
        'method' => 'edit'
    ],
    '/dashboard/users' => [
        'controller' => 'usersController',
        'method' => 'admin_index'
    ],
    '/dashboard/users/add' => [
        'controller' => 'usersController',
        'method' => 'add'
    ],
    '/dashboard/users/delete' => [
        'controller' => 'usersController',
        'method' => 'delete'
    ],
    '/dashboard/users/edit' => [
        'controller' => 'usersController',
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
