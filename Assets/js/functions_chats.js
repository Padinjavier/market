document.addEventListener('DOMContentLoaded', function () {
    let chatLength = 0; // Variable para almacenar la longitud anterior del array
    if (document.querySelector("#boxchat")) {
        const updateChat = () => {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url + '/Chat/getChat';
            request.open("POST", ajaxUrl, true);
            request.send();
            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {
                    let objData = JSON.parse(request.responseText);
                    // console.log(objData.data);
                    if (objData.status) {
                        // Solo actualizar si hay nuevos mensajes
                        if (objData.data.length > chatLength) {
                            chatLength = objData.data.length;
                            let html = '';
                            objData.data.forEach((userData, i) => {
                                userData.msg = userData.msg.length > 80 ? userData.msg.substring(0, 80) + "..." : userData.msg;
                                let conect = (userData.conexion === 0 || userData.conexion === null) ? "<span class='text-dark'>inactivo</span>" : "<span class='text-info'>activo</span>";
                                html += `<li class="p-2 border-bottom" style="cursor: pointer;">
                            <a  id="${userData.idpersona}" class="d-flex justify-content-between " onclick="openChat(${userData.idpersona});">
                            <div class="d-flex flex-row">
                            <div>
                            <img class="app-sidebar__user-avatar" src="Assets/images/avatar1.png" alt="User Image">
                            <span class="badge bg-success badge-dot"></span>
                            </div>
                            <div class="pt-1">
                            <p class="fw-bold mb-0 nombre">${userData.nombres} ${userData.apellidos} ${conect}</p>
                            <p class="small text-muted" style="border-radius: 15px; word-break: break-all; overflow-wrap: break-word;">${userData.msg}</p>
                            </div>
                            </div>
                            <div class="pt-1">
                            <p class="small text-muted mb-1">Just now</p>
                            <span class="badge bg-danger rounded-pill float-end text-info">${userData.unread_count}</span>
                            </div>
                            </a>
                            </li>`;
                            });
                            document.querySelector('#boxchat').innerHTML = html;
                        }
                    } else {
                        let html = '<li class="p-2 border-bottom">Por aquí está muy desolado.</li>';
                        document.querySelector('#boxchat').innerHTML = html;
                    }
                }
            }
        };
        // Ejecutar la función updateChat cada 500 milisegundos
        setInterval(updateChat, 250);
    }
}, false);



function openModalChat() {
    console.log("Abriendo/cerrando panel de chat...");
    const chatPanel = document.getElementById("chat-panel");
    const chatIcon = document.getElementById("icono");
    if (chatPanel.style.display === "none" || chatPanel.style.display === "") {
        chatPanel.style.display = "block";
        document.documentElement.style.overflow = "hidden"; // Bloquear scroll en el html
        chatIcon.classList.remove("fa-comment");
        chatIcon.classList.add("bi", "bi-x-lg"); // Cambiar a ícono de cerrar
    } else {
        chatPanel.style.display = "none";
        document.documentElement.style.overflow = ""; // Desbloquear scroll en el html
        chatIcon.classList.remove("bi", "bi-x-lg");
        chatIcon.classList.add("fas", "fa-comment"); // Cambiar a ícono de comentario
    }
}

let messageInterval; // Variable global para almacenar el intervalo
let previousLength = 0; // Variable para almacenar la longitud anterior del array

function openChat(idpersona) {
    const chatSection = document.getElementById("chat");
    const chatpanel = document.getElementById("chat-panel");
    chatSection.style.display = "block";
    chatpanel.style.display = "none";
    var chatopen = true;
    function getmsg(scrollToEnd = false) {
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url + '/Chat/getChatuser/' + idpersona;
        request.open("POST", ajaxUrl, true);
        request.send();
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {
                let objData = JSON.parse(request.responseText);
                if (objData.status) {

                    // Solo actualizar si hay nuevos mensajes
                    if (objData.data.length > previousLength || chatopen) {
                        chatopen = false;
                        previousLength = objData.data.length; // Actualizar la longitud anterior
                        console.log("tienes: ", objData.data.length);

                        let userData = objData.data;
                        let htmlHeader = userData[0].nombres;
                        document.querySelector('#namechat').innerHTML = htmlHeader;

                        let html = "";
                        userData.forEach((message, i) => {
                            if (message.input_msg_id == idpersona) {
                                html += `<div class="d-flex flex-row justify-content-start mb-4">
                                            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp" alt="avatar 1"
                                                style="width: 45px; height: 100%;">
                                            <div class="p-3 ms-3" style="border-radius: 15px; background-color: #e5e5e5 ;">
                                                <p class="small mb-0" style="word-break: break-all; overflow-wrap: break-word;">${message.msg}</p>
                                            </div>
                                        </div>`;
                            } else {
                                html += `<div class="d-flex flex-row justify-content-end mb-4">
                                            <div class="p-3 me-3 border" style="border-radius: 15px; background-color: rgba(57, 192, 237, .2);">
                                                <p class="small mb-0" style="word-break: break-all; overflow-wrap: break-word;">${message.msg}</p>
                                            </div>
                                            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava2-bg.webp" alt="avatar 1"
                                                style="width: 45px; height: 100%;">
                                        </div>`;
                            }
                        });
                        document.querySelector('#msgbox').innerHTML = html;

                        if (scrollToEnd) {
                            var scrollDiv = document.getElementById('msgbox');
                            scrollDiv.scrollTop = scrollDiv.scrollHeight;
                        }
                    }

                } else {
                    let html = '<li class="p-2 border-bottom">Por aquí está muy desolado.</li>';
                    document.querySelector('#msgbox').innerHTML = html;
                }
            }
        }
    }

    if (messageInterval) {
        clearInterval(messageInterval);
    }

    getmsg(true);

    messageInterval = setInterval(() => getmsg(false), 125);
}




function closeChat() {
    const chatSection = document.getElementById("chat");
    const chatpanel = document.getElementById("chat-panel");
    chatSection.style.display = "none";
    chatpanel.style.display = "block";

    if (messageInterval) {
        clearInterval(messageInterval); // Detener el intervalo cuando se cierre el chat
    }
    // reset todos los mensajes nombre de usuarios y texarea 
    document.querySelector('#namechat').innerHTML = "";
    document.querySelector('#msgbox').innerHTML = "";
    document.querySelector('#textarea').value = "";
    document.querySelector('#textarea').style.height = 'auto';
}
// Verificar si los elementos existen antes de agregarles los event listeners
if (document.getElementById("close-chat") && document.getElementById("back-to-chat-panel")) {
    document.getElementById("close-chat").addEventListener("click", closeChat);
    document.getElementById("back-to-chat-panel").addEventListener("click", closeChat);
}
