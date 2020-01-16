<?php

namespace App\Core;

use App\Page\PagesController;
use App\Page\PagesRepository;
use App\Post\CategoriesController;
use App\Post\CategoriesRepository;
use App\Post\CommentsRepository;
use App\Post\PostsController;
use App\Post\PostsRepository;
use App\User\AuthService;
use App\User\GroupsController;
use App\User\GroupmetasRepository;
use App\User\GroupsRepository;
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
        $this->recipes = array(
            'authService' => function () {
                return new AuthService(
                    $this->make("usersRepository"),
                    $this->make("ranksRepository")
                );
            },
            'categoriesController' => function () {
                return new CategoriesController(
                    $this->make("categoriesRepository"),
                    $this->make("postsRepository"),
                    $this->make("authService")
                );
            },
            'categoriesRepository' => function () {
                return new CategoriesRepository($this->make("pdo"));
            },
            'commentsRepository' => function () {
                return new CommentsRepository($this->make("pdo"));
            },
            'groupsController' => function () {
                return new GroupsController(
                    $this->make("groupsRepository"),
                    $this->make("groupmetasRepository"),
                    $this->make("usersRepository"),
                    $this->make("authService")
                );
            },
            'groupmetasRepository' => function () {
                return new GroupmetasRepository($this->make("pdo"));
            },
            'groupsRepository' => function () {
                return new GroupsRepository($this->make("pdo"));
            },
            'loginController' => function () {
                return new LoginController(
                    $this->make("usersRepository"),
                    $this->make("authService")
                );
            },
            'pagesController' => function () {
                return new PagesController(
                    $this->make("pagesRepository"),
                    $this->make("authService")
                );
            },
            'pagesRepository' => function () {
                return new PagesRepository($this->make("pdo"));
            },
            'postsController' => function () {
                return new PostsController(
                    $this->make("postsRepository"),
                    $this->make("categoriesRepository"),
                    $this->make("usersRepository"),
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
                    $this->make("groupsRepository"),
                    $this->make("groupmetasRepository"),
                    $this->make("ranksRepository"),
                    $this->make("postsRepository"),
                    $this->make("commentsRepository"),
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
                        'mysql:host=' .
                        $_ENV['dbhost'] . ';
                        dbname=' .
                        $_ENV['dbname'] . ';
                        charset=' .
                        $_ENV['dbchar'],
                        $_ENV['dbuser'],
                        $_ENV['dbpass']
                    );
                    unset($_ENV['dbpass']);
                    unset($_ENV['dbuser']);
                    unset($_ENV['dbname']);
                    unset($_ENV['dbhost']);
                    unset($_ENV['dbchar']);
                } catch (PDOException $e) {
                    echo "Could not establish a database connection.";
                    die();
                }
                $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                return $pdo;
            }
        );
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
