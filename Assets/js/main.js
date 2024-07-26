(function () {
  "use strict";

  var treeviewMenu = $(".app-menu");

  // Sidebar functionality
  $('[data-toggle="sidebar"]').click(function (event) {
    event.preventDefault();
    $(".app").toggleClass("sidenav-toggled");
  });

  // Treeview menu functionality
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

  $("[data-toggle='treeview.'].is-expanded")
    .parent()
    .toggleClass("is-expanded");

  $("[data-toggle='tooltip']").tooltip();
})();

// Menu toggle function
function clocemenu() {
  $(".app").addClass("sidenav-toggled");
}

// URL pattern matching
var regex = /\/agencia\/pedidos\/orden\/\d*$/;

if (regex.test(window.location.href)) {
  console.log("gol");
} else {
  const elements = document.querySelectorAll(".app-content, .app-nav");

  elements.forEach((element) => {
    element.addEventListener("click", function () {
      clocemenu();
    });
  });
}

// DOM content loaded event handler
document.addEventListener('DOMContentLoaded', function () {
  // Add sidenav-toggled class on page load
  const appElement = document.querySelector('.app.sidebar-mini.pace-running');
  if (appElement && !appElement.classList.contains('sidenav-toggled')) {
    appElement.classList.add('sidenav-toggled');
  }

  // Current URL
  var currentUrl = window.location.href;

  // Menu item activation based on URL
  function activateMenuItem(urlPart, menuId) {
    if (currentUrl.includes(urlPart)) {
      var menuItem = document.getElementById(menuId);
      if (menuItem) {
        menuItem.classList.add('active');
      }
    }
  }

  activateMenuItem('/empleados', 'menu-empleados');
  activateMenuItem('/rolesempleados', 'menu-empleados');
  activateMenuItem('/clientes', 'menu-clientes');
  activateMenuItem('/usuarios', 'menu-usuario');
  activateMenuItem('/rolesusuarios', 'menu-usuario');
  activateMenuItem('/pedidos', 'menu-puntoventa');
  activateMenuItem('/productos', 'menu-puntoventa');
  activateMenuItem('/servicios', 'menu-puntoventa');
});