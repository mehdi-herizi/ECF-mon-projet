<?php
require_once ROOT . 'app/models/Product.php';

class HomeController
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function index(): void
    {
        $productModel = new Product($this->pdo);

        $data = [
            'jeuxTendance'      => $productModel->getByTag('trending'),
            'jeuxQuiVontSortir' => $productModel->getByTag('coming_soon'),
            'nouveauxJeux'      => $productModel->getByTag('new'),
        ];

        require_once ROOT . 'app/views/home.php';
    }
}