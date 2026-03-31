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
}
