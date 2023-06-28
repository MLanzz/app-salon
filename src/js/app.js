import {serverUrl} from "./config.js";


const appointment =  {
    userId: "",
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
    getServices(); // Lógica para consultar la API PHP
    getClientInfo() // Levantamos la información del cliente
    showResume(); // Mostramos el tab de resumen
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
        nextPage.classList.add("hide");
        // Esto lo ejecutamos solo acá porque paginationButtons() se ejecuta tanto cuando usas los tabs como la paginación
        showResume();
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

const getServices = async () => {
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

const getClientInfo = () => {
    appointment.fullName = document.querySelector("#fullName").value.trim();
    appointment.userId = document.querySelector("#userId").value;

    const appointmentDate = document.querySelector("#appointmentDate")
    appointmentDate.addEventListener("input", (e) => {
        const day = new Date(e.target.value).getUTCDay();
        if ([6,0].includes(day)) {
            e.target.value = "";
            showAlerts("Los fines de semana el salon se encuentra cerrado", "errors", ".form");
        }
        appointment.appointmentDate = e.target.value;
    });

    const appointmentTime = document.querySelector("#appointmentTime")
    appointmentTime.addEventListener("input", (e) => {
        const time = e.target.value.split(":");
        
        if ((time[0] < 10 || time[0] > 19) || (parseInt(time[0]) === 19 && time[1] > 0)) {
            e.target.value = "";
            showAlerts("El salon se encuentra abierto de 10 a 19", "errors", ".form");
        }
        appointment.appointmentTime = e.target.value;
    });
}

// element es el elemento HTML al cual le vamos a hacer el prepend de las alertas
const showAlerts = (alertDesc, alertType, element, hide = true) => {

    if (document.querySelector(".alert")) { // Solo dejamos que se cree una alerta
        document.querySelector(".alert").remove();
    }

    const alert = document.createElement("DIV");
    alert.textContent = alertDesc;
    alert.classList.add("alert");
    alert.classList.add(alertType);

    const referenceElement = document.querySelector(element);
    referenceElement.prepend(alert);

    if (hide) {
        setTimeout(() => {
            alert.remove()
        }, 3000);
    }
}

const showResume = () => {

    const summaryContent = document.querySelector(".summary-content");

    while(summaryContent.firstChild) { // Limpiamos el resumen cada vez que se entra en el tab
        summaryContent.removeChild(summaryContent.firstChild);
    }

    if (Object.values(appointment).includes("") || appointment.services.length === 0) {
        showAlerts("Hacen falta información o no se han seleccionado servicios", "errors", ".summary-content", false);
        return;
    }

    const {fullName, appointmentDate, appointmentTime, services} = appointment;

    // Formateamos la fecha
    const objDate = new Date(appointmentDate);
    
    const  dateOptions = {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric"
    }

    const formattedDate = new Date(objDate.getFullYear(), objDate.getMonth(), objDate.getDate() + 1).toLocaleDateString("es-AR", dateOptions);


    let summaryBody = `
        <h3>Información de la cita</h3> 
        <div class="client-info-container">   
            <p><span>Nombre: </span>${fullName}</p>
            <p><span>Fecha: </span>${formattedDate}</p>
            <p><span>Hora: </span>${appointmentTime}</p>
        </div>
    `;

    // Header para los servicios
    summaryBody += "<h3>Servicios seleccionados</h3>"

    services.forEach(service => { // Iteramos y creamos HTML de los servicios
        const { id, serviceName, price } = service;
        summaryBody += `
            <div class="service-info-container">
                <p>${serviceName}</p>
                <p><span>Precio: $ ${price}</span></p>
            </div>
        `;
    });

    
    summaryContent.innerHTML = summaryBody;
    
    const makeAppointmentButton = document.createElement("BUTTON");
    makeAppointmentButton.onclick = makeAppointment;
    makeAppointmentButton.classList.add("button");
    makeAppointmentButton.textContent = "Reservar cita";
    summaryContent.append(makeAppointmentButton);

}


const makeAppointment = async () =>  {
    const { userId, appointmentDate, appointmentTime, services } = appointment;

    const servicesIds = services.map(service => service.id);

    const postData = new FormData();
    postData.append("userId", userId);
    postData.append("appointmentDate", appointmentDate);
    postData.append("appointmentTime", appointmentTime);
    postData.append("servicesIds", servicesIds);

    const url = `${serverUrl}api/appointments`;


    try {
        const response = await fetch(url, {
            method: "POST",
            body: postData
        });
    
        const data = await response.json();
    
        if (data.result) {
            Swal.fire({
                icon: 'success',
                title: 'Cita creada',
                text: '¡Cita agendada correctamente!'
            }).then(() => {
                window.location.reload();
            });
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Ocurrió un error guardando la cita',
        });
    }
}