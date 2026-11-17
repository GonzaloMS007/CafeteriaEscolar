<?php
require '../../config/conexionBD.php';

$db = new Database();
$con = $db->conectar();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $clientID = isset($_POST['paypal_cliente']) ? $_POST['paypal_cliente'] : null;
    $moneda = isset($_POST['paypal_moneda']) ? $_POST['paypal_moneda'] : null;

    if ($clientID && $moneda) {
        try {
            $con->beginTransaction();
            $sql = $con->prepare("UPDATE configuracion SET valor = ? WHERE nombre = ?");
            $sql->execute([$clientID, 'paypal_cliente']);
            $sql->execute([$moneda, 'paypal_moneda']);
            $con->commit();
            $message = "Configuración de PayPal actualizada correctamente.";
        } catch (Exception $e) {
            $con->rollBack();
            $message = "Error al actualizar la configuración de PayPal: " . $e->getMessage();
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
        <h2 class="mt-4">Configuración de PayPal</h2>
        <?php if (isset($message)) : ?>
            <div class="alert alert-info"><?php echo $message; ?></div>
        <?php endif; ?>
        <a href="
