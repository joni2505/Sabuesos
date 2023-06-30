<?php
require "../conexion.php";

if (isset($_POST['datos'])) {

  $idcaja = $_POST['idcaja'];
  //efectivo
  $resultados = mysqli_query($conexion, "SELECT SUM(ventas.total_venta)'efectivo' FROM ventas WHERE mediodepago='Efectivo' and idcaja='$idcaja'");
  while ($consulta = mysqli_fetch_array($resultados)) {
    $efectivo = $consulta['efectivo'];
  }

  //credito
  $resultados = mysqli_query($conexion, "SELECT SUM(ventas.total_venta)'credito' FROM ventas WHERE mediodepago='Tarjeta de Credito' and idcaja='$idcaja'");
  while ($consulta = mysqli_fetch_array($resultados)) {
    $credito = $consulta['credito'];
  }

  //Debito
  $resultados = mysqli_query($conexion, "SELECT SUM(ventas.total_venta)'debito' FROM ventas WHERE mediodepago='Tarjeta de Debito' and idcaja='$idcaja'");
  while ($consulta = mysqli_fetch_array($resultados)) {
    $debito = $consulta['debito'];
  }

  //transferencia
  $resultados = mysqli_query($conexion, "SELECT SUM(ventas.total_venta)'transferencia' FROM ventas WHERE mediodepago='transferencia' and idcaja='$idcaja'");
  while ($consulta = mysqli_fetch_array($resultados)) {
    $transferencia = $consulta['transferencia'];
  }

  //FACTURA A
  $resultados = mysqli_query($conexion, "SELECT SUM(factura.total)'facturaA' FROM factura WHERE tipoFactura='Factura_A' and idcaja='$idcaja'");
  while ($consulta = mysqli_fetch_array($resultados)) {
    $facturaA = $consulta['facturaA'];
  }

  //FACTURA B
  $resultados = mysqli_query($conexion, "SELECT SUM(factura.total)'facturaB' FROM factura WHERE tipoFactura='Ticket' and idcaja='$idcaja'");
  while ($consulta = mysqli_fetch_array($resultados)) {
    $facturaB = $consulta['facturaB'];
  }

  //FACTURA Comun
  $resultados = mysqli_query($conexion, "SELECT SUM(factura.total)'facturaComun' FROM factura WHERE tipoFactura='Orizontal-A4' and idcaja='$idcaja'");
  while ($consulta = mysqli_fetch_array($resultados)) {
    $facturaComun = $consulta['facturaComun'];
  }

  //total compras
  $resultados = mysqli_query($conexion, "SELECT SUM(compra.total)'compras' FROM compra WHERE idcaja='$idcaja'");
  while ($consulta = mysqli_fetch_array($resultados)) {
    $compras = $consulta['compras'];
  }

  //total gastos
  $resultados = mysqli_query($conexion, "SELECT SUM(importe)'gastos' FROM gastos WHERE idcaja='$idcaja'");
  while ($consulta = mysqli_fetch_array($resultados)) {
    $gastos = $consulta['gastos'];
  }
}

if (isset($_POST['cerrarCaja'])) {

  $idcaja = $_POST['idcaja'];
  $fechaCierre = $_POST['fechaCierre'];
  //Cantidad de ventas
  $resultados = mysqli_query($conexion, "SELECT COUNT(ventas.total_venta)'cantVentas' from ventas WHERE idcaja=$idcaja");
  while ($consulta = mysqli_fetch_array($resultados)) {
    $cantVentas = $consulta['cantVentas'];
  }
  
  //cantidad de articulos
  $resultados = mysqli_query($conexion, "SELECT SUM(cantidad)'cantidadArt' from ventas WHERE idcaja=$idcaja");
  while ($consulta = mysqli_fetch_array($resultados)) {
    $cantArticulos = $consulta['cantidadArt'];
  }
 
  //descuentos
  $resultados = mysqli_query($conexion, "SELECT SUM(ventas.preciofinal)'descuentos' FROM ventas WHERE descuento>0 and idcaja=$idcaja");
  while ($consulta = mysqli_fetch_array($resultados)) {
    $totalDescuento = $consulta['descuentos'];
  }

  //Recargos
  $resultados = mysqli_query($conexion, "SELECT SUM(ventas.preciofinal)'recargos' FROM ventas WHERE interes>0 and idcaja=$idcaja");
  while ($consulta = mysqli_fetch_array($resultados)) {
    $totalRecargo = $consulta['recargos'];
  }
 
  //efectivo
  $resultados = mysqli_query($conexion, "SELECT SUM(ventas.total_venta)'efectivo' FROM ventas WHERE mediodepago='Efectivo' and idcaja='$idcaja'");
  while ($consulta = mysqli_fetch_array($resultados)) {
    $efectivo = $consulta['efectivo'];
  }

  //credito
  $resultados = mysqli_query($conexion, "SELECT SUM(ventas.total_venta)'credito' FROM ventas WHERE mediodepago='Tarjeta de Credito' and idcaja='$idcaja'");
  while ($consulta = mysqli_fetch_array($resultados)) {
    $credito = $consulta['credito'];
  }

  //Debito
  $resultados = mysqli_query($conexion, "SELECT SUM(ventas.total_venta)'debito' FROM ventas WHERE mediodepago='Tarjeta de Debito' and idcaja='$idcaja'");
  while ($consulta = mysqli_fetch_array($resultados)) {
    $debito = $consulta['debito'];
  }

  //transferencia
  $resultados = mysqli_query($conexion, "SELECT SUM(ventas.total_venta)'transferencia' FROM ventas WHERE mediodepago='transferencia' and idcaja='$idcaja'");
  while ($consulta = mysqli_fetch_array($resultados)) {
    $transferencia = $consulta['transferencia'];
  }

  //FACTURA A
  $resultados = mysqli_query($conexion, "SELECT SUM(factura.total)'facturaA' FROM factura WHERE tipoFactura='Factura_A' and idcaja='$idcaja'");
  while ($consulta = mysqli_fetch_array($resultados)) {
    $facturaA = $consulta['facturaA'];
  }

  //FACTURA B
  $resultados = mysqli_query($conexion, "SELECT SUM(factura.total)'facturaB' FROM factura WHERE tipoFactura='Ticket' and idcaja='$idcaja'");
  while ($consulta = mysqli_fetch_array($resultados)) {
    $facturaB = $consulta['facturaB'];
  }

  //FACTURA Comun
  $resultados = mysqli_query($conexion, "SELECT SUM(factura.total)'facturaComun' FROM factura WHERE tipoFactura='Orizontal-A4' and idcaja='$idcaja'");
  while ($consulta = mysqli_fetch_array($resultados)) {
    $facturaComun = $consulta['facturaComun'];
  }

  //total compras
  $resultados = mysqli_query($conexion, "SELECT SUM(compra.total)'compras' FROM compra WHERE idcaja='$idcaja'");
  while ($consulta = mysqli_fetch_array($resultados)) {
    $compras = $consulta['compras'];
  }

  //total gastos
  $resultados = mysqli_query($conexion, "SELECT SUM(importe)'gastos' FROM gastos WHERE idcaja='$idcaja'");
  while ($consulta = mysqli_fetch_array($resultados)) {
    $gastos = $consulta['gastos'];
  }

  //cerrar caja insert en super caja
  $rs = mysqli_query($conexion, "UPDATE superCaja SET fechaCierre = '$fechaCierre', efectivoCierre = '$efectivo',
        creditoCierre = '$credito', debitoCierre = '$debito', transferenciaCierre = '$transferencia', compras = '$compras', gastos = '$gastos', totalN = '$facturaComun',
        totalB = '$facturaB', totalA = '$facturaA', cantVentas = '$cantVentas', cantArticulos = '$cantArticulos', totalDescuentos = '$totalDescuento', totalRecargos = '$totalRecargo', estado = 1 WHERE idsuperCaja='$idcaja'");
  if ($rs) {
    echo '<script language="javascript">';
    echo 'alert("Caja Cerrada Correctamente!");';
    echo '</script>';
  } else {
    echo '<script language="javascript">';
    echo 'alert("Error al Cerrar");';
    echo '</script>';
  }
}


?>
<script type="text/javascript">
  function agregar() {
    //alert("Ready!");
    var efectivo = <?= json_encode($efectivo) ?>;
    var credito = <?= json_encode($credito) ?>;
    var debito = <?= json_encode($debito) ?>;
    var transferencia = <?= json_encode($transferencia) ?>;
    var facturaA = <?= json_encode($facturaA) ?>;
    var facturaB = <?= json_encode($facturaB) ?>;
    var compras = <?= json_encode($compras) ?>;
    var gastos = <?= json_encode($gastos) ?>;

    $("#efectivo").val("$" + efectivo);
    $("#credito").val("$" + credito);
    $("#debito").val("$" + debito);
    $("#transferencia").val("$" + transferencia);
    $("#facturaA").val("$" + facturaA);
    $("#facturaB").val("$" + facturaB);
    $("#compras").val("$" + compras);
    $("#gastos").val("$" + gastos);
    //window.print();
  }
</script>