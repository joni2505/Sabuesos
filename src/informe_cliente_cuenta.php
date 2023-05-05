<?php include_once "includes/header.php";
require("../conexion.php");
$id_user = $_SESSION['idUser'];
$permiso = "informes";
  $sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
  $existe = mysqli_fetch_all($sql);
  if (empty($existe) && $id_user != 1) {
    echo "<script> window.location.replace('permisos.php') </script>";
  }
date_default_timezone_set('America/Argentina/Buenos_Aires');
$fecha=date("Y-m-d H:i:s");
$fechaComoEntero = strtotime($fecha);
$año = date("Y", $fechaComoEntero);
$mes = date("M", $fechaComoEntero);
$rs = mysqli_query($conexion,"SELECT usuario.idlocal, locales.nombre_local FROM usuario INNER JOIN locales on usuario.idlocal=locales.idlocal WHERE usuario.idusuario ='$id_user'");
while($row = mysqli_fetch_array($rs))
{
  //$valores['existe'] = "1"; //Esta variable no la usamos en el vídeo (se me olvido, lo siento xD). Aqui la uso en la linea 97 de registro.php
  $local = $row['nombre_local'];
  $idlocal = $row['idlocal'];
}

?>

<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h2 class="h3 mb-0 text-gray-800"> INFORME DEL CLIENTE CUENTA
    <input type="button" value="ver informe" onclick="imforme_cliente();" class="btn btn-primary">
    <input style="font-size: 16px; width:10%; text-transform: uppercase; color: black;" value="<?php echo $año?>" id="anio">
    </h2>
	</div>
	<div class="row">
     
		<div class="col-lg-12">
    <div class="form-group">
                    <label for="locales">Locales</label>
                    <select name="locales" class="form-control" id="idlocal" style="width:16%;">
                    <?php
                                                        //traer locales
                                                        include "../conexion.php";
                                                    $query = mysqli_query($conexion, "SELECT * FROM locales");
                                                    $result = mysqli_num_rows($query);
                                                    
                                                    while($row = mysqli_fetch_assoc($query))
                                                    {
	                                                
                                                    $local = $row['nombre_local'];
                                                    $idlocal = $row['idlocal'];    
													?>
													
                                                    <option value="<?php echo $idlocal; ?>"><?php echo $local; ?></option>  

                                                    <?php
                                                     }
                                                    
                                                     ?>
								</select>
                    </div> 
        <div class="form-group">
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
                
			<div class="table-responsive">
			<div id="mostrar_informe" style = "float: left"></div>
            <div id="mostrar"></div>
			</div>
		</div>
	</div>



</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<script>
function imforme_cliente()
    { 
      
      //codigo = $("#numero_factura").val();
      
      var idlocal = document.getElementById("idlocal").value;
      var parametros = 
      {
        "informeClienteCuenta" : 1,
        "idlocal" : idlocal,
        //"numero_factura" : numero_factura,
        //"idcliente" : idcliente,
        "accion" : "4"
        
        
      };

      $.ajax({
        data: parametros,
        url: 'datos_informes.php',
        type: 'POST',
        
        beforesend: function()
        {
          $('#mostrar_informe').html("Mensaje antes de Enviar");
        },

        success: function(mensaje)
        {
          $('#mostrar_informe').html(mensaje);
      
        }
      });
    }
</script>
<?php include_once "includes/footer.php"; ?>