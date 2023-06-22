<?php

use PDF as GlobalPDF;

require('fpdf/fpdf.php'); //Agregamos la librería
require_once('qrcode/qrcode.class.php');
include 'afip.php-master\src\Afip.php';
require_once '../../conexion.php';
 //afip
 $afip = new Afip([
    'CUIT'=> (double)20403303462, //<-- ojo ahi!
    'cert' => 'wsaa_homologacion.pem',
    'key'=> 'clave-antonio.key',
    'production' => false
    ]);

    $venta=8300;
    $neto = round($venta / 1.21, 2);
    $iva =  round($neto * 0.21, 2);
    $CbteTipo = 6;
    $PtoVta = 6;

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
            $fechaComprobante = $res['CbteFch']=intval(date('Ymd'));
            
            
        
    class PDF extends FPDF{

    function foter(){
        
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
    
//fpdf estructura
$pdf = new PDF($orientation='P',$unit='mm', array(59,128));
$pdf->AliasNbPages();
$pdf->AddPage();


//salida fpdf
$pdf->SetFont('Arial', '', 11);
$pdf->Output();


?>