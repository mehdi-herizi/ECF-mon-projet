<?php
require 'config.php';

function getGamesByTag($pdo, $tag, $limit = 8)
{
  $query = "SELECT p.*, c.name_category 
              FROM product p
              LEFT JOIN category c ON p.id_category = c.id_category 
              WHERE p.tag = :tag
              LIMIT :limit";
  $stmt = $pdo->prepare($query);
  $stmt->bindValue(':tag', $tag, PDO::PARAM_STR);
  $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
  $stmt->execute();
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$jeuxTendance      = getGamesByTag($pdo, 'trending');
$jeuxQuiVontSortir = getGamesByTag($pdo, 'coming_soon');
$nouveauxJeux      = getGamesByTag($pdo, 'new');
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Master Gaming — votre e-commerce pour acheter les meilleurs jeux vidéo.">
  <title>Master Gaming</title>
  <link rel="stylesheet" href="css/output.css">
  <style>
    #menu-toggle:checked~label span:nth-child(1) {
      transform: translateY(10px) rotate(45deg);
    }

    #menu-toggle:checked~label span:nth-child(2) {
      opacity: 0;
    }

    #menu-toggle:checked~label span:nth-child(3) {
      transform: translateY(-10px) rotate(-45deg);
    }
  </style>
</head>

<body class="bg-gray-900 text-white font-sans">

  <!-- HEADER INDEX -->
  <header class="relative w-full bg-black flex flex-col">
    <div class="relative w-full aspect-video md:h-[80vh]">
      <video class="absolute inset-0 w-full h-full object-cover" autoplay muted loop src="videos-header/elden-ring-header.mp4"></video>

      <div class="absolute inset-x-0 top-0 flex justify-between items-center p-3 md:p-8 bg-gradient-to-b from-black/90 to-transparent z-50">
        <div class="w-1/3 md:w-1/4">
          <a href="index.php">
            <img src="images/logo-master-gaming.png" alt="logo" class="w-full max-w-[100px] md:max-w-[200px]">
          </a>
        </div>

        <div class="relative">
          <input type="checkbox" id="menu-toggle" class="peer hidden">
          <label for="menu-toggle" class="md:hidden flex flex-col gap-1 cursor-pointer z-[60] relative">
            <span class="w-6 h-0.5 bg-white rounded-full transition-all"></span>
            <span class="w-6 h-0.5 bg-white rounded-full transition-all"></span>
            <span class="w-6 h-0.5 bg-white rounded-full transition-all"></span>
          </label>

          <nav class="fixed inset-0 h-screen w-full bg-black backdrop-blur-2xl flex flex-col items-center justify-center gap-6 translate-x-full peer-checked:translate-x-0 transition-transform duration-300 md:static md:h-auto md:w-auto md:bg-transparent md:translate-x-0 md:flex-row md:gap-8 md:p-0 z-50">
            <a href="catalogue.php" class="text-white text-xl md:text-xs uppercase font-black tracking-widest hover:text-blue-500 transition">Catalogue</a>
            <a href="contact.php" class="text-white text-xl md:text-xs uppercase font-black tracking-widest hover:text-blue-500 transition">Assistance</a>

            <?php if (isset($_SESSION['id_user'])): ?>
              <div class="relative group">
                <button class="flex items-center gap-3 bg-white/5 p-1 pr-4 rounded-full border border-white/10 group-hover:border-blue-500 transition-all">
                  <?php
                  $headerAvatar = (!empty($_SESSION['profile_picture']))
                    ? 'uploads/avatars/' . $_SESSION['profile_picture']
                    : 'images/default-avatar.png';
                  ?>
                  <img src="<?= $headerAvatar ?>?t=<?= time() ?>" class="w-8 h-8 rounded-full object-cover border border-blue-500" alt="Profil">
                  <span class="text-white text-[10px] font-black uppercase tracking-widest italic hidden md:inline">
                    <?= htmlspecialchars($_SESSION['firstname'] ?? 'Profil') ?>
                  </span>
                </button>
                <div class="absolute right-0 mt-2 w-48 bg-gray-900 border border-white/10 rounded-2xl shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 overflow-hidden z-[100]">
                  <a href="profil.php" class="block px-6 py-4 text-[10px] font-black uppercase tracking-widest text-gray-300 hover:bg-blue-600 hover:text-white transition">👤 Mon Profil</a>
                  <a href="settings.php" class="block px-6 py-4 text-[10px] font-black uppercase tracking-widest text-gray-300 hover:bg-blue-600 hover:text-white transition border-t border-white/5">⚙️ Paramètres</a>
                  <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <a href="admin.php" class="block px-6 py-4 text-[10px] font-black uppercase tracking-widest text-blue-400 hover:bg-blue-600 hover:text-white transition border-t border-white/5">🛠️ Dashboard Admin</a>
                  <?php endif; ?>
                  <a href="logout.php" class="block px-6 py-4 text-[10px] font-black uppercase tracking-widest text-red-500 hover:bg-red-600 hover:text-white transition border-t border-white/5">🚀 Déconnexion</a>
                </div>
              </div>
            <?php else: ?>
              <div class="flex flex-col md:flex-row items-center gap-4">
                <a href="connexion.php" class="text-white text-xl md:text-xs uppercase font-black tracking-widest hover:text-blue-500 transition">Connexion</a>
                <a href="inscription.php" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-full text-xs font-black uppercase tracking-widest transition-all shadow-lg shadow-blue-900/40">S'inscrire</a>
              </div>
            <?php endif; ?>
          </nav>
        </div>
      </div>
    </div>

    <div class="relative md:absolute md:bottom-0 md:left-0 bg-black md:bg-black/70 p-4 md:p-10 text-center w-full md:w-auto md:min-w-[300px] border-t border-white/10 md:border-r backdrop-blur-md">
      <h1 class="text-lg md:text-5xl font-black text-white mb-2 md:mb-4 uppercase italic tracking-tighter">Elden Ring</h1>
      <div class="flex flex-row items-center justify-center gap-4">
        <p class="text-xl md:text-2xl font-bold text-blue-500">59.99€</p>
        <a href="detail.php?id=47" class="rounded-full border border-white text-white px-4 py-1.5 hover:bg-white hover:text-black transition-all font-bold text-[10px] md:text-base uppercase tracking-widest">
          En savoir plus
        </a>
      </div>
    </div>
  </header>

  <!-- MAIN -->
  <main class="p-4 md:p-12 space-y-32 bg-gray-900">
    <?php
    $sections = [
      "Nos jeux les plus populaires" => ['jeux' => $jeuxTendance,      'page' => 'trending.php'],
      "Nos jeux à venir"             => ['jeux' => $jeuxQuiVontSortir, 'page' => 'coming_soon.php'],
      "Nouveaux jeux"                => ['jeux' => $nouveauxJeux,      'page' => 'new.php'],
    ];

    foreach ($sections as $titre => $data):
      $listeJeux = $data['jeux'];
      $pageLien  = $data['page'];
      if (empty($listeJeux) || !is_array($listeJeux)) continue;
    ?>
      <section class="max-w-7xl mx-auto w-full">

        <!-- Titre cliquable -->
        <a href="<?= $pageLien ?>"
          class="group flex items-center justify-end gap-4 mb-12 w-fit ml-auto">
          <span class="text-blue-500 text-2xl md:text-4xl opacity-0 group-hover:opacity-100 transition-opacity">→</span>
          <h2 class="text-3xl md:text-5xl font-black text-white border-r-8 border-blue-600 pr-6 uppercase italic tracking-tighter group-hover:text-blue-500 transition-colors">
            <?= htmlspecialchars($titre) ?>
          </h2>
        </a>

        <!-- Grille 4 colonnes max -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
          <?php foreach ($listeJeux as $product): ?>
            <article class="group">
              <a href="detail.php?id=<?= (int)$product['id_product'] ?>"
                class="relative block aspect-video overflow-hidden rounded-3xl bg-black shadow-2xl">
                <img src="<?= htmlspecialchars($product['picture']) ?>"
                  alt="<?= htmlspecialchars($product['name']) ?>"
                  class="absolute inset-0 h-full w-full object-cover transition-all duration-700 group-hover:scale-110 group-hover:opacity-40">
                <div class="absolute inset-0 z-10 flex flex-col items-center justify-center p-4 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-center">
                  <h3 class="text-sm font-black text-white mb-2 uppercase tracking-widest">
                    <?= htmlspecialchars($product['name']) ?>
                  </h3>
                  <div class="flex flex-wrap justify-center gap-2">
                    <span class="bg-blue-600 px-3 py-1 rounded-full font-bold text-xs"><?= htmlspecialchars($product['price']) ?>€</span>
                    <span class="bg-white/20 backdrop-blur-md px-3 py-1 rounded-full text-[10px] uppercase"><?= htmlspecialchars($product['name_category'] ?? 'Jeu') ?></span>
                  </div>
                </div>
              </a>
            </article>
          <?php endforeach; ?>
        </div>

        <!-- Voir tout -->
        <div class="text-center mt-10">
          <a href="<?= $pageLien ?>"
            class="inline-block border border-blue-600 text-blue-500 hover:bg-blue-600 hover:text-white px-10 py-3 rounded-full font-black uppercase text-xs tracking-widest transition-all">
            Voir tout →
          </a>
        </div>

      </section>
    <?php endforeach; ?>
  </main>

  <?php require_once 'footer.php'; ?>
</body>

</html>