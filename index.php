<?php 
require 'config.php';

$stmt = $pdo->prepare("SELECT * FROM product");
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

$jeuxTendance = array_filter($products, function($product) {
    return $product['tag'] === 'trending';
});

$jeuxQuiVontSortir = array_filter($products, function($product) {
    return $product['tag'] === 'coming_soon';
});

$nouveauxJeux = array_filter($products, function($product) {
    return $product['tag'] === 'new';
});
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="mon site sert a achete des jeux video ,c'est un e-commerce">
    <title>Master gaming</title>
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/output.css">
  </head>
  <body>
    <header>
      <!-- trailer de mon jeu vitrine -->
      <video
        class="headerVideo"
        autoplay
        muted
        loop
        src="videos-header/elden-ring-header.mp4"
      ></video>
      <!-- mon logo et mes boutons -->
      <div class="hero">
        <nav class="topnav">
          <div id="topnav__logo">
            <a href="index.php"
              ><img
                id="ogol"
                src="images/nexary-blanc.png"
                alt="logo"
                draggable="false"
            /></a>
          </div>
          <div class="btn">
            <a href="catalogue.php" class="tnb">catalogue</a>
            <a href="contact.php" class="tnb">assistance</a>
             <a href="index-connexion.php" class="tnb">connexion</a>
            <a href="index-inscription.php" class="tnb">inscription</a>
          </div>
        </nav>
        <!-- un petit patch pour la vidéo -->
        <div class="cta">
          <h1>Elden Ring</h1>
          <div class="cta__content">
            <p>50€</p>
            <a class="buttum" href="detail.php?id=70">En savoir plus</a>
          </div>
        </div>
      </div>
    </header>
    <!-- pas fini -->
    <main id="contenent">
      <h1 class="text-3xl font-bold underline text-blue-600 ">
  Hello world!
</h1>
      <section id="trending">
        <h2>Nos jeux les plus populaires</h2>
        <div class="products-grid">
          <?php foreach ($jeuxTendance as $product): ?>
            <div class="product-card">
              <img src="<?php echo $product['picture']; ?>" alt="<?php echo $product['name']; ?>">
              <h3><?php echo $product['name']; ?></h3>
              <p><?php echo $product['date_']; ?></p>
              <p><?php echo $product['price']; ?>€</p>
              <a href="detail.php?id=<?php echo $product['id_product']; ?>" class="buttum">En savoir plus</a>
            </div>
          <?php endforeach; ?>
        </div>
      </section>
      <section id="coming_soon">
        <h2>Nos jeux à venir</h2>
        <div class="products-grid">
          <?php foreach ($jeuxQuiVontSortir as $product): ?>
            <div class="product-card">
              <img src="<?php echo $product['picture']; ?>" alt="<?php echo $product['name']; ?>">
              <h3><?php echo $product['name']; ?></h3>
              <p><?php echo $product['date_']; ?></p>
              <p><?php echo $product['price']; ?>€</p>
              <a href="detail.php?id=<?php echo $product['id_product']; ?>" class="buttum">En savoir plus</a>
            </div>
          <?php endforeach; ?>
        </div>
      </section>
      <section id="nouveaux_jeux">
        <h2>Nouveaux jeux</h2>
        <div class="products-grid">
          <?php foreach ($nouveauxJeux as $product): ?>
            <div class="product-card">
              <img src="<?php echo $product['picture']; ?>" alt="<?php echo $product['name']; ?>">
              <h3><?php echo $product['name']; ?></h3>
              <p><?php echo $product['date_']; ?></p>
              <p><?php echo $product['price']; ?>€</p>
              
              <a href="detail.php?id=<?php echo $product['id_product']; ?>" class="buttum">En savoir plus</a>
            </div>
          <?php endforeach; ?>
        </div>
      </section>
    </main>
    <?php 
   require_once 'footer.php';
   ?>
    <!-- <script src="js/index.js"></script> -->
  </body>
</html>
