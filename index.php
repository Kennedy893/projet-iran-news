<?php
session_start();

require_once __DIR__ . '/config/config.php';

use Core\Router;

// Autoloader simple (si pas de Composer)
spl_autoload_register(function ($class) {
    $baseDir = __DIR__ . '/src/';
    $file = $baseDir . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

$router = new Router();

// Routes front
$router->add('GET', '/', 'FrontController@home');
$router->add('GET', '/article/{id}', 'FrontController@showArticle');
$router->add('GET', '/categorie/{id}', 'FrontController@showCategory');
$router->add('GET', '/search', 'FrontController@search');

// Routes admin
$router->add('GET', '/admin/login', 'AuthController@showLogin');
$router->add('POST', '/admin/login', 'AuthController@login');
$router->add('GET', '/admin/logout', 'AuthController@logout');
$router->add('GET', '/admin/dashboard', 'AdminController@dashboard');
$router->add('GET', '/admin/articles', 'AdminController@listArticles');
$router->add('POST', '/admin/articles/store', 'AdminController@storeArticle');
$router->add('POST', '/admin/articles/update/{id}', 'AdminController@updateArticle');
$router->add('POST', '/admin/articles/delete/{id}', 'AdminController@deleteArticle');
$router->add('POST', '/admin/articles/images/delete/{id}', 'AdminController@deleteArticleImage');
$router->add('GET', '/admin/categories', 'AdminController@listCategories');
$router->add('POST', '/admin/categories/store', 'AdminController@storeCategory');
$router->add('POST', '/admin/categories/update/{id}', 'AdminController@updateCategory');
$router->add('POST', '/admin/categories/delete/{id}', 'AdminController@deleteCategory');

$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
