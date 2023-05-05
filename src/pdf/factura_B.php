<?php 
//include_once "includes/header.php";
require_once '../../conexion.php';
//require_once('qrcode/qrcode.class.php');
//include 'afip.php-master\src\Afip.php';
// Llamando a la libreria PHPQRCODE
include('phpqrcode/qrlib.php'); 
$config = mysqli_query($conexion, "SELECT * FROM configuracion");
$datos = mysqli_fetch_assoc($config);

date_default_timezone_set('America/Argentina/Buenos_Aires');
$feha_actual=date("d-m-Y");
date_default_timezone_set('America/Argentina/Buenos_Aires');
$hora_actual=date("H:i:s");
$numFactura = $_GET['factura'];
$cuit = 20403303462;
$factura = mysqli_query($conexion, "SELECT cliente.direccion, cliente.cuit, cliente.nombre, cliente.celular, usuario.usuario,
factura.numero_factura, total, ventas.descuento, ventas.interes, factura.importe, factura.cambio, factura.fecha,
producto.codigo_producto'codigo', producto.nombre_producto, ventas.cantidad, factura.tipoventa, factura.mediopago,
factura.observacion, usuario.usuario'vendedor', factura.idlocal, locales.puntoVenta
       FROM factura 
       INNER JOIN ventas on factura.numero_factura=ventas.numero_factura
       INNER JOIN producto on ventas.idproducto=producto.idproducto
       INNER JOIN cliente on factura.idcliente=cliente.idcliente
       INNER JOIN usuario on factura.idusuario=usuario.idusuario
       INNER JOIN locales on factura.idlocal=locales.idlocal WHERE factura.numero_factura='$numFactura'");
        $datosfac = mysqli_fetch_assoc($factura);  
        $cuitString = $datosfac['cuit']; 
        $cuitCliente = (Double)$cuitString;  
        $puntoVenta = $datosfac['puntoVenta'];
      
        if($puntoVenta == 5){
          $direccion = "VELEZ SARSFIELD 436 - SAN PEDRO DE JUJUY - JUJUY";
        }
        if($puntoVenta == 6){
          $direccion = "9 DE JULIO 432 - SAN PEDRO DE JUJUY - JUJUY";
        }
 
    ?>
 
<!DOCTYPE html>
<html>
<head>
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
	<link rel="stylesheet" href="css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <style>

        .cols {
  display: flex;
}

.cols div {
  flex: 1;
}

.col1 {
  background-color: white;
  /*border-color: black;
  border-style: solid;*/
  margin-left: 0;
  
}

.col2 {
  background-color: white;
  /*border-color: black;*/
  /*border-style: solid;*/
  margin-right: 0;
}

    </style>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>FACTURA A WEBSERVICE</title>
</head>
<body onload="myFunctionB()">

<div class="cols">

  <div class="col1">
    <!--Pagina 1 -->
    <img src="sabueso.jpg" class="img-thumbnail" width="140" height="80" align="left">
    <span style="border-image: initial; border: 0px solid blue;">
    <p style="font-size: 11px"> CUIT:</b> 20403303462</p>
    <p style="font-size: 11px"> Ingresos Brutos:</b> 20403303462</p>
    <p style="font-size: 11px"> Inicio de Actividad:</b> 01/03/2021</p>
    <p style="font-size: 11px"> Domicilio:</b> <?php echo $direccion; ?></p></span>

    <span style="font-size: 25px;">Factura</span> <span style="border: 1px solid black; font-size: 40px">B</span> 
    <span style="font-size: 25px;">  N°00005 1 </span><br>
    <span style="font-size: 10px; margin-left: 5rem;">Cod.006 </span><span style="font-size: 15px;"><input id="fecha" style="border: none; text-align:left;"></span>

    <p style='text-align:left; font-size: 12px;'>Cliente: <?php echo $datosfac['nombre'] ?></p>
    <p style='text-align:left; font-size: 12px;'>CUIT: <?php echo $datosfac['cuit']  ?></p>
    <p style='text-align:left; font-size: 12px;'>Domicilio: <?php echo $datosfac['direccion'] ?></p>
    <table  align="left" cellpadding=3 style="border-collapse: collapse;" border="1";>
    <thead class="thead-dark">
      <tr style='font-size: 13px;' width="12"  rowspan="4" bgcolor="#7B68EE">

                  <th>Cant.</th>
                  <th>Producto</th>
                  <th>Precio</th>
                  <th>Peso</th>
                  <th>Desc.%</th>
                  <th>Int.%</th>
                  <th>Precio Final</th>
                  <!--<th>SubTotal</th>-->
                  <th>SubTotal</th>
                  <th></th>
                  
      </tr>
    </thead>

    <tbody>
             <?php
             $contadorCantidad = 0;
             $contadorSubTotal = 0;
             $acInteres = 0;
                require_once '../../conexion.php';
                $sum = 0;
                    $query = mysqli_query($conexion, "SELECT cliente.nombre, cliente.celular, usuario.usuario, factura.numero_factura, total, ventas.descuento, ventas.interes, factura.importe, factura.cambio, factura.fecha, producto.nombre_producto, producto.codigo_producto'codigo',
                    ventas.cantidad, factura.tipoventa, producto.precio_producto'precio', ventas.interes, ventas.total_venta, factura.mediopago,ventas.gramos, ventas.subtotal, ventas.preciofinal FROM factura 
                            INNER JOIN ventas on factura.numero_factura=ventas.numero_factura
                            INNER JOIN producto on ventas.idproducto=producto.idproducto
                            INNER JOIN cliente on factura.idcliente=cliente.idcliente
                            INNER JOIN usuario on factura.idusuario=usuario.idusuario WHERE factura.numero_factura='$numFactura'");

               
                $i=1;
                $result = mysqli_num_rows($query);
                if ($result > 0) {
                    while ($data = mysqli_fetch_assoc($query)) {
                        
                ?>
                     <tr style="font-family: Arial;" colspan="23" align="center">
                       
                       <td style='font-size: 12px;'><?php echo $data['cantidad']; ?></td>
                       <?php 
                      
                       if($data['gramos']>0){
                          echo "<td style='font-size: 12px;'>" . $data['nombre_producto']." "."(suelto)" . "</td>";
                          $gr=$data['gramos']."gr";
                       }else{

                          echo "<td style='font-size: 12px;'>" .$data['nombre_producto']. "</td>";
                          $gr="gr";
                       }
                       ?>
                       <?php 
                       
                       $precioPro = $data['precio'];
                       $cantidad = $data['cantidad'];
                       $precioFinal = $data['subtotal'];
                       $Subtotal = $data['total_venta'];
                       $subInteres=0;
                       //acumal los importes en credito
                       $interes = $data['interes'];
                       if($interes>0){
                          $subInteres = $acInteres + $Subtotal;
                          $subInteres2 = $subInteres;
                          //echo $subInteres2;
                       }
                       
                       ?>
                       <td style='font-size: 12px;'><?php echo "$".$precioPro; ?></td>
                       <td style='font-size: 12px;'><?php echo $gr; ?></td>
                       <td style='font-size: 12px;'><?php echo $data['descuento']; ?></td>
                       <td style='font-size: 12px;'><?php echo $data['interes']; ?></td>
                       <td style='font-size: 12px;'><?php echo "$".$precioFinal; ?></td>
                       <td style='font-size: 12px;'><?php echo "$".$Subtotal; ?></td>
                       

                   </tr>
                     
             <?php
             
             //total de bultos
             $contadorCantidad = $cantidad + $contadorCantidad;
             $totalBultos = $contadorCantidad;            
             //total Factura
             $contadorSubTotal = $Subtotal + $contadorSubTotal;
            
             $i++; 
             $ImporteNeto = round($contadorSubTotal / 1.21,2);
             
             $iva =  round($ImporteNeto * 0.21, 2);
             $totalFactura = round($ImporteNeto + $iva, 2); }
                } ?>


   
  <tr width="100"  rowspan="4" style=" border: inset 0pt">
      <td></td>
      <td></td> 
      <td></td> 
      <td></td> 
      <td></td> 
      <td></td> 
      <td></td>          
  </tr>
  <tr width="100"  rowspan="4" style=" border: inset 0pt; font-family: Arial;">
                            
                            <th colspan="7" style='font-size: 13px; text-align:right;'>Total Bultos: </th>
                            <th colspan="2" style='font-size: 13px; text-align:right;'><?php echo $contadorCantidad; ?></th>
                            
               </tr>
            
              
              
               <tr width="100"  rowspan="4" style=" border: inset 0pt; font-family: Arial;">
                            
                            <th colspan="7" style='font-size: 13px; text-align:right;'>Importe Credito $</th>
                            <th colspan="2" style='font-size: 13px; text-align:right;'><?php echo $subInteres2; ?></th>
                            
               </tr>
            
               <tr width="100"  rowspan="2" style=" border: inset 0pt; font-family: Arial;">
                            
                            <th colspan="7" style='font-size: 13px; text-align:right;'>Importe Total $</th>
                            <th colspan="2" style='font-size: 13px; text-align:right;'><?php echo $totalFactura; ?></th>
               </tr>


  </tbody>

  <tr style=" border: inset 0pt; font-family: Arial;">

                <th colspan="9"></th>


   </tr>
   <tr style=" border: inset 0pt; font-family: Arial;">

                <th colspan="9"></th>


  </tr>
  <tr>

                <th colspan="9"></th>


  </tr>
   
   <tr width="100" style=" border: inset 0pt; font-family: Arial;">
                
                <th colspan="2" rowspan="3" style='font-size: 13px; text-align:right;'></th>
                <th colspan="7" style='font-size: 13px; text-align:right;'><input id="cae2" style="border: none; text-align:right; font-weight: bold;"></th>
                
   </tr>
   <tr width="100"  style=" border: inset 0pt; font-family: Arial;">
                
                <th colspan="2" style='font-size: 13px; text-align:right;'></th>
                <th colspan="7" style='font-size: 13px; text-align:right;'><input id="caefvt2" style="border: none; text-align:right; font-weight: bold;"></th>
                
   </tr>

  </tbody>

  <tfoot>
  <tr width="100"  rowspan="4" style=" border: inset 0pt; font-family: Arial;">
    <th colspan="5">
    <div class="col-md-6">
    <?php
    // Ingresamos el contenido de nuestro Código QR
    $contenido = "https://www.baulphp.com/";

    // Exportamos una imagen llamado resultado.png que contendra el valor de la avriable $content
    QRcode::png($contenido,"resultado.png",QR_ECLEVEL_L,3,2);

    // Impresión de la imagen en el navegador listo para usarla
    echo "<div><img src='resultado.png'/></div>";
    ?>
    </div>
    </th>
    <th colspan="4"><?php echo "<div><img src='afip.jpg' width='140' height='80'/></div>"; ?></th>
    </tr>  

  </tfoot>
    
  </table>
 
  </div>

  

  <div class="col2">
    
    <!--Pagina 2 -->
    <img src="sabueso.jpg" class="img-thumbnail" width="140" height="80" align="left">
    <span style="border-image: initial; border: 0px solid blue;">
    <p style="font-size: 11px"> CUIT:</b> 20403303462</p>
    <p style="font-size: 11px"> Ingresos Brutos:</b> 20403303462</p>
    <p style="font-size: 11px"> Inicio de Actividad:</b> 01/03/2021</p>
    <p style="font-size: 11px"> Domicilio:</b> <?php echo $direccion; ?></p></span>

    <span style="font-size: 25px;">Factura</span> <span style="border: 1px solid black; font-size: 40px">B</span> 
    <span style="font-size: 25px;">  N°00005 1 </span><br>
    <span style="font-size: 10px; margin-left: 5rem;">Cod.006 </span><span style="font-size: 15px;"><input id="fecha2" style="border: none; text-align:left;"></span>

    <p style='text-align:left; font-size: 12px;'>Cliente: <?php echo $datosfac['nombre'] ?></p>
    <p style='text-align:left; font-size: 12px;'>CUIT: <?php echo $datosfac['cuit']  ?></p>
    <p style='text-align:left; font-size: 12px;'>Domicilio: <?php echo $datosfac['direccion'] ?></p>

    <table  align="left" cellpadding=3 style="border-collapse: collapse;" border="1";>
    <thead class="thead-dark">
      <tr style='font-size: 13px;' width="12"  rowspan="4" bgcolor="#7B68EE">
                  <th>Cant.</th>
                  <th>Producto</th>
                  <th>Precio</th>
                  <th>Peso</th>
                  <th>Desc.%</th>
                  <th>Int.%</th>
                  <th>Precio Final</th>
                  <!--<th>SubTotal</th>-->
                  <th>SubTotal</th>
                  
                  
      </tr>
    </thead>

    <tbody>
             <?php
                require_once '../../conexion.php';
                $contadorCantidad = 0;
                $contadorSubTotal = 0;
                $acInteres = 0;
                $sum = 0;
                $query = mysqli_query($conexion, "SELECT cliente.nombre, cliente.celular, usuario.usuario, factura.numero_factura, total, ventas.descuento, ventas.interes, factura.importe, factura.cambio, factura.fecha, producto.nombre_producto, producto.codigo_producto'codigo',
                ventas.cantidad, factura.tipoventa, producto.precio_producto'precio', ventas.interes, ventas.total_venta, factura.mediopago,ventas.gramos, ventas.subtotal, ventas.preciofinal FROM factura 
                        INNER JOIN ventas on factura.numero_factura=ventas.numero_factura
                        INNER JOIN producto on ventas.idproducto=producto.idproducto
                        INNER JOIN cliente on factura.idcliente=cliente.idcliente
                        INNER JOIN usuario on factura.idusuario=usuario.idusuario WHERE factura.numero_factura='$numFactura'");

               
                $i=1;
                $result = mysqli_num_rows($query);
                if ($result > 0) {
                    while ($data = mysqli_fetch_assoc($query)) {
                        
                ?>
                     <tr style="font-family: Arial;" colspan="23" align="center">
                       
                         <td style='font-size: 12px;'><?php echo $data['cantidad']; ?></td>
                         <?php 
                        
                         if($data['gramos']>0){
                            echo "<td style='font-size: 12px;'>" . $data['nombre_producto']." "."(suelto)" . "</td>";
                            $gr=$data['gramos']."gr";
                         }else{

                            echo "<td style='font-size: 12px;'>" .$data['nombre_producto']. "</td>";
                            $gr="gr";
                         }
                         ?>
                         <?php 
                         
                         $precioPro = $data['precio'];
                         $cantidad = $data['cantidad'];
                         $precioFinal = $data['subtotal'];
                         $Subtotal = $data['total_venta'];
                         $subInteres=0;
                       //acumal los importes en credito
                       $interes = $data['interes'];
                       if($interes>0){
                          $subInteres = $acInteres + $Subtotal;
                          $subInteres2 = $subInteres;
                          //echo $subInteres2;
                       }
                         
                         ?>
                         <td style='font-size: 12px;'><?php echo "$".$precioPro; ?></td>
                         <td style='font-size: 12px;'><?php echo $gr; ?></td>
                         <td style='font-size: 12px;'><?php echo $data['descuento']; ?></td>
                         <td style='font-size: 12px;'><?php echo $data['interes']; ?></td>
                         <td style='font-size: 12px;'><?php echo "$".$precioFinal; ?></td>
                         <td style='font-size: 12px;'><?php echo "$".$Subtotal; ?></td>
                         

                     </tr>
                     
             <?php
            
            //total de bultos
            $contadorCantidad = $cantidad + $contadorCantidad;
            $totalBultos = $contadorCantidad;            
            //total Factura
            $contadorSubTotal = $Subtotal + $contadorSubTotal;
           
            $i++; 
            $ImporteNeto = round($contadorSubTotal / 1.21,2);
            
            $iva =  round($ImporteNeto * 0.21, 2);
            $totalFactura = round($ImporteNeto + $iva, 2); }
                } ?>
<tr width="100"  rowspan="4" style=" border: inset 0pt">
<td></td>
<td></td> 
<td></td> 
<td></td> 
<td></td> 
<td></td> 
<td></td>          
</tr>
  <tr width="100"  rowspan="4" style=" border: inset 0pt; font-family: Arial;">
                            
                <th colspan="7" style='font-size: 13px; text-align:right;'>Total Bultos: </th>
                <th colspan="2" style='font-size: 13px; text-align:right;'><?php echo $totalBultos; ?></th>
                
   </tr>

  
  
   <tr width="100"  rowspan="4" style=" border: inset 0pt; font-family: Arial;">
                
                <th colspan="7" style='font-size: 13px; text-align:right;'>Importe Credito $</th>
                <th colspan="2" style='font-size: 13px; text-align:right;'><?php echo $subInteres2; ?></th>
                
   </tr>

   <tr width="100"  rowspan="2" style=" border: inset 0pt; font-family: Arial;">
                
                <th colspan="7" style='font-size: 13px; text-align:right;'>Importe Total $</th>
                <th colspan="2" style='font-size: 13px; text-align:right;'><?php echo $totalFactura; ?></th>
   </tr>

   <tr style=" border: inset 0pt; font-family: Arial;">

                <th colspan="9"></th>


   </tr>
   <tr style=" border: inset 0pt; font-family: Arial;">

                <th colspan="9"></th>


  </tr>
  <tr>

                <th colspan="9"></th>


  </tr>
   
   <tr width="100" style=" border: inset 0pt; font-family: Arial;">
                
                <th colspan="2" rowspan="3" style='font-size: 13px; text-align:right;'></th>
                <th colspan="7" style='font-size: 13px; text-align:right;'><input id="cae" style="border: none; text-align:right; font-weight: bold; "></th>
                
   </tr>
   <tr width="100"  style=" border: inset 0pt; font-family: Arial;">
                
                <th colspan="2" style='font-size: 13px; text-align:right;'></th>
                
                <th colspan="7" style='font-size: 13px; text-align:right;'><input id="caefvt" style="border: none; text-align:right; font-weight: bold;"></th>
                
   </tr>

  </tbody>

  <tfoot>
  <tr width="100"  rowspan="4" style=" border: inset 0pt; font-family: Arial;">
    <th colspan="5">
    <div class="col-md-6">
    <?php
    // Ingresamos el contenido de nuestro Código QR
    $contenido = "https://www.baulphp.com/";

    // Exportamos una imagen llamado resultado.png que contendra el valor de la avriable $content
    QRcode::png($contenido,"resultado.png",QR_ECLEVEL_L,3,2);

    // Impresión de la imagen en el navegador listo para usarla
    echo "<div><img src='resultado.png'/></div>";
    ?>
    </div>
    </th>
    <th colspan="4"><?php echo "<div><img src='afip.jpg' width='140' height='80'/></div>"; ?></th>
    </tr>  

  </tfoot>

  </table>
 
  </div>

</div>
<div id="mostrar_mensaje"></div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script>
   
   function myFunctionB() {
    //obtener variables php
    var ImporteNeto = <?= json_encode($ImporteNeto) ?>;
    var iva = <?= json_encode($iva) ?>;
    var totalFactura = <?= json_encode($totalFactura) ?>;
    var cuitCliente = <?= json_encode($cuitCliente) ?>;
    var puntoVenta = <?= json_encode($puntoVenta) ?>;
    var parametros = 
    {
      "facturaB": "1",
       "ImporteNeto" : ImporteNeto,
       "iva" : iva,
       "totalFactura" : totalFactura,
       "cuitCliente" : cuitCliente,
       "puntoVenta" : puntoVenta
       
       
       
    };
    $.ajax(
    {
      data:  parametros,
      url:   'datosAfip.php',
      type:  'post',
     
      error: function()
      {alert("Error evento");},
      
      success:  function (mensaje) 
      {
        $('#mostrar_mensaje').html(mensaje);
        b();
    
      }
      
    })
    
   }

</script>
</html>