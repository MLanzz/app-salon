let step = 1;

document.addEventListener("DOMContentLoaded", () => {
    initApp();
});

function initApp() {
    // Lógica de cambio de tabs
    tabs();
}

function tabs() {
    const buttons = document.querySelectorAll(".tabs button");

    buttons.forEach(button  => {
        button.addEventListener("click", function() {
            step = parseInt(this.getAttribute("data-step"));
        })
    });
}