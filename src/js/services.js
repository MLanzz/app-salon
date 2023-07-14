document.addEventListener("DOMContentLoaded", () => {
    initServices();
});


const initServices = () => {
    initModal();
}

const initModal = () => {
    const createServiceBtn = document.querySelector("#createService");
    createServiceBtn.addEventListener("click", () => {
        openModal();
    });

    const updateServiceBtns = document.querySelectorAll("[name='serviceUpdate']");

    updateServiceBtns.forEach(updateServiceBtn => {
        updateServiceBtn.addEventListener("click", e => {
            const serviceName = e.target.getAttribute("serviceName");
            const servicePrice = e.target.getAttribute("servicePrice");

            openModal(serviceName, servicePrice);
        })
    });

    
    const modal = document.querySelector("dialog");

    const cancelModal = document.querySelector("#cancel-modal");
    cancelModal.addEventListener("click", () => {
        modal.close();
    });

    modal.addEventListener("click", e => {
        const dialogDimensions = modal.getBoundingClientRect()
        if (
            e.clientX < dialogDimensions.left ||
            e.clientX > dialogDimensions.right ||
            e.clientY < dialogDimensions.top ||
            e.clientY > dialogDimensions.bottom
        ) {
            modal.close();
        }
    })


}

const openModal = (serviceName = "", servicePrice = "") => {
    const dialogServiceName = document.querySelector("#dialogServiceName");
    const dialogServicePrice = document.querySelector("#dialogServicePrice");

    dialogServiceName.value = serviceName;
    dialogServicePrice.value = servicePrice;

    document.querySelector("dialog").showModal();
}