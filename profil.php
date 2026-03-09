<?php
require_once 'config.php';

if (!isset($_SESSION['email'])) {
    header('Location: connexion.php');
    exit;
}

$success = false;
$error = null;

// 1. Récupération des informations fraîches de l'utilisateur
$stmt = $pdo->prepare("SELECT * FROM pb_user WHERE email = ?");
$stmt->execute([$_SESSION['email']]);
$user = $stmt->fetch();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // --- GESTION DU NOM ET PRÉNOM ---
    if (isset($_POST['firstname']) && isset($_POST['name'])) {
        $firstname = htmlspecialchars($_POST['firstname']);
        $name = htmlspecialchars($_POST['name']);

        $updateInfo = $pdo->prepare("UPDATE pb_user SET firstname = ?, name = ? WHERE email = ?");
        $updateInfo->execute([$firstname, $name, $_SESSION['email']]);

        // Mise à jour des variables pour l'affichage immédiat
        $_SESSION['firstname'] = $firstname;
        $user['firstname'] = $firstname;
        $user['name'] = $name;
        $success = "Informations mises à jour !";
    }

    // --- GESTION DE L'IMAGE (AVATAR) ---
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        $filename = $_FILES['avatar']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        if (in_array($ext, $allowed)) {
            $upload_dir = "uploads/avatars/";

            // Création du dossier s'il n'existe pas
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            // Nom unique pour l'image
            $new_name = "avatar_" . $user['id_user'] . "_" . time() . "." . $ext;
            $destination = $upload_dir . $new_name;

            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $destination)) {
                // Mise à jour Base de données
                $updatePic = $pdo->prepare("UPDATE pb_user SET profile_picture = ? WHERE email = ?");
                $updatePic->execute([$new_name, $_SESSION['email']]);

                // --- CRUCIAL : Mise à jour de la SESSION pour le Header ---
                $_SESSION['profile_picture'] = $new_name;

                // Mise à jour de la variable locale pour l'affichage de la page actuelle
                $user['profile_picture'] = $new_name;
                $success = "Photo de profil mise à jour !";
            } else {
                $error = "Erreur lors du déplacement du fichier.";
            }
        } else {
            $error = "Format non supporté (JPG, PNG, WEBP uniquement).";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Mon Profil - Master Gaming</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 text-white font-sans min-h-screen">

    <?php require_once 'header.php'; ?>

    <main class="max-w-4xl mx-auto px-4 py-12">

        <div class="flex items-center gap-4 mb-10">
            <div class="w-16 h-16 bg-blue-600 rounded-2xl flex items-center justify-center text-3xl font-black italic shadow-lg shadow-blue-900/40">
                <?= strtoupper(substr($user['firstname'], 0, 1)) ?>
            </div>
            <div>
                <h2 class="text-3xl font-black uppercase italic tracking-tighter">Mon <span class="text-blue-500">Profil</span></h2>
                <p class="text-gray-400 text-xs uppercase tracking-widest">Gérez vos accès et informations</p>
            </div>
        </div>
        <?php
        // Requête pour récupérer les commandes de l'utilisateur avec le nom des jeux
        $stmt = $pdo->prepare("
    SELECT o.id_order, o.order_date, o.status, p.name, p.price
    FROM pb_order o
    JOIN order_product op ON o.id_order = op.id_order
    JOIN product p ON op.id_product = p.id_product
    WHERE o.id_user = ?
    ORDER BY o.order_date DESC
");
        $stmt->execute([$_SESSION['id_user']]);
        $mesCommandes = $stmt->fetchAll();
        ?>

        <div class="mt-12">
            <h2 class="text-2xl font-black uppercase italic mb-6">Mes Commandes</h2>
            <div class="space-y-4">
                <?php foreach ($mesCommandes as $co): ?>
                    <div class="bg-gray-800 p-4 rounded-2xl border border-white/5 flex justify-between items-center">
                        <div>
                            <p class="text-[10px] text-gray-500 font-bold uppercase"><?= date('d/m/Y', strtotime($co['order_date'])) ?></p>
                            <p class="text-white font-bold italic"><?= htmlspecialchars($co['name']) ?></p>
                        </div>
                        <div class="text-right">
                            <p class="text-blue-500 font-black"><?= $co['price'] ?>€</p>
                            <span class="text-[8px] bg-green-500/20 text-green-500 px-2 py-1 rounded-full uppercase"><?= $co['status'] ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            <div class="space-y-6">
                <div class="bg-gray-800 p-6 rounded-3xl border border-white/10 shadow-xl text-center">
                    <p class="text-gray-500 text-[10px] font-bold uppercase mb-1">Statut du compte</p>
                    <span class="px-4 py-1 bg-blue-500/10 text-blue-400 border border-blue-500/50 rounded-full text-xs font-black uppercase">
                        <?= htmlspecialchars($user['role']) ?>
                    </span>

                    <hr class="my-6 border-white/5">

                    <p class="text-gray-500 text-[10px] font-bold uppercase mb-1">Email (non modifiable)</p>
                    <p class="text-sm font-bold text-gray-300 truncate px-2"><?= htmlspecialchars($user['email']) ?></p>
                </div>
            </div>

            <div class="md:col-span-2">
                <div class="bg-gray-800 p-8 rounded-3xl border border-white/10 shadow-xl">

                    <?php if ($success): ?>
                        <div class="mb-6 p-4 bg-green-500/10 border border-green-500 text-green-500 rounded-xl text-sm font-bold text-center">
                            ✅ <?= $success ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($error): ?>
                        <div class="mb-6 p-4 bg-red-500/10 border border-red-500 text-red-500 rounded-xl text-sm font-bold text-center">
                            ⚠️ <?= $error ?>
                        </div>
                    <?php endif; ?>

                    <form action="" method="post" enctype="multipart/form-data" class="space-y-6">
                        <div class="flex flex-col items-center mb-8">
                            <div class="relative group">
                                <?php
                                $avatarPath = !empty($user['profile_picture']) ? 'uploads/avatars/' . $user['profile_picture'] : 'images/default-avatar.png';
                                ?>
                                <img src="<?= $avatarPath ?>"
                                    class="w-32 h-32 rounded-3xl object-cover border-4 border-blue-600 shadow-2xl shadow-blue-900/40"
                                    alt="Avatar">

                                <label for="avatar-upload" class="absolute inset-0 flex items-center justify-center bg-black/60 rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer text-[10px] font-black uppercase text-white text-center p-2">
                                    Changer la photo
                                </label>
                                <input type="file" id="avatar-upload" name="avatar" class="hidden" onchange="this.form.submit()">
                            </div>
                            <p class="text-gray-500 text-[10px] uppercase font-bold mt-4 italic">Cliquez sur l'image pour la modifier</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="text-[10px] uppercase font-bold text-gray-500 ml-2">Prénom</label>
                                <input name="firstname" type="text" value="<?= htmlspecialchars($user['firstname']) ?>" class="w-full bg-gray-700 border-none rounded-2xl p-4 focus:ring-2 focus:ring-blue-500 outline-none text-white transition-all">
                            </div>
                            <div>
                                <label class="text-[10px] uppercase font-bold text-gray-500 ml-2">Nom</label>
                                <input name="name" type="text" value="<?= htmlspecialchars($user['name']) ?>" class="w-full bg-gray-700 border-none rounded-2xl p-4 focus:ring-2 focus:ring-blue-500 outline-none text-white transition-all">
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-4 rounded-2xl uppercase tracking-widest transition-all shadow-lg shadow-blue-900/20">
                            Mettre à jour mes infos
                        </button>
                    </form>
                </div>

                <div class="mt-8 p-6 bg-red-500/5 border border-red-500/20 rounded-3xl flex justify-between items-center">
                    <div>
                        <h4 class="text-red-500 font-bold uppercase text-xs">Zone de danger</h4>
                        <p class="text-gray-500 text-[10px]">Action irréversible sur votre compte</p>
                    </div>
                    <a href="delete_account.php" onclick="return confirm('Êtes-vous sûr de vouloir supprimer votre compte ?')" class="text-red-500 hover:text-white border border-red-500 px-4 py-2 rounded-xl text-[10px] font-black uppercase transition-all hover:bg-red-500">
                        Supprimer le compte
                    </a>
                </div>
            </div>
        </div>
    </main>

    <?php require_once 'footer.php'; ?>
</body>

</html>