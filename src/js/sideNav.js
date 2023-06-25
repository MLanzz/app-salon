document.addEventListener("DOMContentLoaded", () => {
    initSideNav();
})

const initSideNav = () => {
    document.querySelector(".open-menu-btn").addEventListener("click", openNav);
    document.querySelector(".close-menu-btn").addEventListener("click", closeNav);
}

const openNav = () => {
    document.querySelector(".side-nav").style.width = "250px";
}

const  closeNav = () => {
    document.querySelector(".side-nav").style.width = "0";
}
