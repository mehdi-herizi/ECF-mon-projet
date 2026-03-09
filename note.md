const bouton = document.createElement("a");
        // mon bouton recupere l'id et le lien de ma page html
        bouton.href = jeu.detail.php + "?id=" + jeu.id_product;
        bouton.classList.add("bouton");