<?php
require_once '../../conexion.php';
require_once 'fpdf/fpdf.php';
//$pdf = new FPDF($orientation='P',$unit='mm', array(105,150));
//$pdf = new FPDF('P', 'mm', 'letter');
$pdf = new FPDF('P','mm','A4');
$pdf->AddPage();
//$pdf->SetMargins(4, 4, 4);
$pdf->SetMargins(10, 10, 10);
$pdf->SetTitle("Lista de Precios");
$pdf->SetFont('Arial','B',12); 
$pdf->Image("../../assets/img/sabueso.jpg", 11, 0, 60, 20, 'JPG');
$pdf->Ln(12);
$config = mysqli_query($conexion, "SELECT * FROM configuracion");
$datos = mysqli_fetch_assoc($config);

$idrubro = $_GET['idrubro'];
$idmarca = $_GET['idmarca'];

//$idrubro=1;
//$idmarca=1;
        

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

$pdf->SetFont('Arial', 'B', 11);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(196, 5, "Lista de Precios", 1, 1, 'C', 1);
$pdf->Ln(3);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(10, 5, utf8_decode('N°'), 0, 0, 'L');
$pdf->Cell(32, 5, utf8_decode('Codigo'), 0, 0, 'L');
$pdf->Cell(40, 5, 'Producto', 0, 0, 'L');
$pdf->Cell(40, 5, 'Precio X menor', 0, 0, 'L');
$pdf->Cell(40, 5, 'Precio X mayor', 0, 0, 'L');
$pdf->Cell(20, 5, 'Rubro', 0, 0, 'L');
$pdf->Cell(40, 5, 'Imagen', 0, 1, 'L');
$pdf->Ln(1);
$pdf->SetFont('Arial', '', 11);
$pdf->Ln();


if($idrubro>0 and $idmarca==0){

    $lista = mysqli_query($conexion, "SELECT idproducto, codigo_producto, nombre_producto,  precio_producto, precio_mayor, stock_producto,
unidad_producto, proveedores.nombre_proveedor'proveedor', producto.estado, rubro.nombre_rubro'rubro', marcas.nombre_marca'marca', imagen, ruta FROM producto
INNER JOIN proveedores on producto.idproveedor=proveedores.idproveedor
inner join rubro on producto.idrubro=rubro.idrubro
inner join marcas on producto.idmarca=marcas.idmarca WHERE producto.idrubro='$idrubro' ");


}else if($idrubro==0 and $idmarca>0){

    $lista = mysqli_query($conexion, "SELECT idproducto, codigo_producto, nombre_producto,  precio_producto, precio_mayor, stock_producto,
unidad_producto, proveedores.nombre_proveedor'proveedor', producto.estado, rubro.nombre_rubro'rubro', marcas.nombre_marca'marca', imagen, ruta FROM producto
INNER JOIN proveedores on producto.idproveedor=proveedores.idproveedor
inner join rubro on producto.idrubro=rubro.idrubro
inner join marcas on producto.idmarca=marcas.idmarca WHERE producto.idmarca='$idmarca' ");


}else if($idrubro>0 and $idmarca>0){

    $lista = mysqli_query($conexion, "SELECT idproducto, codigo_producto, nombre_producto,  precio_producto, precio_mayor, stock_producto,
unidad_producto, proveedores.nombre_proveedor'proveedor', producto.estado, rubro.nombre_rubro'rubro', marcas.nombre_marca'marca', imagen, ruta FROM producto
INNER JOIN proveedores on producto.idproveedor=proveedores.idproveedor
inner join rubro on producto.idrubro=rubro.idrubro
inner join marcas on producto.idmarca=marcas.idmarca WHERE producto.idmarca='$idmarca' AND producto.idrubro='$idrubro' ");

}
$contador=1;
while ($row = mysqli_fetch_assoc($lista)) {
    //$pdf->Cell(3, 5, $contador, 0, 0, 'L');
    $pdf->SetFont('Arial', '', 11);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(10, 5, $contador, 0, 0, 'L');
    $pdf->Cell(30, 5, $row['codigo_producto'], 0, 0, 'L');
    $pdf->Cell(52, 5, $row['nombre_producto'], 0, 0, 'L');
    $pdf->Cell(40, 5, "$".$row['precio_producto'], 0, 0, 'L');
    $pdf->Cell(30, 5, "$".$row['precio_mayor'], 0, 0, 'L');
    $pdf->Cell(25, 5, $row['rubro'], 0, 0, 'L');
    //$codigo = $row['imagen'];
    //$data = "data:image/jpeg;base64,$codigo";
    //$bin = base64_decode($codigo);
    //$im = imageCreateFromString($bin);
    //$img_file = 'assets/img/nuevo.jpeg';
    //$pdf->Cell(25, 5,base64_encode($row['imagen']), 0, 0, 'L');
    //header ('Content-Type: image/jpeg');
    //$pdf->Cell(25, 5,$row['ruta'], 0, 0, 'L');
    //$pdf->Cell(15,15, $pdf->Image("img-productos/".$row['ruta'], $pdf->GetX(), $pdf->GetY(),15,15),1);  
    //$logo = $row['ruta'];
    //$pdf->MemImage(base64_decode($logo), 100, 50);
    //$pdf->Cell(95,50,'$logo',1,0, 'C');
    
    $pdf->Ln(7);
    $contador++;

}
//file_put_contents('assets/img/nuevo.jpg', file_get_contents($data));

$pdf->Output("Lista Precios.pdf", "I");


?>