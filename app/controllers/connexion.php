<?php
require 'config.php';

$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mail = trim($_POST["mail"] ?? "");
    $passwordInput = $_POST["motDePasse"] ?? ""; // On récupère la saisie du formulaire

    if (empty($mail) || empty($passwordInput)) {
        $errors[] = "Veuillez remplir tous les champs";
    }

    if (count($errors) === 0) {
        $stmt = $pdo->prepare("SELECT * FROM pb_user WHERE email = ?");
        $stmt->execute([$mail]);
        $user = $stmt->fetch();

        if ($user) {
            // CORRECTION : On utilise $passwordInput (la variable définie plus haut)
            if (password_verify($passwordInput, $user["password"])) {
                
                // On stocke TOUTES les infos nécessaires en session
                $_SESSION['id_user'] = $user['id_user'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['firstname'] = $user['firstname'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];
                
                // TRÈS IMPORTANT : On stocke l'image de profil pour le header
                $_SESSION['profile_picture'] = $user['profile_picture'];
                
                header('Location: index.php');
                exit;
            } else {
                $errors[] = "Mot de passe incorrect";
            }
        } else {
            $errors[] = "Aucun compte trouvé avec cet email";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Gaming - Connexion</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 text-white font-sans min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md bg-gray-800 rounded-3xl shadow-2xl border border-white/10 p-8">

        <div class="text-center mb-10">
            <h1 class="text-3xl font-black uppercase italic tracking-tighter text-blue-500">Master Gaming</h1>
            <p class="text-gray-400 text-sm uppercase tracking-widest mt-2">Bon retour, soldat</p>
        </div>

        <?php if (!empty($errors)): ?>
            <div class="mb-6 p-4 bg-red-500/10 border border-red-500/50 rounded-xl">
                <?php foreach ($errors as $error): ?>
                    <p class="text-red-500 text-xs font-bold text-center">⚠️ <?= $error ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="" method="post" class="space-y-6">
            <div>
                <label class="block text-[10px] uppercase font-bold text-gray-500 ml-2 mb-1">Email</label>
                <input type="email" name="mail" placeholder="votre@email.com"
                    class="w-full bg-gray-700 border-none rounded-xl p-4 focus:ring-2 focus:ring-blue-500 outline-none transition-all placeholder:text-gray-500">
            </div>

            <div>
                <label class="block text-[10px] uppercase font-bold text-gray-500 ml-2 mb-1">Mot de passe</label>
                <input type="password" name="motDePasse" placeholder="••••••••"
                    class="w-full bg-gray-700 border-none rounded-xl p-4 focus:ring-2 focus:ring-blue-500 outline-none transition-all placeholder:text-gray-500">
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-4 rounded-xl uppercase tracking-widest transition-all shadow-lg shadow-blue-900/40">
                Se connecter
            </button>
        </form>

        <div class="text-center mt-8 space-y-2">
            <p class="text-xs text-gray-500">
                Pas encore de compte ? <a href="inscription.php" class="text-blue-500 hover:underline">Inscris-toi ici</a>
            </p>
            <p class="text-xs">
                <a href="index.php" class="text-gray-600 hover:text-gray-400">Retour à l'accueil</a>
            </p>
        </div>
    </div>

</body>

</html>