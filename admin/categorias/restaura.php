<?php
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

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $db = new Database();
    $con = $db->conectar();

    $id = $_GET['id'];

    // Actualiza el estado de la categoría a activo (1)
    $sql = "UPDATE categorias SET activo = 1 WHERE id = :id";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    header('Location: desactivados.php');
    exit();
} else {
    header('Location: desactivados.php');
    exit();
}
