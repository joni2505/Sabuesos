<?php
	require("../conexion.php");
//cobrar carrito venta
if(isset($_POST['cobrar_carrito_venta']))
	{
    
        $idusuario = $_POST['idusuario'];
        $idlocal = $_POST['idlocal'];
        $idcliente = $_POST['idcliente'];
        $tipoFactura = $_POST['tipoFactura'];
        $total_input = $_POST['total_input'];
        $cambio = $_POST['cambio'];
        $factura = $_POST['numero_factura'];
        $importe = $_POST['importe'];
        $observacion = $_POST['observacion'];
        $idcaja = $_POST['idcaja'];
        $vendedor = $_POST['vendedor'];
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $fecha=date("Y-m-d");
        $fechaComoEntero = strtotime($fecha);
        $año = date("Y", $fechaComoEntero);
        $mes = date("M", $fechaComoEntero);

        //traer id cliente
        /*$rs = mysqli_query($conexion, "SELECT idcliente FROM cliente WHERE nombre ='$nombre'");
        while($row = mysqli_fetch_array($rs))
        {
            $idcliente=$row['idcliente'];
        
        }*/

        
        //validar que no esten los campos vacios de ventas
        $alert = "";
        if (empty($idusuario) || empty($idlocal) || empty($factura) || empty($idcliente) || empty($total_input)) {
          echo '<script language="javascript">';
          echo $idcliente.$idlocal.$idusuario.$factura.$total_input;
          echo 'alert("Campos vacios");';
          echo '</script>';
        }else {

          $query_insert = mysqli_query($conexion, "INSERT INTO factura(idcliente, idusuario, idlocal, numero_factura, total, importe, cambio, fecha, mes, año, observacion, idvendedor, idcaja, tipoFactura) values ('$idcliente', '$idusuario', '$idlocal', '$factura', '$total_input', '$importe', '$cambio', '$fecha', '$mes', '$año', '$observacion', '$vendedor', '$idcaja', '$tipoFactura')");
          if ($query_insert) {
                    echo '<script language="javascript">';
                    echo 'alert("Carrito Cobrado correctamente!!");';
                    echo '</script>';
        
            } else{
            echo '<script language="javascript">';
            echo 'alert("Error al Cobrar");';
            echo '</script>';
        
           
            }
            
            
        }
    }   
//insertar producto
  if(isset($_POST['guardar_producto']))
	{
        $codigo = $_POST['codigo'];
      $nombre_producto = $_POST['nombre_producto'];
      $precio = $_POST['precio'];
      $stock = $_POST['stock'];
      $unidad = $_POST['unidad'];
      $precio_mayor = $_POST['precio_mayor'];
      $locales = $_POST['locales'];
      $mi_precio = $_POST['mi_precio'];
      $porcentaje_menor = $_POST['porcentaje_menor'];
      $porcentaje_mayor = $_POST['porcentaje_mayor'];
      $idproveedor = $_POST['proveedor'];
      $idrubro = $_POST['idrubro2'];
      $idmarca = $_POST['idmarca'];
      //imagen
      
      //$revisar = getimagesize($_FILES['imagen']['tmp_name']);
      $image = $_FILES['imagen']['tmp_name'];
      
      if(file_exists($image)){
      
      $imgContenido = addslashes(file_get_contents($image));
      $alert = "";
      if (empty($codigo) || empty($nombre_producto) || empty($precio) || $precio <  0 || empty($stock) || $unidad < 0 || empty($idrubro) || empty($idmarca)) {
          $alert = '<div class="alert alert-danger" role="alert">
              Todo los campos son obligatorios
            </div>';
      } else {
          $query = mysqli_query($conexion, "SELECT * FROM producto WHERE codigo_producto = '$codigo'");
          $result = mysqli_fetch_array($query);
          if ($result > 0) {
              $alert = '<div class="alert alert-warning" role="alert">
                      El código ya existe
                  </div>';
          } else {
      $query_insert = mysqli_query($conexion,"INSERT INTO producto(codigo_producto, nombre_producto, mi_precio, porcentaje_menor, porcentaje_mayor, precio_producto, stock_producto, unidad_producto, precio_mayor, idlocal, idproveedor, idrubro, idmarca, imagen) values ('$codigo', '$nombre_producto', '$mi_precio', '$porcentaje_menor', '$porcentaje_mayor', '$precio', '$stock', '$unidad', '$precio_mayor', '$locales', '$idproveedor', '$idrubro', '$idmarca', '$imgContenido')");
              if ($query_insert) {
                  $alert = '<div class="alert alert-success" role="alert">
              Producto Registrado
            </div>';
              } else {
                  $alert = '<div class="alert alert-danger" role="alert">
              Error al registrar el producto
            </div>';
              }
          }
      }



      }
      else{
        $alert = "";
      if (empty($codigo) || empty($nombre_producto) || empty($precio) || $precio <  0 || empty($stock) || $unidad < 0 || empty($idrubro) || empty($idmarca)) {
          $alert = '<div class="alert alert-danger" role="alert">
              Todo los campos son obligatorios
            </div>';
      } else {
          $query = mysqli_query($conexion, "SELECT * FROM producto WHERE codigo_producto = '$codigo'");
          $result = mysqli_fetch_array($query);
          if ($result > 0) {
              $alert = '<div class="alert alert-warning" role="alert">
                      El código ya existe
                  </div>';
          } else {
      $query_insert = mysqli_query($conexion,"INSERT INTO producto(codigo_producto, nombre_producto, mi_precio, porcentaje_menor, porcentaje_mayor, precio_producto, stock_producto, unidad_producto, precio_mayor, idlocal, idproveedor, idrubro, idmarca) values ('$codigo', '$nombre_producto', '$mi_precio', '$porcentaje_menor', '$porcentaje_mayor', '$precio', '$stock', '$unidad', '$precio_mayor', '$locales', '$idproveedor', '$idrubro', '$idmarca')");
              if ($query_insert) {
                  $alert = '<div class="alert alert-success" role="alert">
              Producto Registrado
            </div>';
              } else {
                  $alert = '<div class="alert alert-danger" role="alert">
              Error al registrar el producto
            </div>';
              }
          }
      }
    
    }
  
}
  //crear lista de producto pdf
  if(isset($_POST['agregar_lista']))
	{
        $rubro = $_POST['rubro'];
        $marca = $_POST['marca'];
        $query = mysqli_query($conexion, "SELECT * FROM lista WHERE rubro = '$rubro' and marca='$marca'");
        $result = mysqli_fetch_array($query);
        if ($result > 0) {
            echo '<script language="javascript">';
          echo 'alert("Ya existe ese dato en la tabla");';
          echo '</script>';
        }else{

            $query_insert = mysqli_query($conexion, "INSERT INTO lista(rubro, marca) values ('$rubro', '$marca')");
            if ($query_insert) {
                echo '<script language="javascript">';
                //echo 'alert("Se agrego ala lista");';
                echo '</script>';
            } else {
                echo '<script language="javascript">';
                echo 'alert("Error al agregar");';
                echo '</script>';
            }

          }
        
    
}
//eliminar lista
if(isset($_POST['eliminar_lista']))
{

    
       $query_delete = mysqli_query($conexion, "DELETE FROM lista");
        if ($query_delete) {
            echo '<script language="javascript">';
            //echo 'alert("Se Elimino la lista");';
            echo '</script>';
        } else {
            echo '<script language="javascript">';
            echo 'alert("Error al eliminar");';
            echo '</script>';
        }
        

      
    

}

$gamos_perdidos = 0;
  //agregar nuevo producto suelto
  if(isset($_POST['nuevo_producto']))
	{
    $idlocal = $_POST['idlocal'];
    $producto = $_POST['producto'];
    $kg = $_POST['kg'];
    $gramos = $_POST['gramos'];
    $gramos_fijos = $_POST['gramosFijos'];
    $precio = $_POST['precio'];
    $stock_suelto = $_POST['stock'];
    $stock_menor=0;
    $stock_mayor=0;
    //traer stock producto
    $rs = mysqli_query($conexion, "SELECT stock_producto FROM producto WHERE nombre_producto ='$producto' and idlocal='$idlocal'");
    while($row = mysqli_fetch_array($rs))
    {
        $stock_mayor=$row['stock_producto'];
    
    }
    $stock_menor = $stock_mayor - $stock_suelto;

    if (empty($_POST['producto']) || empty($_POST['gramos']) || empty($_POST['precio']) ) {
      echo '<script language="javascript">';
    echo 'alert("Todos los Campos son requeridos");';
    echo '</script>';
  }else{

    $rs = mysqli_query($conexion, "UPDATE producto SET kg='$kg', gramos='$gramos', precio_suelto='$precio', suelto=1, stock_producto='$stock_menor', stock_suelto='$stock_suelto', gramos_fijos='$gramos_fijos' WHERE nombre_producto='$producto' and idlocal='$idlocal' ");
      if ($rs) {
          echo '<script language="javascript">';
          echo 'alert("Producto Suelto Agregado Correctamente");';
          echo '</script>';
      } else {
          echo '<script language="javascript">';
          echo 'alert("Error al Agregar Producto Suelto");';
          echo '</script>';
      }
  
}
    

  }

  //eliminar suelto de producto
  if(isset($_POST['editarSuelto']))
	{
    $producto = $_POST['producto'];
    $idlocal = $_POST['idlocal'];
    $kg = 0;
    $gramos = 0;
    $gramos_fijos = 0;
    $precio = 0;
    $stock_suelto = 0;
    $stock_menor=0;
    $stock_mayor=0;

    $rs = mysqli_query($conexion, "UPDATE producto SET kg='$kg', gramos='$gramos', precio_suelto='$precio', suelto='1', stock_producto='$stock_menor', stock_suelto='$stock_suelto', gramos_fijos='$gramos_fijos', suelto=0 WHERE nombre_producto='$producto' and idlocal='$idlocal' ");
      if ($rs) {
          echo '<script language="javascript">';
          echo 'alert("Listo para Editar");';
          echo '</script>';
      } else {
          echo '<script language="javascript">';
          echo 'alert("Error al Editar");';
          echo '</script>';
      }
  

    

  }
  
  //buscar datos producto input codigo
  if(isset($_POST['buscar_producto']))
  {
    
    $valores = array();
    $codigo = $_POST['codigo'];
    $idlocal = $_POST['idlocal'];
    //CONSULTAR
    $resultados = mysqli_query($conexion,"SELECT * FROM producto WHERE codigo_producto = '$codigo' and idlocal= $idlocal ");
    while($consulta = mysqli_fetch_array($resultados))
    {
      
      $valores['idproducto'] = $consulta['idproducto'];
      $valores['nombre_producto'] = $consulta['nombre_producto'];
      $valores['precio'] = $consulta['precio_producto'];
      $valores['precio_mayor'] = $consulta['precio_mayor'];
      $valores['stock'] = $consulta['stock_producto'];
      $valores['mi_precio'] = $consulta['mi_precio'];
           
    }
    
    
    sleep(1);
    $valores = json_encode($valores);
    echo $valores;
  }
  

  //buscar producto suelto
  if(isset($_POST['buscar_producto_suelto']))
  {
    
    $valores = array();
    $codigo = $_POST['codigo'];
    $idlocal = $_POST['idlocal'];
    //CONSULTAR
    $resultados = mysqli_query($conexion,"SELECT * FROM producto WHERE codigo_producto = '$codigo' and idlocal='$idlocal' ");
    while($consulta = mysqli_fetch_array($resultados))
    {
      
      $valores['idproducto'] = $consulta['idproducto'];
      $valores['gramos'] = $consulta['gramos'];
      $valores['precio_suelto'] = $consulta['precio_suelto'];
      $valores['stock_suelto'] = $consulta['stock_suelto'];
      $valores['kg'] = $consulta['kg'];
      $valores['gramos_fijos'] = $consulta['gramos_fijos'];
     
           
    }
    
    
    sleep(1);
    $valores = json_encode($valores);
    echo $valores;
  }

  //agregar a carrito venta producto suelto
  if(isset($_POST['carrito_cuenta_suelto']))
  {
    $idcliente=$_POST['idcliente'];
    $idproducto=$_POST['idproducto'];
    $idlocal = $_POST['idlocal'];
    $idusuario = $_POST['idusuario'];
    $numero_factura = $_POST['numero_factura'];
    $total_gramos = $_POST['total_gramos'];
    $gramos_res = $_POST['gramos_muestra']; 
    $importe_cliente = $_POST['importe_suelto'];
    $cantidad = $_POST['cantidad'];
    $descuento = $_POST['descuento_suelto'];
    $interes = 0;
    $stock_suelto = $_POST['stock_suelto'];
    $tipo = "Precio x suelto";
    $mediodePago = $_POST['mediodePago'];
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $fecha=date("Y-m-d");
     //obtener mes y año automatico
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $feha_actual=date("Y-m-d H:i:s");
    $fechaComoEntero = strtotime($feha_actual);
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
  
      $subtotal = $importe_cliente;
      $total =  $subtotal *  $cantidad;

  
    if($cantidad <= $stock_suelto && $tipo=="Precio x suelto"){
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
   
        if($interes > 0){
         $totalPagar=0;
         //$precio_final=0;
         $totalDI = $total * $interes / 100;
         $totalPagar = $total + $totalDI;
   
         //calcular precio final
        $inte = $subtotal * $interes / 100;
        $precio_final = $subtotal + $inte;
       
       }else if($interes==0 AND $descuento==0){
   
         $precio_final=$subtotal;
       }

       $query_insert = mysqli_query($conexion, "INSERT INTO ventas(idusuario, idcliente, idproducto, idlocal, numero_factura, cantidad, fecha_venta, subtotal, preciofinal, tipoventa, descuento, interes, total_venta, mediodepago, gramos, mes, año )
      values ('$idusuario', '$idcliente', '$idproducto', '$idlocal', '$numero_factura', '$cantidad', '$fecha', '$subtotal', '$precio_final','$tipo', '$descuento', '$interes', '$totalPagar', '$mediodePago', '$total_gramos', '$mesText', '$anio')");
      if ($query_insert) {
                echo '<script language="javascript">';
                echo 'alert("Se Agrego el producto suelto correctamente");';
                echo '</script>';
                //echo $gramos_perdidos;

        } else{
        echo '<script language="javascript">';
        echo 'alert("Error al carga productos ala venta");';
        echo '</script>';

      
        }
    }


  }

  //agregar productos al carrito
  if(isset($_POST['carrito_cuenta_venta']))
  {
    $subtotal = 0;
    $total = 0;
    $total_compra = 0;
    $idcliente=$_POST['idcliente'];   
    $idproducto=$_POST['idproducto'];
    $idlocal = $_POST['idlocal'];
    $idcaja = $_POST['idcaja'];
    $idusuario = $_POST['idusuario'];
    $numero_factura = $_POST['numero_factura'];
    $idvendedor = $_POST['idvendedor'];
    //$fecha = $_POST['fecha'];
    $tipo = $_POST['tipo'];
    $mi_precio = $_POST['mi_precio'];
    $precio_menor = $_POST['precio_menor'];
    $precio_mayor = $_POST['precio_mayor'];
    $cantidad = $_POST['cantidad'];
    $stock_producto = $_POST['stock'];
    $interes = $_POST['interes'];
    $descuento = $_POST['descuento'];
    $mediodePago2 = $_POST['mediodePago'];
    //$importe_cliente = $_POST['importe_suelto'];
    $total_gramos = $_POST['total_gramos'];
    $gramos_res = $_POST['gramos_muestra'];
    //$gramos_fijos = $_POST['gramos_fijos'];
    $total_compra = $mi_precio * $cantidad;
    $totalDI=0;
    $totalPagar=0;
    $efectivo=0;
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $fecha=date("Y-m-d");
    //obtener mes y año automatico
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $feha_actual=date("Y-m-d H:i:s");
    $fechaComoEntero = strtotime($feha_actual);
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
    
    if($cantidad <= $stock_producto){
    
  
    if($tipo == "Precio x Menor"){

       $subtotal = $precio_menor;
       $total = $subtotal *  $cantidad; 

    }
    if($tipo == "Precio x Mayor"){
        $subtotal = $precio_mayor;
        $total =  $subtotal *  $cantidad;

    }
    if($tipo == "Precio x Suelto"){
      $subtotal = $importe_cliente;
      $total =  $subtotal *  $cantidad;

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

     if($interes > 0){
      $totalPagar=0;
      //$precio_final=0;
      $totalDI = $total * $interes / 100;
      $totalPagar = $total + $totalDI;

      //calcular precio final
     $inte = $subtotal * $interes / 100;
     $precio_final = $subtotal + $inte;
    
    }else if($interes==0 AND $descuento==0){

      $precio_final=$subtotal;
    }

    $total_gramos=0;
    //insertar Venta
  $query_insert = mysqli_query($conexion, "INSERT INTO ventas(idusuario, idcliente, idproducto, idlocal, numero_factura, cantidad, fecha_venta, subtotal, preciofinal, tipoventa, descuento, interes, total_venta, mediodepago, gramos, mes, año, mi_precio, total_compra, idvendedor, idcaja )
  values ('$idusuario', '$idcliente', '$idproducto', '$idlocal', '$numero_factura', '$cantidad', '$fecha', '$subtotal', '$precio_final','$tipo', '$descuento', '$interes', '$totalPagar', '$mediodePago2', '$total_gramos', '$mesText', '$anio', '$mi_precio', '$total_compra', '$idvendedor', '$idcaja')");
  if ($query_insert) {
            echo '<script language="javascript">';
            //echo 'alert("Se Agrego el producto ala venta correctamente");';
            echo '</script>';
            //echo $gramos_perdidos;

    } else{
    echo '<script language="javascript">';
    echo 'alert("Error al carga productos ala venta");';
    echo '</script>';

   
    }

    //condiciones para bolsa entera
    if($tipo=="Precio x Mayor" || $tipo=="Precio x Menor"){

      //modificar stock
   $stock=0;
   $stock = ($stock_producto - $cantidad); 
   $rs = mysqli_query($conexion, "UPDATE producto SET stock_producto = '$stock' WHERE idproducto='$idproducto'");
   if ($rs) {
       echo '<script language="javascript">';
       //echo 'alert("Se modifico el stock");';
       echo '</script>';
   } else {
       echo '<script language="javascript">';
       echo 'alert("Error modificar stock");';
       echo '</script>';
   
     }


    }else{
      
      //restar gramos de la bolsa
      $rs = mysqli_query($conexion, "UPDATE producto SET gramos = '$gramos_res' WHERE idproducto='$idproducto'");
    if ($rs) {
        echo '<script language="javascript">';
        //echo 'alert("Se modifico su gramos");';
        echo '</script>';
    } else {
        echo '<script language="javascript">';
        echo 'alert("Error modificar stock");';
        echo '</script>';
    
      }

      $rs = mysqli_query($conexion, "SELECT gramos, stock_suelto, gramos_fijos FROM producto WHERE idproducto ='$idproducto'");
        while($row = mysqli_fetch_array($rs))
        {
            $gramos_final=$row['gramos'];
            $substock = $row['stock_suelto'];
            $stock_suel = $substock - 1;
            $gramos_fijos = $row['gramos_fijos'];
        }
        //preguntar por los ultimos gramos de la bolsa y restar stock_suelto del producto 
        if($gramos_final == 0 ){

          $rs = mysqli_query($conexion, "UPDATE producto SET stock_suelto = '$stock_suel', gramos='$gramos_fijos' WHERE idproducto='$idproducto'");
   if ($rs) {
       echo '<script language="javascript">';
       //echo 'alert("Se modifico el stock Suelto");';
       echo '</script>';
   } else {
       echo '<script language="javascript">';
       echo 'alert("Error modificar stock");';
       echo '</script>';
   
     }

        }


    }
    

  



  }
  else{

    echo '<script language="javascript">';
    //echo 'alert("No hay Stock Suficiente");';
    echo '</script>';
    
  }



}

if(isset($_POST['borrarpro']))
{

  //subir stock al borrar producto de la venta
     $idventa=$_POST['idventa'];
     $stock2=1;
     $stock3=0;
     $rs = mysqli_query($conexion, "SELECT ventas.idproducto, producto.stock_producto, producto.gramos, ventas.gramos'gramos_venta' FROM ventas
     INNER JOIN producto on ventas.idproducto=producto.idproducto WHERE ventas.idventa='$idventa' LIMIT 1");
     while($row = mysqli_fetch_array($rs))
     {
         $idproducto = $row['idproducto'];
         $stock3=$row['stock_producto'];
         $stock2 = $stock3 + 1;
         $gramos_pro = $row['gramos'];
         $gramos_venta = $row['gramos_venta'];
         $gramos_regreso = ($gramos_venta + $gramos_pro);
         
     }
       
       $rs = mysqli_query($conexion, "UPDATE producto SET stock_producto = '$stock2', gramos='$gramos_regreso' WHERE idproducto='$idproducto'");
       if ($rs) {
           echo '<script language="javascript">';
           //echo 'alert("Incremento el stock y los Gramos");';
           echo '</script>';
           $stock2=0;
       
           
       } else {
           echo '<script language="javascript">';
           echo 'alert("Error modificar stock");';
           echo '</script>';
       }  

  

   //eliminar lista de venta 
   $query_delet = mysqli_query($conexion, "DELETE FROM ventas WHERE idventa = $idventa");
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

//editar factura
if(isset($_POST['editar_factura']))
{

  //subir stock al borrar producto de la venta
     $idfactura=$_POST['idfactura'];
     
        
       $rs = mysqli_query($conexion, "DELETE FROM factura WHERE idfactura='$idfactura'");
       if ($rs) {
           echo '<script language="javascript">';
           echo 'alert("Factura lista para editar ");';
           echo '</script>';
           $stock2=0;
       } else {
           echo '<script language="javascript">';
           echo 'alert("Error para editar factura");';
           echo '</script>';
       } 
  }

  //eliminar factura
  if(isset($_POST['borrar_factura']))
  {
  
    //subir stock al borrar producto de la venta
       $idfactura=$_POST['idfactura'];
       
          
         $rs = mysqli_query($conexion, "DELETE FROM factura WHERE idfactura='$idfactura'");
         if ($rs) {
             echo '<script language="javascript">';
             echo 'alert("Se elimino la Factura ");';
             echo '</script>';
             $stock2=0;
         } else {
             echo '<script language="javascript">';
             echo 'alert("Error para eliminar factura");';
             echo '</script>';
         }
         
         /*$rs = mysqli_query($conexion,"SELECT idlocal FROM factura WHERE factura.idfactura=$idfactura");
            while($row = mysqli_fetch_array($rs))
            {
              $idlocal = $row['idlocal'];
            }*/
         //$rs = mysqli_query($conexion, "DELETE FROM ventas WHERE idcliente=$idcliente and factura=$factura and idlocal=$idlocal");

    }
?>