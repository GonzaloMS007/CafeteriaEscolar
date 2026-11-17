<?php

//ob_start();
//session_start();

require_once '../../config/conexionBD.php';
require_once '../config/config.php';


if (!isset($_SESSION['user_type'])) {
    header('Location: ../index.php');
    exit();
}
if ($_SESSION['user_type'] != 'admin') {
    header('Location: ../../index.php');
    exit();
}

$db = new Database();
$con = $db->conectar();

$id = $_POST['id'];

// Actualizar el estado del producto
$sql = $con->prepare("UPDATE productos SET activo = 1 WHERE id = ?");
$sql->execute([$id]);

header('Location: mostrar_desactivados.php');
?>
