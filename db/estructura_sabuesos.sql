-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 04-05-2023 a las 17:35:26
-- Versión del servidor: 10.5.19-MariaDB-cll-lve
-- Versión de PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `u765647919_sabuesos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito_cuenta`
--

CREATE TABLE `carrito_cuenta` (
  `idcarrito_cuenta` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `idcliente` int(11) NOT NULL,
  `idproducto` int(11) NOT NULL,
  `idlocal` int(11) NOT NULL,
  `numero_factura` varchar(1000) NOT NULL,
  `fecha` date NOT NULL,
  `fecha_vencimiento` date NOT NULL,
  `mes` varchar(100) NOT NULL,
  `año` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `descuento` decimal(10,0) NOT NULL,
  `precio_producto` decimal(10,0) NOT NULL,
  `subtotal` decimal(10,0) NOT NULL,
  `total` decimal(10,0) NOT NULL,
  `mediodepago` varchar(200) NOT NULL,
  `tipoventa` varchar(100) NOT NULL,
  `mi_precio` decimal(10,0) NOT NULL,
  `total_compra` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `idcliente` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `direccion` varchar(200) NOT NULL,
  `celular` varchar(25) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  `cuit` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `idcompra` int(11) NOT NULL,
  `idproducto` int(11) NOT NULL,
  `idproveedor` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `numero_factura` varchar(21) NOT NULL,
  `fecha_compra` date NOT NULL,
  `cantidad` int(11) NOT NULL,
  `sub_total` float NOT NULL,
  `descuento` float NOT NULL,
  `total` float NOT NULL,
  `importe` float NOT NULL,
  `idlocal` int(11) NOT NULL,
  `idcaja` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE `configuracion` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `direccion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuentas`
--

CREATE TABLE `cuentas` (
  `idcuenta` int(11) NOT NULL,
  `numero_factura` text NOT NULL,
  `idcliente` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `cantidad` int(11) NOT NULL,
  `tipo_cuenta` varchar(100) NOT NULL,
  `total` decimal(10,0) NOT NULL,
  `observaciones` varchar(400) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `idlocal` int(11) NOT NULL,
  `total_inicio` decimal(10,0) NOT NULL,
  `idcaja` int(11) NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuenta_corrientes`
--

CREATE TABLE `cuenta_corrientes` (
  `idcuenta_corrientes` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `fecha_vencimiento` date NOT NULL,
  `numero_factura` varchar(1000) NOT NULL,
  `idcliente` int(11) NOT NULL,
  `estado` varchar(100) NOT NULL,
  `gran_total` decimal(10,0) NOT NULL,
  `restante` decimal(10,0) NOT NULL,
  `cantidad_recibida` decimal(10,0) NOT NULL,
  `mes` varchar(100) NOT NULL,
  `año` int(11) NOT NULL,
  `observaciones` varchar(300) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `idlocal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuotas`
--

CREATE TABLE `cuotas` (
  `idcuota` int(11) NOT NULL,
  `idcuenta` int(11) NOT NULL,
  `numero_factura` varchar(21) NOT NULL,
  `fecha` date NOT NULL,
  `cuota` int(11) NOT NULL,
  `importe` decimal(10,0) NOT NULL,
  `saldo` decimal(10,0) NOT NULL,
  `descuento` decimal(10,0) NOT NULL,
  `total` decimal(10,0) NOT NULL,
  `condicion` varchar(100) NOT NULL,
  `mediodepago` varchar(200) NOT NULL,
  `idusuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_permisos`
--

CREATE TABLE `detalle_permisos` (
  `id` int(11) NOT NULL,
  `id_permiso` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `idfactura` int(11) NOT NULL,
  `idcliente` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `idlocal` int(11) NOT NULL,
  `numero_factura` float NOT NULL,
  `total` float NOT NULL,
  `descuento` float NOT NULL,
  `interes` float NOT NULL,
  `importe` float NOT NULL,
  `cambio` float NOT NULL,
  `fecha` date NOT NULL,
  `mes` varchar(50) NOT NULL,
  `año` int(11) NOT NULL,
  `mediopago` varchar(100) NOT NULL,
  `tipoventa` varchar(70) NOT NULL,
  `observacion` varchar(500) NOT NULL,
  `idvendedor` int(11) NOT NULL,
  `idcaja` int(11) NOT NULL,
  `tipoFactura` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gastos`
--

CREATE TABLE `gastos` (
  `idgastos` int(11) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `importe` decimal(10,0) NOT NULL,
  `fecha` date NOT NULL,
  `idusuario` int(11) NOT NULL,
  `idlocal` int(11) NOT NULL,
  `idcaja` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lista`
--

CREATE TABLE `lista` (
  `idlista` int(11) NOT NULL,
  `rubro` varchar(100) NOT NULL,
  `marca` varchar(100) NOT NULL,
  `orden` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lista_productos`
--

CREATE TABLE `lista_productos` (
  `idlista` int(11) NOT NULL,
  `idproducto` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `locales`
--

CREATE TABLE `locales` (
  `idlocal` int(11) NOT NULL,
  `nombre_local` varchar(150) NOT NULL,
  `direccion_local` varchar(150) NOT NULL,
  `celular_local` varchar(25) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `estado` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

CREATE TABLE `marcas` (
  `idmarca` int(11) NOT NULL,
  `nombre_marca` varchar(200) NOT NULL,
  `detalle` varchar(200) NOT NULL,
  `idrubro` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos_cuenta`
--

CREATE TABLE `pagos_cuenta` (
  `idpagos_cuenta` int(11) NOT NULL,
  `idcuenta_corriente` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `numero_factura` int(11) NOT NULL,
  `monto_factura` decimal(10,0) NOT NULL,
  `recibido_antes` decimal(10,0) NOT NULL,
  `recibido_ahora` decimal(10,0) NOT NULL,
  `saldo` decimal(10,0) NOT NULL,
  `mes` varchar(100) NOT NULL,
  `año` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `idpedidos` int(11) NOT NULL,
  `idproducto` int(11) NOT NULL,
  `idpreventista` int(11) NOT NULL,
  `cantidad_pedido` int(11) NOT NULL,
  `total_pedido` float NOT NULL,
  `fecha_pedido` date NOT NULL,
  `fecha_entrega` date NOT NULL,
  `idcliente` int(11) NOT NULL,
  `condicion` varchar(150) NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preventista`
--

CREATE TABLE `preventista` (
  `idpreventista` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `detalle` int(11) NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `idproducto` int(11) NOT NULL,
  `codigo_producto` varchar(21) NOT NULL,
  `nombre_producto` varchar(250) NOT NULL,
  `mi_precio` decimal(10,0) NOT NULL,
  `porcentaje_menor` float NOT NULL,
  `porcentaje_mayor` float NOT NULL,
  `precio_producto` decimal(10,0) NOT NULL,
  `stock_producto` int(11) NOT NULL,
  `unidad_producto` varchar(100) NOT NULL,
  `precio_mayor` decimal(10,0) NOT NULL,
  `estado` int(100) NOT NULL,
  `idlocal` int(11) NOT NULL,
  `idproveedor` int(11) NOT NULL,
  `idrubro` int(11) NOT NULL,
  `idmarca` int(11) NOT NULL,
  `imagen` longblob NOT NULL,
  `ruta` mediumtext NOT NULL,
  `suelto` int(11) NOT NULL,
  `kg` decimal(10,0) NOT NULL,
  `gramos` decimal(10,0) NOT NULL,
  `precio_suelto` decimal(10,0) NOT NULL,
  `stock_suelto` int(11) NOT NULL,
  `gramos_fijos` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `idproveedor` int(11) NOT NULL,
  `nombre_proveedor` varchar(100) NOT NULL,
  `celular` varchar(25) NOT NULL,
  `direccion` varchar(250) NOT NULL,
  `correo` varchar(200) NOT NULL,
  `estado` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rubro`
--

CREATE TABLE `rubro` (
  `idrubro` int(11) NOT NULL,
  `nombre_rubro` varchar(100) NOT NULL,
  `detalle` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `supercaja`
--

CREATE TABLE `supercaja` (
  `idsuperCaja` int(11) NOT NULL,
  `nombreCaja` varchar(100) NOT NULL,
  `fechaApertura` date NOT NULL,
  `efectivoApertura` decimal(10,0) NOT NULL,
  `fechaCierre` date NOT NULL,
  `efectivoCierre` decimal(10,0) NOT NULL,
  `creditoCierre` decimal(10,0) NOT NULL,
  `debitoCierre` decimal(10,0) NOT NULL,
  `transferenciaCierre` decimal(10,0) NOT NULL,
  `compras` decimal(10,0) NOT NULL,
  `gastos` decimal(10,0) NOT NULL,
  `totalN` decimal(10,0) NOT NULL,
  `totalB` decimal(10,0) NOT NULL,
  `totalA` decimal(10,0) NOT NULL,
  `estado` int(11) NOT NULL,
  `idlocal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idusuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `usuario` varchar(20) NOT NULL,
  `clave` varchar(50) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  `idlocal` int(11) NOT NULL,
  `rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `idventa` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `idcliente` int(11) NOT NULL,
  `idproducto` int(11) NOT NULL,
  `numero_factura` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `fecha_venta` date NOT NULL,
  `importe` decimal(10,0) NOT NULL,
  `descuento` decimal(10,0) NOT NULL,
  `subtotal` decimal(10,0) NOT NULL,
  `preciofinal` decimal(10,0) NOT NULL,
  `total_venta` decimal(10,0) NOT NULL,
  `interes` decimal(10,0) NOT NULL,
  `mediodepago` varchar(100) NOT NULL,
  `tipoventa` varchar(100) NOT NULL,
  `idlocal` int(11) NOT NULL,
  `idcaja` int(11) NOT NULL,
  `mes` varchar(50) NOT NULL,
  `año` int(11) NOT NULL,
  `gramos` decimal(10,0) NOT NULL,
  `mi_precio` decimal(10,0) NOT NULL,
  `total_compra` decimal(10,0) NOT NULL,
  `observacion` varchar(500) NOT NULL,
  `idvendedor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carrito_cuenta`
--
ALTER TABLE `carrito_cuenta`
  ADD PRIMARY KEY (`idcarrito_cuenta`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`idcliente`);

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`idcompra`);

--
-- Indices de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cuentas`
--
ALTER TABLE `cuentas`
  ADD PRIMARY KEY (`idcuenta`);

--
-- Indices de la tabla `cuenta_corrientes`
--
ALTER TABLE `cuenta_corrientes`
  ADD PRIMARY KEY (`idcuenta_corrientes`);

--
-- Indices de la tabla `cuotas`
--
ALTER TABLE `cuotas`
  ADD PRIMARY KEY (`idcuota`);

--
-- Indices de la tabla `detalle_permisos`
--
ALTER TABLE `detalle_permisos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`idfactura`);

--
-- Indices de la tabla `gastos`
--
ALTER TABLE `gastos`
  ADD PRIMARY KEY (`idgastos`);

--
-- Indices de la tabla `lista`
--
ALTER TABLE `lista`
  ADD PRIMARY KEY (`idlista`);

--
-- Indices de la tabla `lista_productos`
--
ALTER TABLE `lista_productos`
  ADD PRIMARY KEY (`idlista`);

--
-- Indices de la tabla `locales`
--
ALTER TABLE `locales`
  ADD PRIMARY KEY (`idlocal`);

--
-- Indices de la tabla `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`idmarca`);

--
-- Indices de la tabla `pagos_cuenta`
--
ALTER TABLE `pagos_cuenta`
  ADD PRIMARY KEY (`idpagos_cuenta`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`idpedidos`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `preventista`
--
ALTER TABLE `preventista`
  ADD PRIMARY KEY (`idpreventista`),
  ADD KEY `idusuario` (`idusuario`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`idproducto`),
  ADD KEY `idlocal` (`idlocal`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`idproveedor`);

--
-- Indices de la tabla `rubro`
--
ALTER TABLE `rubro`
  ADD PRIMARY KEY (`idrubro`);

--
-- Indices de la tabla `supercaja`
--
ALTER TABLE `supercaja`
  ADD PRIMARY KEY (`idsuperCaja`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`),
  ADD KEY `idlocal` (`idlocal`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`idventa`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carrito_cuenta`
--
ALTER TABLE `carrito_cuenta`
  MODIFY `idcarrito_cuenta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `idcliente` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `idcompra` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cuentas`
--
ALTER TABLE `cuentas`
  MODIFY `idcuenta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cuenta_corrientes`
--
ALTER TABLE `cuenta_corrientes`
  MODIFY `idcuenta_corrientes` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cuotas`
--
ALTER TABLE `cuotas`
  MODIFY `idcuota` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_permisos`
--
ALTER TABLE `detalle_permisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `idfactura` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `gastos`
--
ALTER TABLE `gastos`
  MODIFY `idgastos` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `lista`
--
ALTER TABLE `lista`
  MODIFY `idlista` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `lista_productos`
--
ALTER TABLE `lista_productos`
  MODIFY `idlista` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `locales`
--
ALTER TABLE `locales`
  MODIFY `idlocal` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `marcas`
--
ALTER TABLE `marcas`
  MODIFY `idmarca` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pagos_cuenta`
--
ALTER TABLE `pagos_cuenta`
  MODIFY `idpagos_cuenta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `idpedidos` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `preventista`
--
ALTER TABLE `preventista`
  MODIFY `idpreventista` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `idproducto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `idproveedor` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rubro`
--
ALTER TABLE `rubro`
  MODIFY `idrubro` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `supercaja`
--
ALTER TABLE `supercaja`
  MODIFY `idsuperCaja` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `idventa` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
