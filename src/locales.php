<?php include_once "includes/header.php";
include "../conexion.php";
$id_user = $_SESSION['idUser'];
$permiso = "locales";
$sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
$existe = mysqli_fetch_all($sql);
if (empty($existe) && $id_user != 1 ) {
    echo "<script> window.location.replace('permisos.php') </script>";
}

if (!empty($_POST)) {
    $nombre_local = $_POST['nombre_local'];
    $direccion_local = $_POST['direccion_local'];
    $celular_local = $_POST['celular_local'];
    $alert = "";
    if (empty($nombre_local) || empty($direccion_local) || empty($celular_local)) {
        $alert = '<div class="alert alert-danger" role="alert">
            Todo los campos son obligatorios
          </div>';
    } else {
        $query = mysqli_query($conexion, "SELECT * FROM locales WHERE nombre_local = '$nombre_local'");
        $result = mysqli_fetch_array($query);
        if ($result > 0) {
            $alert = '<div class="alert alert-warning" role="alert">
                    El local ya existe
                </div>';
        } else {
            $query_insert = mysqli_query($conexion,"INSERT INTO locales(nombre_local, direccion_local, celular_local) values ('$nombre_local', '$direccion_local', '$celular_local')");
            if ($query_insert) {
                $alert = '<div class="alert alert-success" role="alert">
            Local Registrado
          </div>';
            } else {
                $alert = '<div class="alert alert-danger" role="alert">
            Error al registrar el Local
          </div>';
            }
        }
    }
}

?>
<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Lista de Locales</h1>
        <button class="btn btn-primary mb-2" type="button" data-toggle="modal" data-target="#nuevo_local"><i class="fas fa-plus"></i></button>

	</div>

	<div class="row">
		<div class="col-lg-12">
<?php echo isset($alert) ? $alert : ''; ?>
<div class="table-responsive">
    <table class="table table-striped table-bordered" id="tbl">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Local</th>
                <th>Direccion</th>
                <th>Celular</th>
                <th>Estado</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            include "../conexion.php";

            $query = mysqli_query($conexion, "SELECT * FROM locales");
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
                        <td><?php echo $data['idlocal']; ?></td>
                        <td><?php echo $data['nombre_local']; ?></td>
                        <td><?php echo $data['direccion_local']; ?></td>
                        <td><?php echo $data['celular_local']; ?></td>
                        <td><?php echo $estado; ?></td>
                        <td>
                            <?php if ($data['estado'] == 0) { ?>
                                <a href="editar_local.php?id=<?php echo $data['idlocal']; ?>" class="btn btn-success"><i class='fas fa-edit'></i></a>
                                <form action="eliminar_local.php?id=<?php echo $data['idlocal']; ?>" method="post" class="confirmar d-inline">
                                    <button class="btn btn-danger" type="submit"><i class='fas fa-trash-alt'></i> </button>
                                </form>
                            <?php } else{
                                       
                                       echo "<a href='alta_local.php?id=".$data['idlocal']."'class='btn btn-warning'><i class='fa fa-user-plus' aria-hidden='true'></i></a>";
      
   
                                } ?>
                        </td>
                    </tr>
            <?php }
            } ?>
        </tbody>

    </table>
</div>
<div id="nuevo_local" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="my-modal-title">Nuevo Local</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" autocomplete="off">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" placeholder="Ingrese Nombre" name="nombre_local" id="nombre_local" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="direccion">Dirección</label>
                        <input type="text" placeholder="Ingrese Direccion" name="direccion_local" id="direccion_local" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="telefono">Celular</label>
                        <input type="number" placeholder="Ingrese Teléfono" name="celular_local" id="celular_local" class="form-control">
                    </div>
                    
                    <input type="submit" value="Guardar Local" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
</div>
<?php include_once "includes/footer.php"; ?>