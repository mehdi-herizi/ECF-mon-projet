<?php
require_once 'config.php';

// Sécurité admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'super_admin') {
    header('Location: index.php');
    exit;
}

// Vérification de l'ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: admin.php');
    exit;
}

$id = (int)$_GET['id'];

// Récupération du produit
$query = $pdo->prepare("SELECT * FROM product WHERE id_product = ?");
$query->execute([$id]);
$product = $query->fetch();

if (!$product) {
    header('Location: admin.php');
    exit;
}

// Récupération de toutes les catégories
$categories = $pdo->query("SELECT * FROM category ORDER BY name_category ASC")->fetchAll();

// Catégories actuellement assignées à ce produit
$stmtCats = $pdo->prepare("SELECT id_category FROM product_category WHERE id_product = ?");
$stmtCats->execute([$id]);
$selectedCategories = $stmtCats->fetchAll(PDO::FETCH_COLUMN); // tableau d'ids

$success = null;
$error   = null;

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name       = trim($_POST['name']);
    $price      = trim($_POST['price']);
    $desc       = trim($_POST['description']);
    $tag        = trim($_POST['tag']);
    $img        = trim($_POST['picture']);
    $video      = trim($_POST['video']);
    $newCats    = isset($_POST['categories']) ? array_map('intval', $_POST['categories']) : [];

    if (empty($name) || empty($price)) {
        $error = "Le nom et le prix sont obligatoires.";
    } elseif (empty($newCats)) {
        $error = "Veuillez sélectionner au moins une catégorie.";
    } else {
        try {
            $pdo->beginTransaction();

            // Mise à jour du produit (sans id_category)
            $stmt = $pdo->prepare("UPDATE product SET 
                name = ?, price = ?, description = ?, 
                tag = ?, picture = ?, video = ? 
                WHERE id_product = ?");
            $stmt->execute([$name, $price, $desc, $tag ?: null, $img, $video, $id]);

            // Mise à jour des catégories dans product_category
            $pdo->prepare("DELETE FROM product_category WHERE id_product = ?")->execute([$id]);
            $insStmt = $pdo->prepare("INSERT INTO product_category (id_product, id_category) VALUES (?, ?)");
            foreach ($newCats as $catId) {
                $insStmt->execute([$id, $catId]);
            }

            $pdo->commit();
            header('Location: admin.php?msg=updated');
            exit;
        } catch (PDOException $e) {
            $pdo->rollBack();
            $error = "Erreur lors de la mise à jour : " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier <?= htmlspecialchars($product['name']) ?> - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#09090b] text-white min-h-screen p-6 md:p-12">

    <div class="max-w-3xl mx-auto space-y-6">

        <!-- Header -->
        <div class="bg-gray-800/80 p-8 rounded-3xl border border-white/10 shadow-2xl flex justify-between items-center">
            <h1 class="text-3xl font-black uppercase italic tracking-tighter">Modifier le jeu</h1>
            <div class="flex items-center gap-4">
                <span class="text-blue-500 font-mono text-sm">ID: #<?= $id ?></span>
                <a href="admin.php" class="text-gray-400 hover:text-white text-xs font-black uppercase tracking-widest transition-colors">
                    ← Retour
                </a>
            </div>
        </div>

        <?php if ($error): ?>
            <div class="bg-red-500/10 border border-red-500 text-red-500 p-4 rounded-2xl font-bold text-sm">
                ⚠️ <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <!-- Aperçu actuel -->
        <?php if (!empty($product['picture'])): ?>
        <div class="bg-gray-800/80 p-6 rounded-3xl border border-white/10 shadow-xl">
            <p class="text-gray-500 text-[10px] font-black uppercase tracking-widest mb-4">Aperçu actuel</p>
            <div class="aspect-video rounded-2xl overflow-hidden">
                <img src="<?= htmlspecialchars($product['picture']) ?>"
                     alt="<?= htmlspecialchars($product['name']) ?>"
                     class="w-full h-full object-cover">
            </div>
        </div>
        <?php endif; ?>

        <!-- Formulaire -->
        <div class="bg-gray-800/80 p-8 rounded-3xl border border-white/10 shadow-2xl">
            <form method="POST" class="space-y-6">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nom -->
                    <div class="md:col-span-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 block mb-2">Nom du jeu *</label>
                        <input type="text" name="name"
                               value="<?= htmlspecialchars($product['name']) ?>"
                               required
                               class="w-full bg-gray-700 rounded-2xl p-4 outline-none focus:ring-2 focus:ring-blue-500 text-white font-bold transition-all border border-white/5">
                    </div>

                    <!-- Prix -->
                    <div>
                        <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 block mb-2">Prix (€) *</label>
                        <input type="number" name="price" step="0.01" min="0"
                               value="<?= htmlspecialchars($product['price']) ?>"
                               required
                               class="w-full bg-gray-700 rounded-2xl p-4 outline-none focus:ring-2 focus:ring-blue-500 text-white font-bold transition-all border border-white/5">
                    </div>

                    <!-- Catégories (multi-sélection) -->
                    <div class="md:col-span-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 block mb-3">Catégories * <span class="text-gray-600 normal-case">(plusieurs possibles)</span></label>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                            <?php foreach ($categories as $cat): ?>
                                <label class="flex items-center gap-3 bg-gray-700 hover:bg-gray-600 p-3 rounded-xl cursor-pointer border border-white/5 hover:border-blue-500 transition-all group">
                                    <input type="checkbox" name="categories[]"
                                           value="<?= $cat['id_category'] ?>"
                                           <?= in_array($cat['id_category'], $selectedCategories) ? 'checked' : '' ?>
                                           class="w-4 h-4 accent-blue-600 cursor-pointer">
                                    <span class="text-xs font-bold text-gray-300 group-hover:text-white transition-colors">
                                        <?= htmlspecialchars($cat['name_category']) ?>
                                    </span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Tag -->
                    <div>
                        <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 block mb-2">Tag</label>
                        <select name="tag"
                                class="w-full bg-gray-700 rounded-2xl p-4 outline-none focus:ring-2 focus:ring-blue-500 text-white font-bold transition-all border border-white/5 cursor-pointer">
                            <?php foreach (['trending', 'coming_soon', 'new'] as $t): ?>
                                <option value="<?= $t ?>" class="bg-gray-800"
                                    <?= $product['tag'] === $t ? 'selected' : '' ?>>
                                    <?= ucfirst(str_replace('_', ' ', $t)) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Image URL -->
                    <div>
                        <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 block mb-2">URL de l'image</label>
                        <input type="text" name="picture"
                               value="<?= htmlspecialchars($product['picture']) ?>"
                               placeholder="https://... ou chemin/relatif.jpg"
                               class="w-full bg-gray-700 rounded-2xl p-4 outline-none focus:ring-2 focus:ring-blue-500 text-white font-bold transition-all border border-white/5">
                    </div>

                    <!-- Vidéo URL -->
                    <div>
                        <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 block mb-2">URL de la vidéo <span class="text-gray-600">(optionnel)</span></label>
                        <input type="text" name="video"
                               value="<?= htmlspecialchars($product['video'] ?? '') ?>"
                               placeholder="https://youtube.com/watch?v=... ou fichier.mp4"
                               class="w-full bg-gray-700 rounded-2xl p-4 outline-none focus:ring-2 focus:ring-blue-500 text-white font-bold transition-all border border-white/5">
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 block mb-2">Description</label>
                        <textarea name="description" rows="5"
                                  placeholder="Description du jeu..."
                                  class="w-full bg-gray-700 rounded-2xl p-4 outline-none focus:ring-2 focus:ring-blue-500 text-white font-bold transition-all border border-white/5 resize-none"><?= htmlspecialchars($product['description'] ?? '') ?></textarea>
                    </div>
                </div>

                <!-- Boutons -->
                <div class="flex flex-col md:flex-row gap-4 pt-4">
                    <button type="submit"
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-black py-4 rounded-2xl uppercase tracking-widest transition-all shadow-lg shadow-blue-900/40">
                        ✅ Enregistrer les modifications
                    </button>
                    <a href="admin.php"
                       class="flex-1 text-center bg-gray-700 hover:bg-gray-600 text-white font-black py-4 rounded-2xl uppercase tracking-widest transition-all border border-white/10">
                        Annuler
                    </a>
                </div>

            </form>
        </div>

    </div>
</body>
</html>