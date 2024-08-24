document.addEventListener('DOMContentLoaded', function () {
    let previousDatauser = "";
    let isSearching = false;
    let allUsersData = [];
    let audioEnabled = false; // Variable para controlar si el audio está habilitado
    const audio = new Audio("http://192.168.56.1/market/Assets/music/ringtones-heart.mp3");
    // Escucha el primer clic del usuario en la página para habilitar el audio
    document.addEventListener('click', () => {
        audioEnabled = true;
        console.log("Notificaciones de sonido habilitadas.");
    }, { once: true });

    document.getElementById("chat-icon").addEventListener("click", openModalChat);

    function openModalChat() {
        console.log("Abriendo/cerrando panel de chat...");
        const chatPanel = document.getElementById("chat-panel");
        const chatIcon = document.getElementById("icono");
        if (chatPanel.style.display === "none" || chatPanel.style.display === "") {
            chatPanel.style.display = "block";
            document.documentElement.style.overflow = "hidden";
            chatIcon.classList.remove("fa-comment");
            chatIcon.classList.add("bi", "bi-x-lg");
            document.getElementById("nummsg").classList.add('d-none');
            
        } else {
            chatPanel.style.display = "none";
            document.documentElement.style.overflow = "";
            chatIcon.classList.remove("bi", "bi-x-lg");
            chatIcon.classList.add("fas", "fa-comment");
            document.getElementById("nummsg").classList.remove('d-none');
            resetChatList();
        }
    }

    function resetChatList() {
        displayChatUsers(allUsersData.filter(user => user.msg !== ""));
    }

    function displayChatUsers(users) {
        let html = '';
        let totalmsg=0;
        users.forEach(user => {
            let unreadCount = user.unread_count || 0;
            totalmsg= totalmsg + unreadCount;

            let spanunreadCount=(unreadCount != "0") ?
            `<span id="unreadBadge" class="badge bg-danger rounded-pill float-end text-white">${unreadCount}</span>` :
            ``;

            let conect = (user.conexion === "0" || user.conexion === null) ?
                `<span class='text-danger'>inactivo</span>` :
                `<span class='text-info'>activo</span>`;

            let lastConnection = (user.conexion === "1") ?
                `<p class="small text-muted mb-1">Ahora</p>` :
                `<p class="small text-muted mb-1">${user.time_conexion}</p>`;

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
                                ${spanunreadCount}
                            </div>
                        </a>
                    </li>`;
        });
        if(totalmsg>0){
            document.querySelector('#nummsg').innerHTML = totalmsg;
            document.querySelector('#nummsg').classList.remove('d-none');
        }else{
            document.querySelector('#nummsg').classList.add('d-none');
        }
        document.querySelector('#boxchat').innerHTML = html;
    }

    if (document.querySelector("#boxchat")) {
        const updateChat = () => {
            if (isSearching) return;

            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url + '/Chat/getChat';
            request.open("POST", ajaxUrl, true);
            request.send();
            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {
                    let objData = JSON.parse(request.responseText);
                    if (objData.status) {
                        let currentDatauser = JSON.stringify(objData.data);

                        if (currentDatauser !== previousDatauser) {
                            if (audioEnabled && previousDatauser !== "") {
                                audio.play().catch(error => console.log("Error reproduciendo el audio:", error));
                            }

                            previousDatauser = currentDatauser;
                            allUsersData = objData.data;
                            displayChatUsers(objData.data.filter(user => user.msg !== ""));
                        }
                    } else {
                        let html = '<li class="p-2 border-bottom">Por aquí está muy desolado.</li>';
                        document.querySelector('#boxchat').innerHTML = html;
                    }
                }
            }
        };

        updateChat();
        setInterval(updateChat, 250);

        const searchInput = document.getElementById('search-input');
        searchInput.addEventListener('focus', function () {
            isSearching = true;
            displayChatUsers(allUsersData);
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
            displayChatUsers(filteredUsers);
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


//-----------------------------------------------------------------------------
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
                console.log(request.responseText);
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
                        let previousDate = null;

                        userData.forEach((message, i) => {
                            const messageDate = new Date(message.datecreated);

                            // Truncar las horas, minutos y segundos de la fecha para comparar solo la fecha (día, mes, año)
                            const currentDate = new Date();
                            const truncatedMessageDate = new Date(messageDate.getFullYear(), messageDate.getMonth(), messageDate.getDate());
                            const truncatedCurrentDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), currentDate.getDate());

                            // Formatear la hora y minutos del mensaje
                            const messageTime = messageDate.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

                            // Verificar si se debe agregar un separador
                            if (previousDate === null || !isSameDay(previousDate, truncatedMessageDate)) {
                                const daysAgo = daysBetween(truncatedMessageDate, truncatedCurrentDate);

                                if (daysAgo === 0) {
                                    html += `<div class="day-separator text-center fw-bold">Hoy</div>`;
                                } else if (daysAgo === 1) {
                                    html += `<div class="day-separator text-center fw-bold">Ayer</div>`;
                                } else if (daysAgo < 5) {
                                    const dayName = getDayName(truncatedMessageDate);
                                    html += `<div class="day-separator text-center fw-bold">${dayName}</div>`;
                                } else {
                                    const formattedDate = formatDate(truncatedMessageDate);
                                    html += `<div class="day-separator text-center fw-bold">${formattedDate}</div>`;
                                }

                                previousDate = truncatedMessageDate;
                            }

                            // Resto del código para mostrar el mensaje
                            if (message.input_msg_id == idpersona) {
                                html += `<div class="d-flex flex-row justify-content-start mb-4">
                                            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp" alt="avatar 1" style="width: 45px; height: 100%;">
                                            <div class="p-2 pr-3" style="border-radius: 15px; background-color: #e5e5e5;" title="${message.datecreated}">
                                                <p class="small mb-0 ml-5" style="word-break: break-all; overflow-wrap: break-word; font-size: 13.5px;">${message.msg}</p>
                                                <p class="small mb-0" style="font-size: 10px; text-align:start;">${messageTime}</p>
                                            </div>
                                        </div>`;
                            } else {
                                html += `<div class="d-flex flex-row justify-content-end mb-4">
                                            <div class="p-2 pl-3 border" style="border-radius: 15px; background-color: rgba(57, 192, 237, .2);" title="${message.datecreated}">
                                                <p class="small mb-0 mr-5" style="word-break: break-all; overflow-wrap: break-word; font-size: 13.5px;">${message.msg}</p>
                                                <p class="small mb-0" style="font-size: 10px; text-align:end;">${messageTime}</p>
                                            </div>
                                            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava2-bg.webp" alt="avatar 1" style="width: 45px; height: 100%;">
                                        </div>`;
                            }
                        });

                        // Función para verificar si dos fechas son el mismo día
                        function isSameDay(date1, date2) {
                            return date1.getDate() === date2.getDate() &&
                                date1.getMonth() === date2.getMonth() &&
                                date1.getFullYear() === date2.getFullYear();
                        }

                        // Función para obtener la diferencia en días entre dos fechas
                        function daysBetween(date1, date2) {
                            const oneDay = 24 * 60 * 60 * 1000;
                            return Math.floor((date2 - date1) / oneDay);
                        }

                        // Función para obtener el nombre del día
                        function getDayName(date) {
                            const days = ['domingo', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado'];
                            return days[date.getDay()];
                        }

                        // Función para formatear la fecha como "dd/mm/yyyy"
                        function formatDate(date) {
                            return date.getDate().toString().padStart(2, '0') + '/' +
                                (date.getMonth() + 1).toString().padStart(2, '0') + '/' +
                                date.getFullYear();
                        }


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

