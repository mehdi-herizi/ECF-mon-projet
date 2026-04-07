<?php
require_once ROOT . 'app/models/User.php';

class UserController
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function profil(): void
    {
        if (!isset($_SESSION['id_user'])) {
            header('Location: ?action=login');
            exit;
        }

        $idUser    = $_SESSION['id_user'];
        $userModel = new User($this->pdo);
        $success   = false;

        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            // Maj Nom/Prénom
            if (isset($_POST['firstname'], $_POST['name'])) {
                $firstname = htmlspecialchars($_POST['firstname']);
                $name      = htmlspecialchars($_POST['name']);
                $userModel->updateInfo($idUser, $firstname, $name);
                $_SESSION['name']      = $name;
                $_SESSION['firstname'] = $firstname;
                $success = "Informations mises à jour !";
            }

            // Maj Avatar
            if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === 0) {
                $allowed = ['jpg', 'jpeg', 'png', 'webp'];
                $ext     = strtolower(pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION));

                if (in_array($ext, $allowed)) {
                    $uploadDir = ROOT . 'public/uploads/avatars/';
                    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

                    $newName = "avatar_" . $idUser . "_" . time() . "." . $ext;

                    if (move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadDir . $newName)) {
                        $userModel->updateAvatar($idUser, $newName);
                        $_SESSION['profile_picture'] = $newName;
                        $success = "Photo de profil mise à jour !";
                    }
                }
            }
        }

        $user          = $userModel->getById($idUser);
        $wishlistItems = $userModel->getWishlist($idUser);
        $mesCommandes  = $userModel->getOrders($idUser);

        require_once ROOT . 'app/views/profil.php';
    }
    public function settings(): void
{
    if (!isset($_SESSION['id_user'])) {
        header('Location: ?action=login');
        exit;
    }

    $idUser    = $_SESSION['id_user'];
    $userModel = new User($this->pdo);
    $error     = null;
    $success   = null;

    if (isset($_POST['update_password'])) {
        $current = $_POST['current_password'] ?? '';
        $new     = $_POST['new_password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';

        if ($new !== $confirm) {
            $error = "Les nouveaux mots de passe ne correspondent pas.";
        } elseif (strlen($new) < 8) {
            $error = "Le nouveau mot de passe doit faire au moins 8 caractères.";
        } else {
            $hash = $userModel->getPassword($idUser);
            if (password_verify($current, $hash)) {
                $userModel->updatePassword($idUser, $new);
                $success = "Mot de passe mis à jour avec succès !";
            } else {
                $error = "Le mot de passe actuel est incorrect.";
            }
        }
    }

    if (isset($_POST['update_email'])) {
        $newEmail = filter_var($_POST['new_email'] ?? '', FILTER_SANITIZE_EMAIL);
        $password = $_POST['confirm_pass_email'] ?? '';

        if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
            $error = "Format d'email invalide.";
        } else {
            $hash = $userModel->getPassword($idUser);
            if (password_verify($password, $hash)) {
                try {
                    $userModel->updateEmail($idUser, $newEmail);
                    $_SESSION['email'] = $newEmail;
                    $success = "Adresse email modifiée avec succès !";
                } catch (PDOException $e) {
                    $error = "Cet email est déjà utilisé par un autre compte.";
                }
            } else {
                $error = "Mot de passe incorrect pour confirmer le changement d'email.";
            }
        }
    }

    require_once ROOT . 'app/views/settings.php';
}
}