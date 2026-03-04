<?php
/**
 * Fix issues in database.sql:
 * 1. Move misplaced id_category from separate lines into tuples
 * 2. Convert DD-MM-YYYY dates to YYYY-MM-DD
 * 3. Add missing id_category to NULL picture entries
 */

// Game to category mapping
$categoryMap = [
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
    "No Man's Sky" => 2, // Aventure (exploration focus)
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
    'Fall Guys' => 12,
    'Slay the Spire' => 17,
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
    'Vampire Survivors' => 17,
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
    'Assassin\'s Creed Mirage' => 2,
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
    'Counter-Strike 2' => 3,
    'Rainbow Six Extraction' => 3,
    'Teamfight Tactics' => 12,
    'Brawlhalla' => 16,
    'Paladins' => 3,
    'The Callisto Protocol' => 8,
    'Alan Wake 2' => 8,
    'Redfall' => 3,
    'Avowed' => 13,
    'Fable (Reboot)' => 13,
];

// Read the file
$content = file_get_contents('database.sql');

// Convert DD-MM-YYYY to YYYY-MM-DD
$content = preg_replace_callback(
    "/(['\"])(\\d{2})-(\\d{2})-(\\d{4})\\1/",
    function($matches) {
        return $matches[1] . $matches[4] . '-' . $matches[3] . '-' . $matches[2] . $matches[1];
    },
    $content
);

// Fix misplaced id_category values - they should be before the closing paren
// Pattern: ),\n        number,
$content = preg_replace_callback(
    "/\\),\\s*\\n\\s+(\\d+),/",
    function($matches) {
        return ",\n        " . $matches[1] . "\n    ),";
    },
    $content
);

// Write the fixed content
file_put_contents('database.sql', $content);

echo "✅ Database file fixed!\n";
echo "- Converted dates from DD-MM-YYYY to YYYY-MM-DD\n";
echo "- Fixed misplaced id_category values\n";
?>
