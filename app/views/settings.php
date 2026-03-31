<?php
require_once 'config.php';

// Sécurité : Redirection si non connecté
if (!isset($_SESSION['id_user'])) {
    header('Location: connexion.php');
    exit;
}

$error = null;
$success = null;

// --- 1. LOGIQUE CHANGEMENT MOT DE PASSE ---
if (isset($_POST['update_password'])) {
    $current = $_POST['current_password'];
    $new = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];

    if ($new !== $confirm) {
        $error = "Les nouveaux mots de passe ne correspondent pas.";
    } elseif (strlen($new) < 8) {
        $error = "Le nouveau mot de passe doit faire au moins 8 caractères.";
    } else {
        $stmt = $pdo->prepare("SELECT password FROM pb_user WHERE id_user = ?");
        $stmt->execute([$_SESSION['id_user']]);
        $user = $stmt->fetch();

        if (password_verify($current, $user['password'])) {
            $hashed = password_hash($new, PASSWORD_DEFAULT);
            $update = $pdo->prepare("UPDATE pb_user SET password = ? WHERE id_user = ?");
            $update->execute([$hashed, $_SESSION['id_user']]);
            $success = "Sécurité mise à jour avec succès !";
        } else {
            $error = "Le mot de passe actuel est incorrect.";
        }
    }
}

// --- 2. LOGIQUE CHANGEMENT EMAIL ---
if (isset($_POST['update_email'])) {
    $new_email = filter_var($_POST['new_email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['confirm_pass_email'];

    if (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
        $error = "Format d'email invalide.";
    } else {
        $stmt = $pdo->prepare("SELECT password FROM pb_user WHERE id_user = ?");
        $stmt->execute([$_SESSION['id_user']]);
        $user = $stmt->fetch();

        if (password_verify($password, $user['password'])) {
            try {
                $update = $pdo->prepare("UPDATE pb_user SET email = ? WHERE id_user = ?");
                $update->execute([$new_email, $_SESSION['id_user']]);
                $_SESSION['email'] = $new_email; // Mise à jour de la session
                $success = "Votre adresse email a été modifiée.";
            } catch (PDOException $e) {
                $error = "Cet email est déjà utilisé par un autre compte.";
            }
        } else {
            $error = "Mot de passe incorrect pour confirmer le changement d'email.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paramètres - Master Gaming</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white font-sans min-h-screen">

    <?php require_once 'header.php'; ?>

    <main class="max-w-4xl mx-auto px-4 py-12">
        <h2 class="text-4xl font-black uppercase italic mb-10 tracking-tighter border-l-8 border-blue-600 pl-6">
            Paramètres <span class="text-blue-500">Compte</span>
        </h2>

        <?php if ($error): ?>
            <div class="bg-red-500/10 border border-red-500 text-red-500 p-4 rounded-2xl mb-6 font-bold text-sm">
                ⚠️ <?= $error ?>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="bg-green-500/10 border border-green-500 text-green-500 p-4 rounded-2xl mb-6 font-bold text-sm">
                ✅ <?= $success ?>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 gap-8">
            
            <section class="bg-gray-800 p-8 rounded-3xl border border-white/10 shadow-xl">
                <h3 class="text-lg font-bold mb-6 flex items-center gap-2 uppercase tracking-widest text-gray-400">
                    <span class="text-blue-500">📧</span> Modifier l'email
                </h3>
                <form action="" method="post" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="email" name="new_email" placeholder="Nouvel Email" required
                               class="w-full bg-gray-700 rounded-2xl p-4 outline-none focus:ring-2 focus:ring-blue-500 text-white">
                        <input type="password" name="confirm_pass_email" placeholder="Mot de passe actuel" required
                               class="w-full bg-gray-700 rounded-2xl p-4 outline-none focus:ring-2 focus:ring-blue-500 text-white">
                    </div>
                    <button name="update_email" class="w-full md:w-auto px-8 bg-gray-700 hover:bg-blue-600 py-3 rounded-xl font-black uppercase text-xs tracking-widest transition-all">
                        Changer mon email
                    </button>
                </form>
            </section>

            <section class="bg-gray-800 p-8 rounded-3xl border border-white/10 shadow-xl">
                <h3 class="text-lg font-bold mb-6 flex items-center gap-2 uppercase tracking-widest text-gray-400">
                    <span class="text-blue-500">🔒</span> Sécurité du mot de passe
                </h3>
                <form action="" method="post" class="space-y-6">
                    <input type="password" name="current_password" placeholder="Mot de passe actuel" required
                           class="w-full bg-gray-700 rounded-2xl p-4 outline-none focus:ring-2 focus:ring-blue-500">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="password" name="new_password" placeholder="Nouveau mot de passe" required
                               class="w-full bg-gray-700 rounded-2xl p-4 outline-none border border-white/5">
                        <input type="password" name="confirm_password" placeholder="Confirmer le nouveau" required
                               class="w-full bg-gray-700 rounded-2xl p-4 outline-none border border-white/5">
                    </div>
                    
                    <button name="update_password" class="w-full bg-blue-600 hover:bg-blue-700 py-4 rounded-2xl font-black uppercase tracking-widest transition-all shadow-lg shadow-blue-900/40">
                        Mettre à jour le mot de passe
                    </button>
                </form>
            </section>

        </div>
    </main>

    <?php require_once 'footer.php'; ?>
</body>
</html>