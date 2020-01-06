<?php

namespace App\Core;

use App\Post\CategoriesController;
use App\Post\CategoriesRepository;
use App\Post\CommentsRepository;
use App\Post\PostsController;
use App\Post\PostsRepository;
use App\User\AuthService;
use App\User\LoginController;
use App\User\RanksController;
use App\User\RanksRepository;
use App\User\UsersController;
use App\User\UsersRepository;
use PDO;
use PDOException;

class Container
{
    private $recipes = [];
    private $instances = [];

    public function __construct()
    {
        $this->recipes = [
            'authService' => function () {
                return new AuthService(
                    $this->make("usersRepository")
                );
            },
            'categoriesController' => function () {
                return new CategoriesController(
                    $this->make("categoriesRepository"),
                    $this->make("authService")
                );
            },
            'categoriesRepository' => function () {
                return new CategoriesRepository($this->make("pdo"));
            },
            'commentsRepository' => function () {
                return new CommentsRepository($this->make("pdo"));
            },
            'loginController' => function () {
                return new LoginController(
                    $this->make("authService")
                );
            },
            'postsController' => function () {
                return new PostsController(
                    $this->make("postsRepository"),
                    $this->make("commentsRepository"),
                    $this->make("authService")
                );
            },
            'postsRepository' => function () {
                return new PostsRepository($this->make("pdo"));
            },
            'ranksController' => function () {
                return new RanksController(
                    $this->make("ranksRepository"),
                    $this->make("authService")
                );
            },
            'ranksRepository' => function () {
                return new RanksRepository($this->make("pdo"));
            },
            'usersController' => function () {
                return new UsersController(
                    $this->make("usersRepository"),
                    $this->make("authService")
                );
            },
            'usersRepository' => function () {
                return new UsersRepository($this->make("pdo"));
            },
            'pdo' => function () {
                try {
                    require __DIR__ . "/../System/db.php";
                    $pdo = new PDO(
                        'mysql:host=' . $_ENV['dbhost'] . ';dbname=' . $_ENV['dbname'] . ';charset=' . $_ENV['dbchar'],
                        $_ENV['dbuser'],
                        $_ENV['dbpass']
                    );
                } catch (PDOException $e) {
                    echo "Could not establish a database connection.";
                    die();
                }
                $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                return $pdo;
            }
        ];
    }

    public function make($name)
    {
        if (empty($this->instances[$name])) {
            if (isset($this->recipes[$name])) {
                $this->instances[$name] = $this->recipes[$name]();
            }
        }
        return $this->instances[$name];
    }
}

