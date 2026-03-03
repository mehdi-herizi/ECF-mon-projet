<?php

require 'config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mail = trim($_POST["mail"] ?? "");
    $passwordUser = $_POST["motDePasse"] ?? "";

    $errors = [];

    if (empty($mail) || empty($passwordUser)) {
        $errors[] = "veuillez remplir tous les champs";
    }
    if (count($errors) === 0) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE mail = ?");
        $stmt->execute([$mail]);
        $user = $stmt->fetch();

        if ($user) {
            if (password_verify($passwordUser, $user["password"])) {
                $_SESSION['name'] = $user['name'];
                $_SESSION['firstname'] = $user['firstname'];
                $_SESSION['mail'] = $user['mail'];
                $_SESSION['id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                header('Location: exer16-dashboard.php');
                exit;
            } else {
                echo "mot de passe incorrect";
            }
        } else {
            echo "aucun compte trouvé avec cet email";
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
    <title>Document</title>
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
    <form class="formulaire" action="" method="post">
        <label for="mail"> mail</label>
        <input type="email" name="mail" id="mail">
        <label for="motDePasse"> mot de passe</label>
        <input type="password" name="motDePasse" id="motDePasse">
        <button type="submit">connexion</button>
    </form>
</body>

</html>