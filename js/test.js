// je donne un id a mon element
const gameList = document.getElementById("categorie1");
// je recupere mon json avec fetch
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

    const filteredDataGames = jeux.filter(
      (gameList) => gameList.tag == "tendance"
    );
    console.log(filteredDataGames);
    // la creation de mes elements pour mon main
    filteredDataGames.forEach((jeu) => {
      // mon image
      const image = document.createElement("img");
      image.src = jeu.imageUrl;
      image.classList.add("jeu");

    image.href = jeu.lien.lienDescription + "?id=" + jeu.id;;
      // div grandparent
      const monthDiv = document.createElement("div");
      // div parent
      const deuxiemeDiv = document.createElement("div");
      deuxiemeDiv.classList.add("tbl");
      // div enfent
      const troisiemeDiv = document.createElement("div");
      troisiemeDiv.classList.add("tableau");
      
      // ANCHOR EN SAVOIR PLUS (bouton)
    //   const bouton = document.createElement("a");
    //   bouton = jeu.lien.LienName;
    // // mon bouton recupere l'id et le lien de ma page html
    //   bouton.href = jeu.lien.lienDescription + "?id=" + jeu.id;
    //   bouton.classList.add("bouton");
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
        // MaDivReaseaux.appendChild(link);
      });
      // ..........................................................................
          // pour afficher mes elements et leurs donne un parents
      monthDiv.appendChild(deuxiemeDiv);
      deuxiemeDiv.appendChild(troisiemeDiv);
      troisiemeDiv.appendChild(image);
    //   troisiemeDiv.appendChild(bouton);
      gameList.appendChild(monthDiv);
    });
    // ..........................................................................
  } catch (error) {
    console.error(error);
  }
}
// ..........................................................................
chargerJSON();
