<?php 
//include_once "includes/header.php";
include "../conexion.php";
$config = mysqli_query($conexion, "SELECT * FROM configuracion");
$datos = mysqli_fetch_assoc($config);
$rubro = $_GET['idrubro'];
$marca = $_GET['idmarca'];
date_default_timezone_set('America/Argentina/Buenos_Aires');
$feha_actual=date("d-m-Y H:i:s");


?>
<!DOCTYPE HTML5>
<html>
	<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Lista de Precios x Producto</title>
    
    <link href="../assets/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <link rel="stylesheet" href="../assets/js/jquery-ui/jquery-ui.min.css">
    <script src="../assets/js/all.min.js" crossorigin="anonymous"></script>
    <style>

    table {
		/* Para centrar usamos "auto" en la alineación horizontal */
    margin: 0 auto;
		/*Lo siguiente es para los bordes*/
    border-collapse: collapse;   
    }
</style>
	</head >
    
	
    <body onload="window.print()">
    
    <img class="img-thumbnail" src="sabueso.jpg" width="210">

    <h4>Fecha y Hora <?php echo $feha_actual?></h4>
    <h4>Celular: <?php echo $datos['telefono'];?>  </h4> 
    <h4>Direccion: <?php echo $datos['direccion'];?>  </h4>
    <h4>Correo: <?php echo $datos['email'];?>  </h4>
     

<h4 class="font-weight-light my-4"><center>Lista de Precios x Productos</center></h4>
		<table style="border-collapse: collapse;" border="1"; width="700"; height= "100px";>
		
        <thead class="thead-dark">
		<tr width="100"  rowspan="4">
 
                 <th>Código</th>
                 <th><center>Producto</center></th>
                 <th><center>Precio Menor</center></th>
                 <th><center>Precio Mayor</center></th>
                 <th><center>Marca</center></th>
                 <th><center>Imagen</center></th>
                
           
		<tr>
        </thead>
         <tbody>
         <?php
                include "../conexion.php";
               
                if(($rubro !="vacio") && ($marca=="vacio") ){

                    $lista = mysqli_query($conexion, "SELECT idproducto, codigo_producto, nombre_producto,  precio_producto, precio_mayor, stock_producto,
                unidad_producto, proveedores.nombre_proveedor'proveedor', producto.estado, rubro.nombre_rubro'rubro', marcas.nombre_marca'marca', imagen, ruta FROM producto
                INNER JOIN proveedores on producto.idproveedor=proveedores.idproveedor
                inner join rubro on producto.idrubro=rubro.idrubro
                inner join marcas on producto.idmarca=marcas.idmarca WHERE rubro.nombre_rubro='$rubro' ");
                
                
                }else if(($rubro=="vacio") && ($marca !="vacio") ){
                
                    $lista = mysqli_query($conexion, "SELECT idproducto, codigo_producto, nombre_producto,  precio_producto, precio_mayor, stock_producto,
                unidad_producto, proveedores.nombre_proveedor'proveedor', producto.estado, rubro.nombre_rubro'rubro', marcas.nombre_marca'marca', imagen, ruta FROM producto
                INNER JOIN proveedores on producto.idproveedor=proveedores.idproveedor
                inner join rubro on producto.idrubro=rubro.idrubro
                inner join marcas on producto.idmarca=marcas.idmarca WHERE marcas.nombre_marca='$marca' ");
                
                
                }else if( ($rubro !="vacio") && ($marca !="vacio") ){
                
                    $lista = mysqli_query($conexion, "SELECT idproducto, codigo_producto, nombre_producto,  precio_producto, precio_mayor, stock_producto,
                unidad_producto, proveedores.nombre_proveedor'proveedor', producto.estado, rubro.nombre_rubro'rubro', marcas.nombre_marca'marca', imagen, ruta FROM producto
                INNER JOIN proveedores on producto.idproveedor=proveedores.idproveedor
                inner join rubro on producto.idrubro=rubro.idrubro
                inner join marcas on producto.idmarca=marcas.idmarca WHERE marcas.nombre_marca='$marca' AND rubro.nombre_rubro='$rubro' ");
                
                }

                $i=1;
                while ($data = mysqli_fetch_assoc($lista)) {
                      
                ?>
                     <tr style=" border: inset 0pt" colspan="23" align="center">
                     <?php $data['idproducto'];?>
                     
                         <td><?php echo $data['codigo_producto']; ?></td>
                         <td><?php echo $data['nombre_producto']; ?></td>
                         <td><center><?php echo "$".$data['precio_producto']; ?></center></td>
                         <td><center><?php echo "$".$data['precio_mayor']; ?></center></td>
                         <td><?php echo $data['marca']; ?></td>
                         <td><img width="100" src="data:image/jpeg/jpg/png;base64,<?php echo  base64_encode($data['imagen']); ?>"></td>
                         
                         
                     </tr>
             <?php $i++; }
            ?>
        </tbody>
		</table>


	</body>
</html>



