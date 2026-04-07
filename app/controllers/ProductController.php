<?php
require_once ROOT . 'app/models/Product.php';

class ProductController
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function catalogue(): void
    {
        $productModel = new Product($this->pdo);

        $idCategory = null;
        if (isset($_GET['SelectionnerGenre']) && $_GET['SelectionnerGenre'] !== 'tout') {
            $idCategory = (int)$_GET['SelectionnerGenre'];
        }

        $recherche    = trim($_GET['q'] ?? '');
        $parPage      = 12;
        $pageCourante = max(1, (int)($_GET['page'] ?? 1));
        $offset       = ($pageCourante - 1) * $parPage;

        $total      = $productModel->countFiltered($idCategory, $recherche);
        $totalPages = ceil($total / $parPage);
        $resultats  = $productModel->getFiltered($idCategory, $recherche, $parPage, $offset);
        $categories = $productModel->getCategories();

        $queryParams = [];
        if ($idCategory)       $queryParams['SelectionnerGenre'] = $idCategory;
        if ($recherche !== '') $queryParams['q'] = $recherche;
        $queryString = !empty($queryParams) ? '&' . http_build_query($queryParams) : '';

        require_once ROOT . 'app/views/catalogue.php';
    }

    public function detail(): void
{
    $idGame = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    if ($idGame <= 0) {
        header('Location: ?action=catalogue');
        exit;
    }

    $productModel = new Product($this->pdo);
    $userModel    = new User($this->pdo);

    $game = $productModel->getById($idGame);

    if (!$game) {
        header('Location: ?action=catalogue');
        exit;
    }

    $dejaAchete   = false;
    $inWishlist   = false;

    if (isset($_SESSION['id_user'])) {
        $dejaAchete = $productModel->isAlreadyPurchased($_SESSION['id_user'], $idGame);
        $inWishlist = $userModel->isInWishlist($_SESSION['id_user'], $idGame);
    }

    $dejaAuPanier = isset($_SESSION['panier'][$idGame]);

    require_once ROOT . 'app/views/detail.php';
}
public function tagPage(string $tag, string $titre): void
{
    $productModel = new Product($this->pdo);
    $parPage      = 12;
    $pageCourante = max(1, (int)($_GET['page'] ?? 1));
    $offset       = ($pageCourante - 1) * $parPage;

    $total      = $productModel->countByTag($tag);
    $totalPages = ceil($total / $parPage);
    $jeux       = $productModel->getByTagPaginated($tag, $parPage, $offset);
    $titreePage = $titre;

    require_once ROOT . 'app/views/tag_page.php';
}
}