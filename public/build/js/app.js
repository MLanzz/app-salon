import{serverUrl}from"./config.js";const appointment={fullName:"",appointmentDate:"",appointmentTime:"",services:[]};document.addEventListener("DOMContentLoaded",()=>{initApp()});const initApp=()=>{tabs(),showSection(1),paginationButtons(),nextPage(),previousPage(),consultAPI(),getClientInfo()},tabs=()=>{document.querySelectorAll(".tabs button").forEach(e=>{e.addEventListener("click",(function(){const e=parseInt(this.getAttribute("data-step"));showSection(e),paginationButtons()}))})},showSection=e=>{const t=document.querySelector(".show-section");t&&t.classList.remove("show-section");document.querySelector(".step-"+e).classList.add("show-section");const n=document.querySelector(".active");n&&n.classList.remove("active");document.querySelector(`[data-step="${e}"]`).classList.add("active")},paginationButtons=()=>{const e=document.querySelector("#previous"),t=document.querySelector("#next"),n=parseInt(document.querySelector("button[class='active']").getAttribute("data-step"));e.classList.remove("hide"),t.classList.remove("hide"),1===n&&e.classList.add("hide"),3===n&&t.classList.add("hide")},nextPage=()=>{document.querySelector("#next").addEventListener("click",()=>{let e=parseInt(document.querySelector("button[class='active']").getAttribute("data-step"));showSection(++e),paginationButtons()})},previousPage=()=>{document.querySelector("#previous").addEventListener("click",()=>{let e=parseInt(document.querySelector("button[class='active']").getAttribute("data-step"));showSection(--e),paginationButtons()})},consultAPI=async()=>{try{const e=serverUrl+"api/services",t=await fetch(e),n=await t.json();showServices(n)}catch(e){console.log(e)}},showServices=e=>{const t=document.querySelector("#services");e.forEach(e=>{const{id:n,serviceName:s,price:o}=e,c=document.createElement("DIV");c.classList.add("service"),c.dataset.idService=n;const a=document.createElement("P");a.classList.add("service-name"),a.textContent=s;const i=document.createElement("P");i.classList.add("service-price"),i.textContent="$ "+o,c.appendChild(a),c.appendChild(i),c.onclick=function(){selectService(e)},t.appendChild(c)})},selectService=e=>{const{id:t}=e,{services:n}=appointment;n.some(e=>e.id===t)?appointment.services=n.filter(e=>e.id!==t):appointment.services=[...n,e];document.querySelector(`[data-id-service="${t}"]`).classList.toggle("serviceSelected")};function getClientInfo(){appointment.fullName=document.querySelector("#fullName").value.trim();document.querySelector("#appointmentDate").addEventListener("input",e=>{const t=new Date(e.target.value).getUTCDay();[6,0].includes(t)?(e.target.value="",showAlerts("Los fines de semana el salon se encuentra cerrado","errors")):appointment.appointmentDate=e.target.value});document.querySelector("#appointmentTime").addEventListener("input",e=>{const t=e.target.value.split(":");t[0]<10||t[0]>19||19===parseInt(t[0])&&t[1]>0?showAlerts("El salon se encuentra abierto de 10 a 19","errors"):appointment.appointmentTime=e.target.value})}const showAlerts=(e,t)=>{if(!document.querySelector(".alert")){const n=document.createElement("DIV");n.textContent=e,n.classList.add("alert"),n.classList.add(t);document.querySelector(".form").prepend(n),setTimeout(()=>{n.remove()},3e3)}};