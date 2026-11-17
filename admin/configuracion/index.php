<?php
ob_start();

//session_start();
require_once '../../config/conexionBD.php';
require_once '../config/config.php';
require_once '../header.php';
require_once '../clases/cifrado.php';


if(!isset($_SESSION['user_type'])){
    header('Location: ../index.php');
    exit();
}
if($_SESSION['user_type'] != 'admin') {
    header('Location: ../../index.php');
    exit();
}

$db = new Database();
$con = $db->conectar();

$sql = "SELECT nombre, valor FROM configuracion";
$resultado = $con->query($sql);
$datos = $resultado->fetchAll(PDO::FETCH_ASSOC);

$config = [];

foreach ($datos as $dato) {
    $config[$dato['nombre']] = $dato['valor'];
}


?>

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Configuración</h1>

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="general-tab" data-bs-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="true">General</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="correo-tab" data-bs-toggle="tab" href="#correo" role="tab" aria-controls="correo" aria-selected="false">Correo Electrónico</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="paypal-tab" data-bs-toggle="tab" href="#paypal" role="tab" aria-controls="paypal" aria-selected="false">PayPal</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                <!-- Contenido de la pestaña General -->
                <form action="guardaInformacionTienda.php" method="post">
                    <div class="row mt-4">
                        <div class="col-6">
                            <label for="nombre">Nombre de la tienda</label>
                            <input class="form-control" type="text" name="nombre" id="nombre" value="<?php echo isset($config['tienda_nombre']) ? $config['tienda_nombre'] : ''; ?>">
                        </div>
                        <div class="col-6">
                            <label for="telefono">Teléfono</label>
                            <input class="form-control" type="text" name="telefono" id="telefono" value="<?php echo isset($config['tienda_telefono']) ? $config['tienda_telefono'] : ''; ?>">
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-6">
                            <label for="moneda">Moneda</label>
                            <input class="form-control" type="text" name="moneda" id="moneda" value="<?php echo isset($config['tienda_moneda']) ? $config['tienda_moneda'] : ''; ?>">
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="tab-pane fade" id="correo" role="tabpanel" aria-labelledby="correo-tab">
                <!-- Contenido de la pestaña Correo Electrónico -->
                <form action="guardaCorreo.php" method="post">
                    <div class="row mt-4">
                        <div class="col-6">
                            <label for="smtp">SMTP</label>
                            <input class="form-control" type="text" name="smtp" id="smtp" value="<?php echo isset($config['correo_smtp']) ? $config['correo_smtp'] : ''; ?>">
                        </div>

                        <div class="col-6">
                            <label for="puerto">Puerto</label>
                            <input class="form-control" type="text" name="puerto" id="puerto" value="<?php echo isset($config['correo_puerto']) ? $config['correo_puerto'] : ''; ?>">
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-6">
                            <label for="email">Correo</label>
                            <input class="form-control" type="email" name="email" id="email" value="<?php echo isset($config['correo_email']) ? $config['correo_email'] : ''; ?>">
                        </div>

                        <div class="col-6">
                            <label for="password">Contraseña</label>
                            <input class="form-control" type="password" name="password" id="password" value="<?php echo isset($config['correo_password']) ? $config['correo_password'] : ''; ?>">
                        </div>
                
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="tab-pane fade" id="paypal" role="tabpanel" aria-labelledby="paypal-tab">
                <!-- Contenido de la pestaña PayPal -->
                <form action="guardaPaypal.php" method="post">
                    <div class="row mt-4">
                        <div class="col-12">
                            <label for="paypal_cliente">Client ID</label>
                            <input class="form-control" type="text" name="paypal_cliente" id="paypal_cliente" value="<?php echo isset($config['paypal_cliente']) ? $config['paypal_cliente'] : ''; ?>">
                        </div>

                        <div class="col-12 mt-4">
                            <label for="paypal_moneda">Moneda</label>
                            <input class="form-control" type="text" name="paypal_moneda" id="paypal_moneda" value="<?php echo isset($config['paypal_moneda']) ? $config['paypal_moneda'] : ''; ?>">
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
<?php require '../footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"></script>
