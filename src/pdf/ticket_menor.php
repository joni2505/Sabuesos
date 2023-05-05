<?php

require_once '../../conexion.php';
require_once 'fpdf/fpdf.php';
require_once('qrcode/qrcode.class.php');
//require_once('pdfs/fusion.php');


class PDF extends FPDF
{
    // Cabecera de página
		function Header()
		{
			// Logo
			$this->Image('sabueso.jpg',10,8,33);
			// Arial bold 15
			$this->SetFont('Arial','B',15);
			// Movernos a la derecha
			$this->Cell(80);
			// Título
			$this->Cell(30,10,'Marko',1,0,'C');
			// Salto de línea
			$this->Ln(20);
		}

    function Footer()
        {
            $this->Image('sabueso.jpg',10,8,33);
            // Position at 1.5 cm from bottom
            $this->SetY(-15);

            // Arial italic 8
            $this->SetFont('Arial','I',8);

            // Page number
            $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}

}

$pdf = new FPDF($orientation='P',$unit='mm', array(58,150));
$pdf->AddPage();
$pdf->SetMargins(4, 4, 4);
$pdf->SetTitle("Comprobante de Pago");
$pdf->SetFont('Arial','B',8); 
$pdf->Image("sabueso.jpg", 2, 6, 43, 13, 'JPG');
$pdf->Ln(10);
$config = mysqli_query($conexion, "SELECT * FROM configuracion");
$datos = mysqli_fetch_assoc($config);

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
$textypos = 5;
//$pdf->Cell(5, $textypos, utf8_decode($datos['nombre']), 0, 1, 'L');
$pdf->SetFont('Arial', '', 5);
date_default_timezone_set('America/Argentina/Buenos_Aires');
$feha_actual=date("d-m-Y H:i:s");
$pdf->Ln();
$pdf->Cell(8, 5, utf8_decode("Fecha/Hs: $feha_actual"), 0, 0, 'L');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 5);
$pdf->SetFont('Arial', 'B', 5);
$pdf->Cell(9, 5, utf8_decode("Teléfono: "), 0, 0, 'L');
$pdf->SetFont('Arial', '', 5);
$pdf->Cell(12, 5, $datos['telefono'], 0, 1, 'L');
$pdf->SetFont('Arial', 'B', 5);
$pdf->Cell(9, 5, utf8_decode("Dirección: "), 0, 0, 'L');
$pdf->SetFont('Arial', '', 5);
$pdf->Cell(5, 5, utf8_decode($datos['direccion']), 0, 1, 'L');
$pdf->SetFont('Arial', 'B', 5);
$pdf->Cell(8, 5, "Correo: ", 0, 0, 'L');
$pdf->SetFont('Arial', '', 5);
$pdf->Cell(5, 5, utf8_decode($datos['email']), 0, 1, 'L');
$pdf->SetFont('Arial', 'B', 5);
$pdf->Cell(8, 5, "---------------------------------------------------------------", 0, 0, 'L');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 5);
$pdf->Cell(10, 5, utf8_decode("N°Factura: "), 0, 0, 'L');
$pdf->SetFont('Arial', '', 5);
$pdf->Cell(7, 5, $datosfac['numero_factura'], 0, 0, 'L');
$pdf->Ln();
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
$pdf->Cell(20, 5, utf8_decode('Productos:'), 0, 0, 'L');
$pdf->Cell(11, 5, utf8_decode('Cantidad:'), 0, 0, 'L');
$pdf->Cell(10, 5, utf8_decode('Subtotal:'), 0, 0, 'L');
$pdf->Ln();
$pdf->SetFont('Arial', '', 4);
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
    $pdf->Cell(28, 5, $row['nombre_producto'], 0, 0, 'L');
    $pdf->Cell(3, 5, $row['cantidad'], 0, 0, 'L');
    $pdf->Cell(5, 5, "$".$row['total_venta'], 0, 0, 'L');
    $sub = $row['total_venta'];
    $supertotal = $supertotal + $sub;
    $cantidad = $row['cantidad'];
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
$pdf->Cell(7, 5, utf8_decode(' '), 0, 0, 'L');
$pdf->Cell(10, 3, utf8_decode('Total:'), 0, 0, 'L');
$pdf->Ln();
$pdf->SetFont('Arial', '', 5);

$factura = mysqli_query($conexion, "SELECT descuento,interes, total FROM factura WHERE numero_factura='$numFactura'");
while ($row = mysqli_fetch_assoc($factura)) {
}
    //$pdf->Cell(15, 5, $row['descuento'], 0, 0, 'L');
    $pdf->Cell(30, 5, "", 0, 0, 'L');
    $pdf->Cell(5, 5, "$".$supertotal, 0, 0, 'L');
    $pdf->Ln(2);

$pdf->Ln();
$pdf->SetFont('Arial', 'B', 5);
$pdf->Cell(15, 5, utf8_decode("Tipo de Venta: "), 0, 0, 'L');
$pdf->SetFont('Arial', '', 5);
$pdf->Cell(7, 5, $datosfac['tipoventa'], 0, 0, 'L');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 5);
$pdf->Cell(16, 5, utf8_decode("Medio de Pago: "), 0, 0, 'L');
$pdf->SetFont('Arial', '', 5);
$pdf->Cell(7, 5, $datosfac['mediopago'], 0, 0, 'L');

include 'afip.php-master\src\Afip.php';
//$afip = new Afip(array('CUIT' => 20397385028));
$afip = new Afip([
    'CUIT'=> 20403303462, //<-- ojo ahi!
    'cert' => 'wsaa_homologacion.pem',
    'key'=> 'clave-antonio.key',
    'production' => FALSE
    ]);

    $data = array(
        'CantReg' 	=> 1,  // Cantidad de comprobantes a registrar
        'PtoVta' 	=> 1,  // Punto de venta
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
    $pdf->Ln();
    $pdf->SetFont('Arial', 'B', 5);
    $pdf->Cell(9, 5, utf8_decode("CEA N°: "), 0, 0, 'L');
    $pdf->SetFont('Arial', '', 5);
    $pdf->Cell(7, 5, $res['CAE'], 0, 0, 'L');
    $pdf->Ln();
    $pdf->SetFont('Arial', 'B', 5);
    $pdf->Cell(14, 5, utf8_decode("Vencimiento: "), 0, 0, 'L');
    $pdf->SetFont('Arial', '', 5);
    $pdf->Cell(7, 5, $res['CAEFchVto'], 0, 0, 'L');
    $res['CAE']; //CAE asignado el comprobante
    $res['CAEFchVto']; //Fecha de vencimiento del CAE (yyyy-mm-dd)
    //$res['voucher_number']; //Número asignado al comprobante
    /*echo 'CAE: ';
    print_r($res['CAE']);
    echo '<br>';
    echo 'F/V: ';
    print_r($res['CAEFchVto']);
    echo '<br>';
    echo 'N°Factura: ';
    print_r($res['voucher_number']);
    echo '<br>';
    echo 'TOTAL: ';
    print_r('$'.$data['ImpTotal']);
    echo '<br>';*/
    $pdf->Ln();
    //$pdf->Image("afip.png", 2,$pdf->GetY(), 6, 15, 10, 'PNG');
    $pdf->Image('afip.png', 0, $pdf->GetY(),15, 7.10);
    $pdf->SetFont('Arial', 'B', 3.6);
    $pdf->Cell(9, 5, "", 0, 0, 'L');
    $pdf->Cell(9, 5, utf8_decode("Comprobante Autorizado "), 0, 0, 'L');
    $pdf->SetFont('Arial', 'B', 5);
    $pdf->Cell(9, 5, "", 0, 0, 'L');
    $pdf->Cell(8, 3, utf8_decode("CAE N°: "), 0, 0, 'L');
    $pdf->SetFont('Arial', '', 5);
    $pdf->Cell(7, 3, $res['CAE'], 0, 0, 'L');
    $pdf->Ln();
    $pdf->SetFont('Arial', 'B', 5);
    $pdf->Cell(27, 5, "", 0, 0, 'L');
    $pdf->Cell(13, 3, utf8_decode("Vencimiento: "), 0, 0, 'L');
    $pdf->SetFont('Arial', '', 5);
    $pdf->Cell(7, 3, $res['CAEFchVto'], 0, 0, 'L');
    
    $qrcode = new QRcode('your message here', 'H');
    //$pdf->AliasNbPages();
    //$pdf->SetFont('Arial','',14);
    $pdf->AddPage('P', 'Letter', 0);
    //$pdf->SetFont('Arial','',10);
    $code='ABCDEFG1234567890AbCdEf';
    //$pdf->Code128(50,230,$code,125,20);
    $pdf->SetXY(5,5);
    $pdf->Write(5,$code);
    $qrcode->displayFPDF($pdf, 5, 5, 5);
    
    
    
    /*class MiFactura{
    
        function generarFacturaPDF($data){
            $qrcode = new QRcode('your message here', 'H');
            $pdf = new FormatPDF();
            $pdf->dataEmpresa($data);
            $pdf->dataFactura($data);
            $pdf->AliasNbPages();
            $pdf->SetFont('Arial','',14);
            $pdf->AddPage('P', 'Letter', 0);
            $pdf->cliente($data);
            $pdf->detalle($data);
            $pdf->totalizacion();
            $pdf->SetFont('Arial','',10);
            $code='ABCDEFG1234567890AbCdEf';
            $pdf->Code128(50,230,$code,125,20);
            $pdf->SetXY(90,250);
            $pdf->Write(5,$code);
            $qrcode->displayFPDF($pdf, 169, 10, 36);
            $pdf->Output();
        }
    }*/

    $pdf->SetFont('Times','',12);
    $pdf->Output("ticket.pdf", "I");
    exit;
    

?>
