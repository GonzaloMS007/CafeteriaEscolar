<?php

//use Composer\Util\Url;
//clase index.php

require_once 'config/config.php';
require_once 'config/conexionBD.php';
require_once 'clases/clienteFunciones.php';

$db = new Database();
$con = $db->conectar();

$proceso = isset($_GET['pago']) ? 'pago' : 'login';

$errors = [];

if (!empty($_POST)) {


    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['password']);
    $proceso = $_POST['proceso'] ?? 'login';

    if (esNulo([$usuario, $password])) {
        $errors[] = "Debe llenar todos los campos";
    }
    
    if (count($errors) == 0) {
        $errors[] = login($usuario, $password, $con, $proceso);
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cafeteria esclar</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <link href="css/estilos.css" rel="stylesheet">
</head>

<body>
    <!-- Barra de navegacion -->
    <?php include 'menu.php'; ?>

    <!--Contenido-->
    <main class="form-login m-auto pt-4" style="max-width: 350px;">
        <h2>Iniciar sesion</h2>

        <?php mostrarMensajes($errors); ?>

        <form class="row g-3" action="login.php" method="post" autocomplete="off">

        <input type="hidden" name="proceso" value="<?php echo $proceso; ?>">

            <div class="form-floating">
                <input class="form-control" type="text" name="usuario" id="usuario" placeholder="Usuario" required>
                <label for="usuario">Usuario</label>
            </div>

            <div class="form-floating">
                <input class="form-control" type="password" name="password" id="password" placeholder="Contraseña" required>
                <label for="password">Contraseña</label>
            </div>

            <div class="col-12">
                <a href="recupera.php">¿Olidaste tu contraseña?</a>
            </div>
            <div class="d-grid gap-3 col-12">
                <button type="submit" class="btn btn-primary" id="ingresar_sistem">Ingresar</button>
            </div>
            <hr>
            <div class="col-12">
                ¿No tiene cuenta? <a href="registro.php">Registrate aqui</a>
            </div>
        </form>
    </main>


    <!-- opcion 1: Bootstrap Budle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!--
           
        Proyecto sistema de ventas online
        2024
    -->


</body>

</html>