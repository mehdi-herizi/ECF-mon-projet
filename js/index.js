const gameList = document.getElementById("categorie1");
async function chargerJSON() {
  try {
    const response = await fetch("gameList.json");

    if (!response.ok) {
      0;
      throw new Error("Problème de chargement");
    }

    const jeux = await response.json();
    console.log("JEUX :", jeux);

    // ..........................................................................
    
    const filteredDataGames = jeux.filter((gameList) => gameList.tag=="tendance");
    console.log(filteredDataGames);
    
    filteredDataGames.forEach((jeu) => {
      const image = document.createElement("img");
      image.src = jeu.imageUrl;
      image.classList.add("jeu");
      // div grandparent
      const monthDiv = document.createElement("div");
      // div parent
      const deuxiemeDiv = document.createElement("div");
      deuxiemeDiv.classList.add("tbl");
      // div enfent
      const troisiemeDiv = document.createElement("div");
      troisiemeDiv.classList.add("tableau");
      // titre
      const h3 = document.createElement("h1");
      h3.innerText = jeu.name;
      // date
      const date = document.createElement("p");
      date.innerText = jeu.date;
      // catégorie
      const categorie = document.createElement("p");
      categorie.innerText = "🎮 " + jeu.categorie;
      categorie.style.fontWeight = "bold";
      // description
      const description = document.createElement("p");
      description.innerText = jeu.description;
      // reseaux sociaux
      const MaDivReaseaux = document.createElement("div");
      MaDivReaseaux.classList.add("reseaux");

      const prix = document.createElement("p");
      prix.innerText = jeu.prix;

      // ANCHOR EN SAVOIR PLUS (bouton)
      const bouton = document.createElement("a");
      bouton.innerText = jeu.lien.LienName;

      bouton.href = jeu.lien.lienDescription + "?id=" + jeu.id;

      bouton.classList.add("bouton");
      // ..........................................................................
      jeu.reseauxSociaux.forEach((reseau) => {
        const link = document.createElement("a");
        link.href = reseau.SocialMediaUrl;

        const img = document.createElement("img");
        img.src = reseau.socialMediaImage;
        img.classList.add("soc");
        img.classList.add("sociaux");
        link.appendChild(img);
        MaDivReaseaux.appendChild(link);
      });
      // ..........................................................................
      monthDiv.appendChild(deuxiemeDiv);
      deuxiemeDiv.appendChild(troisiemeDiv);
      troisiemeDiv.appendChild(image);
      troisiemeDiv.appendChild(h3);
      troisiemeDiv.appendChild(categorie);
      troisiemeDiv.appendChild(MaDivReaseaux);
      troisiemeDiv.appendChild(date);
      troisiemeDiv.appendChild(description);
      troisiemeDiv.appendChild(prix);
      troisiemeDiv.appendChild(bouton);
      gameList.appendChild(monthDiv);
    });
    // ..........................................................................
  } catch (error) {
    console.error(error);
  }
}
// ..........................................................................
chargerJSON();
//TODO faut que je mette categorie dans un tableau
