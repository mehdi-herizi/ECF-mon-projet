<?php
require_once 'config.php';

// Accès réservé aux super_admin uniquement
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'super_admin') {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: super_admin.php');
    exit;
}

$action = $_POST['action'] ?? '';

// ============================================================
// ACTION : Changer le rôle d'un utilisateur
// ============================================================
if ($action === 'change_role') {
    $id_user = (int)($_POST['id_user'] ?? 0);
    $role    = $_POST['role'] ?? '';

    // Impossible de se modifier soi-même
    if ($id_user === (int)$_SESSION['id_user']) {
        header('Location: super_admin.php?msg=cannot_self');
        exit;
    }

    $rolesValides = ['user', 'admin', 'super_admin'];
    if (!in_array($role, $rolesValides) || $id_user <= 0) {
        header('Location: super_admin.php?msg=error');
        exit;
    }

    try {
        $stmt = $pdo->prepare("UPDATE pb_user SET role = ? WHERE id_user = ?");
        $stmt->execute([$role, $id_user]);
        header('Location: super_admin.php?msg=role_updated');
    } catch (PDOException $e) {
        header('Location: super_admin.php?msg=error');
    }
    exit;
}

// ============================================================
// ACTION : Supprimer un utilisateur
// ============================================================
if ($action === 'delete_user') {
    $id_user = (int)($_POST['id_user'] ?? 0);

    // Impossible de se supprimer soi-même
    if ($id_user === (int)$_SESSION['id_user']) {
        header('Location: super_admin.php?msg=cannot_self');
        exit;
    }

    if ($id_user <= 0) {
        header('Location: super_admin.php?msg=error');
        exit;
    }

    try {
        // Les commandes et la wishlist sont supprimées en CASCADE via les FK
        $stmt = $pdo->prepare("DELETE FROM pb_user WHERE id_user = ?");
        $stmt->execute([$id_user]);
        header('Location: super_admin.php?msg=user_deleted');
    } catch (PDOException $e) {
        header('Location: super_admin.php?msg=error');
    }
    exit;
}

// ============================================================
// ACTION : Ajouter un utilisateur manuellement
// ============================================================
if ($action === 'add_user') {
    $firstname = trim($_POST['firstname'] ?? '');
    $name      = trim($_POST['name']      ?? '');
    $email     = trim($_POST['email']     ?? '');
    $birthdate = trim($_POST['birthdate'] ?? '');
    $phone     = trim($_POST['phone']     ?? '') ?: null;
    $role      = $_POST['role']           ?? 'user';
    $password  = $_POST['password']       ?? '';

    $rolesValides = ['user', 'admin', 'super_admin'];

    // Validation
    if (empty($firstname) || empty($name) || empty($email) || empty($birthdate) || empty($password)) {
        header('Location: super_admin.php?msg=missing_fields');
        exit;
    }

    if (!in_array($role, $rolesValides)) {
        header('Location: super_admin.php?msg=error');
        exit;
    }

    // Vérifier si l'email existe déjà
    $check = $pdo->prepare("SELECT COUNT(*) FROM pb_user WHERE email = ?");
    $check->execute([$email]);
    if ($check->fetchColumn() > 0) {
        header('Location: super_admin.php?msg=email_exists');
        exit;
    }

    $hash = password_hash($password, PASSWORD_BCRYPT);

    try {
        $stmt = $pdo->prepare("
            INSERT INTO pb_user (firstname, name, email, birthdate, phone, role, password, profile_picture)
            VALUES (?, ?, ?, ?, ?, ?, ?, 'default-avatar.png')
        ");
        $stmt->execute([$firstname, $name, $email, $birthdate, $phone, $role, $hash]);
        header('Location: super_admin.php?msg=user_added');
    } catch (PDOException $e) {
        header('Location: super_admin.php?msg=error');
    }
    exit;
}

// Fallback
header('Location: super_admin.php');
exit;