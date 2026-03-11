# 🎮 Mastergaming

<!-- Plateforme e-commerce de jeux vidéo développée en PHP/MySQL.  
Permet aux utilisateurs de parcourir, acheter et gérer une wishlist de jeux.
il y a aussi un coté admin et super admin, l'admin sera capable d'enlevé des jeux, de rajouté des jeux et de voir des messages envoyé depuis l'assitance, le super admin sera capable, de changé les roles d'utilisateurs de savoirs il y a combien d'utilisateurs pour chaque role, rajouté des utilisateurs, supprimé des utilisateurs et de voir l'activité des utilisateurs. -->

Video game e-commerce platform developed in PHP/MySQL.  
Allows users to browse, buy and manage a game wishlist.
there is also an admin side and super admin, the admin will be able to remove games, add games and see messages sent from the account, the super admin will be able to change the roles of knowledge users there are how many users for each role, added users, deleted users and to see the activity of the users.

## Language and Prerequisites

- PHP 
- MySQL 
- JS
- Tailwind 
- HTML
- Apache / Nginx
- phpMyAdmin 

## installation

1. Clone the repository :
```bash
   git clone https://github.com/mehdi-herizi/ECF-mon-projet.git
```

2. Import the database :
```bash
   mysql -u root -p mastergaming < Mastergaming.sql
```

3. Configure the connection in `config.php` :
```php
   define('DB_HOST', 'mysql-serveur');
   define('DB_NAME', 'mastergaming');
   define('DB_USER', 'root');
   define('DB_PASS', 'ton_mot_de_passe');
```

4. Launch the server and open `http://localhost/master-gaming/`

## 🗂️ project structure
```
mastergaming/
├── index.php               # Page d'accueil
├── catalogue.php           # Liste des jeux
├── detail.php              # Détail d'un jeu
├── panier.php              # Panier
├── panier_action.php       # Actions panier (ajout/suppression)
├── valider_commande.php    # Validation de commande
├── confirmation.php        # Page de confirmation
├── wishlist_action.php     # Gestion wishlist
├── trending.php            # Jeux tendance
├── coming_soon.php         # Prochaines sorties
├── connexion.php           # Connexion
├── inscription.php         # Inscription
├── logout.php              # Déconnexion
├── profil.php              # Profil utilisateur
├── settings.php            # Paramètres du compte
├── contact.php             # Formulaire de contact
├── admin.php               # Espace administrateur
├── admin_messages.php      # Gestion des messages (admin)
├── add_product.php         # Ajout produit (admin)
├── edit_product.php        # Modification produit (admin)
├── delete_product.php      # Suppression produit (admin)
├── super_admin.php         # Super administration
├── super_admin_action.php  # Actions super admin
├── super_admin_view_u.php  # Vue utilisateurs (super admin)
├── new.php                 # Nouveautés
├── header.php              # En-tête (composant)
├── footer.php              # Pied de page (composant)
├── config.php              # Configuration BDD
├── Mastergaming.sql        # Script SQL de la BDD
├── css/                    # Feuilles de style
├── images/                 # Images générales
├── images-jeux/            # Images des jeux
├── uploads/                # Fichiers uploadés
├── videos-header/          # Vidéos de la bannière
├── MLC.png                 # Modèle Conceptuel (Merise)
├── MLD.png                 # Modèle Logique (Merise)
└── README.md
```

## 🛠️ technologies used

- **PHP** 8.2 — back-end
- **MySQL** 8.4 — database
- **HTML/CSS/JS** — front-end
- **phpMyAdmin** — management BDD

## merise MLC

- ![](https://i.ibb.co/dJcvxCQj/MLC.png)


## merise MLD

- ![](https://i.ibb.co/7Jb5qvGf/MLD.png)

## 👥 authors

- Mehdi Herizi — [@mehdi](https://github.com/mehdi-herizi)

