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
        //$apellido = $_POST['apellido'];
        $email = $_POST['correo'];
        $user = $_POST['usuario'];
        $clave = md5($_POST['clave']);
        $locales = $_POST['locales'];
        $rol = $_POST['rol'];
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
        
            $query_insert = mysqli_query($conexion, "INSERT INTO usuario(nombre,correo,usuario,clave,idlocal,rol) values ('$nombre', '$email', '$user', '$clave', '$idlocal', '$rol')");
            if ($query_insert) {
                $alert = '<div class="alert alert-primary" role="alert">
                            Usuario registrado
                        </div>';
                
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
        <h1 class="h3 mb-0 text-gray-800">Panel de Administración</h1>
        <a href="lista_usuarios.php" class="btn btn-primary">Regresar</a>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-lg-6 m-auto">
            <form action="" method="post" autocomplete="off">
                <?php echo isset($alert) ? $alert : ''; ?>
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" placeholder="Ingrese Nombre" name="nombre" id="nombre">
                </div>
                <div class="form-group">
                    <label for="correo">Correo</label>
                    <input type="email" class="form-control" placeholder="Ingrese Correo Electrónico" name="correo" id="correo">
                </div>
                <div class="form-group">
                    <label for="usuario">Usuario</label>
                    <input type="text" class="form-control" placeholder="Ingrese Usuario" name="usuario" id="usuario">
                </div>
                <div class="form-group">
                    <label for="clave">Contraseña</label>
                    <input type="password" class="form-control" placeholder="Ingrese Contraseña" name="clave" id="clave">
                </div>
                <div class="form-group">
                    <label for="locales">Locales</label>
                    <select name="locales" class="form-control">
                    <?php
                                                        //traer locales
                                                        include "../conexion.php";
                                                    $query = mysqli_query($conexion, "SELECT nombre_local FROM locales");
                                                    $result = mysqli_num_rows($query);
                                                    
                                                    while($row = mysqli_fetch_assoc($query))
                                                    {
	                                                
                                                    $local = $row['nombre_local'];

													?>
													
                                                    <option value="<?php echo $local; ?>"><?php echo $local; ?></option>  

                                                    <?php
                                                     }
                                                    
                                                     ?>
								</select>
                    </div>
                    <div class="form-group">
                    <label for="locales">Rol</label>
                    <select class="form-control" name="rol" id="rol">

                    <option value="1">Administrador</option>
                    <option value="2">Vendedor</option>
                    <option value="3">Preventista</option>

                    </select>
                    </div>
                <input type="submit" value="Guardar Usuario" class="btn btn-primary">
            </form>
        </div>
    </div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php include_once "includes/footer.php"; ?>