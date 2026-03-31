<?php
class Product
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getByTag(string $tag, int $limit = 8): array
    {
        $query = "SELECT p.*,
                    GROUP_CONCAT(c.name_category ORDER BY c.name_category SEPARATOR ', ') AS name_category
                  FROM product p
                  LEFT JOIN product_category pc ON p.id_product = pc.id_product
                  LEFT JOIN category c ON pc.id_category = c.id_category
                  WHERE p.tag = :tag
                  GROUP BY p.id_product
                  LIMIT :limit";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':tag', $tag, PDO::PARAM_STR);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getCategories(): array
{
    return $this->pdo->query("SELECT id_category, name_category FROM category ORDER BY name_category ASC")->fetchAll();
}

public function countFiltered(?int $idCategory, string $recherche): int
{
    $conditions = [];
    $params = [];

    if ($idCategory) {
        $conditions[] = "EXISTS (SELECT 1 FROM product_category pc WHERE pc.id_product = p.id_product AND pc.id_category = ?)";
        $params[] = $idCategory;
    }
    if ($recherche !== '') {
        $conditions[] = "p.name LIKE ?";
        $params[] = '%' . $recherche . '%';
    }

    $where = !empty($conditions) ? "WHERE " . implode(" AND ", $conditions) : "";
    $stmt = $this->pdo->prepare("SELECT COUNT(DISTINCT p.id_product) FROM product p $where");
    $stmt->execute($params);
    return (int)$stmt->fetchColumn();
}

public function getFiltered(?int $idCategory, string $recherche, int $limit, int $offset): array
{
    $conditions = [];
    $params = [];

    if ($idCategory) {
        $conditions[] = "EXISTS (SELECT 1 FROM product_category pc WHERE pc.id_product = p.id_product AND pc.id_category = ?)";
        $params[] = $idCategory;
    }
    if ($recherche !== '') {
        $conditions[] = "p.name LIKE ?";
        $params[] = '%' . $recherche . '%';
    }

    $where = !empty($conditions) ? "WHERE " . implode(" AND ", $conditions) : "";

    $sql = "SELECT p.*,
                GROUP_CONCAT(c.name_category ORDER BY c.name_category SEPARATOR ', ') AS category_name
            FROM product p
            LEFT JOIN product_category pc ON p.id_product = pc.id_product
            LEFT JOIN category c ON pc.id_category = c.id_category
            $where
            GROUP BY p.id_product
            LIMIT ? OFFSET ?";

    $stmt = $this->pdo->prepare($sql);
    $i = 1;
    foreach ($params as $param) {
        $stmt->bindValue($i++, $param, is_int($param) ? PDO::PARAM_INT : PDO::PARAM_STR);
    }
    $stmt->bindValue($i++, $limit, PDO::PARAM_INT);
    $stmt->bindValue($i,   $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}
public function getById(int $id): array|false
{
    $query = "SELECT p.*,
                GROUP_CONCAT(c.name_category ORDER BY c.name_category SEPARATOR ', ') AS name_category
              FROM product p
              LEFT JOIN product_category pc ON p.id_product = pc.id_product
              LEFT JOIN category c ON pc.id_category = c.id_category
              WHERE p.id_product = :id
              GROUP BY p.id_product";
    $stmt = $this->pdo->prepare($query);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch();
}

public function isAlreadyPurchased(int $idUser, int $idProduct): bool
{
    $stmt = $this->pdo->prepare("
        SELECT COUNT(*) FROM order_product op
        JOIN pb_order o ON op.id_order = o.id_order
        WHERE o.id_user = ? AND op.id_product = ?
    ");
    $stmt->execute([$idUser, $idProduct]);
    return $stmt->fetchColumn() > 0;
}
}