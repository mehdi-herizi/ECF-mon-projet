<?php
require 'config.php';


if (isset($_POST["name"])) {
    $nom = $_POST["name"];
    $prenom = $_POST["firstname"];
    $numero = $_POST["numero"];
    $mail = $_POST["mail"];
    $message = $_POST["Message"];

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <meta name="description" content="mon site sert a achete des jeux video ,c'est un e-commerce">
  <title>Master gaming</title>
  <link rel="stylesheet" href="css/header.css" />
    <link rel="stylesheet" href="css/contact.css">
</head>

<body>
   <?php 
   require_once 'header.php';
   ?>
    <!-- pas finie -->
  <main class="contact">
    <form class="place" action="" method="post">
      <div class="form">
        <label class="titre">
          <strong> Contactez-nous </strong>
        </label>
      </div>
      <div class="form">
        <label class="titre" for="firstname">
          <strong> Prénom </strong>
        </label>
        <input name="firstname" type="text" id="firstname"/>
      </div>
      <div class="form">
        <label class="titre" for="name">
          <strong> Nom </strong>
        </label>
        <input name="name" type="text" id="name"/>
      </div>
      <div class="form">
        <label class="titre" for="mail">
          <strong> Mail </strong>
        </label>
        <input name="mail" type="email" id="mail"/>
      </div>
      <div class="form">
        <label class="titre" for="numeroDeTelephone">
          <strong> Telephone </strong>
        </label>
        <input name="numero" type="tel" id="numeroDeTelephone" />
      </div>
      <div class="form">
        <label class="titre" for="message">
          <strong> Message </strong>
        </label>
      </div>
      <div class="env">
        <textarea name="Message" id="message"></textarea>
        <div class="envoyer">
          <input type="submit" value="Envoyer">
        </div>
      </div>
    </form>
  </main>
  <?php 
   require_once 'footer.php';
   ?>
</body>

</html>