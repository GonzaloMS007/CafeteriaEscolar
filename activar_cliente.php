<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cafeteria esclar</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="css/estilos.css" rel="stylesheet">
</head>

<body>
<!-- Barra de navegacion -->
<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a href="index.php" class="navbar-brand">
                <strong>Tienda online</strong>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarHeader">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a href="#" class="nav-link active">Catalago</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Contacto</a>
                    </li>
                </ul>

                <?php if (isset($_SESSION['user_id'])) { ?>

                    <div class="dropdown">
                        <button class="btn btn-success btn-sm dropdown-toggle" type="button" id="btn_session" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo $_SESSION['user_name']; ?>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="btn_session">
                        <li><a class="dropdown-item" href="compras.php">Mis compras</a></li>
                            <li><a class="dropdown-item" href="logout.php">Cerrar sesion</a></li>
                        </ul>
                    </div>
  
                <?php } else { ?>
                    <a href="login.php" class="btn btn-success">Ingresar</a>
                <?php } ?>
            </div>
        </div>
        </div>
    </nav>
</header>


    <!--Contenido-->
    <main>
        <div class="container">
        </div>
    </main>


    <!-- opcion 1: Bootstrap Budle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>


</body>

</html>

<?php

require_once 'config/config.php';
require_once 'config/conexionBD.php';
require_once 'clases/clienteFunciones.php';

$id = isset($_GET['id']) ? $_GET['id'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';

if ($id == '' || $token == '') {
    header("Location: index.php");
    exit;
}

$db = new Database();
$con = $db->conectar();

echo validaToken($id, $token, $con);


?>