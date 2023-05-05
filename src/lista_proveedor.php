<?php include_once "includes/header.php"; 
include "../conexion.php";
$id_user = $_SESSION['idUser'];
$permiso = "proveedor";
  $sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
  $existe = mysqli_fetch_all($sql);
  if (empty($existe) && $id_user != 1) {
    echo "<script> window.location.replace('permisos.php') </script>";
  }

?>

<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Proveedores</h1>
		<a href="registro_proveedor.php" class="btn btn-primary">Nuevo</a>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<div class="table-responsive">
				<table class="table table-striped table-bordered" id="tbl">
					<thead class="thead-dark">
						<tr>
							<th>ID</th>
							<th>PROVEEDOR</th>
							<th>DIRECCION</th>
							<th>TELEFONO</th>
							<th>CORREO</th>
							<th>ESTADO</th>
							<?php if ($_SESSION['idUser'] == 1) { ?>
							<th>ACCIONES</th>
							<?php } ?>
						</tr>
					</thead>
					<tbody>
					<?php
            include "../conexion.php";

            $query = mysqli_query($conexion, "SELECT * FROM proveedores");
            $result = mysqli_num_rows($query);
            if ($result > 0) {
                while ($data = mysqli_fetch_assoc($query)) {
                    if ($data['estado'] == 0) {
                        $estado = '<span class="badge badge-pill badge-success">Activo</span>';
                    } else {
                        $estado = '<span class="badge badge-pill badge-danger">Inactivo</span>';
                    }
            ?>
                    <tr>
                        <td><?php echo $data['idproveedor']; ?></td>
                        <td><?php echo $data['nombre_proveedor']; ?></td>
                        <td><?php echo $data['direccion']; ?></td>
                        <td><?php echo $data['celular']; ?></td>
                        <td><?php echo $data['correo']; ?></td>
                        <td><?php echo $estado; ?></td>
                        <td>
                            <?php if ($data['estado'] == 0) { ?>
                                <a href="editar_proveedor.php?id=<?php echo $data['idproveedor']; ?>" class="btn btn-success"><i class='fas fa-edit'></i></a>
                                <form action="eliminar_proveedor.php?id=<?php echo $data['idproveedor']; ?>" method="post" class="confirmar d-inline">
                                    <button class="btn btn-danger" type="submit"><i class='fas fa-trash-alt'></i> </button>
                                </form>
                            <?php } else{
                                       
                                       echo "<a href='alta_proveedor.php?id=".$data['idproveedor']."'class='btn btn-warning'><i class='fa fa-user-plus' aria-hidden='true'></i></a>";
      
   
                                } ?>
                        </td>
                    </tr>
            <?php }
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

<script type="text/javascript" src="js/funciones.js"></script> 
<?php include_once "includes/footer.php"; ?>