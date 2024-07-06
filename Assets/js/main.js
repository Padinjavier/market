(function () {
  "use strict";

  var treeviewMenu = $(".app-menu");

  // Toggle Sidebar
  $('[data-toggle="sidebar"]').click(function (event) {
    event.preventDefault();
    $(".app").toggleClass("sidenav-toggled");
  });

  // Activate sidebar treeview toggle
  $("[data-toggle='treeview']").click(function (event) {
    event.preventDefault();
    if (!$(this).parent().hasClass("is-expanded")) {
      treeviewMenu
        .find("[data-toggle='treeview']")
        .parent()
        .removeClass("is-expanded");
    }
    $(this).parent().toggleClass("is-expanded");
  });

  // Set initial active toggle
  $("[data-toggle='treeview.'].is-expanded")
    .parent()
    .toggleClass("is-expanded");

  //Activate bootstrip tooltips
  $("[data-toggle='tooltip']").tooltip();
})();

//desactivar el menu cuando se dea click a nuevo
function clocemenu() {
  $(".app").addClass("sidenav-toggled");
}
// Expresión regular para verificar si la URL termina con "/agencia/pedidos/orden" seguido opcionalmente por un número
var regex = /\/agencia\/pedidos\/orden\/\d*$/;

// Verificar si la URL actual coincide con el patrón de la expresión regular
if (regex.test(window.location.href)) {
  // Ejecutar console.log("gol")
  console.log("gol");
} else {
  const elements = document.querySelectorAll(".app-content, .app-nav");

  elements.forEach((element) => {
    element.addEventListener("click", function () {
      clocemenu();
    });
  });
}


document.addEventListener('DOMContentLoaded', function () {
  // Obtener la URL actual
  var currentUrl = window.location.href;

  // Verificar si la URL contiene /empleados o /rolesempleados
  if (currentUrl.includes('/empleados') || currentUrl.includes('/rolesempleados')) {
      // Seleccionar el <li> con el id menu-empleados
      var menuItem = document.getElementById('menu-empleados');
      if (menuItem) {
          // Agregar la clase 'active'
          menuItem.classList.add('active');
      }
  }

  if (currentUrl.includes('/clientes')) {
      var menuItem = document.getElementById('menu-clientes');
      if (menuItem) {
          menuItem.classList.add('active');
      }
  }
  
  if (currentUrl.includes('/usuarios') || currentUrl.includes('/rolesusuarios')) {
      var menuItem = document.getElementById('menu-usuario');
      if (menuItem) {
          menuItem.classList.add('active');
      }
  }
  if (currentUrl.includes('/pedidos') || currentUrl.includes('/productos')|| currentUrl.includes('/servicios')) {
      // Seleccionar el <li> con el id menu-empleados
      var menuItem = document.getElementById('menu-puntoventa');
      if (menuItem) {
          // Agregar la clase 'active'
          menuItem.classList.add('active');
      }
  }
});