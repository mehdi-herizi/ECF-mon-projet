const gameList = document.getElementById("categorie");

async function chargerJSON() {
  try {
    const response = await fetch("gameList.json");

    if (!response.ok) {
      throw new Error("Problème de chargement");
    }

    const jeux = await response.json();
    console.log("JEUX :", jeux);

    jeux.forEach((jeu) => {
      const image = document.createElement("img");
      image.src = jeu.imageUrl;
      image.classList.add("jeu")
      
      const monthDiv = document.createElement("div");
      monthDiv.id = "categorie"

      const h3 = document.createElement("h1");
      h3.innerText = jeu.name;

      const date = document.createElement("p");
      date.innerText = jeu.date;

      const categorie = document.createElement("p");
      categorie.innerText = "🎮 " + jeu.categorie;
      categorie.style.fontWeight = "bold";

      const description = document.createElement("p");
      description.innerText = jeu.description;

      const MaDivReaseaux = document.createElement("div");
      MaDivReaseaux.classList.add("reseaux")
      
      jeu.reseauxSociaux.forEach((reseau) => {
        const link = document.createElement("a")
        link.href=reseau.SocialMediaUrl

        const img = document.createElement("img")
        img.src=reseau.socialMediaImage
        img.classList.add("soc")
        link.appendChild(img)
        MaDivReaseaux.appendChild(link)
      });

      monthDiv.appendChild(image);
      monthDiv.appendChild(h3);
      monthDiv.appendChild(date);
      monthDiv.appendChild(categorie);
      monthDiv.appendChild(MaDivReaseaux);
      monthDiv.appendChild(description);

      gameList.appendChild(monthDiv);
    });
  } catch (error) {
    console.error(error);
  }
}

chargerJSON();
//TODO faut que je mette categorie dans un tableau
