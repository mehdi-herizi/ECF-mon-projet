<?php


if (isset($_POST["name"])) {
    $nom = $_POST["name"];
    $prenom = $_POST["firstname"];
    $numero = $_POST["numero"];
    $mail = $_POST["mail"];
    $message = $_POST["Message"];

    echo "<br> $nom <br> $prenom <br> $numero <br> $mail <br> $message";
}

?>