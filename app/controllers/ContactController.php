<?php
require_once ROOT . 'app/models/Message.php';

class ContactController
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function index(): void
    {
        $success = false;
        $error   = null;

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nom      = trim($_POST["name"] ?? "");
            $prenom   = trim($_POST["firstname"] ?? "");
            $numero   = trim($_POST["numero"] ?? "");
            $mail     = trim($_POST["mail"] ?? "");
            $message  = trim($_POST["Message"] ?? "");

            if (!empty($nom) && !empty($prenom) && !empty($mail) && !empty($message)) {
                try {
                    $messageModel = new Message($this->pdo);
                    $messageModel->create($prenom, $nom, $mail, $numero, $message);

                    ini_set('sendmail_path', '/usr/bin/msmtp -t --host=mailpit --port=1025 -f no-reply@master-gaming.com');

                    $subject = "Master Gaming - Confirmation de votre message";
                    $content = "Bonjour " . htmlspecialchars($prenom) . ",\n\n"
                        . "Nous avons bien reçu votre message concernant Master Gaming.\n"
                        . "Notre équipe va l'étudier et vous recontactera très prochainement.\n\n"
                        . "Récapitulatif :\n---------------------------------\n"
                        . htmlspecialchars($message) . "\n"
                        . "---------------------------------\n\nCordialement,\nL'équipe Master Gaming.";

                    $headers = "From: Master Gaming <no-reply@master-gaming.com>\r\n"
                        . "Reply-To: support@master-gaming.com\r\n"
                        . "X-Mailer: PHP/" . phpversion();

                    if (mail($mail, $subject, $content, $headers)) {
                        $success = true;
                    } else {
                        $error = "Message enregistré mais le mail de confirmation n'a pas pu être envoyé.";
                    }

                } catch (PDOException $e) {
                    $error = "Erreur lors de l'enregistrement : " . $e->getMessage();
                }
            } else {
                $error = "Veuillez remplir tous les champs obligatoires.";
            }
        }

        require_once ROOT . 'app/views/contact.php';
    }
}