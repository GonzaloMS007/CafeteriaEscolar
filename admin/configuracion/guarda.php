<?php
require '../../config/conexionBD.php';
require '../config/config.php';
require '../header.php';
require '../clases/cifrado.php'; // Incluir el archivo de cifrado

$db = new Database();
$con = $db->conectar();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $smtp = isset($_POST['smtp']) ? $_POST['smtp'] : null;
    $puerto = isset($_POST['puerto']) ? $_POST['puerto'] : null;
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $password = isset($_POST['password']) ? $_POST['password'] : null;

    if ($smtp && $puerto && $email && $password) {
        $passwordCifrada = cifrar($password); // Cifrar la contraseña

        try {
            $con->beginTransaction();
            $sql = $con->prepare("UPDATE configuracion SET valor = ? WHERE nombre = ?");
            $sql->execute([$smtp, 'correo_smtp']);
            $sql->execute([$puerto, 'correo_puerto']);
            $sql->execute([$email, 'correo_email']);
            $sql->execute([$passwordCifrada, 'correo_password']);
            $con->commit();
            $message = "Configuración actualizada correctamente.";
        } catch (Exception $e) {
            $con->rollBack();
            $message = "Error al actualizar la configuración: " . $e->getMessage();
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
        <h2 class="mt-4">Configuración</h2>
        <?php if (isset($message)) : ?>
            <div class="alert alert-info"><?php echo $message; ?></div>
        <?php endif; ?>
        <a href="index.php" class="btn btn-secondary">Regresar</a>
    </div>
</main>

<?php include '../footer.php'; ?>

