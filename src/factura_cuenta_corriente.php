<?php
include_once "includes/header.php";
include "../conexion.php";
$id_user = $_SESSION['idUser'];
$permiso = "cuenta_corriente";
  $sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
  $existe = mysqli_fetch_all($sql);
  if (empty($existe) && $id_user != 1) {
    echo "<script> window.location.replace('permisos.php') </script>";
  }
date_default_timezone_set('America/Argentina/Buenos_Aires');
$feha_actual=date("d-m-Y ");
?>

<div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                  <div class="box">
                    <div class="box-header with-border" id="nuevo">
                          <h5 class="box-title">Lista Cuenta Corriente</h5>
                        <div class="box-tools pull-right">
                        </div>
                    </div>

                    <div class="box-header with-border" id="">
                          <h4 class="box-title">Ver Lista <button id="" class="btn btn-success" onclick="tablacuenta();" title="Nuevo categoria"><i class="fa fa-plus-circle" ></i> </button></h4>
                        <div class="box-tools pull-right">
                     
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" style="height: 400px;" id="">
                      <table id="" class="table table-bordered table-striped table-hover">
                      <div id="mostrar_cuentas"></div>
                      </table>

                    </div>
                 
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->



  <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <script src="http://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <script>
    //tabla cuenta corriente
    function tablacuenta()
    { 
  
    
      var parametros = 
      {
        "mostrar_cuentas" : 1,
        "accion" : "4"
         
      };

      $.ajax({
        data: parametros,
        url: 'tabla_cuenta.php',
        type: 'POST',
        
        beforesend: function()
        {
          $('#mostrar_cuentas').html("Mensaje antes de Enviar");
        },

        success: function(mensaje)
        {
          $('#mostrar_cuentas').html(mensaje);
       
        }
      });
    }
  </script>  

<?php include_once "includes/footer.php"; ?>
  