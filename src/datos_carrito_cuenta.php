<?php
	require("../conexion.php");
    //cobrar pago cuenta corriente
if(isset($_POST['insertar_pago_cuenta']))
{

  //subir stock al borrar producto de la venta
     $idcuenta_corriente=$_POST['idcuenta_corriente'];
     //$fecha=$_POST['fecha'];
     $numero_factura=$_POST['numero_factura'];
     $monto_factura=$_POST['gran_total'];
     $recibido_antes=$_POST['recibido_antes'];
     $recibido_ahora=$_POST['recibido_ahora'];
     $saldo_por_recibir=$_POST['saldo_por_recibir'];
     $total_pagado=$_POST['total_pagado'];
     $estado=$_POST['estado'];
  
     //lista mes
     date_default_timezone_set('America/Argentina/Buenos_Aires');
     $fecha=date("Y-m-d");
     $fechaComoEntero = strtotime($fecha);
     $anio = date("Y", $fechaComoEntero);
     $mes = date("m", $fechaComoEntero);

     if($mes==1){
       $mesText="Enero";
     }
     if($mes==2){
       $mesText="Febrero";
     }
     if($mes==3){
       $mesText="Marzo";
     }
     if($mes==4){
       $mesText="Abril";
     }
     if($mes==5){
       $mesText="Mayo";
     }
     if($mes==6){
       $mesText="Junio";
     }
     if($mes==7){
       $mesText="Julio";
     }
     if($mes==8){
       $mesText="Agosto";
     }
     if($mes==9){
       $mesText="Septiembre";
     }
     if($mes==10){
       $mesText="Octubre";
     }
     if($mes==11){
       $mesText="Noviembre";
     }
     if($mes==12){
       $mesText="Diciembre";
     } 
        
     $query_insert = mysqli_query($conexion, "INSERT INTO pagos_cuenta( idcuenta_corriente, fecha, numero_factura, monto_factura, recibido_antes, recibido_ahora, saldo, mes, año) values ('$idcuenta_corriente', '$fecha', '$numero_factura', '$monto_factura', '$recibido_antes', '$recibido_ahora', '$saldo_por_recibir', '$mesText', '$anio')");
     if ($query_insert) {
         echo '<script language="javascript">';
         echo 'alert("Se guardo el pago de la cuenta corriente");';
         echo '</script>';
     } else {
         echo '<script language="javascript">';
         echo 'alert("Error al pagar cuenta");';
         echo '</script>';
     }
     // editar cuenta corriente datos de pagos
     $saldo_por_recibir2=$_POST['saldo_por_recibir'];
     $total_pagado2=$_POST['total_pagado'];
     //obtener recibido antes de pago cuenta
     $rs = mysqli_query($conexion, "SELECT recibido_antes FROM pagos_cuenta WHERE idcuenta_corriente ='$idcuenta_corriente' ");
    while($row = mysqli_fetch_array($rs))
    {
        $recibido_antes2=$row['recibido_antes'];
    
    }
    $recibido = $recibido_antes + $total_pagado2;
     $rs = mysqli_query($conexion, "UPDATE cuenta_corrientes SET restante = '$saldo_por_recibir2', cantidad_recibida ='$recibido', estado = '$estado' WHERE idcuenta_corrientes='$idcuenta_corriente'");
          if ($query_insert) {
                    echo '<script language="javascript">';
                    //echo 'alert("Se edito cuenta corriente");';
                    echo '</script>';
        
            } else{
            echo '<script language="javascript">';
            echo 'alert("Error para agregar a caja");';
            echo '</script>';
        
           
            } 
  }

    // insertar en carrito cuenta corriente
    if(isset($_POST['carrito_cuenta']))
	{
        $idcliente = $_POST['idcliente'];
        $idproducto = $_POST['idproducto'];
        $idlocal = $_POST['idlocal'];
        $idusuario = $_POST['idusuario'];
        $numero_factura = $_POST['numero_factura'];
        $fecha = $_POST['fecha'];
        $fecha_vencimiento = $_POST['fecha_vencimiento'];
        $cantidad = $_POST['cantidad'];
        $interes = 0;
        $subtotal=0;
        $total=0;
        $tipo = $_POST['tipo'];
        $mi_precio = $_POST['mi_precio'];
        $precio_menor = $_POST['precio_menor'];
        $precio_mayor = $_POST['precio_mayor'];
        $descuento = $_POST['descuento'];
        $mediodePago = $_POST['mediodePago'];
        $stock_producto = $_POST['stock'];
        $total_compra = $mi_precio * $cantidad;
        
        if($tipo == "Precio x Menor"){

            $subtotal = $precio_menor;
            $total = $subtotal *  $cantidad; 
           
     
         }
         if($tipo == "Precio x Mayor"){
             $subtotal = $precio_mayor;
             $total =  $subtotal *  $cantidad;
             
     
         }
        //lista mes
        $fechaComoEntero = strtotime($fecha);
    $anio = date("Y", $fechaComoEntero);
    $mes = date("m", $fechaComoEntero);
    if($mes==1){
      $mesText="Enero";
    }
    if($mes==2){
      $mesText="Febrero";
    }
    if($mes==3){
      $mesText="Marzo";
    }
    if($mes==4){
      $mesText="Abril";
    }
    if($mes==5){
      $mesText="Mayo";
    }
    if($mes==6){
      $mesText="Junio";
    }
    if($mes==7){
      $mesText="Julio";
    }
    if($mes==8){
      $mesText="Agosto";
    }
    if($mes==9){
      $mesText="Septiembre";
    }
    if($mes==10){
      $mesText="Octubre";
    }
    if($mes==11){
      $mesText="Noviembre";
    }
    if($mes==12){
      $mesText="Diciembre";
    } 
    
    if($descuento > 0 ){
       
        $totalDI = $total * $descuento / 100;
        $totalPagar = $total - $totalDI;
        //$precio_final=0;
   
        //calcular precio final
        $desc = $subtotal * $descuento / 100;
        $precio_final = $subtotal - $desc;
        
       }else if($descuento==0 AND $interes==0){
   
         $totalPagar=$total;
         $precio_final=$subtotal;
         
       }
        
            $query_insert = mysqli_query($conexion, "INSERT INTO carrito_cuenta(idusuario, idcliente, idproducto, idlocal, numero_factura, fecha, fecha_vencimiento, mes, año, cantidad, descuento, precio_producto, subtotal, total, mediodepago, tipoventa, mi_precio, total_compra) values ('$idlocal', '$idcliente', '$idproducto', '$idlocal', '$numero_factura', '$fecha', '$fecha_vencimiento', '$mesText', '$anio', '$cantidad', '$descuento', '$subtotal', '$precio_final', '$totalPagar', '$mediodePago', '$tipo', '$mi_precio', '$total_compra')");
            if ($query_insert) {
                echo '<script language="javascript">';
                //echo 'alert("Se Cargaron los Productos al Carrito");';
                echo '</script>';
            } else {
                echo '<script language="javascript">';
                echo 'alert("Error al agregar");';
                echo '</script>';
            }

          
        
    
}

//insertar cuenta corriente
if(isset($_POST['insertar_cuenta']))
{

  //subir stock al borrar producto de la venta
     $fecha=$_POST['fecha'];
     $fecha_vencimiento=$_POST['fecha_vencimiento'];
     $numero_factura=$_POST['numero_factura'];
     $idcliente=$_POST['idcliente'];
     $total=$_POST['total'];
     $observacion = $_POST['observacion'];
     $idusuario = $_POST['idusuario'];
     $idlocal = $_POST['idlocal'];
     //lista mes
     $fechaComoEntero = strtotime($fecha);
     $anio = date("Y", $fechaComoEntero);
     $mes = date("m", $fechaComoEntero);
     if($mes==1){
       $mesText="Enero";
     }
     if($mes==2){
       $mesText="Febrero";
     }
     if($mes==3){
       $mesText="Marzo";
     }
     if($mes==4){
       $mesText="Abril";
     }
     if($mes==5){
       $mesText="Mayo";
     }
     if($mes==6){
       $mesText="Junio";
     }
     if($mes==7){
       $mesText="Julio";
     }
     if($mes==8){
       $mesText="Agosto";
     }
     if($mes==9){
       $mesText="Septiembre";
     }
     if($mes==10){
       $mesText="Octubre";
     }
     if($mes==11){
       $mesText="Noviembre";
     }
     if($mes==12){
       $mesText="Diciembre";
     } 
        
     $query_insert = mysqli_query($conexion, "INSERT INTO cuenta_corrientes( fecha, fecha_vencimiento, numero_factura, idcliente, estado, gran_total, restante, cantidad_recibida, mes, año, observaciones, idusuario, idlocal) values ('$fecha', '$fecha_vencimiento', '$numero_factura', '$idcliente', 'No Recibido', '$total', '$total', 0, '$mesText', '$anio', '$observacion', '$idusuario', '$idlocal')");
     if ($query_insert) {
         echo '<script language="javascript">';
         echo 'alert("Se guardo la cuenta corriente");';
         echo '</script>';
     } else {
         echo '<script language="javascript">';
         echo 'alert("Error al agregar");';
         echo '</script>';
     } 
  }

//borrar producto
if(isset($_POST['borrarpro']))
{

  //subir stock al borrar producto de la venta
     $idcarrito_cuenta=$_POST['idcarrito_cuenta'];
     $idcaja2 = 0;
     $stock2=1;
     $stock3=0;
     $rs = mysqli_query($conexion, "SELECT carrito_cuenta.idproducto, producto.stock_producto FROM carrito_cuenta
     INNER JOIN producto on carrito_cuenta.idproducto=producto.idproducto WHERE carrito_cuenta.idcarrito_cuenta='$idcarrito_cuenta' LIMIT 1");
     while($row = mysqli_fetch_array($rs))
     {
         $idproducto = $row['idproducto'];
         $stock3=$row['stock_producto'];
         $stock2 = $stock3 + 1;
  
     }
       
       $rs = mysqli_query($conexion, "UPDATE producto SET stock_producto = '$stock2' WHERE idproducto='$idproducto'");
       if ($rs) {
           echo '<script language="javascript">';
           //echo 'alert("Incremento el stock y los Gramos");';
           echo '</script>';
           $stock2=0;
       
           
       } else {
           echo '<script language="javascript">';
           //echo 'alert("Error modificar stock");';
           echo '</script>';
       }  

   //eliminar lista de venta 
   $query_delet = mysqli_query($conexion, "DELETE FROM carrito_cuenta WHERE idcarrito_cuenta = $idcarrito_cuenta");
   if ($query_delet) {
             echo '<script language="javascript">';
             //echo 'alert("Se Elimino el producto de la venta");';
             echo '</script>';
 
     } else{
     echo '<script language="javascript">';
     echo 'alert("Error al eliminar producto de la venta");';
     echo '</script>';
 
    
     }

}

?>    