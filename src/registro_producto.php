 <?php include_once "includes/header.php";
  include "../conexion.php";
  $id_user = $_SESSION['idUser'];
  $permiso = "productos";
  $sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
  $existe = mysqli_fetch_all($sql);
  if (empty($existe) && $id_user != 1) {
    echo "<script> window.location.replace('permisos.php') </script>";
  }
  if (!empty($_POST)) {
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
  ?>

 <!-- Begin Page Content -->
 <div class="container-fluid">

   <!-- Page Heading -->
   <div class="d-sm-flex align-items-center justify-content-between mb-4">
     <h1 class="h3 mb-0 text-gray-800">Panel de Administración</h1>
     <a href="lista_productos.php" class="btn btn-primary">Regresar</a>
   </div>

   <!-- Content Row -->
   <div class="row">
   <div class="box-tools pull-right">
   <form action="" method="post" autocomplete="off" enctype="multipart/form-data">
         <?php echo isset($alert) ? $alert : ''; ?>
                          <div class="form-group">
                            <label><i class="fa fa-barcode"></i> Codigo</label>
                            <input type="text" class="form-control" name="codigo" id="codigo" maxlength="256" placeholder="Codigo de Barra" required>
                          </div>

                          <div class="form-group">
                            <label>Nombre Producto</label>
                            <input type="text" class="form-control" name="nombre_producto" id="nombre_producto" maxlength="50" placeholder="Nombre Producto" required>
                          </div>
                          <div class="form-group">
                            <label>Precio Compra</label>
                            <input type="text" class="form-control" name="mi_precio" id="mi_precio" maxlength="256" placeholder="Precio compra">
                            </div>
                          
                          <div class="form-group">
                            <label>Stock</label>
                            <input type="text" class="form-control" name="stock" id="stock" maxlength="256" placeholder="Stock producto">
                          </div>

                          <div class="form-group">
                            <label> Porcentaje Menor %</label>
                            <input type="number"  class="form-control" name="porcentaje_menor" id="porcentaje_menor" maxlength="256" placeholder="% X Menor" onclick="calcular_menor();">
                          </div>

                          <div class="form-group">
                            <label> Porcentaje Mayor %</label>
                            <input type="number"  class="form-control" name="porcentaje_mayor" id="porcentaje_mayor" maxlength="256" placeholder="% X Mayor" onclick="calcular_mayor();">
                          </div>

                          <div class="form-group">
                            <label>Precio x Menor</label>
                            <input type="text"  class="form-control" name="precio" id="precio" maxlength="256" placeholder="Precio Menor">
                          </div>
                        
                          <div class="form-group">
                            <label>Precio x Mayor</label>
                            <input type="text"  class="form-control" name="precio_mayor" id="precio_mayor" maxlength="256" placeholder="Precio Mayor">
                          </div>
   </div>
     <div class="col-lg-6 m-auto">
                          <div class="form-group">
                            <label>Unidad</label>
                            <select name="unidad" class="form-control" id="unidad" style="width:40%;">
                            <option value="unidad">Unidad</option>
                            <option value="litro">Litro</option>
                            <option value="kg">Kg</option>
                            </select>
                          </div>
                          
                          <div class="form-group">
                            <label>Proveedor</label>
                                <select name="proveedor" class="form-control" id="proveedor"style="width:40%;">
                                                    <option value="">Seleccionar Proveedor</option>
                                                     <?php

                                          
                                                        //traer proveedor
                                                        include "../conexion.php";
                                                    $query = mysqli_query($conexion, "SELECT * FROM proveedores");
                                                    $result = mysqli_num_rows($query);
                                                    
                                                    while($row = mysqli_fetch_assoc($query))
                                                    {
	                                                //$idrol = $row['idrol'];
                                                    $prov = $row['nombre_proveedor'];
                                                    $idprov = $row['idproveedor'];

													?>
													
                                                    <option value="<?php echo $idprov; ?>"><?php echo $prov; ?></option>  

                                                    <?php
                                                     }
                                                    
                                                     ?>
							    </select>                          
                        </div>

                        <div class="form-group">
                            <label>Rubro</label>
                            <select name="idrubro2" class="form-control" id="idrubro2" style="width:40%;"onchange="listaMarcas2();" >
                         <option value="">Seleccionar Rubro</option>
                    
                    <?php

                                          
                                                        //traer proveedor
                                                        include "../conexion.php";
                                                    $query = mysqli_query($conexion, "SELECT * FROM rubro");
                                                    $result = mysqli_num_rows($query);
                                                    
                                                    while($row = mysqli_fetch_assoc($query))
                                                    {
	                                                //$idrol = $row['idrol'];
                                                    $rubro = $row['nombre_rubro'];
                                                    $idrubro = $row['idrubro'];

													?>
													
                                                    <option value="<?php echo $idrubro; ?>"><?php echo $rubro; ?></option>  

                                                    <?php
                                                     }
                                                    
                                                     ?>
								</select>
                          </div>

                          <div class="form-group">
                            <label>Marca</label>
                            <select name="idmarca" class="form-control" style="width:40%;" id="idmarca">
                            <option value="">Seleccionar Marca</option>
                    <?php
                                                        //traer marca
                                                        include "../conexion.php";
                                                    $query = mysqli_query($conexion, "SELECT * FROM marcas");
                                                    $result = mysqli_num_rows($query);
                                                    
                                                    while($row = mysqli_fetch_assoc($query))
                                                    {
	                                                //$idrol = $row['idrol'];
                                                    $marca = $row['nombre_marca'];
                                                    $idmarca = $row['idmarca'];

													?>
													
                                                    <option value="<?php echo $idmarca; ?>"><?php echo $marca; ?></option>  

                                                    <?php
                                                     }
                                                    
                                                     ?>
								</select>
                          </div>

                          <div class="form-group">
                            <label>Locales</label>
                            <select name="locales" class="form-control" id="locales" style="width:40%;">
                    <?php
                                                        //traer sedes
                                                        include "../conexion.php";
                                                        $rs = mysqli_query($conexion, "SELECT usuario, idlocal FROM usuario WHERE idusuario='$id_user'");
                                                        while($row = mysqli_fetch_array($rs))
                                                        {
                                                            $idlocal1=$row['idlocal'];
                                                            $admin = $row['usuario'];
                                                            //echo $admin;
                                                        
                                                        }
                                                        if($admin=="admin"){

                                                            $query = mysqli_query($conexion, "SELECT idlocal,nombre_local FROM locales");

                                                        }else{

                                                            $query = mysqli_query($conexion, "SELECT idlocal,nombre_local FROM locales WHERE idlocal='$idlocal1'");

                                                        }    
                                                    
                                                    $result = mysqli_num_rows($query);
                                                    
                                                    while($row = mysqli_fetch_assoc($query))
                                                    {
	                                                
                                                    $local = $row['nombre_local'];
                                                    $idlocal = $row['idlocal'];
													?>
													
                                                    <option value="<?php echo $idlocal; ?>"><?php echo $local; ?></option>  

                                                    <?php
                                                     }
                                                    
                                                     ?>
								</select>
                          </div>

                            <div class="form-group">
                            <label>Archivo</label>
                            <input type="file" class="form-control" id="imagen" name="imagen" multiple>
                            <img width="120" id="imagenPrevisualizacion">
                            </div>

         <input type="submit" value="Guardar Producto" class="btn btn-primary">
       </form>
     </div>
   </div>


 </div>
 <!-- /.container-fluid -->

 </div>
 <!-- End of Main Content -->

<script src="http://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
<script type="text/javascript" src="js/categoria.js"></script>
<script type="text/javascript" src="js/producto1.js"></script>
<script type="text/javascript" src="js/autocompletado.js"></script> 


<script type="text/javascript">
  //previsualizar imagen  
const $seleccionArchivos = document.querySelector("#imagen"),
$imagenPrevisualizacion = document.querySelector("#imagenPrevisualizacion");

// Escuchar cuando cambie
$seleccionArchivos.addEventListener("change", () => {
// Los archivos seleccionados, pueden ser muchos o uno
const archivos = $seleccionArchivos.files;
// Si no hay archivos salimos de la función y quitamos la imagen
if (!archivos || !archivos.length) {
$imagenPrevisualizacion.src = "";
return;
}
// Ahora tomamos el primer archivo, el cual vamos a previsualizar
const primerArchivo = archivos[0];
// Lo convertimos a un objeto de tipo objectURL
const objectURL = URL.createObjectURL(primerArchivo);
// Y a la fuente de la imagen le ponemos el objectURL
$imagenPrevisualizacion.src = objectURL;
});

  //buscardor tbl
    (function(document) {
	'use strict';

	var LightTableFilter = (function(Arr) {

	  var _input;

	  function _onInputEvent(e) {
		_input = e.target;
		var tables = document.getElementsByClassName(_input.getAttribute('data-table'));
		Arr.forEach.call(tables, function(table) {
		  Arr.forEach.call(table.tBodies, function(tbody) {
			Arr.forEach.call(tbody.rows, _filter);
		  });
		});
	  }

	  function _filter(row) {
		var text = row.textContent.toLowerCase(), val = _input.value.toLowerCase();
		row.style.display = text.indexOf(val) === -1 ? 'none' : 'table-row';
	  }

	  return {
		init: function() {
		  var inputs = document.getElementsByClassName('light-table-filter');
		  Arr.forEach.call(inputs, function(input) {
			input.oninput = _onInputEvent;
		  });
		}
	  };
	})(Array.prototype);

	document.addEventListener('readystatechange', function() {
	  if (document.readyState === 'complete') {
		LightTableFilter.init();
	  }
	});

  })(document);
  </script>
 <?php include_once "includes/footer.php"; ?>