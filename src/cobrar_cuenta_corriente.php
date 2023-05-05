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
                          <h1 class="box-title">Pagos</h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>

                    <div class="box-header with-border" id="mlista">
                          <h1 class="box-title"><button id="btnagregar" data-toggle="modal" data-target="#buscarCliente" class="btn btn-primary" onclick="listaClientes(); mostrarform(true);" title="Nuevo categoria"><i class="fa fa-plus-circle" ></i> Agregar Pago  </button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <?php echo isset($ams) ? $ms: ''; ?>
                    <div class="panel-body table-responsive" style="height: 400px;" id="listadoregistros">
                    <table class="table table-bordered order-table " id="tbl_producto">
                    <thead>
                        <th>#</th>
                        <th>N°Factura</th>
                        <th>fecha</th>
                          <th>Cliente</th>
                          <th>Recibido</th>
                          <th>estado</th>
                        </thead>
                        <tbody>
             <?php
                include "../conexion.php";
                $rs = mysqli_query($conexion, "SELECT usuario, idlocal FROM usuario WHERE idusuario='$id_user'");
                while($row = mysqli_fetch_array($rs))
                {
                    $idlocal1=$row['idlocal'];
                    $admin = $row['usuario'];
                    //echo $admin;
                
                }
                

                    $query = mysqli_query($conexion, "SELECT idpagos_cuenta, pagos_cuenta.numero_factura, date_format(pagos_cuenta.fecha, '%d-%m-%Y') AS fecha, cliente.nombre, recibido_ahora  FROM pagos_cuenta
                    INNER JOIN cuenta_corrientes on pagos_cuenta.idcuenta_corriente=cuenta_corrientes.idcuenta_corrientes 
                    INNER JOIN cliente on cuenta_corrientes.idcliente=cliente.idcliente order By pagos_cuenta.fecha desc");

                
                $i=1;
                $result = mysqli_num_rows($query);
                if ($result > 0) {
                    while ($data = mysqli_fetch_assoc($query)) {
                        
                ?>
                     <tr>
                     <?php $data['idpagos_cuenta'];?>
                     <td><?php echo $i; ?></td>
                         <td><?php echo $data['numero_factura']; ?></td>
                         <td><?php echo $data['fecha']; ?></td>
                         <td><?php echo $data['nombre']; ?></td>
                         <td><?php echo $data['recibido_ahora']; ?></td>
                         <td>
                         <!--<a href="editar_marca.php?id=<?php echo $data['idmarca']; ?>" class="btn btn-success">Editar</a>-->
  
                         <a href="eliminar_pago_cuenta.php?id=<?php echo $data['idpagos_cuenta'];?>&recibido=<?php echo $data['recibido_ahora']; ?>&numero=<?php echo $data['numero_factura']; ?>" class="btn btn-danger">Eliminar</i></a>
                                 
                         </td>
                     </tr>
             <?php $i++; }
                } ?>
         </tbody>
                      </table>

                    </div>
                    <div class="panel-body with-border " style="height: 200px;" id="formularioregistros">
                    <h4 class="box-title">Formulario de Pago</h4>
                      
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Nombre del Cliente:</label>
                            <input type="hidden" name="idcliente" id="idcliente">
                            <input type="text" class="form-control" name="nombre_cliente" id="nombre_cliente" maxlength="100" style='font-size: 20px; width:72%; text-transform: uppercase; color: black;'  placeholder="Nombre" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12" style="width:20%; float:right;" >
                            <label>Fecha de Pago:</label>
                            <input type="date" class="form-control" value="<?php echo date('Y-m-d', strtotime($feha_actual)) ?>"   name="fecha" id="fecha" maxlength="50" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12" style="width:20%; float:right;" >
                            <label>N°Factura:</label>
                            <input type="text" class="form-control" name="numero_factura" id="numero_factura" required>
                          </div>
                          
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <!--<button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>-->

                            <button class="btn btn-danger" onclick="cancelarform()" type="button" title="Cancelar"><i class="fa fa-arrow-circle-left"></i></button>
                          </div>
                          
                       
                        <div class="panel-body table-responsive" style="height: 300px;" id="">
                          <table id="" class="table table-bordered table-striped table-hover">
                          <div id="mostrar_cuentas"></div>
                          </table>

                        </div>
                        <div class="panel-footer bg-light-blue " style="height: 80px;" id="">
                        <input type="hidden" name="idcuenta_corriente" id="idcuenta_corriente">
                    
                          <div class="form-group">
                            <label>Monto de la Factura</label>
                            <input type="text" style='font-size: 20px; width:9%;' id="monto_factura" class="input-group-addon" name="monto_factura" required>
                          
                            <label style='font-size: 60px;'>+</label>
                        
                            <label style='font-size: 15px;'>Agregue el pago anticipado (si lo hay)</label>
                            <input type="number" value="0" style='font-size: 20px; width:9%;' id="anticipo" class="input-group-addon" name="anticipo" id="fecha" required>
                   
                            <label style='font-size: 60px;'>=</label>
       
                            <label>Total Pagado Ahora</label>
                            <input type="number"  style='font-size: 20px; width:9%;' id="total_pagado" class="input-group-addon" name="total_pagado" id="fecha" required>
                          
                            <button class="btn btn-info " style="font-size: 20px;" type="button" id="btnGuardar" onclick="cobrar_cuenta()"><i class="fa fa-save"></i> Cobrar</button>
                            <button class="btn btn-danger" style="font-size: 20px;" onclick="cancelarform()" type="button" title="Cobrar"><i class="fa fa-arrow-circle-left"></i></button>
                            
                          <div id="mostrar_mensaje"></div>
                       
                        </div>
                        
                        </div><!-- /.row -->
                        
                        
                    <!--Fin centro -->
                    

                  </div><!-- /.box -->
                  
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->
      
    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->
  

  <!--Modal Buscar Cliente-->
<div class="card">
<div class="card-body">
<div id="buscarCliente" class="modal fade" role="dialog" data-toggle="offcanvas" >
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Cliantela</h3>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
      <input type="text" placeholder="Buscar Clientes" id="cuadro_buscar" class="form-control" onkeypress="listaClientes();">
      <table class="table table-hover">
      <div id="mostrar_clientes"></div>
      </table>
      </div>
      
      </div>
      </div>
      </div>
      </div>
      </div>
  <?php
    require 'includes/footer.php';
  ?>
  <script type="text/javascript" src="js/categoria.js"></script>
  
  <script>
    //cobrar cuenta
    function cobrar_cuenta()
  {
    
    idcuenta_corriente = $("#idcuenta_corriente").val();
    numero_factura = $("#numero_factura").val();
    gran_total = $("#gran_total").val();
    recibido_antes = $("#recibido_antes").val();
    recibido_ahora = $("#recibido_ahora").val();
    saldo_por_recibir = $("#saldo_por_recibir").val();
    total_pagado = $("#total_pagado").val();
    estado = $("#estado").val();
    
    var parametros = 
    {
      "insertar_pago_cuenta": "1",
       "idcuenta_corriente" : idcuenta_corriente,
       "numero_factura" : numero_factura,
       "gran_total" : gran_total,
       "recibido_antes" : recibido_antes,
       "recibido_ahora" : recibido_ahora,
       "saldo_por_recibir" : saldo_por_recibir,
       "total_pagado" : total_pagado,
       "estado" : estado
       
       
       
    };
    $.ajax(
    {
      data:  parametros,
      url:   'datos_carrito_cuenta.php',
      type:  'post',
     
      error: function()
      {alert("Error evento");},
      
      success:  function (mensaje) 
      {
        $('#mostrar_mensaje').html(mensaje);
        window.location.href = "cobrar_cuenta_corriente.php";
    
      }
      
    }) 
    
  }

    //tabla cuenta corriente para pagos
    function tablacuenta_pagos()
    { 
  
      buscar = document.getElementById('idcliente').value;
      var parametros = 
      {
        "mostrar_tabla_pagos" : 1,
        "buscar" : buscar,
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


  function listaClientes()
    { 
      
      buscar = document.getElementById('cuadro_buscar').value;
      var parametros = 
      {
        "lista_clientes" : 1,
        "buscar" : buscar,
        "accion" : "4"
        
        
      };

      $.ajax({
        data: parametros,
        url: 'tablas.php',
        type: 'POST',
        
        beforesend: function()
        {
          $('#mostrar_clientes').html("Mensaje antes de Enviar");
        },

        success: function(mensaje)
        {
          $('#mostrar_clientes').html(mensaje);
        }
      });
    }
    </script>
    <?php include_once "includes/footer.php"; ?>