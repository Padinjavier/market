

  <a id="chat-icon" type="button" onclick="openModal();" class="d-flex justify-content-center align-items-center">
    <i id="icono" class="fas fa-comment fa-2x"></i>
  </a>




<!-- chat panel  -->
<section id="chat-panel" class="h-75 p-2" style="display: none; width: 100%; max-width:600px; overflow: hidden;">
  <div class="w-100 h-100 p-2">
    <div class="input-group rounded mb-3">
      <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search"
        aria-describedby="search-addon" />
      <span class="input-group-text border-0" id="search-addon">
        <i class="fas fa-search"></i>
      </span>
    </div>
    <div data-mdb-perfect-scrollbar="true" class="h-100" style="position: relative;">
      <ul id="boxchat" class="list-unstyled mb-0" style="max-height: 100%; height:390px; overflow-y: auto; ">
  
      </ul>
    </div>
  </div>
</section>


<!-- chat chat --> 
<section id="chat" class="" style=" display: none; width: 100%; max-width:600px;">
  <div class="container py-3">
  <div class="row">
      <div class="col-md-12">
        <div class="card" id="chat1" style="border-radius: 15px;">
          <div
            class="bg-primary card-header d-flex justify-content-between align-items-center p-3 text-white border-bottom-0"
            style="border-top-left-radius: 15px; border-top-right-radius: 15px;" >
            <i class="fas fa-angle-left" id="back-to-chat-panel"></i>
            <p class="mb-0 fw-bold">Live chat</p>
            <i class="fas fa-times" id="close-chat"></i>
          </div>
          <div class="card-body" style="max-height: -webkit-fill-available; overflow-y: auto;">
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
            <div class="d-flex flex-row justify-content-start mb-4">
              <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp" alt="avatar 1"
                style="width: 45px; height: 100%;">
              <div class="ms-3" style="border-radius: 15px;">
                <div class="bg-image">
                  <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/screenshot1.webp"
                    style="border-radius: 15px;" alt="video">
                  <a href="#!">
                    <div class="mask"></div>
                  </a>
                </div>
              </div>
            </div>
            <div class="d-flex flex-row justify-content-start mb-4">
              <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp" alt="avatar 1"
                style="width: 45px; height: 100%;">
              <div class="p-3 ms-3" style="border-radius: 15px; background-color: rgba(57, 192, 237,.2);">
                <p class="small mb-0 www" id="">...</p>
              </div>
            </div>
            <div class="form-outline">
              <textarea class="form-control" id="textAreaExample" rows="4"></textarea>
              <label class="form-label" for="textAreaExample">Type your message</label>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>



























<style>
  /* Estilo del icono de mensaje */
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

  /*chat */
  #chat-panel {
    display: none;
    position: fixed;
    bottom: 0;
    right: 0;
    background-color: #fff;
    border: 1px solid #ddd;
    overflow-y: scroll;
    /* width: 100%; */
    max-height: calc(100vh - 50px);
    z-index: 99;
    /* Altura máxima */
  }
  #chat{
    display: none;
    position: fixed;
    bottom: 0;
    right: 0;
    background-color: #fff;
    border: 1px solid #ddd;
    overflow-y: scroll;
    /* width: 100%; */
    max-height: calc(100vh - 50px);
    z-index: 101;
    /* Altura máxima */
  }
</style>

<script>

</script>