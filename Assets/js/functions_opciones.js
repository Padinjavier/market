let listOpciones;
let rowTable = ""; 
let divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded', function(){
    listOpciones = $('#listOpciones').dataTable( {
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/Opciones/getOpciones",
            "dataSrc":""
        },
        "columns":[
            {"data":"id"},
            {"data":"personaid"},
            {"data":"idioma"},
            {"data":"tema"},
            {"data":"formato_moneda"}
        ],
        "resonsieve":"true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order":[[0,"desc"]]  
    });

}, false);



document.addEventListener('DOMContentLoaded', function() {
    fntEditOpciones();
});

// Función para cargar las opciones guardadas en los selectores
function fntEditOpciones() {
    // Crear una solicitud AJAX para obtener las opciones guardadas
    let request = new XMLHttpRequest();
    let ajaxUrl = base_url + '/Opciones/getOpciones';
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
                  
            if (objData != null) {
                document.querySelector("#selectIdioma").value = objData[0].idioma;
                $('#selectIdioma').selectpicker('render');
                document.querySelector("#selectTema").value = objData[0].tema;
                $('#selectTema').selectpicker('render');
                document.querySelector("#selectMoneda").value = objData[0].formato_moneda;
                $('#selectMoneda').selectpicker('render');
                $('#modalFormUsuario').modal('show');
            } else {
                swal("Error", objData.msg, "error");
            }
            
        }
    };
}

function guardarOpciones() {
    // Obtener los valores de los selectores
    let idioma = document.getElementById("selectIdioma").value;
    let tema = document.getElementById("selectTema").value;
    let moneda = document.getElementById("selectMoneda").value;
    // Crear un objeto FormData con los datos del formulario
    let formData = new FormData();
    formData.append("selectIdioma", idioma);
    formData.append("selectTema", tema);
    formData.append("selectMoneda", moneda);

    // Crear y enviar la solicitud AJAX
    let request = new XMLHttpRequest();
    request.open("POST", base_url + "/Opciones/setOpciones", true);
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            let response = JSON.parse(request.responseText);
            if (response != null) {
                // Datos guardados correctamente
                // swal("Éxito", response.msg, "success");
                swal({
                    title: "",
                    text: response.msg,
                    type: "success",
                    confirmButtonText: "Aceptar",
                    closeOnConfirm: false,
                }, function(isConfirm) {
                    if (isConfirm) {
                        location.reload();
                    }
                });
            } else {
                // Error al guardar los datos
                swal("Error", response.msg, "error");
            }
        }
    };
    request.send(formData);
    // Devolver false para prevenir el comportamiento predeterminado del evento click
    return false;
}


