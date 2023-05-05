<?php
require("../conexion.php");
//lista ventas x vendedores
if(isset($_POST['tabla_ventas']))
	{
    echo 
    '   
      <h5><center>Lista Detallada </center></h5>
      <table class="table table-bordered order-table ">
      <thead class="thead-dark">
        <tr bgcolor="#ADD8E6">
          <th scope="col" style="color:#FFFFFF" >#</th>
          <th scope="col">N°Factura</th>
          <th scope="col">Cliente</th>
          <th scope="col">Codigo</th>
          <th scope="col">Producto</th>
          <th scope="col">Precio</th>
          <th scope="col">Cantidad</th>
          <th scope="col">Des.%</th>
          <th scope="col">Int.%</th>
          <th scope="col">Precio Final</th>
          <th scope="col">Total</th>
          <th scope="col">M.D.P.</th>
        </tr>
        </thead>    
    ';

    $fecha = $_POST['fecha'];
    //$locales = $_POST['locales'];
    $mes = $_POST['mes'];
    $idvendedor = $_POST['vendedor'];
    if(empty($mes)){
      
      $resultados = mysqli_query($conexion,"SELECT cliente.nombre, ventas.idproducto, idventa,numero_factura, producto.codigo_producto'codigo', producto.nombre_producto'producto', subtotal, ventas.cantidad, ventas.descuento, ventas.interes, ventas.total_venta, ventas.mediodepago, ventas.preciofinal FROM ventas
    LEFT JOIN producto on ventas.idproducto=producto.idproducto
    LEFT JOIN cliente on ventas.idcliente=cliente.idcliente WHERE fecha_venta='$fecha' AND ventas.idvendedor='$idvendedor'");
   
    }else if(empty($fecha)){
      
      $resultados = mysqli_query($conexion,"SELECT cliente.nombre, ventas.idproducto, idventa,numero_factura, producto.codigo_producto'codigo', producto.nombre_producto'producto', subtotal, ventas.cantidad, ventas.descuento, ventas.interes, ventas.total_venta, ventas.mediodepago, ventas.preciofinal FROM ventas
    LEFT JOIN producto on ventas.idproducto=producto.idproducto
    LEFT JOIN cliente on ventas.idcliente=cliente.idcliente WHERE mes='$mes' AND ventas.idvendedor='$idvendedor' ");
    }
    
    
  $contador=0;
  $num=0;
  $i=1;
  while($consulta = mysqli_fetch_array($resultados))
    {
          echo "<tr>";
          $consulta['idproducto'];
          //$consulta['idventa'];
          echo "<td style='color:#FFFFFF'>".$consulta['idventa']."</td>";
          
          echo "<td>" . $consulta['numero_factura'] . "</td>";
          echo "<td>" . $consulta['nombre'] . "</td>";
          $num = $consulta['numero_factura'];
          echo "<td>" . $consulta['codigo'] . "</td>";
          echo "<td>" . $consulta['producto'] . "</td>";
          echo "<td>" . $consulta['subtotal'] . "</td>";
          echo "<td>" . $consulta['cantidad'] . "</td>";
          echo "<td>" . $consulta['descuento'] . "</td>";
          echo "<td>" . $consulta['interes'] . "</td>";
          echo "<td>" . $consulta['preciofinal'] . "</td>";
          echo "<td>" . $consulta['total_venta'] . "</td>";
          echo "<td>" . $consulta['mediodepago'] . "</td>";

          //echo "<td><a href='inscripcion.php?id=".$consulta['idalumno']."'><i class='fas fa-trash-alt'></i></a></td>";
          //echo "<td><a href='javascript: prueba();'> <img src='.' alt='Seleccionar'></a></td>";
          //echo "<td><input type='button' value='Seleccionar' class='btn btn-primary' name='btn_inscribir' onclick='prueba();'></td>";
          echo "</tr>";
          $i++;
  }	
  
  
  $Sumcan=0;
  $CanVen=0;
  $totalProductos=0;
  $resultados = mysqli_query($conexion,"SELECT COUNT(idventa)'cantventa', SUM(cantidad)'sumcantidad' FROM ventas WHERE mes='$mes' or fecha_venta='$fecha' and  idvendedor='$idvendedor' ");
  while($consulta = mysqli_fetch_array($resultados))
    {
      $CanVen = $consulta['cantventa'];
      $CanVen = $consulta['sumcantidad'];
      $totalProductos = $Sumcan + $CanVen;

    }
    echo "<h3>Productos Vendidos: $totalProductos </h3>";   
    echo "<tfoot>";
    $resultados = mysqli_query($conexion,"SELECT SUM(total_venta)'total' FROM ventas where mes='$mes' or fecha_venta='$fecha' and idvendedor='$idvendedor' ");
      while($consulta = mysqli_fetch_array($resultados))
     {
       $total = $consulta['total']; 
       echo "<h3>Recaudacion: $total </h3>";        
    echo"<tfoot>
                  <tr class='font-weight-bold'>
                      <td colspan=3>Recaudacion$
                      <input type='number' name='total' id='totalC' class='form-control' value='$total' style='font-size: 20px; width:60%; text-transform: uppercase; color: black;'> </td>
                      <td></td>
                  </tr> ";

    echo "</tfoot>";
           
     }

  }
//lista ventas
if(isset($_POST['tabla']))
	{
    
    echo 
    '   
      <h5><center>Lista Detallada </center></h5>
      <table class="table table-bordered order-table ">
      <thead class="thead-dark">
        <tr bgcolor="#ADD8E6">
          <th scope="col" style="color:#FFFFFF" >#</th>
          <th scope="col">N°Factura</th>
          <th scope="col">Cliente</th>
          <th scope="col">Codigo</th>
          <th scope="col">Producto</th>
          <th scope="col">Precio</th>
          <th scope="col">Cantidad</th>
          <th scope="col">Des.%</th>
          <th scope="col">Int.%</th>
          <th scope="col">Precio Final</th>
          <th scope="col">Total</th>
          <th scope="col">M.D.P.</th>
        </tr>
        </thead>    
    ';

      $fecha = $_POST['fecha'];
      $locales = $_POST['locales'];
      $mes = $_POST['mes'];
      if(empty($mes)){
        
        $resultados = mysqli_query($conexion,"SELECT cliente.nombre, ventas.idproducto, idventa,numero_factura, producto.codigo_producto'codigo', producto.nombre_producto'producto', subtotal, ventas.cantidad, ventas.descuento, ventas.interes, ventas.total_venta, ventas.mediodepago, ventas.preciofinal FROM ventas
      LEFT JOIN producto on ventas.idproducto=producto.idproducto
      LEFT JOIN cliente on ventas.idcliente=cliente.idcliente WHERE fecha_venta='$fecha' AND ventas.idlocal='$locales'");
     
      }else if(empty($fecha)){
        
        $resultados = mysqli_query($conexion,"SELECT cliente.nombre, ventas.idproducto, idventa,numero_factura, producto.codigo_producto'codigo', producto.nombre_producto'producto', subtotal, ventas.cantidad, ventas.descuento, ventas.interes, ventas.total_venta, ventas.mediodepago, ventas.preciofinal FROM ventas
      LEFT JOIN producto on ventas.idproducto=producto.idproducto
      LEFT JOIN cliente on ventas.idcliente=cliente.idcliente WHERE mes='$mes' AND ventas.idlocal='$locales'");
      }
      
      
    $contador=0;
    $num=0;
    $i=1;
    while($consulta = mysqli_fetch_array($resultados))
	    {
            echo "<tr>";
            $consulta['idproducto'];
            //$consulta['idventa'];
            echo "<td style='color:#FFFFFF'>".$consulta['idventa']."</td>";
            
            echo "<td>" . $consulta['numero_factura'] . "</td>";
            echo "<td>" . $consulta['nombre'] . "</td>";
            $num = $consulta['numero_factura'];
            echo "<td>" . $consulta['codigo'] . "</td>";
            echo "<td>" . $consulta['producto'] . "</td>";
            echo "<td>" . $consulta['subtotal'] . "</td>";
            echo "<td>" . $consulta['cantidad'] . "</td>";
            echo "<td>" . $consulta['descuento'] . "</td>";
            echo "<td>" . $consulta['interes'] . "</td>";
            echo "<td>" . $consulta['preciofinal'] . "</td>";
            echo "<td>" . $consulta['total_venta'] . "</td>";
            echo "<td>" . $consulta['mediodepago'] . "</td>";

            //echo "<td><a href='inscripcion.php?id=".$consulta['idalumno']."'><i class='fas fa-trash-alt'></i></a></td>";
            //echo "<td><a href='javascript: prueba();'> <img src='.' alt='Seleccionar'></a></td>";
            //echo "<td><input type='button' value='Seleccionar' class='btn btn-primary' name='btn_inscribir' onclick='prueba();'></td>";
            echo "</tr>";
            $i++;
	  }	
    
    
    $Sumcan=0;
    $CanVen=0;
    $totalProductos=0;
    $resultados = mysqli_query($conexion,"SELECT COUNT(idventa)'cantventa', SUM(cantidad)'sumcantidad' FROM ventas WHERE fecha_venta = '$fecha' OR mes='$mes' ");
    while($consulta = mysqli_fetch_array($resultados))
	    {
        $CanVen = $consulta['cantventa'];
        $CanVen = $consulta['sumcantidad'];
        $totalProductos = $Sumcan + $CanVen;

      }
      echo "<h3>Productos Vendidos: $totalProductos </h3>";   
      echo "<tfoot>";
      $resultados = mysqli_query($conexion,"SELECT SUM(total_venta)'total' FROM ventas where fecha_venta='$fecha' OR mes='$mes'");
        while($consulta = mysqli_fetch_array($resultados))
       {
         $total = $consulta['total'];        
      echo"<tfoot>
                    <tr class='font-weight-bold'>
                        <td colspan=3>Recaudacion$
                        <input type='number' name='total' id='totalC' class='form-control' value='$total' style='font-size: 20px; width:60%; text-transform: uppercase; color: black;'> </td>
                        <td></td>
                    </tr> ";

      echo "</tfoot>";
             
       }
       
  }
  ?>