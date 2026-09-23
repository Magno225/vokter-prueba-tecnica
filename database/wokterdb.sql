-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3307
-- Tiempo de generación: 23-09-2026 a las 05:34:46
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `wokterdb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carritos`
--

CREATE TABLE `carritos` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `carritos`
--

INSERT INTO `carritos` (`id`, `usuario_id`, `fecha_creacion`) VALUES
(1, 1, '2026-09-21 17:28:35');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `descripcion`) VALUES
(1, 'Tecnología', 'Audífonos, consolas, accesorios y gadgets'),
(2, 'Ropa y Calzado', 'Sudaderas, camisetas, pantalones y calzado'),
(3, 'Hogar', 'Sábanas, artículos para el hogar y Star Home');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_factura`
--

CREATE TABLE `detalle_factura` (
  `id` int(11) NOT NULL,
  `factura_id` int(11) NOT NULL,
  `variante_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_factura`
--

INSERT INTO `detalle_factura` (`id`, `factura_id`, `variante_id`, `cantidad`, `precio_unitario`) VALUES
(1, 1, 47, 2, 110000.00),
(2, 2, 8, 1, 45000.00),
(3, 3, 2, 5, 13000.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direcciones_envio`
--

CREATE TABLE `direcciones_envio` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `ciudad` varchar(100) NOT NULL,
  `departamento` varchar(100) NOT NULL,
  `codigo_postal` varchar(10) NOT NULL,
  `es_principal` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `direcciones_envio`
--

INSERT INTO `direcciones_envio` (`id`, `usuario_id`, `direccion`, `ciudad`, `departamento`, `codigo_postal`, `es_principal`) VALUES
(1, 1, 'Cra. 77y #47-29 Sur', 'Bogotá', 'Cundimarca', '1030536475', 1),
(2, 1, 'Cra. 77y #47-29 Sur', 'Bogotá', 'Cundimarca', '110861', 1),
(3, 1, 'Cra. 77y #47-29 Sur', 'Bogotá', 'Cundimarca', '110861', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados_pedido`
--

CREATE TABLE `estados_pedido` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estados_pedido`
--

INSERT INTO `estados_pedido` (`id`, `nombre`) VALUES
(1, 'Pendiente'),
(2, 'Confirmado'),
(3, 'Enviado'),
(4, 'Entregado'),
(5, 'Cancelado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

CREATE TABLE `facturas` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `direccion_envio_id` int(11) NOT NULL,
  `metodo_pago_id` int(11) DEFAULT NULL,
  `estado_id` int(11) NOT NULL,
  `fecha_pedido` datetime DEFAULT current_timestamp(),
  `subtotal` decimal(10,2) NOT NULL,
  `costo_envio` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `facturas`
--

INSERT INTO `facturas` (`id`, `usuario_id`, `direccion_envio_id`, `metodo_pago_id`, `estado_id`, `fecha_pedido`, `subtotal`, `costo_envio`, `total`) VALUES
(1, 1, 1, NULL, 2, '2026-09-21 21:02:22', 220000.00, 0.00, 220000.00),
(2, 1, 2, NULL, 2, '2026-09-22 21:13:51', 45000.00, 0.00, 45000.00),
(3, 1, 3, NULL, 2, '2026-09-22 21:26:23', 65000.00, 0.00, 65000.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenes_producto`
--

CREATE TABLE `imagenes_producto` (
  `id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `es_principal` tinyint(1) DEFAULT 0,
  `orden` int(11) DEFAULT 0,
  `variante_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `imagenes_producto`
--

INSERT INTO `imagenes_producto` (`id`, `producto_id`, `url`, `es_principal`, `orden`, `variante_id`) VALUES
(1, 1, '/projectVokter/Images/Fotos/TecnologiaProductos/consola.png', 1, 1, 1),
(2, 2, '/projectVokter/Images/Fotos/TecnologiaProductos/teclado1.png', 1, 1, 2),
(3, 3, '/projectVokter/Images/Fotos/TecnologiaProductos/comboGamer1.jpg', 1, 1, 3),
(4, 4, '/projectVokter/Images/Fotos/TecnologiaProductos/mousenegro1.jpg', 1, 1, 4),
(5, 5, '/projectVokter/Images/Fotos/TecnologiaProductos/MouseInalámbricoColorGris.jpg', 1, 1, 5),
(6, 6, '/projectVokter/Images/Fotos/TecnologiaProductos/Power-Bank-de-20.000-MAH.jpg', 1, 1, 6),
(7, 7, '/projectVokter/Images/Fotos/TecnologiaProductos/Power-Bank-de-10.000-MAH.jpg', 1, 1, 7),
(8, 8, '/projectVokter/Images/Fotos/TecnologiaProductos/PowerBankde5000MAHBlanca.jpg', 1, 1, 8),
(9, 9, '/projectVokter/Images/Fotos/TecnologiaProductos/MicrofonoInalámbrico1.jpg', 1, 1, 9),
(10, 10, '/projectVokter/Images/Fotos/TecnologiaProductos/SoporteInalámbricoParaMoto1.jpg', 1, 1, 10),
(11, 11, '/projectVokter/Images/Fotos/TecnologiaProductos/SoporteDeEspejoParaMoto.jpg', 1, 1, 11),
(12, 12, '/projectVokter/Images/Fotos/TecnologiaProductos/SoporteParaMotoManubrio.jpg', 1, 1, 12),
(13, 13, '/projectVokter/Images/Fotos/TecnologiaProductos/HolderParaCarro.jpg', 1, 1, 13),
(14, 14, '/projectVokter/Images/Fotos/TecnologiaProductos/HolderParaCarroChupaIman.jpg', 1, 1, 14),
(15, 15, '/projectVokter/Images/Fotos/TecnologiaProductos/Cargador4A20WTipoC.jpg', 1, 1, 15),
(16, 16, '/projectVokter/Images/Fotos/TecnologiaProductos/Cargador67WTipoCXioami.jpg', 1, 1, 16),
(17, 17, '/projectVokter/Images/Fotos/TecnologiaProductos/CargadorTipoC.jpg', 1, 1, 17),
(18, 18, '/projectVokter/Images/Fotos/TecnologiaProductos/CargadorTipoCTechnoMaster.jpg', 1, 1, 18),
(19, 19, '/projectVokter/Images/Fotos/TecnologiaProductos/Pulin38WNegro.jpg', 1, 1, 19),
(20, 20, '/projectVokter/Images/Fotos/TecnologiaProductos/Pulin5ATechnoMasterC209.jpg', 1, 1, 20),
(21, 21, '/projectVokter/Images/Fotos/TecnologiaProductos/ParlanteFlySoundS520Negro.jpg', 1, 1, 21),
(22, 22, '/projectVokter/Images/Fotos/TecnologiaProductos/ParlanteS640Negro.jpg', 1, 1, 22),
(23, 23, '/projectVokter/Images/Fotos/TecnologiaProductos/ParlanteFL828Negro.jpg', 1, 1, 23),
(24, 24, '/projectVokter/Images/Fotos/TecnologiaProductos/ParlanteFlySoundS430Negro.jpg', 1, 1, 24),
(25, 25, '/projectVokter/Images/Fotos/TecnologiaProductos/ParlanteModelSoundS410VerdeRojo.jpg', 1, 1, 25),
(26, 26, '/projectVokter/Images/Fotos/TecnologiaProductos/ManosLibresPyPF805Negro.jpg', 1, 1, 26),
(27, 27, '/projectVokter/Images/Fotos/TecnologiaProductos/ManosLibresFlySoundF20Negro.jpg', 1, 1, 27),
(28, 28, '/projectVokter/Images/Fotos/TecnologiaProductos/CuellerabluetoothSportWirelessZon-35Negro.jpg', 1, 1, 28),
(29, 29, '/projectVokter/Images/Fotos/TecnologiaProductos/DiademaAirpodsMaxGris.jpg', 1, 1, 29),
(30, 30, '/projectVokter/Images/Fotos/TecnologiaProductos/DiademaP9Plateado.jpg', 1, 1, 30),
(31, 31, '/projectVokter/Images/Fotos/TecnologiaProductos/DiademaSonyWireless450BTNegroRojo.jpg', 1, 1, 31),
(32, 32, '/projectVokter/Images/Fotos/TecnologiaProductos/DiademaTechnoMasterWirelessN65BTPurpura.jpg', 1, 1, 32),
(33, 33, '/projectVokter/Images/Fotos/TecnologiaProductos/DiademaSonyMDRXB450.jpg', 1, 1, 33),
(34, 34, '/projectVokter/Images/Fotos/TecnologiaProductos/DiademaGamerAzulNegro.jpg', 1, 1, 34),
(35, 35, '/projectVokter/Images/Fotos/TecnologiaProductos/BalacaAirMAXImantadaBlacoPlateado.jpg', 1, 1, 35),
(36, 36, '/projectVokter/Images/Fotos/TecnologiaProductos/ManosLibresSamsungTunedbyARKNegro.jpg', 1, 1, 36),
(37, 37, '/projectVokter/Images/Fotos/TecnologiaProductos/ProyectorCasero2ControlesBlanca.jpg', 1, 1, 37),
(38, 38, '/projectVokter/Images/Fotos/TecnologiaProductos/TVStickAndroidSmartTVsNegro.jpg', 1, 1, 38),
(39, 39, '/projectVokter/Images/Fotos/TecnologiaProductos/WatchOnnTVStreamingNegro.jpg', 1, 1, 39),
(40, 40, '/projectVokter/Images/Fotos/TecnologiaProductos/SiliconeIphoneparaIphone1112 y14Plus.jpg', 1, 1, 40),
(41, 41, '/projectVokter/Images/Fotos/TecnologiaProductos/SiliconeAndroidPararefSamsungRedmiMotorola.jpg', 1, 1, 41),
(42, 42, '/projectVokter/Images/Fotos/TecnologiaProductos/SiliconeAndroidSamsungDeLujo.jpg', 1, 1, 42),
(43, 43, '/projectVokter/Images/Fotos/TecnologiaProductos/ProtectordeAirpodsPersonalizados.jpg', 1, 1, 43),
(44, 44, '/projectVokter/Images/Fotos/TecnologiaProductos/ProtectordeCargadorPersonalizado.jpg', 1, 1, 44),
(45, 45, '/projectVokter/Images/Fotos/TecnologiaProductos/AntenadeTelevisiónDigitalTDT.jpg', 1, 1, 45),
(46, 46, '/projectVokter/Images/Fotos/TecnologiaProductos/CodificadordeTelevisiónDigitalTerrestreTDT.jpg', 1, 1, 46),
(47, 47, '/projectVokter/Images/Fotos/HogarProductos/SabanasStarHome100AlogdonEstampadoTipoPlantas+FundaDeAlmohadas.jpg', 1, 1, 47),
(48, 47, '/projectVokter/Images/Fotos/HogarProductos/SabanasStarHome100AlogdonEstampadoTipo+Triangulo+FundadeAlmohadas.jpg', 0, 2, 48),
(49, 47, '/projectVokter/Images/Fotos/HogarProductos/SabanasStarHome100AlogdonEstampadoTipo+GrisFloreal+FundadeAlmohadas.jpg', 0, 3, 49),
(50, 47, '/projectVokter/Images/Fotos/HogarProductos/SabanasStarHome100AlogdonEstampadoTipo+Estrellas+FundadeAlmohadas.jpg', 0, 4, 50),
(51, 47, '/projectVokter/Images/Fotos/HogarProductos/SabanasStarHome100AlogdonEstampadoTipo+Goteras+FundadeAlmohadas.jpg', 0, 5, 51),
(52, 47, '/projectVokter/Images/Fotos/HogarProductos/SabanasStarHome100AlogdonEstampadoTipo+Pastel+FundadeAlmohadas.jpg', 0, 6, 52),
(53, 47, '/projectVokter/Images/Fotos/HogarProductos/SabanasStarHome100AlogdonEstampadoTipo+Pecas+FundadeAlmohadas.jpg', 0, 7, 53),
(54, 48, '/projectVokter/Images/Fotos/RopaCalzadoProductos/ConjuntoDeportivoHombreChaquetaPantalón+Negro+confranjaslaterales.jpg', 1, 1, 54),
(55, 48, '/projectVokter/Images/Fotos/RopaCalzadoProductos/ConjuntoDeportivoHombreChaquetaPantalón+Gris+confranjaslaterales.jpg', 0, 2, 58),
(56, 48, '/projectVokter/Images/Fotos/RopaCalzadoProductos/ConjuntoDeportivoHombreChaquetaPantalón+Beige+confranjaslaterales.jpg', 0, 3, 62),
(57, 48, '/projectVokter/Images/Fotos/RopaCalzadoProductos/ConjuntoDeportivoHombreChaquetaPantalón+Azul+confranjaslaterales.jpg', 0, 4, 66),
(58, 49, '/projectVokter/Images/Fotos/RopaCalzadoProductos/ConjuntoDeportivoHombreChaquetaCuelloAlto+Negro+PantalónRecto.jpg', 1, 1, 70),
(59, 49, '/projectVokter/Images/Fotos/RopaCalzadoProductos/ConjuntoDeportivoHombreChaquetaCuelloAlto+Azul-marino+PantalónRecto.jpg', 0, 2, 74),
(60, 49, '/projectVokter/Images/Fotos/RopaCalzadoProductos/ConjuntoDeportivoHombreChaquetaCuelloAlto+Beige+PantalónRecto.jpg', 0, 3, 78),
(61, 50, '/projectVokter/Images/Fotos/RopaCalzadoProductos/ConjuntoDeportivoHombreChaquetaCuelloAlto+Negro+PantalónRecto.jpg', 1, 1, 82),
(62, 50, '/projectVokter/Images/Fotos/RopaCalzadoProductos/ConjuntoDeportivoHombreChaquetaCuelloAlto+Azul-marino+PantalónRecto.jpg', 0, 2, 86),
(63, 50, '/projectVokter/Images/Fotos/RopaCalzadoProductos/ConjuntoDeportivoHombreChaquetaCuelloAlto+Beige+PantalónRecto.jpg', 0, 3, 90),
(64, 51, '/projectVokter/Images/Fotos/RopaCalzadoProductos/ConjuntoDeportivoMujerChaqueta+Negro-Azul+PantalónconCordónYDetalleLateral.jpg', 1, 1, 98),
(65, 51, '/projectVokter/Images/Fotos/RopaCalzadoProductos/ConjuntoDeportivoMujerChaqueta+Verde-Menta+PantalónconCordónYDetalleLateral.jpg', 0, 2, 94),
(66, 51, '/projectVokter/Images/Fotos/RopaCalzadoProductos/ConjuntoDeportivoMujerChaqueta+Coral+PantalónconCordónYDetalleLateral.jpg', 0, 3, 102),
(67, 52, '/projectVokter/Images/Fotos/RopaCalzadoProductos/ConjuntoDeportivoMujerChaquetaCuelloAlto+Lila+PantalónNegroRecto.jpg', 1, 1, 106),
(68, 52, '/projectVokter/Images/Fotos/RopaCalzadoProductos/ConjuntoDeportivoMujerChaquetaCuelloAlto+Gris+PantalónNegroRecto.jpg', 0, 2, 110),
(69, 52, '/projectVokter/Images/Fotos/RopaCalzadoProductos/ConjuntoDeportivoMujerChaquetaCuelloAlto+Blanco+PantalónNegroRecto.jpg', 0, 3, 114),
(70, 52, '/projectVokter/Images/Fotos/RopaCalzadoProductos/ConjuntoDeportivoMujerChaquetaCuelloAlto+Beige+PantalónNegroRecto.jpg', 0, 4, 118),
(71, 52, '/projectVokter/Images/Fotos/RopaCalzadoProductos/ConjuntoDeportivoMujerChaquetaCuelloAlto+Azul+PantalónNegroRecto.jpg', 0, 5, 122),
(72, 52, '/projectVokter/Images/Fotos/RopaCalzadoProductos/ConjuntoDeportivoMujerChaquetaCuelloAlto+Negro+PantalónNegroRecto.jpg', 0, 6, 126),
(73, 52, '/projectVokter/Images/Fotos/RopaCalzadoProductos/ConjuntoDeportivoMujerChaquetaCuelloAlto+Verde-Menta+PantalónNegroRecto.jpg', 0, 7, 130),
(74, 53, '/projectVokter/Images/Fotos/RopaCalzadoProductos/ConjuntoDeportivoHombreChaquetaBicolor+Azul-Beige+PantalónPoliester.jpg', 1, 1, 134),
(75, 53, '/projectVokter/Images/Fotos/RopaCalzadoProductos/ConjuntoDeportivoHombreChaquetaBicolor+Verde-Gris+PantalónPoliester.jpg', 0, 2, 138),
(76, 53, '/projectVokter/Images/Fotos/RopaCalzadoProductos/ConjuntoDeportivoHombreChaquetaBicolor+Negro-Marron+PantalónPoliester.jpg', 0, 3, 142),
(77, 53, '/projectVokter/Images/Fotos/RopaCalzadoProductos/ConjuntoDeportivoHombreChaquetaBicolor+Roja-Balnco+PantalónPoliester.jpg', 0, 4, 146),
(78, 53, '/projectVokter/Images/Fotos/RopaCalzadoProductos/ConjuntoDeportivoHombreChaquetaBicolor+Azul-Blanco+PantalónPoliester.jpg', 0, 5, 150),
(79, 54, '../Images/Fotos/RopaCalzadoProductos/TenisLouisVuittonLVSkate+Negro-Blanco+Hombre.jpg', 1, 1, 154),
(80, 55, '../Images/Fotos/RopaCalzadoProductos/TenisLouisVuittonLVTrainer+Azul-Blanco+Hombre.jpg', 1, 1, 159),
(81, 56, '../Images/Fotos/RopaCalzadoProductos/TenisLouisVuittonLVArchlight+Blanco-Negro+Mujer.jpg', 1, 1, 164),
(82, 57, '../Images/Fotos/RopaCalzadoProductos/TenisRunningHokaClifton9+Azul-Blanco+Hombre.jpg', 1, 1, 169),
(83, 58, '../Images/Fotos/RopaCalzadoProductos/TenisRunningHokaBondi9+Gris-Azul+Hombre.jpg', 1, 1, 174),
(84, 59, '../Images/Fotos/RopaCalzadoProductos/TenisRunningHokaBondi9+BlancoCrema-Negro+Mujer.jpg', 1, 1, 179),
(85, 60, '../Images/Fotos/RopaCalzadoProductos/TenisRunningHokaBondi+Negro-GrisOscuro+Hombre.jpg', 1, 1, 184),
(86, 61, '../Images/Fotos/RopaCalzadoProductos/TenisSkechersGOWALK+Negro-GrisOscuro+Mujer.jpg', 1, 1, 189),
(87, 62, '../Images/Fotos/RopaCalzadoProductos/SneakerValentinoGaravaniOneStud+Blanco-GrisClaro+Hombre.jpg', 1, 1, 194),
(88, 63, '../Images/Fotos/RopaCalzadoProductos/SneakerValentinoGaravaniOpen+Blanco-AzulMarino+Hombre.jpg', 1, 1, 199),
(89, 64, '../Images/Fotos/RopaCalzadoProductos/SneakerValentinoGaravaniVL7N+Negro-Blanco+Hombre.jpg', 1, 1, 204),
(90, 65, '../Images/Fotos/RopaCalzadoProductos/BotaUnderArmourMicroGValsetzMid+VerdeOliva-Negro+Hombre.jpg', 1, 1, 209);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `items_carrito`
--

CREATE TABLE `items_carrito` (
  `id` int(11) NOT NULL,
  `carrito_id` int(11) NOT NULL,
  `variante_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 1,
  `precio_unitario` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metodos_pago`
--

CREATE TABLE `metodos_pago` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `marca` varchar(50) NOT NULL,
  `ultimos_4_digitos` char(4) NOT NULL,
  `token_pasarela` varchar(255) NOT NULL,
  `es_principal` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio_base` decimal(10,2) NOT NULL,
  `marca` varchar(50) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1,
  `en_promocion` tinyint(1) DEFAULT 0,
  `descuento_porcentaje` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `categoria_id`, `nombre`, `descripcion`, `precio_base`, `marca`, `activo`, `en_promocion`, `descuento_porcentaje`) VALUES
(1, 1, 'Consola Negra Verde Retro', 'Consola gamer retro con control inalámbrico incluido', 70000.00, 'Vokter', 1, 1, 20.00),
(2, 1, 'Teclado Office Wired Keyboard Color Negro', 'Teclado de oficina alámbrico, color negro', 13000.00, 'Vokter', 1, 0, NULL),
(3, 1, 'Combo Gamer T25 Color Blanco', 'Combo gamer con teclado y mouse, color blanco', 45000.00, 'Vokter', 1, 0, NULL),
(4, 1, 'Mouse Alámbrico', 'Mouse alámbrico estándar', 5500.00, 'Vokter', 1, 1, 20.00),
(5, 1, 'Mouse Inalámbrico Color Gris', 'Mouse inalámbrico, color gris', 12000.00, 'Vokter', 1, 0, NULL),
(6, 1, 'Power Bank de 20.000 MAH', 'Batería portátil de 20.000 mAh', 55000.00, 'Vokter', 1, 0, NULL),
(7, 1, 'Power Bank de 10.000 MAH', 'Batería portátil de 10.000 mAh', 45000.00, 'Vokter', 1, 1, 20.00),
(8, 1, 'Power Bank de 5.000 MAH Blanca', 'Batería portátil de 5.000 mAh, color blanco', 45000.00, 'Vokter', 1, 0, NULL),
(9, 1, 'Micrófono Inalámbrico', 'Micrófono inalámbrico', 25000.00, 'Vokter', 1, 1, 20.00),
(10, 1, 'Soporte Inalámbrico Para Moto', 'Soporte con carga inalámbrica para moto', 15000.00, 'Vokter', 1, 0, NULL),
(11, 1, 'Soporte De Espejo Para Moto', 'Soporte para espejo de moto', 13000.00, 'Vokter', 1, 0, NULL),
(12, 1, 'Soporte Para Moto Manubrio', 'Soporte para manubrio de moto', 13000.00, 'Vokter', 1, 0, NULL),
(13, 1, 'Holder Para Carro', 'Soporte para celular en carro', 9500.00, 'Vokter', 1, 1, 20.00),
(14, 1, 'Holder Para Carro Chupa Imán', 'Soporte para celular en carro con chupa/imán', 10000.00, 'Vokter', 1, 1, 20.00),
(15, 1, 'Cargador 4A y 20W Tipo C', 'Cargador rápido tipo C, 4A y 20W', 7000.00, 'Vokter', 1, 0, NULL),
(16, 1, 'Cargador 67W Tipo C Xiaomi', 'Cargador rápido tipo C, 67W, compatible Xiaomi', 20000.00, 'Vokter', 1, 0, NULL),
(17, 1, 'Cargador Tipo C', 'Cargador tipo C estándar', 20000.00, 'Vokter', 1, 0, NULL),
(18, 1, 'Cargador Tipo C TechnoMaster', 'Cargador tipo C marca TechnoMaster', 10000.00, 'TechnoMaster', 1, 0, NULL),
(19, 1, 'Pulin 38W Negro', 'Pulin cargador 38W, color negro', 9500.00, 'Vokter', 1, 0, NULL),
(20, 1, 'Pulin 5A TechnoMaster C209', 'Pulin cargador 5A, modelo C209', 7500.00, 'TechnoMaster', 1, 0, NULL),
(21, 1, 'Parlante Fly Sound S520 Negro', 'Parlante Fly Sound S520, color negro', 85000.00, 'Fly Sound', 1, 0, NULL),
(22, 1, 'Parlante S640 Negro', 'Parlante S640, color negro', 13000.00, 'Vokter', 1, 1, 20.00),
(23, 1, 'Parlante FL828 Negro', 'Parlante FL828, color negro', 85000.00, 'Vokter', 1, 0, NULL),
(24, 1, 'Parlante Fly Sound S430 Negro', 'Parlante Fly Sound S430, color negro', 75000.00, 'Fly Sound', 1, 1, 20.00),
(25, 1, 'Parlante Model Sound S410 Verde/Rojo', 'Parlante Model Sound S410, color verde/rojo', 38000.00, 'Model Sound', 1, 0, NULL),
(26, 1, 'Manos Libres P&P F805 Negro', 'Manos libres P&P F805, color negro', 40000.00, 'P&P', 1, 0, NULL),
(27, 1, 'Manos Libres Fly Sound F20 Negro', 'Manos libres Fly Sound F20, color negro', 38000.00, 'Fly Sound', 1, 0, NULL),
(28, 1, 'Cuellera Bluetooth Sport Wireless Zon-35 Negro', 'Cuellera bluetooth deportiva Zon-35, color negro', 38000.00, 'Sport Wireless', 1, 0, NULL),
(29, 1, 'Diadema Airpods Max Gris', 'Diadema estilo Airpods Max, color gris', 52000.00, 'Vokter', 1, 0, NULL),
(30, 1, 'Diadema P9 Plateado', 'Diadema P9, color plateado', 52000.00, 'Vokter', 1, 1, 20.00),
(31, 1, 'Diadema Sony Wireless 450BT Negro/Rojo', 'Diadema Sony Wireless 450BT, color negro/rojo', 25000.00, 'Sony', 1, 0, NULL),
(32, 1, 'Diadema TechnoMaster Wireless N65BT Purpura', 'Diadema TechnoMaster Wireless N65BT, color púrpura', 32000.00, 'TechnoMaster', 1, 0, NULL),
(33, 1, 'Diadema Sony MDR XB450', 'Diadema Sony MDR XB450', 14500.00, 'Sony', 1, 0, NULL),
(34, 1, 'Diadema Gamer Azul/Negro', 'Diadema gamer, color azul/negro', 63000.00, 'Vokter', 1, 0, NULL),
(35, 1, 'Balaca Air MAX Imantada Blanco/Plateado', 'Balaca Air MAX imantada, color blanco/plateado', 90000.00, 'Vokter', 1, 0, NULL),
(36, 1, 'Manos Libres Samsung Tuned by ARK Negro', 'Manos libres Samsung Tuned by ARK, color negro', 3600.00, 'Samsung', 1, 0, NULL),
(37, 1, 'Proyector Casero + 2 Controles Blanca', 'Proyector casero para reproducción de multimedia y videojuegos, incluye 2 controles', 185000.00, 'Vokter', 1, 0, NULL),
(38, 1, 'TV Stick Android Smart TVs Negro', 'TV Stick con sistema Android para convertir cualquier TV en Smart TV', 55000.00, 'Vokter', 1, 0, NULL),
(39, 1, 'Watch Onn TV Streaming Negro', 'Dispositivo de streaming Watch Onn TV, color negro', 80000.00, 'Onn', 1, 0, NULL),
(40, 1, 'Silicone Iphone para Iphone 11, 12 y 14 Plus', 'Funda de silicona compatible con iPhone 11, 12 y 14 Plus', 4500.00, 'Vokter', 1, 0, NULL),
(41, 1, 'Silicone Android Para ref Samsung/Redmi/Motorola', 'Funda de silicona compatible con Samsung, Redmi y Motorola', 5000.00, 'Vokter', 1, 1, 20.00),
(42, 1, 'Silicone Android Samsung De Lujo', 'Funda de silicona de lujo para Samsung', 12000.00, 'Vokter', 1, 0, NULL),
(43, 1, 'Protector de Airpods Personalizados', 'Protector personalizado para Airpods', 7000.00, 'Vokter', 1, 0, NULL),
(44, 1, 'Protector de Cargador Personalizado', 'Protector personalizado para cargador', 7000.00, 'Vokter', 1, 0, NULL),
(45, 1, 'Antena de Televisión Digital/TDT', 'Antena para televisión digital terrestre casera de facíl instalación Color negro.', 15000.00, 'Vokter', 1, 0, NULL),
(46, 1, 'Codificador de Televisión Digital Terrestre/TDT', 'Codificador/decodificador de señal TDT', 48000.00, 'Vokter', 1, 0, NULL),
(47, 3, 'Sábanas Star Home 100% Algodón + Funda de Almohadas', 'Juego de sábanas 100% algodón estampado, suave, fresco y duradero. Presentado en caja y listo para regalar.', 110000.00, 'Star Home', 1, 0, NULL),
(48, 2, 'Conjunto Deportivo Hombre Chaqueta + Pantalón con franjas laterales', 'Conjunto deportivo de dos piezas para hombre, con chaqueta de cuello alto y cierre frontal completo. Tiene una franja que recorre hombros y mangas, y puños tejidos que dan un ajuste cómodo. El pantalón recto lleva cintura elástica con cordón y bolsillos laterales con cierre.', 170000.00, 'Vokter', 1, 0, NULL),
(49, 2, 'Conjunto Deportivo Hombre Chaqueta Cuello Alto + Pantalón Recto', 'Conjunto deportivo de dos piezas para hombre, con chaqueta de cuello alto y cierre frontal completo. Tiene paneles texturizados en pecho y hombros que le dan un look moderno, un bolsillo con cierre en el pecho y bolsillos laterales. Los puños y la cintura son tejidos, para un ajuste cómodo. El pantalón es de corte recto, con cintura elástica y bolsillos laterales con cierre.', 119900.00, 'Under Armour', 1, 0, NULL),
(50, 2, 'Conjunto Deportivo Hombre Chaqueta Cuello Alto + Pantalón Recto', 'Conjunto deportivo de dos piezas para hombre, con chaqueta de cuello alto y cierre frontal completo. Tiene paneles texturizados en pecho y hombros que le dan un look moderno, un bolsillo con cierre en el pecho y bolsillos laterales. Los puños y la cintura son tejidos, para un ajuste cómodo. El pantalón es de corte recto, con cintura elástica y bolsillos laterales con cierre.', 119900.00, 'Under Armour', 1, 0, NULL),
(51, 2, 'Conjunto Deportivo Mujer Chaqueta + Pantalón con Cordón y Detalle Lateral', 'Chaqueta de cuello alto con cierre y puños ajustados, y pantalón negro con cordón en la cintura y franja estampada al costado. La tela se ve más gruesa, ideal para clima frío.', 109900.00, 'Vokter', 1, 0, NULL),
(52, 2, 'Conjunto Deportivo Mujer Chaqueta Cuello Alto + Pantalón Negro Recto', 'Conjunto deportivo de dos piezas para mujer, con chaqueta de cuello alto y cierre frontal completo, en colores lisos y fáciles de combinar. Tiene bolsillos laterales con cierre y puños ajustados. El pantalón es negro, de corte recto, con cintura elástica y cordón ajustable. La tela es liviana, suave y flexible, y seca rápido. Sirve para gimnasio, yoga, caminatas, viajes o para usar todos los días.', 99900.00, 'Nike', 1, 0, NULL),
(53, 2, 'Conjunto Deportivo Hombre Chaqueta Bicolor + Pantalón', 'Conjunto deportivo de dos piezas para hombre, con chaqueta bicolor con cuello alto y cierre frontal. Bolsillos laterales con cierre, tela elástica, liviana y de secado rápido. Su diseño bicolor con corte en V al frente le da un look moderno y diferente. Tiene bolsillos laterales con cierre y el borde inferior y los puños son tejidos, con franjas en contraste. El pantalón es de corte recto, con cintura elástica y bolsillos laterales con cierre, en el mismo tono de la chaqueta. Está hecho en tela tipo seda coreana (poliéster elástico), liviana, suave al tacto, resistente y de secado rápido. Sirve para gimnasio.', 124900.00, 'Vokter', 1, 0, NULL),
(54, 2, 'Tenis Louis Vuitton LV Skate Hombre Color: Negro-Blanco', 'Tenis de skate estilo casual, con parte superior en malla técnica combinada con piel de becerro y gamuza, y suela de caucho bicolor decorada con las icónicas flores Monogram. Inspirado en las zapatillas de skate de los años 90, este modelo combina la actitud urbana con el lujo de la casa francesa. Si buscas destacar con un diseño llamativo que mezcla comodidad y estatus, este es el par para verte diferente en cualquier lugar.', 199900.00, 'Louis Vuitton', 1, 0, NULL),
(55, 2, 'Tenis Louis Vuitton LV Trainer Hombre Color: Azul-Blanco', 'Tenis inspirados en las zapatillas de baloncesto vintage, con parte superior en denim Monogram combinado con piel de becerro granulada en relieve. Suela de caucho con inyección de gel, y cada par lleva siete horas de costura, fabricado en Italia. Diseñado bajo la dirección de Virgil Abloh, este modelo te da un aire urbano y sofisticado a la vez. Siéntete parte de la vanguardia del streetwear de lujo con cada paso.', 199900.00, 'Louis Vuitton', 1, 0, NULL),
(56, 2, 'Tenis Louis Vuitton LV Archlight Mujer Color: Blanco-Negro', 'Tenis de corte bajo con suela ondulada en forma de ola y lengüeta oversize, parte superior en malla técnica de nylon blanca combinada con piel de becerro, con detalles en lona Monogram recubierta. Un modelo statement que combina volumen y elegancia urbana. Con este par, cada paso se convierte en una declaración de estilo, perfecta para quien busca sobresalir sin esfuerzo.', 250000.00, 'Louis Vuitton', 1, 0, NULL),
(57, 2, 'Tenis Running Hoka Clifton 9 Hombre Color: Azul-Blanco', 'Tenis de running con parte superior en malla técnica tejida (engineered knit) transpirable, hecha con material reciclado, entresuela en espuma EVA moldeada por compresión (CMEVA) y suela exterior en caucho Durabrasion. Ligereza y amortiguación en cada zancada, ideales para quienes buscan rendimiento sin sacrificar comodidad. Siente la diferencia desde el primer kilómetro.', 189900.00, 'Hoka', 1, 0, NULL),
(58, 2, 'Tenis Running Hoka Bondi 9 Hombre Color: Gris-Azul', 'Tenis de running con parte superior en malla técnica tejida (engineered mesh), 55% poliéster reciclado, con respiración por zonas. Entresuela en espuma EVA supercrítica y suela exterior en caucho resistente a la abrasión. Máxima amortiguación para largas distancias, pensado para quien no quiere detenerse. Corre más lejos, siente menos cansancio.', 299900.00, 'Hoka', 1, 0, NULL),
(59, 2, 'Tenis Running Hoka Bondi 9 Mujer Color: Blanco Crema-Negro', 'Tenis de running con parte superior en malla técnica tejida (engineered mesh) transpirable, entresuela en espuma EVA supercrítica de alta amortiguación y suela exterior en caucho resistente a la abrasión. Un diseño limpio y versátil que acompaña tanto tus entrenamientos como tu día a día. Camina o corre con la confianza de un respaldo suave en cada paso.', 99900.00, 'Hoka', 1, 0, NULL),
(60, 2, 'Tenis Running Hoka Bondi Hombre Color: Negro-Gris Oscuro', 'Tenis de running con parte superior en malla textil técnica (engineered mesh) transpirable con forro textil, entresuela en espuma EVA de alta amortiguación y suela exterior en caucho resistente a la abrasión. Su versión \"Triple Black\" ofrece un look elegante y discreto sin sacrificar el rendimiento. Ideal para quien busca destacar por la sencillez y la comodidad al mismo tiempo.', 109900.00, 'Hoka', 1, 0, NULL),
(61, 2, 'Tenis Skechers GO WALK Mujer Color: Negro-Gris Oscuro', 'Tenis slip-on sin cordones, con parte superior en textil de malla tejida atlética, ligera y transpirable, material vegano. Plantilla acolchada de espuma y entresuela liviana de amortiguación, con suela exterior en caucho sintético. Practicidad total: te los pones y sales, sin complicarte con cordones, sin perder estilo ni comodidad.', 104900.00, 'Skechers', 1, 0, NULL),
(62, 2, 'Sneaker Valentino Garavani One Stud Hombre Color: Blanco-Gris Claro', 'Sneaker bajo en piel napa de becerro (calfskin) con acabado semimate, tachuela piramidal (maxi stud) de acabado semimate como sello distintivo, y suela de caucho con relieve de tachuelas. Fabricado en Italia. Un calzado que combina el lujo italiano con un toque urbano audaz, perfecto para quien quiere pisar fuerte con estilo.', 399900.00, 'Valentino Garavani', 1, 0, NULL),
(63, 2, 'Sneaker Valentino Garavani Open Hombre Color: Blanco-Azul Marino', 'Sneaker bajo en piel de becerro (calfskin) lisa, con banda de contraste también en piel cruzando el empeine, forro en piel y suela de caucho blanco con tachuelas decorativas en el talón. Fabricado en Italia. Un clásico atemporal con un toque de color que le da personalidad sin perder la elegancia minimalista.', 269900.00, 'Valentino Garavani', 1, 0, NULL),
(64, 2, 'Sneaker Valentino Garavani VL7N Hombre Color: Negro-Blanco', 'Sneaker bajo en cuero de becerro granulado (pebbled), con cintas de algodón y logo VLTN de efecto engomado cruzando el empeine, forro en cuero y suela de caucho con dibujo texturizado. Fabricado en Italia. Un diseño statement con identidad propia, para quien busca que cada paso hable por sí mismo.', 3500000.00, 'Valentino Garavani', 1, 0, NULL),
(65, 2, 'Bota Under Armour Micro G Valsetz Mid Hombre Color: Verde Oliva-Negro', 'Bota táctica/outdoor de caña media, con capellada sintética transpirable en malla textil, refuerzos de poliuretano en las zonas de mayor desgaste, y suela de caucho. La línea Micro G suma amortiguación extra a una de las botas tácticas más duraderas de la marca. Resistencia y confort para quienes no se detienen ante ningún terreno.', 690000.00, 'Under Armour', 1, 0, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resenas`
--

CREATE TABLE `resenas` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `calificacion` int(11) NOT NULL,
  `comentario` text DEFAULT NULL,
  `fecha` datetime DEFAULT current_timestamp()
) ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `cedula` varchar(20) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `correo` varchar(150) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `cedula`, `nombre`, `apellido`, `correo`, `password_hash`, `telefono`, `fecha_registro`) VALUES
(1, '1030536475', 'John Alejandro', 'Celis Cifuentes', 'alejocc.magno2005@gmail.com', '$2y$10$1LbafmPDvkddrmu8p9pi.u81zyY58FOgYxy3y0AFuy8vrT3TZZBFe', '3214042824', '2026-09-21 17:26:37');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `variantes_producto`
--

CREATE TABLE `variantes_producto` (
  `id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `talla` varchar(10) DEFAULT NULL,
  `color` varchar(20) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `sku` varchar(50) DEFAULT NULL,
  `color_hex` varchar(7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `variantes_producto`
--

INSERT INTO `variantes_producto` (`id`, `producto_id`, `talla`, `color`, `stock`, `sku`, `color_hex`) VALUES
(1, 1, NULL, 'Negro/Verde', 15, 'TEC-CONSOLA-001', '#22c55e'),
(2, 2, NULL, 'Negro', 10, 'TEC-TECLADO-001', '#1a1a1a'),
(3, 3, NULL, 'Blanco', 15, 'TEC-COMBOGMR-001', '#f5f5f5'),
(4, 4, NULL, 'Negro', 15, 'TEC-MOUSE-001', '#1a1a1a'),
(5, 5, NULL, 'Gris', 15, 'TEC-MOUSE-002', '#9ca3af'),
(6, 6, NULL, 'Negro', 15, 'TEC-PWBANK-20K', '#1a1a1a'),
(7, 7, NULL, 'Negro', 15, 'TEC-PWBANK-10K', '#1a1a1a'),
(8, 8, NULL, 'Blanco', 14, 'TEC-PWBANK-5K', '#f5f5f5'),
(9, 9, NULL, 'Negro', 15, 'TEC-MICROFONO-001', '#1a1a1a'),
(10, 10, NULL, 'Negro', 15, 'TEC-SOPORTEMOTO-001', '#1a1a1a'),
(11, 11, NULL, 'Negro', 15, 'TEC-SOPORTEMOTO-002', '#1a1a1a'),
(12, 12, NULL, 'Negro', 15, 'TEC-SOPORTEMOTO-003', '#1a1a1a'),
(13, 13, NULL, 'Negro', 15, 'TEC-HOLDERCARRO-001', '#1a1a1a'),
(14, 14, NULL, 'Negro', 15, 'TEC-HOLDERCARRO-002', '#1a1a1a'),
(15, 15, NULL, 'Negro', 15, 'TEC-CARGADOR-001', '#1a1a1a'),
(16, 16, NULL, 'Negro', 15, 'TEC-CARGADOR-002', '#1a1a1a'),
(17, 17, NULL, 'Negro', 15, 'TEC-CARGADOR-003', '#1a1a1a'),
(18, 18, NULL, 'Negro', 15, 'TEC-CARGADOR-004', '#1a1a1a'),
(19, 19, NULL, 'Negro', 15, 'TEC-PULIN-001', '#1a1a1a'),
(20, 20, NULL, 'Negro', 15, 'TEC-PULIN-002', '#1a1a1a'),
(21, 21, NULL, 'Negro', 15, 'TEC-PARLANTE-001', '#1a1a1a'),
(22, 22, NULL, 'Negro', 15, 'TEC-PARLANTE-002', '#1a1a1a'),
(23, 23, NULL, 'Negro', 15, 'TEC-PARLANTE-003', '#1a1a1a'),
(24, 24, NULL, 'Negro', 15, 'TEC-PARLANTE-004', '#1a1a1a'),
(25, 25, NULL, 'Verde/Rojo', 15, 'TEC-PARLANTE-005', '#dc2626'),
(26, 26, NULL, 'Negro', 15, 'TEC-MANOSLIBRES-001', '#1a1a1a'),
(27, 27, NULL, 'Negro', 15, 'TEC-MANOSLIBRES-002', '#1a1a1a'),
(28, 28, NULL, 'Negro', 15, 'TEC-CUELLERA-001', '#1a1a1a'),
(29, 29, NULL, 'Gris', 15, 'TEC-DIADEMA-001', '#9ca3af'),
(30, 30, NULL, 'Plateado', 15, 'TEC-DIADEMA-002', '#c0c0c0'),
(31, 31, NULL, 'Negro/Rojo', 15, 'TEC-DIADEMA-003', '#1e293b'),
(32, 32, NULL, 'Purpura', 15, 'TEC-DIADEMA-004', '#7c3aed'),
(33, 33, NULL, 'Negro', 15, 'TEC-DIADEMA-005', '#1a1a1a'),
(34, 34, NULL, 'Azul/Negro', 15, 'TEC-DIADEMA-006', '#1e3a8a'),
(35, 35, NULL, 'Blanco/Plateado', 15, 'TEC-BALACA-001', '#f8fafc'),
(36, 36, NULL, 'Negro', 15, 'TEC-MANOSLIBRES-003', '#1a1a1a'),
(37, 37, NULL, 'Blanco', 15, 'TEC-PROYECTOR-001', '#f5f5f5'),
(38, 38, NULL, 'Negro', 15, 'TEC-TVSTICK-001', '#1a1a1a'),
(39, 39, NULL, 'Negro', 15, 'TEC-WATCHTV-001', '#1a1a1a'),
(40, 40, NULL, 'Negro', 15, 'TEC-FUNDAIPHONE-001', '#1a1a1a'),
(41, 41, NULL, 'Negro', 15, 'TEC-FUNDAANDROID-001', '#1a1a1a'),
(42, 42, NULL, 'Negro', 15, 'TEC-FUNDAANDROID-002', '#1a1a1a'),
(43, 43, NULL, 'Negro', 15, 'TEC-PROTAIRPODS-001', '#1a1a1a'),
(44, 44, NULL, 'Negro', 15, 'TEC-PROTCARGADOR-001', '#1a1a1a'),
(45, 45, NULL, 'Negro', 15, 'TEC-ANTENA-001', '#1a1a1a'),
(46, 46, NULL, 'Negro', 15, 'TEC-CODIFICADOR-001', '#1a1a1a'),
(47, 47, NULL, 'Plantas', 8, 'HOG-SABANA-PLANTAS', '#84cc16'),
(48, 47, NULL, 'Triangulo', 10, 'HOG-SABANA-TRIANGULO', '#3b82f6'),
(49, 47, NULL, 'Gris Floral', 10, 'HOG-SABANA-GRISFLORAL', '#9ca3af'),
(50, 47, NULL, 'Estrellas', 10, 'HOG-SABANA-ESTRELLAS', '#1e1e2e'),
(51, 47, NULL, 'Goteras', 10, 'HOG-SABANA-GOTERAS', '#fbbf24'),
(52, 47, NULL, 'Pastel', 10, 'HOG-SABANA-PASTEL', '#f9a8d4'),
(53, 47, NULL, 'Pecas', 10, 'HOG-SABANA-PECAS', '#fde68a'),
(54, 48, 'S', 'Negro', 5, 'ROP-CONJDEP-NEGRO-S', '#1a1a1a'),
(55, 48, 'M', 'Negro', 5, 'ROP-CONJDEP-NEGRO-M', '#1a1a1a'),
(56, 48, 'L', 'Negro', 5, 'ROP-CONJDEP-NEGRO-L', '#1a1a1a'),
(57, 48, 'XL', 'Negro', 5, 'ROP-CONJDEP-NEGRO-XL', '#1a1a1a'),
(58, 48, 'S', 'Gris', 5, 'ROP-CONJDEP-GRIS-S', '#9ca3af'),
(59, 48, 'M', 'Gris', 5, 'ROP-CONJDEP-GRIS-M', '#9ca3af'),
(60, 48, 'L', 'Gris', 5, 'ROP-CONJDEP-GRIS-L', '#9ca3af'),
(61, 48, 'XL', 'Gris', 5, 'ROP-CONJDEP-GRIS-XL', '#9ca3af'),
(62, 48, 'S', 'Beige', 5, 'ROP-CONJDEP-BEIGE-S', '#e8dcc8'),
(63, 48, 'M', 'Beige', 5, 'ROP-CONJDEP-BEIGE-M', '#e8dcc8'),
(64, 48, 'L', 'Beige', 5, 'ROP-CONJDEP-BEIGE-L', '#e8dcc8'),
(65, 48, 'XL', 'Beige', 5, 'ROP-CONJDEP-BEIGE-XL', '#e8dcc8'),
(66, 48, 'S', 'Azul', 5, 'ROP-CONJDEP-AZUL-S', '#2563eb'),
(67, 48, 'M', 'Azul', 5, 'ROP-CONJDEP-AZUL-M', '#2563eb'),
(68, 48, 'L', 'Azul', 5, 'ROP-CONJDEP-AZUL-L', '#2563eb'),
(69, 48, 'XL', 'Azul', 5, 'ROP-CONJDEP-AZUL-XL', '#2563eb'),
(70, 49, 'S', 'Negro', 5, 'ROP-CONJDEP2-NEGRO-S', '#1a1a1a'),
(71, 49, 'M', 'Negro', 5, 'ROP-CONJDEP2-NEGRO-M', '#1a1a1a'),
(72, 49, 'L', 'Negro', 5, 'ROP-CONJDEP2-NEGRO-L', '#1a1a1a'),
(73, 49, 'XL', 'Negro', 5, 'ROP-CONJDEP2-NEGRO-XL', '#1a1a1a'),
(74, 49, 'S', 'Azul-marino', 5, 'ROP-CONJDEP2-AZULMARINO-S', '#1e3a5f'),
(75, 49, 'M', 'Azul-marino', 5, 'ROP-CONJDEP2-AZULMARINO-M', '#1e3a5f'),
(76, 49, 'L', 'Azul-marino', 5, 'ROP-CONJDEP2-AZULMARINO-L', '#1e3a5f'),
(77, 49, 'XL', 'Azul-marino', 5, 'ROP-CONJDEP2-AZULMARINO-XL', '#1e3a5f'),
(78, 49, 'S', 'Beige', 5, 'ROP-CONJDEP2-BEIGE-S', '#e8dcc8'),
(79, 49, 'M', 'Beige', 5, 'ROP-CONJDEP2-BEIGE-M', '#e8dcc8'),
(80, 49, 'L', 'Beige', 5, 'ROP-CONJDEP2-BEIGE-L', '#e8dcc8'),
(81, 49, 'XL', 'Beige', 5, 'ROP-CONJDEP2-BEIGE-XL', '#e8dcc8'),
(82, 50, 'S', 'Negro', 5, 'ROP-CONJDEP2-NEGRO-S', '#1a1a1a'),
(83, 50, 'M', 'Negro', 5, 'ROP-CONJDEP2-NEGRO-M', '#1a1a1a'),
(84, 50, 'L', 'Negro', 5, 'ROP-CONJDEP2-NEGRO-L', '#1a1a1a'),
(85, 50, 'XL', 'Negro', 5, 'ROP-CONJDEP2-NEGRO-XL', '#1a1a1a'),
(86, 50, 'S', 'Azul-marino', 5, 'ROP-CONJDEP2-AZULMARINO-S', '#1e3a5f'),
(87, 50, 'M', 'Azul-marino', 5, 'ROP-CONJDEP2-AZULMARINO-M', '#1e3a5f'),
(88, 50, 'L', 'Azul-marino', 5, 'ROP-CONJDEP2-AZULMARINO-L', '#1e3a5f'),
(89, 50, 'XL', 'Azul-marino', 5, 'ROP-CONJDEP2-AZULMARINO-XL', '#1e3a5f'),
(90, 50, 'S', 'Beige', 5, 'ROP-CONJDEP2-BEIGE-S', '#e8dcc8'),
(91, 50, 'M', 'Beige', 5, 'ROP-CONJDEP2-BEIGE-M', '#e8dcc8'),
(92, 50, 'L', 'Beige', 5, 'ROP-CONJDEP2-BEIGE-L', '#e8dcc8'),
(93, 50, 'XL', 'Beige', 5, 'ROP-CONJDEP2-BEIGE-XL', '#e8dcc8'),
(94, 51, 'XS', 'VerdeMenta', 5, 'ROP-CONJMUJ-VERDEMENTA-XS', '#3ec9a7'),
(95, 51, 'S', 'VerdeMenta', 5, 'ROP-CONJMUJ-VERDEMENTA-S', '#3ec9a7'),
(96, 51, 'M', 'VerdeMenta', 5, 'ROP-CONJMUJ-VERDEMENTA-M', '#3ec9a7'),
(97, 51, 'L', 'VerdeMenta', 5, 'ROP-CONJMUJ-VERDEMENTA-L', '#3ec9a7'),
(98, 51, 'XS', 'Negro-Azul', 5, 'ROP-CONJMUJ-NEGROAZUL-XS', '#1a2a4a'),
(99, 51, 'S', 'Negro-Azul', 5, 'ROP-CONJMUJ-NEGROAZUL-S', '#1a2a4a'),
(100, 51, 'M', 'Negro-Azul', 5, 'ROP-CONJMUJ-NEGROAZUL-M', '#1a2a4a'),
(101, 51, 'L', 'Negro-Azul', 5, 'ROP-CONJMUJ-NEGROAZUL-L', '#1a2a4a'),
(102, 51, 'XS', 'Coral', 5, 'ROP-CONJMUJ-CORAL-XS', '#ff6f5e'),
(103, 51, 'S', 'Coral', 5, 'ROP-CONJMUJ-CORAL-S', '#ff6f5e'),
(104, 51, 'M', 'Coral', 5, 'ROP-CONJMUJ-CORAL-M', '#ff6f5e'),
(105, 51, 'L', 'Coral', 5, 'ROP-CONJMUJ-CORAL-L', '#ff6f5e'),
(106, 52, 'XS', 'Lila', 5, 'ROP-CONJMUJ3-LILA-XS', '#c8a2c8'),
(107, 52, 'S', 'Lila', 5, 'ROP-CONJMUJ3-LILA-S', '#c8a2c8'),
(108, 52, 'M', 'Lila', 5, 'ROP-CONJMUJ3-LILA-M', '#c8a2c8'),
(109, 52, 'L', 'Lila', 5, 'ROP-CONJMUJ3-LILA-L', '#c8a2c8'),
(110, 52, 'XS', 'Gris', 5, 'ROP-CONJMUJ3-GRIS-XS', '#9ca3af'),
(111, 52, 'S', 'Gris', 5, 'ROP-CONJMUJ3-GRIS-S', '#9ca3af'),
(112, 52, 'M', 'Gris', 5, 'ROP-CONJMUJ3-GRIS-M', '#9ca3af'),
(113, 52, 'L', 'Gris', 5, 'ROP-CONJMUJ3-GRIS-L', '#9ca3af'),
(114, 52, 'XS', 'Blanco', 5, 'ROP-CONJMUJ3-BLANCO-XS', '#f5f5f5'),
(115, 52, 'S', 'Blanco', 5, 'ROP-CONJMUJ3-BLANCO-S', '#f5f5f5'),
(116, 52, 'M', 'Blanco', 5, 'ROP-CONJMUJ3-BLANCO-M', '#f5f5f5'),
(117, 52, 'L', 'Blanco', 5, 'ROP-CONJMUJ3-BLANCO-L', '#f5f5f5'),
(118, 52, 'XS', 'Beige', 5, 'ROP-CONJMUJ3-BEIGE-XS', '#e8dcc8'),
(119, 52, 'S', 'Beige', 5, 'ROP-CONJMUJ3-BEIGE-S', '#e8dcc8'),
(120, 52, 'M', 'Beige', 5, 'ROP-CONJMUJ3-BEIGE-M', '#e8dcc8'),
(121, 52, 'L', 'Beige', 5, 'ROP-CONJMUJ3-BEIGE-L', '#e8dcc8'),
(122, 52, 'XS', 'Azul', 5, 'ROP-CONJMUJ3-AZUL-XS', '#2563eb'),
(123, 52, 'S', 'Azul', 5, 'ROP-CONJMUJ3-AZUL-S', '#2563eb'),
(124, 52, 'M', 'Azul', 5, 'ROP-CONJMUJ3-AZUL-M', '#2563eb'),
(125, 52, 'L', 'Azul', 5, 'ROP-CONJMUJ3-AZUL-L', '#2563eb'),
(126, 52, 'XS', 'Negro', 5, 'ROP-CONJMUJ3-NEGRO-XS', '#1a1a1a'),
(127, 52, 'S', 'Negro', 5, 'ROP-CONJMUJ3-NEGRO-S', '#1a1a1a'),
(128, 52, 'M', 'Negro', 5, 'ROP-CONJMUJ3-NEGRO-M', '#1a1a1a'),
(129, 52, 'L', 'Negro', 5, 'ROP-CONJMUJ3-NEGRO-L', '#1a1a1a'),
(130, 52, 'XS', 'VerdeMenta', 5, 'ROP-CONJMUJ3-VERDEMENTA-XS', '#3ec9a7'),
(131, 52, 'S', 'VerdeMenta', 5, 'ROP-CONJMUJ3-VERDEMENTA-S', '#3ec9a7'),
(132, 52, 'M', 'VerdeMenta', 5, 'ROP-CONJMUJ3-VERDEMENTA-M', '#3ec9a7'),
(133, 52, 'L', 'VerdeMenta', 5, 'ROP-CONJMUJ3-VERDEMENTA-L', '#3ec9a7'),
(134, 53, 'S', 'Azul-Beige', 5, 'ROP-CONJHOM3-AZULBEIGE-S', '#5b7fa6'),
(135, 53, 'M', 'Azul-Beige', 5, 'ROP-CONJHOM3-AZULBEIGE-M', '#5b7fa6'),
(136, 53, 'L', 'Azul-Beige', 5, 'ROP-CONJHOM3-AZULBEIGE-L', '#5b7fa6'),
(137, 53, 'XL', 'Azul-Beige', 5, 'ROP-CONJHOM3-AZULBEIGE-XL', '#5b7fa6'),
(138, 53, 'S', 'Verde-Gris', 5, 'ROP-CONJHOM3-VERDEGRIS-S', '#5f7d6e'),
(139, 53, 'M', 'Verde-Gris', 5, 'ROP-CONJHOM3-VERDEGRIS-M', '#5f7d6e'),
(140, 53, 'L', 'Verde-Gris', 5, 'ROP-CONJHOM3-VERDEGRIS-L', '#5f7d6e'),
(141, 53, 'XL', 'Verde-Gris', 5, 'ROP-CONJHOM3-VERDEGRIS-XL', '#5f7d6e'),
(142, 53, 'S', 'Negro-Marron', 5, 'ROP-CONJHOM3-NEGROMARRON-S', '#4a3527'),
(143, 53, 'M', 'Negro-Marron', 5, 'ROP-CONJHOM3-NEGROMARRON-M', '#4a3527'),
(144, 53, 'L', 'Negro-Marron', 5, 'ROP-CONJHOM3-NEGROMARRON-L', '#4a3527'),
(145, 53, 'XL', 'Negro-Marron', 5, 'ROP-CONJHOM3-NEGROMARRON-XL', '#4a3527'),
(146, 53, 'S', 'Roja-Balnco', 5, 'ROP-CONJHOM3-ROJABLANCO-S', '#c23b3b'),
(147, 53, 'M', 'Roja-Balnco', 5, 'ROP-CONJHOM3-ROJABLANCO-M', '#c23b3b'),
(148, 53, 'L', 'Roja-Balnco', 5, 'ROP-CONJHOM3-ROJABLANCO-L', '#c23b3b'),
(149, 53, 'XL', 'Roja-Balnco', 5, 'ROP-CONJHOM3-ROJABLANCO-XL', '#c23b3b'),
(150, 53, 'S', 'Azul-Blanco', 5, 'ROP-CONJHOM3-AZULBLANCO-S', '#2c4a6e'),
(151, 53, 'M', 'Azul-Blanco', 5, 'ROP-CONJHOM3-AZULBLANCO-M', '#2c4a6e'),
(152, 53, 'L', 'Azul-Blanco', 5, 'ROP-CONJHOM3-AZULBLANCO-L', '#2c4a6e'),
(153, 53, 'XL', 'Azul-Blanco', 5, 'ROP-CONJHOM3-AZULBLANCO-XL', '#2c4a6e'),
(154, 54, '38', 'Negro-Blanco', 5, 'ROP-LVSKATE-38', '#1a1a1a'),
(155, 54, '39', 'Negro-Blanco', 5, 'ROP-LVSKATE-39', '#1a1a1a'),
(156, 54, '40', 'Negro-Blanco', 5, 'ROP-LVSKATE-40', '#1a1a1a'),
(157, 54, '41', 'Negro-Blanco', 5, 'ROP-LVSKATE-41', '#1a1a1a'),
(158, 54, '42', 'Negro-Blanco', 5, 'ROP-LVSKATE-42', '#1a1a1a'),
(159, 55, '38', 'Azul-Blanco', 5, 'ROP-LVTRAINER-38', '#2c4a6e'),
(160, 55, '39', 'Azul-Blanco', 5, 'ROP-LVTRAINER-39', '#2c4a6e'),
(161, 55, '40', 'Azul-Blanco', 5, 'ROP-LVTRAINER-40', '#2c4a6e'),
(162, 55, '41', 'Azul-Blanco', 5, 'ROP-LVTRAINER-41', '#2c4a6e'),
(163, 55, '42', 'Azul-Blanco', 5, 'ROP-LVTRAINER-42', '#2c4a6e'),
(164, 56, '36', 'Blanco-Negro', 5, 'ROP-LVARCHLIGHT-36', '#f5f5f5'),
(165, 56, '37', 'Blanco-Negro', 5, 'ROP-LVARCHLIGHT-37', '#f5f5f5'),
(166, 56, '38', 'Blanco-Negro', 5, 'ROP-LVARCHLIGHT-38', '#f5f5f5'),
(167, 56, '39', 'Blanco-Negro', 5, 'ROP-LVARCHLIGHT-39', '#f5f5f5'),
(168, 56, '40', 'Blanco-Negro', 5, 'ROP-LVARCHLIGHT-40', '#f5f5f5'),
(169, 57, '38', 'Azul-Blanco', 5, 'ROP-HOKACLIFTON9-38', '#2563eb'),
(170, 57, '39', 'Azul-Blanco', 5, 'ROP-HOKACLIFTON9-39', '#2563eb'),
(171, 57, '40', 'Azul-Blanco', 5, 'ROP-HOKACLIFTON9-40', '#2563eb'),
(172, 57, '41', 'Azul-Blanco', 5, 'ROP-HOKACLIFTON9-41', '#2563eb'),
(173, 57, '42', 'Azul-Blanco', 5, 'ROP-HOKACLIFTON9-42', '#2563eb'),
(174, 58, '38', 'Gris-Azul', 5, 'ROP-HOKABONDI9H-38', '#9ca3af'),
(175, 58, '39', 'Gris-Azul', 5, 'ROP-HOKABONDI9H-39', '#9ca3af'),
(176, 58, '40', 'Gris-Azul', 5, 'ROP-HOKABONDI9H-40', '#9ca3af'),
(177, 58, '41', 'Gris-Azul', 5, 'ROP-HOKABONDI9H-41', '#9ca3af'),
(178, 58, '42', 'Gris-Azul', 5, 'ROP-HOKABONDI9H-42', '#9ca3af'),
(179, 59, '36', 'Blanco Crema-Negro', 5, 'ROP-HOKABONDI9M-36', '#f0ead6'),
(180, 59, '37', 'Blanco Crema-Negro', 5, 'ROP-HOKABONDI9M-37', '#f0ead6'),
(181, 59, '38', 'Blanco Crema-Negro', 5, 'ROP-HOKABONDI9M-38', '#f0ead6'),
(182, 59, '39', 'Blanco Crema-Negro', 5, 'ROP-HOKABONDI9M-39', '#f0ead6'),
(183, 59, '40', 'Blanco Crema-Negro', 5, 'ROP-HOKABONDI9M-40', '#f0ead6'),
(184, 60, '38', 'Negro-Gris Oscuro', 5, 'ROP-HOKABONDI-38', '#2b2b2b'),
(185, 60, '39', 'Negro-Gris Oscuro', 5, 'ROP-HOKABONDI-39', '#2b2b2b'),
(186, 60, '40', 'Negro-Gris Oscuro', 5, 'ROP-HOKABONDI-40', '#2b2b2b'),
(187, 60, '41', 'Negro-Gris Oscuro', 5, 'ROP-HOKABONDI-41', '#2b2b2b'),
(188, 60, '42', 'Negro-Gris Oscuro', 5, 'ROP-HOKABONDI-42', '#2b2b2b'),
(189, 61, '36', 'Negro-Gris Oscuro', 5, 'ROP-SKGOWALK-36', '#1a1a1a'),
(190, 61, '37', 'Negro-Gris Oscuro', 5, 'ROP-SKGOWALK-37', '#1a1a1a'),
(191, 61, '38', 'Negro-Gris Oscuro', 5, 'ROP-SKGOWALK-38', '#1a1a1a'),
(192, 61, '39', 'Negro-Gris Oscuro', 5, 'ROP-SKGOWALK-39', '#1a1a1a'),
(193, 61, '40', 'Negro-Gris Oscuro', 5, 'ROP-SKGOWALK-40', '#1a1a1a'),
(194, 62, '38', 'Blanco-Gris Claro', 5, 'ROP-VALENTINOONESTUD-38', '#f5f5f5'),
(195, 62, '39', 'Blanco-Gris Claro', 5, 'ROP-VALENTINOONESTUD-39', '#f5f5f5'),
(196, 62, '40', 'Blanco-Gris Claro', 5, 'ROP-VALENTINOONESTUD-40', '#f5f5f5'),
(197, 62, '41', 'Blanco-Gris Claro', 5, 'ROP-VALENTINOONESTUD-41', '#f5f5f5'),
(198, 62, '42', 'Blanco-Gris Claro', 5, 'ROP-VALENTINOONESTUD-42', '#f5f5f5'),
(199, 63, '38', 'Blanco-Azul Marino', 5, 'ROP-VALENTINOOPEN-38', '#f5f5f5'),
(200, 63, '39', 'Blanco-Azul Marino', 5, 'ROP-VALENTINOOPEN-39', '#f5f5f5'),
(201, 63, '40', 'Blanco-Azul Marino', 5, 'ROP-VALENTINOOPEN-40', '#f5f5f5'),
(202, 63, '41', 'Blanco-Azul Marino', 5, 'ROP-VALENTINOOPEN-41', '#f5f5f5'),
(203, 63, '42', 'Blanco-Azul Marino', 5, 'ROP-VALENTINOOPEN-42', '#f5f5f5'),
(204, 64, '38', 'Negro-Blanco', 5, 'ROP-VALENTINOVL7N-38', '#1a1a1a'),
(205, 64, '39', 'Negro-Blanco', 5, 'ROP-VALENTINOVL7N-39', '#1a1a1a'),
(206, 64, '40', 'Negro-Blanco', 5, 'ROP-VALENTINOVL7N-40', '#1a1a1a'),
(207, 64, '41', 'Negro-Blanco', 5, 'ROP-VALENTINOVL7N-41', '#1a1a1a'),
(208, 64, '42', 'Negro-Blanco', 5, 'ROP-VALENTINOVL7N-42', '#1a1a1a'),
(209, 65, '38', 'Verde Oliva-Negro', 5, 'ROP-UAVALSETZ-38', '#6b6e3f'),
(210, 65, '39', 'Verde Oliva-Negro', 5, 'ROP-UAVALSETZ-39', '#6b6e3f'),
(211, 65, '40', 'Verde Oliva-Negro', 5, 'ROP-UAVALSETZ-40', '#6b6e3f'),
(212, 65, '41', 'Verde Oliva-Negro', 5, 'ROP-UAVALSETZ-41', '#6b6e3f'),
(213, 65, '42', 'Verde Oliva-Negro', 5, 'ROP-UAVALSETZ-42', '#6b6e3f');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carritos`
--
ALTER TABLE `carritos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalle_factura`
--
ALTER TABLE `detalle_factura`
  ADD PRIMARY KEY (`id`),
  ADD KEY `factura_id` (`factura_id`),
  ADD KEY `variante_id` (`variante_id`);

--
-- Indices de la tabla `direcciones_envio`
--
ALTER TABLE `direcciones_envio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `estados_pedido`
--
ALTER TABLE `estados_pedido`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `direccion_envio_id` (`direccion_envio_id`),
  ADD KEY `metodo_pago_id` (`metodo_pago_id`),
  ADD KEY `estado_id` (`estado_id`);

--
-- Indices de la tabla `imagenes_producto`
--
ALTER TABLE `imagenes_producto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `producto_id` (`producto_id`),
  ADD KEY `variante_id` (`variante_id`);

--
-- Indices de la tabla `items_carrito`
--
ALTER TABLE `items_carrito`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carrito_id` (`carrito_id`),
  ADD KEY `variante_id` (`variante_id`);

--
-- Indices de la tabla `metodos_pago`
--
ALTER TABLE `metodos_pago`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoria_id` (`categoria_id`);

--
-- Indices de la tabla `resenas`
--
ALTER TABLE `resenas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- Indices de la tabla `variantes_producto`
--
ALTER TABLE `variantes_producto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carritos`
--
ALTER TABLE `carritos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=302;

--
-- AUTO_INCREMENT de la tabla `detalle_factura`
--
ALTER TABLE `detalle_factura`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `direcciones_envio`
--
ALTER TABLE `direcciones_envio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `estados_pedido`
--
ALTER TABLE `estados_pedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `facturas`
--
ALTER TABLE `facturas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `imagenes_producto`
--
ALTER TABLE `imagenes_producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT de la tabla `items_carrito`
--
ALTER TABLE `items_carrito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `metodos_pago`
--
ALTER TABLE `metodos_pago`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT de la tabla `resenas`
--
ALTER TABLE `resenas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `variantes_producto`
--
ALTER TABLE `variantes_producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=214;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carritos`
--
ALTER TABLE `carritos`
  ADD CONSTRAINT `carritos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `detalle_factura`
--
ALTER TABLE `detalle_factura`
  ADD CONSTRAINT `detalle_factura_ibfk_1` FOREIGN KEY (`factura_id`) REFERENCES `facturas` (`id`),
  ADD CONSTRAINT `detalle_factura_ibfk_2` FOREIGN KEY (`variante_id`) REFERENCES `variantes_producto` (`id`);

--
-- Filtros para la tabla `direcciones_envio`
--
ALTER TABLE `direcciones_envio`
  ADD CONSTRAINT `direcciones_envio_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD CONSTRAINT `facturas_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `facturas_ibfk_2` FOREIGN KEY (`direccion_envio_id`) REFERENCES `direcciones_envio` (`id`),
  ADD CONSTRAINT `facturas_ibfk_3` FOREIGN KEY (`metodo_pago_id`) REFERENCES `metodos_pago` (`id`),
  ADD CONSTRAINT `facturas_ibfk_4` FOREIGN KEY (`estado_id`) REFERENCES `estados_pedido` (`id`);

--
-- Filtros para la tabla `imagenes_producto`
--
ALTER TABLE `imagenes_producto`
  ADD CONSTRAINT `imagenes_producto_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`),
  ADD CONSTRAINT `imagenes_producto_ibfk_2` FOREIGN KEY (`variante_id`) REFERENCES `variantes_producto` (`id`);

--
-- Filtros para la tabla `items_carrito`
--
ALTER TABLE `items_carrito`
  ADD CONSTRAINT `items_carrito_ibfk_1` FOREIGN KEY (`carrito_id`) REFERENCES `carritos` (`id`),
  ADD CONSTRAINT `items_carrito_ibfk_2` FOREIGN KEY (`variante_id`) REFERENCES `variantes_producto` (`id`);

--
-- Filtros para la tabla `metodos_pago`
--
ALTER TABLE `metodos_pago`
  ADD CONSTRAINT `metodos_pago_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`);

--
-- Filtros para la tabla `resenas`
--
ALTER TABLE `resenas`
  ADD CONSTRAINT `resenas_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `resenas_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`);

--
-- Filtros para la tabla `variantes_producto`
--
ALTER TABLE `variantes_producto`
  ADD CONSTRAINT `variantes_producto_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
