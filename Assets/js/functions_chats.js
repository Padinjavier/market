document.addEventListener('DOMContentLoaded', function () {
    let previousDatauser = ""; // Variable para almacenar los datos anteriores del array
    let isSearching = false; // Bandera para pausar la actualización durante la búsqueda
    let allUsersData = []; // Variable para almacenar todos los usuarios
    document.getElementById("chat-icon").addEventListener("click", openModalChat);

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
            resetChatList(); // Restablecer el listado de chats cuando se cierra el panel
        }
    }

    function resetChatList() {
        displayChatUsers(allUsersData.filter(user => user.msg !== ""));
    }

    function displayChatUsers(users) {
        let html = '';
        users.forEach(user => {
            let unreadCount = user.unread_count || 0;
            let conect = (user.conexion === "0" || user.conexion === null) ?
                `<span class='text-danger'>inactivo</span>` :
                `<span class='text-info'>activo</span>`;

            // Define la variable para la última conexión
            let lastConnection = (user.conexion === "1") ? 
                `<p class="small text-muted mb-1">Ahora</p>` : 
                `<p class="small text-muted mb-1">${user.time_conexion}</p>`;

// Obtener las iniciales
let initials = user.nombres.charAt(0) + user.apellidos.charAt(0);

            html += `<li class="p-2 border-bottom" style="cursor: pointer;">
                        <a id="${user.idpersona}" class="d-flex justify-content-between" onclick="openChat(${user.idpersona});">
                            <div class="d-flex flex-row">
                                <div class="d-flex align-items-center pr-2">
                                    <div class="initials-circle bg-primary text-white text-center">
                                        <span>${initials}</span>
                                    </div>
                                </div>
                                <div class="pt-1">
                                    <p class="fw-bold mb-0 h6 nombre">${user.nombres} ${user.apellidos} ${conect}</p>
                                    <p class="small text-muted" style="border-radius: 15px; word-break: break-all; overflow-wrap: break-word;">${user.msg || ''}</p>
                                </div>
                            </div>
                            <div class="pt-1 d-flex flex-column align-items-end">
                                ${lastConnection}
                                <span class="badge bg-danger rounded-pill float-end text-white">${unreadCount}</span>
                            </div>
                        </a>
                    </li>`;
        });
        document.querySelector('#boxchat').innerHTML = html;
    }


    if (document.querySelector("#boxchat")) {
        const updateChat = () => {
            if (isSearching) return; // Pausar la actualización si se está buscando

            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url + '/Chat/getChat'; // Endpoint para obtener los chats
            request.open("POST", ajaxUrl, true);
            request.send();
            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {
                    let objData = JSON.parse(request.responseText);
                    if (objData.status) {
                        let currentDatauser = JSON.stringify(objData.data); // Convertir los datos actuales a string JSON

                        if (currentDatauser !== previousDatauser) {
                            previousDatauser = currentDatauser; // Actualizar los datos anteriores
                            allUsersData = objData.data; // Guardar todos los usuarios
                            displayChatUsers(objData.data.filter(user => user.msg !== "")); // Mostrar solo usuarios con mensajes
                        }
                    } else {
                        let html = '<li class="p-2 border-bottom">Por aquí está muy desolado.</li>';
                        document.querySelector('#boxchat').innerHTML = html;
                    }
                }
            }
        };

        // Ejecutar la función updateChat inicialmente y luego cada 250 milisegundos
        updateChat();
        setInterval(updateChat, 250);

        // Añadir event listener al input de búsqueda
        const searchInput = document.getElementById('search-input');
        searchInput.addEventListener('focus', function () {
            isSearching = true;
            displayChatUsers(allUsersData); // Mostrar todos los usuarios al hacer clic en la barra de búsqueda
        });
        searchInput.addEventListener('blur', function () {
            isSearching = false;
        });
        searchInput.addEventListener('input', function () {
            const searchTerm = searchInput.value.toLowerCase();
            const filteredUsers = allUsersData.filter(user => {
                const nombre = `${user.nombres} ${user.apellidos}`.toLowerCase();
                return nombre.includes(searchTerm);
            });
            displayChatUsers(filteredUsers); // Mostrar usuarios filtrados por el término de búsqueda
        });
    }



    function closeChat() {
        const chatSection = document.getElementById("chat");
        const chatpanel = document.getElementById("chat-panel");
        chatSection.style.display = "none";
        chatpanel.style.display = "block";
        clearInterval(messageInterval);
        messageInterval = null;
        document.querySelector('#msgbox').innerHTML = "";
        document.querySelector('#namechat').innerHTML = "";
    }

    document.querySelector('#msg').addEventListener('keyup', function () {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });

    document.getElementById("close-chat").addEventListener("click", closeChat);
    document.getElementById("back-to-chat-panel").addEventListener("click", closeChat);
});


let messageInterval; // Variable global para almacenar el intervalo
let previousData = ""; // Variable para almacenar los datos anteriores del array

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
                    let currentData = JSON.stringify(objData.data); // Convertir los datos actuales a string JSON
                    // Solo actualizar si hay cambios en los mensajes
                    if (currentData !== previousData || chatopen) {
                        chatopen = false;
                        previousData = currentData; // Actualizar los datos anteriores

                        console.log(objData.data);
                        console.log("Tienes: ", objData.data.filter(msg => msg.msg && msg.msg.trim() !== '').length, " mensajes");

                        let userData = objData.data;
                        let htmlHeader = userData[0].nombres;
                        let htmlidpersona = userData[0].idpersona;
                        document.querySelector('#namechat').innerHTML = htmlHeader;
                        document.querySelector('#idpersona').value = htmlidpersona;
                        console.log(htmlidpersona)

                        let html = "";
                        userData.forEach((message, i) => {
                            if (message.msg !== null) {
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

function fntsendmsg() {
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/Chat/setMSG/';

    let idpersona = document.querySelector("#idpersona").value;
    let msg = document.querySelector("#msg").value.trim();

    if (idpersona === '' || msg === '') {
        alert('ID de persona o mensaje vacío.');
        return;
    }

    let formData = new FormData();
    formData.append('idpersona', idpersona);
    formData.append('msg', msg);

    request.open("POST", ajaxUrl, true);
    request.send(formData);

    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
                console.log("Mensaje enviado");
                // Limpia el campo de mensaje
                document.querySelector("#msg").value = '';
            } else {
                console.log("Error al enviar mensaje");
            }
        }
    }
}

