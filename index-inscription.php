<?php
require 'config.php';

// ANCHOR traitement du formulaire - Validation des données

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? "");
    $firstName = trim($_POST["firstname"] ?? "");
    $numerodetelephone = trim($_POST["telephone"] ?? "");
    $birthdate = $_POST["datedenaissance"] ?? "";
    $mail = $_POST["mail"] ?? "";
    $passwordUser = $_POST["motDePasse"] ?? "";
    $passwordConfirmed = $_POST["confirmationMotDePasse"] ?? "";

    $confirmed = [];

    $errors = [];

    if (empty($name)) {
        $errors[] = "veuillez rentrer un nom";
    } elseif (strlen($name) >= 2 && strlen($name) <= 50) {
        $confirmed[] = "nom validé✅";
    } else {
        $errors[] = "nom pas au norme veuillez rentrez un nom entre 2 et 50 character";
    }


    if (empty($firstName)) {
        $errors[] = "veuillez rentrer un prénom";
    } elseif (strlen($firstName) >= 2 && strlen($firstName) <= 50) {
        $confirmed[] = "prénom validé✅";
    } else {
        $errors[] = "prénom pas au norme veuillez rentrez un prénom entre 2 et 50 character";
    }


    if (empty($mail)) {
        $errors[] = "veuillez rentrer un mail";
    } elseif (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        $confirmed[] = "mail validé✅";
    } else {
        $errors[] = "mail pas vérifier";
    }


    if (empty($passwordUser) || empty($passwordConfirmed)) {
        $errors[] = "veuillez rentrer un mot de passe";
    } elseif ($passwordUser === $passwordConfirmed) {
        $passwordHash = password_hash($passwordUser, PASSWORD_DEFAULT);
        $confirmed[] = "mot de passe validé✅";
    } else {
        $errors[] = "Les mots de passe ne correspondent pas !";
    }



    if (count($errors) === 0) {
        // Requete SQL insertion
        try {
            $stmt = $pdo->prepare("INSERT INTO pb_user (name, firstname,numerotelephone,birthdate, email, password) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$name, $firstName,$numerodetelephone,$birthdate, $mail, $passwordHash]);
           header('Location: index.php');
                    exit;
            
        } catch (PDOException $e) {
            echo "Erreur technique : " . $e->getMessage();
        }
    } else {
        foreach ($errors as $value) {
            echo "<br>" . $value;
        }
    }
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master gaming</title>
    <style>
        .formulaire {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
    </style>
</head>

<body>
    <form class="formulaire" method="post">
        <label for="name"> Nom </label>
        <input id="name" name="name" type="text">
        <label for="firstname"> Prenom </label>
        <input id="firstname" name="firstname" type="text">
        <label for="tel"> Telephone </label>
        <input id="tel" name="telephone" type="tel">
        <label for="datedenaissance"> Date de naissance </label>
        <input type="date" name="datedenaissance" id="datedenaissance">
        <label for="mail"> mail </label>
        <input type="email" name="mail" id="mail">
        <label for="motDePasse"> mot de passe </label>
        <input type="password" name="motDePasse" id="motDePasse">
        <label for="confirmationMotDePasse"> confirmer le mot de passe </label>
        <input type="password" name="confirmationMotDePasse" id="confirmationMotDePasse">
        <button type="submit">s'inscrire</button>
    </form>
</body>

</html>