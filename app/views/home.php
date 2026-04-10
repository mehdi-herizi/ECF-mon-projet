<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Catalogue - Master Gaming</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white font-sans">
    <?php require_once ROOT . 'app/views/partials/header_index.php'; ?>

<main class="p-4 md:p-12 space-y-32 bg-gray-900">
    <?php
    $sections = [
        "Nos jeux les plus populaires" => ['jeux' => $data['jeuxTendance'],      'page' => '?action=trending'],
        "Nos jeux à venir"             => ['jeux' => $data['jeuxQuiVontSortir'], 'page' => '?action=coming_soon'],
        "Nouveaux jeux"                => ['jeux' => $data['nouveauxJeux'],      'page' => '?action=new'],
    ];

    foreach ($sections as $titre => $section):
        $listeJeux = $section['jeux'];
        $pageLien  = $section['page'];
        if (empty($listeJeux) || !is_array($listeJeux)) continue;
    ?>
        <section class="max-w-7xl mx-auto w-full">
            <a href="<?= $pageLien ?>" class="group flex items-center justify-end gap-4 mb-12 w-fit ml-auto">
                <span class="text-blue-500 text-2xl md:text-4xl opacity-0 group-hover:opacity-100 transition-opacity">→</span>
                <h2 class="text-3xl md:text-5xl font-black text-white border-r-8 border-blue-600 pr-6 uppercase italic tracking-tighter group-hover:text-blue-500 transition-colors">
                    <?= htmlspecialchars($titre) ?>
                </h2>
            </a>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php foreach ($listeJeux as $product): ?>
                    <article class="group">
                        <a href="?action=product&id=<?= (int)$product['id_product'] ?>" class="relative block aspect-video overflow-hidden rounded-3xl bg-black shadow-2xl">
                            <img src="<?= htmlspecialchars($product['picture']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="absolute inset-0 h-full w-full object-cover transition-all duration-700 group-hover:scale-110 group-hover:opacity-40">
                            <div class="absolute inset-0 z-10 flex flex-col items-center justify-center p-4 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-center">
                                <h3 class="text-sm font-black text-white mb-2 uppercase tracking-widest"><?= htmlspecialchars($product['name']) ?></h3>
                                <div class="flex flex-wrap justify-center gap-2">
                                    <span class="bg-blue-600 px-3 py-1 rounded-full font-bold text-xs"><?= htmlspecialchars($product['price']) ?>€</span>
                                    <span class="bg-white/20 backdrop-blur-md px-3 py-1 rounded-full text-[10px] uppercase"><?= htmlspecialchars($product['name_category'] ?? 'Jeu') ?></span>
                                </div>
                            </div>
                        </a>
                    </article>
                <?php endforeach; ?>
            </div>

            <div class="text-center mt-10">
                <a href="<?= $pageLien ?>" class="inline-block border border-blue-600 text-blue-500 hover:bg-blue-600 hover:text-white px-10 py-3 rounded-full font-black uppercase text-xs tracking-widest transition-all">
                    Voir tout →
                </a>
            </div>
        </section>
    <?php endforeach; ?>
</main>

<?php require_once ROOT . 'app/views/partials/footer.php'; ?>
</body>
</html>