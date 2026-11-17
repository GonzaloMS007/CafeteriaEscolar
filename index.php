<?php
// clase index.php

require_once 'config/config.php';

$db = new Database();
$con = $db->conectar();

$idCategoria = $_GET['cat'] ?? '';
$orden = $_GET['orden'] ?? '';
$buscar = $_GET['q'] ?? '';

$filtro = '';

$orders = [
    'asc' => 'nombre ASC',
    'desc' => 'nombre DESC',
    'precio_alto' => 'precio DESC',
    'precio_bajo' => 'precio ASC',
];

$order = $orders[$orden] ?? '';

if (!empty($order)) {
    $order = " ORDER BY $order";
}


if ($buscar != '') {
    $filtro = "AND nombre LIKE '%$buscar%' || descripcion LIKE '%$buscar%'";
}

if (!empty($idCategoria)) {
    $comando = $con->prepare("SELECT id, nombre, precio, descuento, (precio - (precio * descuento / 100)) as precio_desc FROM productos WHERE activo=1 $filtro AND id_categoria = ? $order");
    $comando->execute([$idCategoria]);
} else {
    $comando = $con->prepare("SELECT id, nombre, precio, descuento, (precio - (precio * descuento / 100)) as precio_desc FROM productos WHERE activo=1 $filtro $order");
    $comando->execute();
}

$resultado = $comando->fetchAll(PDO::FETCH_ASSOC);


$sqlCategorias = $con->prepare("SELECT id, nombre FROM categorias WHERE activo=1");
$sqlCategorias->execute();
$categorias = $sqlCategorias->fetchAll(PDO::FETCH_ASSOC);
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

<body class="d-flex flex-column h-100">
    <!-- Barra de navegación -->
    <?php include 'menu.php'; ?>

    <!-- Contenido -->
    <main class="flex-shrink-0">
        <div class="container p-3">
            <div class="row">
                <div class="col-12 col-md-3 col-lg-3">
                    <div class="card shadow-sm">
                        <div class="card-header"><i class="fas fa-tags"></i> Categorías</div>
                        <div class="list-group">
                            <a href="index.php" class="list-group-item list-group-item-action"><i class="fas fa-shopping-bag"></i>
                                Todos los productos
                            </a>
                            <?php foreach ($categorias as $categoria) { ?>
                                <a href="index.php?cat=<?php echo $categoria['id']; ?>" class="list-group-item list-group-item-action <?php if ($idCategoria == $categoria['id']) echo 'actve'; ?>"><i class="fas fa-list"></i>
                                    <?php echo $categoria['nombre']; ?>
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-9 col-lg-9">
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 justify-content-end g-4">
                        <div class="col mb-2">
                            <form action="index.php" id="ordenForm" method="get">

                                <input type="hidden" name="cat" id="cat" value="<?php echo $idCategoria; ?>">

                                <select name="orden" id="orden" class="form-select form-select-sm" onchange="submitForm()">
                                    <option value="">Ordenar por</option>
                                    <option value="precio_alto" <?php echo ($orden === 'precio_alto') ? 'selected' : '' ?>>Precios mas altos</option>
                                    <option value="precio_bajo" <?php echo ($orden === 'precio_bajo') ? 'selected' : '' ?>>Precios mas bajos</option>
                                    <option value="asc" <?php echo ($orden === 'asc') ? 'selected' : '' ?>>Nombre A-Z</option>
                                    <option value="desc" <?php echo ($orden === 'desc') ? 'selected' : '' ?>>Nombre Z-A</option>
                                </select>
                            </form>
                        </div>
                    </div>

                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
                        <?php foreach ($resultado as $row) { ?>
                            <div class="col d-flex">
                                <div class="card shadow-sm h-100 w-100 d-flex flex-column">
                                    <?php
                                    $id = $row['id'];
                                    $imagen = "images/productos/" . $id . "/principal.jpg";

                                    if (!file_exists($imagen)) {
                                        $imagen = "images/no-photo.jpg";
                                    }

                                    ?>
                                    <div class="text-center p-3">
                                        <img src="<?php echo $imagen; ?>" class="img-fluid" style="max-height: 250px; object-fit: cover;">
                                    </div>

                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title"><?php echo $row['nombre']; ?></h5>
                                        <?php if ($row['descuento'] > 0) { ?>
                                            <p class="card-text"><del>$ <?php echo number_format($row['precio'], 2, '.', ','); ?></del></p>
                                            <p class="card-text">$ <?php echo number_format($row['precio_desc'], 2, '.', ','); ?></p>
                                        <?php } else { ?>
                                            <p class="card-text">$ <?php echo number_format($row['precio'], 2, '.', ','); ?></p>
                                        <?php } ?>
                                        <div class="mt-auto d-flex justify-content-between align-items-center">
                                            <a href="details.php?id=<?php echo $row['id']; ?>&token=<?php echo hash_hmac('sha1', $row['id'], KEY_TOKEN); ?>" class="btn button-size button-size-primary"> <i class="fas fa-info-circle"></i> Detalles</a>
                                            <button class="btn button-size button-size-green" type="button" onclick="addProducto(<?php echo $row['id']; ?>, '<?php echo hash_hmac('sha1', $row['id'], KEY_TOKEN); ?>')"><i class="fas fa-shopping-cart"></i> Agregar al carrito</button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </main>

    <!-- Opción 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script>
        function addProducto(id, token) {
            var url = 'clases/carrito.php'
            var formData = new FormData()
            formData.append('id', id);
            formData.append('token', token);

            fetch(url, {
                    method: 'POST',
                    body: formData,
                    mode: 'cors',
                }).then(response => response.json())
                .then(data => {
                    if (data.ok) {
                        let elemento = document.getElementById("num_cart")
                        elemento.innerHTML = data.numero;
                    } else {
                        alert('No hay en existencia de este producto')
                    }
                })
        }

        function submitForm() {
            document.getElementById('ordenForm').submit();
        }
    </script>
    <!--
           
        Proyecto sistema de ventas online
        2024
    -->
</body>

</html>