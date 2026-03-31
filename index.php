<?php
session_start();
require_once 'config/config.php';
require_once ROOT . 'app/models/Database.php';

$pdo = Database::getInstance();
$action = $_GET['action'] ?? 'home';

switch ($action) {
    case 'home':
        require_once ROOT . 'app/controllers/HomeController.php';
        $controller = new HomeController($pdo);
        $controller->index();
        break;

    default:
        http_response_code(404);
        echo "Page introuvable";
        break;
    case 'login':
        require_once ROOT . 'app/controllers/AuthController.php';
        $controller = new AuthController($pdo);
        $controller->login();
        break;

    case 'register':
        require_once ROOT . 'app/controllers/AuthController.php';
        $controller = new AuthController($pdo);
        $controller->register();
        break;

    case 'logout':
        require_once ROOT . 'app/controllers/AuthController.php';
        $controller = new AuthController($pdo);
        $controller->logout();
        break;

    case 'catalogue':
        require_once ROOT . 'app/controllers/ProductController.php';
        $controller = new ProductController($pdo);
        $controller->catalogue();
        break;

    case 'detail':
        require_once ROOT . 'app/controllers/ProductController.php';
        $controller = new ProductController($pdo);
        $controller->detail();
        break;

    case 'panier':
    require_once ROOT . 'app/controllers/CartController.php';
    $controller = new CartController($pdo);
    $controller->index();
    break;

case 'panier_add':
    require_once ROOT . 'app/controllers/CartController.php';
    $controller = new CartController($pdo);
    $controller->add();
    break;

case 'panier_remove':
    require_once ROOT . 'app/controllers/CartController.php';
    $controller = new CartController($pdo);
    $controller->remove();
    break;

case 'panier_clear':
    require_once ROOT . 'app/controllers/CartController.php';
    $controller = new CartController($pdo);
    $controller->clear();
    break;
}
