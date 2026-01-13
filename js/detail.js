// je donne un id a mon element
const gameList = document.getElementById("page");
// je recupere mon json avec fetch
async function chargerJSON() {
  try {
    const response = await fetch("gameList.json");

    if (!response.ok) {
      0;
      throw new Error("Problème de chargement");
    }

    const jeux = await response.json();

    // ..........................................................................
    // je recupere l'url pour afficher le jeu exacte appuyer
    const params1 = new URLSearchParams(window.location.search);
    console.log(params1.get("id"))?.trim();
    const id = new URLSearchParams(window.location.search).get("id");
    const jeu = jeux.find((j) => j.id == id);
    console.log("jeu:", jeu);

    if (!jeu) {
      gameList.innerHTML = "<p>Jeu introuvable</p>";
      return;
    }
    console.log("JEUX :", jeux);

    // la creation de mes elements pour mon main

    // mon image
    const image = document.createElement("img");
    image.src = jeu.imageUrl;
    image.classList.add("jeu");
    console.log("image:", image);
    // div grandparent
    const monthDiv = document.createElement("div");
    console.log("monthDiv:", monthDiv);
    // div parent
    const deuxiemeDiv = document.createElement("div");
    deuxiemeDiv.classList.add("tbl");
    console.log("deuxiemeDiv", deuxiemeDiv);

    // div enfent
    const troisiemeDiv = document.createElement("div");
    troisiemeDiv.classList.add("tableau");
    console.log("troisiemeDiv:", troisiemeDiv);
    // titre
    const h3 = document.createElement("h1");
    h3.innerText = jeu.name;
    console.log("h3:", h3);
    // date
    const date = document.createElement("p");
    date.innerText = jeu.date;
    console.log("date:", date);
    // catégorie
    const categorie = document.createElement("p");
    categorie.innerText = "🎮 " + jeu.categorie;
    categorie.style.fontWeight = "bold";
    console.log("categorie:", categorie);
    // description
    const description = document.createElement("p");
    description.innerText = jeu.content;
    console.log("description:", description);
    // reseaux sociaux
    const MaDivReaseaux = document.createElement("div");
    MaDivReaseaux.classList.add("reseaux");
    console.log("MaDivReaseaux:", MaDivReaseaux);
    // le prix
    const prix = document.createElement("p");
    prix.innerText = jeu.prix;
    console.log("prix:", prix);

    // ANCHOR EN SAVOIR PLUS (bouton)

    const bouton = document.createElement("a");
    bouton.innerText = jeu.lien.LienName;
    // mon bouton recupere l'id et le lien de ma page html
    bouton.href = jeu.lien.lienDescription + "?id=" + jeu.id;
    bouton.classList.add("bouton");
    console.log("bouton:", bouton);

    // ..........................................................................
    // foreach necessaire pour recuperer tous mes elements dans mes tableaux reseaux sociaux
    jeu.reseauxSociaux.forEach((reseau) => {
      const link = document.createElement("a");
      console.log("link:", link);
      link.href = reseau.SocialMediaUrl;

      const img = document.createElement("img");
      img.src = reseau.socialMediaImage;
      img.classList.add("soc");
      img.classList.add("sociaux");
      link.appendChild(img);
      MaDivReaseaux.appendChild(link);
      console.log("img:", img);
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

    // ..........................................................................
  } catch (error) {
    console.error(error);
  }
}

// ..........................................................................

chargerJSON();
