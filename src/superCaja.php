<?php include_once "includes/header.php";
include "../conexion.php";
$id_user = $_SESSION['idUser'];
$permiso = "venta";
$sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
$existe = mysqli_fetch_all($sql);
if (empty($existe) && $id_user != 1) {
  echo "<script> window.location.replace('permisos.php') </script>";
}

if (!empty($_POST)) {
  $alert = "";
  if (empty($_POST['nombreCaja']) || empty($_POST['fechaApertura'])) {
    $alert = '<div class="alert alert-danger" role="alert">
        Nombre de caja y Fecha son Obligatorio
        </div>';
  } else {
    $nombreCaja = $_POST['nombreCaja'];
    $fechaApertura = $_POST['fechaApertura'];
    $EfectivoApertura = $_POST['efectivoApertura'];
    //$fechaCierre = $_POST['fechaCierre'];
    $query = mysqli_query($conexion, "SELECT * FROM superCaja where nombreCaja = '$nombreCaja' and fechaApertura='$fechaApertura'");
    $result = mysqli_fetch_array($query);
    if ($result > 0) {
      $alert = '<div class="alert alert-warning" role="alert">
                        la caja ya existe
                    </div>';
    } else {
      //traer id de sede
      $query2 = mysqli_query($conexion, "SELECT idlocal FROM usuario WHERE idusuario ='$id_user'");
      $result2 = mysqli_num_rows($query2);

      while ($row2 = mysqli_fetch_array($query2)) {
        $idlocal = $row2['idlocal'];
      }

      $query_insert = mysqli_query($conexion, "INSERT INTO superCaja(nombreCaja, fechaApertura, efectivoApertura, idlocal) values ('$nombreCaja', '$fechaApertura', '$EfectivoApertura', '$idlocal')");
      if ($query_insert) {
        $alert = '<div class="alert alert-primary" role="alert">
                            Caja registrada
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

<div class="container-fluid">
  <h4 class="box-title">Apertura y Cierre de Caja</h4><br>

  <div class="box-header with-border" id="nuevo">
    <form action="" method="post" autocomplete="off">
      <?php echo isset($alert) ? $alert : ''; ?>
      <div class="input-group">
        <span class="input-group-text">Apertura de Caja</span>
        <input type="text" placeholder="Nombre de la caja" class="form-control" name="nombreCaja">
        <input type="date" class="form-control" name="fechaApertura">
        <input type="numer" placeholder="Efectivo de Apertura" class="form-control" name="efectivoApertura">
        <input type="submit" value="Guardar" class="btn btn-primary">
      </div>
    </form> <br>

    <div class="input-group">
      <span class="input-group-text">Cierre de Caja</span>

      <select name="caja" id="caja" style="width:15%;">
        <?php
        //traer sedes
        include "../conexion.php";
        $query = mysqli_query($conexion, "SELECT * FROM superCaja where estado=0 ");

        while ($row = mysqli_fetch_assoc($query)) {

          $nom_caja = $row['nombreCaja'];
          $idcaja = $row['idsuperCaja'];
        ?>

          <option value="<?php echo $idcaja; ?>"><?php echo $nom_caja; ?></option>

        <?php
        }

        ?>
      </select>

      <input type="date" style="width:15%" name="fechaCierre" id="fechaCierre">
      <input type="submit" value="Cerrar" class="btn btn-info" onclick="cerrar()">
    </div>
  </div><br>

</div>

<div class="table-responsive">
  <table class="table table-striped table-bordered" id="tbl">
    <thead class="thead-dark">
      <tr>
        <th>#</th>
        <th>Nombre</th>
        <th>Fecha Apertura</th>
        <th>Efectivo Apertura</th>
        <th>Fecha Cierre</th>
        <th>Efectivo Cierre</th>
        <th>Estado</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php
      include "../conexion.php";

      $query = mysqli_query($conexion, "SELECT idsuperCaja, nombreCaja, fechaApertura, efectivoApertura, fechaCierre, efectivoCierre, estado FROM superCaja ");
      $result = mysqli_num_rows($query);
      if ($result > 0) {
        while ($data = mysqli_fetch_assoc($query)) {
          if ($data['estado'] == 0) {
            $estado = '<span class="badge badge-pill badge-success">Abierto</span>';
          } else {
            $estado = '<span class="badge badge-pill badge-danger">Cerrado</span>';
          }
      ?>
          <tr>

            <td><?php echo $data['idsuperCaja'] ?> </td>
            <td><?php echo $data['nombreCaja']; ?></td>
            <td><?php echo $data['fechaApertura']; ?></td>
            <td><?php echo $data['efectivoApertura']; ?></td>
            <td><?php echo $data['fechaCierre']; ?></td>
            <td><?php echo $data['efectivoCierre']; ?></td>
            <td><?php echo $estado; ?></td>
          <?php
          if ($data['estado'] == 0) {
            $id = $data['idsuperCaja'];
            echo '<td>
                            
                                <a href="editarCaja.php?id=' . $data['idsuperCaja'] . '" class="btn btn-success"><i class="fas fa-edit"></i></a>
                                <form action="eliminarCaja.php?id=' . $data['idsuperCaja'] . '" method="post" class="confirmar d-inline">
                                    <button class="btn btn-danger" type="submit"><i class="fas fa-trash-alt"></i> </button>
                                </form>
                                <a href="pdf/reporteCaja.php?id=' . $data['idsuperCaja'] . '" class="btn btn-info"><i class="fas fa-print"></i></a>
                        </td>';
          } else {
            $id = $data['idsuperCaja'];
            echo '<td>
                      
                  <a href="pdf/reporteCaja.php?idcaja='.$data['idsuperCaja'].'" class="btn btn-info"><i class="fas fa-print"></i></a>
                  
                  </td>';
          }
        } ?>

          </tr>
        <?php
      }
        ?>

    </tbody>

  </table>
</div>
<div id="mostrar"></div>
<!-- End of Main Content -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script>
  function cerrar() {
    idcaja = $("#caja").val();
    fechaCierre = $("#fechaCierre").val();
    var parametros = {
      "cerrarCaja": 1,
      "idcaja": idcaja,
      "fechaCierre": fechaCierre

    };

    $.ajax({
      data: parametros,
      url: 'datosCaja.php',
      type: 'POST',

      beforesend: function() {
        $('#mostrar').html("Mensaje antes de Enviar");

      },

      error: function() {
        alert("Error evento");
      },

      success: function(mensaje) {
        $('#mostrar').html(mensaje);
        window.location.reload();
      }
    });
  }

  //buscardor tbl
 /* (function(document) {
    'use strict';

    var LightTableFilter = (function(Arr) {

      var _input;

      function _onInputEvent(e) {
        _input = e.target;
        var tables = document.getElementsByClassName(_input.getAttribute('data-table'));
        Arr.forEach.call(tables, function(table) {
          Arr.forEach.call(table.tBodies, function(tbody) {
            Arr.forEach.call(tbody.rows, _filter);
          });
        });
      }

      function _filter(row) {
        var text = row.textContent.toLowerCase(),
          val = _input.value.toLowerCase();
        row.style.display = text.indexOf(val) === -1 ? 'none' : 'table-row';
      }

      return {
        init: function() {
          var inputs = document.getElementsByClassName('light-table-filter');
          Arr.forEach.call(inputs, function(input) {
            input.oninput = _onInputEvent;
          });
        }
      };
    })(Array.prototype);

    document.addEventListener('readystatechange', function() {
      if (document.readyState === 'complete') {
        LightTableFilter.init();
      }
    });

  })(document);*/
</script>
<?php include_once "includes/footer.php"; ?>