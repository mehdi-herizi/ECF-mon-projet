<?php
class CartController
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function index(): void
    {
        require_once ROOT . 'app/views/panier.php';
    }

    public function add(): void
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        if ($id <= 0) {
            header('Location: ?action=catalogue');
            exit;
        }

        if (!isset($_SESSION['panier'])) {
            $_SESSION['panier'] = [];
        }

        $stmt = $this->pdo->prepare("SELECT id_product, name, price, picture FROM product WHERE id_product = ?");
        $stmt->execute([$id]);
        $game = $stmt->fetch();

        if ($game) {
            $_SESSION['panier'][$id] = [
                'name'    => $game['name'],
                'price'   => $game['price'],
                'picture' => $game['picture'],
                'qty'     => 1
            ];
        }

        header('Location: ?action=panier');
        exit;
    }

    public function remove(): void
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        if (isset($_SESSION['panier'][$id])) {
            unset($_SESSION['panier'][$id]);
        }

        header('Location: ?action=panier');
        exit;
    }

    public function clear(): void
    {
        unset($_SESSION['panier']);
        header('Location: ?action=panier');
        exit;
    }
}