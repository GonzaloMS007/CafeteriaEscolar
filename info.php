<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cafetería</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        header {
            background-color: #343a40;
            color: white;
            text-align: center;
            padding: 10px 0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 0 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .section {
            margin-bottom: 40px;
        }
        .section img {
            max-width: 100%;
            display: block;
            margin: 0 auto;
            border-radius: 5px;
        }
        p {
            text-align: justify;
        }
        footer {
            background-color: #343a40;
            color: white;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <header>
        <h1>Información sobre la cafetería</h1>
    </header>
    <div class="container">
        <div class="section">
            <h2>Nuestra cafetería</h2>
            <img src="cafe.jpg" alt="Cafetería">
            <p>¡Bienvenido a nuestra cafetería! Somos un lugar acogedor donde puedes disfrutar de deliciosos cafés y pasteles.</p>
        </div>
        <div class="section">
            <h2>Nuestros productos</h2>
            <img src="productos.jpg" alt="Productos">
            <p>Ofrecemos una amplia variedad de productos, desde café recién hecho hasta pasteles caseros. ¡Descubre nuestras delicias!</p>
        </div>
        <div class="section">
            <h2>Ubicación</h2>
            <img src="mapa.jpg" alt="Mapa">
            <p>Nos encontramos en una ubicación céntrica y de fácil acceso. ¡Visítanos pronto!</p>
        </div>
    </div>
    <footer>
        <h4>&copy; 2024 Cafetería XYZ</h4>
    </footer>
</body>
</html>
