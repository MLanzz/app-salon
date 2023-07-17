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
            const serviceId = e.target.dataset.id;
            const serviceName = e.target.dataset.serviceName;
            const servicePrice = e.target.dataset.servicePrice;

            openModal(serviceId, serviceName, servicePrice);
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
    });

    submitBtn = document.querySelector("#submit-modal");
    submitBtn.addEventListener("click", () => {
        const dialogServiceId = document.querySelector("#dialogServiceId");
        const dialogServiceName = document.querySelector("#dialogServiceName");
        const dialogServicePrice = document.querySelector("#dialogServicePrice"); 
        saveService(dialogServiceId, dialogServiceName, dialogServicePrice);
    });

}

const openModal = (serviceId = 0, serviceName = "", servicePrice = "") => {
    const dialogServiceId = document.querySelector("#dialogServiceId");
    const dialogServiceName = document.querySelector("#dialogServiceName");
    const dialogServicePrice = document.querySelector("#dialogServicePrice");

    dialogServiceId.value = serviceId;
    dialogServiceName.value = serviceName;
    dialogServicePrice.value = servicePrice;

    document.querySelector("dialog").showModal();
}

const saveService = async (serviceId, serviceName, servicePrice) => {
    
    const postData = new FormData();
    postData.append("serviceId", serviceId);
    postData.append("serviceName", serviceName);
    postData.append("servicePrice", servicePrice);

    const url = "/api/saveService";
    try {
        const response = await fetch(url, {
            method: "POST",
            body: postData
        });

        const data = response.json();

        if (data.result) {
            Swal.fire({
                icon: 'success',
                title: 'Cita creada',
                text: '¡Cita agendada correctamente!'
            }).then(() => {
                // Si el proceso se completo correctamente agregamos/modificamos el servicio en la UI
                renderService(data.service)
            });
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: `Ocurrió un error guardando la cita - ${error}`,
        });
    }
}

const renderService = (service) => {
    const serviceList = document.querySelector("#serviceList");

    const servicesList = Array.from(document.querySelectorAll("ul[id='service-list'] li"));
    let newService = servicesList.find(e => e.dataset.serviceId === service.id);

    if (newService){
        console.log("Se esta actualizando")
    } else {
        console.log("Se esta creando")
    }
    console.log(newService)
}