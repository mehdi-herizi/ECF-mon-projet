 console.log("hello")
 
 let jeux = [];

const gameList = document.getElementById("categorie");

for (let i = 0; i < jeux.length; i++) {

    const monthDiv = document.createElement("div");
    monthDiv.classList.add("month");
    
    const h3 = document.createElement("h3");
    h3.innerText = jeux[i].month;
    
    const jeuxTitre = document.createElement("p");
    jeuxTitre.innerText = "🎮 " + jeux[i].game;
    jeuxTitre.style.fontWeight = "bold";
    
    const description = document.createElement("p");
    description.innerText = jeux[i].description;

    const ImageJeux = document.createElement("img")
    ImageJeux.src = "image/StarForge.png"
    document.getElementById
    monthDiv.appendChild(h3);
    monthDiv.appendChild(jeuxTitre);
    monthDiv.appendChild(description);
    
    gameList.appendChild(monthDiv);
}