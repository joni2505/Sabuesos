<?php
require_once '../../conexion.php';
require_once 'fpdf/fpdf.php';
$config = mysqli_query($conexion, "SELECT * FROM configuracion");
$datos = mysqli_fetch_assoc($config);
date_default_timezone_set('America/Argentina/Buenos_Aires');
$feha_actual=date("d-m-Y");
date_default_timezone_set('America/Argentina/Buenos_Aires');
$hora_actual=date("H:i:s");
$numFactura = $_GET['factura'];

//$idusuario = $_GET['idusuario3'];
//$idcuota = $_GET['id'];
    
       /* $factura = mysqli_query($conexion, "SELECT producto.nombre_producto, producto.codigo_producto'codigo',
        ventas.cantidad, ventas.subtotal'precio', ventas.descuento, ventas.interes,  ventas.total_venta, usuario.usuario'vendedor', observaciones  FROM cuentas 
        INNER JOIN ventas on cuentas.numero_factura=ventas.numero_factura
        INNER JOIN producto on ventas.idproducto=producto.idproducto
        INNER JOIN usuario on cuentas.idusuario=usuario.idusuario  WHERE cuentas.numero_factura='$numFactura'");
        $datosfac = mysqli_fetch_assoc($factura);

        //consultar datos del cliente
        $cliente = mysqli_query($conexion, "SELECT cuentas.numero_factura, cliente.nombre, cliente.apellido, cliente.direccion, cliente.celular FROM cuentas
        INNER JOIN cliente on cuentas.idcliente=cliente.idcliente WHERE cuentas.numero_factura='$numFactura'");
        $datosClie = mysqli_fetch_assoc($cliente);*/



?>
<!DOCTYPE HTML5>
<html>
	<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Boleta Cuenta Corriente</title>
    
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

<table class="ticket" align="center" style='width:100%;'  border=1 cellspacing=1 cellpadding=1>
<td>
<table  align="center" cellpadding=3 style="border-collapse: collapse;" border="1";>
<img class="img-thumbnail" src="sabueso.jpg" width="150" align="left">
<p style='text-align:left; font-size:11px;'><b>Celular:</b> <?php echo $datos['telefono'];?></p>
<p style='text-align:left; font-size:11px;'><b>Direccion:</b> <?php echo $datos['direccion'];?></p>
<p style='text-align:left; font-size:11px;'><b>Correo:</b> <?php echo $datos['email'];?></p>

    <?php 
    
    $factura = mysqli_query($conexion, "SELECT numero_factura, cliente.nombre, cliente.apellido, cliente.direccion, cliente.celular, usuario.usuario'vendedor', observaciones FROM cuenta_corrientes
    INNER JOIN cliente on cuenta_corrientes.idcliente=cliente.idcliente
    INNER JOIN usuario on cuenta_corrientes.idusuario=usuario.idusuario WHERE cuenta_corrientes.numero_factura='$numFactura'");
        $datosfac = mysqli_fetch_assoc($factura);  
        
    ?>
   
    
    <span style="border-image: initial; border: 0px solid blue; font-size: 20px; text-align:left; ">Nota Pedido    </span> <span style="border-image: initial; border: 1px solid black; font-size: 40px; text-align:left  ">X</span> <span style="border-image: initial; border: 0px solid blue; font-size: 20px; text-align:left ">Precio Especial</span>
    <p style='text-align:center'>Cuenta Corriente: <?php echo $datosfac['numero_factura'] ?></p>
    <p style='text-align:right'>N°Factura: <?php echo $datosfac['numero_factura']."..." ?></p>
    <p style='text-align:right'>Fecha: <?php echo $feha_actual?> -- Hora:<?php echo $hora_actual."..."?></p>
    <p style='text-align:right'>Vendedor: <?php echo $datosfac['vendedor']."..." ?></p>

    
    Cliente: <?php echo $datosfac['nombre'] ?><br>
    Direccion: <?php echo $datosfac['direccion'] ?><br>
    Celular: <?php echo $datosfac['celular'] ?><br>
    Observaciones: <?php echo $datosfac['observaciones'] ?><br><br>

    <thead class="thead-dark">
    <tr width="100"  rowspan="4" bgcolor="#7B68EE">

                <th>Cant.</th>
                 <th>Producto</th>
                 <th>Precio</th>
                 <th>Desc.%</th>
                 <th>Precio Final</th>
                 <th>SubTotal</th>
                 
    </tr>
</thead>
<tbody>
             <?php
                require_once '../../conexion.php';
                $sum = 0;
                    $query = mysqli_query($conexion, "SELECT carrito_cuenta.cantidad, producto.nombre_producto,carrito_cuenta.precio_producto, carrito_cuenta.descuento, carrito_cuenta.subtotal'preciofinal', carrito_cuenta.total'subtotal', usuario.usuario'vendedor', observaciones FROM cuenta_corrientes
                    INNER JOIN carrito_cuenta on cuenta_corrientes.numero_factura=carrito_cuenta.numero_factura
                    INNER JOIN producto on carrito_cuenta.idproducto=producto.idproducto
                    INNER JOIN usuario on cuenta_corrientes.idusuario=usuario.idusuario  WHERE cuenta_corrientes.numero_factura='$numFactura'");

               
                $i=1;
                $result = mysqli_num_rows($query);
                if ($result > 0) {
                    while ($data = mysqli_fetch_assoc($query)) {
                        
                ?>
                     <tr style="" colspan="23" align="center">
                       
                         <td style='font-size: 14px;'><?php echo $data['cantidad']; ?></td>
                         <td style='font-size: 14px;'><?php echo $data['nombre_producto']; ?></td>
                         <td style='font-size: 14px;'><?php echo $data['precio_producto']; ?></td>
                         <td style='font-size: 14px;'><?php echo $data['descuento']; ?></td>
                         <td style='font-size: 14px;'><?php echo "$".$data['preciofinal']; ?></td>
                         <td style='font-size: 14px;'><?php echo "$".$data['subtotal']; ?></td>
                  
             
                         
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
                <th>Bultos</th>
                <th>Total</th>
                
   </tr>
   <tr style=" border: inset 0pt" colspan="23" align="center">
                    
                     
                         <td style='font-size: 14px;'></td>
                         <td style='font-size: 14px;'></td>
                         <td style='font-size: 14px;'></td>
                         <td style='font-size: 14px;'></td>
                         
                         <td style='font-size: 14px;'><?php echo $sum ?></td>
                         <?php 
$factura = mysqli_query($conexion, "SELECT gran_total FROM cuenta_corrientes WHERE numero_factura='$numFactura'");
while ($row = mysqli_fetch_assoc($factura)) {
 
   $total = $row['gran_total'];
    
}

?>
                         <td style='font-size: 14px;'><?php echo"$".$total ?></td>
                         
                     </tr>

         </tbody>

</table>
<!--<br><b>Total de Bultos: </b><?php //echo $sum ?>
<br><b>Total a pagar:</b> <?php //echo"$".$total ?><br>-->


</td>


<td><table  align="center" border=1  cellspacing=1 cellpadding=3 style="border-collapse: collapse;" border="1";>
<tr>
<img class="img-thumbnail" src="sabueso.jpg" width="150" align="left">
<p style='text-align:left; font-size:11px;'><b>Celular:</b> <?php echo $datos['telefono'];?></p>
<p style='text-align:left; font-size:11px;'><b>Direccion:</b> <?php echo $datos['direccion'];?></p> 
<p style='text-align:left; font-size:11px;'><b>Correo:</b> <?php echo $datos['email'];?></p>

    <?php 
    $factura = mysqli_query($conexion, "SELECT numero_factura, cliente.nombre, cliente.apellido, cliente.direccion, cliente.celular, usuario.usuario'vendedor', observaciones FROM cuenta_corrientes
    INNER JOIN cliente on cuenta_corrientes.idcliente=cliente.idcliente
    INNER JOIN usuario on cuenta_corrientes.idusuario=usuario.idusuario WHERE cuenta_corrientes.numero_factura='$numFactura'");
        $datosfac = mysqli_fetch_assoc($factura);  
        
    ?>

    <span style="border-image: initial; border: 0px solid blue; font-size: 20px; text-align:left; ">Nota Pedido    </span> <span style="border-image: initial; border: 1px solid black; font-size: 40px; text-align:left  ">X</span> <span style="border-image: initial; border: 0px solid blue; font-size: 20px; text-align:left ">Precio Especial</span>
    <p style='text-align:center'>Cuenta Corriente: <?php echo $datosfac['numero_factura'] ?></p>
    <p style='text-align:right'>N°Factura: <?php echo $datosfac['numero_factura'] ?></p>
    <p style='text-align:right'>Fecha: <?php echo $feha_actual?> -- Hora:<?php echo $hora_actual?></p>
    <p style='text-align:right'>Vendedor: <?php echo $datosfac['vendedor'] ?></p>
   
    
    Cliente: <?php echo $datosfac['nombre'] ?><br>
    Direccion: <?php echo $datosfac['direccion'] ?><br>
    Celular: <?php echo $datosfac['celular'] ?><br>
    Observaciones: <?php echo $datosfac['observaciones'] ?><br><br>

    <thead class="thead-dark">
    <tr width="100"  rowspan="4" bgcolor="#7B68EE">
                <th>Cant.</th>
                <th>Producto</th>
                <th>Precio</th>
                <th>Desc.%</th>
                <th>Precio Final</th>
                <th>SubTotal</th>

</tr>
</thead>
<tbody>
             <?php
                require_once '../../conexion.php';
                $sum = 0;
                    $query = mysqli_query($conexion, "SELECT carrito_cuenta.cantidad, producto.nombre_producto,carrito_cuenta.precio_producto, carrito_cuenta.descuento, carrito_cuenta.subtotal'preciofinal', carrito_cuenta.total'subtotal', usuario.usuario'vendedor', observaciones FROM cuenta_corrientes
                    INNER JOIN carrito_cuenta on cuenta_corrientes.numero_factura=carrito_cuenta.numero_factura
                    INNER JOIN producto on carrito_cuenta.idproducto=producto.idproducto
                    INNER JOIN usuario on cuenta_corrientes.idusuario=usuario.idusuario  WHERE cuenta_corrientes.numero_factura='$numFactura'");

               
                $i=1;
                $result = mysqli_num_rows($query);
                if ($result > 0) {
                    while ($data = mysqli_fetch_assoc($query)) {
                        
                ?>
                     <tr style= colspan="23" align="center">
                    
                     <td style='font-size: 14px;'><?php echo $data['cantidad']; ?></td>
                         <td style='font-size: 14px;'><?php echo $data['nombre_producto']; ?></td>
                         <td style='font-size: 14px;'><?php echo $data['precio_producto']; ?></td>
                         <td style='font-size: 14px;'><?php echo $data['descuento']; ?></td>
                         <td style='font-size: 14px;'><?php echo "$".$data['preciofinal']; ?></td>
                         <td style='font-size: 14px;'><?php echo "$".$data['subtotal']; ?></td>
                         
                         
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
                <th>Bultos</th>
                <th>Total</th>
                
   </tr>
   <tr style=" border: inset 0pt" colspan="23" align="center">
                    
                     
                         <td style='font-size: 14px;'></td>
                         <td style='font-size: 14px;'></td>
                         <td style='font-size: 14px;'></td>
                         <td style='font-size: 14px;'></td>
                         
                         <td style='font-size: 14px;'><?php echo $sum ?></td>
                         <?php 
$factura = mysqli_query($conexion, "SELECT gran_total FROM cuenta_corrientes WHERE numero_factura='$numFactura'");
while ($row = mysqli_fetch_assoc($factura)) {
 
   $total = $row['gran_total'];
    
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
