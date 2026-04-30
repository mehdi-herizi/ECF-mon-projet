<?php
session_start();
define('APP_RUNNING', true);

// 1. On définit ROOT sur le dossier actuel (la nouvelle racine)
define('ROOT', __DIR__ . '/'); 

// 2. On appelle les fichiers directement depuis cette racine
require_once ROOT . 'config/config.php';       // Plus simple
require_once ROOT . 'app/models/database.php'; // On enlève le "config/../"

$pdo    = Database::getInstance();
$action = $_GET['action'] ?? 'home';

switch ($action) {

    // HOME
    case 'home':
        require_once ROOT . 'app/controllers/HomeController.php';
        $controller = new HomeController($pdo);
        $controller->index();
        break;

    // AUTH
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

    // PRODUITS
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

    case 'trending':
        require_once ROOT . 'app/controllers/ProductController.php';
        $controller = new ProductController($pdo);
        $controller->tagPage('trending', 'Jeux Tendance');
        break;

    case 'new':
        require_once ROOT . 'app/controllers/ProductController.php';
        $controller = new ProductController($pdo);
        $controller->tagPage('new', 'Nouveaux Jeux');
        break;

    case 'coming_soon':
        require_once ROOT . 'app/controllers/ProductController.php';
        $controller = new ProductController($pdo);
        $controller->tagPage('coming_soon', 'Jeux à Venir');
        break;

    // PANIER
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

    // COMMANDES
    case 'valider_commande':
        require_once ROOT . 'app/controllers/OrderController.php';
        $controller = new OrderController($pdo);
        $controller->valider();
        break;

    case 'confirmation':
        require_once ROOT . 'app/controllers/OrderController.php';
        $controller = new OrderController($pdo);
        $controller->confirmation();
        break;

    // WISHLIST
    case 'wishlist_toggle':
        require_once ROOT . 'app/controllers/WishlistController.php';
        $controller = new WishlistController($pdo);
        $controller->toggle();
        break;

    // UTILISATEUR
    case 'profil':
        require_once ROOT . 'app/controllers/UserController.php';
        $controller = new UserController($pdo);
        $controller->profil();
        break;

    case 'settings':
        require_once ROOT . 'app/controllers/UserController.php';
        $controller = new UserController($pdo);
        $controller->settings();
        break;

    // CONTACT
    case 'contact':
        require_once ROOT . 'app/controllers/ContactController.php';
        $controller = new ContactController($pdo);
        $controller->index();
        break;

    // ADMIN
    case 'admin':
        require_once ROOT . 'app/controllers/AdminController.php';
        $controller = new AdminController($pdo);
        $controller->index();
        break;

    case 'add_product':
        require_once ROOT . 'app/controllers/AdminController.php';
        $controller = new AdminController($pdo);
        $controller->addProduct();
        break;

    case 'edit_product':
        require_once ROOT . 'app/controllers/AdminController.php';
        $controller = new AdminController($pdo);
        $controller->editProduct();
        break;

    case 'delete_product':
        require_once ROOT . 'app/controllers/AdminController.php';
        $controller = new AdminController($pdo);
        $controller->deleteProduct();
        break;

    case 'admin_messages':
        require_once ROOT . 'app/controllers/AdminController.php';
        $controller = new AdminController($pdo);
        $controller->messages();
        break;

    // SUPER ADMIN
    case 'super_admin':
        require_once ROOT . 'app/controllers/SuperAdminController.php';
        $controller = new SuperAdminController($pdo);
        $controller->index();
        break;

    case 'super_admin_action':
        require_once ROOT . 'app/controllers/SuperAdminController.php';
        $controller = new SuperAdminController($pdo);
        $controller->action();
        break;

    case 'super_admin_view_user':
        require_once ROOT . 'app/controllers/SuperAdminController.php';
        $controller = new SuperAdminController($pdo);
        $controller->viewUser();
        break;

    // 404
    default:
        http_response_code(404);
        echo "Page introuvable";
        break;
}