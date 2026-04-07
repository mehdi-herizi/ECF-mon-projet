<?php
require_once ROOT . 'app/models/User.php';

class WishlistController
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function toggle(): void
    {
        if (!isset($_SESSION['id_user']) || !isset($_GET['id'])) {
            header('Location: ?action=catalogue');
            exit;
        }

        $idProduct = (int)$_GET['id'];
        $userModel = new User($this->pdo);
        $userModel->toggleWishlist($_SESSION['id_user'], $idProduct);

        // Retour à la page précédente
        $referer = $_SERVER['HTTP_REFERER'] ?? '?action=catalogue';
        header('Location: ' . $referer);
        exit;
    }
}