
-- Volcando estructura de base de datos para cafeteria
CREATE DATABASE IF NOT EXISTS `cafeteria` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `cafeteria`;

-- Volcando estructura para tabla cafeteria.admin
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario` varchar(30) COLLATE utf8mb3_spanish_ci NOT NULL,
  `password` varchar(120) COLLATE utf8mb3_spanish_ci NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb3_spanish_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb3_spanish_ci NOT NULL,
  `token_password` varchar(40) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `password_request` tinyint NOT NULL DEFAULT '0',
  `activo` tinyint NOT NULL,
  `fecha_alta` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- Volcando datos para la tabla cafeteria.admin: ~1 rows (aproximadamente)
INSERT INTO `admin` (`id`, `usuario`, `password`, `nombre`, `email`, `token_password`, `password_request`, `activo`, `fecha_alta`) VALUES
	(1, 'administrador', '$2y$10$nR0d5HA1AU/H0taGvvyzQuP5PmVZgg3WwdthTKny3inyWWY.lOIK6', 'Administrador', ' @ejemplo.com', NULL, 0, 1, '2024-05-15 14:40:35');

-- Volcando estructura para tabla cafeteria.categorias
CREATE TABLE IF NOT EXISTS `categorias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8mb3_spanish_ci NOT NULL,
  `activo` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- Volcando datos para la tabla cafeteria.categorias: ~4 rows (aproximadamente)
INSERT INTO `categorias` (`id`, `nombre`, `activo`) VALUES
	(1, 'Bebidas', 1),
	(2, 'Frituras', 1),
	(3, 'Comidas', 1),
	(4, 'Dulces', 1);

-- Volcando estructura para tabla cafeteria.clientes
CREATE TABLE IF NOT EXISTS `clientes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombres` varchar(80) COLLATE utf8mb3_spanish_ci NOT NULL,
  `apellidos` varchar(80) COLLATE utf8mb3_spanish_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb3_spanish_ci NOT NULL,
  `telefono` varchar(20) COLLATE utf8mb3_spanish_ci NOT NULL,
  `dni` varchar(20) COLLATE utf8mb3_spanish_ci NOT NULL,
  `estatus` tinyint NOT NULL,
  `fecha_alta` datetime NOT NULL,
  `fecha_modifica` datetime DEFAULT NULL,
  `fecha_baja` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- Volcando datos para la tabla cafeteria.clientes: ~1 rows (aproximadamente)
INSERT INTO `clientes` (`id`, `nombres`, `apellidos`, `email`, `telefono`, `dni`, `estatus`, `fecha_alta`, `fecha_modifica`, `fecha_baja`) VALUES
	(1, ' ', 'Silverio', ' @ejemplo.com', '1234567890', '1234', 1, '2024-05-18 17:00:08', NULL, NULL);

-- Volcando estructura para tabla cafeteria.compra
CREATE TABLE IF NOT EXISTS `compra` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_transaccion` varchar(20) COLLATE utf8mb3_spanish_ci NOT NULL,
  `fecha` datetime NOT NULL,
  `status` varchar(20) COLLATE utf8mb3_spanish_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb3_spanish_ci NOT NULL,
  `id_cliente` varchar(20) COLLATE utf8mb3_spanish_ci NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `medio_pago` varchar(50) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- Volcando estructura para tabla cafeteria.configuracion
CREATE TABLE IF NOT EXISTS `configuracion` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8mb3_spanish_ci NOT NULL,
  `valor` tinytext COLLATE utf8mb3_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- Volcando datos para la tabla cafeteria.configuracion: ~9 rows (aproximadamente)
INSERT INTO `configuracion` (`id`, `nombre`, `valor`) VALUES
	(1, 'tienda_nombre', 'Cafetería Escolar'),
	(2, 'correo_email', 'ejemplo@ejemplo.com'),
	(3, 'correo_smtp', 'smtp.ejemplo.com'),
	(4, 'correo_password', 'contrasena'),
	(5, 'correo_puerto', '465'),
	(6, 'paypal_cliente', 'ejemplo'),
	(7, 'paypal_moneda', 'MXN'),
	(8, 'tienda_telefono', '1234567890'),
	(9, 'tienda_moneda', '$');

-- Volcando estructura para tabla cafeteria.detalle_compre
CREATE TABLE IF NOT EXISTS `detalle_compre` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_compra` int NOT NULL,
  `id_producto` int NOT NULL,
  `nombre` varchar(200) COLLATE utf8mb3_spanish_ci NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `cantidad` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- Volcando datos para la tabla cafeteria.detalle_compre: ~101 rows (aproximadamente)
INSERT INTO `detalle_compre` (`id`, `id_compra`, `id_producto`, `nombre`, `precio`, `cantidad`) VALUES
	(1, 1, 1, 'Sopes de pastor', 40.00, 1),
	(2, 2, 2, 'Tacos', 40.00, 1),
	(3, 2, 3, 'Hamburguesa con papas fritas', 45.00, 1),
	(4, 2, 5, 'Flautas', 30.00, 1),
	(5, 3, 8, 'Arizona kiwi con fresa', 20.00, 7),
	(6, 4, 1, 'Sopes de pastor', 40.00, 1),
	(7, 4, 2, 'Tacos', 40.00, 1),
	(8, 4, 3, 'Hamburguesa con papas fritas', 45.00, 1),
	(9, 5, 2, 'Tacos', 40.00, 1),
	(10, 5, 3, 'Hamburguesa con papas fritas', 45.00, 1),
	(11, 6, 2, 'Tacos', 40.00, 1),
	(12, 6, 3, 'Hamburguesa con papas fritas', 45.00, 1),
	(13, 7, 2, 'Tacos', 40.00, 1),
	(14, 7, 3, 'Hamburguesa con papas fritas', 45.00, 1),
	(15, 8, 2, 'Tacos', 40.00, 1),
	(16, 8, 1, 'Sopes de pastor', 40.00, 1),
	(17, 9, 2, 'Tacos', 40.00, 1),
	(18, 9, 3, 'Hamburguesa con papas fritas', 45.00, 1),
	(19, 10, 2, 'Tacos', 40.00, 1),
	(20, 10, 3, 'Hamburguesa con papas fritas', 45.00, 1),
	(21, 11, 2, 'Tacos', 40.00, 1),
	(22, 11, 3, 'Hamburguesa con papas fritas', 45.00, 1),
	(23, 12, 2, 'Tacos', 40.00, 1),
	(24, 13, 2, 'Tacos', 40.00, 1),
	(25, 13, 3, 'Hamburguesa con papas fritas', 45.00, 1),
	(26, 14, 2, 'Tacos', 40.00, 1),
	(27, 14, 3, 'Hamburguesa con papas fritas', 45.00, 1),
	(28, 15, 2, 'Tacos', 40.00, 1),
	(29, 15, 3, 'Hamburguesa con papas fritas', 45.00, 1),
	(30, 16, 2, 'Tacos', 40.00, 1),
	(31, 16, 3, 'Hamburguesa con papas fritas', 45.00, 1),
	(32, 17, 2, 'Tacos', 40.00, 1),
	(33, 17, 3, 'Hamburguesa con papas fritas', 45.00, 1),
	(34, 18, 2, 'Tacos', 40.00, 1),
	(35, 18, 3, 'Hamburguesa con papas fritas', 45.00, 1),
	(36, 19, 2, 'Tacos', 40.00, 1),
	(37, 19, 3, 'Hamburguesa con papas fritas', 45.00, 1),
	(38, 20, 2, 'Tacos', 40.00, 1),
	(39, 20, 3, 'Hamburguesa con papas fritas', 45.00, 1),
	(40, 21, 2, 'Tacos', 40.00, 1),
	(41, 21, 3, 'Hamburguesa con papas fritas', 45.00, 1),
	(42, 22, 2, 'Tacos', 40.00, 1),
	(43, 22, 3, 'Hamburguesa con papas fritas', 45.00, 1),
	(44, 23, 2, 'Tacos', 40.00, 1),
	(45, 23, 3, 'Hamburguesa con papas fritas', 45.00, 1),
	(46, 24, 2, 'Tacos', 40.00, 1),
	(47, 24, 3, 'Hamburguesa con papas fritas', 45.00, 1),
	(48, 25, 2, 'Tacos', 40.00, 1),
	(49, 25, 3, 'Hamburguesa con papas fritas', 45.00, 1),
	(50, 26, 2, 'Tacos', 40.00, 1),
	(51, 26, 3, 'Hamburguesa con papas fritas', 45.00, 1),
	(52, 27, 2, 'Tacos', 40.00, 1),
	(53, 27, 3, 'Hamburguesa con papas fritas', 45.00, 1),
	(54, 28, 2, 'Tacos', 40.00, 1),
	(55, 28, 3, 'Hamburguesa con papas fritas', 45.00, 1),
	(56, 29, 2, 'Tacos', 40.00, 1),
	(57, 29, 3, 'Hamburguesa con papas fritas', 45.00, 1),
	(58, 30, 2, 'Tacos', 40.00, 1),
	(59, 30, 3, 'Hamburguesa con papas fritas', 45.00, 1),
	(60, 31, 2, 'Tacos', 40.00, 1),
	(61, 31, 3, 'Hamburguesa con papas fritas', 45.00, 1),
	(62, 32, 2, 'Tacos', 40.00, 1),
	(63, 32, 3, 'Hamburguesa con papas fritas', 45.00, 1),
	(64, 33, 2, 'Tacos', 40.00, 1),
	(65, 33, 3, 'Hamburguesa con papas fritas', 45.00, 1),
	(66, 34, 2, 'Tacos', 40.00, 1),
	(67, 34, 3, 'Hamburguesa con papas fritas', 45.00, 1),
	(68, 35, 2, 'Tacos', 40.00, 1),
	(69, 35, 3, 'Hamburguesa con papas fritas', 45.00, 1),
	(70, 35, 1, 'Sopes de pastor', 40.00, 1),
	(71, 36, 2, 'Tacos', 40.00, 1),
	(72, 36, 3, 'Hamburguesa con papas fritas', 45.00, 1),
	(73, 37, 2, 'Tacos', 40.00, 1),
	(74, 37, 3, 'Hamburguesa con papas fritas', 45.00, 1),
	(75, 38, 2, 'Tacos', 40.00, 1),
	(76, 38, 3, 'Hamburguesa con papas fritas', 45.00, 1),
	(77, 39, 2, 'Tacos', 40.00, 1),
	(78, 39, 3, 'Hamburguesa con papas fritas', 45.00, 1),
	(79, 40, 5, 'Flautas', 30.00, 1),
	(80, 40, 6, 'sandwich', 15.00, 1),
	(81, 40, 7, 'Papas fritas Sabritas', 15.00, 1),
	(82, 41, 1, 'Sopes de pastor', 40.00, 1),
	(83, 41, 6, 'sandwich', 15.00, 1),
	(84, 41, 7, 'Papas fritas Sabritas', 15.00, 1),
	(85, 1, 5, 'Flautas', 30.00, 1),
	(86, 1, 6, 'sandwich', 15.00, 1),
	(87, 1, 7, 'Papas fritas Sabritas', 15.00, 1),
	(88, 2, 1, 'Sopes de pastor', 40.00, 1),
	(89, 2, 2, 'Tacos', 40.00, 1),
	(90, 2, 3, 'Hamburguesa con papas fritas', 45.00, 1),
	(91, 3, 2, 'Tacos', 40.00, 1),
	(92, 3, 3, 'Hamburguesa con papas fritas', 45.00, 1),
	(93, 4, 2, 'Tacos', 40.00, 1),
	(94, 4, 3, 'Hamburguesa con papas fritas', 45.00, 1),
	(95, 5, 2, 'Tacos', 40.00, 1),
	(96, 5, 3, 'Hamburguesa con papas fritas', 45.00, 1),
	(97, 6, 2, 'Tacos', 40.00, 1),
	(98, 7, 2, 'Tacos', 40.00, 1),
	(99, 7, 3, 'Hamburguesa con papas fritas', 45.00, 1),
	(100, 8, 2, 'Tacos', 40.00, 1),
	(101, 8, 3, 'Hamburguesa con papas fritas', 45.00, 1);

-- Volcando estructura para tabla cafeteria.productos
CREATE TABLE IF NOT EXISTS `productos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) COLLATE utf8mb3_spanish_ci NOT NULL,
  `descripcion` text COLLATE utf8mb3_spanish_ci NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `id_categoria` int NOT NULL,
  `activo` int NOT NULL,
  `descuento` tinyint NOT NULL DEFAULT '0',
  `stock` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- Volcando datos para la tabla cafeteria.productos: ~17 rows (aproximadamente)
INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `precio`, `id_categoria`, `activo`, `descuento`, `stock`) VALUES
	(1, 'Sopes de pastor', '<h2>Sopes de pastor</h2><p><br><strong>Características:</strong><br>Ingredientes:<br>Tortilla gruesa<br>Carne<br>&nbsp;</p>', 40.00, 3, 1, 0, 15),
	(2, 'Tacos', '<p>Tacos</p>\n<br>\n<b>Características:</b><br>\nIngredientes:<br>\nTortilla<br>\nCarne<br>\nCebolla<br>\nCilantro<br>', 40.00, 3, 1, 0, 6),
	(3, 'Hamburguesa con papas fritas', '<p>Hamburguesa con papas fritas</p>\n<br>\n<b>Características:</b><br>\nIngredientes:<br>\nPan<br>\nCarne<br>\nQueso <br>\nAderezos<br>', 50.00, 3, 1, 10, 7),
	(5, 'Flautas', '<p>Flautas "tacos dorados"</p>\r\n<br>\r\n<b>Características:</b><br>\r\nIngredientes:<br>\r\nTortilla<br>\r\nPollo<br>\r\nLechuga<br>\r\nTomate<br>', 30.00, 3, 1, 0, 4),
	(6, 'sandwich', 'Pan Integral Bimbo\r\nAderezo mostaza con miel\r\nPollo\r\nTocino ahumado\r\nLechuga\r\nQueso manchego', 20.00, 3, 1, 25, 4),
	(7, 'Papas fritas Sabritas', 'Papas fritas Sabritas original 159 g', 20.00, 2, 1, 25, 4),
	(8, 'Arizona kiwi con fresa', 'Arizona sabor kiwi con fresa 460ml', 20.00, 1, 1, 0, 0),
	(9, 'Tostadas', 'Tostadas con queso, frijos y salsa', 30.00, 3, 1, 0, 8),
	(10, 'Agua', 'Agua ciel de 1 litro', 15.00, 1, 1, 0, 8),
	(11, 'Arizona Sandía', '<h2><strong>Arizona Sandía 460 ml</strong></h2>', 20.00, 1, 1, 0, 8),
	(12, 'Coca Cola Lata 355 ml', '<h2>Coca Cola Lata 355 ml</h2>', 20.00, 1, 1, 10, 8),
	(13, 'Refresco Frutal Escuis Fresa 600ml', '<h2>Refresco frutal Escuis sabor fresa 600ml botella PET</h2><h2>&nbsp;</h2>', 20.00, 1, 1, 15, 8),
	(14, 'Papas fritas', '<h2>Papas fritas</h2>', 15.00, 2, 1, 0, 8),
	(15, 'Estrujada con huevo', '<h2>Estrujada con huevo</h2><p>Estrujada</p><p>Huevo</p><p>Queso</p><p>Frijol</p><p>Aguacate</p>', 40.00, 3, 1, 0, 8),
	(16, 'Torta de pollo', '<h2><strong>Torta de pollo</strong></h2><p>Ingredientes:</p><p>Bolillo</p><p>Pollo deshebrado</p><p>Tomate</p><p>Aguacate</p>', 20.00, 3, 1, 0, 8),
	(17, 'Powerade Ion4 Sabor Moras', '<h2>Powerade</h2><p>Bebida Para Deportistas</p><p>Sabor Moras</p><p>Botella de 1 Litro</p>', 30.00, 1, 1, 0, 8),
	(30, 'Pulparindo', '<h2>De la Rosa Pulparindo Original 1 pieza 14 grs</h2><p>Marca: de la Rosa</p>', 10.00, 4, 1, 0, 10);

-- Volcando estructura para tabla cafeteria.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario` varchar(30) COLLATE utf8mb3_spanish_ci NOT NULL,
  `password` varchar(120) COLLATE utf8mb3_spanish_ci NOT NULL,
  `activacion` int NOT NULL DEFAULT '0',
  `token` varchar(40) COLLATE utf8mb3_spanish_ci NOT NULL,
  `token_password` varchar(40) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `password_request` int NOT NULL DEFAULT '0',
  `id_cliente` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_usuario` (`usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;
