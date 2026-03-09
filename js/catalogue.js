// je donne un id a mon element
const gameList = document.getElementById("catalogue");
// je recupere mon json avec fetch
async function chargerJSON() {
  try {
    // const response = await fetch("gameList.json");
        const response = await fetch("catalogue-test.php");
  
    if (!response.ok) {
      0;
      throw new Error("Problème de chargement");
    }

    let jeux = await response.json();
    console.log("JEUX :", jeux);
   
    jeux.forEach((jeu) => {
      // mon image
      const image = document.createElement("img");
      image.src = jeu.picture;
      image.classList.add("jeu");

      gameList.appendChild(image);
    });
  }
  catch (error) {
    console.error("Erreur lors du chargement du JSON :", error);
  }}