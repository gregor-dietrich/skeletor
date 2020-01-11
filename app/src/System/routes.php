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
    '/dashboard/post_categories' => [
        'controller' => 'categoriesController',
        'method' => 'admin_index'
    ],
    '/dashboard/post_categories/add' => [
        'controller' => 'categoriesController',
        'method' => 'add'
    ],
    '/dashboard/post_categories/delete' => [
        'controller' => 'categoriesController',
        'method' => 'delete'
    ],
    '/dashboard/post_categories/edit' => [
        'controller' => 'categoriesController',
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
    '/dashboard/user_groups' => [
        'controller' => 'groupsController',
        'method' => 'admin_index'
    ],
    '/dashboard/user_groups/add' => [
        'controller' => 'groupsController',
        'method' => 'add'
    ],
    '/dashboard/user_groups/delete' => [
        'controller' => 'groupsController',
        'method' => 'delete'
    ],
    '/dashboard/user_groups/edit' => [
        'controller' => 'groupsController',
        'method' => 'edit'
    ],
    '/dashboard/user_ranks' => [
        'controller' => 'ranksController',
        'method' => 'admin_index'
    ],
    '/dashboard/user_ranks/add' => [
        'controller' => 'ranksController',
        'method' => 'add'
    ],
    '/dashboard/user_ranks/delete' => [
        'controller' => 'ranksController',
        'method' => 'delete'
    ],
    '/dashboard/user_ranks/edit' => [
        'controller' => 'ranksController',
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
    '/user_group' => [
        'controller' => 'groupsController',
        'method' => 'show'
    ],
    '/user_groups' => [
        'controller' => 'groupsController',
        'method' => 'index'
    ]
];