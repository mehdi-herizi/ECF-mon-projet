<?php
/**
 * Script pour générer un INSERT product complet avec catégories
 * Lit depuis database_backup.sql (VERSION AVEC IMAGES ET DATES CORRIGÉES)
 */

// Les données des jeux avec leurs catégories
$games = [
    ['name' => 'ARC Raiders', 'price' => '39.99', 'date' => '2023-09-01', 'cat' => 1],
    ['name' => 'ARK: Survival Ascended', 'price' => '44.99', 'date' => '2024-10-23', 'cat' => 15],
];

echo "Vous devez fournir le fichier database.sql complet avec les descriptions et images.\n";
echo "Je vais générer un script pour ajouter les catégories.\n";
?>
