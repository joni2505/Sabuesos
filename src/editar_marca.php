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
  if (empty($_POST['marca'])) {
    $alert = '<div class="alert alert-primary" role="alert">
              Todo los campos son requeridos
            </div>';
  } else {
    $idmarca = $_GET['id'];
    $marca = $_POST['marca'];
    $detalle = $_POST['detalle'];
    $idrubro = $_POST['idrubro'];
    
    $query_update = mysqli_query($conexion, "UPDATE marcas SET nombre_marca = '$marca', detalle='$detalle', idrubro = '$idrubro'  WHERE idmarca = '$idmarca'");
    if ($query_update) {
      $alert = '<div class="alert alert-primary" role="alert">
              Se modifico la Marca
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
  $idmarca = $_REQUEST['id'];
  if (!is_numeric($idmarca)) {
    header("Location: lista_productos.php");
  }
  $query = mysqli_query($conexion, "SELECT * FROM marcas WHERE idmarca = $idmarca");
  $result = mysqli_num_rows($query);

  //traer rubro de marca
  $rs = mysqli_query($conexion, "SELECT rubro.nombre_rubro FROM marcas INNER JOIN rubro on marcas.idrubro=rubro.idrubro WHERE marcas.idmarca='$idmarca' ");
        while($row = mysqli_fetch_array($rs))
        {
          $nombreRubro=$row['nombre_rubro'];
  
        }

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
        Modificar Marca
      </div>
      <div class="card-body">
        <form action="" method="post">
          <?php echo isset($alert) ? $alert : ''; ?>
          <div class="form-group">
            <label for="marca">Nombre Marca</label>
            <input type="text" placeholder="Ingrese nombre" name="marca" id="marca" class="form-control" value="<?php echo $data['nombre_marca']; ?>">
          </div>

          <div class="form-group">
            <label for="detalle">Detalle</label>
            <input type="text" class="form-control" placeholder="Ingrese detalle" name="detalle" id="detalle" value="<?php echo $data['detalle']; ?>">

          </div>
          <div class="form-group">
                         <label for="rubro">Rubro</label>
                         <select name="idrubro" class="form-control" id="idrubro"style="width:60%;">
                    <option value="<?php echo $data['idrubro']; ?>"><?php echo $nombreRubro; ?></option>
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
          <input type="submit" value="Actualizar Marca" class="btn btn-primary">
          <a href="lista_productos.php" class="btn btn-danger">Atras</a>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include_once "includes/footer.php"; ?>