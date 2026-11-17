<?php
require '../../config/conexionBD.php';
require '../clases/cifrado.php'; // Incluir el archivo de cifrado

$db = new Database();
$con = $db->conectar();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombreTienda = isset($_POST['nombre']) ? $_POST['nombre'] : null;
    $telefono = isset($_POST['telefono']) ? $_POST['telefono'] : null;
    $moneda = isset($_POST['moneda']) ? $_POST['moneda'] : null;

    if ($nombreTienda && $telefono && $moneda) {
        try {
            $con->beginTransaction();
            $sql = $con->prepare("UPDATE configuracion SET valor = ? WHERE nombre = ?");
            $sql->execute([$nombreTienda, 'tienda_nombre']);
            $sql->execute([$telefono, 'tienda_telefono']);
            $sql->execute([$moneda, 'tienda_moneda']);
            $con->commit();
            $message = "Configuración de la tienda actualizada correctamente.";
        } catch (Exception $e) {
            $con->rollBack();
            $message = "Error al actualizar la configuración de la tienda: " . $e->getMessage();
        }
    } else {
        $message = "Por favor, complete todos los campos.";
    }
} else {
    $message = "Método de solicitud no permitido.";
}
?>

<main>
    <div class="container-fluid px-4">
        <h2 class="mt-4">Configuración de la tienda</h2>
        <?php if (isset($message)) : ?>
            <div class="alert alert-info"><?php echo $message; ?></div>
        <?php endif; ?>
        <a href="index.php" class="btn btn-secondary">Regresar</a>
    </div>
</main>

<?php include '../footer.php'; ?>
