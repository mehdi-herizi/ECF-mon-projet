<?php
require_once ROOT . 'app/models/User.php';

class AuthController
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function login(): void
    {
        $errors = [];

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $mail          = trim($_POST["mail"] ?? "");
            $passwordInput = $_POST["motDePasse"] ?? "";

            if (empty($mail) || empty($passwordInput)) {
                $errors[] = "Veuillez remplir tous les champs";
            }

            if (empty($errors)) {
                $userModel = new User($this->pdo);
                $user      = $userModel->findByEmail($mail);

                if ($user && password_verify($passwordInput, $user["password"])) {
                    $_SESSION['id_user']         = $user['id_user'];
                    $_SESSION['name']            = $user['name'];
                    $_SESSION['firstname']       = $user['firstname'];
                    $_SESSION['email']           = $user['email'];
                    $_SESSION['role']            = $user['role'];
                    $_SESSION['profile_picture'] = $user['profile_picture'];

                    header('Location: index.php');
                    exit;
                } else {
                    $errors[] = "Email ou mot de passe incorrect";
                }
            }
        }

        require_once ROOT . 'app/views/login.php';
    }

    public function register(): void
    {
        $errors = [];

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $name              = trim($_POST["name"] ?? "");
            $firstname         = trim($_POST["firstname"] ?? "");
            $phone             = trim($_POST["telephone"] ?? "");
            $birthdate         = $_POST["datedenaissance"] ?? "";
            $mail              = $_POST["mail"] ?? "";
            $password          = $_POST["motDePasse"] ?? "";
            $passwordConfirmed = $_POST["confirmationMotDePasse"] ?? "";

            if (empty($name))      $errors[] = "Veuillez entrer un nom";
            if (empty($firstname)) $errors[] = "Veuillez entrer un prénom";
            if (empty($phone))     $errors[] = "Veuillez entrer un numéro de téléphone";
            if (empty($birthdate)) $errors[] = "Veuillez entrer une date de naissance ";
            if (empty($mail))      $errors[] = "Veuillez entrer un email";
            if (empty($password))  $errors[] = "Veuillez entrer un mot de passe";
            if (empty($passwordConfirmed)) $errors[] = "Veuillez confirmer votre mot de passe";

            $stmt = $this->pdo->prepare("SELECT id_user FROM pb_user WHERE email = ?");
            $stmt->execute([$mail]);
            if ($stmt->fetch()) {
               $errors[] = "Cet email est déjà utilisé";
            }

            if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Format de mail invalide";
            }

            if (empty($password) || $password !== $passwordConfirmed) {
                $errors[] = "Les mots de passe ne correspondent pas";
            }

            if (strlen($password) < 8) {
                $errors[] = "Le mot de passe doit contenir au moins 8 caractères";
            }

            if (empty($errors)) {
                try {
                    $userModel = new User($this->pdo);
                    $userModel->create($name, $firstname, $phone, $birthdate, $mail, $password);
                    header('Location: ?action=home&success=1');
                    exit;
                } catch (PDOException $e) {
                    $errors[] = "Erreur technique : " . $e->getMessage();
                }
            }
        }

        require_once ROOT . 'app/views/register.php';
    }

    public function logout(): void
    {
        $_SESSION = [];

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        session_destroy();
        header("Location: ?action=home");
        exit();
    }
}
