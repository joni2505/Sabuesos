<?php 
//include_once "includes/header.php";
require_once '../../conexion.php';

//datos afip factura electronica
include 'afip.php-master\src\Afip.php';
//$afip = new Afip(array('CUIT' => 20397385028));
$afip = new Afip([
    'CUIT'=> 20397385028, //<-- ojo ahi!
    'cert' => 'wsfe-sga.pem',
    'key'=> 'privada.key'
    ]);

//factura electronica     
$data = array(
	'CantReg' 		=> 1, // Cantidad de comprobantes a registrar
	'PtoVta' 		=> 1, // Punto de venta
	'CbteTipo' 		=> 6, // Tipo de comprobante (ver tipos disponibles) 
	'Concepto' 		=> 1, // Concepto del Comprobante: (1)Productos, (2)Servicios, (3)Productos y Servicios
	'DocTipo' 		=> 80, // Tipo de documento del comprador (ver tipos disponibles)
	'DocNro' 		=> 20111111112, // Numero de documento del comprador
	'CbteDesde' 	=> 1, // Numero de comprobante o numero del primer comprobante en caso de ser mas de uno
	'CbteHasta' 	=> 1, // Numero de comprobante o numero del ultimo comprobante en caso de ser mas de uno
	'CbteFch' 		=> intval(date('Ymd')), // (Opcional) Fecha del comprobante (yyyymmdd) o fecha actual si es nulo
	'ImpTotal' 		=> 128.8, // Importe total del comprobante
	'ImpTotConc' 	=> 0, // Importe neto no gravado
	'ImpNeto' 		=> 100, // Importe neto gravado
	'ImpOpEx' 		=> 0, // Importe exento de IVA
	'ImpIVA' 		=> 21, //Importe total de IVA
	'ImpTrib' 		=> 7.8, //Importe total de tributos
	'FchServDesde' 	=> NULL, // (Opcional) Fecha de inicio del servicio (yyyymmdd), obligatorio para Concepto 2 y 3
	'FchServHasta' 	=> NULL, // (Opcional) Fecha de fin del servicio (yyyymmdd), obligatorio para Concepto 2 y 3
	'FchVtoPago' 	=> NULL, // (Opcional) Fecha de vencimiento del servicio (yyyymmdd), obligatorio para Concepto 2 y 3
	'MonId' 		=> 'PES', //Tipo de moneda usada en el comprobante (ver tipos disponibles)('PES' para pesos argentinos) 
	'MonCotiz' 		=> 1, // Cotización de la moneda usada (1 para pesos argentinos)  
	
	'Tributos' 		=> array( // (Opcional) Tributos asociados al comprobante
		array(
			'Id' 		=>  99, // Id del tipo de tributo (ver tipos disponibles) 
			'Desc' 		=> 'Ingresos Brutos', // (Opcional) Descripcion
			'BaseImp' 	=> 150, // Base imponible para el tributo
			'Alic' 		=> 5.2, // Alícuota
			'Importe' 	=> 7.8 // Importe del tributo
		)
	), 
	'Iva' 			=> array( // (Opcional) Alícuotas asociadas al comprobante
		array(
			'Id' 		=> 5, // Id del tipo de IVA (ver tipos disponibles) 
			'BaseImp' 	=> 100, // Base imponible
			'Importe' 	=> 21 // Importe 
		)
	)
);


    $res = $afip->ElectronicBilling->CreateNextVoucher($data);

    $res['CAE']; //CAE asignado el comprobante
    $res['CAEFchVto']; //Fecha de vencimiento del CAE (yyyy-mm-dd)
    $res['voucher_number']; //Número asignado al comprobante  
    print_r($res['ImpNeto']);
     

$config = mysqli_query($conexion, "SELECT * FROM configuracion");
$datos = mysqli_fetch_assoc($config);

date_default_timezone_set('America/Argentina/Buenos_Aires');
$feha_actual=date("d-m-Y");
date_default_timezone_set('America/Argentina/Buenos_Aires');
$hora_actual=date("H:i:s");
$numFactura = $_GET['factura'];

?>
<!DOCTYPE HTML5>
<html>
	<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Factura Electronica</title>
    
    <link href="../assets/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <link rel="stylesheet" href="../assets/js/jquery-ui/jquery-ui.min.css">
    <script src="../assets/js/all.min.js" crossorigin="anonymous"></script>
     <!--Imprecion orizontal -->
     <style>
/*@media print { .noprint { display:none; } }*/
table.ticket{
  border-collapse: collapse;
  background: whithe;
  border: 0px;
  border-spacing: 0px;
  padding: 0px;
  margin: 0px;
}
</style>

</script>
    
	</head >
    
	
    <!--<body onload="window.print()">-->
    <body>
<h4 class="font-weight-light my-4"><center>Hoja 1  --  Hoja 2</center></h4>

<table class="ticket" align="center" border=1 cellspacing=1 cellpadding=1 style='width:100%;' >
<tr>
<td><table  align="center" border=1  cellspacing=1 cellpadding=3 style="border-collapse: collapse;" border="1";><tr>
<img class="img-thumbnail" src="sabueso.jpg" width="200" align="left">
<p style='text-align:left; font-size:15px;'><b>Celular:</b> <?php echo $datos['telefono'];?></p>
<p style='text-align:left; font-size:15px;'><b>Direccion:</b> <?php echo $datos['direccion'];?></p>
<p style='text-align:left; font-size:13px;'><b>Correo:</b> <?php echo $datos['email'];?></p>

    <?php 
    
    $factura = mysqli_query($conexion, "SELECT cliente.direccion, cliente.nombre, cliente.celular, usuario.usuario, factura.numero_factura, total, ventas.descuento, ventas.interes, factura.importe, factura.cambio, factura.fecha, producto.codigo_producto'codigo', producto.nombre_producto, ventas.cantidad, factura.tipoventa, factura.mediopago, usuario.usuario'vendedor'
        FROM factura 
        INNER JOIN ventas on factura.numero_factura=ventas.numero_factura
        INNER JOIN producto on ventas.idproducto=producto.idproducto
        INNER JOIN cliente on factura.idcliente=cliente.idcliente
        INNER JOIN usuario on factura.idusuario=usuario.idusuario WHERE factura.numero_factura='$numFactura'");
        $datosfac = mysqli_fetch_assoc($factura);  
        
    ?>
   
    
    <span style="border-image: initial; border: 0px solid blue; font-size: 20px; text-align:left; ">Nota Pedido    </span> <span style="border-image: initial; border: 1px solid black; font-size: 40px; text-align:left  ">X</span> <span style="border-image: initial; border: 0px solid blue; font-size: 20px; text-align:left ">Precio Especial</span>
    <p style='text-align:left'>CAE: <?php echo $res['CAE']."..." ?></p>
    <p style='text-align:right'>N°Factura: <?php echo $datosfac['numero_factura']."..." ?></p>
    <p style='text-align:right'>Fecha: <?php echo $feha_actual?> -- Hora:<?php echo $hora_actual."..."?></p>
    <p style='text-align:right'>Vendedor: <?php echo $datosfac['vendedor']."..." ?></p>

    
    Cliente: <?php echo $datosfac['nombre'] ?><br>
    Direccion: <?php echo $datosfac['direccion'] ?><br>
    Celular: <?php echo $datosfac['celular'] ?><br><br>
    <thead class="thead-dark">
    <tr width="100"  rowspan="4">

                <th>Cant.</th>
                 <th>Producto</th>
                 <th>Precio</th>
                 <th>Peso</th>
                 <th>Desc.%</th>
                 <th>Precio Final</th>
                 <th>SubTotal</th>
                 
    </tr>
</thead>
<tbody>
             <?php
                require_once '../../conexion.php';
                $sum = 0;
                    $query = mysqli_query($conexion, "SELECT cliente.nombre, cliente.celular, usuario.usuario, factura.numero_factura, total, ventas.descuento, ventas.interes, factura.importe, factura.cambio, factura.fecha, producto.nombre_producto, producto.codigo_producto'codigo',
                    ventas.cantidad, factura.tipoventa, ventas.total_venta, factura.mediopago,ventas.gramos, ventas.subtotal, ventas.preciofinal FROM factura 
                            INNER JOIN ventas on factura.numero_factura=ventas.numero_factura
                            INNER JOIN producto on ventas.idproducto=producto.idproducto
                            INNER JOIN cliente on factura.idcliente=cliente.idcliente
                            INNER JOIN usuario on factura.idusuario=usuario.idusuario WHERE factura.numero_factura='$numFactura'");

               
                $i=1;
                $result = mysqli_num_rows($query);
                if ($result > 0) {
                    while ($data = mysqli_fetch_assoc($query)) {
                        
                ?>
                     <tr style="" colspan="23" align="center">
                       
                         <td style='font-size: 14px;'><?php echo $data['cantidad']; ?></td>
                         <?php 
                         if($data['gramos']>0){
                            echo "<td style='font-size: 14px;'>" . $data['nombre_producto']." "."(suelto)" . "</td>";
                            $gr=$data['gramos']."gr";
                         }else{

                            echo "<td style='font-size: 14px;'>" .$data['nombre_producto']. "</td>";
                            $gr="gr";
                         }
                         
                         ?>
                         
                         <td style='font-size: 14px;'><?php echo "$".$data['subtotal']; ?></td>
                         <td style='font-size: 14px;'><?php echo $gr; ?></td>
                         <td style='font-size: 14px;'><?php echo $data['descuento']; ?></td>
                         <td style='font-size: 14px;'><?php echo "$".$data['preciofinal']; ?></td>
                         <td style='font-size: 14px;'><?php echo "$".$data['total_venta']; ?></td>
                         
                     </tr>
                     
             <?php
             $cantidad = $data['cantidad'];
             $sum = $sum + $cantidad;

             $i++; }
                } ?>

<tr width="100"  rowspan="4" style=" border: inset 0pt">
                
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th>Bultos</th>
                <th>Total</th>
                
   </tr>
   <tr style=" border: inset 0pt" colspan="23" align="center">
                    
                     
                         <td style='font-size: 14px;'></td>
                         <td style='font-size: 14px;'></td>
                         <td style='font-size: 14px;'></td>
                         <td style='font-size: 14px;'></td>
                         <td style='font-size: 14px;'></td>
                         <td style='font-size: 14px;'><?php echo $sum ?></td>
                         <?php 
$factura = mysqli_query($conexion, "SELECT total FROM factura WHERE numero_factura='$numFactura'");
while ($row = mysqli_fetch_assoc($factura)) {
 
   $total = $row['total'];
    
}

?>
                         <td style='font-size: 14px;'><?php echo"$".$total ?></td>
                         
                     </tr>

         </tbody>

</table>
<!--<br><b>Total de Bultos: </b><?php //echo $sum ?>
<br><b>Total a pagar:</b> <?php //echo"$".$total ?><br>-->


</td>


<td><table  align="center" border=1  cellspacing=1 cellpadding=3 style="border-collapse: collapse;" border="1";><tr>
<tr>
<img class="img-thumbnail" src="sabueso.jpg" width="200" align="left">
<p style='text-align:left; font-size:15px;'><b>Celular:</b> <?php echo $datos['telefono'];?></p>
<p style='text-align:left; font-size:14px;'><b>Direccion:</b> <?php echo $datos['direccion'];?></p> 
<p style='text-align:left; font-size:13px;'><b>Correo:</b> <?php echo $datos['email'];?></p>

    <?php 
    $factura = mysqli_query($conexion, "SELECT cliente.direccion, cliente.nombre, cliente.celular, usuario.usuario, factura.numero_factura, total, ventas.descuento, ventas.interes, factura.importe, factura.cambio, factura.fecha, producto.codigo_producto'codigo', producto.nombre_producto, ventas.cantidad, factura.tipoventa, factura.mediopago, usuario.usuario'vendedor'
        FROM factura 
        INNER JOIN ventas on factura.numero_factura=ventas.numero_factura
        INNER JOIN producto on ventas.idproducto=producto.idproducto
        INNER JOIN cliente on factura.idcliente=cliente.idcliente
        INNER JOIN usuario on factura.idusuario=usuario.idusuario WHERE factura.numero_factura='$numFactura'");
        $datosfac = mysqli_fetch_assoc($factura);  
        
    ?>

    <span style="border-image: initial; border: 0px solid blue; font-size: 20px; text-align:left; ">Nota Pedido    </span> <span style="border-image: initial; border: 1px solid black; font-size: 40px; text-align:left  ">X</span> <span style="border-image: initial; border: 0px solid blue; font-size: 20px; text-align:left ">Precio Especial</span>
    <p style='text-align:right'>N°Factura: <?php echo $datosfac['numero_factura'] ?></p>
    <p style='text-align:right'>Fecha: <?php echo $feha_actual?> -- Hora:<?php echo $hora_actual?></p>
    <p style='text-align:right'>Vendedor: <?php echo $datosfac['vendedor'] ?></p>
 
    
    Cliente: <?php echo $datosfac['nombre'] ?><br>
    Direccion: <?php echo $datosfac['direccion'] ?><br>
    Celular: <?php echo $datosfac['celular'] ?><br><br>

    <thead class="thead-dark">
    <tr width="100"  rowspan="4">
                <th>Cant.</th>
                <th>Producto</th>
                <th>Precio</th>
                <th>Peso</th>
                <th>Desc.%</th>
                <th>Precio Final</th>
                <th>SubTotal</th>

</tr>
</thead>
<tbody>
             <?php
                require_once '../../conexion.php';
                $sum = 0;
                    $query = mysqli_query($conexion, "SELECT cliente.nombre, cliente.celular, usuario.usuario, factura.numero_factura, total, ventas.descuento, ventas.interes, factura.importe, factura.cambio, factura.fecha, producto.nombre_producto, producto.codigo_producto'codigo',
                    ventas.cantidad, factura.tipoventa, ventas.total_venta, factura.mediopago,ventas.gramos, ventas.subtotal, ventas.preciofinal FROM factura 
                            INNER JOIN ventas on factura.numero_factura=ventas.numero_factura
                            INNER JOIN producto on ventas.idproducto=producto.idproducto
                            INNER JOIN cliente on factura.idcliente=cliente.idcliente
                            INNER JOIN usuario on factura.idusuario=usuario.idusuario WHERE factura.numero_factura='$numFactura'");

               
                $i=1;
                $result = mysqli_num_rows($query);
                if ($result > 0) {
                    while ($data = mysqli_fetch_assoc($query)) {
                        
                ?>
                     <tr style= colspan="23" align="center">
                    
                         <td style='font-size: 14px;'><?php echo $data['cantidad']; ?></td>
                         <?php 
                         if($data['gramos']>0){
                            echo "<td style='font-size: 14px;'>" . $data['nombre_producto']." "."(suelto)" . "</td>";
                            $gr=$data['gramos']."gr";
                         }else{

                            echo "<td style='font-size: 14px;'>" .$data['nombre_producto']. "</td>";
                            $gr="gr";
                         }
                         
                         ?>
                         <td style='font-size: 14px;'><?php echo "$".$data['subtotal']; ?></td>
                         <td style='font-size: 14px;'><?php echo $gr; ?></td>
                         <td style='font-size: 14px;'><?php echo $data['descuento']; ?></td>
                         <td style='font-size: 14px;'><?php echo "$".$data['preciofinal']; ?></td>
                         <td style='font-size: 14px;'><?php echo "$".$data['total_venta']; ?></td>
                         
                     </tr>
             <?php

             $cantidad = $data['cantidad'];
             $sum = $sum + $cantidad;

             $i++; }
                } ?>

<tr width="100"  rowspan="4" style=" border: inset 0pt">
                
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th>Bultos</th>
                <th>Total</th>
                
   </tr>
   <tr style=" border: inset 0pt" colspan="23" align="center">
                    
                     
                         <td style='font-size: 14px;'></td>
                         <td style='font-size: 14px;'></td>
                         <td style='font-size: 14px;'></td>
                         <td style='font-size: 14px;'></td>
                         <td style='font-size: 14px;'></td>
                         <td style='font-size: 14px;'><?php echo $sum ?></td>
                         <?php 
$factura = mysqli_query($conexion, "SELECT total FROM factura WHERE numero_factura='$numFactura'");
while ($row = mysqli_fetch_assoc($factura)) {
 
   $total = $row['total'];
    
}

?>
                         <td style='font-size: 14px;'><?php echo"$".$total ?></td>
                         
                     </tr>

         </tbody>

</table>

<?php 
$factura = mysqli_query($conexion, "SELECT total FROM factura WHERE numero_factura='$numFactura'");
while ($row = mysqli_fetch_assoc($factura)) {
 
   $total = $row['total'];
    
}

?>

</td>

</tr>
</table> 
	</body>

    <script>

function printHTML() { 
  if (window.print) { 
    window.print();
  }
}
document.addEventListener("DOMContentLoaded", function(event) {
  printHTML(); 
});
        </script>


<!--<footer>
  <p>&copy; Sabuesos Petshop</p>
  <img class="img-thumbnail" src="QR.jpeg" width="100">

</footer>-->
</html>
