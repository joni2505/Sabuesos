<?php
include_once "includes/header.php";
include "../conexion.php";
$id_user = $_SESSION['idUser'];
$permiso = "proveedores";
$sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
$existe = mysqli_fetch_all($sql);
if (empty($existe) && $id_user != 1) {
  header("Location: permisos.php");
}
if (!empty($_POST)) {
  $alert = "";
  if (empty($_POST['nombre_proveedor'])) {
    $alert = '<div class="alert alert-primary" role="alert">
              Todo los campos son requeridos
            </div>';
  } else {
    $idproveedor = $_GET['id'];
    $nombre_proveedor = $_POST['nombre_proveedor'];
    $direccion = $_POST['direccion'];
    $celular = $_POST['celular'];
    $correo = $_POST['correo'];
    
    $query_update = mysqli_query($conexion, "UPDATE proveedores SET nombre_proveedor = '$nombre_proveedor', direccion='$direccion', celular = '$celular'  WHERE idproveedor = '$idproveedor'");
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

// Validar 

if (empty($_REQUEST['id'])) {
    header("Location: proveedores.php");
  } else {
    $id_proveedor = $_REQUEST['id'];
    if (!is_numeric($id_proveedor)) {
      header("Location: proveedores.php");
    }
    $query = mysqli_query($conexion, "SELECT * FROM proveedores WHERE idproveedor = $id_proveedor");
    $result = mysqli_num_rows($query);
  
    if ($result > 0) {
      $data_proveedor = mysqli_fetch_assoc($query);
    } else {
      header("Location: proveedores.php");
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
            <input type="text" placeholder="Ingrese nombre" name="nombre_proveedor" id="nombre_proveedor" class="form-control" value="<?php echo $data_proveedor['nombre_proveedor']; ?>">
          </div>

          <div class="form-group">
            <label for="descripcion">Descripcion</label>
            <input type="text" class="form-control" placeholder="Ingrese direccion" name="direccion" id="direccion" value="<?php echo $data_proveedor['direccion']; ?>">

          </div>
          <div class="form-group">
            <label for="telefono">Celular</label>
            <input type="number" class="form-control" placeholder="Ingrese Celular" name="celular" id="celular" value="<?php echo $data_proveedor['celular']; ?>">
        </div>
        <div class="form-group">
            <label for="correo">Correo</label>
            <input type="email" class="form-control" placeholder="Ingrese Correo Electrónico" name="correo" id="correo" value="<?php echo $data_proveedor['correo']; ?>">
        </div>
          <input type="submit" value="Actualizar Proveedor" class="btn btn-primary">
          <a href="lista_proveedor.php" class="btn btn-danger">Atras</a>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include_once "includes/footer.php"; ?>
<?php include_once "includes/footer.php"; ?>