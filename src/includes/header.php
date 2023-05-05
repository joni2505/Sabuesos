<?php
session_start();
if (empty($_SESSION['active'])) {
	header('location: ../');
}
include "includes/functions.php";
include "../conexion.php";
$id_user = $_SESSION['idUser'];
$rs = mysqli_query($conexion,"SELECT usuario.idlocal, locales.nombre_local FROM usuario INNER JOIN locales on usuario.idlocal=locales.idlocal WHERE usuario.idusuario ='$id_user'");
            while($row = mysqli_fetch_array($rs))
            {
              //$valores['existe'] = "1"; //Esta variable no la usamos en el vídeo (se me olvido, lo siento xD). Aqui la uso en la linea 97 de registro.php
              $local = $row['nombre_local'];
              $idlocal = $row['idlocal'];
            }
// datos Empresa
$dni = '';
$nombre_empresa = '';
$razonSocial = '';
$emailEmpresa = '';
$telEmpresa = '';
$dirEmpresa = '';
$igv = '';

$query_empresa = mysqli_query($conexion, "SELECT * FROM configuracion WHERE idlocal = $idlocal");
$row_empresa = mysqli_num_rows($query_empresa);
if ($row_empresa > 0) {
	if ($infoEmpresa = mysqli_fetch_assoc($query_empresa)) {
		//$dni = $infoEmpresa['dni'];
		$nombre_empresa = $infoEmpresa['nombre'];
		//$razonSocial = $infoEmpresa['razon_social'];
		$telEmpresa = $infoEmpresa['telefono'];
		$emailEmpresa = $infoEmpresa['email'];
		$dirEmpresa = $infoEmpresa['direccion'];
		//$igv = $infoEmpresa['igv'];
	}
}
/*$query_data = mysqli_query($conexion, "CALL data();");
$result_data = mysqli_num_rows($query_data);
if ($result_data > 0) {
	$data = mysqli_fetch_assoc($query_data);
}*/
?>
<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
  
	<title>Sabuesos Petshop</title>

	<!-- Custom styles for this template-->
	<link href="css/sb-admin-2.min.css" rel="stylesheet">
	<link rel="stylesheet" href="css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">

</head>
<!--Modal nuevo cliente-->
<div id="nuevo_cliente" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="my-modal-title">Nuevo Cliente</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" autocomplete="off">
                    <div class="form-group">
                        <label for="nombre">Nombre y Apellido</label>
                        <input type="text" placeholder="Ingrese Nombre" name="nombre2" id="nombre2" class="form-control">
                    </div>
                    <!--<div class="form-group">
                        <label for="apellido">Apellido</label>
                        <input type="text" placeholder="Ingrese Nombre" name="apellido" id="apellido2" class="form-control">
                    </div>-->
                    <div class="form-group">
                        <label for="direccion">Dirección</label>
                        <input type="text" placeholder="Ingrese Direccion" name="direccion" id="direccion2" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="telefono">Celular</label>
                        <input type="number" placeholder="Ingrese Teléfono" name="celular" id="celular2" class="form-control">
                    </div>
                    
                    <input type="button" value="Guardar Cliente" class="btn btn-primary" onclick="agregar_cliente();">
                    <div id="mostrar_mensaje"></div>
                  </form>
            </div>
        </div>
    </div>
</div>


<!--Modal Marca-->
<div class="modal" tabindex="-1" id="marca">
  <div class="modal-dialog">
    <div class="modal-content " >
      <div class="modal-header">
        <h5 class="modal-title">Nueva Marca</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        
      </div>
      <div class="modal-body">
      <form action="marca.php" method="post" autocomplete="off">
      <div class="form-group">  
      <label>Nombre Marca</label>
      <input type='text' name='marca' id='marca' class='form-control'style='font-size: 20px; width:72%; text-transform: uppercase; color: black;'> </td>
      </div>
      <div class="form-group">  
      <label>detalle</label>
      <input type='text' name="detalle" id="detalle" class='form-control'style='font-size: 20px; width:72%; text-transform: uppercase; color: red;'> </td>                                           
      </div>
      <div class="form-group">
                         <label for="rubro">Rubro</label>
                         <select name="rubros" class="form-control" id="rubros"style="width:60%;">
                    <option value="">Select Rubro</option>
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
                <button type="submit" class="btn btn-success">Guardar Marca</button>

                </form>
      <div id="mostrar_cierre"></div>
      <div class="table-responsive">
      <h3><center>Lista de Marcas<center></h3>
      <input class="form-control col-md-3 light-table-filter" data-table="order-table" type="text" placeholder="Buscar .."><br>
      <table class="table table-bordered order-table">
      <thead class="thead-dark">
             <tr>
                 <th>#</th>
                 <th>Marca</th>
                 <th>Detalle</th>
                 <th>Rubro</th>
                 <th></th>
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
              

                $query = mysqli_query($conexion, "SELECT marcas.idmarca, nombre_marca, marcas.detalle, rubro.nombre_rubro'rubro' FROM marcas LEFT JOIN rubro on marcas.idrubro=rubro.idrubro");
                
                $i=1;
                $result = mysqli_num_rows($query);
                if ($result > 0) {
                    while ($data = mysqli_fetch_assoc($query)) {
                        
                ?>
                     <tr>
                     <?php $data['idmarca'];?>
                     <td><?php echo $i; ?></td>
                     <td><?php echo $data['nombre_marca']; ?></td>
                         <td><?php echo $data['detalle']; ?></td>
                         <td><?php echo $data['rubro']; ?></td>
                        
                         <td>
                         <a href="eliminar_marca.php?id=<?php echo $data['idmarca']; ?>" class="btn btn-danger"><i class='fas fa-trash-alt'></i></a>
                         <a href="editar_marca.php?id=<?php echo $data['idmarca']; ?>" class="btn btn-primary"><i class='fas fa-edit'></i></a>

                         </td>
                     </tr>
             <?php $i++; }
                } ?>
             
         </tbody>
     </table>
     </div>
      </div>
     
      <div class="modal-footer">
        
      </div>
    </div>
  </div>
</div>


<!--Modal Rubro-->
<div class="modal" tabindex="-1" id="rubro">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Nuevo Rubro</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        
      </div>
      <div class="modal-body">
        <form action="rubro.php" method="post" autocomplete="off">
      <div class="form-group">  
      <label>Nombre Rubro</label>
      <input type='text' name='rubro' id='rubro' class='form-control'style='font-size: 20px; width:72%; text-transform: uppercase; color: black;'> </td>
      </div>
      <div class="form-group">  
      <label>detalle</label>
      <input type='text' name="detalle" id="detalle" class='form-control'style='font-size: 20px; width:72%; text-transform: uppercase; color: red;'> </td>                                           
      </div>
      <button type="submit" class="btn btn-primary">Guardar Rubro</button>
      <div id="mostrar_cierre"></div>
      <div class="table-responsive">
      <h3><center>Lista de Rubros<center></h3>
      <input class="form-control col-md-3 light-table-filter" data-table="order-table" type="text" placeholder="Buscar Rubros.."><br>
      <table class="table table-bordered order-table">
         <thead class="thead-dark">
             <tr>
                 <th>#</th>
                 <th>Rubro</th>
                 <th>Detalle</th>
               
                 <th></th>
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
              

                    $query = mysqli_query($conexion, "SELECT * FROM rubro");

                
                $i=1;
                $result = mysqli_num_rows($query);
                if ($result > 0) {
                    while ($data = mysqli_fetch_assoc($query)) {
                        
                ?>
                     <tr>
                     <?php $data['idrubro'];?>
                     <td><?php echo $i; ?></td>
                         <td><?php echo $data['nombre_rubro']; ?></td>
                         <td><?php echo $data['detalle']; ?></td>
                        
                         <td>
                         <a href="eliminar_rubro.php?id=<?php echo $data['idrubro']; ?>" class="btn btn-danger"><i class='fas fa-trash-alt'></i></a>
                         <a href="editar_rubro.php?id=<?php echo $data['idrubro']; ?>" class="btn btn-primary"><i class='fas fa-edit'></i></a>
                        </td>
                     </tr>
             <?php $i++; }
                } ?>
         </tbody>

     </table>
     </div>
 
      </form>

      </div>
      <div class="modal-footer">
        
      </div>
    </div>
  </div>
</div>



<!--Modal Imprimir lista-->
<div class="modal" tabindex="-1" id="imprimir">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Imprimir lista de Precios</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        
      </div>
      <div class="modal-body">
      <div class="form-group">
                         <label for="telefono">Seleccionar Rubro</label>
                         <select name="idrubro" class="form-control" id="idrubro1"style="width:40%;" onchange="listaMarcas();">
                         <option value="vacio">Seleccionar Rubro</option>
                    
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
													
                                                    <option value="<?php echo $rubro; ?>"><?php echo $rubro; ?></option>  

                                                    <?php
                                                     }
                                                    
                                                     ?>
								</select>
                     </div>
                     <div id="mostrar_marcas"></div> 
                     <!--<div class="form-group">
                         <label for="telefono">Seleccionar Marca</label>
                         <select name="idmarca" class="form-control" id="idmarca1"style="width:20%;">
                         <option value="vacio">Seleccionar marca</option>
                    
                    <?php

                                          
                                                        //traer marcas
                                                        include "../conexion.php";
                                                    $query = mysqli_query($conexion, "SELECT * FROM marcas");
                                                    $result = mysqli_num_rows($query);
                                                    
                                                    while($row = mysqli_fetch_assoc($query))
                                                    {
	                                                //$idrol = $row['idrol'];
                                                    $marca = $row['nombre_marca'];
                                                    $idmarca = $row['idmarca'];

													?>
													
                                                    <option value="<?php //echo $marca; ?>"><?php //echo $marca; ?></option>  

                                                    <?php
                                                     }
                                                    
                                                     ?>
								</select>
                     </div>-->
                     <br>
                     <div id="mostrar_mensaje"></div>
                    
                     <button type="button" class="btn btn-success" onclick="imprimirLista();"><i class='fa fa-print' aria-hidden='true'></i>Generar PDF</button>
                     <button type="button" class="btn btn-primary" onclick="agregarLista();"><i class='' aria-hidden='true'></i>Agregar a Lista</button>
                     <div id="mostrar_tabla"></div> 


      </div>
        

      </div>
      <div class="modal-footer">
        
      </div>
    </div>
  </div>
</div>

<body id="page-top">
	<?php
	/*include "../conexion.php";
	$query_data = mysqli_query($conexion, "CALL data();");
	$result_data = mysqli_num_rows($query_data);
	if ($result_data > 0) {
		$data = mysqli_fetch_assoc($query_data);
	}*/

	?>
	<!-- Page Wrapper -->
	<div id="wrapper">

		<?php include_once "includes/menu.php"; ?>
		<!-- Content Wrapper -->
		<div id="content-wrapper" class="d-flex flex-column">

			<!-- Main Content -->
			<div id="content">
				<!-- Topbar -->
				<nav class="navbar navbar-expand navbar-light bg-primary text-white topbar mb-4 static-top shadow">

					<!-- Sidebar Toggle (Topbar) -->
					<button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
						<i class="fa fa-bars"></i>
					</button>
					<div class="input-group">
						<h6>Sistema de Venta</h6>
						<p class="ml-auto"><strong>Argentina, </strong><?php echo fechaArgentina(); ?></p>
					</div>

					<!-- Topbar Navbar -->
					<ul class="navbar-nav ml-auto">

						<div class="topbar-divider d-none d-sm-block"></div>

						<!-- Nav Item - User Information -->
						<li class="nav-item dropdown no-arrow">
							<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<span class="mr-2 d-none d-lg-inline small text-white" ><?php echo $_SESSION['user']; ?></span>
							</a>
							<!-- Dropdown - User Information -->
							<div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
								<a class="dropdown-item" href="#" data-toggle="modal" data-target="#nuevo_pass">
									<i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
									<?php echo $_SESSION['email']; ?>
								</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="salir.php">
									<i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
									Salir
								</a>
							</div>
						</li>

					</ul>

				</nav>

				<div id="nuevo_pass" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Cambiar contraseña</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="frmPass">
                    <div class="form-group">
                        <label for="actual"><i class="fas fa-key"></i> Contraseña Actual</label>
                        <input id="actual" class="form-control" type="text" name="actual" placeholder="Contraseña actual" required>
                    </div>
                    <div class="form-group">
                        <label for="nueva"><i class="fas fa-key"></i> Contraseña Nueva</label>
                        <input id="nueva" class="form-control" type="text" name="nueva" placeholder="Contraseña nueva" required>
                    </div>
                    <button class="btn btn-primary" type="button" onclick="btnCambiar(event)">Cambiar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="http://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
<!--<script type="text/javascript" src="js/funciones.js"></script>-->
<script type="text/javascript" src="js/autocompletado.js"></script>     
<script type="text/javascript" src="js/producto1.js"></script>
<script>
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

