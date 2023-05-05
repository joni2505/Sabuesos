<?php
include_once "includes/header.php";
include "../conexion.php";
$id_user = $_SESSION['idUser'];
$permiso = "producto";
$sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
$existe = mysqli_fetch_all($sql);
if (empty($existe) && $id_user != 1) {
  header("Location: permisos.php");
}
if (!empty($_POST)) {
  $alert = "";
  if (empty($_POST['rubro'])) {
    $alert = '<div class="alert alert-primary" role="alert">
              Todo los campos son requeridos
            </div>';
  } else {
    $idrubro = $_GET['id'];
    $rubro = $_POST['rubro'];
    $detalle = $_POST['detalle'];

    $query_update = mysqli_query($conexion, "UPDATE rubro SET nombre_rubro = '$rubro', detalle='$detalle' WHERE idrubro = '$idrubro'");
    if ($query_update) {
      $alert = '<div class="alert alert-primary" role="alert">
              Se modifico el rubro
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
  header("Location: lista_productos.php");
} else {
  $idrubro = $_REQUEST['id'];
  if (!is_numeric($idmarca)) {
    header("Location: lista_productos.php");
  }
  $query = mysqli_query($conexion, "SELECT * FROM rubro WHERE idrubro = $idrubro");
  $result = mysqli_num_rows($query);
  if ($result > 0) {
    $data = mysqli_fetch_assoc($query);
  } else {
    header("Location: lista_productos.php");
  }
}
?>
<div class="row">
  <div class="col-lg-6 m-auto">

    <div class="card">
      <div class="card-header bg-primary text-white">
        Modificar Rubro
      </div>
      <div class="card-body">
        <form action="" method="post">
          <?php echo isset($alert) ? $alert : ''; ?>
          <div class="form-group">
            <label for="marca">Nombre Rubro</label>
            <input type="text" placeholder="Ingrese nombre" name="rubro" id="rubro" class="form-control" value="<?php echo $data['nombre_rubro']; ?>">
          </div>

          <div class="form-group">
            <label for="detalle">Detalle</label>
            <input type="text" class="form-control" placeholder="Ingrese detalle" name="detalle" id="detalle" value="<?php echo $data['detalle']; ?>">

          </div>
         
          <input type="submit" value="Actualizar Rubro" class="btn btn-primary">
          <a href="lista_productos.php" class="btn btn-danger">Atras</a>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include_once "includes/footer.php"; ?>