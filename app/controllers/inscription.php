<?php
require 'config.php';

$errors = [];
$confirmed = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? "");
    $firstName = trim($_POST["firstname"] ?? "");
    $numerodetelephone = trim($_POST["telephone"] ?? "");
    $birthdate = $_POST["datedenaissance"] ?? "";
    $mail = $_POST["mail"] ?? "";
    $passwordUser = $_POST["motDePasse"] ?? "";
    $passwordConfirmed = $_POST["confirmationMotDePasse"] ?? "";

    // Validations (Nom, Prénom, Mail, MDP)
    if (empty($name)) { $errors[] = "Veuillez entrer un nom"; }
    if (empty($firstName)) { $errors[] = "Veuillez entrer un prénom"; }
    
    if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format de mail invalide";
    }

    if (empty($passwordUser) || $passwordUser !== $passwordConfirmed) {
        $errors[] = "Les mots de passe ne correspondent pas";
    }

    if (count($errors) === 0) {
        try {
            $passwordHash = password_hash($passwordUser, PASSWORD_DEFAULT);
            // Correction ici : 'phone' au lieu de 'numerotelephone'
            $stmt = $pdo->prepare("INSERT INTO pb_user (name, firstname, phone, birthdate, email, password) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$name, $firstName, $numerodetelephone, $birthdate, $mail, $passwordHash]);
            
            header('Location: index.php?success=1');
            exit;
        } catch (PDOException $e) {
            $errors[] = "Erreur technique : " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Gaming - Inscription</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white font-sans min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md bg-gray-800 rounded-3xl shadow-2xl border border-white/10 p-8">
        
        <div class="text-center mb-8">
            <h1 class="text-3xl font-black uppercase italic tracking-tighter text-blue-500">Master Gaming</h1>
            <p class="text-gray-400 text-sm uppercase tracking-widest mt-2">Rejoins la communauté</p>
        </div>

        <?php if (!empty($errors)): ?>
            <div class="mb-6 p-4 bg-red-500/10 border border-red-500/50 rounded-xl">
                <?php foreach ($errors as $error): ?>
                    <p class="text-red-500 text-xs font-bold">⚠️ <?= $error ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="" method="post" class="space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] uppercase font-bold text-gray-500 ml-2 mb-1">Nom</label>
                    <input name="name" type="text" placeholder="Geralt" class="w-full bg-gray-700 border-none rounded-xl p-3 focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-[10px] uppercase font-bold text-gray-500 ml-2 mb-1">Prénom</label>
                    <input name="firstname" type="text" placeholder="De Riv" class="w-full bg-gray-700 border-none rounded-xl p-3 focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                </div>
            </div>

            <div>
                <label class="block text-[10px] uppercase font-bold text-gray-500 ml-2 mb-1">Téléphone</label>
                <input name="telephone" type="tel" placeholder="06..." class="w-full bg-gray-700 border-none rounded-xl p-3 focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

            <div>
                <label class="block text-[10px] uppercase font-bold text-gray-500 ml-2 mb-1">Date de naissance</label>
                <input type="date" name="datedenaissance" class="w-full bg-gray-700 border-none rounded-xl p-3 focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

            <div>
                <label class="block text-[10px] uppercase font-bold text-gray-500 ml-2 mb-1">Email</label>
                <input type="email" name="mail" placeholder="gaming@master.com" class="w-full bg-gray-700 border-none rounded-xl p-3 focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label class="block text-[10px] uppercase font-bold text-gray-500 ml-2 mb-1">Mot de passe</label>
                    <input type="password" name="motDePasse" class="w-full bg-gray-700 border-none rounded-xl p-3 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-[10px] uppercase font-bold text-gray-500 ml-2 mb-1">Confirmation</label>
                    <input type="password" name="confirmationMotDePasse" class="w-full bg-gray-700 border-none rounded-xl p-3 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-4 rounded-xl uppercase tracking-widest transition-all shadow-lg shadow-blue-900/40 mt-6">
                S'inscrire
            </button>
        </form>

        <p class="text-center text-xs text-gray-500 mt-6">
            Déjà membre ? <a href="connexion.php" class="text-blue-500 hover:underline">Connecte-toi</a>
        </p>
    </div>

</body>
</html>