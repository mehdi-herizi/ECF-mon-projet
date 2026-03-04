<?php 
require 'config.php';

$stmt = $pdo->prepare("SELECT * FROM product");
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($products as $product) {
    echo $product['name'] . " - " . $product['price'] . "€<br>";
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="mon site sert a achete des jeux video ,c'est un e-commerce">
    <title>Master gaming</title>
    <link rel="stylesheet" href="css/style.css" />
  </head>
  <body>
    <header>
      <!-- trailer de mon jeu vitrine -->
      <video
        class="headerVideo"
        autoplay
        muted
        loop
        src="videos/elden-ring-header.mp4"
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
            <a class="buttum" href="">En savoir plus</a>
          </div>
        </div>
      </div>
    </header>
    <!-- pas fini -->
    <main id="contenent">
      <section id="categorie1"></section>
      <section id="categorie2"></section>
      <section id="categorie3"></section>
    </main>
    <?php 
   require_once 'footer.php';
   ?>
    <!-- <script src="js/index.js"></script> -->
  </body>
</html>
