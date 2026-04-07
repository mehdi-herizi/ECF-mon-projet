<?php
class User
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findByEmail(string $email): array|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM pb_user WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public function create(string $name, string $firstname, string $phone, string $birthdate, string $email, string $password): void
    {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("INSERT INTO pb_user (name, firstname, phone, birthdate, email, password) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $firstname, $phone, $birthdate, $email, $passwordHash]);
    }

    public function isInWishlist(int $idUser, int $idProduct): bool
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM wishlist WHERE id_user = ? AND id_product = ?");
        $stmt->execute([$idUser, $idProduct]);
        return $stmt->fetchColumn() > 0;
    }

    public function toggleWishlist(int $idUser, int $idProduct): void
    {
        $check = $this->pdo->prepare("SELECT * FROM wishlist WHERE id_user = ? AND id_product = ?");
        $check->execute([$idUser, $idProduct]);

        if ($check->fetch()) {
            $stmt = $this->pdo->prepare("DELETE FROM wishlist WHERE id_user = ? AND id_product = ?");
        } else {
            $stmt = $this->pdo->prepare("INSERT INTO wishlist (id_user, id_product) VALUES (?, ?)");
        }

        $stmt->execute([$idUser, $idProduct]);
    }
    public function getById(int $idUser): array|false
{
    $stmt = $this->pdo->prepare("SELECT * FROM pb_user WHERE id_user = ?");
    $stmt->execute([$idUser]);
    return $stmt->fetch();
}

public function updateInfo(int $idUser, string $firstname, string $name): void
{
    $stmt = $this->pdo->prepare("UPDATE pb_user SET firstname = ?, name = ? WHERE id_user = ?");
    $stmt->execute([$firstname, $name, $idUser]);
}

public function updateAvatar(int $idUser, string $filename): void
{
    $stmt = $this->pdo->prepare("UPDATE pb_user SET profile_picture = ? WHERE id_user = ?");
    $stmt->execute([$filename, $idUser]);
}

public function getWishlist(int $idUser): array
{
    $stmt = $this->pdo->prepare("
        SELECT p.*, c.name_category
        FROM wishlist w
        JOIN product p ON w.id_product = p.id_product
        LEFT JOIN category c ON p.id_category = c.id_category
        WHERE w.id_user = ?
        ORDER BY w.added_at DESC
    ");
    $stmt->execute([$idUser]);
    return $stmt->fetchAll();
}

public function getOrders(int $idUser): array
{
    $stmt = $this->pdo->prepare("
        SELECT o.id_order, o.order_date, o.status, p.name, p.price, p.picture
        FROM pb_order o
        JOIN order_product op ON o.id_order = op.id_order
        JOIN product p ON op.id_product = p.id_product
        WHERE o.id_user = ?
        ORDER BY o.order_date DESC
    ");
    $stmt->execute([$idUser]);
    return $stmt->fetchAll();
}
public function getAll(string $recherche = ''): array
{
    if ($recherche !== '') {
        $stmt = $this->pdo->prepare("SELECT * FROM pb_user WHERE name LIKE ? OR firstname LIKE ? OR email LIKE ? ORDER BY id_user ASC");
        $stmt->execute(['%'.$recherche.'%', '%'.$recherche.'%', '%'.$recherche.'%']);
    } else {
        $stmt = $this->pdo->query("SELECT * FROM pb_user ORDER BY id_user ASC");
    }
    return $stmt->fetchAll();
}

public function getStats(): array
{
    return $this->pdo->query("SELECT role, COUNT(*) as nb FROM pb_user GROUP BY role")->fetchAll(PDO::FETCH_KEY_PAIR);
}

public function getUsersActivity(): array
{
    $stmt = $this->pdo->prepare("
        SELECT u.id_user, u.firstname, u.name, u.email,
            (SELECT COUNT(DISTINCT op.id_product)
             FROM pb_order o
             JOIN order_product op ON o.id_order = op.id_order
             WHERE o.id_user = u.id_user) as total_achats,
            (SELECT COUNT(*) FROM wishlist WHERE id_user = u.id_user) as total_likes
        FROM pb_user u
        WHERE u.role != 'super_admin'
        ORDER BY total_achats DESC
    ");
    $stmt->execute();
    return $stmt->fetchAll();
}

public function changeRole(int $idUser, string $role): void
{
    $stmt = $this->pdo->prepare("UPDATE pb_user SET role = ? WHERE id_user = ?");
    $stmt->execute([$role, $idUser]);
}

public function deleteUser(int $idUser): void
{
    $this->pdo->prepare("DELETE FROM pb_user WHERE id_user = ?")->execute([$idUser]);
}

public function emailExists(string $email): bool
{
    $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM pb_user WHERE email = ?");
    $stmt->execute([$email]);
    return $stmt->fetchColumn() > 0;
}

public function addUser(string $firstname, string $name, string $email, string $birthdate, string $phone, string $role, string $password): void
{
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $this->pdo->prepare("INSERT INTO pb_user (firstname, name, email, birthdate, phone, role, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$firstname, $name, $email, $birthdate, $phone, $role, $hash]);
}
public function getOrder(int $idUser): array
{
    $stmt = $this->pdo->prepare("
        SELECT o.id_order, o.order_date, o.status,
            GROUP_CONCAT(p.name SEPARATOR ', ') as produits,
            SUM(p.price) as total_calcule
        FROM pb_order o
        JOIN order_product op ON o.id_order = op.id_order
        JOIN product p ON op.id_product = p.id_product
        WHERE o.id_user = ?
        GROUP BY o.id_order
        ORDER BY o.order_date DESC
    ");
    $stmt->execute([$idUser]);
    return $stmt->fetchAll();
}

public function getWishlistItems(int $idUser): array
{
    $stmt = $this->pdo->prepare("
        SELECT p.* FROM wishlist w
        JOIN product p ON w.id_product = p.id_product
        WHERE w.id_user = ?
    ");
    $stmt->execute([$idUser]);
    return $stmt->fetchAll();
}
public function getPassword(int $idUser): string
{
    $stmt = $this->pdo->prepare("SELECT password FROM pb_user WHERE id_user = ?");
    $stmt->execute([$idUser]);
    return $stmt->fetchColumn();
}

public function updatePassword(int $idUser, string $newPassword): void
{
    $hash = password_hash($newPassword, PASSWORD_DEFAULT);
    $stmt = $this->pdo->prepare("UPDATE pb_user SET password = ? WHERE id_user = ?");
    $stmt->execute([$hash, $idUser]);
}

public function updateEmail(int $idUser, string $email): void
{
    $stmt = $this->pdo->prepare("UPDATE pb_user SET email = ? WHERE id_user = ?");
    $stmt->execute([$email, $idUser]);
}
}
