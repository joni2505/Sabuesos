<?php include_once "includes/header.php"; 
include "../conexion.php";
$id_user = $_SESSION['idUser'];
$permiso = "productos";
$sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
$existe = mysqli_fetch_all($sql);
if (empty($existe) && $id_user != 1) {
    echo "<script> window.location.replace('permisos.php') </script>";
}
$resultados = mysqli_query($conexion,"SELECT idlocal FROM usuario where idusuario='$id_user'");
while($consulta = mysqli_fetch_array($resultados))
	    {
			$idlocal = $consulta['idlocal'];
		}
?>  
<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Productos</h1>
		<a href="registro_producto.php" class="btn btn-primary">Nuevo</a>
		<input type="hidden" id="idlocal" value="<?php echo $idlocal; ?>">

		<button type="button" class="btn btn-success"data-toggle="modal" data-target="#suelto" onclick="tabla_suelto();">Producto Suelto</button>
	</div>

	<div class="row">
		<div class="col-lg-12">

		<div class="table-responsive">
				<table class="table table-striped table-bordered" id="tbl">
					<thead class="thead-dark">
						<tr>
						  <th>Codigo</th>
                          <th>Nombre Producto</th>
                          <th>Precio x Menor</th>
                          <th>Precio x Mayor</th>
                          <th>Stock</th>
                          <th>Unidad</th>
                          <th>Rubro</th>
                          <th>Marca</th>
						  <th>ACCIONES</th>
							
						</tr>
					</thead>
					<tbody>
						<?php
						include "../conexion.php";
						$rs = mysqli_query($conexion, "SELECT usuario, idlocal FROM usuario WHERE idusuario='$id_user'");
						while($row = mysqli_fetch_array($rs))
						{
							$idlocal1=$row['idlocal'];
							$admin = $row['usuario'];
							//echo $admin;
						
						}
						if($admin=="admin"){
							$query = mysqli_query($conexion, "SELECT idproducto, codigo_producto, nombre_producto,  precio_producto, precio_mayor, stock_producto,
							unidad_producto, proveedores.nombre_proveedor'proveedor', producto.estado, rubro.nombre_rubro'rubro', marcas.nombre_marca'marca', imagen, producto.idmarca FROM producto
							INNER JOIN proveedores on producto.idproveedor=proveedores.idproveedor
							left join rubro on producto.idrubro=rubro.idrubro
							left join marcas on producto.idmarca=marcas.idmarca");
		
						}else{
							$query = mysqli_query($conexion, "SELECT idproducto, codigo_producto, nombre_producto,  precio_producto, precio_mayor, stock_producto,
							unidad_producto, proveedores.nombre_proveedor'proveedor', producto.estado, rubro.nombre_rubro'rubro', marcas.nombre_marca'marca', imagen, producto.idmarca FROM producto
							left JOIN proveedores on producto.idproveedor=proveedores.idproveedor
							left join rubro on producto.idrubro=rubro.idrubro
							left join marcas on producto.idmarca=marcas.idmarca WHERE idlocal='$idlocal1'");
						}

						$i=1;
						$rownumber=0;
						$result = mysqli_num_rows($query);
						if ($result > 0) {
							while ($data = mysqli_fetch_assoc($query)) {
							$rownumber = $data ['idproducto'];
							$cod = $data["codigo_producto"];
							$nom = $data["nombre_producto"];
							$pre = $data["precio_producto"];
							$prem = $data["precio_mayor"];
							$stock = $data["stock_producto"];

					    ?>	
						<tr>
						 	<!--<td scope="row"><?php echo $rownumber; ?></td>-->
							 <td id="codigo_producto:<?php echo $rownumber; ?>" contenteditable="true"><?php echo $cod; ?></td>
							<td id="nombre_producto:<?php echo $rownumber; ?>" contenteditable="true"><?php echo $nom; ?></td>
							<td id="precio_producto:<?php echo $rownumber; ?>" contenteditable="true"><?php echo $pre; ?></td>
							<td id="precio_mayor:<?php echo $rownumber; ?>" contenteditable="true"><?php echo $prem; ?></td>
							<td id="stock_producto:<?php echo $rownumber; ?>" contenteditable="true"><?php echo $stock; ?></td>
							<td> <?php echo $data['unidad_producto']; ?></td>
							<td> <?php echo $data['rubro']; ?></td>
							<td> <?php echo $data['marca']; ?></td>
									<td>
										<!--<a href="agregar_producto.php?id=<?php echo $data['idproducto']; ?>" class="btn btn-primary"><i class='fas fa-audio-description'></i></a>-->

										<a href="editar_producto.php?id=<?php echo $data['idproducto']; ?>" class="btn btn-success"><i class='fas fa-edit'></i></a>

										<form action="eliminar_producto.php?id=<?php echo $data['idproducto']; ?>" method="post" class="confirmar d-inline">
											<button class="btn btn-danger" type="submit"><i class='fas fa-trash-alt'></i> </button>
										</form>
									</td>
									
								</tr>
						<?php $i++; }
						} ?>
					</tbody>

				</table>
			</div>

		</div>
	</div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<!-- Modal suelto -->
<div class="modal" tabindex="-1" role="dialog" id="suelto">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Producto X suelto</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        
      </div>
      <div class="modal-body">
      <form action="" method="post" autocomplete="off">
      <div class="form-group">  
      <label>Producto</label>
      <input type='text' name="producto" id="producto" class='form-control' style='font-size: 20px; width:72%; text-transform: uppercase; color: black;'>                                           
      <div id="response"></div>
      </div>
      <div class="form-group">  
      <label>Kilos Bolsa</label>
      <input type='number' name="kg" id="kg" class='form-control'style='font-size: 20px; width:72%; text-transform: uppercase; color: black;' onkeyup="if(event.keyCode ==13) calcular_gramos();">                                           
      </div>
      <div class="form-group">  
      <label>Gramos Totales</label>
      <input type='number' name="gramos" id="gramos" class='form-control'style='font-size: 20px; width:72%; text-transform: uppercase; color: black;'>                                           
      </div>
      <div class="form-group">  
      <label>Precio x Kg</label>
      <input type='number' name="precio3" id="precio3" class='form-control'style='font-size: 20px; width:72%; text-transform: uppercase; color: black;'>                                           
      </div>
      <div class="form-group">  
      <label>Stock Suelto</label>
      <input type='number' name="stock3" id="stock3" class='form-control'style='font-size: 20px; width:72%; text-transform: uppercase; color: black;'>                                            
      </div>
      <input type="button" value="Guardar" class="btn btn-primary" onclick="agregar_suelto();">
      <div id="mostrar_mensaje"></div>
      </form>

      <div class="table-responsive">
      <br><input class="form-control col-md-3 light-table-filter" data-table="order-table" type="text" placeholder="Buscar...">
      <div id="mostrar_sueltos"></div>
      </div>
      </div>
      <div class="modal-footer">
        
      </div>
    </div>
  </div>
</div>
<script src="http://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
<script type="text/javascript" src="js/categoria.js"></script>
<script type="text/javascript" src="js/producto1.js"></script>
<script type="text/javascript" src="js/autocompletado.js"></script> 
<script type="text/javascript" src="js/funciones.js"></script> 

<script type="text/javascript">

 //tabla productos sueltos
 function tabla_suelto()
  { 
    
    idlocal = $("#idlocal").val();
  var parametros = 
  {
  
  "tabla_suelto" : "1",
  "idlocal" : idlocal,
  "variable" : "4"
  };
  
  $.ajax({
  data: parametros,
  url: 'tablas.php',
  type: 'POST',
  
  beforesend: function()
  {
  $('#mostrar_sueltos').html("Mensaje antes de Enviar");
  
  },
  
  success: function(mensaje)
  {
  $('#mostrar_sueltos').html(mensaje);
  
  }
  });
  }

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