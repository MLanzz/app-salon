import{serverUrl}from"./config.js";document.addEventListener("DOMContentLoaded",()=>{initApp()});const initApp=()=>{showAppointmentDetails()},showAppointmentDetails=()=>{document.querySelectorAll("[name='detailsButton']").forEach(t=>{t.addEventListener("click",t=>{const e=t.target;e.classList.toggle("rotate");const n=e.dataset.idAppointment;getServices(n)})})},getServices=async t=>{const e=serverUrl+"/api/appointmentDetails",n=new FormData;n.append("appointmentId",t);try{const t=await fetch(e,{method:"POST",body:n}),o=await t.json();o.appointmentServices.length>0?console.table(o.appointmentServices):console.log("No hay servicios")}catch(t){console.error(t)}};