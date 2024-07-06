const lightTheme = {
  // Definiciones de estilo para el tema claro
  "--HEADERHOVER": "#F9A147",
  "--HEADER": "#F37101",
  "--blue": "#007bff",
  "--indigo": "#6610f2",
  "--purple": "#6f42c1",
  "--pink": "#e83e8c",
  "--red": "#dc3545",
  "--orange": "#fd7e14",
  "--yellow": "#ffc107",
  "--green": "#28a745",
  "--teal": "#20c997",
  "--cyan": "#17a2b8",
  "--white": "#FFF",
  "--gray": "#6c757d",
  "--gray-dark": "#343a40",
  "--primary": "var(--HEADER)",
  "--secondary": "#6c757d",
  "--success": "#28a745",
  "--info": "#17a2b8",
  "--warning": "#ffc107",
  "--danger": "#dc3545",
  "--light": "#f8f9fa",
  "--dark": "#343a40",
  "--breakpoint-xs": " 0",
  "--breakpoint-sm": " 576px",
  "--breakpoint-md": " 768px",
  "--breakpoint-lg": " 992px",
  "--breakpoint-xl": " 1200px",

  "--font-family-monospace":
    ' SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace',
};

const darkTheme = {
  // Definiciones de estilo para el tema oscuro
  "--HEADERHOVER": "#dc3545",
  "--HEADER": "#dc1345",
  "--blue": "#007bff",
  "--indigo": "#6610f2",
  "--purple": "#6f42c1",
  "--pink": "#e83e8c",
  "--red": "#dc3545",
  "--orange": "#fd7e14",
  "--yellow": "#ffc107",
  "--green": "#28a745",
  "--teal": "#20c997",
  "--cyan": "#17a2b8",
  "--white": "#FFF",
  "--gray": "#6c757d",
  "--gray-dark": "#343a40",
  "--primary": "var(--HEADER)",
  "--secondary": "#6c757d",
  "--success": "#28a745",
  "--info": "#17a2b8",
  "--warning": "#ffc107",
  "--danger": "#dc3545",
  "--light": "#f8f9fa",
  "--dark": "#343a40",
  "--breakpoint-xs": " 0",
  "--breakpoint-sm": " 576px",
  "--breakpoint-md": " 768px",
  "--breakpoint-lg": " 992px",
  "--breakpoint-xl": " 1200px",

  "--font-family-monospace":
    ' SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace',
};

const tardeTheme = {
  // Definiciones de estilo para el tema tarde
  "--HEADERHOVER": "#28a745",
  "--HEADER": "#28a745",
  "--blue": "#007bff",
  "--indigo": "#6610f2",
  "--purple": "#6f42c1",
  "--pink": "#e83e8c",
  "--red": "#dc3545",
  "--orange": "#fd7e14",
  "--yellow": "#ffc107",
  "--green": "#28a745",
  "--teal": "#20c997",
  "--cyan": "#17a2b8",
  "--white": "#FFF",
  "--gray": "#6c757d",
  "--gray-dark": "#343a40",
  "--primary": "var(--HEADER)",
  "--secondary": "#6c757d",
  "--success": "#28a745",
  "--info": "#17a2b8",
  "--warning": "#ffc107",
  "--danger": "#dc3545",
  "--light": "#f8f9fa",
  "--dark": "#343a40",
  "--breakpoint-xs": " 0",
  "--breakpoint-sm": " 576px",
  "--breakpoint-md": " 768px",
  "--breakpoint-lg": " 992px",
  "--breakpoint-xl": " 1200px",

  "--font-family-monospace":
    ' SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace',
};

const addTheme = (theme) => {
  const styles = document.documentElement.style;
  const customStyles = Object.keys(theme);
  for (const style of customStyles) {
    styles.setProperty(style, theme[style]);
  }
};

function Cambiodetema(selectedValue) {
  //   console.log("wwwwwwwwwwwwww" + selectedValue);
  if (selectedValue == 1) {
    addTheme(lightTheme);
  } else if (selectedValue == 2) {
    addTheme(darkTheme);
  } else {
    addTheme(tardeTheme);
  }
}

document.addEventListener(
  "DOMContentLoaded",
  function () {
    fntcamiothem();
    // addTheme(darkTheme);
  },
  false
);
function fntcamiothem() {
  // Crear una solicitud AJAX para obtener las opciones guardadas
  let request = new XMLHttpRequest();
  let ajaxUrl = base_url + "/Opciones/getOpciones";
  request.open("GET", ajaxUrl, true);
  request.send();
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      let objData = JSON.parse(request.responseText);

      if (objData != null) {
        let selectedValue = objData[0].tema;
        Cambiodetema(selectedValue);
      } else {
        swal("Error", objData.msg, "error");
      }
    }
  };
}
