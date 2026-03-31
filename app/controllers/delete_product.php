<?php
require_once 'config/db.php';

// On récupère l'ID depuis l'URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Préparation de la requête de suppression
    $delete = $pdo->prepare("DELETE FROM product WHERE id_product = ?");
    
    if ($delete->execute([$id])) {
        // Redirection vers l'admin avec un message de succès (optionnel)
        header("Location: admin.php?msg=supprime");
        exit();
    }
}
?>