import {serverUrl} from "./config.js";

document.addEventListener("DOMContentLoaded", () => {
    initApp();
})

const initApp = () => {
    showAppointmentDetails();
}

const showAppointmentDetails = () => {
    const detailsButtons = document.querySelectorAll("[name='detailsButton']");

    detailsButtons.forEach(detailButton => {
        detailButton.addEventListener("click", (e) => {

            const arrowIcon = e.target;
            arrowIcon.classList.toggle("rotate");
            const appointmentId = arrowIcon.dataset.idAppointment;
            if (arrowIcon.classList.contains("rotate")) {
                showServices(appointmentId);
            } else {
                hideServices(appointmentId);
            }
        });
    });
}

const showServices = async (appointmentId) => {

    // Si previamente ya se mostraron los servicios de la cita en cuestión
    // No volvemos a hacer el llamado a la api
    // Solo los volvemos a mostrar
    if (document.querySelector(`[servicesAppointmentId="${appointmentId}"]`)) {
        document.querySelector(`[servicesAppointmentId="${appointmentId}"]`).style.display = "table-row";
        return;
    }

    displayLoading(appointmentId);

    const url = `${serverUrl}api/appointmentDetails`;
    const postData = new FormData();
    postData.append("appointmentId", appointmentId);

    try {
        const response = await fetch(url,{
            method: "POST",
            body: postData
        });
    
        const data = await response.json();

        
        if(data.appointmentServices.length > 0) {
            const {appointmentServices} = data;

            document.querySelector(".trLoading").remove();
            createServicesTables(appointmentServices, appointmentId);
            


        } else {
            console.log("No hay servicios");
        }
        
    } catch (error) {
        console.error(error);
    }
}

const hideServices = (appointmentId) => {
    document.querySelector(`[servicesAppointmentId="${appointmentId}"]`).style.display = "none";
}

const createServicesTables = (appointmentServices, appointmentId) => {

    let serviceTable = `
        <tr servicesAppointmentId="${appointmentId}">
            <td></td>
            <td colspan="3" style="padding: 0 0 1rem 0;">
                <table style="width: 100%;" cellspacing="0">
                    <thead>
                        <th>#</th>
                        <th>Servicio</th>
                        <th>Precio</th>
                    </thead>
                    <tbody>
                        #servicesRows
                    </tbody>
                </table>
            </td>
            <td></td>
            <td></td>
        </tr>
    `;

    let serviceTableBody = "";
    appointmentServices.forEach(service => {
        const { id, serviceName, price } = service;

        serviceTableBody += `
            <tr>
                <td>${id}</td>
                <td>${serviceName}</td>
                <td>$ ${price}</td>
            </tr>
        `;
        
    });
    
    serviceTable = serviceTable.replace("#servicesRows", serviceTableBody);

    const trAppointment = document.querySelector(`[appointmentId='${appointmentId}']`);

    trAppointment.insertAdjacentHTML("afterend", serviceTable);

}

const displayLoading = (appointmentId) => {
    const trAppointment = document.querySelector(`[appointmentId='${appointmentId}']`);

    const loading = `
        <tr class="trLoading">
            <td colspan="6">
                <div class="loading"></div>
            </td>
        </tr>
    `;

    trAppointment.insertAdjacentHTML("afterend", loading);
}