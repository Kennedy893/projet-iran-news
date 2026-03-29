<?php
session_start();

// require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/config.php';
// require_once __DIR__ . '/../src/Helpers/functions.php';

use Core\Router;

// Autoloader simple (si pas de Composer)
spl_autoload_register(function ($class) {
    $prefix = '';
    $base_dir = __DIR__ . '/../src/';
    $file = $base_dir . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

// Initialisation du routeur
$router = new Router();

// Définition des routes
$router->add('GET', '/', 'FrontController@home');
$router->add('GET', '/article/{id}', 'FrontController@showArticle');
$router->add('GET', '/categorie/{id}', 'FrontController@showCategory');
$router->add('GET', '/search', 'FrontController@search');

// Routes admin
// $router->add('GET', '/admin/login', 'AuthController@showLogin');
// $router->add('POST', '/admin/login', 'AuthController@login');
// $router->add('GET', '/admin/logout', 'AuthController@logout');
// $router->add('GET', '/admin/dashboard', 'AdminController@dashboard');
// $router->add('GET', '/admin/articles', 'AdminController@listArticles');
// $router->add('GET', '/admin/articles/create', 'AdminController@createArticle');
// $router->add('POST', '/admin/articles/store', 'AdminController@storeArticle');
// $router->add('GET', '/admin/articles/edit/{id}', 'AdminController@editArticle');
// $router->add('POST', '/admin/articles/update/{id}', 'AdminController@updateArticle');
// $router->add('POST', '/admin/articles/delete/{id}', 'AdminController@deleteArticle');

// Exécution du routeur
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);