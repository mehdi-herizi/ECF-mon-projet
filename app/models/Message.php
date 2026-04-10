<?php
class Message
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll(): array
    {
        return $this->pdo->query("SELECT * FROM contact_messages ORDER BY created_at DESC")->fetchAll();
    }

    public function delete(int $id): void
    {
        $this->pdo->prepare("DELETE FROM contact_messages WHERE id_message = ?")->execute([$id]);
    }
    public function create(string $firstname, string $name, string $email, string $phone, string $message): void
{
    $stmt = $this->pdo->prepare("INSERT INTO contact_messages (firstname, name, email, phone, message) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$firstname, $name, $email, $phone, $message]);
}
}