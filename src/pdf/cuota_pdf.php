<?php
require_once '../../conexion.php';
require_once 'fpdf/fpdf.php';
//$pdf = new FPDF($orientation='P',$unit='mm', array(105,150));
//$pdf = new FPDF('P', 'mm', 'letter');
$pdf = new FPDF('P','mm','A4');
$pdf->AddPage();
//$pdf->SetMargins(4, 4, 4);
$pdf->SetMargins(10, 10, 10);
$pdf->SetTitle("Comprobante de Pago");
$pdf->SetFont('Arial','B',12); 
$pdf->Image("../../assets/img/sabueso.jpg", 11, 0, 60, 20, 'JPG');
$pdf->Ln(12);
$config = mysqli_query($conexion, "SELECT * FROM configuracion");
$datos = mysqli_fetch_assoc($config);

$idcuota = $_GET['idcuota'];   
        //consultar datos del cliente
        $cliente = mysqli_query($conexion, "SELECT cuotas.numero_factura, cliente.nombre, cliente.apellido, cliente.direccion, cliente.celular, cuentas.total_inicio FROM cuentas
        INNER JOIN cliente on cuentas.idcliente=cliente.idcliente
        INNER JOIN cuotas on cuentas.idcuenta=cuotas.idcuenta WHERE cuotas.idcuota='$idcuota'");
        $datosClie = mysqli_fetch_assoc($cliente);

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
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(25, 5, utf8_decode("N°Factura: "), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(40, 5, $datosClie['numero_factura']." "."Cuenta Corriente", 0, 0, 'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(29, 5, utf8_decode("Total Apertura: "), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(7, 5, "$".$datosClie['total_inicio'], 0, 0, 'L');
$pdf->Ln(7);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(10, 5, utf8_decode("Clte: "), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(43, 5, $datosClie['nombre'], 0, 0, 'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(20, 5, utf8_decode("Direccion: "), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(35, 5, $datosClie['direccion'], 0, 0, 'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(15, 5, utf8_decode("Celular: "), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(12, 5, $datosClie['celular'], 0, 0, 'L');
$pdf->Ln(7);
$pdf->SetFont('Arial', 'B', 11);
$pdf->SetFillColor(0, 0, 0);
$pdf->SetTextColor(255, 255, 255);
//$pdf->Cell(196, 5, "Datos del Cliente", 1, 1, 'C', 1);
//$pdf->SetTextColor(0, 0, 0);
//$pdf->Cell(20, 5, utf8_decode('#'), 0, 0, 'L');
$pdf->Ln(1);
$pdf->Cell(25, 5, utf8_decode('N°Factura'), 0, 0, 'L',1);
$pdf->Cell(25, 5, utf8_decode('Pago'), 0, 0, 'L',1);
$pdf->Cell(40, 5, utf8_decode('Fecha de Pago'), 0, 0, 'L',1);
$pdf->Cell(40, 5, utf8_decode('Importe Entregado'), 0, 0, 'L',1);
$pdf->Cell(40, 5, utf8_decode('Saldo Pendiente'), 0, 0, 'L',1);
//$pdf->Cell(27, 5, utf8_decode('Total Cuenta'), 0, 0, 'L',1);
$pdf->Ln(7);



$contador = 1;
$sum = 0;
$factura1 = mysqli_query($conexion, "SELECT cuotas.numero_factura, cuota, cuotas.fecha, cuotas.importe, cuotas.saldo, cuentas.total FROM cuotas
INNER JOIN cuentas on cuotas.idcuenta=cuentas.idcuenta  WHERE cuotas.idcuota='$idcuota'");
while ($row = mysqli_fetch_assoc($factura1)) {
    //$pdf->Cell(3, 5, $contador, 0, 0, 'L');
    $pdf->SetFont('Arial', '', 11);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(25, 5, $row['numero_factura'], 0, 0, 'L');
    $pdf->Cell(25, 5, $row['cuota'], 0, 0, 'L');
    $pdf->Cell(40, 5, $row['fecha'], 0, 0, 'L');
    $pdf->Cell(40, 5, "$".$row['importe'], 0, 0, 'L');
    $pdf->Cell(40, 5, "$".$row['saldo'], 0, 0, 'L');
    //$pdf->Cell(25, 5, "$".$row['total'], 0, 0, 'L');
    $pdf->Ln(7);
    $contador++;

}

$pdf->Output("cuenta corriente.pdf", "I");


?>