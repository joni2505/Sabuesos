<?php
	require('fpdf/fpdf.php'); //Agregamos la librería
    require_once '../../conexion.php';

    class PDF extends FPDF
	{
    public function Header(){
        // Logo
		$this->Image('sabueso.jpg',3,6,30);
		// Arial bold 15
		$this->SetFont('Arial', '', 5);
		// Move to the right
		$this->Cell(1);
		// Title
		$this->SetXY(1,18);
		//$this->Ln();
		$cuitt = 20403303462;
		$this->Cell(1, 7, "", 0, 0, 'L');
		$this->Cell(1, 7, utf8_decode("CUIT: $cuitt "), 0, 0, 'L');
	
		$this->SetXY(1,15);
		$this->Cell(1, 5, "", 0, 0, 'L');
		$this->Cell(1, 7, utf8_decode("Ingresos Brutos: $cuitt "), 0, 0, 'L');

	    $this->SetXY(1,21);
		$this->Cell(1, 5, "", 0, 0, 'L');
		$this->Cell(1, 7, utf8_decode("Inicio de Actividad: 05/2020 "), 0, 0, 'L');
		
		$this->SetXY(1,24);
		$this->Cell(1, 5, "", 0, 0, 'L');
		$this->Cell(1, 7, utf8_decode("Domicilio: velez sarfield 436 san pedro de jujuy"), 0, 0, 'L');
		/*//$this->Ln();
		$this->Cell(1, 5, "", 0, 0, 'L');
		$this->Cell(1, 7, utf8_decode("RD"), 0, 0, 'L');
		// Line break*/
		$this->Ln(5);

    }
}
    //datos base de datos
    $numFactura = $_GET['factura']=71;
    //$idusuario = $_GET['idusuario3'];
    //$idcuota = $_GET['id'];

    $factura = mysqli_query($conexion, "SELECT cliente.nombre, cliente.celular, usuario.usuario, factura.numero_factura, total, factura.descuento, factura.interes, factura.importe, factura.cambio, factura.fecha, producto.nombre_producto, ventas.cantidad, factura.tipoventa, factura.mediopago
    FROM factura 
    INNER JOIN ventas on factura.numero_factura=ventas.numero_factura
    INNER JOIN producto on ventas.idproducto=producto.idproducto
    INNER JOIN cliente on factura.idcliente=cliente.idcliente
    INNER JOIN usuario on factura.idusuario=usuario.idusuario WHERE factura.numero_factura='$numFactura'");
    $datosfac = mysqli_fetch_assoc($factura);
    $numeroFactura = $datosfac['numero_factura'];
    //fpdf estructura
    $pdf = new PDF($orientation='P',$unit='mm', array(60,128));
	$pdf->AliasNbPages();
	$pdf->AddPage();
	//body fpdf
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $feha_actual=date("d-m-Y H:i:s");
	$pdf->SetMargins(2, 2, 2);
    $pdf->SetFillColor(0, 0, 0);
    $pdf->SetFont('Arial','', 5);
	$pdf->Cell(2, 1, utf8_decode("----------------------------------------------------------------------------------------------------------------------------------------------------------------"), 0, 0, 'C');
    $pdf->Ln(3);
    $pdf->SetFont('Arial','', 10);
    $pdf->Cell(14, 5, utf8_decode("Factura "), 0, 0, 'L');
	$pdf->SetFont('Arial','B', 14);
	$pdf->Cell(6, 5, utf8_decode("B"), 0, 0, 'L');
	$pdf->SetFont('Arial','', 10);
	$pdf->Cell(2, 5, $numFactura , 0, 0, 'L');
	$pdf->SetFont('Arial','', 5);
	$pdf->Ln();
	$pdf->Cell(4, 10, utf8_decode(""), 0, 0, 'L');
	$pdf->Cell(1, 1, utf8_decode("Original   Cod. 006  "), 0, 0, 'L');
    $pdf->Cell(15, 10, utf8_decode(""), 0, 0, 'L');
    $pdf->SetFont('Arial','', 7);
    $pdf->Cell(1, 2, $feha_actual, 0, 0, 'L');
    //$pdf->Cell(1, 2, utf8_decode("Fecha: "$feha_actual), 0, 0, 'L');
   
	$pdf->SetFont('Arial', '', 5);
    $pdf->Cell(2, 12, utf8_decode("---------------------------------------------------------------------------------------------------------------------------------------------------------------"), 0, 0, 'C');
    $pdf->Ln(0);
    //datos clientes
    $pdf->SetFont('Arial', 'B', 6);
	$pdf->Cell(8, 16, utf8_decode("Cliente: "), 0, 0, 'L');
	$pdf->SetFont('Arial', 'B', 6);
	$pdf->Cell(18, 16, $datosfac['nombre'], 0, 0, 'L');
    $pdf->Ln(0);
	$pdf->SetFont('Arial', 'B', 6);
	$pdf->Cell(8, 22, utf8_decode("Celular: "), 0, 0, 'L');
	$pdf->SetFont('Arial', 'B', 6);
	$pdf->Cell(8, 22, $datosfac['celular'], 0, 0, 'L');
	$pdf->Ln(0);
    $pdf->SetFont('Arial', 'B', 6);
	$pdf->Cell(8, 28, utf8_decode("Condicion de IVA: Consumidor Final"), 0, 0, 'L');
	$pdf->SetFont('Arial', '', 6);
    
	//$pdf->Cell(8, 20, $datosfac['direccion'], 0, 0, 'L');
    $pdf->Cell(2, 30, utf8_decode("---------------------------------------------------------------------------------------------------------------------------------------------------------------"), 0, 0, 'C');
    $pdf->Ln(17);
    
    //tabla datos factura
    $pdf->SetFont('Arial', 'B', 6);
    $pdf->SetTextColor(0, 0, 0);

    $pdf->Cell(15, 5, utf8_decode('Can'), 0, 0, 'L');
    $pdf->Cell(17, 5, utf8_decode('Producto'), 0, 0, 'L');
    $pdf->Cell(8, 5, utf8_decode('Precio'), 0, 0, 'L');
    $pdf->Cell(6, 5, utf8_decode('Int%'), 0, 0, 'L');
    $pdf->Cell(15, 5, utf8_decode('SubTotal'), 0, 0, 'L');
    $pdf->Ln(3);
    $pdf->SetFont('Arial', '', 5);
	$contador = 1;
	$sum = 0;
	$supertotal=0;
	$factura1 = mysqli_query($conexion, "SELECT cliente.nombre, cliente.celular, usuario.usuario, factura.numero_factura, total, factura.descuento, factura.interes, factura.importe, factura.cambio, factura.fecha, producto.nombre_producto,
	producto.precio_producto, ventas.interes, ventas.cantidad, factura.tipoventa, ventas.total_venta, factura.mediopago FROM factura 
			INNER JOIN ventas on factura.numero_factura=ventas.numero_factura
			INNER JOIN producto on ventas.idproducto=producto.idproducto
			INNER JOIN cliente on factura.idcliente=cliente.idcliente
			INNER JOIN usuario on factura.idusuario=usuario.idusuario WHERE factura.numero_factura='$numFactura'");
	while ($row = mysqli_fetch_assoc($factura1)) {
		//$pdf->Cell(2, 5, $contador, 0, 0, 'L');
		$pdf->Cell(2, 5, $row['cantidad'], 0, 0, 'L');
		$pdf->Cell(32, 5, $row['nombre_producto'], 0, 0, 'L');
		$pdf->Cell(8, 5, "$".$row['precio_producto'], 0, 0, 'L');
        $pdf->Cell(6, 5,$row['interes']."%", 0, 0, 'L');
        $pdf->Cell(5, 5, "$".$row['total_venta'], 0, 0, 'L');

		$cantidad = $row['cantidad'];
		$sub = $row['total_venta'] * $cantidad;
		$supertotal = $supertotal + $sub;
		$sum = $sum + $cantidad;
		$pdf->Ln(3);
		$contador++;

	}

    

    //datos del total
    $pdf->Ln();
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial', 'B', 6);
    $pdf->Cell(22,15, utf8_decode("Total de Productos:"), 0, 0, 'L');
    $pdf->SetFont('Arial', '', 6);
    $pdf->Cell(6, 15, $sum, 0, 0, 'L');
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial', 'B', 6);
    $pdf->Cell(10, 5, utf8_decode(' '), 0, 0, 'L');
    //$pdf->Cell(10, 3, utf8_decode('Total:'),0 , 0, 'L');
    $pdf->Ln();
    $pdf->SetFont('Arial', '', 8);
    $factura = mysqli_query($conexion, "SELECT descuento,interes, total FROM factura WHERE numero_factura='$numFactura'");
    while ($row = mysqli_fetch_assoc($factura)) {
    }
        //$pdf->Cell(15, 5, $row['descuento'], 0, 0, 'L');
        $pdf->Cell(29, 5, "", 0, 0, 'L');
        $pdf->Cell(25, 5, "TOTAL VENTA: $".$venta, 1, 0, 'L');
        $pdf->Ln(2);
    //salida fpdf
    $pdf->SetFont('Arial', '', 11);
    $pdf->Output();