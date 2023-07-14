const appointment={userId:"",fullName:"",appointmentDate:"",appointmentTime:"",services:[]};document.addEventListener("DOMContentLoaded",()=>{initApp()});const initApp=()=>{tabs(),showSection(1),paginationButtons(),nextPage(),previousPage(),getServices(),getClientInfo(),showResume()},tabs=()=>{document.querySelectorAll(".tabs button").forEach(e=>{e.addEventListener("click",(function(){const e=parseInt(this.getAttribute("data-step"));showSection(e),paginationButtons()}))})},showSection=e=>{const t=document.querySelector(".show-section");t&&t.classList.remove("show-section");document.querySelector(".step-"+e).classList.add("show-section");const n=document.querySelector(".active");n&&n.classList.remove("active");document.querySelector(`[data-step="${e}"]`).classList.add("active")},paginationButtons=()=>{const e=document.querySelector("#previous"),t=document.querySelector("#next"),n=parseInt(document.querySelector("button[class='active']").getAttribute("data-step"));e.classList.remove("hide"),t.classList.remove("hide"),1===n&&e.classList.add("hide"),3===n&&(t.classList.add("hide"),showResume())},nextPage=()=>{document.querySelector("#next").addEventListener("click",()=>{let e=parseInt(document.querySelector("button[class='active']").getAttribute("data-step"));showSection(++e),paginationButtons()})},previousPage=()=>{document.querySelector("#previous").addEventListener("click",()=>{let e=parseInt(document.querySelector("button[class='active']").getAttribute("data-step"));showSection(--e),paginationButtons()})},getServices=async()=>{try{const e="/api/getServices",t=await fetch(e),n=await t.json();showServices(n)}catch(e){console.log(e)}},showServices=e=>{const t=document.querySelector("#services");e.forEach(e=>{const{id:n,serviceName:a,price:o}=e,s=document.createElement("DIV");s.classList.add("service"),s.dataset.idService=n;const i=document.createElement("P");i.classList.add("service-name"),i.textContent=a;const c=document.createElement("P");c.classList.add("service-price"),c.textContent="$ "+o,s.appendChild(i),s.appendChild(c),s.onclick=function(){selectService(e)},t.appendChild(s)})},selectService=e=>{const{id:t}=e,{services:n}=appointment;n.some(e=>e.id===t)?appointment.services=n.filter(e=>e.id!==t):appointment.services=[...n,e];document.querySelector(`[data-id-service="${t}"]`).classList.toggle("serviceSelected")},getClientInfo=()=>{appointment.fullName=document.querySelector("#fullName").value.trim(),appointment.userId=document.querySelector("#userId").value;document.querySelector("#appointmentDate").addEventListener("input",e=>{const t=new Date(e.target.value).getUTCDay();[6,0].includes(t)&&(e.target.value="",showAlerts("Los fines de semana el salon se encuentra cerrado","errors",".form")),appointment.appointmentDate=e.target.value});document.querySelector("#appointmentTime").addEventListener("input",e=>{const t=e.target.value.split(":");(t[0]<10||t[0]>19||19===parseInt(t[0])&&t[1]>0)&&(e.target.value="",showAlerts("El salon se encuentra abierto de 10 a 19","errors",".form")),appointment.appointmentTime=e.target.value})},showAlerts=(e,t,n,a=!0)=>{document.querySelector(".alert")&&document.querySelector(".alert").remove();const o=document.createElement("DIV");o.textContent=e,o.classList.add("alert"),o.classList.add(t);document.querySelector(n).prepend(o),a&&setTimeout(()=>{o.remove()},3e3)},showResume=()=>{const e=document.querySelector(".summary-content");for(;e.firstChild;)e.removeChild(e.firstChild);if(Object.values(appointment).includes("")||0===appointment.services.length)return void showAlerts("Hacen falta información o no se han seleccionado servicios","errors",".summary-content",!1);const{fullName:t,appointmentDate:n,appointmentTime:a,services:o}=appointment,s=new Date(n);let i=`\n        <h3>Información de la cita</h3> \n        <div class="client-info-container">   \n            <p><span>Nombre: </span>${t}</p>\n            <p><span>Fecha: </span>${new Date(s.getFullYear(),s.getMonth(),s.getDate()+1).toLocaleDateString("es-AR",{weekday:"long",year:"numeric",month:"long",day:"numeric"})}</p>\n            <p><span>Hora: </span>${a}</p>\n        </div>\n    `;i+="<h3>Servicios seleccionados</h3>",o.forEach(e=>{const{id:t,serviceName:n,price:a}=e;i+=`\n            <div class="service-info-container">\n                <p>${n}</p>\n                <p><span>Precio: $ ${a}</span></p>\n            </div>\n        `}),e.innerHTML=i;const c=document.createElement("BUTTON");c.onclick=makeAppointment,c.classList.add("button"),c.textContent="Reservar cita",e.append(c)},makeAppointment=async()=>{const{userId:e,appointmentDate:t,appointmentTime:n,services:a}=appointment,o=a.map(e=>e.id),s=new FormData;s.append("userId",e),s.append("appointmentDate",t),s.append("appointmentTime",n),s.append("servicesIds",o);try{const e=await fetch("/api/saveAppointment",{method:"POST",body:s});(await e.json()).result&&Swal.fire({icon:"success",title:"Cita creada",text:"¡Cita agendada correctamente!"}).then(()=>{window.location.reload()})}catch(e){Swal.fire({icon:"error",title:"Error",text:"Ocurrió un error guardando la cita"})}};