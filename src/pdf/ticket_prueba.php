<?php
	require('fpdf/fpdf.php'); //Agregamos la librería
	require_once('qrcode/qrcode.class.php');
	include 'afip.php-master\src\Afip.php';
	require_once '../../conexion.php';

	class PDF extends FPDF
	{
	// Page header
	public function Header()
	{
		// Logo
		$this->Image('sabueso.jpg',3,6,30);
		// Arial bold 15
		$this->SetFont('Arial', '', 5);
		// Move to the right
		$this->Cell(1);
		// Title
		$this->SetXY(1,18);
		//$this->Ln();
		$cuit = 20403303462;
		$this->Cell(1, 7, "", 0, 0, 'L');
		$this->Cell(1, 7, utf8_decode("CUIT: $cuit "), 0, 0, 'L');
	
		$this->SetXY(1,15);
		$this->Cell(1, 5, "", 0, 0, 'L');
		$this->Cell(1, 7, utf8_decode("Ingresos Brutos: $cuit "), 0, 0, 'L');

	    $this->SetXY(1,21);
		$this->Cell(1, 5, "", 0, 0, 'L');
		$this->Cell(1, 7, utf8_decode("Inicio de Actividad: 15/05/2020 "), 0, 0, 'L');
		
		$this->SetXY(1,24);
		$this->Cell(1, 5, "", 0, 0, 'L');
		$this->Cell(1, 7, utf8_decode("Domicilio: velez sarfield 436 san pedro de jujuy"), 0, 0, 'L');
		/*//$this->Ln();
		$this->Cell(1, 5, "", 0, 0, 'L');
		$this->Cell(1, 7, utf8_decode("RD"), 0, 0, 'L');
		// Line break*/
		$this->Ln(10);
	}
	
	// Page footer
	public function Footer()
	{
		// Position at 1.5 cm from bottom
		$this->SetY(-35);
		// Arial italic 8
		$this->SetFont('Arial','I',100);

		//AFIP

//$afip = new Afip(array('CUIT' => 20397385028));
$afip = new Afip([
    'CUIT'=> 20403303462, //<-- ojo ahi!
    'cert' => 'sabuesosproduccion_3cb7c9e227b08100.crt',
    'key'=> 'MiClavePrivada.key',
    'production' => false
    ]);

	//$taxpayer_details = $afip->RegisterScopeTen->GetTaxpayerDetails(20403303462);
	//print_r($taxpayer_details);

    $data = array(
        'CantReg' 	=> 1,  // Cantidad de comprobantes a registrar
        'PtoVta' 	=> 5,  // Punto de venta
        'CbteTipo' 	=> 6,  // Tipo de comprobante (ver tipos disponibles) 
        'Concepto' 	=> 1,  // Concepto del Comprobante: (1)Productos, (2)Servicios, (3)Productos y Servicios
        'DocTipo' 	=> 99, // Tipo de documento del comprador (99 consumidor final, ver tipos disponibles)
        'DocNro' 	=> 0,  // Número de documento del comprador (0 consumidor final)
        'CbteDesde' 	=> 1,  // Número de comprobante o numero del primer comprobante en caso de ser mas de uno
        'CbteHasta' 	=> 1,  // Número de comprobante o numero del último comprobante en caso de ser mas de uno
        'CbteFch' 	=> intval(date('Ymd')), // (Opcional) Fecha del comprobante (yyyymmdd) o fecha actual si es nulo
        'ImpTotal' 	=> 121, // Importe total del comprobante
        'ImpTotConc' 	=> 0,   // Importe neto no gravado
        'ImpNeto' 	=> 100, // Importe neto gravado
        'ImpOpEx' 	=> 0,   // Importe exento de IVA
        'ImpIVA' 	=> 21,  //Importe total de IVA
        'ImpTrib' 	=> 0,   //Importe total de tributos
        'MonId' 	=> 'PES', //Tipo de moneda usada en el comprobante (ver tipos disponibles)('PES' para pesos argentinos) 
        'MonCotiz' 	=> 1,     // Cotización de la moneda usada (1 para pesos argentinos)  
        'Iva' 		=> array( // (Opcional) Alícuotas asociadas al comprobante
            array(
                'Id' 		=> 5, // Id del tipo de IVA (5 para 21%)(ver tipos disponibles) 
                'BaseImp' 	=> 100, // Base imponible
                'Importe' 	=> 21 // Importe 
            )
        ), 
    );
	$ptovta = $data['PtoVta']=5; //Punto de Venta SIN CEROS ADELANTE!!
	$tipocbte = $data['PtoVta']= 6; // Factura A: 1 --- Factura B: 6 ---- Factura C: 11
	$res = $afip->ElectronicBilling->CreateNextVoucher($data);
	
	//Pido ultimo numero autorizado
	$nro = $afip->ElectronicBilling->GetLastVoucher($data['PtoVta'], $data['CbteTipo']);
	if(!is_numeric($nro)) {
		echo "<br>Error al obtener el ultimo numero autorizado<br>";
	
	}
	$numero = $nro+1;  
	$cuit= '20403303462'; //para el codigo de barras
	$comprob = str_pad($tipocbte, 3, "0", STR_PAD_LEFT); //para el codigo de barras
	$punto =  str_pad($ptovta, 5, "0", STR_PAD_LEFT); //para el codigo de barras
	$cae = $res['CAE']; //para el codigo de barras
	$caefvt = $res['CAEFchVto']; //para el codigo de barras
	
	
	//$date = $afip->ElectronicBilling->FormatDate($res['CAEFchVto']); //Nos devuelve 1997-05-08
	
		$this->Ln();
		//$pdf->Image("afip.png", 2,$pdf->GetY(), 6, 15, 10, 'PNG');
		$this->Image('afip.png', 0, $this->GetY(),20, 8.10);
		$this->SetFont('Arial', 'B', 3.9);
		$this->Cell(17, 5, "", 0, 0, 'L');
		$this->Cell(9, 5, utf8_decode("Comprobante Autorizado "), 0, 0, 'L');
		$this->Ln();
		$this->SetFont('Arial', 'B', 6);
		$this->Cell(17, 5, "", 0, 0, 'L');
		$this->Cell(9, 3, utf8_decode("CAE N°: "), 0, 0, 'L');
		$this->SetFont('Arial', '', 6);
		$this->Cell(8, 3, $res['CAE'], 0, 0, 'L');
		$this->Ln();
		$this->SetFont('Arial', 'B', 6);
		$this->Cell(17, 5, "", 0, 0, 'L');
		$this->Cell(14, 3, utf8_decode("Vencimiento: "), 0, 0, 'L');
		$this->SetFont('Arial', '', 6);
		$this->Cell(7, 3, date( "d/m/Y", strtotime( $caefvt ) ), 0, 0, 'L');
		//QR
		$qr=$cuit.$comprob.$punto.$cae.$caefvt;
		$qrcode = new QRcode($qr, 'H');
		//$code='ABCDEFG1234567890AbCdEf';
		//$this->Write(10,$code);
		$qrcode->displayFPDF($this, 16, 135, 14);
		// Page number
		//$this->SetXY(20,290);
		//$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}
	}

	$config = mysqli_query($conexion, "SELECT * FROM configuracion");
	$datos = mysqli_fetch_assoc($config);
     

	//AFIP
	$afip = new Afip([
		'CUIT'=> 20403303462, //<-- ojo ahi!
		'cert' => 'sabuesosproduccion_3cb7c9e227b08100.crt',
		'key'=> 'MiClavePrivada.key',
		'production' => false
		]);
	
		$data = array(
			'CantReg' 	=> 1,  // Cantidad de comprobantes a registrar
			'PtoVta' 	=> 5,  // Punto de venta
			'CbteTipo' 	=> 6,  // Tipo de comprobante (ver tipos disponibles) 
			'Concepto' 	=> 1,  // Concepto del Comprobante: (1)Productos, (2)Servicios, (3)Productos y Servicios
			'DocTipo' 	=> 99, // Tipo de documento del comprador (99 consumidor final, ver tipos disponibles)
			'DocNro' 	=> 0,  // Número de documento del comprador (0 consumidor final)
			'CbteDesde' 	=> 1,  // Número de comprobante o numero del primer comprobante en caso de ser mas de uno
			'CbteHasta' 	=> 1,  // Número de comprobante o numero del último comprobante en caso de ser mas de uno
			'CbteFch' 	=> intval(date('Ymd')), // (Opcional) Fecha del comprobante (yyyymmdd) o fecha actual si es nulo
			'ImpTotal' 	=> 121, // Importe total del comprobante
			'ImpTotConc' 	=> 0,   // Importe neto no gravado
			'ImpNeto' 	=> 100, // Importe neto gravado
			'ImpOpEx' 	=> 0,   // Importe exento de IVA
			'ImpIVA' 	=> 21,  //Importe total de IVA
			'ImpTrib' 	=> 0,   //Importe total de tributos
			'MonId' 	=> 'PES', //Tipo de moneda usada en el comprobante (ver tipos disponibles)('PES' para pesos argentinos) 
			'MonCotiz' 	=> 1,     // Cotización de la moneda usada (1 para pesos argentinos)  
			'Iva' 		=> array( // (Opcional) Alícuotas asociadas al comprobante
				array(
					'Id' 		=> 5, // Id del tipo de IVA (5 para 21%)(ver tipos disponibles) 
					'BaseImp' 	=> 100, // Base imponible
					'Importe' 	=> 21 // Importe 
				)
			), 
		);
		$res = $afip->ElectronicBilling->CreateNextVoucher($data);
		$ptovta = $data['PtoVta']=5; //Punto de Venta SIN CEROS ADELANTE!!
		$tipocbte = $data['CbteTipo']= 6; // Factura A: 1 --- Factura B: 6 ---- Factura C: 11
		$res = $afip->ElectronicBilling->CreateNextVoucher($data);
		
		//Pido ultimo numero autorizado
		$nro = $afip->ElectronicBilling->GetLastVoucher($data['PtoVta'], $data['CbteTipo']);
		if(!is_numeric($nro)) {
			echo "<br>Error al obtener el ultimo numero autorizado<br>";
		
		}
		$numero1 = $nro+1; 

	$numFactura = $_GET['factura'];
	//$idusuario = $_GET['idusuario3'];
	//$idcuota = $_GET['id'];
    
        $factura = mysqli_query($conexion, "SELECT cliente.nombre, cliente.celular, usuario.usuario, factura.numero_factura, total, factura.descuento, factura.interes, factura.importe, factura.cambio, factura.fecha, producto.nombre_producto, ventas.cantidad, factura.tipoventa, factura.mediopago
        FROM factura 
        INNER JOIN ventas on factura.numero_factura=ventas.numero_factura
        INNER JOIN producto on ventas.idproducto=producto.idproducto
        INNER JOIN cliente on factura.idcliente=cliente.idcliente
        INNER JOIN usuario on factura.idusuario=usuario.idusuario WHERE factura.numero_factura='$numFactura'");
        $datosfac = mysqli_fetch_assoc($factura);
	
	// Instanciation of inherited class
	$pdf = new PDF($orientation='P',$unit='mm', array(58,150));
	$pdf->AliasNbPages();
	$pdf->AddPage();
	//body fpdf
	$pdf->SetMargins(2, 2, 2);
    //date_default_timezone_set('America/Argentina/Buenos_Aires');
	//$feha_actual=date("d-m-Y");
	$pdf->SetFont('Arial','', 10);
	$pdf->Cell(12, 5, utf8_decode("Ticket"), 0, 0, 'L');
	$pdf->SetFont('Arial','B', 14);
	$pdf->Cell(5, 3, utf8_decode("C"), 0, 0, 'L');
	$pdf->SetFont('Arial','', 10);
	$pdf->Cell(2, 5, utf8_decode("N°00005 ".$numero1), 0, 0, 'L');
	$pdf->SetFont('Arial','', 4);
	$pdf->Ln();
	$pdf->Cell(19, 10, utf8_decode(""), 0, 0, 'L');
	$pdf->Cell(1, 1, utf8_decode("cod. 011"), 0, 0, 'L');
	$pdf->SetFont('Arial', '', 5);
	//$pdf->Cell(18, 5, $datosfac['numero_factura'], 0, 0, 'L');
	$pdf->Ln(4);

	$pdf->SetFont('Arial', 'B', 5);
	$pdf->Cell(5, 5, utf8_decode("Clte: "), 0, 0, 'L');
	$pdf->SetFont('Arial', '', 5);
	$pdf->Cell(18, 5, $datosfac['nombre'], 0, 0, 'L');
	$pdf->SetFont('Arial', 'B', 5);
	
	$pdf->Cell(8, 5, utf8_decode("Celular: "), 0, 0, 'L');
	$pdf->SetFont('Arial', '', 5);
	$pdf->Cell(10, 5, $datosfac['celular'], 0, 0, 'L');
	$pdf->Ln();

	$pdf->SetTextColor(0, 0, 0);
	$pdf->SetFont('Arial', 'B', 5);
	$pdf->Cell(33, 5, utf8_decode('Productos:'), 0, 0, 'L');
	$pdf->Cell(11, 5, utf8_decode('Cantidad:'), 0, 0, 'L');
	$pdf->Cell(10, 5, utf8_decode('Subtotal:'), 0, 0, 'L');
	$pdf->Ln();

	$pdf->SetFont('Arial', '', 5);
	$contador = 1;
	$sum = 0;
	$supertotal=0;
	$factura1 = mysqli_query($conexion, "SELECT cliente.nombre, cliente.celular, usuario.usuario, factura.numero_factura, total, factura.descuento, factura.interes, factura.importe, factura.cambio, factura.fecha, producto.nombre_producto,
	ventas.cantidad, factura.tipoventa, ventas.total_venta, factura.mediopago FROM factura 
			INNER JOIN ventas on factura.numero_factura=ventas.numero_factura
			INNER JOIN producto on ventas.idproducto=producto.idproducto
			INNER JOIN cliente on factura.idcliente=cliente.idcliente
			INNER JOIN usuario on factura.idusuario=usuario.idusuario WHERE factura.numero_factura='$numFactura'");
	while ($row = mysqli_fetch_assoc($factura1)) {
		//$pdf->Cell(2, 5, $contador, 0, 0, 'L');
		$pdf->Cell(37, 5, $row['nombre_producto'], 0, 0, 'L');
		$pdf->Cell(7, 5, $row['cantidad'], 0, 0, 'L');
		$pdf->Cell(5, 5, "$".$row['total_venta'], 0, 0, 'L');
		$cantidad = $row['cantidad'];
		$sub = $row['total_venta'] * $cantidad;
		$supertotal = $supertotal + $sub;
		$sum = $sum + $cantidad;
		$pdf->Ln(3);
		$contador++;

	}
	$pdf->Ln();
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial', 'B', 5);
$pdf->Cell(18,3, utf8_decode("Total de Productos:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', 5);
$pdf->Cell(6, 3, $sum, 0, 0, 'L');
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial', 'B', 5);
$pdf->Cell(10, 5, utf8_decode(' '), 0, 0, 'L');
$pdf->Cell(10, 3, utf8_decode('Total:'), 0, 0, 'L');
$pdf->Ln();
$pdf->SetFont('Arial', '', 5);
$factura = mysqli_query($conexion, "SELECT descuento,interes, total FROM factura WHERE numero_factura='$numFactura'");
while ($row = mysqli_fetch_assoc($factura)) {
}
    //$pdf->Cell(15, 5, $row['descuento'], 0, 0, 'L');
    $pdf->Cell(34, 5, "", 0, 0, 'L');
    $pdf->Cell(5, 5, "$".$supertotal, 0, 0, 'L');
    $pdf->Ln(2);

//$pdf->Ln();
//$pdf->SetFont('Arial', 'B', 5);
//$pdf->Cell(15, 5, utf8_decode("Tipo de Venta: "), 0, 0, 'L');
//$pdf->SetFont('Arial', '', 5);
//$pdf->Cell(7, 5, $datosfac['tipoventa'], 0, 0, 'L');
/*$pdf->Ln();
$pdf->SetFont('Arial', 'B', 5);
$pdf->Cell(16, 5, utf8_decode("Medio de Pago: "), 0, 0, 'L');
$pdf->SetFont('Arial', '', 5);
$pdf->Cell(7, 5, $datosfac['mediopago'], 0, 0, 'L');*/


	$pdf->SetFont('Arial', '', 11);
	$pdf->Output();

	
?>