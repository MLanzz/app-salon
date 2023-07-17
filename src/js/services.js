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
            const serviceName = e.target.dataset.servicename;
            const servicePrice = e.target.dataset.serviceprice;

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
        const dialogServiceId = document.querySelector("#dialogServiceId").value;
        const dialogServiceName = document.querySelector("#dialogServiceName").value;
        const dialogServicePrice = document.querySelector("#dialogServicePrice").value;
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
    postData.append("id", serviceId);
    postData.append("serviceName", serviceName);
    postData.append("price", servicePrice);

    const url = "/api/saveService";
    try {
        const response = await fetch(url, {
            method: "POST",
            body: postData
        });

        const data = await response.json();

        let result;
        let swalText;
        if (serviceId !== "0") {
            result = data.result;
            swalText = 'actualizado'
        } else {
            result = data.result.resultado
            swalText = 'creado'
        }

        document.querySelector("dialog").close();

        if (result) {
            Swal.fire({
                icon: 'success',
                title: `Servicio ${swalText}`,
                text: `Servicio ${swalText} correctamente!`
            }).then(() => {
                console.log("llego");
                // Si el proceso se completo correctamente agregamos/modificamos el servicio en la UI
                renderService(data.service);
            });
        } else {
            let errorText = "";
            data.errors.forEach(element => {
                errorText += `<li>${element}</li>`
            });

            console.log(errorText);

            Swal.fire({
                icon: 'error',
                title: 'Error',
                html: `
                    Ocurrieron los siguientes errores:
                    <ul><b>${errorText}</b></ul>
                `,
            });
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: `Ocurrió un error guardando el servicio - ${error}`,
        });
    }
}

const renderService = (service) => {

    const {id, serviceName, price} = service;
    
    const servicesList = Array.from(document.querySelectorAll("ul[id='service-list'] li"));
    let newService = servicesList.find(e => e.dataset.serviceId === id);
    
    if (!newService){
        const newServiceHTML = `
            <li data-service-id="${id}">
                <p><span>Nombre:</span> <span class="service-desc">${serviceName}</span></p>
                <p><span>Precio:</span> $ <span class="service-desc">${price}</span></p>
                <div class="buttons-container">
                    <input type="button" class="button" value="Actualizar servicio" name="serviceUpdate" data-id="${id}" data-serviceName="${serviceName}" data-servicePrice="${price}">
                    
                    <input type="button" class="button-delete" value="Eliminar servicio" name="serviceDelete" data-id="${id}">
                </div>
            </li>
            <hr>
        `;
        const serviceList = document.querySelector("#service-list");
        serviceList.insertAdjacentHTML('beforeend', newServiceHTML);
    } else {
        newService.innerHTML = `
            <p><span>Nombre:</span> <span class="service-desc">${serviceName}</span></p>
            <p><span>Precio:</span> $ <span class="service-desc">${price}</span></p>
            <div class="buttons-container">
                <input type="button" class="button" value="Actualizar servicio" name="serviceUpdate" data-id="${id}" data-serviceName="${serviceName}" data-servicePrice="${price}">
                
                <input type="button" class="button-delete" value="Eliminar servicio" name="serviceDelete" data-id="${id}">
            </div>
        `
    }
}