let tableVentas;
let rowTable = "";
let divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded', function(){

  tableVentas = $('#tableVentas').dataTable({
      "aProcessing":true,
      "aServerSide":true,
      "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
      },
      "ajax": {
        "url": " "+base_url+"/Ventas/getVentas",
        "dataSrc": ""
      },
      "columns": [
        { "data": "codigo_venta" },
        { "data": "nombres_emails" },
        { "data": "datecreated" },
        { "data": "tipopago_nombre" },
        { "data": "total" },
        { "data": "options" }
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
      "responsive":"true",
      "bDestroy": true,
      "iDisplayLength": 10,
      "order":[[0,"desc"]]  
    });

// ------------------------------------
// -------------se usa-----------------------
// ------------------------------------
// NUEVA VENTA
if(document.querySelector("#formUpdateVenta")){
let formVenta = document.querySelector("#formUpdateVenta");
formVenta.onsubmit = function (e) {
    e.preventDefault();
    let idVenta = document.querySelector('#idVenta').innerText;
    let strDNI = document.querySelector('#listClienteid').value;
    let idMetodoPago = document.querySelector('#listMetodoPagoid').value;
    let total = document.querySelector('#gran_total').innerText;
    
    // Obtener datos de los servicios
    let servicios = [];
    document.querySelectorAll("tr.detalle-venta-row").forEach(row => {
        let selectServicio = row.querySelector("select.servicio-select");
        let cantidad = row.querySelector("input.cantidad").value;
        let precio = row.querySelector("input.precio").value;
        let descuento = row.querySelector("input.descuento").value;
        let precioTotal = row.querySelector("input.precio_total").value;

        if (selectServicio && selectServicio.value !== '' && cantidad !== '' && precio !== '') {
            let nombreServicio = selectServicio.options[selectServicio.selectedIndex].text;
            let idServicio = selectServicio.value;
            servicios.push({
                id: idServicio,
                servicio: nombreServicio,
                cantidad: parseFloat(cantidad),
                precio: parseFloat(precio),
                descuento: parseFloat(descuento),
                precioTotal: parseFloat(precioTotal)
            });
        }
    });

   console.log(idVenta)
   console.log(strDNI)
   console.log(idMetodoPago)
   console.log(total)

    // Imprimir servicios
    if (servicios.length > 0) {
        console.log("Servicios:", servicios);
    }

    // // Verificar campos obligatorios
    if (strDNI == '' || idMetodoPago == ''|| servicios == ''|| total == '') {
        swal("Atención", "Todos los campos obligatorios deben ser llenados.", "error");
        return false;
    }

    divLoading.style.display = "flex";
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/Ventas/setVenta';
    let formData = new FormData();
    
    // Agregar datos al formData
    formData.append('idVenta', idVenta);
    formData.append('dni', strDNI);
    formData.append('metodopago', idMetodoPago);
    formData.append('servicios', JSON.stringify(servicios));
    formData.append('total', total);

    request.open("POST", ajaxUrl, true);
    request.send(formData);
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
          console.log(request)
          console.log(request.responseText)
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
              console.log(objData)
              console.log(objData.data)
              if(rowTable == ""){
                tableVentas.api().ajax.reload();
              } else {
                // rowTable.cells[0].textContent = idVenta;
                // rowTable.cells[1].textContent = strDNI;
                // rowTable.cells[2].textContent = idMetodoPago; // Fecha de la venta
                // rowTable.cells[3].textContent = idMetodoPago; // Nombre del tipo de pago
                // rowTable.cells[4].textContent = "S/" + total;
                tableVentas.api().ajax.reload();
            
              }

                $('#modalFormVenta').modal("hide");
                formVenta.reset();
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


//  clientes list------------
//  clientes list------------
window.addEventListener("load", function () {
  fntClienteslist();
}, false);

function fntClienteslist() {
  if (document.querySelector("#listClienteid")) {
      let ajaxUrl = base_url + "/Clientes/getlistclientes";
      let request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
      request.open("GET", ajaxUrl, true);
      request.send();
      request.onreadystatechange = function () {
          if (request.readyState == 4 && request.status == 200) {
              let response = request.responseText;
              document.querySelector("#listClienteid").innerHTML = response;
              $("#listClienteid").selectpicker("render");
          }
      };
  }
}
//  medio de pago list------------
//  medio de pago list------------
window.addEventListener("load", function () {
  fnttipopagolist();
}, false);

function fnttipopagolist() {
  if (document.querySelector("#listMetodoPagoid")) {
      let ajaxUrl = base_url + "/Ventas/getlisttipopago";
      let request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
      request.open("GET", ajaxUrl, true);
      request.send();
      request.onreadystatechange = function () {
          if (request.readyState == 4 && request.status == 200) {
              let response = request.responseText;
              document.querySelector("#listMetodoPagoid").innerHTML = response;
              $("#listMetodoPagoid").selectpicker("render");
          }
      };
  }
}

// // // ---------------Servicios----------
// // // ---------------Servicios----------
document.addEventListener("DOMContentLoaded", function () {
  const tblDetalleVenta = document.getElementById("tblDetalleVenta");
  const btnAgregarProducto = document.getElementById("btnAgregarProducto");

  function loadInitialSelectOptions() {
      let ajaxUrl = base_url + "/Servicios/getSelectServicios";
      let request = new XMLHttpRequest();
      request.open("GET", ajaxUrl, true);
      request.send();
      request.onreadystatechange = function () {
          if (request.readyState == 4 && request.status == 200) {
              let response = JSON.parse(request.responseText);
              addNewProductoRow(response);
          }
      };
  }

  function addNewProductoRow(response) {
      let newRow = document.createElement("tr");
      newRow.classList.add("detalle-venta-row");
      newRow.innerHTML = `
          <td style="text-align: center;">
              <span class="row-number"></span>
          </td>
          <td>
              <select class="form-control selectpicker servicio-select" name="selectServicio" id="listservicios" required data-live-search="true">
                  ${response[0]}
              </select>
          </td>
          <td>
              <input type="number" class="form-control cantidad" value="0.00" min="0">
          </td>
          <td>
              <input type="number" class="form-control precio" value="0.00" min="0">
          </td>
          <td>
              <input type="number" class="form-control descuento" value="0.00" min="0">
          </td>
          <td>
              <input type="number" class="form-control precio_total" value="0.00" min="0" readonly>
          </td>
          <td>
              <div class="col-auto">
                  <button type="button" class="btn btn-danger btn-remove-select btn-sm">X</button>
              </div>
          </td>
          <td>
              <input type="hidden" class="form-control precio_db" readonly>
          </td>
      `;
      tblDetalleVenta.insertBefore(newRow, tblDetalleVenta.lastElementChild); // Insertar antes de la última fila

      $(newRow).find('.selectpicker').selectpicker('render');

      addEventListenersToRow(newRow);

      newRow.querySelector(".btn-remove-select").addEventListener("click", function () {
          newRow.remove();
          updateRowNumbers();
          sumarPreciosTotales();
      });

      updateRowNumbers();
  }

  function addEventListenersToRow(row) {
      const selectElement = row.querySelector(".servicio-select");
      const cantidadInput = row.querySelector(".cantidad");
      const precioInput = row.querySelector(".precio");
      const descuentoInput = row.querySelector(".descuento");

      selectElement.addEventListener("change", function () {
          cal_precio_db(row);
          calculateRow(row);
          sumarPreciosTotales();
      });

      cantidadInput.addEventListener("input", function () {
          calculateRow(row);
          sumarPreciosTotales();
      });

      precioInput.addEventListener("input", function () {
          calculateRow(row);
          sumarPreciosTotales();
      });
      
      descuentoInput.addEventListener("input", function () {
            const precio = parseFloat(precioInput.value) || 0;
            let descuento = parseFloat(descuentoInput.value) || 0;

            if (descuento > precio) {
                descuento = precio;
                descuentoInput.value = descuento.toFixed(2);
                alert("El descuento no puede ser mayor que el precio.");
            }

          calculateRow(row);
          sumarPreciosTotales();
      });

      calculateRow(row);
  }

  function updateRowNumbers() {
      let rows = tblDetalleVenta.getElementsByClassName("detalle-venta-row");
      for (let i = 0; i < rows.length; i++) {
          let rowNumberElement = rows[i].querySelector(".row-number");
          rowNumberElement.innerText = i + 1;
      }
  }

  btnAgregarProducto.addEventListener("click", function () {
      loadInitialSelectOptions();
  });

  loadInitialSelectOptions(); // Cargar opciones iniciales al abrir el modal
});
// fin servicio 

// funciones publicas
function cal_precio_db(row) {
  var buttonElement = row.querySelector('.precio').value;
  row.querySelector(".precio_db").value = buttonElement;
}

// calcula el precio total por fila 
function calculateRow(row) {
  cal_precio_db(row);
  const cantidad = parseFloat(row.querySelector(".cantidad").value) || 0;
  const precio = parseFloat(row.querySelector(".precio").value) || 0;
  const descuento = parseFloat(row.querySelector(".descuento").value) || 0;
  const precioDb = parseFloat(row.querySelector(".precio_db").value) || 0;

cant_precio= cantidad*precio;
cant_descuento = cantidad * descuento;
total= cant_precio -cant_descuento;
  if((total)<0){
    row.querySelector(".precio_total").value = precioTotal.toFixed(2);

}else{
    row.querySelector(".precio_total").value = total.toFixed(2);
}
}

// calcula precios totales del sub total descuento total total 
function sumarPreciosTotales() {
  let subtotal = 0;
  let totalDescuento = 0;
  let subtotalreal = 0;
  let filas = tblDetalleVenta.getElementsByClassName("detalle-venta-row");

  for (let i = 0; i < filas.length; i++) {
      let fila = filas[i];
      // Obtener la cantidad y el precio base
      let cantidad = parseFloat(fila.querySelector(".cantidad").value) || 0;
      let precioDB = parseFloat(fila.querySelector(".precio_db").value) || 0;

      // Calcular el subtotal real del lote actual
      let subtotalLote = cantidad * precioDB;
      subtotalreal += subtotalLote;

      // Sumar precios totales
      let precioTotalElement = fila.querySelector(".precio_total");
      let precioTotal = 0;
      if (precioTotalElement) {
          precioTotal = parseFloat(precioTotalElement.value) || 0;
      }
      subtotal += precioTotal;

      // Sumar descuentos
      let descuentoElement = fila.querySelector(".descuento");
      let descuento = 0;
      if (descuentoElement) {
          descuento = parseFloat(descuentoElement.value) || 0;
      }
      totalDescuento += descuento;
  }

  // Actualizar el total
  document.getElementById("gran_sub_total").innerText = subtotalreal.toFixed(2);
  document.getElementById("gran_descuento").innerText = totalDescuento.toFixed(2);
  document.getElementById("gran_total").innerText = subtotal.toFixed(2);
}

// fin funciones publicas 


// ------editar venta-----------
// ------editar venta-----------

function fntEditInfo(element, idventa) {

  // Eliminar elementos del grupo de servicio pero debe dejar al menos uno
  let detalleVentaRows = document.querySelectorAll('.detalle-venta-row');
  for (let i = 0; i < detalleVentaRows.length; i++) {
      detalleVentaRows[i].remove();
  }
  
  rowTable = element.parentNode.parentNode.parentNode; 
  document.querySelector('.viewcodigoventa').classList.remove("d-none");
  document.querySelector('#titleModal').innerHTML = "Actualizar venta ";
  document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
  document.querySelector('#btnText').innerHTML = "Actualizar";
  let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  let ajaxUrl = base_url + '/Ventas/getVenta/'+idventa;
  request.open("GET", ajaxUrl, true);
  request.send();
  request.onreadystatechange = function () {
      if (request.readyState == 4 && request.status == 200) {
          let objData = JSON.parse(request.responseText);
          console.log(objData.data);

          if (objData.status) {
      
              document.querySelector("#idVenta").innerHTML = objData.data.venta.codigo_venta;

              document.querySelector("#listClienteid").value = objData.data.venta.dni_cliente;
              $('#listClienteid').selectpicker('refresh');
      
              document.querySelector("#listMetodoPagoid").value = objData.data.venta.idtipopago;
              $('#listMetodoPagoid').selectpicker('refresh');
      
              let cantidadDatos = objData.data.detalle_venta.length;
              // Hacer clic en el botón para agregar nuevos grupos
              for (let i = 0; i < cantidadDatos; i++) {
                  btnAgregarProducto.click();
              }
              $('#modalFormVenta').modal('show');
              // Ejecutar la asignación de datos después de un retraso
              setTimeout(function() {
                  asignarDatos(objData.data.detalle_venta);
              }, 2000); // Esperar 0.15 segundos 1 segundo = 1000 (ajustar si es necesario)
          }
      }
  }
}

function asignarDatos(detalleVenta) {
  let cantidadDatos = detalleVenta.length;
  // Asignar los datos a los grupos respectivos
  let grupos = document.querySelectorAll(".detalle-venta-row");

  for (let i = 0; i < cantidadDatos; i++) {
      let datosLote = detalleVenta[i];
      let grupoActual = grupos[i];
      if (grupoActual) {
          let servicioSelect = grupoActual.querySelector("#listservicios");
          if (servicioSelect) {
              servicioSelect.value = datosLote.idservicio;
              $(servicioSelect).selectpicker('refresh');
          }

          let cantidadInput = grupoActual.querySelector(".cantidad");
          if (cantidadInput) {
              cantidadInput.value = datosLote.cantidad;
          }

          let precioInput = grupoActual.querySelector(".precio");
          if (precioInput) {
              precioInput.value = datosLote.precio;
            }
          let descuentoInput = grupoActual.querySelector(".descuento");
          if (descuentoInput) {
            descuentoInput.value = datosLote.descuento;
            }

            // Llamar a las funciones necesarias para calcular y sumar precios
            cal_precio_db(grupoActual);
            calculateRow(grupoActual);
        }
    }
    // Sumar precios totales después de asignar todos los datos
    sumarPreciosTotales();
}
// ------fin editar venta-----------
// ------fin editar venta-----------



  function openModal() {
    rowTable = "";
    document.querySelector('#idVenta').innerHTML = "";
    document.querySelector('.viewcodigoventa').classList.add("d-none");
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML = "Guardar";
    document.querySelector("#formUpdateVenta").reset();

    // Eliminar elementos del grupo de servicio pero debe dejar al menos uno
    let detalleVentaRows = document.querySelectorAll('.detalle-venta-row');
    for (let i = 1; i < detalleVentaRows.length; i++) {
        detalleVentaRows[i].remove();
    }
    // Restablecer los select a su estado inicial
  $('.servicio-select').selectpicker('val', '');
  $('#listClienteid').selectpicker('val', '');
  $('#listMetodoPagoid').selectpicker('val', '');
  document.getElementById("gran_sub_total").innerText ="00.00";
  document.getElementById("gran_descuento").innerText ="00.00";
  document.getElementById("gran_total").innerText ="00.00";
  
    $('#modalFormVenta').modal('show');
  }



// funcion view venta 
// funcion view venta 
function fntViewVenta(idventa){
  let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  let ajaxUrl = base_url+'/Ventas/getVenta/'+idventa;
  request.open("GET",ajaxUrl,true);
  request.send();
  request.onreadystatechange = function(){
      if(request.readyState == 4 && request.status == 200){
          let objData = JSON.parse(request.responseText);
          if(objData.status)
          {

            // Suponiendo que objData.data.venta.fecha es una cadena de fecha en formato ISO 8601
            let fechaISO = objData.data.venta.fecha; // Ejemplo: "2025-06-14T13:13:04Z"
            let fechaFormateada = moment(fechaISO).format('YYYY/MM/DD | hh:mm:ss A');
            texto =""
            for (i=0;i<objData.data.detalle_venta.length ; i++){
              texto +="<i class='bi bi-circle'></i> "+ objData.data.detalle_venta[i].nombre + "<br>";
            }
              document.querySelector("#celIdentificacion").innerHTML = objData.data.venta.codigo_venta;
              document.querySelector("#celNombre").innerHTML = objData.data.venta.nombres;
              document.querySelector("#celApellido").innerHTML = objData.data.venta.tipopago;
              document.querySelector("#celTelefono").innerHTML = objData.data.venta.total;
              document.querySelector("#celEmail").innerHTML = texto
              document.querySelector("#celFechaRegistro").innerHTML = fechaFormateada;
              $('#modalViewVenta').modal('show');
          }else{
              swal("Error", objData.msg , "error");
          }
      }
  }
}

// funcion delet 
// funcion delet 
function fntDelEmpleado(idventa){
  swal({
      title: "Eliminar Venta",
      text: "¿Realmente quiere eliminar al Venta?",
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
          let ajaxUrl = base_url+'/Ventas/delVenta';
          // cuando es post es los name de los imput
          let strData = "idVenta="+idventa;
          request.open("POST",ajaxUrl,true);
          console.log(strData)
          request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
          request.send(strData);
          request.onreadystatechange = function(){
              if(request.readyState == 4 && request.status == 200){
                  let objData = JSON.parse(request.responseText);
                  if(objData.status)
                  {
                      swal("Eliminado", objData.msg , "success");
                      tableVentas.api().ajax.reload();
                  }else{
                      swal("Atención!", objData.msg , "error");
                  }
              }
          }
      }

  });

}
// ------------------------------------
// -------------fin se usan-----------------------
// ------------------------------------