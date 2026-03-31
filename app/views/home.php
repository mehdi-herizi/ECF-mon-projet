<?php require_once ROOT . 'app/views/partials/header_index.php'; ?>

<main class="p-4 md:p-12 space-y-32 bg-gray-900">
    <?php
    $sections = [
        "Nos jeux les plus populaires" => ['jeux' => $data['jeuxTendance'],      'page' => '?action=trending'],
        "Nos jeux à venir"             => ['jeux' => $data['jeuxQuiVontSortir'], 'page' => '?action=coming_soon'],
        "Nouveaux jeux"                => ['jeux' => $data['nouveauxJeux'],      'page' => '?action=new'],
    ];

    foreach ($sections as $titre => $section):
        if (empty($section['jeux'])) continue;
    ?>
        <section class="max-w-7xl mx-auto w-full">
            <!-- votre HTML existant, rien ne change -->
        </section>
    <?php endforeach; ?>
</main>

<?php require_once ROOT . 'app/views/partials/footer.php'; ?>