
    <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="#" />  
    <title>Tutorial DataTables</title>
      
    <!-- Bootstrap CSS -->
    
    <!-- CSS personalizado --> 
    <link rel="stylesheet" href="exportar/main.css">  
      
    <!--datables CSS básico-->
    <link rel="stylesheet" type="text/css" href="exportar/datatables/datatables.min.css"/>
    <!--datables estilo bootstrap 4 CSS-->  
    <link rel="stylesheet"  type="text/css" href="exportar/datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">
           
    <!--font awesome con CDN-->  
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">  
      
  </head>    
<?php
//informe mensual venta
	require("../conexion.php");
if(isset($_POST['informe_dato']))
	{
        echo 
        '  
          <h5><center>Lista Detallada de Informe</center></h5>    
          <center><table class="table table-bordered order-table " style="width: 55%" id="example"></center>
          
          <thead class="thead-dark">
    
            <tr>
           
            <th>Productos</th>
            <th>cantidad</th>
            <th>Total</th>
            <th>Venta</th>
           
            </tr>
            </thead> 
        ';
    $mes = $_POST['mes'];
    $idlocal = $_POST['idlocal'];
    $anio = $_POST['anio'];
    $ac = 0;
    $aci = 0;
    $i = 1;
    
    //datos de informe
    $resultados = mysqli_query($conexion,"SELECT producto.nombre_producto, ventas.total_venta'total', cantidad, ventas.tipoventa FROM ventas INNER JOIN producto on ventas.idproducto=producto.idproducto where mes='$mes' and ventas.idlocal=$idlocal and año=$anio ");
    while($consulta = mysqli_fetch_array($resultados))
	    {
        echo ' 
        <tr>';
                
				echo "<td>". $consulta['nombre_producto'] ."</td>";
                echo "<td>". $consulta['cantidad'] ."</td>";
				echo "<td>". $consulta['total'] ."</td>";
                echo "<td>". $consulta['tipoventa'] ."</td>";
                $totall = $consulta['total'];
                $cantidad = $consulta['cantidad'];
                $ac = $ac + $totall;
                $aci = $aci + $cantidad;
        echo "</tr>";
        $i++;
        }
        
        echo"<tr>
                    <tr class='font-weight-bold'>
                    
                        <td colspan=1>MES INFORME
                        <input type='text' name='total' id='totalC' class='form-control' value='$mes' style='font-size: 20px;  text-transform: uppercase; color: black;'> </td>
                        <td colspan=1>BULTOS
                    <input type='text' name='total' id='totalC' class='form-control' value='$aci' style='font-size: 20px;  text-transform: uppercase; color: black;'> </td>
                        <td colspan=1> RECAUDACION TOTAL$
                        <input type='number' name='total' id='totalC' class='form-control' value='$ac' style='font-size: 20px;  text-transform: uppercase; color: black;'></td>
                        <a href='exportar.php?mes=$mes&idlocal=$idlocal&anio=$anio' class='d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm'><i class='fas fa-download fa-sm text-white-50'></i>Exportar Informe</a>
                    </tr> ";
       
      echo "</tr>";
        
      
  }


  //informe datos tabla cliente
  if(isset($_POST['informe_dato_cliente']))
	{
        echo 
        '   
          <h5><center>Lista Detallada de Informe </center></h5>    
          <center><table class="table table-bordered order-table " style="width: 55%" id="example"></center>
          <thead class="thead-dark">
    
            <tr>
           
            <th>Productos</th>
            <th>cantidad</th>
            <th>Total</th>
            <th>Venta</th>
           
            </tr>
            </thead> 
        ';
    $idcliente = $_POST['id'];
    $mes = $_POST['mes'];
    $anio = $_POST['anio'];
    $idlocal = $_POST['idlocal'];
    $ac = 0;
    $aci = 0;
    $i = 1;
    //datos de informe
    echo'<tbody>';
    $resultados = mysqli_query($conexion,"SELECT producto.nombre_producto, ventas.total_venta'total', cantidad, tipoventa FROM ventas INNER JOIN cliente on ventas.idcliente=cliente.idcliente INNER JOIN producto on ventas.idproducto=producto.idproducto where ventas.idcliente=$idcliente and mes='$mes' and ventas.idlocal=$idlocal and año=$anio");
    while($consulta = mysqli_fetch_array($resultados))
	    {
        echo ' 
        <tr>';
                
				echo "<td>". $consulta['nombre_producto'] ."</td>";
                echo "<td>". $consulta['cantidad'] ."</td>";
				echo "<td>". $consulta['total'] ."</td>";
                echo "<td>". $consulta['tipoventa'] ."</td>";
                $totall = $consulta['total'];
                $cantidad = $consulta['cantidad'];
                $ac = $ac + $totall;
                $aci = $aci + $cantidad;
        echo "</tr>";
        $i++;
        }
        echo'<tbody>';
        echo"<tr>
                    <tr class='font-weight-bold'>
                    <td colspan=1>MES INFORME
                    <input type='text' name='total' id='totalC' class='form-control' value='$mes' style='font-size: 20px;  text-transform: uppercase; color: black;'> </td>
                        <td colspan=1>COMPRAS
                    <input type='text' name='total' id='totalC' class='form-control' value='$aci' style='font-size: 20px;  text-transform: uppercase; color: black;'> </td>
                        <td colspan=1> TOTAL COMPRAS $
                        <input type='number' name='total' id='totalC' class='form-control' value='$ac' style='font-size: 20px;  text-transform: uppercase; color: black;'></td>
                    </tr> ";

      echo "</tr>";
                
      echo"<a href='exportar_informe_cliente.php?idcliente=$idcliente&mes=$mes&idlocal=$idlocal&anio=$anio' class='d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm'><i class='fas fa-download fa-sm text-white-50'></i>Exportar Informe</a>";  
  }


  //informe ganancias tabla
  if(isset($_POST['tblinfo_ganancias']))
	{
       /* echo 
        '  
          <h5><center>Informe Ventas</center></h5>    
          <center><table class="table table-bordered order-table " style="width: 55%" id="example"></center>
          
          <thead class="thead-dark">
    
            <tr>
            
            <th>Recaudacion X Menor</th>
            <th>Recaudacion X Mayor</th>
            <th>Bultos</th>
            <th>Gasto en Compras</th>
            </tr>
            </thead> 
        ';*/
    $mes = $_POST['mes'];
    $idlocal = $_POST['idlocal'];
    $anio = $_POST['anio'];
    $ac = 0;
    $aci = 0;
    $i = 1;
    $ganancias_menor=0;
    $ganancias_mayor=0;
    $ganancias_compras=0;
    $compra_menor=0;
    $compra_mayor=0;
    $total_compra = 0;
    $total_menor = 0;
    $total_mayor = 0;
    $recaudacion_menor=0;
    $recaudacion_mayor=0;
    $cantidad_pro_menor=0;
    $recaudacion_compras=0;
    $cantidad_pro_mayor=0;
    $bultos = 0;
    //datos de informe ventas x menor
    $resultados = mysqli_query($conexion," SELECT SUM(ventas.total_venta)'total_menor', SUM(ventas.total_compra)'total_compra_menor', SUM(ventas.cantidad)'cantidad_menor' FROM ventas WHERE mes='$mes' and ventas.idlocal=$idlocal and año=$anio and tipoventa='Precio x Menor' ");
    while($consulta = mysqli_fetch_array($resultados))
	    {
        echo ' 
        <tr>';
              $cantidad_pro_menor = $consulta['cantidad_menor']; 
              $compra_menor = $consulta['total_compra_menor'];
              $total_menor = $consulta['total_menor'];
              //echo "<td>"."$". $consulta['total_menor'] ."</td>"; 
              if($total_menor>$compra_menor){
                $recaudacion_menor = $total_menor - $compra_menor;
              }else{
                $recaudacion_menor = $compra_menor - $total_menor;
              }
              
       
        }

        //datos de informe ventas x mayor
       
    $resultados = mysqli_query($conexion," SELECT SUM(ventas.total_venta)'total_mayor', SUM(ventas.total_compra)'total_compra_mayor', SUM(ventas.cantidad)'cantidad_mayor' FROM ventas WHERE mes='$mes' and ventas.idlocal=$idlocal and año=$anio and tipoventa='Precio x Mayor' ");
    while($consulta = mysqli_fetch_array($resultados))
	    {
                $cantidad_pro_mayor = $consulta['cantidad_mayor']; 
                $compra_mayor = $consulta['total_compra_mayor'];
                $total_mayor = $consulta['total_mayor'];
                //echo "<td>"."$". $consulta['total_mayor'] ."</td>";
                $bultos = $cantidad_pro_mayor + $cantidad_pro_menor;
                $total_compra = $compra_mayor + $compra_menor;
                //echo "<td>". $bultos ."</td>";
                //echo "<td>"."$". $total_compra ."</td>";
                if($total_mayor>$compra_mayor){
                    $recaudacion_mayor = $total_mayor - $compra_mayor;
                }else{
                    $recaudacion_mayor = $compra_mayor - $total_mayor;
                }
                
                $ganancia_final_ventas=0;
                $ganancia_final_ventas = $recaudacion_mayor + $recaudacion_menor;
                
                
       // echo "</tr>";
        $i++;
        }
       /* echo"<tr>
                    <tr class='font-weight-bold'>
            
                        <td colspan=1>Ganancias X Menor
                    <input type='text' name='total' id='totalC' class='form-control' value='$ $recaudacion_menor' style='font-size: 20px;  text-transform: uppercase; color: black;'>
                    <a href='detalle_ganancia_menor.php?mes=$mes&idlocal=$idlocal&anio=$anio&compra=$ganancias_compras&total_compras=$compra_menor' target='_blank' class='d-none d-sm-inline-block btn btn-sm btn- shadow-sm'><i class='fas fa-download fa-sm text-white-50'></i>Ver detalle</a> </td>
                        <td colspan=1>Ganancias X Mayor
                        <input type='text' name='total' id='totalC' class='form-control' value='$ $recaudacion_mayor' style='font-size: 20px;  text-transform: uppercase; color: black;'>
                        <a href='detalle_ganancias_mayor.php?mes=$mes&idlocal=$idlocal&anio=$anio&compra=$ganancias_compras&total_compras=$compra_mayor' target='_blank' class='d-none d-sm-inline-block btn btn-sm btn- shadow-sm'><i class='fas fa-download fa-sm text-white-50'></i>Ver detalle</a> </td>
                        <td colspan=1>Mes Informe
                        <input type='text' name='total' id='totalC' class='form-control' value='$mes' style='font-size: 20px;  text-transform: uppercase; color: black;'> 
                        <a href='' class='d-none d-sm-inline-block btn btn-sm btn- shadow-sm'><i class='fas fa-download fa-sm text-white-50'></i></a></td>
                        <td colspan=1>Ganancia Final
                        <input type='text' name='total' id='totalC' class='form-control' value='$ $ganancia_final_ventas' style='font-size: 20px;  text-transform: uppercase; color: black;'> 
                        <a href='' class='d-none d-sm-inline-block btn btn-sm btn- shadow-sm'><i class='fas fa-download fa-sm text-white-50'></i></a></td>
                    </tr> 
                    </table>";
       
      echo "</tr>";*/

        //cuentas corrientes

        /*echo 
        ' 
        <h5><center>Informe Cuenta Corriente</center></h5>    
   
          <center><table class="table table-bordered order-table " style="width: 55%" id="example"></center>
          
          <thead class="thead-dark">
    
            <tr>
            
            <th>Rec.Cuenta X Menor</th>
            <th>Rec.Cuenta X Mayor</th>
            <th>Bultos Cuenta</th>
            <th>Gastos Cuentas</th>
            </tr>
            </thead> 
        ';*/

        //cuenta corriente x menor
        $compra_menor_cuenta = 0;
        $cantidad_pro_menor_cuenta = 0;
        $total_menor_cuenta = 0;
        $recaudacion_menor_cuenta=0;

        $resultados = mysqli_query($conexion,"SELECT SUM(carrito_cuenta.total)'total_menor', SUM(carrito_cuenta.total_compra)'total_compra_menor', SUM(carrito_cuenta.cantidad)'cantidad_menor' FROM carrito_cuenta WHERE mes='$mes' and carrito_cuenta.idlocal=$idlocal and año=$anio and tipoventa='Precio x Menor' ");
        while($consulta = mysqli_fetch_array($resultados))
	      {
        echo ' 
        <tr>';
              $cantidad_pro_menor_cuenta = $consulta['cantidad_menor']; 
              $compra_menor_cuenta = $consulta['total_compra_menor'];
              $total_menor_cuenta = $consulta['total_menor'];
              //echo "<td>"."$". $consulta['total_menor'] ."</td>"; 
              if($total_menor_cuenta>$compra_menor_cuenta){
                $recaudacion_menor_cuenta = $total_menor_cuenta - $compra_menor_cuenta;
              }else{
                $recaudacion_menor_cuenta = $compra_menor_cuenta - $total_menor_cuenta;
              }
              
       
        }
        
        //cuenta corriente x mayor
        $compra_mayor_cuenta = 0;
        $cantidad_pro_mayor_cuenta = 0;
        $total_mayor_cuenta = 0;
        $recaudacion_mayor_cuenta=0;
        $total_compra_cuenta=0;
        $resultados = mysqli_query($conexion,"SELECT SUM(carrito_cuenta.total)'total_mayor', SUM(carrito_cuenta.total_compra)'total_compra_mayor', SUM(carrito_cuenta.cantidad)'cantidad_mayor' FROM carrito_cuenta WHERE mes='$mes' and carrito_cuenta.idlocal=$idlocal and año=$anio and tipoventa='Precio x Mayor' ");
        while($consulta = mysqli_fetch_array($resultados))
	      {
     
      
              $cantidad_pro_mayor_cuenta = $consulta['cantidad_mayor']; 
              $compra_mayor_cuenta = $consulta['total_compra_mayor'];
              $total_mayor_cuenta = $consulta['total_mayor'];
              $bultos_cuenta = $cantidad_pro_mayor_cuenta + $cantidad_pro_menor_cuenta;
              //echo "<td>"."$". $consulta['total_mayor'] ."</td>"; 
              $total_compra_cuenta = $compra_mayor_cuenta + $compra_menor_cuenta;
                //echo "<td>". $bultos_cuenta ."</td>";
                //echo "<td>"."$". $total_compra_cuenta ."</td>";
              if($total_mayor_cuenta>$compra_mayor_cuenta){
                $recaudacion_mayor_cuenta = $total_mayor_cuenta - $compra_mayor_cuenta;
              }else{
                $recaudacion_mayor_cuenta = $compra_mayor_cuenta - $total_mayor_cuenta;
              }
              $ganancia_final_cuenta = $recaudacion_menor_cuenta + $recaudacion_mayor_cuenta;
              
              //echo "</tr>";
        }
        $super_recaudacion_menor=0;
        $super_recaudacion_mayor=0;
        $super_recaudacion_menor = $recaudacion_menor + $recaudacion_menor_cuenta;
        $super_recaudacion_mayor = $recaudacion_mayor + $recaudacion_mayor_cuenta;
        $ganancia_final = $super_recaudacion_mayor + $super_recaudacion_menor;
        
        /*echo"<tr>
                    <tr class='font-weight-bold'>
            
                        <td colspan=1>Ganancias X Menor
                    <input type='text' name='total' id='totalC' class='form-control' value='$ $super_recaudacion_menor' style='font-size: 20px;  text-transform: uppercase; color: black;'>
                    <a href='detalle_ganancia_menor.php?mes=$mes&idlocal=$idlocal&anio=$anio&compra=$ganancias_compras&total_compras=$compra_menor' target='_blank' class='d-none d-sm-inline-block btn btn-sm btn- shadow-sm'><i class='fas fa-download fa-sm text-white-50'></i>Ver detalle</a> </td>
                        <td colspan=1>Ganancias X Mayor
                        <input type='text' name='total' id='totalC' class='form-control' value='$ $super_recaudacion_mayor' style='font-size: 20px;  text-transform: uppercase; color: black;'>
                        <a href='detalle_ganancias_mayor.php?mes=$mes&idlocal=$idlocal&anio=$anio&compra=$ganancias_compras&total_compras=$compra_mayor' target='_blank' class='d-none d-sm-inline-block btn btn-sm btn- shadow-sm'><i class='fas fa-download fa-sm text-white-50'></i>Ver detalle</a> </td>
                        <td colspan=1>Mes Informe
                        <input type='text' name='total' id='totalC' class='form-control' value='$mes' style='font-size: 20px;  text-transform: uppercase; color: black;'> 
                        <a href='' class='d-none d-sm-inline-block btn btn-sm btn- shadow-sm'><i class='fas fa-download fa-sm text-white-50'></i></a></td>
                        <td colspan=1>Ganancia Final
                        <input type='text' name='total' id='totalC' class='form-control' value='$ $ganancia_final' style='font-size: 20px;  text-transform: uppercase; color: black;'> 
                        <a href='' class='d-none d-sm-inline-block btn btn-sm btn- shadow-sm'><i class='fas fa-download fa-sm text-white-50'></i></a></td>
                    </tr> 
                    </table>";*/
       
      echo "</tr>";


      echo 
      '  
        <h5><center>Informe Final</center></h5>    
        <center><table class="table table-bordered order-table " style="width: 75%" id="example" ></center>
        
        <thead class="thead-dark">
  
          <tr>
          <th>Mes</th>
          <th>Tipo</th>
          <th style="width:30%;">Recaudacion X Menor</th>
          <th style="width:30%;">Recaudacion X Mayor</th>
          <th style="width:20%;">Bultos</th>
          <th style="width:60%;">Gasto en Compras</th>
          </tr>
          </thead> 
      ';
      $total_recaudacion_menor=0;
      $total_recaudacion_menor = $total_menor + $total_menor_cuenta;
      $total_recaudacion_mayor=0;
      $total_recaudacion_mayor = $total_mayor + $total_mayor_cuenta;
      $bulto_total=0;
      $bulto_total = $bultos + $bultos_cuenta;
      $total_compra_final=0;
      $total_compra_final = $total_compra + $total_compra_cuenta;
      echo "<tbody>
      <tr bgcolor='#FFEFD5'>
            <td> $mes </td>
            <td> Ventas </td>
            <td>$ $total_menor </td>
            <td>$$total_mayor </td>
            <td>$bultos </td>
            <td>$ $total_compra </td>
      </tr>
      <tr bgcolor='#90EE90' style='color: black;'>
            <td> $mes </td>
            <td> Ganancia Ventas </td>
            <td>$ $recaudacion_menor </td>
            <td>$ $recaudacion_mayor </td>
            <td>$bultos </td>
            <td colspan=1>Ganancia
                    <input type='text' name='total' id='totalC' class='form-control' value='$ $ganancia_final_ventas' style='font-size: 20px;  text-transform: uppercase; color: black;'>
                    </td>
      </tr>
      <tr bgcolor='#FFF8DC'>
            <td> $mes </td>
            <td> Cuentas </td>
            <td>$$total_menor_cuenta </td>
            <td>$$total_mayor_cuenta </td>
            <td>$bultos_cuenta </td>
            <td>$ $total_compra_cuenta </td>
      </tr>
      <tr bgcolor='#9ACD32' style='color: black;'>
            <td> $mes </td>
            <td> Ganancia Cuenta </td>
            <td>$ $recaudacion_menor_cuenta </td>
            <td>$ $recaudacion_mayor_cuenta </td>
            <td>$bultos_cuenta </td>
            <td colspan=1>Ganancia
                    <input type='text' name='total' id='totalC' class='form-control' value='$ $ganancia_final_cuenta' style='font-size: 20px;  text-transform: uppercase; color: black;'>
                    </td>
      </tr>
      <tr bgcolor='#FFF0F5' style='color: black;'>
            <td > $mes </td>
            <td> Ganancia Final </td>
            <td colspan=1>Total X Menor
                        <input type='text' name='total' id='totalC' class='form-control' value='$ $super_recaudacion_menor' style='font-size: 20px;  text-transform: uppercase; color: black;'>
                        </td>
            <td colspan=1>Total X Mayor
                        <input type='text' name='total' id='totalC' class='form-control' value='$ $super_recaudacion_mayor' style='font-size: 20px;  text-transform: uppercase; color: black;'>
                        </td>
            <td colspan=1>Bultos
                        <input type='text' name='total' id='totalC' class='form-control' value='$bulto_total' style='font-size: 20px;  text-transform: uppercase; color: black;'>
                        </td>
            <td colspan=1>Ganancia Final
                        <input type='text' name='total' id='totalC' class='form-control' value='$ $ganancia_final' style='font-size: 20px;  text-transform: uppercase; color: black;'>
                        </td>
      </tr>
    
            </tbody>";
          
  }
//query 
//tabla ganancias lista ventas x menor
//SELECT producto.nombre_producto, ventas.mi_precio'precio_compra', ventas.subtotal'precio_menor', cantidad,descuento, preciofinal,ventas.total_venta, ventas.tipoventa FROM ventas INNER JOIN producto on ventas.idproducto=producto.idproducto where mes='Noviembre' and ventas.idlocal=1 and año=2022 and tipoventa='Precio x Menor' 

//INFORME MENSUAL CUENTA
if(isset($_POST['informe_mensual_cuenta']))
	{
        echo 
        '  
          <h5><center>Lista Detallada de Informe</center></h5>    
          <center><table class="table table-bordered order-table " style="width: 55%" id="example"></center>
          
          <thead class="thead-dark">
    
            <tr>
           
            <th>Productos</th>
            <th>cantidad</th>
            <th>Total</th>
            <th>Venta</th>
           
            </tr>
            </thead> 
        ';
    $mes = $_POST['mes'];
    $idlocal = $_POST['idlocal'];
    $anio = $_POST['anio'];
    $ac = 0;
    $aci = 0;
    $i = 1;
    
    //datos de informe
    $resultados = mysqli_query($conexion,"SELECT producto.nombre_producto, carrito_cuenta.total'total', cantidad, carrito_cuenta.tipoventa FROM carrito_cuenta INNER JOIN producto on carrito_cuenta.idproducto=producto.idproducto where mes='$mes' and carrito_cuenta.idlocal=$idlocal and año=$anio ");
    while($consulta = mysqli_fetch_array($resultados))
	    {
        echo ' 
        <tr>';
                
				echo "<td>". $consulta['nombre_producto'] ."</td>";
                echo "<td>". $consulta['cantidad'] ."</td>";
				echo "<td>". $consulta['total'] ."</td>";
                echo "<td>". $consulta['tipoventa'] ."</td>";
                $totall = $consulta['total'];
                $cantidad = $consulta['cantidad'];
                $ac = $ac + $totall;
                $aci = $aci + $cantidad;
        echo "</tr>";
        $i++;
        }
        
        echo"<tr>
                    <tr class='font-weight-bold'>
                    
                        <td colspan=1>MES INFORME
                        <input type='text' name='total' id='totalC' class='form-control' value='$mes' style='font-size: 20px;  text-transform: uppercase; color: black;'> </td>
                        <td colspan=1>BULTOS
                    <input type='text' name='total' id='totalC' class='form-control' value='$aci' style='font-size: 20px;  text-transform: uppercase; color: black;'> </td>
                        <td colspan=1> RECAUDACION TOTAL$
                        <input type='number' name='total' id='totalC' class='form-control' value='$ac' style='font-size: 20px;  text-transform: uppercase; color: black;'></td>
                        </a>
                    </tr> ";
       
      echo "</tr>";

      
  }


  //INFORME CLIENTE CUENTA 
  if(isset($_POST['informe_dato_cliente_cuenta']))
	{
        echo 
        '   
          <h5><center>Lista Detallada de Informe </center></h5>    
          <center><table class="table table-bordered order-table " style="width: 55%" id="example"></center>
          <thead class="thead-dark">
    
            <tr>
           
            <th>Productos</th>
            <th>cantidad</th>
            <th>Total</th>
            <th>Venta</th>
           
            </tr>
            </thead> 
        ';
    $idcliente = $_POST['id'];
    $mes = $_POST['mes'];
    $anio = $_POST['anio'];
    $idlocal = $_POST['idlocal'];
    $ac = 0;
    $aci = 0;
    $i = 1;
    //datos de informe
    echo'<tbody>';
    $resultados = mysqli_query($conexion,"SELECT producto.nombre_producto, carrito_cuenta.total'total', cantidad, tipoventa FROM carrito_cuenta INNER JOIN cliente on carrito_cuenta.idcliente=cliente.idcliente INNER JOIN producto on carrito_cuenta.idproducto=producto.idproducto where carrito_cuenta.idcliente=$idcliente and mes='$mes' and carrito_cuenta.idlocal=$idlocal and año=$anio");
    while($consulta = mysqli_fetch_array($resultados))
	    {
        echo ' 
        <tr>';
                
				echo "<td>". $consulta['nombre_producto'] ."</td>";
                echo "<td>". $consulta['cantidad'] ."</td>";
				echo "<td>". $consulta['total'] ."</td>";
                echo "<td>". $consulta['tipoventa'] ."</td>";
                $totall = $consulta['total'];
                $cantidad = $consulta['cantidad'];
                $ac = $ac + $totall;
                $aci = $aci + $cantidad;
        echo "</tr>";
        $i++;
        }
        echo'<tbody>';
        echo"<tr>
                    <tr class='font-weight-bold'>
                    <td colspan=1>MES INFORME
                    <input type='text' name='total' id='totalC' class='form-control' value='$mes' style='font-size: 20px;  text-transform: uppercase; color: black;'> </td>
                        <td colspan=1>COMPRAS
                    <input type='text' name='total' id='totalC' class='form-control' value='$aci' style='font-size: 20px;  text-transform: uppercase; color: black;'> </td>
                        <td colspan=1> TOTAL COMPRAS $
                        <input type='number' name='total' id='totalC' class='form-control' value='$ac' style='font-size: 20px;  text-transform: uppercase; color: black;'></td>
                    </tr> ";

      echo "</tr>";
                
      echo"<a href='exportar_informe_cliente.php?idcliente=$idcliente&mes=$mes&idlocal=$idlocal&anio=$anio' class='d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm'><i class='fas fa-download fa-sm text-white-50'></i>Exportar Informe</a>";  
  }

?> 

 