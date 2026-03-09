<?php 
require 'config.php';
$stmt=$pdo->prepare("SELECT * FROM product");
$stmt->execute();
$products=$stmt->fetchAll();

echo json_encode($products);

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="mon site sert a achete des jeux video ,c'est un e-commerce">
    <title>Master gaming</title>
    <link rel="stylesheet" href="css/header.css" />
    <link rel="stylesheet" href="css/catalogue.css" />
  </head>
  <body>
    <?php 
    require_once 'header.php';
    ?>
    <!-- mon systeme de categorie -->
    <main id="catalogue">
 <div id="categorie">
      <select name="" id="genres">
        <option value="none">Tous les jeux</option>
        <option value="fps">FPS</option>
        <option value="aventure">Aventure</option>
        <option value="action">Action</option>
        <option value="rpg">RPG</option>
        <option value="mmorpg">MMORPG</option>
        <option value="énigme">énigme</option>
        <option value="arcade">Arcade</option>
        <option value="extraction shooter">Extraction shooter</option>
        <option value="tir à la troisième personne">
          Tir à la troisième personne
        </option>
        <option value="survie">Survie</option>
        <option value="monde ouvert">monde Ouvert</option>
        <option value="multijoueurs">Multijoueurs</option>
        <option value="tower defense (sauver le monde)">
          Tower defense (sauver le monde)
        </option>
        <option value="battle royale">Battle Royale</option>
        <option value="tir à la troisième personne (battle royale)">
          Tir à la troisième personne (battle royale)
        </option>
        <option value="tir à la troisième personne (créatif)">
          Tir à la troisième personne (créatif)
        </option>
        <option value="sandbox">Sandbox</option>
        <option value="conduite">Conduite</option>
        <option value="moba">MOBA</option>
        <option value="bac à sable">Bac à sable</option>
        <option value="tir à la première personne (fps)">
          Tir à la première personne (fps)
        </option>
        <option value="course">Course</option>
        <option value="football">Football</option>
        <option value="tps">TPS</option>
        <option value="science-fiction">Science-fiction</option>
        <option value="tir tactique">Tir tactique</option>
        <option value="hero shooter">Hero shooter</option>
      </select>
    </div>
    <div>
    </div>
  X<h2>Notre catalogue</h2>
        <div class="products">
          <?php foreach ($products as $product): ?>
            <div class="product">
              <img src="<?php echo $product['picture']; ?>" alt="<?php echo $product['name']; ?>">
              <h3><?php echo $product['name']; ?></h3>
              <p><?php echo $product['price']; ?>€</p>
      
              <a href="detail.php?id=<?php echo $product['id_product']; ?>" class="buttum">En savoir plus</a>
            </div>
          <?php endforeach; ?>
        </div>
        </div>
    </main>
         
   
    <!-- footer pas terminé amelioration en vue -->
   <?php 
   require_once 'footer.php';
   ?>
    <!-- <script src="js/catalogue.js"></script> -->
  </body>
</html>
