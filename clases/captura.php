<?php
//clase captura.php
require '../config/config.php';

$db = new Database();
$con = $db->conectar();

$json = file_get_contents('php://input');
$datos = json_decode($json, true);


if (is_array($datos)) {

    $id_cliente = $_SESSION['user_cliente'];
    $sqlProd = $con->prepare("SELECT email FROM clientes WHERE id = ? AND estatus=1");
    $sqlProd->execute([$id_cliente]);
    $row_cliente = $sqlProd->fetch(PDO::FETCH_ASSOC);

    $status = $datos['detalles']['status'];
    $fecha = $datos['detalles']['update_time'];
    $fecha_nueva = date('Y-m-d H:i:s', strtotime($fecha));
    $email = $row_cliente['email'];

    $total = $datos['detalles']['purchase_units'][0]['amount']['value'];
    $id_transaccion = $datos['detalles']['id'];

    $comando = $con->prepare("INSERT INTO compra (id_transaccion, fecha, status, email, id_cliente, total, medio_pago) VALUES (?,?,?,?,?,?,?)");
    $comando->execute([$id_transaccion, $fecha_nueva, $status, $email, $id_cliente, $total, 'paypal']);
    $id = $con->lastInsertId();

    if ($id > 0) {
        $productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;

        if ($productos != null) {
            foreach ($productos as $clave => $cantidad) {

                $sqlProd = $con->prepare("SELECT id, nombre, precio, descuento FROM productos WHERE id = ? AND activo = 1");
                $sqlProd->execute([$clave]);
                $row_prod = $sqlProd->fetch(PDO::FETCH_ASSOC);

                $precio = $row_prod['precio'];
                $descuento = $row_prod['descuento'];
                $precio_desc = $precio - (($precio * $descuento) / 100);

                $sql = $con->prepare("INSERT INTO detalle_compre (id_compra, id_producto, nombre, precio, cantidad) VALUES (?,?,?,?,?)");
                if($sql->execute([$id, $row_prod['id'], $row_prod['nombre'], $precio_desc, $cantidad])){
                    restarStock($row_prod['id'], $cantidad, $con);
                }
            }
            $asunto =  "Detalles de su pedido";
            $cuerpo = '<h4>Gracias por su compra</h4>';
            $cuerpo .= '<p>El ID de su compra es <b>' . $id_transaccion . '</b></p>';

            require 'Mailer.php';
            $mailer = new Mailer();
            $mailer->enviarEmail($email, $asunto, $cuerpo);
        }

        unset($_SESSION['carrito']);
    }
}

function restarStock($id, $cantidad, $con)
{
    $sql = $con->prepare("UPDATE productos SET stock = stock - ? WHERE id = ?");
    $sql->execute([$cantidad, $id]);
}