<?php 
//include_once "includes/header.php";
require_once '../../conexion.php';
$config = mysqli_query($conexion, "SELECT * FROM configuracion");
$datos = mysqli_fetch_assoc($config);

date_default_timezone_set('America/Argentina/Buenos_Aires');
$feha_actual=date("d-m-Y");
date_default_timezone_set('America/Argentina/Buenos_Aires');
$hora_actual=date("H:i:s");
$numFactura = $_GET['factura'];
$idlocal = $_GET['local'];
$idcliente = $_GET['cliente'];

?>
<!DOCTYPE HTML5>
<html>
	<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Boleta Cliente</title>
    <!-- CSS only -->
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

<table class="ticket" align="center" border=1 cellspacing=1 style='width:100%;' >

<td>
<table  align="center" cellpadding=3 style="border-collapse: collapse;" border="1";>
<img class="img-thumbnail" src="sabueso.jpg" width="200" align="left">
<p style='text-align:left; font-size:15px;'><b>Celular:</b> <?php echo $datos['telefono'];?></p>
<p style='text-align:left; font-size:13px;'><b>Direccion:</b> <?php echo $datos['direccion'];?></p>
<p style='text-align:left; font-size:13px;'><b>Correo:</b> <?php echo $datos['email'];?></p></td>

    <?php 
    
    $factura = mysqli_query($conexion, "SELECT factura.numero_factura, factura.total, usuario.nombre'vendedor', cliente.nombre, cliente.celular, cliente.direccion, factura.observacion FROM factura
    INNER JOIN usuario on factura.idusuario=usuario.idusuario
    INNER JOIN cliente on factura.idcliente=cliente.idcliente WHERE factura.numero_factura='$numFactura' and factura.idlocal = $idlocal and factura.idcliente=$idcliente");
        $datosfac = mysqli_fetch_assoc($factura);  
        
    ?>
    <?php
    //traer vendedor
    $result2 = mysqli_query($conexion, "SELECT usuario.nombre FROM factura LEFT JOIN usuario on factura.idvendedor=usuario.idusuario WHERE factura.numero_factura='$numFactura' and factura.idlocal = $idlocal and factura.idcliente=$idcliente");
            $result = mysqli_num_rows($result2);
          
            while($row2 = mysqli_fetch_array($result2))
            {
                $vendedor=$row2['nombre'];
            }
    ?>
    
    <span style="border-image: initial; border: 0px solid blue; font-size: 20px; text-align:left; ">Nota Pedido    </span> <span style="border-image: initial; border: 1px solid black; font-size: 40px; text-align:left  ">X</span> <span style="border-image: initial; border: 0px solid blue; font-size: 20px; text-align:left ">Precio Especial</span>
    <p style='text-align:right'>N°Factura: <?php echo $datosfac['numero_factura']."..." ?></p>
    <p style='text-align:right'>Fecha: <?php echo $feha_actual?> -- Hora:<?php echo $hora_actual."..."?></p>
    <p style='text-align:right'>Admin: <?php echo $datosfac['vendedor']."..." ?></p>
    <p style='text-align:right'>Vendedor: <?php echo $vendedor."...";"..." ?></p>

    
    Cliente: <?php echo $datosfac['nombre'] ?><br>
    Direccion: <?php echo $datosfac['direccion'] ?><br>
    Celular: <?php echo $datosfac['celular'] ?><br>
    Observacion: <?php echo $datosfac['observacion'] ?><br><br>
    <thead class="thead-dark">
    <tr width="100"  rowspan="4" bgcolor="#7B68EE">

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
                    $query = mysqli_query($conexion, "SELECT cliente.nombre, cliente.celular, usuario.nombre'vendedor', ventas.cantidad, producto.nombre_producto, ventas.subtotal, ventas.gramos, ventas.preciofinal, ventas.total_venta,
                    ventas.descuento, ventas.interes FROM ventas 
                    INNER JOIN producto on ventas.idproducto=producto.idproducto
                    INNER JOIN locales on ventas.idlocal=locales.idlocal 
                    INNER JOIN usuario on ventas.idusuario=usuario.idusuario
                    INNER JOIN cliente on ventas.idcliente=cliente.idcliente WHERE numero_factura=$numFactura and ventas.idcliente=$idcliente and ventas.idlocal=$idlocal");

               
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
$factura = mysqli_query($conexion, "SELECT total FROM factura WHERE numero_factura='$numFactura' and factura.idlocal = $idlocal and factura.idcliente=$idcliente");
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


<td><table  align="center" border=1  cellspacing=1 cellpadding=3 style="border-collapse: collapse;" border="1";>
<img class="img-thumbnail" src="sabueso.jpg" width="200" align="left">
<p style='text-align:left; font-size:15px;'><b>Celular:</b> <?php echo $datos['telefono'];?></p>
<p style='text-align:left; font-size:13px;'><b>Direccion:</b> <?php echo $datos['direccion'];?></p> 
<p style='text-align:left; font-size:13px;'><b>Correo:</b> <?php echo $datos['email'];?></p></td>

    <?php 
    $factura = mysqli_query($conexion, "SELECT factura.numero_factura, factura.total, usuario.nombre'vendedor', cliente.nombre, cliente.celular, cliente.direccion, factura.observacion FROM factura
    INNER JOIN usuario on factura.idusuario=usuario.idusuario
    INNER JOIN cliente on factura.idcliente=cliente.idcliente WHERE factura.numero_factura='$numFactura' and factura.idlocal = $idlocal and factura.idcliente=$idcliente");
        $datosfac = mysqli_fetch_assoc($factura);  
        
    ?>

    <span style="border-image: initial; border: 0px solid blue; font-size: 20px; text-align:left; ">Nota Pedido    </span> <span style="border-image: initial; border: 1px solid black; font-size: 40px; text-align:left  ">X</span> <span style="border-image: initial; border: 0px solid blue; font-size: 20px; text-align:left ">Precio Especial</span>
    <p style='text-align:right'>N°Factura: <?php echo $datosfac['numero_factura'] ?></p>
    <p style='text-align:right'>Fecha: <?php echo $feha_actual?> -- Hora:<?php echo $hora_actual?></p>
    <p style='text-align:right'>Admin: <?php echo $datosfac['vendedor'] ?></p>
    <p style='text-align:right'>Vendedor: <?php echo $vendedor; ?></p>
 
    
    Cliente: <?php echo $datosfac['nombre'] ?><br>
    Direccion: <?php echo $datosfac['direccion'] ?><br>
    Celular: <?php echo $datosfac['celular'] ?><br>
    Observacion: <?php echo $datosfac['observacion'] ?><br><br>

    <thead class="thead-dark">
    <tr width="100"  rowspan="4" bgcolor="#7B68EE">
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
                    $query = mysqli_query($conexion, "SELECT cliente.nombre, cliente.celular, usuario.nombre'vendedor', ventas.cantidad, producto.nombre_producto, ventas.subtotal, ventas.gramos, ventas.preciofinal, ventas.total_venta,
                    ventas.descuento, ventas.interes FROM ventas 
                    INNER JOIN producto on ventas.idproducto=producto.idproducto
                    INNER JOIN locales on ventas.idlocal=locales.idlocal 
                    INNER JOIN usuario on ventas.idusuario=usuario.idusuario
                    INNER JOIN cliente on ventas.idcliente=cliente.idcliente WHERE numero_factura=$numFactura and ventas.idcliente=$idcliente and ventas.idlocal=$idlocal");

               
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
$factura = mysqli_query($conexion, "SELECT total FROM factura WHERE numero_factura='$numFactura' and factura.idlocal = $idlocal and factura.idcliente=$idcliente");
while ($row = mysqli_fetch_assoc($factura)) {
 
   $total = $row['total'];
    
}

?>
                         <td style='font-size: 14px;'><?php echo"$".$total ?></td>
                         
                     </tr>

         </tbody>

</table>

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
