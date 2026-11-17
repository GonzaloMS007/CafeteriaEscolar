<?php

//clase index.php
require_once 'config/config.php';
require_once 'config/conexionBD.php';
require_once 'clases/clienteFunciones.php';

$db = new Database();
$con = $db->conectar();

$errors = [];

if (!empty($_POST)) {

    $nombres = trim($_POST['nombres']);
    $apellidos = trim($_POST['apellidos']);
    $email = trim($_POST['email']);
    $telefono = trim($_POST['telefono']);
    $dni = trim($_POST['dni']);
    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['password']);
    $repassword = trim($_POST['repassword']);

    if (esNulo([$nombres, $apellidos, $email, $telefono, $dni, $usuario, $password, $repassword])) {
        $errors[] = "Debe llenar todos los campos";
    }

    if (!esEmail($email)) {
        $errors[] = "La direccion de correo no es valida";
    }

    if (!validarPassword($password, $repassword)) {
        $errors[] = "Las contraseñas no coinciden";
    }

    if (usuarioExiste($usuario, $con)) {
        $errors[] = "El nombre de usuario $usuario ya existe";
    }

    if (emailExiste($email, $con)) {
        $errors[] = "El correo electronico $email ya existe";
    }

    if (count($errors) == 0) {

        $id = registraCliente([$nombres, $apellidos, $email, $telefono, $dni], $con);

        if ($id > 0) {

            require 'clases/Mailer.php';
            $mailer = new Mailer();
            $token = generarToken();
            $pass_hash = password_hash($password, PASSWORD_DEFAULT);
            
            $idUsuario = registraUsuario([$usuario, $pass_hash, $token, $id], $con);
            if ($idUsuario > 0) {

                $url = SITE_URL . '/activar_cliente.php?id=' . $idUsuario . '&token=' . $token;
                //http://localhost/CafeteriaEscolar/activar_cliente.php?id=1&token=62e38dcdae441c0ae10f219ab6865e23
                $asunto = "Activar cuenta - Cafeteria Escolar";
                $cuerpo = "Estimado $nombres: <br> Para continuar con el proceso de registro es indispensable de click en la siguiente liga <a href='$url'>Activar cuenta</a>";

                if ($mailer->enviarEmail($email, $asunto, $cuerpo)) {
                    echo "Para terminar el proceso de registro siga las intrucciones que le hemos enviado a la direccon de correo electronivo $email";
                    echo '<button id="loginButton" onclick="window.location.href=\'login.php\'"> Login</button>';
                    exit;
                }
            } else {
                $errors[] = "Error al registrar usuario";
            }
        } else {
            $errors[] = "Error al registrar cliente";
        }
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
    <link href="css/estilos.css" rel="stylesheet">
</head>

<body>
    <!-- Barra de navegacion -->
    <?php include 'menu.php'; ?>
    
    <!--Contenido-->
    <main>
        <div class="container my-4">
            <h2>Datos del cliente</h2>

            <?php mostrarMensajes($errors); ?>

            <form class="row g-3" action="registro.php" method="post">
                <div class="col-md-6">
                    <label for="nombres"><span class="text-darger">*</span> Nombres</label>
                    <input type="text" name="nombres" id="nombres" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="apellidos"><span class="text-darger">*</span> Apellidos</label>
                    <input type="text" name="apellidos" id="apellidos" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="email"><span class="text-darger">*</span> Correo</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                    <span id="validaEmail" class="text-danger"></span>
                </div>
                <div class="col-md-6">
                    <label for="telefono"><span class="text-darger">*</span> Telefono</label>
                    <input type="tel" name="telefono" id="telefono" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="dni"><span class="text-darger">*</span> DNI</label>
                    <input type="text" name="dni" id="dni" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="usuario"><span class="text-darger">*</span> Usuario</label>
                    <input type="text" name="usuario" id="usuario" class="form-control" required>
                    <span id="validaUsuario" class="text-danger"></span>
                </div>
                <div class="col-md-6">
                    <label for="password"><span class="text-darger">*</span> Contraseña</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="repassword"><span class="text-darger">*</span> Repetir Contraseña</label>
                    <input type="password" name="repassword" id="repassword" class="form-control" required>
                </div>
                <i><b>Nota:</b>Los campos con * son obligatorios</i>
                <div class="col-12">
                    <button type="submit" id="registrarusuario" class="btn btn-primary">Registrar</button>
                </div>
            </form>
        </div>
    </main>


    <!-- opcion 1: Bootstrap Budle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <script>
        let txtusuario = document.getElementById('usuario')
        txtusuario.addEventListener("blur", function() {
            existeUsuario(txtusuario.value)
        }, false)

        let txtEmail = document.getElementById('email')
        txtEmail.addEventListener("blur", function() {
            existeEmail(txtEmail.value)
        }, false)


        function existeUsuario(usuario) {
            let url = "clases/clienteAjax.php"
            let formData = new FormData()
            formData.append("action", "existeUsuario")
            formData.append("usuario", usuario)

            fetch(url, {
                    method: 'POST',
                    body: formData
                }).then(response => response.json())
                .then(data => {

                    if (data.ok) {
                        document.getElementById('usuario').value = ''
                        document.getElementById('validaUsuario').innerHTML = 'Usuario no disponible'
                    } else {
                        document.getElementById('validaUsuario').innerHTML = ''
                    }

                })
        }

        function existeEmail(email) {
            let url = "clases/clienteAjax.php"
            let formData = new FormData()
            formData.append("action", "existeEmail")
            formData.append("email", email)

            fetch(url, {
                    method: 'POST',
                    body: formData
                }).then(response => response.json())
                .then(data => {

                    if (data.ok) {
                        document.getElementById('email').value = ''
                        document.getElementById('validaEmail').innerHTML = 'Email no disponible'
                    } else {
                        document.getElementById('validaEmail').innerHTML = ''
                    }

                })
        }

    </script>
    <!--
           
        Proyecto sistema de ventas online
        2024
    -->


</body>

</html>