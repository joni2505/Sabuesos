<?php
require_once '../../conexion.php';
$idcaja = $_GET['idcaja'];
//$fechaCierre = $_POST['fechaCierre'];
$resultados = mysqli_query($conexion, "SELECT * FROM supercaja WHERE idsuperCaja=$idcaja");
  while ($consulta = mysqli_fetch_array($resultados)) {
    $nombre = $consulta['nombreCaja'];
    $fechaApertura = $consulta['fechaApertura'];
    $fechaCierre = $consulta['fechaCierre'];
    $cantVentas = $consulta['cantVentas'];
    $cantArticulos = $consulta['cantArticulos'];
    $efectivoCierre = $consulta['efectivoCierre'];
    $efectivoApertura = $consulta['efectivoApertura'];
    $creditoCierre = $consulta['creditoCierre'];
    $debitoCierre = $consulta['debitoCierre'];
    $trasferenciaCierre = $consulta['transferenciaCierre'];
    $totalN = $consulta['totalN'];
    $totalDescuento = $consulta['totalDescuentos'];
    $totalRecargos = $consulta['totalRecargos'];
    $retiroEfectivo = $consulta['retiroEfectivo'];
  }

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Cierre de Caja Sabuesos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    </head>
    <body>
        <h2 class="text-success" style="text-align: center;">Sabuesos Petshop Cierre</h2>
        <h6 style="text-align: center;"><?php echo $nombre; ?></h6>
        <h6 style="text-align: center;">Desde: <?php echo $fechaApertura; ?></h6>
        <h6 style="text-align: center;">Hasta: <?php echo $fechaCierre; ?></h6>
        <h2 class="text-success" style="text-align: center;">---Estadisticas---</h2>
        <h6 style="text-align: center;">Cant. de Ventas: <?php echo $cantVentas; ?> </h6>
        <h6 style="text-align: center;">Cant. de Articulos: <?php echo $cantArticulos; ?></h6>
        <h2 class="text-success" style="text-align: center;">--Totales Ventas--</h2>
        <h6 style="text-align: center;">Efectivo: <?php echo "$".$efectivoCierre; ?> </h6>
        <h6 style="text-align: center;">Tarj. Credito: <?php echo "$".$creditoCierre; ?> </h6>
        <h6 style="text-align: center;">Tarj. Debito: <?php echo "$".$debitoCierre; ?> </h6>
        <h6 style="text-align: center;">Transferencia: <?php echo "$".$trasferenciaCierre; ?> </h6>
        <?php $total = $efectivoCierre+$creditoCierre+$debitoCierre+$trasferenciaCierre; ?>
        <h6 class="text-success" style="text-align: center;">Total: <?php echo "$".$total; ?> </h6>
        <h2 class="text-success" style="text-align: center;">--Desc/Rec Ventas--</h2>
        <h6 style="text-align: center;">Descuentos: <?php echo "$".$totalDescuento; ?> </h6>
        <h6 style="text-align: center;">Recargos: <?php echo "$".$totalRecargos; ?> </h6>
        <h2 class="text-success" style="text-align: center;">--Dinero en Caja--</h2>
        <h6 style="text-align: center;">Efectivo: <?php echo "$".$efectivoCierre; ?> </h6>
        <h6 style="text-align: center;">Retiro de Efectivo: <?php echo "$".$retiroEfectivo; ?> </h6>
        <h2 class="text-success" style="text-align: center;">Cierre de Caja Sabuesos</h2>
    </body>
</html>