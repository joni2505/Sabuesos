<?php include_once "includes/header.php";
include "../conexion.php";
$id_user = $_SESSION['idUser'];
$permiso = "usuarios";
$sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
$existe = mysqli_fetch_all($sql);
if (empty($existe) && $id_user != 1) {
    echo "<script> window.location.replace('permisos.php') </script>";
}


if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['nombre']) || empty($_POST['correo']) || empty($_POST['usuario']) || empty($_POST['clave'])) {
        $alert = '<div class="alert alert-danger" role="alert">
        Todo los campos son obligatorios
        </div>';
    } else {
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $email = $_POST['correo'];
        $user = $_POST['usuario'];
        $clave = md5($_POST['clave']);
        $locales = $_POST['locales'];
        $query = mysqli_query($conexion, "SELECT * FROM usuario where correo = '$email'");
        $result = mysqli_fetch_array($query);
        if ($result > 0) {
            $alert = '<div class="alert alert-warning" role="alert">
                        El correo ya existe
                    </div>';
        } else {
            //traer id de sede
            $result2 = mysqli_query($conexion, "SELECT idlocal FROM locales WHERE nombre_local ='$locales'");
            $result = mysqli_num_rows($result2);
          
            while($row2 = mysqli_fetch_array($result2))
            {
                $idlocal=$row2['idlocal'];
            }
        
            $query_insert = mysqli_query($conexion, "INSERT INTO usuario(nombre,apellido,correo,usuario,clave,idlocal) values ('$nombre', '$email', '$user', '$clave', '$idlocal')");
            if ($query_insert) {
                $alert = '<div class="alert alert-primary" role="alert">
                            Usuario registrado
                        </div>';
                header("Location: usuarios.php");
                $alert = '<div class="alert alert-primary" role="alert">
                            Usuario registrado
                        </div>';
            } else {
                $alert = '<div class="alert alert-danger" role="alert">
                        Error al registrar
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
		<h1 class="h3 mb-0 text-gray-800">Lista Usuarios</h1>
		
		<a href="registro_usuario.php" class="btn btn-primary">Nuevo</a>
		
	</div>

	<div class="row">
		<div class="col-lg-12">
			<div class="table-responsive">
				<table class="table table-striped table-bordered" id="tbl">
					<thead class="thead-dark">
						<tr>
							<th>ID</th>
							<th>NOMBRE</th>
							<th>CORREO</th>
							<th>USUARIO</th>
							<th>LOCAL RAIZ</th>
                            <th>ROL</th>
							<th>ACCIONES</th>
							
						</tr>
					</thead>
					<tbody>
					<?php
            include "../conexion.php";

            $query = mysqli_query($conexion, "SELECT usuario.idusuario, usuario.nombre, apellido, correo, usuario, locales.nombre_local'local', rol.nombreRol, usuario.estado FROM usuario INNER JOIN locales on usuario.idlocal=locales.idlocal
            INNER JOIN rol on usuario.rol=rol.idrol ORDER BY estado DESC");
            $result = mysqli_num_rows($query);
            if ($result > 0) {
                while ($data = mysqli_fetch_assoc($query)) {
                    if ($data['estado'] == 1) {
                        $estado = '<span class="badge badge-pill badge-success">Activo</span>';
                    } else {
                        $estado = '<span class="badge badge-pill badge-danger">Inactivo</span>';
                    }
            ?>
                    <tr>

						<td><?php echo $data['idusuario'] ?> </td>
                        <td><?php echo $data['nombre']; ?></td>
                        <td><?php echo $data['correo']; ?></td>
                        <td><?php echo $data['usuario']; ?></td>
                        <td><?php echo $data['local']; ?></td>
                        <td><?php echo $data['nombreRol']; ?></td>
                        <td>
                            <?php if ($data['estado'] == 1) { ?>
                                <a href="rol.php?id=<?php echo $data['idusuario']; ?>" class="btn btn-warning"><i class='fas fa-key'></i></a>
                                <a href="editar_usuario.php?id=<?php echo $data['idusuario']; ?>" class="btn btn-success"><i class='fas fa-edit'></i></a>
                                <form action="eliminar_usuario.php?id=<?php echo $data['idusuario']; ?>" method="post" class="confirmar d-inline">
                                    <button class="btn btn-danger" type="submit"><i class='fas fa-trash-alt'></i> </button>
                                </form>
                            <?php }else{
                                   echo "<a href='alta_usuario.php?id=".$data['idusuario']."'class='btn btn-warning'><i class='fa fa-user-plus' aria-hidden='true'></i></a>";

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