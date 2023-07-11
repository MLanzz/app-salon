document.addEventListener("DOMContentLoaded", () => {
    initSideNav();
    userProfile();
})

const initSideNav = () => {
    document.querySelector(".open-menu-btn").addEventListener("click", openNav);
    document.querySelector(".close-menu-btn").addEventListener("click", closeNav);
}

const openNav = () => {
    document.querySelector(".side-nav").style.width = "250px";
}

const closeNav = () => {
    document.querySelector(".side-nav").style.width = "0";
}

const userProfile = () => {
    const userProfile = document.querySelector("#user-profile");

    userProfile.addEventListener("click", () => {
        const dialog = document.querySelector(".user-profile-dialog");

        console.log(dialog);
        // dialog.showModal();
        // dialog.addEventListener("click", (e) => {
        //     console.log(e)
        // })

        // if(!dialog.open) {
		// 	dialog.show();
		// } else {
		// 	dialog.close();
		// };

    });
}