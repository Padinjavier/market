<?php
$ip = $_SERVER['SERVER_ADDR'];
$link = 'http://' . $ip . '/market';
define('BASE_URL', $link);
// const BASE_URL = 'http://localhost/gsm';
//Zona horaria
date_default_timezone_set('America/Lima');
//Datos de conexión a Base de Datos
const DB_HOST = "localhost";
const DB_NAME = "agencia";
const DB_USER = "root";
const DB_PASSWORD = "javier20";
const DB_CHARSET = "utf8";

//Para envío de correo
const ENVIRONMENT = 1; // Local: 0, Produccón: 1;

//Deliminadores decimal y millar Ej. 24,1989.00
const MONEDA_DECIMALES =1;
const SPD = ".";
const SPM = ",";

//Simbolo de moneda
const SMONEY = "S/";
const CURRENCY = "PEN";

//Api PayPal
//SANDBOX PAYPAL
const URLPAYPAL = "https://api-m.sandbox.paypal.com";
const IDCLIENTE = "";
const SECRET = "";
//LIVE PAYPAL
//const URLPAYPAL = "https://api-m.paypal.com";
//const IDCLIENTE = "";
//const SECRET = "";

//Datos envio de correo
const NOMBRE_REMITENTE = "Vive tu aventura";
const EMAIL_REMITENTE = "marketch@marketchamorro.shop"; //correo del host siempre caambia si cambias de host
const NOMBRE_EMPESA = "Vive tu aventura";
const WEB_EMPRESA = "www.marketchamorro.shop"; //url de la pagina

const DESCRIPCION = "Un negocio familiar que ofrece variedad de productos, calidad y a buen precio.";
const SHAREDHASH = "TiendaVirtual";

//Datos Empresa
const DIRECCION = "Av. Arequipa 600, Quilmaná 15712";
const TELEMPRESA = "+(51)928378072";
const WHATSAPP = "954149814";
const EMAIL_EMPRESA = "chamorrochavezjorge@gmail.com";
const EMAIL_PEDIDOS = "chamorrochavezjorge@gmail.com";
const EMAIL_SUSCRIPCION = "chamorrochavezjorge@gmail.com";
const EMAIL_CONTACTO = "chamorrochavezjorge@gmail.com";

const CAT_SLIDER = "1,2,3";
const CAT_BANNER = "4,5,6";
const CAT_FOOTER = "1,2,3,4,5";

//Datos para Encriptar / Desencriptar
const KEY = 'tecomsis';
const METHODENCRIPT = "AES-128-ECB";

//Envío
const COSTOENVIO = 5;

//Módulos
// const MDASHBOARD = 1;
// const MEMPLEADOS = 2;
// const MCLIENTES = 3;
// const MPRODUCTOS = 4;
// const MPEDIDOS = 5;
// const MSERVICIOS = 6;
// const MSUSCRIPTORES = 7;
// const MDCONTACTOS = 8;
// const MDPAGINAS = 9;
// const MDOPCIONES = 10;
// const MUSUARIOS = 11;
const MDASHBOARD = 1;
const MEMPLEADOS = 2;
const MROLEMPLEADOS = 3;
const MCLIENTES = 4;
const MUSUARIOS = 5;
const MROLUSUARIOS = 6;
const MVENTAS = 7;
const MSALIDAS = 8;
const MSERVICIOS = 9;
const MDOPCIONES = 10;
const MDPAGINAS = 11;
const MDCONTACTOS = 12;
const MDSUSCRIPCIONES = 13;

//Páginas
const PINICIO = 1;
const PTIENDA = 2;
const PCARRITO = 3;
const PNOSOTROS = 4;
const PCONTACTO = 5;
const PPREGUNTAS = 6;
const PTERMINOS = 7;
const PSUCURSALES = 8;
const PERROR = 9;

//Roles
const RADMINISTRADOR = 1;
const RSUPERVISOR = 2;
const RCLIENTES = 3;

const STATUS = array('Completo', 'Aprobado', 'Cancelado', 'Reembolsado', 'Pendiente', 'Entregado');

//Productos por página cantidad
const CANTPORDHOME = 10;
const PROPORPAGINA = 20;
const PROCATEGORIA = 20;
const PROBUSCAR = 20;

//REDES SOCIALES
const FACEBOOK = "https://www.facebook.com/profile.php?id=100063589661454&locale=es_LA";
const INSTAGRAM = "https://www.facebook.com/profile.php?id=100063589661454&locale=es_LA";


?>