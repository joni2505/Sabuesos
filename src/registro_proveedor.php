<?php
include_once "includes/header.php";
include "../conexion.php";
$id_user = $_SESSION['idUser'];
$permiso = "proveedor";
$sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
$existe = mysqli_fetch_all($sql);
if (empty($existe) && $id_user != 1) {
    echo "<script> window.location.replace('permisos.php') </script>";
}
if (!empty($_POST)) {
$nombre_proveedor = $_POST['nombre_proveedor'];
        $direccion = $_POST['direccion'];
        $celular = $_POST['celular'];
        $correo = $_POST['correo'];
        //$idsede = $_POST['sedes'];

        $alert = "";
        if (empty($nombre_proveedor)) {
            $alert = '<div class="alert alert-warning" role="alert">
                        Todos los campos son Obligatorios
                    </div>';
        } else {
            $query = mysqli_query($conexion, "SELECT * FROM proveedores WHERE nombre_proveedor = '$nombre_proveedor'");
            $result = mysqli_fetch_array($query);
            if ($result > 0) {
                $alert = '<div class="alert alert-warning" role="alert">
                        El proveedor ya existe
                    </div>';
            } else {
				$query_insert = mysqli_query($conexion,"INSERT INTO proveedores(nombre_proveedor,direccion, celular, correo) values ('$nombre_proveedor', '$direccion','$celular','$correo')");
                if ($query_insert) {
                    $alert = '<div class="alert alert-warning" role="alert">
                        Se guardo Correctamente
                    </div>';
                } else {
                    $alert = '<div class="alert alert-warning" role="alert">
                        Error al Guardar
                    </div>';
                }
            }
        }
    }

?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Content Row -->
    <div class="row">
        <div class="col-lg-6 m-auto">
            <div class="card-header bg-primary text-white">
                Registro de Proveedor
            </div>
            <div class="card">
                <form action="" autocomplete="off" method="post" class="card-body p-2">
                    <?php echo isset($alert) ? $alert : ''; ?>
                    <div class="form-group">
                        <label for="nombre">NOMBRE</label>
                        <input type="text" placeholder="Ingrese Nombre" name="nombre_proveedor" id="nombre_proveedor" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="contacto">CORREO</label>
                        <input type="email" class="form-control" placeholder="Ingrese Correo Electrónico" name="correo" id="correo">
                    </div>
                    <div class="form-group">
                        <label for="telefono">TELÉFONO</label>
                        <input type="number" placeholder="Ingrese Teléfono" name="celular" id="celular" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="direccion">DIRECIÓN</label>
                        <input type="text" placeholder="Ingrese Direccion" name="direccion" id="direccion" class="form-control">
                    </div>
                    <input type="submit" value="Guardar Proveedor" class="btn btn-primary">
                    <a href="lista_proveedor.php" class="btn btn-danger">Regresar</a>
                </form>
            </div>
        </div>
    </div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php include_once "includes/footer.php"; ?>