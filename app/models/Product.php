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
    public function searchAll(string $recherche = ''): array
    {
        $sql = "SELECT p.*,
                GROUP_CONCAT(c.name_category ORDER BY c.name_category SEPARATOR ', ') AS name_category
            FROM product p
            LEFT JOIN product_category pc ON p.id_product = pc.id_product
            LEFT JOIN category c ON pc.id_category = c.id_category";

        if ($recherche !== '') {
            $sql .= " WHERE p.name LIKE ?";
            $sql .= " GROUP BY p.id_product ORDER BY p.id_product DESC";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['%' . $recherche . '%']);
        } else {
            $sql .= " GROUP BY p.id_product ORDER BY p.id_product DESC";
            $stmt = $this->pdo->query($sql);
        }

        return $stmt->fetchAll();
    }
    public function create(string $name, float $price, string $desc, string $tag, string $picture, string $video, array $categories): void
    {
        $date = date('Y-m-d');
        $stmt = $this->pdo->prepare("INSERT INTO product (name, price, description, tag, picture, video, date_, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, 1)");
        $stmt->execute([$name, $price, $desc, $tag, $picture, $video, $date]);
        $idProduct = (int)$this->pdo->lastInsertId();

        $insStmt = $this->pdo->prepare("INSERT INTO product_category (id_product, id_category) VALUES (?, ?)");
        foreach ($categories as $catId) {
            $insStmt->execute([$idProduct, $catId]);
        }
    }
    public function update(int $id, string $name, float $price, string $desc, string $tag, string $picture, string $video, array $categories): void
    {
        $this->pdo->beginTransaction();

        $stmt = $this->pdo->prepare("UPDATE product SET name = ?, price = ?, description = ?, tag = ?, picture = ?, video = ? WHERE id_product = ?");
        $stmt->execute([$name, $price, $desc, $tag ?: null, $picture, $video, $id]);

        $this->pdo->prepare("DELETE FROM product_category WHERE id_product = ?")->execute([$id]);
        $insStmt = $this->pdo->prepare("INSERT INTO product_category (id_product, id_category) VALUES (?, ?)");
        foreach ($categories as $catId) {
            $insStmt->execute([$id, $catId]);
        }

        $this->pdo->commit();
    }

    public function getSelectedCategories(int $id): array
    {
        $stmt = $this->pdo->prepare("SELECT id_category FROM product_category WHERE id_product = ?");
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function delete(int $id): void
    {
        $this->pdo->prepare("DELETE FROM product WHERE id_product = ?")->execute([$id]);
    }
    public function getByTagPaginated(string $tag, int $limit, int $offset): array
    {
        $stmt = $this->pdo->prepare("
        SELECT p.*,
            GROUP_CONCAT(c.name_category ORDER BY c.name_category SEPARATOR ', ') AS name_category
        FROM product p
        LEFT JOIN product_category pc ON p.id_product = pc.id_product
        LEFT JOIN category c ON pc.id_category = c.id_category
        WHERE p.tag = ?
        GROUP BY p.id_product
        LIMIT ? OFFSET ?
    ");
        $stmt->bindValue(1, $tag,    PDO::PARAM_STR);
        $stmt->bindValue(2, $limit,  PDO::PARAM_INT);
        $stmt->bindValue(3, $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function countByTag(string $tag): int
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM product WHERE tag = ?");
        $stmt->execute([$tag]);
        return (int)$stmt->fetchColumn();
    }
}
