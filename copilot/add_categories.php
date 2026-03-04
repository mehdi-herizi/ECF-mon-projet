<?php
// Lire le fichier database.sql
$content = file_get_contents(__DIR__ . '/database.sql');

// Mapping jeux => catégories
$games_categories = [
    'ARC Raiders' => 1,
    'ARK: Survival Ascended' => 15,
    "Assassin's Creed Odyssey" => 2,
    'Call of Duty: Black Ops II' => 3,
    'Call of Duty 4: Modern Warfare' => 3,
    'DayZ' => 15,
    'Fortnite' => 3,
    'Genshin Impact' => 13,
    'Grand Theft Auto VI' => 2,
    'League of Legends' => 4,
    'Minecraft' => 14,
    'Call of Duty: Modern Warfare 2' => 3,
    'Rocket League' => 7,
    'Warframe' => 3,
    'Wuthering Waves' => 13,
    "Tom Clancy's Rainbow Six Siege" => 3,
    'Sekiro: Shadows Die Twice' => 1,
    'Control' => 1,
    'Subnautica' => 15,
    'Cities: Skylines' => 5,
    'Factorio' => 5,
    'Hades' => 13,
    'Dead Cells' => 16,
    'Cuphead' => 10,
    'Stardew Valley' => 5,
    'Terraria' => 14,
    'Among Us' => 12,
    'Phasmophobia' => 8,
    'Outlast' => 8,
    'The Forest' => 15,
    'Valheim' => 15,
    "No Man's Sky" => 2,
    'Forza Horizon 5' => 6,
    'FIFA 23' => 7,
    'NBA 2K24' => 7,
    'Tekken 8' => 16,
    'Street Fighter 6' => 16,
    'Monster Hunter: World' => 1,
    'Darkest Dungeon' => 13,
    'RimWorld' => 5,
    'Planet Zoo' => 5,
    'Satisfactory' => 5,
    'Age of Empires IV' => 4,
    'Total War: Warhammer III' => 4,
    'StarCraft II' => 4,
    'Diablo IV' => 13,
    'Path of Exile' => 13,
    'Fall Guys' => 7,
    'Slay the Spire' => 4,
    'Celeste' => 10,
    'Inside' => 10,
    'Limbo' => 10,
    'Rust' => 15,
    'Ark: Survival Evolved' => 15,
    'Sea of Thieves' => 2,
    'Guild Wars 2' => 11,
    'Black Desert Online' => 11,
    'The Crew Motorfest' => 6,
    'Gran Turismo 7' => 6,
    'Mortal Kombat 1' => 16,
    'It Takes Two' => 2,
    'Little Nightmares II' => 8,
    'Undertale' => 13,
    'Vampire Survivors' => 12,
    'Project Zomboid' => 15,
    'Mount & Blade II: Bannerlord' => 4,
    'Hogwarts Legacy' => 2,
    'The Legend of Zelda: Tears of the Kingdom' => 2,
    'Starfield' => 13,
    'Elden Ring' => 1,
    'Spider-Man 2 (PS5)' => 1,
    'Horizon Forbidden West: Burning Shores' => 2,
    'Resident Evil 4 Remake' => 8,
    'Final Fantasy XVI' => 13,
    "Assassin's Creed Mirage" => 2,
    'God of War Ragnarök' => 1,
    'Apex Legends' => 3,
    'Valorant' => 3,
    'Call of Duty: Modern Warfare II (2022)' => 3,
    'Overwatch 2' => 3,
    'Destiny 2' => 3,
    'GTA Online' => 2,
    'Hollow Knight: Silksong' => 10,
    'Loop Hero' => 17,
    'Tunic' => 2,
    'Sifu' => 1,
    'Stray' => 2,
    'Oxenfree II: Lost Signals' => 2,
    'Rainbow Six Extraction' => 3,
    'Brawlhalla' => 16,
    'Paladins' => 3,
    'The Callisto Protocol' => 8,
    'Alan Wake 2' => 8,
    'Redfall' => 3,
    'Avowed' => 13,
    'Fable (Reboot)' => 13,
];

// Pour chaque jeu, ajouter id_category à la fin du tuple
foreach ($games_categories as $game_name => $category_id) {
    // Échapper les caractères spéciaux pour regex
    $escaped_name = preg_quote($game_name, '/');
    
    // Pattern: chercher le tuple qui commence par le nom du jeu
    // et se termine par la fermeture )
    // On cherche le pattern: 'NOM_JEU',\n...\n        ),
    
    // Plutôt, utilisons une approche plus simple:
    // chercher la dernière ligne du tuple (celle avec l'excerpt)
    // et modifier la fermeture ) pour ajouter ,$category_id
    
    // Mais c'est compliqué car certains tuples s'étendent sur plusieurs lignes.
    // Je vais utiliser une regex plus complexe.
    
    $pattern = "/\\(\\s*'" . $escaped_name . "',/s";
    
    if (preg_match($pattern, $content)) {
        // Trouver le ) de fermeture de ce tuple
        // On va chercher le tuple entier et remplacer son ) par ),id_category
        
        // Pattern plus complet: chercher depuis le nom du jeu jusqu'au ),
        $full_pattern = "/(\\(\\s*'" . $escaped_name . "',[\s\S]*?\\))(\\s*,)/";
        $replacement = "\${1},\n        " . $category_id . "\${2}";
        
        $content = preg_replace($full_pattern, $replacement, $content, 1);
    }
}

// Ecrire le nouveau contenu
file_put_contents(__DIR__ . '/database.sql', $content);
echo "✅ Fichier mis à jour avec les catégories!\n";
?>
