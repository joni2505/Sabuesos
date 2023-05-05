<?php
require("../conexion.php");


if(isset($_POST['buscar_productos']))
	{
        $locales = $_POST['locales'];
		$valores = array();
		$resultados = mysqli_query($conexion,"SELECT COUNT(idproducto)'total' FROM producto WHERE idlocal='$locales'");
		  while($consulta = mysqli_fetch_array($resultados))
		  {
			  $valores['total'] = $consulta['total'];
		  }
		  sleep(1);
		  $valores = json_encode($valores);
		  echo $valores;
          //tabla
	
	}

	if(isset($_POST['lista_producto']))
	{
		
		$idprovee = $_POST['id'];
        //echo $idprovee;
        echo '

        <div class="form-group">
                         <label for="productos">Productos</label>
                         <select name="productos" class="form-control" id="productos"style="width:80%;" onchange="selectPro();" >
                    <option value="Select">Select Productos</option>';
                 

                                          
                                                    
                                                        //traer proveedor
                                                        include "../conexion.php";
                                                    $query = mysqli_query($conexion, "SELECT * FROM producto WHERE idproveedor='$idprovee'");
                                                    $result = mysqli_num_rows($query);
                                                    
                                                    while($row = mysqli_fetch_assoc($query))
                                                    {
	                                                //$idrol = $row['idrol'];
                                                    $prod = $row['nombre_producto'];
                                                    $idprod = $row['idproducto'];
                                                   
																				
                                                    echo "<option value='$idprod'>$prod</option>";

                                                
                                                     }
                                                    
                                                    
                                                    
                                                
                                                     echo '</select>
                     </div>
                     
        
        
        ';
	

	}
    
    if(isset($_POST['comprar']))
	{
         $idusuario = $_POST['idusuario'];
        $idlocal = $_POST['idlocal'];
        $idproveedor = $_POST['proveedor'];
        $idproducto = $_POST['idproducto'];
        $precio = $_POST['precio'];
        $cantidad = $_POST['cantidad'];
        $total = $_POST['total'];
        //$descuento = $_POST['descuento'];
        //$mediodePago = $_POST['mediodePago'];
        //$cambio = $_POST['cambio'];
        //$factura = $_POST['factura'];
        //$apellido = $_POST['apellido'];
        //$nombre = $_POST['nombre'];
        //$importe = $_POST['importe'];
        //$tipo = $_POST['tipo2'];
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $fecha=date("Y-m-d");
        $fechaComoEntero = strtotime($fecha);
            $año = date("Y", $fechaComoEntero);
            $mes = date("M", $fechaComoEntero);

  
        //validar que no esten los campos vacios de ventas
        $alert = "";
        if (empty($idusuario) || empty($idlocal) || empty($idproveedor)) {
          echo '<script language="javascript">';
          echo 'alert("Campos vacios");';
          echo '</script>';
        }else {

          $query_insert = mysqli_query($conexion, "INSERT INTO compra(idproducto, idproveedor, idusuario, idlocal, fecha_compra, sub_total, cantidad, total ) values ('$idproducto', '$idproveedor', '$idusuario', '$idlocal', '$fecha', '$precio', '$cantidad', '$total')");
          if ($query_insert) {
                    echo '<script language="javascript">';
                    echo 'alert("Compraste el producto correctamente");';
                    echo '</script>';
        
            } else{
            echo '<script language="javascript">';
            echo 'alert("Error al Comprar");';
            echo '</script>';
        
           
            }
        
        //Incrementar Stock
        
        $rs = mysqli_query($conexion, "SELECT stock_producto FROM producto WHERE idproducto ='$idproducto'");
        while($row = mysqli_fetch_array($rs))
        {
            $stock=$row['stock_producto'];
        
        }
        //sumar los stock
        $Sumstock = $cantidad + $stock;
        
        $rs = mysqli_query($conexion, "UPDATE producto SET stock_producto = '$Sumstock', mi_precio = '$precio' WHERE idproducto='$idproducto'");
       if ($rs) {
           echo '<script language="javascript">';
           echo 'alert("Incremento el stock del producto");';
           echo 'window.location.href = "compras.php";';
           echo '</script>';
           
           $Sumstock=0;
       } else {
           echo '<script language="javascript">';
           echo 'alert("Error modificar stock");';
           echo '</script>';
       } 
            
        }
    }
			


?>

<script type="text/javascript">
    function selectPro()
    {
    /* Para obtener el valor */
    //var cod = document.getElementById("productos").value;
    //alert(cod);
    document.getElementById("idproducto").value = document.getElementById("productos").value;
     
    }

    </script> 
