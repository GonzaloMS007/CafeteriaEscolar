<?php

include '../config/conexionBD.php';
include 'config/config.php';

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'admin') {
    header('Location: index.php');
    exit();
}
$db = new Database();
$con = $db->conectar();

$hoy = date('Y-m-d');
$lunes = date('Y-m-d', strtotime('monday this week', strtotime($hoy)));
$domingo = date('Y-m-d', strtotime('sunday this week', strtotime($hoy)));
$fechaInicial = new DateTime($lunes);
$fechaFinal = new DateTime($domingo);

$diasVentas = [];

for ($i = $fechaInicial; $i <= $fechaFinal; $i->modify('+1 day')) {
    $diasVentas[] = totalDia($con, $i->format('Y-m-d'));
    //$diasVentas[] = $monto;
}
//print_r($diasVentas);
$diasVentas = implode(',', $diasVentas);



//----------------------------------------------------------------------------------------


$listaProductos = produtosMasVendidos($con, $lunes, $domingo);
$nombreProductos = [];
$cantidadProductos = [];

foreach ($listaProductos as $producto) {
    $nombreProductos[] = $producto['nombre'];
    $cantidadProductos[] = $producto['cantidad'];
}
$nombreProductos = implode("','", $nombreProductos);
$cantidadProductos = implode(',', $cantidadProductos);


function totalDia($con, $fecha)
{
    $sql = "SELECT IFNULL(SUM(total), 0) AS total FROM compra
    WHERE DATE(fecha) = '$fecha' AND status LIKE 'COMPLETED'";
    $resultado = $con->query($sql);
    $row = $resultado->fetch(PDO::FETCH_ASSOC);

    return $row['total'];
}

function produtosMasVendidos($con, $fechaInicial, $fechaFinal)
{
    $sql = "SELECT SUM(dc.cantidad) AS cantidad, dc.nombre FROM detalle_compre AS dc
    INNER JOIN compra AS c ON dc.id_compra = c.id
    WHERE DATE(c.fecha) BETWEEN '$fechaInicial' AND '$fechaFinal'
    GROUP BY dc.id_producto, dc.nombre
    ORDER BY SUM(dc.cantidad) DESC
    LIMIT 5";
    $resultado = $con->query($sql);
    return $resultado->fetchAll(PDO::FETCH_ASSOC);
}

include 'header.php';
?>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Gráficas</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Información sobre las ventas</li>
        </ol>

        <div class="row">
            <div class="col-6">
                <div class="card mb-4" style="height: 450px;">
                    <div class="card-header">
                        Ventas de la semana
                    </div>
                    <div class="card-body" style="height: calc(100% - 56px); margin-top: 20px;">
                        <canvas id="myChart" width="300" height="300"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card mb-4" style="height: 450px;">
                    <div class="card-header">
                        Productos más vendidos de la semana
                    </div>
                    <div class="card-body" style="height: calc(100% - 56px); margin-top: 20px;">
                        <canvas id="chart-productos" width="300" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


<script>
const ctx = document.getElementById('myChart');

// Ajusta el tamaño del lienzo de la gráfica
ctx.style.width = '200px'; // Ajusta el ancho según lo necesites
ctx.style.height = '150px'; // Ajusta la altura según lo necesites

let chart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'],
        datasets: [{
            data: [<?php echo $diasVentas; ?>],
            backgroundColor: [
                'rgb(255, 99, 132)', // Rojo
                'rgb(54, 162, 235)', // Azul
                'rgb(255, 206, 86)', // Amarillo
                'rgb(75, 192, 192)', // Verde
                'rgb(153, 102, 255)', // Púrpura
                'rgb(255, 159, 64)', // Naranja
                'rgb(201, 203, 207)' // Gris
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        },
        plugins: {
            legend: {
                display: false
            },
            datalabels: {
                color: 'black',
                formatter: (value) => {
                    return value; // Muestra la cantidad dentro de la gráfica
                }
            }
        }
    },
    plugins: [ChartDataLabels]
});
</script>


<script>
    const cxProductos = document.getElementById('chart-productos');

    let chartProd = new Chart(cxProductos, {
        type: 'pie',
        data: {
            labels: ['<?php echo $nombreProductos; ?>'],
            datasets: [{
                data: [<?php echo $cantidadProductos; ?>],
                borderWidth: 1
            }]
        },
        options: {
            plugins: {
                datalabels: {
                    color: '#000', // Color del texto de las etiquetas
                    formatter: (value, context) => {
                        return value;
                    }
                }
            }
        },
        plugins: [ChartDataLabels]
    });
</script>

<?php include 'footer.php'; ?>