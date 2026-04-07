<?php
require_once ROOT . 'app/models/Product.php';

class AdminController
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    private function checkAdmin(): void
    {
        if (!isset($_SESSION['role']) ||
            ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'super_admin')) {
            header('Location: ?action=home');
            exit;
        }
    }

    public function index(): void
    {
        $this->checkAdmin();

        $recherche    = trim($_GET['q'] ?? '');
        $productModel = new Product($this->pdo);
        $allProducts  = $productModel->searchAll($recherche);

        require_once ROOT . 'app/views/admin/index.php';
    }
    public function addProduct(): void
{
    $this->checkAdmin();

    $productModel = new Product($this->pdo);
    $categories   = $productModel->getCategories();
    $errors       = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name       = trim($_POST['name'] ?? '');
        $price      = (float)($_POST['price'] ?? 0);
        $desc       = trim($_POST['description'] ?? '');
        $tag        = $_POST['tag'] ?? 'new';
        $picture    = trim($_POST['picture'] ?? '');
        $video      = trim($_POST['video'] ?? '');
        $newCats    = isset($_POST['categories']) ? array_map('intval', $_POST['categories']) : [];

        if (empty($name))    $errors[] = "Le nom est obligatoire";
        if ($price <= 0)     $errors[] = "Le prix est invalide";
        if (empty($picture)) $errors[] = "L'image est obligatoire";

        if (empty($errors)) {
            $productModel->create($name, $price, $desc, $tag, $picture, $video, $newCats);
            header('Location: ?action=admin');
            exit;
        }
    }

    require_once ROOT . 'app/views/admin/add_product.php';
}
public function editProduct(): void
{
    $this->checkAdmin();

    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    if ($id <= 0) {
        header('Location: ?action=admin');
        exit;
    }

    $productModel       = new Product($this->pdo);
    $product            = $productModel->getById($id);

    if (!$product) {
        header('Location: ?action=admin');
        exit;
    }

    $categories         = $productModel->getCategories();
    $selectedCategories = $productModel->getSelectedCategories($id);
    $error              = null;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name    = trim($_POST['name'] ?? '');
        $price   = (float)($_POST['price'] ?? 0);
        $desc    = trim($_POST['description'] ?? '');
        $tag     = trim($_POST['tag'] ?? '');
        $picture = trim($_POST['picture'] ?? '');
        $video   = trim($_POST['video'] ?? '');
        $newCats = isset($_POST['categories']) ? array_map('intval', $_POST['categories']) : [];

        if (empty($name) || $price <= 0) {
            $error = "Le nom et le prix sont obligatoires.";
        } elseif (empty($newCats)) {
            $error = "Veuillez sélectionner au moins une catégorie.";
        } else {
            try {
                $productModel->update($id, $name, $price, $desc, $tag, $picture, $video, $newCats);
                header('Location: ?action=admin');
                exit;
            } catch (PDOException $e) {
                $error = "Erreur lors de la mise à jour : " . $e->getMessage();
            }
        }
    }

    require_once ROOT . 'app/views/admin/edit_product.php';
}

public function deleteProduct(): void
{
    $this->checkAdmin();

    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    if ($id <= 0) {
        header('Location: ?action=admin');
        exit;
    }

    $productModel = new Product($this->pdo);
    $productModel->delete($id);

    header('Location: ?action=admin');
    exit;
}
public function messages(): void
{
    $this->checkAdmin();

    $messageModel = new Message($this->pdo);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
        $messageModel->delete((int)$_POST['delete_id']);
        header('Location: ?action=admin_messages');
        exit;
    }

    $messages = $messageModel->getAll();

    require_once ROOT . 'app/views/admin/messages.php';
}
}