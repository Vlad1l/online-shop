<?php

class App
{
    private array $routes = [
        '/registration' => [
            'GET' => [
                'class' => 'UserController',
                'method' => 'getRegistrate'
            ],
            'POST' => [
                'class' => 'UserController',
                'method' => 'registrate'
            ]
        ],
        '/login' => [
            'GET' => [
                'class' => 'UserController',
                'method' => 'getLoginForm'
            ],
            'POST' => [
                'class' => 'UserController',
                'method' => 'login'
            ]
        ],
        '/logout' => [
            'GET' => [
                'class' => 'UserController',
                'method' => 'logout'
            ]
        ],
        '/profile' => [
            'GET' => [
                'class' => 'UserController',
                'method' => 'getProfile'
            ]
        ],
        '/profile-change' => [
            'GET' => [
                'class' => 'UserController',
                'method' => 'getEditProfileForm'
            ],
            'POST' => [
                'class' => 'UserController',
                'method' => 'editProfile'
            ]
        ],
        '/catalog' => [
            'GET' => [
                'class' => 'ProductController',
                'method' => 'getCatalog',
            ]
        ]
    ];

    public function run() {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $requestUri = $_SERVER["REQUEST_URI"];
        $requestMethod = $_SERVER["REQUEST_METHOD"];

        if (isset($this->routes[$requestUri])) {
            $routeMethods = $this->routes[$requestUri];
            if (isset($routeMethods[$requestMethod])) {
                $handler = $routeMethods[$requestMethod];

                $class = $handler['class'];
                $method = $handler['method'];

                require_once "../Controllers/$class.php";

                $controller = new $class();
                $controller->$method();
            }
        } else {
            http_response_code(404);
            require_once './404.php';
        }
    }
}