<?php
class Order
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create(int $idUser, array $panier): int
    {
        $stmt = $this->pdo->prepare("INSERT INTO pb_order (id_user, order_date, status) VALUES (?, NOW(), 'termine')");
        $stmt->execute([$idUser]);
        $idOrder = (int)$this->pdo->lastInsertId();

        $stmtProduct = $this->pdo->prepare("INSERT INTO order_product (id_order, id_product) VALUES (?, ?)");
        foreach ($panier as $idProduct => $jeu) {
            $stmtProduct->execute([$idOrder, (int)$idProduct]);
        }

        return $idOrder;
    }

    public function getDetails(int $idOrder): array
{
    $stmt = $this->pdo->prepare("
        SELECT p.name, p.price, p.picture
        FROM order_product op
        JOIN product p ON op.id_product = p.id_product
        WHERE op.id_order = ?
    ");
    $stmt->execute([$idOrder]);
    return $stmt->fetchAll();
}
}