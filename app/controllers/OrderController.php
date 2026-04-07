<?php
require_once ROOT . 'app/models/Order.php';

class OrderController
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function valider(): void
    {
        if (!isset($_SESSION['id_user'])) {
            header('Location: ?action=login');
            exit;
        }

        if (empty($_SESSION['panier'])) {
            header('Location: ?action=panier');
            exit;
        }

        try {
            $orderModel = new Order($this->pdo);
            $idOrder    = $orderModel->create($_SESSION['id_user'], $_SESSION['panier']);

            unset($_SESSION['panier']);

            header('Location: ?action=confirmation&order=' . $idOrder);
            exit;
        } catch (PDOException $e) {
            die("Erreur SQL : " . $e->getMessage());
        }
    }

    public function confirmation(): void
{
    if (!isset($_SESSION['id_user'])) {
        header('Location: ?action=login');
        exit;
    }

    $idOrder = isset($_GET['order']) ? (int)$_GET['order'] : 0;

    if ($idOrder <= 0) {
        header('Location: ?action=home');
        exit;
    }

    $orderModel = new Order($this->pdo);
    $jeux       = $orderModel->getDetails($idOrder);
    $total      = array_sum(array_column($jeux, 'price'));

    require_once ROOT . 'app/views/confirmation.php';
}
}