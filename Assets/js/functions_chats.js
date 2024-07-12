document.addEventListener('DOMContentLoaded', function(){

    if(document.querySelector("#boxchat")){
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Chat/getChat';
        request.open("POST",ajaxUrl,true);
        request.send();
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                let objData = JSON.parse(request.responseText);
                console.log(objData.data);
                if(objData.status)
                {
                    document.querySelector('#boxchat').innerHTML = objData.data;
                }else{
                    swal("Error", objData.msg , "error");
                }
            }
        }

    }

}, false);


window.addEventListener('load', function() {
        fntRolesEmpleado();
}, false);

function fntRolesEmpleado(){
    if(document.querySelector('#listRolid')){
        let ajaxUrl = base_url+'/RolesEmpleados/getSelectRoles';
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        request.open("GET",ajaxUrl,true);
        request.send();
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                document.querySelector('#listRolid').innerHTML = request.responseText;
                $('#listRolid').selectpicker('render');
            }
        }
    }
}

function fntViewEmpleado(idpersona){
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Empleados/getEmpleado/'+idpersona;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);

            if(objData.status)
            {
               let estadoEmpleado = objData.data.status == 1 ? 
                '<span class="badge badge-success">Activo</span>' : 
                '<span class="badge badge-danger">Inactivo</span>';

                document.querySelector("#celIdentificacion").innerHTML = objData.data.identificacion;
                document.querySelector("#celNombre").innerHTML = objData.data.nombres;
                document.querySelector("#celApellido").innerHTML = objData.data.apellidos;
                document.querySelector("#celTelefono").innerHTML = objData.data.telefono;
                document.querySelector("#celEmail").innerHTML = objData.data.email_user;
                document.querySelector("#celTipoEmpleado").innerHTML = objData.data.nombrerolempleado;
                document.querySelector("#celEstado").innerHTML = estadoEmpleado;
                document.querySelector("#celFechaRegistro").innerHTML = objData.data.datecreated; 
                $('#modalViewUser').modal('show');
            }else{
                swal("Error", objData.msg , "error");
            }
        }
    }
}

function fntEditEmpleado(element,idpersona){
    rowTable = element.parentNode.parentNode.parentNode; 
    document.querySelector('#titleModal').innerHTML ="Actualizar empleado";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    // document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar";
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Empleados/getEmpleado/'+idpersona;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){

        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);

            if(objData.status)
            {
                console.log(objData.data)


                document.querySelector("#idEmpleado").value = objData.data.idpersona;
                document.querySelector("#txtIdentificacion").value = objData.data.identificacion;
                document.querySelector("#txtNombre").value = objData.data.nombres;
                document.querySelector("#txtApellido").value = objData.data.apellidos;
                document.querySelector("#txtTelefono").value = objData.data.telefono;
                document.querySelector("#txtEmail").value = objData.data.email_user;
                document.querySelector("#listRolid").value =objData.data.idrolempleado;
                $('#listRolid').selectpicker('render');

                if(objData.data.status == 1){
                    document.querySelector("#listStatus").value = 1;
                }else{
                    document.querySelector("#listStatus").value = 2;
                }
                $('#listStatus').selectpicker('render');
            }
        }
    
        $('#modalFormEmpleado').modal('show');
    }
}

function fntDelEmpleado(idpersona){
    swal({
        title: "Eliminar Empleado",
        text: "¿Realmente quiere eliminar al Empleado?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, eliminar!",
        cancelButtonText: "No, cancelar!",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        
        if (isConfirm) 
        {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Empleados/delEmpleado';
            // cuando es post es los name de los imput
            let strData = "idEmpleado="+idpersona;
            request.open("POST",ajaxUrl,true);
            console.log(strData)
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        swal("Empleados", objData.msg , "success");
                        tableEmpleados.api().ajax.reload();
                    }else{
                        swal("Atención!", objData.msg , "error");
                    }
                }
            }
        }

    });

}




document.addEventListener('DOMContentLoaded', function() {
    // Seleccionar el elemento <p> con la clase 'nombre'
    const nombreElement = document.querySelector('.nombre');

    // Verificar si se encontró el elemento
    if (nombreElement) {
        nombreElement.textContent += ' usuario';
    }

    document.getElementById('close-chat').addEventListener('click', closeChat);
    document.getElementById('back-to-chat-panel').addEventListener('click', showChatPanel);

    document.querySelectorAll('#chat-panel a').forEach(item => {
        item.addEventListener('click', function() {
            abrirChat(this.id);
        });
    });



    
});


  


function closeChat() {
    document.getElementById('chat-panel').style.display = 'none';
    document.getElementById('chat').style.display = 'none';
    document.body.style.overflow = ''; // Desbloquear scroll
}

function showChatPanel() {
    document.getElementById('chat-panel').style.display = 'block';
    document.getElementById('chat').style.display = 'none';
    document.body.style.overflow = 'hidden'; // Bloquear scroll
}

function abrirChat(id) {
    document.getElementById('chat-panel').style.display = 'none';
    document.getElementById('chat').style.display = 'block';

    const paragraph = document.querySelector('#chat p.www');
    paragraph.innerHTML += id;
}

function fntEditInfo(element, idpersona) {
    rowTable = element.closest('tr');
    document.querySelector('#titleModal').textContent = "Actualizar Cliente";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').textContent = "Actualizar";

    const request = new XMLHttpRequest();
    const ajaxUrl = `${base_url}/Clientes/getCliente/${idpersona}`;
    request.open("GET", ajaxUrl, true);
    request.send();

    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            const objData = JSON.parse(request.responseText);
            if (objData.status) {
                document.querySelector("#idUsuario").value = objData.data.idpersona;
                document.querySelector("#txtIdentificacion").value = objData.data.identificacion;
                document.querySelector("#txtNombre").value = objData.data.nombres;
                document.querySelector("#txtApellido").value = objData.data.apellidos;
                document.querySelector("#txtTelefono").value = objData.data.telefono;
                document.querySelector("#txtEmail").value = objData.data.email_user;
                document.querySelector("#txtHotel").value = objData.data.hotel;
            }
            $('#modalFormCliente').modal('show');
        }
    };
}


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
  