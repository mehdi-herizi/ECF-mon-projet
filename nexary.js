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

      const monthDiv = document.createElement("div");
      monthDiv.classList.add("month");

      const h3 = document.createElement("h3");
      h3.innerText = jeu.name;

      const date = document.createElement("p");
      date.innerText = jeu.date;

      const categorie = document.createElement("p");
      categorie.innerText = "🎮 " + jeu.categorie;
      categorie.style.fontWeight = "bold";

      const description = document.createElement("p");
      description.innerText = jeu.description;

      const MaDivReaseaux = document.createElement("div");
      MaDivReaseaux.classList = ""
      
      jeu.reesauxSociaux.forEach((reseau) => {});

      monthDiv.appendChild(image);
      monthDiv.appendChild(h3);
      monthDiv.appendChild(date);
      monthDiv.appendChild(categorie);
      monthDiv.appendChild(imagereseaux);
      monthDiv.appendChild(description);

      gameList.appendChild(monthDiv);
    });
  } catch (error) {
    console.error(error);
  }
}

chargerJSON();
//TODO faut que je mette categorie dans un tableau
