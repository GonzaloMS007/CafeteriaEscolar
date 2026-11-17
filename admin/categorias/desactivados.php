<?php
ob_start();
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

$sql = "SELECT id, nombre FROM categorias WHERE activo = 0";
$resultado = $con->query($sql);
$categorias = $resultado->fetchAll(PDO::FETCH_ASSOC);
?>

<main>
    <div class="container-fluid px-4">
        <h2 class="mt-3">Categorías Eliminadas</h2>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Nombre</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categorias as $categoria) { ?>
                        <tr>
                            <td><?php echo $categoria['id']; ?></td>
                            <td><?php echo $categoria['nombre']; ?></td>
                            <td><a href="restaura.php?id=<?php echo $categoria['id']; ?>" class="btn btn-success btn-sm">Restaurar</a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php require '../footer.php'; ?>
