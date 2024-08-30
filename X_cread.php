<?php
// Solicitar el nombre al usuario (en un entorno CLI o mediante un formulario web)
echo "Por favor, ingresa el nombre base: ";
$nombreOriginal = trim(fgets(STDIN)); // Para CLI (línea de comandos)

// Si estás usando un formulario web, puedes reemplazar la línea anterior con:
// $nombreOriginal = isset($_POST['nombre']) ? $_POST['nombre'] : '';

if (empty($nombreOriginal)) {
    echo "El nombre no puede estar vacío.";
    exit;
}

// Convertir el nombre a formatos específicos
$nombreMinuscula = strtolower($nombreOriginal); // todo en minúsculas
$nombreCapitalizado = ucfirst(strtolower($nombreOriginal)); // primera letra mayúscula, resto minúsculas

// 1. Crear archivo JS en Assets/js/functions_nombre.js (en minúsculas)
$rutaJs = __DIR__ . "/Assets/js/functions_" . $nombreMinuscula . ".js";
if (!file_exists($rutaJs)) {
    $contenidoJs = "function openModal()\n";
    $contenidoJs .= "{\n";
    $contenidoJs .= "    rowTable = \"\";\n";
    $contenidoJs .= "    document.querySelector('#modalViewMensaje').value =\"\";\n";
    $contenidoJs .= "    document.querySelector('.modal-header').classList.replace(\"headerUpdate\", \"headerRegister\");\n";
    $contenidoJs .= "    document.querySelector('#btnActionForm').classList.replace(\"btn-info\", \"btn-primary\");\n";
    $contenidoJs .= "    document.querySelector('#btnText').innerHTML =\"Guardar\";\n";
    $contenidoJs .= "    document.querySelector(\"#formEmpleado\").reset();\n";
    $contenidoJs .= "    \$('#modalFormEmpleado').modal('show');\n";
    $contenidoJs .= "}\n";

    $archivoJs = fopen($rutaJs, "w");
    if ($archivoJs) {
        fwrite($archivoJs, $contenidoJs);
        fclose($archivoJs);
        echo "Archivo JS '$rutaJs' creado exitosamente.\n";
    }
}

// 2. Crear archivo PHP en Controllers/Nombre.php (nombre con primera letra mayúscula)
$rutaController = __DIR__ . "/Controllers/" . $nombreCapitalizado . ".php";
if (!file_exists($rutaController)) {
    $contenidoController = "<?php\n\n";
    $contenidoController .= "class " . $nombreCapitalizado . " extends Controllers{\n";
    $contenidoController .= "\tpublic function __construct()\n\t{\n";
    $contenidoController .= "\t\tparent::__construct();\n";
    $contenidoController .= "\t\tsession_start();\n";
    $contenidoController .= "\t\tif(empty(\$_SESSION['login']))\n\t\t{\n";
    $contenidoController .= "\t\t\theader('Location: '.base_url().'/login');\n";
    $contenidoController .= "\t\t\tdie();\n";
    $contenidoController .= "\t\t}\n\t}\n\n";
    
    $contenidoController .= "\tpublic function " . $nombreCapitalizado . "()\n\t{\n";
    $contenidoController .= "\t\tif(empty(\$_SESSION['permisosMod']['r'])){\n";
    $contenidoController .= "\t\t\theader('Location:'.base_url().'/dashboard');\n";
    $contenidoController .= "\t\t}\n";
    $contenidoController .= "\t\t\$data['page_tag'] = \"" . $nombreCapitalizado . "\";\n";
    $contenidoController .= "\t\t\$data['page_title'] = \"" . strtoupper($nombreCapitalizado) . " <small>Tienda Virtual</small>\";\n";
    $contenidoController .= "\t\t\$data['page_name'] = \"" . $nombreMinuscula . "\";\n";
    $contenidoController .= "\t\t\$data['page_functions_js'] = \"functions_" . $nombreMinuscula . ".js\";\n";
    $contenidoController .= "\t\t\$this->views->getView(\$this,\"" . $nombreMinuscula . "\",\$data);\n";
    $contenidoController .= "\t}\n\n";
    $contenidoController .= "}\n";
    $contenidoController .= "?>";

    $archivoController = fopen($rutaController, "w");
    if ($archivoController) {
        fwrite($archivoController, $contenidoController);
        fclose($archivoController);
        echo "Archivo Controller '$rutaController' creado exitosamente.\n";
    }
}

// 3. Crear archivo PHP en Models/NombreModel.php (nombre con primera letra mayúscula + 'Model')
$rutaModel = __DIR__ . "/Models/" . $nombreCapitalizado . "Model.php";
if (!file_exists($rutaModel)) {
    $contenidoModel = "<?php\n";
    $contenidoModel .= "class " . $nombreCapitalizado . "Model extends Mysql\n";
    $contenidoModel .= "{\n";
    $contenidoModel .= "\tpublic function __construct()\n\t{\n";
    $contenidoModel .= "\t\tparent::__construct();\n";
    $contenidoModel .= "\t}\n";
    $contenidoModel .= "}\n";
    $contenidoModel .= "?>";

    $archivoModel = fopen($rutaModel, "w");
    if ($archivoModel) {
        fwrite($archivoModel, $contenidoModel);
        fclose($archivoModel);
        echo "Archivo Model '$rutaModel' creado exitosamente.\n";
    }
}

// 4. Crear carpeta en Views/Nombre y archivo PHP nombre.php (carpeta con primera letra mayúscula, archivo en minúsculas)
$rutaViewCarpeta = __DIR__ . "/Views/" . $nombreCapitalizado;
if (!file_exists($rutaViewCarpeta)) {
    mkdir($rutaViewCarpeta, 0755, true);
}

$rutaViewArchivo = $rutaViewCarpeta . "/" . $nombreMinuscula . ".php";
if (!file_exists($rutaViewArchivo)) {
    $contenidoView = "<?php \n";
    $contenidoView .= "headerAdmin(\$data); \n";
    $contenidoView .= "getModal('modalMensaje',\$data);\n";
    $contenidoView .= "?>\n";
    $contenidoView .= "<main class=\"app-content\">\n";
    $contenidoView .= "    <div class=\"app-title\">\n";
    $contenidoView .= "        <div>\n";
    $contenidoView .= "            <h1><i class=\"fas fa-user-tag\"></i> <?= \$data['page_title'] ?></h1>\n";
    $contenidoView .= "        </div>\n";
    $contenidoView .= "        <ul class=\"app-breadcrumb breadcrumb\">\n";
    $contenidoView .= "          <li class=\"breadcrumb-item\"><i class=\"fa fa-home fa-lg\"></i></li>\n";
    $contenidoView .= "          <li class=\"breadcrumb-item\"><a href=\"<?= base_url(); ?>/" . $nombreMinuscula . "\"><?= \$data['page_title'] ?></a></li>\n";
    $contenidoView .= "        </ul>\n";
    $contenidoView .= "    </div>\n";
    $contenidoView .= "    <div class=\"row\">\n";
    $contenidoView .= "        <div class=\"col-md-12\">\n";
    $contenidoView .= "          <div class=\"tile\">\n";
    $contenidoView .= "            <div class=\"tile-body\">\n";
    $contenidoView .= "              <div class=\"table-responsive\">\n";
    $contenidoView .= "                <table class=\"table table-hover table-bordered w-100\" id=\"table" . $nombreCapitalizado . "\">\n";
    $contenidoView .= "                  <thead>\n";
    $contenidoView .= "                    <tr>\n";
    $contenidoView .= "                      <th>ID</th>\n";
    $contenidoView .= "                      <th>Nombre</th>\n";
    $contenidoView .= "                      <th>Email</th>\n";
    $contenidoView .= "                      <th>Fecha</th>\n";
    $contenidoView .= "                      <th>Acciones</th>\n";
    $contenidoView .= "                    </tr>\n";
    $contenidoView .= "                  </thead>\n";
    $contenidoView .= "                  <tbody>\n";
    $contenidoView .= "                  </tbody>\n";
    $contenidoView .= "                </table>\n";
    $contenidoView .= "              </div>\n";
    $contenidoView .= "            </div>\n";
    $contenidoView .= "          </div>\n";
    $contenidoView .= "        </div>\n";
    $contenidoView .= "    </div>\n";
    $contenidoView .= "</main>\n";
    $contenidoView .= "<?php footerAdmin(\$data); ?>\n";
    
    $archivoView = fopen($rutaViewArchivo, "w");
    if ($archivoView) {
        fwrite($archivoView, $contenidoView);
        fclose($archivoView);
        echo "Archivo View '$rutaViewArchivo' creado exitosamente.\n";
    }
}

// 5. Crear archivo PHP en Views/Template/Modals/modalNombre.php (modal con primera letra mayúscula)
$rutaModal = __DIR__ . "/Views/Template/Modals/modal" . $nombreCapitalizado . ".php";
if (!file_exists($rutaModal)) {
    $contenidoModal = "<!-- Modal -->\n";
    $contenidoModal .= "<div class=\"modal fade\" id=\"modalViewMensaje\" tabindex=\"-1\" role=\"dialog\" aria-hidden=\"true\">\n";
    $contenidoModal .= "  <div class=\"modal-dialog modal-xl\">\n";
    $contenidoModal .= "    <div class=\"modal-content\">\n";
    $contenidoModal .= "      <div class=\"modal-header header-primary\">\n";
    $contenidoModal .= "        <h5 class=\"modal-title\" id=\"titleModal\">Datos del contacto</h5>\n";
    $contenidoModal .= "        <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">\n";
    $contenidoModal .= "          <span aria-hidden=\"true\">&times;</span>\n";
    $contenidoModal .= "        </button>\n";
    $contenidoModal .= "      </div>\n";
    $contenidoModal .= "      <div class=\"modal-body\">\n";
    $contenidoModal .= "        <table class=\"table table-bordered\">\n";
    $contenidoModal .= "          <tbody>\n";
    $contenidoModal .= "            <tr>\n";
    $contenidoModal .= "              <td>ID:</td>\n";
    $contenidoModal .= "              <td id=\"celCodigo\"></td>\n";
    $contenidoModal .= "            </tr>\n";
    $contenidoModal .= "            <tr>\n";
    $contenidoModal .= "              <td>Nombres:</td>\n";
    $contenidoModal .= "              <td id=\"celNombre\"></td>\n";
    $contenidoModal .= "            </tr>\n";
    $contenidoModal .= "            <tr>\n";
    $contenidoModal .= "              <td>Email:</td>\n";
    $contenidoModal .= "              <td id=\"celEmail\"></td>\n";
    $contenidoModal .= "            </tr>\n";
    $contenidoModal .= "            <tr>\n";
    $contenidoModal .= "              <td>Fecha:</td>\n";
    $contenidoModal .= "              <td id=\"celFecha\"></td>\n";
    $contenidoModal .= "            </tr>\n";
    $contenidoModal .= "            <tr>\n";
    $contenidoModal .= "              <td>Mensaje:</td>\n";
    $contenidoModal .= "              <td id=\"celMensaje\"></td>\n";
    $contenidoModal .= "            </tr>\n";
    $contenidoModal .= "          </tbody>\n";
    $contenidoModal .= "        </table>\n";
    $contenidoModal .= "      </div>\n";
    $contenidoModal .= "      <div class=\"modal-footer\">\n";
    $contenidoModal .= "        <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Cerrar</button>\n";
    $contenidoModal .= "      </div>\n";
    $contenidoModal .= "    </div>\n";
    $contenidoModal .= "  </div>\n";
    $contenidoModal .= "</div>\n";

    $archivoModal = fopen($rutaModal, "w");
    if ($archivoModal) {
        fwrite($archivoModal, $contenidoModal);
        fclose($archivoModal);
        echo "Archivo Modal '$rutaModal' creado exitosamente.\n";
    }
}

?>
