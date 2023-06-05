document.addEventListener("DOMContentLoaded", () => {
    initApp();
});

const initApp = () => {
    // Lógica de cambio de tabs
    tabs();
    showSection(1);
    paginationButtons();
    nextPage();
    previousPage();
}

const tabs = () => {
    const buttons = document.querySelectorAll(".tabs button");

    buttons.forEach(button => {
        button.addEventListener("click", function() {
            const step = parseInt(this.getAttribute("data-step"));
            showSection(step);
            paginationButtons();
        })
    });
}

const showSection = (step) => {

    // Mostramos la sección
    const activeSection = document.querySelector(".show-section");
    if (activeSection) activeSection.classList.remove("show-section");

    const sectionToActive = document.querySelector(`.step-${step}`);
    sectionToActive.classList.add("show-section");


    // Seleccionamos el tab
    const activeTab = document.querySelector(".active");
    if (activeTab) activeTab.classList.remove("active");

    const tabToActive = document.querySelector(`[data-step="${step}"]`);
    tabToActive.classList.add("active")

}

const paginationButtons = () => {

    const previousPage = document.querySelector("#previous");
    const nextPage = document.querySelector("#next");

    const activeTab = parseInt(document.querySelector("button[class='active']").getAttribute("data-step"));
    
    previousPage.classList.remove("hide");
    nextPage.classList.remove("hide");

    if (activeTab === 1) {
        previousPage.classList.add("hide");
    }

    if (activeTab === 3) {
        nextPage.classList.add("hide")
    }
}

const nextPage = () => {
    const button = document.querySelector("#next");
    button.addEventListener("click", () => {
        let activeTab = parseInt(document.querySelector("button[class='active']").getAttribute("data-step"))
        showSection(++activeTab);
        paginationButtons();
    })
}

const previousPage = () => {
    const button = document.querySelector("#previous");
    
    button.addEventListener("click", () => {
        let activeTab = parseInt(document.querySelector("button[class='active']").getAttribute("data-step"))
        showSection(--activeTab);
        paginationButtons();
    })
}