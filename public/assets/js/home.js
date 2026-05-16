function irASeccion(id){

    document.getElementById(id).scrollIntoView({
        behavior: "smooth"
    });

}

/* =========================
   SHOWCASE DINAMICO
========================= */

const slider = document.querySelector(".slider-showcase");

setInterval(() => {

    const cards = document.querySelectorAll(".showcase-card");

    // mover el primero al final
    slider.appendChild(cards[0]);

    // quitar tamaños
    cards.forEach(card => {

        card.classList.remove("large");

        card.classList.add("small");

    });

    // hacer grande el del centro
    const nuevasCards = document.querySelectorAll(".showcase-card");

    nuevasCards[1].classList.remove("small");

    nuevasCards[1].classList.add("large");

}, 5000);