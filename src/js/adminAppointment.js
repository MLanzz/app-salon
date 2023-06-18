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
            getServices(appointmentId);
        })
        // console.log(detailButton.dataset.idAppointment);
    })
}

const getServices = async (appointmentId) => {
    const url = `${serverUrl}/api/appointmentDetails`;
    const postData = new FormData();
    postData.append("appointmentId", appointmentId);

    try {
        const response = await fetch(url,{
            method: "POST",
            body: postData
        });
    
        const data = await response.json();

        
        if(data.appointmentServices.length > 0) {
            console.table(data.appointmentServices);
        } else {
            console.log("No hay servicios")
        }
        
    } catch (error) {
        console.error(error);
    }

}