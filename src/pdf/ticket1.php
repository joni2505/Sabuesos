<?php
require_once '../../conexion.php';
require_once 'fpdf/fpdf.php';
//$pdf = new FPDF($orientation='P',$unit='mm', array(105,150));
//$pdf = new FPDF('P', 'mm', 'letter');
$pdf = new FPDF('P','mm','A4');
//$pdf=new FPDF('L','mm','A4');
$pdf->AddPage();
//$pdf->SetMargins(4, 4, 4);
$pdf->SetMargins(10, 10, 10);
$pdf->SetTitle("Comprobante de Pago");
$pdf->SetFont('Arial','B',12); 
//$pdf->Image("sabueso.jpg", 11, 0, 60, 20, 'JPG');
$pdf->Ln(12);
$config = mysqli_query($conexion, "SELECT * FROM configuracion");
$datos = mysqli_fetch_assoc($config);

$numFactura = $_GET['factura'];
//$idusuario = $_GET['idusuario3'];
//$idcuota = $_GET['id'];
    
        $factura = mysqli_query($conexion, "SELECT cliente.direccion, cliente.nombre, cliente.celular, usuario.usuario, factura.numero_factura, total, ventas.descuento, ventas.interes, factura.importe, factura.cambio, factura.fecha, producto.codigo_producto'codigo', producto.nombre_producto, ventas.cantidad, factura.tipoventa, factura.mediopago, usuario.nombre'vendedor'
        FROM factura 
        INNER JOIN ventas on factura.numero_factura=ventas.numero_factura
        INNER JOIN producto on ventas.idproducto=producto.idproducto
        INNER JOIN cliente on factura.idcliente=cliente.idcliente
        INNER JOIN usuario on factura.idusuario=usuario.idusuario WHERE factura.numero_factura='$numFactura'");
        $datosfac = mysqli_fetch_assoc($factura);
$textypos = 5;
//$pdf->Cell(5, $textypos, utf8_decode($datos['nombre']), 0, 1, 'L');
$pdf->SetFont('Arial', '', 8);
date_default_timezone_set('America/Argentina/Buenos_Aires');
$feha_actual=date("d-m-Y H:i:s");

$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(20, 5, utf8_decode("Teléfono: "), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(20, 5, $datos['telefono'], 0, 1, 'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(20, 5, utf8_decode("Dirección: "), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(20, 5, utf8_decode($datos['direccion']), 0, 1, 'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(20, 5, "Correo: ", 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(5, 5, utf8_decode($datos['email']), 0, 1, 'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Ln();
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(8, 5, utf8_decode("Fecha/Hs: $feha_actual"), 0, 0, 'L');
$pdf->Ln();
$pdf->Cell(8, 5, "------------------------------------------------------", 0, 0, 'L');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(20, 5, utf8_decode("N°Factura: "), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(7, 5, $datosfac['numero_factura'], 0, 0, 'L');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(10, 5, utf8_decode("Clte: "), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(43, 5, $datosfac['nombre'], 0, 0, 'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(20, 5, utf8_decode("Direccion: "), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(35, 5, $datosfac['direccion'], 0, 0, 'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(15, 5, utf8_decode("Celular: "), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(12, 5, $datosfac['celular'], 0, 0, 'L');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 11);
$pdf->SetFillColor(0, 0, 0);
$pdf->SetTextColor(255, 255, 255);
//$pdf->Cell(196, 5, "Datos del Cliente", 1, 1, 'C', 1);
//$pdf->SetTextColor(0, 0, 0);
//$pdf->Cell(20, 5, utf8_decode('#'), 0, 0, 'L');
$pdf->Ln(1);
$pdf->Cell(73, 5, utf8_decode('Productos'), 0, 0, 'L',1);
$pdf->Cell(20, 5, utf8_decode('Precio'), 0, 0, 'L',1);
$pdf->Cell(25, 5, utf8_decode('Cantidad'), 0, 0, 'L',1);
$pdf->Cell(23, 5, utf8_decode('Desc.%'), 0, 0, 'L',1);
$pdf->Cell(30, 5, utf8_decode('Precio Final'), 0, 0, 'L',1);
$pdf->Cell(25, 5, utf8_decode('Total'), 0, 0, 'L',1);
$pdf->Ln();



$contador = 1;
$sum = 0;
$factura1 = mysqli_query($conexion, "SELECT cliente.nombre, cliente.celular, usuario.usuario, factura.numero_factura, total, ventas.descuento, ventas.interes, factura.importe, factura.cambio, factura.fecha, producto.nombre_producto, producto.codigo_producto'codigo',
ventas.cantidad, factura.tipoventa, ventas.total_venta, factura.mediopago, ventas.subtotal, ventas.preciofinal FROM factura 
        INNER JOIN ventas on factura.numero_factura=ventas.numero_factura
        INNER JOIN producto on ventas.idproducto=producto.idproducto
        INNER JOIN cliente on factura.idcliente=cliente.idcliente
        INNER JOIN usuario on factura.idusuario=usuario.idusuario WHERE factura.numero_factura='$numFactura'");
while ($row = mysqli_fetch_assoc($factura1)) {
    //$pdf->Cell(3, 5, $contador, 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(73, 5, $row['nombre_producto'], 0, 0, 'L');
    $pdf->Cell(25, 5, "$".$row['subtotal'], 0, 0, 'L');
    $pdf->Cell(25, 5, $row['cantidad'], 0, 0, 'L');
    $pdf->Cell(23, 5, $row['descuento'], 0, 0, 'L');
    $pdf->Cell(22, 5, "$".$row['preciofinal'], 0, 0, 'L');
    $pdf->Cell(5, 5, "$".$row['total_venta'], 0, 0, 'L');
    $cantidad = $row['cantidad'];
    $sum = $sum + $cantidad;
    $pdf->Ln(6);
    $contador++;

}
$pdf->Ln();
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(28,3, utf8_decode("Total de Bultos:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(6, 3, $sum, 0, 0, 'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(10,3, utf8_decode("Total:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);

$factura = mysqli_query($conexion, "SELECT total FROM factura WHERE numero_factura='$numFactura'");
while ($row = mysqli_fetch_assoc($factura)) {
 
    $pdf->Cell(5, 3, "$".$row['total'], 0, 0, 'L');
    $pdf->Ln(3);
   

}
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(25, 5, utf8_decode("Tipo de Venta: "), 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(24, 5, $datosfac['tipoventa'], 0, 0, 'L');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(26, 5, utf8_decode("Medio de Pago: "), 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(15, 5, $datosfac['mediopago'], 0, 0, 'L');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(17, 5, utf8_decode("Vendedor: "), 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(7, 5, $datosfac['vendedor'], 0, 0, 'L');
$pdf->Ln(22);
$pdf->Cell(8, 5, "---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------", 0, 0, 'L');
//Copia de la Factura
$pdf->Ln(10);
$pdf->SetFont('Arial','B',12); 
//$pdf->Image("../../assets/img/sabueso.jpg", 11, 142, 60, 20, 'JPG');
$pdf->Ln(35);
$config = mysqli_query($conexion, "SELECT * FROM configuracion");
$datos = mysqli_fetch_assoc($config);

$numFactura = $_GET['factura'];
//$idusuario = $_GET['idusuario3'];
//$idcuota = $_GET['id'];
    
        $factura = mysqli_query($conexion, "SELECT cliente.direccion, cliente.nombre, cliente.celular, usuario.usuario, factura.numero_factura, total, ventas.descuento, ventas.interes, factura.importe, factura.cambio, factura.fecha, producto.codigo_producto'codigo', producto.nombre_producto, ventas.cantidad, factura.tipoventa, factura.mediopago, usuario.nombre'vendedor'
        FROM factura 
        INNER JOIN ventas on factura.numero_factura=ventas.numero_factura
        INNER JOIN producto on ventas.idproducto=producto.idproducto
        INNER JOIN cliente on factura.idcliente=cliente.idcliente
        INNER JOIN usuario on factura.idusuario=usuario.idusuario WHERE factura.numero_factura='$numFactura'");
        $datosfac = mysqli_fetch_assoc($factura);
$textypos = 5;
//$pdf->Cell(5, $textypos, utf8_decode($datos['nombre']), 0, 1, 'L');
$pdf->SetFont('Arial', '', 8);
date_default_timezone_set('America/Argentina/Buenos_Aires');
$feha_actual=date("d-m-Y H:i:s");

$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(20, 5, utf8_decode("Teléfono: "), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(20, 5, $datos['telefono'], 0, 1, 'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(20, 5, utf8_decode("Dirección: "), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(20, 5, utf8_decode($datos['direccion']), 0, 1, 'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(20, 5, "Correo: ", 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(5, 5, utf8_decode($datos['email']), 0, 1, 'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Ln();
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(8, 5, utf8_decode("Fecha/Hs: $feha_actual"), 0, 0, 'L');
$pdf->Ln();
$pdf->Cell(8, 5, "------------------------------------------------------", 0, 0, 'L');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(20, 5, utf8_decode("N°Factura: "), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(7, 5, $datosfac['numero_factura'], 0, 0, 'L');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(10, 5, utf8_decode("Clte: "), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(43, 5, $datosfac['nombre'], 0, 0, 'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(20, 5, utf8_decode("Direccion: "), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(35, 5, $datosfac['direccion'], 0, 0, 'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(15, 5, utf8_decode("Celular: "), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(12, 5, $datosfac['celular'], 0, 0, 'L');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 11);
$pdf->SetFillColor(0, 0, 0);
$pdf->SetTextColor(255, 255, 255);
//$pdf->Cell(196, 5, "Datos del Cliente", 1, 1, 'C', 1);
//$pdf->SetTextColor(0, 0, 0);
//$pdf->Cell(20, 5, utf8_decode('#'), 0, 0, 'L');
$pdf->Ln(1);
$pdf->Cell(73, 5, utf8_decode('Productos'), 0, 0, 'L',1);
$pdf->Cell(20, 5, utf8_decode('Precio'), 0, 0, 'L',1);
$pdf->Cell(25, 5, utf8_decode('Cantidad'), 0, 0, 'L',1);
$pdf->Cell(23, 5, utf8_decode('Desc.%'), 0, 0, 'L',1);
$pdf->Cell(30, 5, utf8_decode('Precio Final'), 0, 0, 'L',1);
$pdf->Cell(25, 5, utf8_decode('Total'), 0, 0, 'L',1);
$pdf->Ln();



$contador = 1;
$sum = 0;
$factura1 = mysqli_query($conexion, "SELECT cliente.nombre, cliente.celular, usuario.usuario, factura.numero_factura, total, ventas.descuento, ventas.interes, factura.importe, factura.cambio, factura.fecha, producto.nombre_producto, producto.codigo_producto'codigo',
ventas.cantidad, factura.tipoventa, ventas.total_venta, factura.mediopago, ventas.subtotal, ventas.preciofinal FROM factura 
        INNER JOIN ventas on factura.numero_factura=ventas.numero_factura
        INNER JOIN producto on ventas.idproducto=producto.idproducto
        INNER JOIN cliente on factura.idcliente=cliente.idcliente
        INNER JOIN usuario on factura.idusuario=usuario.idusuario WHERE factura.numero_factura='$numFactura'");
while ($row = mysqli_fetch_assoc($factura1)) {
    //$pdf->Cell(3, 5, $contador, 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->SetTextColor(0, 0, 0);
    
    $pdf->Cell(73, 5, $row['nombre_producto'], 0, 0, 'L');
    $pdf->Cell(25, 5, "$".$row['subtotal'], 0, 0, 'L');
    $pdf->Cell(25, 5, $row['cantidad'], 0, 0, 'L');
    $pdf->Cell(23, 5, $row['descuento'], 0, 0, 'L');
    
    $pdf->Cell(22, 5, "$".$row['preciofinal'], 0, 0, 'L');
    $pdf->Cell(5, 5, "$".$row['total_venta'], 0, 0, 'L');
    $cantidad = $row['cantidad'];
    $sum = $sum + $cantidad;
    $pdf->Ln(6);
    $contador++;

}
$pdf->Ln();
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(28,3, utf8_decode("Total de Bultos:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(6, 3, $sum, 0, 0, 'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(10,3, utf8_decode("Total:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);

$factura = mysqli_query($conexion, "SELECT total FROM factura WHERE numero_factura='$numFactura'");
while ($row = mysqli_fetch_assoc($factura)) {
 
    $pdf->Cell(5, 3, "$".$row['total'], 0, 0, 'L');
    $pdf->Ln(3);
   

}
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(25, 5, utf8_decode("Tipo de Venta: "), 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(24, 5, $datosfac['tipoventa'], 0, 0, 'L');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(26, 5, utf8_decode("Medio de Pago: "), 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(15, 5, $datosfac['mediopago'], 0, 0, 'L');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(17, 5, utf8_decode("Vendedor: "), 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(7, 5, $datosfac['vendedor'], 0, 0, 'L');
$pdf->Ln();  

$pdf->Output("ticket.pdf", "I");


?>