<?php
//session_start();

$path = dirname(__FILE__) . DIRECTORY_SEPARATOR;

require_once $path.'conexionBD.php';
require_once $path.'../admin/clases/cifrado.php'; 

$db = new Database();
$con = $db->conectar();

$sql = "SELECT nombre, valor FROM configuracion";
$resultado = $con->query($sql);
$datosConfig = $resultado->fetchAll(PDO::FETCH_ASSOC);

$config = [];

foreach ($datosConfig as $datoConfig) {
    $config[$datoConfig['nombre']] = $datoConfig['valor'];
}

define("SITE_URL", "http://localhost/CafeteriaEscolar");


define("CLIENT_ID", $config["paypal_cliente"]);

define("CURRENCY", $config["paypal_moneda"]);

define("KEY_TOKEN", "APR.wqc-354*");

define("MONEDA", $config["tienda_moneda"]);

define("MAIL_HOST", $config['correo_smtp']);

define("MAIL_USER", $config['correo_email']);

define("MAIL_PASS", decifrar($config['correo_password']));

define("MAIL_PORT", $config['correo_puerto']);

unset($config);

session_name('ecomerce_sesion');
session_start();

$num_cart = 0;
if(isset($_SESSION['carrito']['productos'])){
    $num_cart = count($_SESSION['carrito']['productos']);
}

?>