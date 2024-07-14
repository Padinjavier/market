<a id="chat-icon" type="button" onclick="openModalChat();" class="d-flex justify-content-center align-items-center">
  <i id="icono" class="fas fa-comment fa-2x"></i>
</a>

<!-- chat panel  -->
<section id="chat-panel" class="h-75 p-2">
  <div class="w-100 h-100 p-2">
    <div class="input-group rounded mb-3">
      <input type="search" id="search-input" class="form-control rounded" placeholder="Search" aria-label="Search"
        aria-describedby="search-addon" />
      <span class="input-group-text border-0" id="search-addon">
        <i class="fas fa-search " id="search-icon"></i>
      </span>
    </div>
    <div data-mdb-perfect-scrollbar="true" id="lista-filtro" class="h-100" style="position: relative;">
      <ul id="boxchat" class="list-unstyled mb-0" style="max-height: 100%; height:390px; overflow-y: auto; ">
        <li class="p-2 border-bottom">
          <a id="" class="d-flex justify-content-between ">
            <div class="d-flex flex-row">
              <div>
                <img class="app-sidebar__user-avatar" src="Assets/images/avatar1.png" alt="User Image">
                <span class="badge bg-success badge-dot"></span>
              </div>
              <div class="pt-1">
                <p class="fw-bold mb-0 nombre">cargando...</p>
                <p class="small text-muted">....</p>
              </div>
            </div>
            <div class="pt-1">
              <p class="small text-muted mb-1">....</p>
              <span class="badge bg-danger rounded-pill float-end text-info">0</span>
            </div>
          </a>
        </li>
      </ul>
    </div>
  </div>
</section>


<!-- chat chat -->
<section id="chat" class="h-75">
  <div class="bg-primary p-3 text-white heder-chat">
    <i class="fas fa-angle-left" id="back-to-chat-panel" style="cursor: pointer;"></i>
    <p class="mb-0 fw-bold" id="namechat">Live chat</p>
    <i class="fas fa-times" id="close-chat" style="cursor: pointer;"></i>
  </div>
  <div class="card-body">
    <div class="conten-msg" id="msgbox">
      <div class="d-flex flex-row justify-content-start mb-4">
        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp" alt="avatar 1"
          style="width: 45px; height: 100%;">
        <div class="p-3 ms-3" style="border-radius: 15px; background-color: rgba(57, 192, 237,.2);">
          <p class="small mb-0">Hello and thank you for visiting MDBootstrap. Please click the
            video
            below.</p>
        </div>
      </div>
      <div class="d-flex flex-row justify-content-end mb-4">
        <div class="p-3 me-3 border" style="border-radius: 15px; background-color: #fbfbfb;">
          <p class="small mb-0">Thank you, I really like your product.</p>
        </div>
        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava2-bg.webp" alt="avatar 1"
          style="width: 45px; height: 100%;">
      </div>
    </div>
    <div class="input-group" style="align-items: flex-end !important">
      <textarea name="" id="textarea" class="form-control auto-expand" placeholder="Escribe un mensaje" rows="1"
        style="resize: none;"></textarea>
      <span class="input-group-text" id="basic-addon1" style="cursor: pointer;">
        <i class="bi bi-send fa-lg icon" ></i>
      </span>
    </div>
  </div>
</section>


<style>
  #chat-icon {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background-color: #007bff;
    color: #fff;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    text-align: center;
    cursor: pointer;
    z-index: 100;
  }

  #chat-panel {
    display: none;
    position: fixed;
    bottom: 0;
    right: 0;
    background-color: #fff;
    border: 1px solid #ddd;
    overflow-y: scroll;
    max-height: calc(100vh - 50px);
    z-index: 99;
    width: 100%;
    max-width: 600px;
    overflow: hidden;
    box-shadow: -3px -4px 20px 6px rgb(157 157 157);
    border-radius: 20px 0px 0px 0px;
  }

  #chat {
    display: none;
    position: fixed;
    bottom: 0;
    right: 0;
    background-color: #fff;
    border: 1px solid #ddd;
    z-index: 101;
    width: 100%;
    max-width: 600px;
    overflow: hidden;
    box-shadow: -3px -4px 20px 6px rgb(157 157 157);
    border-radius: 20px 0px 0px 0px;
  }

  .card-body {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 91%;
  }

  .heder-chat {
    height: 9%;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  div#msgbox {
    overflow: auto; /* Esto habilita el scroll */
    /* border: 1px solid #ccc; */
    padding: 10px;
}
/* Estilos para navegadores WebKit */
div#msgbox::-webkit-scrollbar {
    width: 8px; /* Ancho de la barra de desplazamiento vertical */
    height: 8px; /* Altura de la barra de desplazamiento horizontal */
}

div#msgbox::-webkit-scrollbar-thumb {
    background-color: #F37101; /* Color del pulgar de la barra de desplazamiento */
    border-radius: 10px; /* Radio de borde para redondear las esquinas */
}

div#msgbox::-webkit-scrollbar-track {
    background: #f1f1f1; /* Color del fondo de la barra de desplazamiento */
}
</style>
<script>
        // JavaScript para desplazar el contenido hacia el final
        window.onload = function() {
            var scrollDiv = document.getElementById('msgbox');
            scrollDiv.scrollTop = scrollDiv.scrollHeight;
        };
    </script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const textarea = document.querySelector('.auto-expand');

    textarea.addEventListener('input', function () {
      textarea.style.height = 'auto';

      const newHeight = Math.min(textarea.scrollHeight, 1.5 * 5 * 16) + 'px';
      textarea.style.height = newHeight;

      if (textarea.scrollHeight > parseInt(newHeight)) {
        textarea.style.overflowY = 'auto';
      } else {
        textarea.style.overflowY = 'hidden';
      }

      if (textarea.value.trim() === '') {
        textarea.style.height = 'auto';
      }
    });

    textarea.dispatchEvent(new Event('input'));
  });
</script>