<?php
headerAdmin($data);
getModal('modalPerfil', $data);
?>
<main class="app-content">
    <div class="row user">
        <div class="col-md-12">
            <div class="profile">
                <div class="info"><img class="user-img" src="<?= media(); ?>/images/avatar.png">
                    <h4>
                        <?= $_SESSION['userData']['nombres'] . ' ' . $_SESSION['userData']['apellidos']; ?>
                    </h4>
                    <p>
                        <?= $_SESSION['userData']['nombrerolusuario']; ?>
                    </p>
                </div>
                <div class="cover-image"></div>
            </div>
            <div id="formDataOpciones" name="formDataOpciones">
                <div class="container mt-5">
                    <h1>Panel de opciones</h1>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <h3>Preferencias de visualización</h3>
                            <ul class="list-group">
                                <li class="list-group-item">Idioma:
                                    <select class="form-control selectpicker" id="selectIdioma" name="listStatus"
                                        required="">
                                        <option value="1">Español</option>
                                        <option value="2">Inglés</option>
                                        <option value="3">Francés</option>
                                    </select>
                                </li>
                                <li class="list-group-item">TEMA:
                                    <select class="form-control selectpicker" id="selectTema" name="listStatus"
                                        required="">

                                        <option value="1">DIA</option>
                                        <option value="2">NOCHE</option>
                                        <option value="3">TARDE XD</option>
                                    </select>
                                </li>
                                <li class="list-group-item">Formato de moneda:
                                    <select class="form-control selectpicker" id="selectMoneda" name="listStatus"
                                        required="">

                                        <option value="1">USD</option>
                                        <option value="2">PEN</option>
                                    </select>
                                </li>
                                <!-- <button class="btn btn-primary" onClick="fntEditOpciones(<?= $_SESSION['userData']['idpersona'];?>)" > -->
                                <button class="btn btn-primary" onClick="guardarOpciones()" >
                                    <i class="fa fa-fw fa-lg fa-check-circle"></i> Guardar
                                </button>
                                <!-- <?= $_SESSION['userData']['idpersona'];?> -->
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h3>Otras configuraciones</h3>
                            <ul class="list-group">
                                <li class="list-group-item">Preferencias de envío: <a href="#">Configurar</a></li>
                                <!-- Resto de las opciones -->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>


        </div>
</main>
<?php footerAdmin($data); ?>