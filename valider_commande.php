<?php
// Vérifier si l'utilisateur possède déjà le jeu
$dejaAchete = false;
if (isset($_SESSION['id_user'])) {
    $checkOwn = $pdo->prepare("SELECT COUNT(*) FROM order_product op 
                               JOIN pb_order o ON op.id_order = o.id_order 
                               WHERE o.id_user = ? AND op.id_product = ?");
    $checkOwn->execute([$_SESSION['id_user'], $id_game]);
    $dejaAchete = $checkOwn->fetchColumn() > 0;
}
?>

<?php if ($dejaAchete): ?>
    <button disabled class="w-full bg-gray-700 text-gray-400 font-black py-5 rounded-2xl uppercase tracking-widest cursor-not-allowed">
        Déjà possédé
    </button>
<?php else: ?>
    <a href="panier_action.php?add=<?= $game['id_product'] ?>" 
       class="block text-center w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-5 rounded-2xl uppercase tracking-widest transition-all shadow-lg transform hover:scale-105">
        Ajouter au panier
    </a>
<?php endif; ?>