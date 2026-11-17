<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cafeteria Escolar</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="css/estilos.css" rel="stylesheet">
</head>

<body>
    <!-- Barra de navegación -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a href="info.php" class="navbar-brand" style="font-weight: bold;">
                    <i class="fas fa-coffee"></i> Cafeteria Escolar
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarHeader">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a href="index.php" id="catalagos" class="nav-link active" style="padding: 10px 15px; font-size: 16px; color: white;">
                                <i class="fas fa-book-open"></i> Catálogo
                            </a>
                        </li>
                    </ul>

                    <form action="index.php" method="get" autocomplete="off">
                        <div class="input-group pe-3">
                            <input type="text" name="q" id="q" class="form-control form-control-sm" placeholder="Buscar..." aria-describedby="icon-buscar">
                            <button type="submit" id="icon-buscar" class="btn btn-outline-info">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>

                    <a href="checkout.php" id="btncarrito" class="btn btn-primary me-2" style="padding: 10px 15px; font-size: 16px; border-radius: 5px; margin-left: 10px; background-color: #007bff; border: none;">
                        <i class="fas fa-shopping-cart"></i> Carrito <span id="num_cart" class="badge bg-secondary" style="background-color: gray; border-radius: 50%; padding: 5px;"><?php echo $num_cart; ?></span>
                    </a>
                    <?php if (isset($_SESSION['user_id'])) { ?>
                        <div class="dropdown">
                            <button class="btn btn-success dropdown-toggle" type="button" id="btn_session" data-bs-toggle="dropdown" aria-expanded="false" style="padding: 10px 15px; font-size: 16px; border-radius: 5px; margin-left: 10px; background-color: #28a745; border: none;">
                                <i class="fas fa-user"></i> <?php echo $_SESSION['user_name']; ?>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="btn_session" style="min-width: 150px; text-align: center;">
                                <li><a class="dropdown-item" href="compras.php"><i class="fas fa-shopping-basket"></i> Mis compras</a></li>
                                <li><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a></li>
                            </ul>
                        </div>
                    <?php } else { ?>
                        <a href="login.php" class="btn btn-success" style="padding: 10px 15px; font-size: 16px; border-radius: 5px; margin-left: 10px; background-color: #28a745; border: none;">
                            <i class="fas fa-user"></i> Ingresar
                        </a>
                    <?php } ?>
                </div>
            </div>
        </nav>
    </header>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-B4gt1JRx4gtSQsUU1wXNihHYPmFHU04S3Zr2pCpzKXstPoN8cqetj83K6zH9k1cM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9KNxaR12FRc8DRC1NTR3K27mxOao6tMRMJClon0L4HsK/5th8RDZm8E" crossorigin="anonymous"></script>
</body>

</html>
