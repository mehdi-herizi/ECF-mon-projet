<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
class Database
{
    private static ?PDO $instance = null;

    // Constructeur privé : new Database() est interdit de l'extérieur
    private function __construct() {}

    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            self::$instance = new PDO(
                'mysql:host=mysql-server;dbname=Mastergaming;charset=utf8',
                'root',
                'root',
                [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
        }
        return self::$instance;
    }
}
$pdo = Database::getInstance();