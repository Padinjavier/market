document.addEventListener('DOMContentLoaded', function(){

    if (document.querySelector("#boxchat")) {
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url + '/Chat/getChat';
        request.open("POST", ajaxUrl, true);
        request.send();
        request.onreadystatechange = function() {
            if (request.readyState == 4 && request.status == 200) {
                let objData = JSON.parse(request.responseText);
                console.log(objData.data);
                if (objData.status) {
                    let html = '';
                    objData.data.forEach((userData, i) => {
                        html += `<li class="p-2 border-bottom">
                                    <a href="#!" id="${i}" class="d-flex justify-content-between">
                                        <div class="d-flex flex-row">
                                            <div>
                                                <img class="app-sidebar__user-avatar" src="Assets/images/avatar1.png" alt="User Image">
                                                <span class="badge bg-success badge-dot"></span>
                                            </div>
                                            <div class="pt-1">
                                                <p class="fw-bold mb-0 nombre">${userData.nombres} ${userData.apellidos}</p>
                                                <p class="small text-muted">${userData.msg}</p>
                                            </div>
                                        </div>
                                        <div class="pt-1">
                                            <p class="small text-muted mb-1">Just now</p>
                                            <span class="badge bg-danger rounded-pill float-end">${i}</span>
                                        </div>
                                    </a>
                                </li>`;
                    });
                    document.querySelector('#boxchat').innerHTML = html;
                } else {
                    let html = '';
                    objData.data.forEach((userData, i) => {
                        html += `<li class="p-2 border-bottom">
                                    Por aquie esta muy desolado.
                                </li>`;
                    });
                    document.querySelector('#boxchat').innerHTML = html;
                }
            }
        }
    }
    

}, false);



function openModal() {
    console.log("Abriendo/cerrando panel de chat...");
  
    const chatPanel = document.getElementById("chat-panel");
    const chatIcon = document.getElementById("icono");
  
    if (chatPanel.style.display === "none" || chatPanel.style.display === "") {
      chatPanel.style.display = "block";
      document.documentElement.style.overflow = "hidden"; // Bloquear scroll en el html
    //   document.documentElement.style.paddingRight = "3px"; // Agregar padding derecho
      chatIcon.classList.remove("fa-comment");
      chatIcon.classList.add("bi", "bi-x-lg"); // Cambiar a ícono de cerrar
    } else {
      chatPanel.style.display = "none";
      document.documentElement.style.overflow = ""; // Desbloquear scroll en el html
    //   document.documentElement.style.paddingRight = "0"; // Eliminar padding derecho
      chatIcon.classList.remove("bi", "bi-x-lg");
      chatIcon.classList.add("fas", "fa-comment"); // Cambiar a ícono de comentario
    }
  }
  