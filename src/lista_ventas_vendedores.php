<?php include_once "includes/header.php";
include "../conexion.php";
$id_user = $_SESSION['idUser'];
$permiso = "venta";
  $sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
  $existe = mysqli_fetch_all($sql);
  if (empty($existe) && $id_user != 1) {
    echo "<script> window.location.replace('permisos.php') </script>";
  }

?>
<div class="container-fluid">
<h4 class="box-title">Lista de Ventas X Vendedores:</h4><br>

<div class="box-header with-border" id="nuevo">

    <div class="form-group">    
    <label>Usuario</label>
    <input class="input-group-addon" value="<?php echo $_SESSION['nombre']; ?>" id="usuario" readonly="readonly">
   
    <label>Fecha de Busqueda</label>
    <input  type="date" class="input-group-addon" id="fecha" style="width:15%;" onclick="setiarmes()">
    
    <label>Mes</label>
                    <select class="input-group-addon"  name="mes" style="width:15%;" class="input-group-addon" id="mes" onclick="setiarfecha()" >
                    <option value=0>Seleccionar Mes</option>                                       
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
                              </select><br>
    </div>

<label>Lista de Vendedores</label><br>
<select name="buscador" class="input-group-addon" id="vendedor" style="width:15%;" onchange="">
                                <option value="">Buscar Vendedor</option>
                                <?php
                                                        //traer sedes
                                                        include "../conexion.php";
                                                          
                                                    
                                                    $query = mysqli_query($conexion, "SELECT * FROM usuario where rol=2");
                                            
                                                    while($row = mysqli_fetch_assoc($query))
                                                    {
	                                                
                                                    $idvendedor = $row['idusuario'];
                                                    $nombre = $row['nombre'];
                                                    $apellido = $row['apellido'];
                                                    
                                                    
													      ?>
													
                                                    <option value="<?php echo $idvendedor; ?>"><?php echo $nombre; ?></option>  
                                                    
                                                    <?php
                                                     }
                                                    
                                                     ?>   
                            </select>

<button class="btn btn-primary" id="btnGuardar" onclick="tablaventas()">Buscar</button>
</div>

</div><br>

<div class="panel-footer bg- " style="height: 400px;" id="">
<div class="table-responsive">
<input class="form-control col-md-3 light-table-filter" data-table="order-table" type="text" placeholder="Buscar en Tabla" style="width:20%;">    
<div id="mostrar"></div>
</div>
</div>


<script type="text/javascript">

    //setiar fecha
    function setiarfecha(){

        $("#fecha").val("");
        /*$('#fecha').click(function(){
            var time = moment().format('YYYY-MM-DDTHH:mm:ss');
            $('#time-holder').val(time);  
        });*/
    }

    //setiar mes
    function setiarmes(){
        
        document.getElementById("mes").selectedIndex = 0;
        
    }

    //buscar datos
    function tablaventas()
    { 
      //locales = codigo = $("#locales").val();
      fecha = codigo = $("#fecha").val();
      mes = codigo = $("#mes").val();
      vendedor = $("#vendedor").val();  

      var parametros = 
      {
        "tabla_ventas" : 1,
        "fecha" : fecha,
        "mes" : mes,
        "vendedor" : vendedor,
        "accion" : "4"
        //"locales" : locales,
        
        
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
    
</script>    
<?php include_once "includes/footer.php"; ?>
