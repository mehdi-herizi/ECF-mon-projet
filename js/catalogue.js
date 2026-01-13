// je donne un id a mon element
const gameList = document.getElementById("catalogue");
// je recupere mon json avec fetch
async function chargerJSON() {
  try {
    const response = await fetch("gameList.json");

    if (!response.ok) {
      0;
      throw new Error("Problème de chargement");
    }

    let jeux = await response.json();
    console.log("JEUX :", jeux);
    // pour que mon genre (tous les jeux) soit par défault
    function pardefaut() {
      let genreSelected = "none";
      const filtergenreGames = jeux.filter((gameList) =>
        gameList.categorie.includes(genreSelected)
      );
      console.log(filtergenreGames);
      // ..........................................................................
      // la creation de mes elements pour mon main
      filtergenreGames.forEach((jeu) => {
        // mon image
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
        // le prix
        const prix = document.createElement("p");
        prix.innerText = jeu.prix;

        // ANCHOR EN SAVOIR PLUS (bouton)
        const bouton = document.createElement("a");
        bouton.innerText = jeu.lien.LienName;
        // mon bouton recupere l'id et le lien de ma page html
        bouton.href = jeu.lien.lienDescription + "?id=" + jeu.id;
        bouton.classList.add("bouton");
        // ..........................................................................
        // foreach necessaire pour recuperer tous mes elements dans mes tableaux reseaux sociaux
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
        // pour afficher mes elements et leurs donne un parents
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
    }
    // je filtre mes jeux par catégories
    pardefaut();
    const genres = document.getElementById("genres");

    genres.addEventListener("change", function () {
      cleanJeux();
      let genreSelected = genres.value;
      const filtergenreGames = jeux.filter((gameList) =>
        gameList.categorie.includes(genreSelected)
      );
      console.log(filtergenreGames);
      // ..........................................................................
      // la creation de mes elements pour mon main
      filtergenreGames.forEach((jeu) => {
        // mon image
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
        // le prix
        const prix = document.createElement("p");
        prix.innerText = jeu.prix;

        // ANCHOR EN SAVOIR PLUS (bouton)
        const bouton = document.createElement("a");
        bouton.innerText = jeu.lien.LienName;
        // mon bouton recupere l'id et le lien de ma page html
        bouton.href = jeu.lien.lienDescription + "?id=" + jeu.id;
        bouton.classList.add("bouton");
        // ..........................................................................
        // foreach necessaire pour recuperer tous mes elements dans mes tableaux reseaux sociaux
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
        // pour afficher mes elements et leurs donne un parents
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
    });
    // ..........................................................................
  } catch (error) {
    console.error(error);
  }
}
// ..........................................................................
chargerJSON();
// pour enlever les anciens jeux catalogué
function cleanJeux() {
  const maincat = document.getElementById("catalogue");
  maincat.replaceChildren();
}
