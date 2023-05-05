<?php
include_once "includes/header.php";
include "../conexion.php";
$id_user = $_SESSION['idUser'];
$permiso = "locales";
$sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
$existe = mysqli_fetch_all($sql);
if (empty($existe) && $id_user != 1) {
  header("Location: permisos.php");
}
if (!empty($_POST)) {
  $alert = "";
  if (empty($_POST['nombre_local']) || empty($_POST['celular_local']) || empty($_POST['direccion_local'])) {
    $alert = '<div class="alert alert-primary" role="alert">
              Todo los campos son requeridos
            </div>';
  } else {
    $idlocal = $_GET['id'];
    $nombre_local = $_POST['nombre_local'];
    $direccion_local = $_POST['direccion_local'];
    $celular_local = $_POST['celular_local'];
    
    $query_update = mysqli_query($conexion, "UPDATE locales SET nombre_local = '$nombre_local', direccion_local='$direccion_local', celular_local = '$celular_local'  WHERE idlocal = '$idlocal'");
    if ($query_update) {
      $alert = '<div class="alert alert-primary" role="alert">
              Local Modificado
            </div>';
    } else {
      $alert = '<div class="alert alert-primary" role="alert">
                Error al Modificar
              </div>';
    }
  }
}

// Validar producto

if (empty($_REQUEST['id'])) {
  header("Location: locales.php");
} else {
  $id_local = $_REQUEST['id'];
  if (!is_numeric($id_local)) {
    header("Location: locales.php");
  }
  $query_local = mysqli_query($conexion, "SELECT * FROM locales WHERE idlocal = $id_local");
  $result_local = mysqli_num_rows($query_local);

  if ($result_local > 0) {
    $data_local= mysqli_fetch_assoc($query_local);
  } else {
    header("Location: locales.php");
  }
}
?>
<div class="row">
  <div class="col-lg-6 m-auto">

    <div class="card">
      <div class="card-header bg-primary text-white">
        Modificar Local
      </div>
      <div class="card-body">
        <form action="" method="post">
          <?php echo isset($alert) ? $alert : ''; ?>
          <div class="form-group">
            <label for="codigo">Nombre</label>
            <input type="text" placeholder="Ingrese nombre" name="nombre_local" id="nombre_local" class="form-control" value="<?php echo $data_local['nombre_local']; ?>">
          </div>

          <div class="form-group">
            <label for="descripcion">Descripcion</label>
            <input type="text" class="form-control" placeholder="Ingrese direccion" name="direccion_local" id="direccion_local" value="<?php echo $data_local['direccion_local']; ?>">

          </div>
          <div class="form-group">
            <label for="telefono">Celular</label>
            <input type="number" class="form-control" placeholder="Ingrese Celular" name="celular_local" id="celular_local" value="<?php echo $data_local['celular_local']; ?>">
        </div>
        <!--<div class="form-group">
            <label for="correo">Correo</label>
            <input type="email" class="form-control" placeholder="Ingrese Correo Electrónico" name="correo" id="correo" value="<?php echo $data_local['correo']; ?>">
        </div>-->
          <input type="submit" value="Actualizar Producto" class="btn btn-primary">
          <a href="locales.php" class="btn btn-danger">Atras</a>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include_once "includes/footer.php"; ?>