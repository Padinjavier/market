// -----------------------------------------------------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------------------------------------
document.write(`<script src="${base_url}/Assets/js/plugins/JsBarcode.all.min.js"></script>`);
let tableSalidas;
let rowTable = "";
$(document).on('focusin', function(e) {
    if ($(e.target).closest(".tox-dialog").length) {
        e.stopImmediatePropagation();
    }
});
tableSalidas = $('#tableSalidas').dataTable( {
    "aProcessing":true,
    "aServerSide":true,
    "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
    },
    "ajax":{
        "url": " "+base_url+"/Salidas/getSalidas",
        "dataSrc":""
    },
    "columns":[
        {"data":"idsalida"},
        {"data":"codigo_venta"},
        {"data":"nombre_completo"},
        {"data":"datecreated"},
        {"data":"pago_status"},
        {"data":"options"}
    ],
    "columnDefs": [
                    { 'className': "textcenter", "targets": [ 3 ] },
                    { 'className': "textcenter", "targets": [ 4 ] },
                    { 'className': "textcenter", "targets": [ 5 ] }
                  ],       
    'dom': 'lBfrtip',
        'buttons': [
            {
                "extend": "copyHtml5",
                "text": "<i class='far fa-copy'></i> Copiar",
                "titleAttr":"Copiar",
                "className": "btn btn-secondary",
                "exportOptions": { 
                "columns": [ 0, 1, 2, 3, 4] 
            }
            },{
                "extend": "excelHtml5",
                "text": "<i class='bi bi-file-earmark-excel'></i> Excel",
                "titleAttr":"Exportar a Excel",
                "className": "btn btn-success",
                "exportOptions": { 
                "columns": [ 0, 1, 2, 3, 4] 
            }
            },{
                "extend": "pdfHtml5",
                "text": "<i class='bi bi-filetype-pdf'></i> Pdf",
                "titleAttr":"Exportar a PDF",
                "className": "btn btn-danger",
                "exportOptions": { 
                "columns": [ 0, 1, 2, 3, 4] 
            }
            },{
                "extend": "csvHtml5",
                "text": "<i class='fas fa-file-csv'></i> CSV",
                "titleAttr":"Exportar a CSV",
                "className": "btn btn-info d-none",
                "exportOptions": { 
                "columns": [ 0, 1, 2, 3, 4] 
            }
            }
        ],
    "resonsieve":"true",
    "bDestroy": true,
    "iDisplayLength": 10,
    "order":[[0,"desc"]]  
});
window.addEventListener('load', function() {
    if(document.querySelector("#formSalidas")){
        let formSalidas = document.querySelector("#formSalidas");
        formSalidas.onsubmit = function (e) {
            e.preventDefault();
            let idSalida = document.querySelector('#idSalida').value;
            let CodVenta = document.querySelector('#listCodVenta').options[document.querySelector('#listCodVenta').selectedIndex].text;
            // let CodVenta = document.querySelector('#listCodVenta').value;
            let idNombre = document.querySelector('#listNombres').value;
            let Pago = document.querySelector('#listEstPago').value;
            let Nombreexterno = document.querySelector('#txtNombre').value;
            let descripcion = document.querySelector('#txtdescripcion').value;
            
            // Obtener datos de los servicios
            let servicios = [];
            document.querySelectorAll("tr.detalle-salida-row").forEach(row => {
                let selectServicio = row.querySelector("select.servicio-select");
                let cantidad = row.querySelector("input.cantidad").value;
        
                if (selectServicio && selectServicio.value !== '' && cantidad !== '' ) {
                    let nombreServicio = selectServicio.options[selectServicio.selectedIndex].text;
                    let idServicio = selectServicio.value;
                    servicios.push({
                        idServicio: idServicio,
                        servicio: nombreServicio,
                        cantidad: parseFloat(cantidad)
                    });
                }
            });
        
           //console.log(idSalida)
           //console.log(CodVenta)
           //console.log(idNombre)
           //console.log(Pago)
           //console.log(Nombreexterno)
           //console.log(descripcion)
        
            // Imprimir servicios
            if (servicios.length > 0) {
                //console.log("Servicios:", servicios);
            }
        
            // // Verificar campos obligatorios
            if (CodVenta == '' || servicios == '') {
                swal("Atención", "Todos los campos obligatorios deben ser llenados.", "error");
                return false;
            }
        
            divLoading.style.display = "flex";
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url + '/Salidas/setSalida';
            let formData = new FormData();
            
            // Agregar datos al formData
            formData.append('idSalida', idSalida);
            formData.append('CodVenta', CodVenta);
            formData.append('idNombre', idNombre);
            formData.append('Pago', Pago);
            formData.append('Nombreexterno', Nombreexterno);
            formData.append('descripcion', descripcion);
            formData.append('servicios', JSON.stringify(servicios));
        
            request.open("POST", ajaxUrl, true);
            request.send(formData);
            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {
                  //console.log(request)
                  //console.log(request.responseText)
                    let objData = JSON.parse(request.responseText);
                    if (objData.status) {
                      //console.log(objData)
                      //console.log(objData.data)
                      if(rowTable == ""){
                        tableSalidas.api().ajax.reload();
                      } else {
                        tableSalidas.api().ajax.reload();
                      }
        
                        $('#modalFormSalidas').modal("hide");
                        formSalidas.reset();
                        if(objData.action=="insert"){
                          swal("Guardado", objData.msg ,"success");
                        }else{
                            swal("Actualizado", objData.msg ,"success");
                        }
                    } else {
                        swal("Error", objData.msg, "error");
                    }
                }
                divLoading.style.display = "none";
                return false;
              }
            }
          }
},false);

function fntDelInfo(idSalida){
    swal({
        title: "Eliminar Salida",
        text: "¿Realmente quiere eliminar la Salida?",
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
            let ajaxUrl = base_url+'/Salidas/delSalida';
            let strData = "idSalida="+idSalida;
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    //console.log(request);
                    //console.log(request.responseText);
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        swal("Eliminar!", objData.msg , "success");
                        tableSalidas.api().ajax.reload();
                    }else{
                        swal("Atención!", objData.msg , "error");
                    }
                }
            }
        }

    });

}








function fntEditInfo(element,idSalida){

      // Eliminar elementos del grupo de servicio pero debe dejar al menos uno
  let detalleVentaRows = document.querySelectorAll('.detalle-salida-row');
  for (let i = 0; i < detalleVentaRows.length; i++) {
      detalleVentaRows[i].remove();
  }

    rowTable = element.parentNode.parentNode.parentNode;
    document.querySelector('#titleModal').innerHTML ="Actualizar Salida";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar";
    let request = (window.XMLHttpRequest) ? 
                    new XMLHttpRequest() : 
                    new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/Salidas/getSalida/' + idSalida;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                //console.log(objData.data.Salida);
                //console.log(objData.data.detalle_salida);

                document.querySelector('#idSalida').value = objData.data.Salida.idsalida;
                $('#listCodVenta').selectpicker('val', objData.data.Salida.idventa);
                $('#listCodVenta').selectpicker('render');
                $('#listNombres').selectpicker('val', objData.data.Salida.personaid);
                $('#listNombres').selectpicker('render');
                $('#listEstPago').selectpicker('val', objData.data.Salida.pago);
                $('#listEstPago').selectpicker('render');

                // arreglas esto 
                if(objData.data.Salida.persona_externa) {
                    if(!document.querySelector('#externo').checked) {
                        document.querySelector('#externo').click();
                    }
                    document.querySelector('#txtNombre').value = objData.data.Salida.persona_externa;
                    document.querySelector('#txtdescripcion').value = objData.data.Salida.descripcion;
                } else {
                    if(document.querySelector('#externo').checked) {
                        document.querySelector('#externo').click();
                    }
                }

                let cantidadDatos = objData.data.detalle_salida.length;
                for (let i = 0; i < cantidadDatos; i++) {
                    btnAgregar.click();
                }     
                $('#modalFormSalidas').modal('show');
                setTimeout(function() {
                    asignarDatos(objData.data.detalle_salida);
                }, 1500);
            } else {
                swal("Error", objData.msg, "error");
            }
        }
    }
}
function asignarDatos(detalleSalida) {
    let cantidadDatos = detalleSalida.length;
    // Asignar los datos a los grupos respectivos
    let grupos = document.querySelectorAll(".detalle-salida-row");
  
    for (let i = 0; i < cantidadDatos; i++) {
        let datosLote = detalleSalida[i];
        let grupoActual = grupos[i];
        if (grupoActual) {
            let servicioSelect = grupoActual.querySelector("#selectSalida");
            if (servicioSelect) {
                servicioSelect.value = datosLote.idservicio;
                $(servicioSelect).selectpicker('refresh');
            }
  
            let cantidadInput = grupoActual.querySelector(".cantidad");
            if (cantidadInput) {
                cantidadInput.value = datosLote.cantidad;
            }
          }
      }
  }



function fntViewInfo(idSalida){
    let request = (window.XMLHttpRequest) ? 
                    new XMLHttpRequest() : 
                    new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Salidas/getSalida/'+idSalida;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){

            //console.log(request)
            //console.log(request.responseText)

            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                
                let estadoSalida = objData.data.Salida.pago == 1 ? 
                 '<span style="color: white; background-color:  red; padding: 5px; border-radius: 3px;"> Falta'+ objData.data.Salida.pago +'</span>': 
                 '<span style="color: white; background-color: green; padding: 5px; border-radius: 3px;"> Listo'+ objData.data.Salida.pago +'</span>';

                servicios =""
                cantidad =""
                Cantidad_total=0;
                for (i=0;i<objData.data.detalle_salida.length ; i++){
                    servicios += objData.data.detalle_salida[i].nombre_servicio + " -> " + objData.data.detalle_salida[i].cantidad + "<br>";
                // }
                // for (i=0;i<objData.data.detalle_salida.length ; i++){
                // cantidad +="<i class='bi bi-circle'></i> "+ objData.data.detalle_salida[i].cantidad + "<br>";
                Cantidad_total+= objData.data.detalle_salida[i].cantidad;
                }
                document.querySelector("#celCodigo").innerHTML = objData.data.Salida.codigo_venta;
                document.querySelector("#celNombre").innerHTML = objData.data.Salida.nombre_completo;
                document.querySelector("#celEstadoPago").innerHTML = estadoSalida;
                document.querySelector("#celDescripcion").innerHTML = objData.data.Salida.descripcion;
                document.querySelector("#celTipoServicios").innerHTML = servicios;
                document.querySelector("#celCantidad").innerHTML = Cantidad_total;
                document.querySelector("#celFecha").innerHTML = objData.data.Salida.datecreated;
               

                $('#modalViewSalida').modal('show');

            }else{
                swal("Error", objData.msg , "error");
            }
        }
    } 
}

document.addEventListener("DOMContentLoaded", function () {
    const btnAgregar = document.getElementById("btnAgregar");
    const dynamicFields = document.getElementById("dynamicFields");

    function loadInitialSelectOptions(callback) {
        let ajaxUrl = base_url + "/Servicios/getSelectServicios";
        let request = new XMLHttpRequest();
        request.open("GET", ajaxUrl, true);
        request.send();
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {
                let response = JSON.parse(request.responseText);
                callback(response);
            }
        };
    }

    function addNewServicioRow(response) {
        const newRow = document.createElement("tr");
      newRow.classList.add("detalle-salida-row");
        newRow.innerHTML = `
            <td>
                <select class="form-control selectpicker servicio-select" id="selectSalida" name="listServicio[]" required="" data-live-search="true">
                    ${response[0]}
                </select>
            </td>
            <td>
                <div class="col-auto">
                    <button type="button" class="btn btn-danger btn-remove-select btn-sm">X</button>
                </div>
            </td>
            <td>
                <input class="form-control cantidad" name="cantidad[]" type="number" placeholder="0">
            </td>
        `;
        dynamicFields.appendChild(newRow);

        // Inicializar los nuevos selects de Bootstrap Select
        $(newRow).find('.selectpicker').selectpicker('refresh');

        // Agregar evento para eliminar la fila
        newRow.querySelector(".btn-remove-select").addEventListener("click", function () {
            newRow.remove();
        });
    }

    btnAgregar.addEventListener("click", function () {
        loadInitialSelectOptions(addNewServicioRow);
    });

    // Generar una fila al iniciar la página
    loadInitialSelectOptions(addNewServicioRow);
});


// arreglas esto 
document.addEventListener("DOMContentLoaded", function () {
    const externoBtn = document.getElementById("externo");
    const listNombres = document.getElementById("listNombres");
    // const listEstPago = document.getElementById("listEstPago");
    const txtNombre = document.getElementById("txtNombre");
    const txtdescripcion = document.getElementById("txtdescripcion");

    externoBtn.addEventListener("click", function () {
        if (listNombres.disabled) {
            // Activar selects
            listNombres.disabled = false;
            listNombres.setAttribute("required", "");
            $(listNombres).selectpicker("refresh");

            // Desactivar inputs
            txtNombre.disabled = true;
            txtNombre.value = ""; // Limpiar el valor del input
            txtdescripcion.disabled = true;
            txtdescripcion.value = ""; // Limpiar el valor del input

        } else {
            // Desactivar selects
            listNombres.disabled = true;
            listNombres.removeAttribute("required");
            listNombres.value = ""; // Limpiar el valor seleccionado
            $(listNombres).selectpicker("refresh");

            // Activar inputs
            txtNombre.disabled = false;
            txtdescripcion.disabled = false;
        }
    });
});



document.addEventListener("DOMContentLoaded", function() {
    fntListCategorias();
    fntListNombres();
});


function fntListCategorias(){
    if(document.querySelector('#listCodVenta')){
        let ajaxUrl = base_url+'/Ventas/getSelectVentas';
        let request = (window.XMLHttpRequest) ? 
                    new XMLHttpRequest() : 
                    new ActiveXObject('Microsoft.XMLHTTP');
        request.open("GET",ajaxUrl,true);
        request.send();
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                document.querySelector('#listCodVenta').innerHTML = request.responseText;
                $('#listCodVenta').selectpicker('render');
            }
        }
    }
}
function fntListNombres(){
    if(document.querySelector('#listNombres')){
        let ajaxUrl = base_url+'/Empleados/getSelectEmpleados';
        let request = (window.XMLHttpRequest) ? 
                    new XMLHttpRequest() : 
                    new ActiveXObject('Microsoft.XMLHTTP');
        request.open("GET",ajaxUrl,true);
        request.send();
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                document.querySelector('#listNombres').innerHTML = request.responseText;
                $('#listNombres').selectpicker('render');
            }
        }
    }
}

function openModal()
{
    rowTable = "";
    document.querySelector('#idSalida').value ="";
    document.querySelector('#txtNombre').value ="";
    document.querySelector('#txtdescripcion').value ="";
    $('#listCodVenta').selectpicker('val', '');
    $('#listNombres').selectpicker('val', '');
    $('#listEstPago').selectpicker('val', '1');
    $('.servicio-select').selectpicker('val', '');
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nueva Salida";
    document.querySelector("#formSalidas").reset();
    $('#modalFormSalidas').modal('show');
}