<?php include_once "includes/header.php";
    include "../conexion.php";
$id_user = $_SESSION['idUser'];
$permiso = "compras.php";
$sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
$existe = mysqli_fetch_all($sql);
if (empty($existe) && $id_user != 1) {
    header("Location: permisos.php");
}
date_default_timezone_set('America/Argentina/Buenos_Aires');
$feha_actual=date("d-m-Y ");
$nf=1;
$rs = mysqli_query($conexion, "SELECT * FROM compra ");

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
            <!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h2 class="h3 mb-0 text-gray-800"> Compra a Proveedores
  </h2>
</div>
            <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                <div class="col order-1">
            <label><i class="fa fa-university" aria-hidden="true"></i>Local</label><br>
            <input style="font-size: 16px; text-transform: uppercase; color: red;" value="<?php echo $local;?>" id="local" readonly="readonly">
            <input style="visibility:hidden" value="<?php echo $idlocal;?>" id="idlocal" readonly="readonly">
            <input style="visibility:hidden" value="<?php echo $_SESSION['idUser']; ?>" id="idusuario" readonly="readonly">
            <input style="visibility:hidden" value="<?php echo $_SESSION['idUser']; ?>" id="idproducto" readonly="readonly">

            USUARIO: <input style="font-size: 16px; text-transform: uppercase; color: red;" value="<?php echo $_SESSION['nombre']; ?>" id="usuario" readonly="readonly">    
            </div>      
            
            <br><button class="btn btn-outline-danger" type="button" data-toggle="modal" data-target="#nueva_compra"><i class="fas fa-plus"></i>Nueva Compra</button>

            <?php echo isset($alert) ? $alert : ''; ?>
 <!--<button class="btn btn-outline-info"  type="button" data-toggle="modal" data-target="#imprimir"><i class='fa fa-print' aria-hidden='true'></i>.Imprimir</button><br><br>-->
 <h4><center>Lista de Compras</center></h4>
 <div class="table-responsive">
     <table class="table table-striped table-bordered" id="tbl">
     
         <thead class="thead-dark">
         
             <tr>
                 
                 <th>Producto</th>
                 <th>Precio</th>
                 <th>Cantidad</th>
                 <th>Total</th>
                 <th>Proveedor</th>
                 <th>Tienda Local</th>
                 <th>Usuario</th>
                 <th>Fecha de Compra</th>
                 <th></th>
             </tr>
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
                if($admin=="admin"){
                
                $query = mysqli_query($conexion, "SELECT idcompra, producto.nombre_producto, compra.sub_total, compra.cantidad, compra.total, proveedores.nombre_proveedor, usuario.usuario,
                locales.nombre_local, fecha_compra FROM compra  
                INNER JOIN  producto on compra.idproducto=producto.idproducto
                INNER JOIN proveedores on compra.idproveedor=proveedores.idproveedor
                INNER JOIN locales on compra.idlocal=locales.idlocal
                INNER JOIN usuario on compra.idusuario=usuario.idusuario");
                $result = mysqli_num_rows($query);
                  
                }else{
                    $query = mysqli_query($conexion, "SELECT idcompra, producto.nombre_producto, compra.sub_total, compra.cantidad, compra.total, proveedores.nombre_proveedor, usuario.usuario,
                    locales.nombre_local, fecha_compra FROM compra  
                    INNER JOIN  producto on compra.idproducto=producto.idproducto
                    INNER JOIN proveedores on compra.idproveedor=proveedores.idproveedor
                    INNER JOIN locales on compra.idlocal=locales.idlocal
                    INNER JOIN usuario on compra.idusuario=usuario.idusuario WHERE usuario.idlocal='$idlocal1'");
                    $result = mysqli_num_rows($query);

                }
                
                if ($result > 0) {
                    while ($data = mysqli_fetch_assoc($query)) {
                ?>
                     <tr>
                         
                        <?php  $data['idcompra']; ?>
                         <td><?php echo $data['nombre_producto']; ?></td>
                         <td><?php echo $data['sub_total']; ?></td>
                         <td><?php echo $data['cantidad']; ?></td>
                         <td><?php echo $data['total']; ?></td>
                         <td><?php echo $data['nombre_proveedor']; ?></td>
                         <td><?php echo $data['nombre_local']; ?></td>
                         <td><?php echo $data['usuario']; ?></td>
                         <td><?php echo $data['fecha_compra']; ?></td>
                         <td>
                             
                                 <!--<a href="agregar_producto.php?id=<?php echo $data['codproducto']; ?>" class="btn btn-primary"><i class='fas fa-audio-description'></i></a>-->

                                 <!--<a href="editar_producto.php?id=<?php echo $data['codproducto']; ?>" class="btn btn-success"><i class='fas fa-edit'></i></a>-->

                                 <form action="eliminar_compra.php?id=<?php echo $data['idcompra']; ?>" method="post" class="confirmar d-inline">
                                     <button class="btn btn-danger" type="submit"><i class='fas fa-trash-alt'></i> </button>
                                 </form>
                            
                         </td>
                     </tr>
             <?php }
                } ?>
         </tbody>

     </table>
 </div>

<!--Modal Buscar Cliente-->
<div id="nueva_compra" class="modal fade" role="dialog" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">NUEVA COMPRA.</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">

      <div class="form-group">
                         <label for="telefono">Proveedores</label>
                         <select name="proveedor" class="form-control" id="proveedor"style="width:80%;" onchange="ShowSelected();">
                    <option value="Select">Select Proveedor</option>
                    <?php

                                          
                                                        //traer proveedor
                                                        include "../conexion.php";
                                                    $query = mysqli_query($conexion, "SELECT * FROM proveedores");
                                                    $result = mysqli_num_rows($query);
                                                    
                                                    while($row = mysqli_fetch_assoc($query))
                                                    {
	                                                //$idrol = $row['idrol'];
                                                    $prov = $row['nombre_proveedor'];
                                                    $idprov = $row['idproveedor'];

													?>
													
                                                    <option value="<?php echo $idprov; ?>"><?php echo $prov; ?></option>  

                                                    <?php
                                                     }
                                                    
                                                     ?>
								</select>
                     </div>
                     <div class="form-group">
                     <div id="mostrar_producto"></div>
                     </div>
                     <div class="col-lg-4">
                            <div class="form-group">
                                <label>Precio de Compra</label>
                                <input type="number" name="precio" id="precio" class="form-control"  required>
                            </div>
                        </div>
                
                     <div class="col-lg-4">
                            <div class="form-group">
                                <label>Cantidad</label>
                                <input type="number" name="cantidad" id="cantidad" value="1" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">  
                                <label>Total Al Pagar</label>
                                <input type='number' name='total' id='total' class='form-control' value='$total' style='font-size: 20px; width:100%; text-transform: uppercase; color: black;' onclick="calcular_total();"> </td>
                            </div>
                        </div>
                        <button type="button" class="btn btn-success" onclick=comprar_producto();>Guardar Compra</button>
       
      </div>
      </div><br>
 

<script type="text/javascript">


function ShowSelected()
{
/* Para obtener el valor*/ 
var id = document.getElementById("proveedor").value;

var parametros = 
    {
      "lista_producto": "1",
       "id" : id
      
       
    };
    $.ajax(
    {
      data:  parametros,
      url:   'datos_compra.php',
      type:  'post',
     
      error: function()
      {alert("Error evento");},
      
      success:  function (mensaje) 
      {
        $('#mostrar_producto').html(mensaje);
  
       
      }
      
    }) 


}

function calcular_total()
  {
    
    var cantidad = parseFloat($('#cantidad').val());
    var precio = parseFloat($('#precio').val());
    var total = precio * cantidad;
    $.ajax({
       
       beforesend: function()
       {
         alert("Error");
       },

       success: function()
       {
         
         $("#total").val(total);
       }
     });

    

  }


  function comprar_producto()
  {
    idusuario = $("#idusuario").val();
    idlocal = $("#idlocal").val();
    proveedor = $("#proveedor").val();
    idproducto = $("#idproducto").val();
    precio = $("#precio").val();
    cantidad = $("#cantidad").val();
    total = $("#total").val();
  
    
    var parametros = 
    {
      "comprar": "1",
      "idusuario" : idusuario,
      "idlocal" : idlocal,
      "proveedor" : proveedor,
      "idproducto" : idproducto,
       "precio" : precio,
       "cantidad" : cantidad,
       "total" : total,
       
    };
    $.ajax(
    {
      data:  parametros,
      url:   'datos_compra.php',
      type:  'post',
     
      error: function()
      {alert("Error");},
      
      success:  function (mensaje) 
      {
        $('#mostrar_producto').html(mensaje); 
        
      }
      
    }) 
    
  }

</script> 
<?php include_once "includes/footer.php"; ?>      