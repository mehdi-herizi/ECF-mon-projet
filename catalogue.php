<?php 
require_once 'config.php';

$idCategory = null;
$Prix = null;

if (isset($_GET['SelectionnerGenre']) && $_GET['SelectionnerGenre'] !== 'tout')
    $idCategory = (int)$_GET['SelectionnerGenre'];

$stmtCategories = $pdo->query("SELECT id_category, name FROM category ORDER BY name ASC");
$categories = $stmtCategories->fetchAll();

$conditions = [];
$params = [];

if ($idCategory) {
    $conditions[] = "p.id_category = ?";
    $params[] = $idCategory;
}

$sql = "SELECT p.*, c.name AS category_name FROM product p 
        JOIN category c ON p.id_category = c.id_category";

if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$resultats = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Mon site sert à acheter des jeux vidéo, c'est un e-commerce">
    <title>Master gaming</title>
    <link rel="stylesheet" href="css/header.css" />
    <link rel="stylesheet" href="css/catalogue.css" />
  </head>
  <body>
    <?php require_once 'header.php'; ?>

    <main id="catalogue">
      <form method="get">
        <select name="SelectionnerGenre" id="genre">
          <option value="tout" <?= !$idCategory ? 'selected' : '' ?>>Toutes les catégories</option>
          <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat['id_category'] ?>"
              <?= $idCategory === (int)$cat['id_category'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($cat['name']) ?>
            </option>
          <?php endforeach; ?>
        </select>
        <button type="submit">Filtrer</button>
      </form>

      <div>
        <?php if (count($resultats) > 0): ?>
          <div class="product-grid">
            <?php foreach ($resultats as $produit): ?>
              <div class="product-card">
                <!-- ✅ $produit['picture'] et non $images['picture'] -->
                <img src="<?= htmlspecialchars($produit['picture']) ?>" 
                     alt="<?= htmlspecialchars($produit['name']) ?>">
                <h3><?= htmlspecialchars($produit['name']) ?></h3>
                <p><?= htmlspecialchars($produit['category_name']) ?></p>
                <p><?= number_format($produit['price'], 2) ?> €</p>
                <a href="detail.php?id=<?= $produit['id_product'] ?>">Voir les détails</a>
              </div>
            <?php endforeach; ?>
          </div>
        <?php else: ?>
          <p>Aucun produit trouvé pour cette catégorie.</p>
        <?php endif; ?>
      </div>

    </main>

    <?php require_once 'footer.php'; ?>
  </body>
</html>