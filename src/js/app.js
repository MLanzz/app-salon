import {serverUrl} from "./config.js";


const appointment =  {
    fullName: "",
    appointmentDate: "",
    appointmentTime: "",
    services: []
}

document.addEventListener("DOMContentLoaded", () => {
    initApp();
});

const initApp = () => {
    tabs(); // Lógica de cambio de tabs
    showSection(1); // Inicializamos la sección a mostrar
    paginationButtons(); // Lógica para mostrar/ocultar los botones de la paginación
    nextPage(); // Lógica para el boton "Siguiente" de la paginación
    previousPage(); // Lógica para el boton "Anterior" de la paginación
    consultAPI(); // Lógica para consultar la API PHP
    getClientInfo() // Levantamos la información del cliente
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

const consultAPI = async () => {
    try {
        const url = `${serverUrl}api/services`;

        const result = await fetch(url);

        const services = await result.json();
        
        showServices(services);

    } catch (error) {
        console.log(error);
    }
}


const showServices = (services) => {
    const servicesSection = document.querySelector("#services");

    services.forEach(service => {
        const { id, serviceName, price } = service;

        const serviceContainer = document.createElement("DIV");
        serviceContainer.classList.add("service");
        serviceContainer.dataset.idService = id;

        const pServiceName = document.createElement("P");
        pServiceName.classList.add("service-name")
        pServiceName.textContent = serviceName;
        
        const pPrice = document.createElement("P");
        pPrice.classList.add("service-price")
        pPrice.textContent = `$ ${price}`;

        serviceContainer.appendChild(pServiceName);
        serviceContainer.appendChild(pPrice);

        serviceContainer.onclick = function () {
            selectService(service);
        }

        servicesSection.appendChild(serviceContainer);
    })
}

const selectService = (service) => {
    const { id } = service;
    const { services } = appointment;

    if (services.some(actualService => actualService.id === id )) { // Se esta deseleccionando un servicio
        appointment.services = services.filter(actualService => actualService.id !== id);
    } else { // Se esta seleccionando un servicio
        appointment.services = [...services, service];
    }

    const serviceContainer = document.querySelector(`[data-id-service="${id}"]`);

    serviceContainer.classList.toggle("serviceSelected");
}

function getClientInfo() {
    appointment.fullName = document.querySelector("#fullName").value.trim();

    const appointmentDate = document.querySelector("#appointmentDate")
    appointmentDate.addEventListener("input", (e) => {
        const day = new Date(e.target.value).getUTCDay();
        if ([6,0].includes(day)) {
            e.target.value = "";
            showAlerts("Los fines de semana el salon se encuentra cerrado", "errors");
        } else {
            appointment.appointmentDate = e.target.value;
        }
    });

    const appointmentTime = document.querySelector("#appointmentTime")
    appointmentTime.addEventListener("input", (e) => {
        const time = e.target.value.split(":");
        
        if ((time[0] < 10 || time[0] > 19) || (parseInt(time[0]) === 19 && time[1] > 0)) {
            showAlerts("El salon se encuentra abierto de 10 a 19", "errors");
        } else {
            appointment.appointmentTime = e.target.value;
        }
    });


}


const showAlerts = (alertDesc, alertType) => {

    if (!document.querySelector(".alert")) { // Solo dejamos que se cree una alerta

        const alert = document.createElement("DIV");
        alert.textContent = alertDesc;
        alert.classList.add("alert");
        alert.classList.add(alertType);
    
        const form = document.querySelector(".form");
        form.prepend(alert);

        setTimeout(() => {
            alert.remove()
        }, 3000);

    }
}