<?php include_once "includes/header.php";
include "../conexion.php";
$id_user = $_SESSION['idUser'];
$permiso = "caja";
  $sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
  $existe = mysqli_fetch_all($sql);
  if (empty($existe) && $id_user != 1) {
    echo "<script> window.location.replace('permisos.php') </script>";
  }

  if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['nombreCaja']) || empty($_POST['fechaApertura'])) {
        $alert = '<div class="alert alert-danger" role="alert">Todo los campos son requeridos</div>';
    } else {
        $idcaja = $_GET['id'];
        $nombreCaja = $_POST['nombreCaja'];
        //$apellido = $_POST['apellido'];
        $fechaApertura = $_POST['fechaApertura'];
        $efectivoApertura = $_POST['efectivoApertura'];
            $sql_update = mysqli_query($conexion, "UPDATE superCaja SET nombreCaja = '$nombreCaja', efectivoApertura = '$efectivoApertura', fechaApertura = '$fechaApertura' WHERE idsuperCaja = '$idcaja'");

            if ($sql_update) {
                $alert = '<div class="alert alert-success" role="alert">Caja Actualizada correctamente</div>';
            } else {
                $alert = '<div class="alert alert-danger" role="alert">Error al Actualizar la Caja</div>';
            }
    }
}
// Mostrar Datos

if (empty($_REQUEST['id'])) {
    header("Location: caja.php");
}
$idcaja = $_REQUEST['id'];
$sql = mysqli_query($conexion, "SELECT * FROM supercaja WHERE idsuperCaja = $idcaja");
$result_sql = mysqli_num_rows($sql);
if ($result_sql == 0) {
    header("Location: caja.php");
} else {
    if ($data = mysqli_fetch_array($sql)) {
        $idcaja = $data['idsuperCaja'];
        $nombreCaja = $data['nombreCaja'];
        $efectivoApertura = $data['efectivoApertura'];
        $fechaApertura = $data['fechaApertura'];
    }
}

?>

<div class="container-fluid">
<h4 class="box-title">Apertura y Cierre de Caja</h4><br>

<div class="box-header with-border" id="nuevo">
<form action="" method="post" autocomplete="off">
<?php echo isset($alert) ? $alert : ''; ?>
<div class="input-group">
  <span class="input-group-text">Apertura de Caja</span>
  <input type="text" placeholder="Nombre de la caja"  class="form-control" name="nombreCaja" value="<?php echo $nombreCaja ?>">
  <input type="date" class="form-control" name="fechaApertura">
  <input type="numer" placeholder="Efectivo de Apertura" class="form-control" name="efectivoApertura" value="<?php echo $efectivoApertura ?>">
  <input type="submit" value="Editar" class="btn btn-primary">
  <a href="caja.php" class="btn btn-info">Regresar</a>
</div> 
</form> <br>


</div>
<?php include_once "includes/footer.php"; ?>