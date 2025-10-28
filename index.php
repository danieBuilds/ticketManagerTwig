<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// index.php - Main router
session_start();

require_once 'vendor/autoload.php';

// Initialize Twig
$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader, [
    'cache' => false, // Set to 'cache' folder in production
    'debug' => true,
]);

// Set a global variable array containing necessary objects
// We will extract this array in the controller files.
$GLOBALS['app'] = [
    'twig' => $twig,
    // You would add database connections, authentication services, etc. here later
];

// Simple router
$request = $_SERVER['REQUEST_URI'];
$path = parse_url($request, PHP_URL_PATH);

// Remove base path if app is in subdirectory
$path = str_replace('/tickHandler', '', $path);

switch ($path) {
    case '/':
    case '/index.php':
        echo $twig->render('landing.twig');
        break;
    
    case '/login':
        include 'controllers/login.php';
        break;
    
    case '/signup':
        include 'controllers/signup.php';
        break;
    
    case '/dashboard':
        include 'controllers/dashboard.php';
        break;
    
    case '/logout':
        session_destroy();
        header('Location: /');
        exit;
        break;
    
    default:
        http_response_code(404);
        echo "404 - Page not found";
        break;
}
?>