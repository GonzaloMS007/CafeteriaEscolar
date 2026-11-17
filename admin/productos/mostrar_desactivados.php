<?php

require_once '../../config/conexionBD.php';
require_once '../config/config.php';
require_once '../header.php';

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

// Obtener productos desactivados
$sql = $con->prepare("SELECT id, nombre FROM productos WHERE activo = 0");
$sql->execute();
$productos = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos Desactivados</title>
    <link href="../css/styles.css" rel="stylesheet" />
</head>

<body>
    <div class="container">
        <h1>Productos Desactivados</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $producto): ?>
                    <tr>
                        <td><?php echo $producto['id']; ?></td>
                        <td><?php echo $producto['nombre']; ?></td>
                        <td>
                            <form action="activar_producto.php" method="POST">
                                <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">
                                <button type="submit" class="btn btn-success">Activar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>
