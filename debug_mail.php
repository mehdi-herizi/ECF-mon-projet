<?php
echo "<h3>Debug Approfondi MSMPT</h3>";

$to = "test@example.com";
$subject = "Test Master Gaming";
$message = "Test contenu";
$headers = "From: no-reply@master-gaming.com";

// On tente l'envoi et on capture la sortie d'erreur
$command = 'printf "To: '.$to.'\nSubject: '.$subject.'\n\n'.$message.'" | /usr/bin/msmtp -t --host=mailpit --port=1025 -v 2>&1';
exec($command, $output, $return_var);

echo "<pre>";
echo "Commande exécutée : " . htmlspecialchars($command) . "\n\n";
echo "Retour de la commande :\n";
print_r($output);
echo "\nCode de retour : " . $return_var;
echo "</pre>";
?>