// Seleccionar el elemento <p> con la clase 'nombre'
const nombreElement = document.querySelector('.nombre');

// Verificar si se encontró el elemento
if (nombreElement) {
    // Obtener el contenido actual del elemento
    let nombreActual = nombreElement.textContent.trim();

    // Agregar ' usuario' al final del contenido actual
    nombreActual += ' usuario';

    // Asignar el contenido modificado de vuelta al elemento
    nombreElement.textContent = nombreActual;
}
