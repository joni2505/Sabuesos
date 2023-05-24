<?php include_once "includes/header.php";
include "../conexion.php";
$id_user = $_SESSION['idUser'];
$permiso = "venta";
  $sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
  $existe = mysqli_fetch_all($sql);
  if (empty($existe) && $id_user != 1) {
    echo "<script> window.location.replace('permisos.php') </script>";
  }
 
date_default_timezone_set('America/Argentina/Buenos_Aires');
$feha_actual=date("d-m-Y");
 
$rs = mysqli_query($conexion, "SELECT * FROM ventas ");

        while($row = mysqli_fetch_array($rs))
            {
            
                $nf=$row['numero_factura'];
                
            } 
            $nf++;

            $rs = mysqli_query($conexion,"SELECT usuario.idlocal, locales.nombre_local FROM usuario INNER JOIN locales on usuario.idlocal=locales.idlocal WHERE usuario.idusuario ='$id_user'");
            while($row = mysqli_fetch_array($rs))
            {
              //$valores['existe'] = "1"; //Esta variable no la usamos en el vídeo (se me olvido, lo siento xD). Aqui la uso en la linea 97 de registro.php
              $local = $row['nombre_local'];
              $idlocal = $row['idlocal'];
            }
             
?>
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                 
                    <div class="box-header with-border" id="nuevo">
                          <h1 class="box-title">Lista de Ventas</h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-heder table-responsive"  id="listadoregistros">
                    
                    <input id="idusuario" value="<?php echo $id_user; ?>" style="visibility:hidden"> 
                    <input class="input-group-addon" id="idlocal" value="<?php echo $idlocal; ?>" style="visibility:hidden">
                    <div class="form-group">
                    <label>Usuario</label>
                    <input class="input-group-addon" value="<?php echo $_SESSION['nombre']; ?>" id="usuario" readonly="readonly">
                  
                        <label>Fecha de Busqueda</label>
                        <input  type="date" class="input-group-addon" id="fecha" onclick="" style="width:15%;">
                        
                    <label for="textInput"> <i class="fa fa-calendar-o" aria-hidden="true"></i>Mes:</label>
                    <select class="input-group-addon"  name="mes" class="input-group-addon" id="mes" >
                    <option value="">Seleccionar Mes</option>                                       
                                  <option value="Enero">Enero</option>
                                  <option value="Febrero">Febrero</option>
                                  <option value="Marzo">Marzo</option>
                                  <option value="Abril">Abril</option>
                                  <option value="Mayo">Mayo</option>
                                  <option value="Junio">Junio</option>
                                  <option value="Julio">Julio</option>
                                  <option value="Agosto">Agosto</option>
                                  <option value="Septiembre">Septiembre</option>
                                  <option value="Octubre">Octubre</option>
                                  <option value="Noviembre">Noviembre</option>
                                  <option value="Diciembre">Diciembre</option>
                              </select>
                      </div>

                    </div>
                    
                    <div class="panel-footer bg- " style="height: 100px;" id="">

                    
                      
                      <div class="form-group" style="width:20%;">
                          <label for="locales">Tiendas Locales</label>
                          <select name="locales" class="input-group-addon" id="locales" >
                                                    <?php
                                                        //traer sedes
                                                        include "../conexion.php";
                                                    $query = mysqli_query($conexion, "SELECT * FROM locales");
                                                    $result = mysqli_num_rows($query);
                                                    
                                                    while($row = mysqli_fetch_assoc($query))
                                                    {
                                                    $localid = $row['idlocal'];
                                                    $local = $row['nombre_local'];

													                          ?>
													
                          <option value="<?php echo $localid; ?>"><?php echo $local; ?></option>  

                                                    <?php
                                                     }
                                                    
                                                     ?>
								            </select>

              
                    </div>
                                                       
                    </div> 

<button type="button" class="btn btn-primary" onclick="listaVenta();">Buscar</button><br><br>
<div class="table-responsive">
<input class="form-control col-md-3 light-table-filter" data-table="order-table" type="text" placeholder="Buscar en Tabla" style="width:20%;">    
<div id="mostrar"></div>
</div>

     

</div><br>

                    </div>
                    
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->
<script type="text/javascript" src="js/categoria.js"></script>
<script type="text/javascript">

function listaVenta()
    { 
      
      fecha = codigo = $("#fecha").val();
      locales = codigo = $("#locales").val();
      mes = codigo = $("#mes").val();
      var parametros = 
      {
        "tabla" : "a",
        "fecha" : fecha,
        "locales" : locales,
        "mes" : mes,
        "accion" : "4"
        
        
      };

      $.ajax({
        data: parametros,
        url: 'datos_listaVentas.php',
        type: 'POST',
        
        beforesend: function()
        {
          $('#mostrar').html("Mensaje antes de Enviar");
        },

        success: function(mensaje)
        {
          $('#mostrar').html(mensaje);

        }
      });
    }

    (function(document) {
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
var text = row.textContent.toLowerCase(), val = _input.value.toLowerCase();
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

})(document);

</script> 
  <?php include_once "includes/footer.php"; ?>
  
  