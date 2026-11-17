<?php
//ob_start();

// Start session
//session_start();

// Include database and configuration files
require_once '../../config/conexionBD.php';
require_once '../config/config.php';
require_once '../header.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_type'])) {
    header('Location: ../index.php');
    exit();
}
if ($_SESSION['user_type'] != 'admin') {
    header('Location: ../../index.php');
    exit();
}

// Connect to the database
$db = new Database();
$con = $db->conectar();

// Retrieve form data
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];
$descuento = $_POST['descuento'];
$stock = $_POST['stock'];
$id_categoria = $_POST['categoria'];

// Insert product into database
$sql = "INSERT INTO productos (nombre, descripcion, precio, descuento, stock, id_categoria, activo) VALUES (?, ?, ?, ?, ?, ?, 1)";
$stm = $con->prepare($sql);

if ($stm->execute([$nombre, $descripcion, $precio, $descuento, $stock, $id_categoria])) {
    $id = $con->lastInsertId();

    // subir imagen principal
    if ($_FILES['imagen_principal']['error'] == UPLOAD_ERR_OK) {
        $dir = '../../images/productos/' . $id . '/';
        $permitidos = ['jpeg', 'jpg', 'png'];

        $arregloImagen = explode('.', $_FILES['imagen_principal']['name']);
        $extension = strtolower(end($arregloImagen));

        if (in_array($extension, $permitidos)) {
            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }

            $ruta_img = $dir . 'principal.' . $extension;
            if (move_uploaded_file($_FILES['imagen_principal']['tmp_name'], $ruta_img)) {
                echo "El archivo se cargó correctamente.<br>";
            } else {
                echo "Error al cargar el archivo.";
            }
        } else {
            echo "Archivo no permitido.";
        }
    } else {
        echo "No se subió el archivo.";
    }

    if (isset($_FILES['otras_imagenes'])) {
        $dir = '../../images/productos/' . $id . '/';
        $permitidos = ['jpeg', 'jpg'];

        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
        $contador = 1;
        foreach ($_FILES['otras_imagenes']['tmp_name'] as $key => $tmp_name) {
            $FileName = $_FILES['otras_imagenes']['name'][$key];

            $arregloImagen = explode('.', $FileName);
            $extension = strtolower(end($arregloImagen));

            if (in_array($extension, $permitidos)) {
                $ruta_img = $dir . $contador . '.' . $extension;
                if (move_uploaded_file($tmp_name, $ruta_img)) {
                    echo "El archivo se cargó correctamente.<br>";
                    $contador++;
                } else {
                    echo "Error al cargar el archivo.";
                }
            } else {
                echo "Archivo no permitido.";
            }
        }
    }
}


// Redirecionar
//header('Location: index.php');
//exit();
