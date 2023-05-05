<?php
	require('fpdf/fpdf.php'); //Agregamos la librería
	require_once('qrcode/qrcode.class.php');
	include 'afip.php-master\src\Afip.php';
	require_once '../../conexion.php';

   /* Produccion 
   $afip = new Afip([
        'CUIT'=> (double)20403303462, //<-- ojo ahi!
        'cert' => 'sabuesosproduccion.crt',
        'key'=> 'key_antonio.key',
        'production' => true
        ]);
    */  
    /*omologacion*/
   /* $afip = new Afip([
        'CUIT'=> (double)20403303462, //<-- ojo ahi!
        'cert' => 'wsaa_homologacion.pem',
        'key'=> 'clave-antonio.key',
        'production' => false
        ]);  


        $server_status = $afip->RegisterScopeTen->GetServerStatus();
        /*echo 'Este es el estado del servidor:';
        echo '<pre>';
        print_r($server_status);
        echo '</pre>';*/
        
       /* $venta=8300;
        $neto = round($venta / 1.21, 2);
        $iva =  round($neto * 0.21, 2);
        $CbteTipo = 6;
        $PtoVta = 6;
        //$total = round($neto + $iva);
        $data = array(
            'CantReg' 	=> 1,  // Cantidad de comprobantes a registrar
            'PtoVta' 	=> 6,  // Punto de venta
            'CbteTipo' 	=> 6,  // Tipo de comprobante (ver tipos disponibles) 
            'Concepto' 	=> 1,  // Concepto del Comprobante: (1)Productos, (2)Servicios, (3)Productos y Servicios
            'DocTipo' 	=> 99, // Tipo de documento del comprador (99 consumidor final, ver tipos disponibles)
            'DocNro' 	=> 0,  // Número de documento del comprador (0 consumidor final)
            'CbteDesde' 	=> 1,  // Número de comprobante o numero del primer comprobante en caso de ser mas de uno
            'CbteHasta' 	=> 1,  // Número de comprobante o numero del último comprobante en caso de ser mas de uno
            'CbteFch' 	=> intval(date('Ymd')), // (Opcional) Fecha del comprobante (yyyymmdd) o fecha actual si es nulo
            'ImpTotal' 	=> $venta, // Importe total del comprobante
            'ImpTotConc' 	=> 0,   // Importe neto no gravado
            'ImpNeto' 	=> $neto, // Importe neto gravado
            'ImpOpEx' 	=> 0,   // Importe exento de IVA
            'ImpIVA' 	=> $iva,  //Importe total de IVA
            'ImpTrib' 	=> 0,   //Importe total de tributos
            'MonId' 	=> 'PES', //Tipo de moneda usada en el comprobante (ver tipos disponibles)('PES' para pesos argentinos) 
            'MonCotiz' 	=> 1,     // Cotización de la moneda usada (1 para pesos argentinos)  
            'Iva' 		=> array( // (Opcional) Alícuotas asociadas al comprobante
                array(
                    'Id' 		=> 5, // Id del tipo de IVA (5 para 21%)(ver tipos disponibles) 
                    'BaseImp' 	=> $neto, // Base imponible
                    'Importe' 	=> $iva // Importe 
                )
            ), 
        );*/
        //datos de contribuyente solo en produccion
        //$taxpayer_details = $afip->RegisterScopeFive->GetTaxpayerDetails(20397385028); //Devuelve los datos del contribuyente correspondiente al identificador 20111111111 
        //print_r($taxpayer_details);

        //Pido ultimo numero autorizado
       /* $nro = $afip->ElectronicBilling->GetLastVoucher($data['PtoVta'], $data['CbteTipo']);
        if(!is_numeric($nro)) {
            //echo "<br>Error al obtener el ultimo numero autorizado<br>";
        
        }
        $numero = $nro+1;

        //$res = $afip->ElectronicBilling->CreateVoucher($data);
        $res = $afip->ElectronicBilling->CreateNextVoucher($data);
        $cae = $res['CAE']; //CAE asignado el comprobante
        $caefvt = $res['CAEFchVto']; //Fecha de vencimiento del CAE (yyyy-mm-dd)
        $fechaComprobante = $res['CbteFch']=intval(date('Ymd'));*/

       /* echo '<h1>';
        echo 'Fecha: '.date( "d/m/Y", strtotime( $fechaComprobante));
        echo '<br>';
        echo 'N° Factura: '.'N°0006 0006'.$numero;
        echo '<br>';
        echo "Importe Neto: "."$".$res['ImpNeto']=$neto;
        echo '<br>';
        echo "Importe Iva: "."$".$res['ImpIVA']=$iva;
        echo '<br>';
        echo "Total: "."$".$res['ImpTotal']=$venta;
        echo '</h1>';
        
        echo '<h3>';
        //datos CAE QR y Fecha
        echo 'Comprobante Autorizado';
        echo '<br><br>';
        echo "CAE: ".$cae;
        echo '<br>';
        echo "Fecha Vencimiento: ".date( "d/m/Y", strtotime( $caefvt ));
        echo '</h3>';
        //QR = cuit + tipo de comprobante + punto de venta + cae + fecha ven cae
        $cuit = '20403303462';
        $qr = $cuit.$CbteTipo.$PtoVta.$cae.$caefvt;
        $qrcode = new QRcode($qr, 'H');
        //$qrcode->displayFPDF($this, 16, 135, 14);*/
        

    class PDF extends FPDF
	{
        
    //foter
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

    // Page footer
	public function Footer(){

        //afip
        $afip = new Afip([
            'CUIT'=> (double)20403303462, //<-- ojo ahi!
            'cert' => 'wsaa_homologacion.pem',
            'key'=> 'clave-antonio.key',
            'production' => false
            ]);

            /*$afip = new Afip([
                'CUIT'=> (double)20403303462, //<-- ojo ahi!
                'cert' => 'sabuesosproduccion.crt',
                'key'=> 'key_antonio.key',
                'production' => true
                ]);*/

            $server_status = $afip->RegisterScopeTen->GetServerStatus();
            /*echo 'Este es el estado del servidor:';
            echo '<pre>';
            print_r($server_status);
            echo '</pre>';*/
            
            $venta=8300;
            $neto = round($venta / 1.21, 2);
            $iva =  round($neto * 0.21, 2);
            $PtoVta = 5;
            $CbteTipo = 6;
            
            $data = array(
                'CantReg' 	=> 1,  // Cantidad de comprobantes a registrar
                'PtoVta' 	=> $PtoVta,  // Punto de venta
                'CbteTipo' 	=> $CbteTipo,  // Tipo de comprobante (ver tipos disponibles) 
                'Concepto' 	=> 1,  // Concepto del Comprobante: (1)Productos, (2)Servicios, (3)Productos y Servicios
                'DocTipo' 	=> 99, // Tipo de documento del comprador (99 consumidor final, ver tipos disponibles)
                'DocNro' 	=> 0,  // Número de documento del comprador (0 consumidor final)
                'CbteDesde' 	=> 1,  // Número de comprobante o numero del primer comprobante en caso de ser mas de uno
                'CbteHasta' 	=> 1,  // Número de comprobante o numero del último comprobante en caso de ser mas de uno
                'CbteFch' 	=> intval(date('Ymd')), // (Opcional) Fecha del comprobante (yyyymmdd) o fecha actual si es nulo
                'ImpTotal' 	=> $venta, // Importe total del comprobante
                'ImpTotConc' 	=> 0,   // Importe neto no gravado
                'ImpNeto' 	=> $neto, // Importe neto gravado
                'ImpOpEx' 	=> 0,   // Importe exento de IVA
                'ImpIVA' 	=> $iva,  //Importe total de IVA
                'ImpTrib' 	=> 0,   //Importe total de tributos
                'MonId' 	=> 'PES', //Tipo de moneda usada en el comprobante (ver tipos disponibles)('PES' para pesos argentinos) 
                'MonCotiz' 	=> 1,     // Cotización de la moneda usada (1 para pesos argentinos)  
                'Iva' 		=> array( // (Opcional) Alícuotas asociadas al comprobante
                    array(
                        'Id' 		=> 5, // Id del tipo de IVA (5 para 21%)(ver tipos disponibles) 
                        'BaseImp' 	=> $neto, // Base imponible
                        'Importe' 	=> $iva // Importe 
                    )
                ), 
            );
            //datos de contribuyente solo en produccion
            //$taxpayer_details = $afip->RegisterScopeFive->GetTaxpayerDetails(20397385028); //Devuelve los datos del contribuyente correspondiente al identificador 20111111111 
            //print_r($taxpayer_details);
    
            //Pido ultimo numero autorizado
            $nro = $afip->ElectronicBilling->GetLastVoucher($data['PtoVta'], $data['CbteTipo']);
            if(!is_numeric($nro)) {
                //echo "<br>Error al obtener el ultimo numero autorizado<br>";
            
            }
            $numero = $nro+1; 
    
            //$res = $afip->ElectronicBilling->CreateVoucher($data);
            $res = $afip->ElectronicBilling->CreateNextVoucher($data);
            $cae = $res['CAE']; //CAE asignado el comprobante
            $caefvt = $res['CAEFchVto']; //Fecha de vencimiento del CAE (yyyy-mm-dd)
            //$fechaComprobante = $res['CbteFch']=intval(date('Ymd'));

        // FPDF Position at 1.5 cm from bottom
		$this->SetY(-35);
		// Arial italic 8
		$this->SetFont('Arial','I',100);
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
		$this->Cell(8, 3, $cae, 0, 0, 'L');
		$this->Ln();
		$this->SetFont('Arial', 'B', 6);
		$this->Cell(17, 5, "", 0, 0, 'L');
		$this->Cell(14, 3, utf8_decode("Vencimiento: "), 0, 0, 'L');
		$this->SetFont('Arial', '', 6);
		$this->Cell(7, 3, date( "d/m/Y", strtotime( $caefvt ) ), 0, 0, 'L');

        //QR = cuit + tipo de comprobante + punto de venta + cae + fecha ven cae
        $cuit = '20403303462';
        $qr = $cuit.str_pad($CbteTipo, 3,"0",STR_PAD_LEFT).str_pad($PtoVta, 5, "0", STR_PAD_LEFT).$cae.$caefvt;
        $qrcode = new QRcode($qr, 'H');
        $qrcode->displayFPDF($this, 21, 110, 16); //dimencion left, espacion en hoja, tamaño
    }

    }


    //afip
    //afip
      $afip = new Afip([
        'CUIT'=> (double)20403303462, //<-- ojo ahi!
        'cert' => 'wsaa_homologacion.pem',
        'key'=> 'clave-antonio.key',
        'production' => false
        ]);
        /*$afip = new Afip([
            'CUIT'=> (double)20403303462, //<-- ojo ahi!
            'cert' => 'sabuesosproduccion.crt',
            'key'=> 'key_antonio.key',
            'production' => true
            ]);*/

        $server_status = $afip->RegisterScopeTen->GetServerStatus();
        /*echo 'Este es el estado del servidor:';
        echo '<pre>';
        print_r($server_status);
        echo '</pre>';*/
        $numFactura = $_GET['factura'];
        $supertotal = 0;
        $sum = 0;
        $contador = 0;
        $factura1 = mysqli_query($conexion, "SELECT cliente.nombre, cliente.celular, usuario.usuario, factura.numero_factura, total, factura.descuento, factura.interes, factura.importe, factura.cambio, factura.fecha, producto.nombre_producto,
	producto.precio_producto, ventas.interes, ventas.cantidad, factura.tipoventa, ventas.total_venta, factura.mediopago FROM factura 
			INNER JOIN ventas on factura.numero_factura=ventas.numero_factura
			INNER JOIN producto on ventas.idproducto=producto.idproducto
			INNER JOIN cliente on factura.idcliente=cliente.idcliente
			INNER JOIN usuario on factura.idusuario=usuario.idusuario WHERE factura.numero_factura='$numFactura'");
	while ($row = mysqli_fetch_assoc($factura1)) {
	
        //para afip sacar iva al precio
		$cantidad = $row['cantidad'];
		$sub = round($row['total_venta'] * $cantidad);
		$supertotal = round( $supertotal + $sub);
		$sum = round($sum + $cantidad);
		$contador++;

	}

        $venta=8300;
        $neto = round($venta / 1.21, 2);
        $iva =  round($neto * 0.21, 2);
        $PtoVta = 5;
        $CbteTipo = 6;
        $PtoVta = 5; //direccion velez sarfield
        $CbteTipo = 6;
        
        $data = array(
            'CantReg' 	=> 1,  // Cantidad de comprobantes a registrar
            'PtoVta' 	=> $PtoVta,  // Punto de venta
            'CbteTipo' 	=> $CbteTipo,  // Tipo de comprobante (ver tipos disponibles) 
            'Concepto' 	=> 1,  // Concepto del Comprobante: (1)Productos, (2)Servicios, (3)Productos y Servicios
            'DocTipo' 	=> 99, // Tipo de documento del comprador (99 consumidor final, ver tipos disponibles)
            'DocNro' 	=> 0,  // Número de documento del comprador (0 consumidor final)
            'CbteDesde' 	=> 1,  // Número de comprobante o numero del primer comprobante en caso de ser mas de uno
            'CbteHasta' 	=> 1,  // Número de comprobante o numero del último comprobante en caso de ser mas de uno
            'CbteFch' 	=> intval(date('Ymd')), // (Opcional) Fecha del comprobante (yyyymmdd) o fecha actual si es nulo
            'ImpTotal' 	=> $venta, // Importe total del comprobante
            'ImpTotConc' 	=> 0,   // Importe neto no gravado
            'ImpNeto' 	=> $neto, // Importe neto gravado
            'ImpOpEx' 	=> 0,   // Importe exento de IVA
            'ImpIVA' 	=> $iva,  //Importe total de IVA
            'ImpTrib' 	=> 0,   //Importe total de tributos
            'MonId' 	=> 'PES', //Tipo de moneda usada en el comprobante (ver tipos disponibles)('PES' para pesos argentinos) 
            'MonCotiz' 	=> 1,     // Cotización de la moneda usada (1 para pesos argentinos)  
            'Iva' 		=> array( // (Opcional) Alícuotas asociadas al comprobante
                array(
                    'Id' 		=> 5, // Id del tipo de IVA (5 para 21%)(ver tipos disponibles) 
                    'BaseImp' 	=> $neto, // Base imponible
                    'Importe' 	=> $iva // Importe 
                )
            ), 
        );
        //datos de contribuyente solo en produccion
        //$taxpayer_details = $afip->RegisterScopeFive->GetTaxpayerDetails(20397385028); //Devuelve los datos del contribuyente correspondiente al identificador 20111111111 
        //print_r($taxpayer_details);

        //Pido ultimo numero autorizado
        $nro = $afip->ElectronicBilling->GetLastVoucher($data['PtoVta'], $data['CbteTipo']);
        if(!is_numeric($nro)) {
            //echo "<br>Error al obtener el ultimo numero autorizado<br>";
        
        }
        $numero = $nro+1; 

        $res = $afip->ElectronicBilling->CreateNextVoucher($data);
        //$cae = $res['CAE']; //CAE asignado el comprobante
        //$caefvt = $res['CAEFchVto']; //Fecha de vencimiento del CAE (yyyy-mm-dd)
        $fechaComprobante = $res['CbteFch']=intval(date('Ymd'));

    //datos base de datos
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

    //fpdf estructura
    $pdf = new PDF($orientation='P',$unit='mm', array(59,128));
	$pdf->AliasNbPages();
	$pdf->AddPage();
	//body fpdf
	$pdf->SetMargins(2, 2, 2);
    $pdf->SetFillColor(0, 0, 0);
    //$pdf->SetTextColor(255, 255, 255);
    $pdf->SetFont('Arial','', 5);
	$pdf->Cell(2, 1, utf8_decode("----------------------------------------------------------------------------------------------------------------------------------------------------------------"), 0, 0, 'C');
    $pdf->Ln(3);
    $pdf->SetFont('Arial','', 10);
    $pdf->Cell(14, 5, utf8_decode("Factura "), 0, 0, 'L');
	$pdf->SetFont('Arial','B', 14);
	$pdf->Cell(6, 5, utf8_decode("B"), 0, 0, 'L');
	$pdf->SetFont('Arial','', 10);
	$pdf->Cell(2, 5, utf8_decode("N°00005 0000".$numero), 0, 0, 'L');
	$pdf->SetFont('Arial','', 5);
	$pdf->Ln();
	$pdf->Cell(4, 10, utf8_decode(""), 0, 0, 'L');
	$pdf->Cell(1, 1, utf8_decode("Original   Cod. 006  "), 0, 0, 'L');
    $pdf->Cell(15, 10, utf8_decode(""), 0, 0, 'L');
    $pdf->SetFont('Arial','', 7);
    $pdf->Cell(1, 2, utf8_decode("Fecha: ".date( "d/m/Y", strtotime( $fechaComprobante))), 0, 0, 'L');
   
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
        $pdf->Cell(25, 5, "TOTAL: $".$venta, 1, 0, 'L');
        $pdf->Ln(2);
    

        //salida fpdf
        $pdf->SetFont('Arial', '', 11);
        $pdf->Output();
            
?>