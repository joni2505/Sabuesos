<?php
include_once "vistas/header.php";
include "../conexion.php";
$id_user = $_SESSION['idUser'];
$permiso = "productos";
$sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
$existe = mysqli_fetch_all($sql);
if (empty($existe) && $id_user != 1) {
  header("Location: permisos.php");
}
if (!empty($_POST)) {
  $alert = "";
  if (empty($_POST['codigo_producto']) || empty($_POST['nombre_producto']) || empty($_POST['precio_menor']) || empty($_POST['precio_mayor'])) {
    $alert = '<div class="alert alert-primary" role="alert">
              Todo los campos son requeridos
            </div>';
  } else {
    $idproducto = $_GET['id'];
    $codigo_producto = $_POST['codigo_producto'];
    $nombre_producto = $_POST['nombre_producto'];
    $precio_menor = $_POST['precio_menor'];
    $precio_mayor = $_POST['precio_mayor'];
    $stock = $_POST['stock'];
    $unidad = $_POST['unidad'];
    $locales = $_POST['locales'];
    $mi_precio = $_POST['mi_precio'];
    $porcentaje_menor = $_POST['porcentaje_menor'];
    $porcentaje_mayor = $_POST['porcentaje_mayor'];
    $idproveedor = $_POST['proveedor'];
    $idrubro = $_POST['idrubro'];
    $idmarca = $_POST['idmarca'];
    //agregar imagen 
        $image = $_FILES['imagen']['tmp_name'];
        if(file_exists($image)){
          $imgContenido = addslashes(file_get_contents($image));

          $query_update = mysqli_query($conexion, "UPDATE producto SET codigo_producto = '$codigo_producto', nombre_producto='$nombre_producto', mi_precio = '$mi_precio', porcentaje_menor ='$porcentaje_menor', porcentaje_mayor = '$porcentaje_mayor', precio_producto= '$precio_menor', precio_mayor='$precio_mayor', stock_producto='$stock', unidad_producto='$unidad', idlocal='$locales', idproveedor='$idproveedor', idrubro='$idrubro', idmarca='$idmarca', imagen='$imgContenido' WHERE idproducto = '$idproducto'");
    if ($query_update) {
      $alert = '<div class="alert alert-primary" role="alert">
              Producto Modificado
            </div>';

    } else {
      $alert = '<div class="alert alert-primary" role="alert">
                Error al Modificar
              </div>';
    }
    $rs = mysqli_query($conexion, "UPDATE compra SET idproveedor = '$idproveedor' WHERE idproducto='$idproducto'");
    if ($rs) {
        echo '<script language="javascript">';
        
        //echo 'window.location.href = "productos.php";';
        echo '</script>';
        
        $Sumstock=0;
    } else {
        echo '<script language="javascript">';
        echo 'alert("Error modificar");';
        echo '</script>';
    }


        }else{

          // cuando no exista imagen
          $query_update = mysqli_query($conexion, "UPDATE producto SET codigo_producto = '$codigo_producto', nombre_producto='$nombre_producto', mi_precio = '$mi_precio', porcentaje_menor ='$porcentaje_menor', porcentaje_mayor = '$porcentaje_mayor', precio_producto= '$precio_menor', precio_mayor='$precio_mayor', stock_producto='$stock' WHERE idproducto = '$idproducto'");
    if ($query_update) {
      $alert = '<div class="alert alert-primary" role="alert">
              Producto Modificado
            </div>';
           
    } else {
      /*$alert = '<div class="alert alert-primary" role="alert">
                Error al Modificar
              </div>';*/
    }
    $rs = mysqli_query($conexion, "UPDATE compra SET idproveedor = '$idproveedor' WHERE idproducto='$idproducto'");
    if ($rs) {
        echo '<script language="javascript">';
        
        //echo 'window.location.href = "productos.php";';
        echo '</script>';
        
        $Sumstock=0;
    } else {
        echo '<script language="javascript">';
        echo 'alert("Error modificar");';
        echo '</script>';
    }

        }
        
  }
}

// Validar producto

if (empty($_REQUEST['id'])) {
  header("Location: stock_productos.php");
} else {
  $id_producto = $_REQUEST['id'];
  if (!is_numeric($id_producto)) {
    header("Location: stock_productos.php");
  }
  $query_producto = mysqli_query($conexion, "SELECT * FROM producto WHERE idproducto = $id_producto");
  $result_producto = mysqli_num_rows($query_producto);

  if ($result_producto > 0) {
    $data_producto = mysqli_fetch_assoc($query_producto);
  } else {
    header("Location: stock_productos.php");
  }
}
?>
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">

        <!-- Main content -->
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border" id="nuevo">
                          <h1 class="box-title">Modificar Producto</h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <div class="panel-body " style="height: 800px;" id="">
                    <form action="" method="post" enctype="multipart/form-data">
                        <?php echo isset($alert) ? $alert : ''; ?>
                          
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12" >
                            <label><i class="fa fa-barcode"></i> Codigo</label>
                            <input type="text" class="form-control" name="codigo_producto" id="codigo" maxlength="256" placeholder="Codigo de Barra" value="<?php echo $data_producto['codigo_producto']; ?>">
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Nombre Producto</label>
                            <input type="text" class="form-control" name="nombre_producto" id="nombre_producto" maxlength="50" placeholder="Nombre Producto" value="<?php echo $data_producto['nombre_producto']; ?>" required>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Precio Compra</label>
                            <input type="text" style="width:40%;" class="form-control" name="mi_precio" id="mi_precio" maxlength="256" placeholder="Precio compra" value="<?php echo $data_producto['mi_precio']; ?>">
                            </div>
                          
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Stock</label>
                            <input type="text" style="width:40%;" class="form-control" name="stock" id="stock" maxlength="256" placeholder="Stock producto" value="<?php echo $data_producto['stock_producto']; ?>">
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label> Porcentaje Menor %</label>
                            <input type="number" style="width:40%;" class="form-control" name="porcentaje_menor" id="porcentaje_menor" maxlength="256" placeholder="% X Menor" value="<?php echo $data_producto['porcentaje_menor']; ?>" onclick="calcular_menor();">
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label> Porcentaje Mayor %</label>
                            <input type="number" style="width:40%;" class="form-control" name="porcentaje_mayor" id="porcentaje_mayor" maxlength="256" placeholder="% X Mayor" value="<?php echo $data_producto['porcentaje_mayor']; ?>" onclick="calcular_mayor();">
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Precio x Menor</label>
                            <input type="text" style="width:40%;" class="form-control" name="precio_menor" id="precio_menor" maxlength="256" placeholder="Precio Menor" value="<?php echo $data_producto['precio_producto']; ?>">
                          </div>
                        
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Precio x Mayor</label>
                            <input type="text" style="width:40%;" class="form-control" name="precio_mayor" id="precio_mayor" maxlength="256" placeholder="Precio Mayor" value="<?php echo $data_producto['precio_mayor']; ?>">
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Unidad</label>
                            <select name="unidad" class="form-control" id="unidad" style="width:40%;">
                            <option value="unidad">Unidad</option>
                            <option value="litro">Litro</option>
                            <option value="kg">Kg</option>
                            </select>
                          </div>
                          
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Proveedor</label>
                                <select name="proveedor" class="form-control" id="proveedor"style="width:40%;">
                                                    <option value="">Seleccionar Proveedor</option>
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

                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Rubro</label>
                            <select name="idrubro" class="form-control" id="idrubro" style="width:40%;"onchange="listaMarcas2();" >
                         <option value="">Seleccionar Rubro</option>
                    
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

                          <div class="form-group">
                            <label>Marca</label>
                            <select name="idmarca" class="form-control" style="width:40%;" id="idmarca">
                            <option value="">Seleccionar Marca</option>
                    <?php
                                                        //traer marca
                                                        include "../conexion.php";
                                                    $query = mysqli_query($conexion, "SELECT * FROM marcas");
                                                    $result = mysqli_num_rows($query);
                                                    
                                                    while($row = mysqli_fetch_assoc($query))
                                                    {
	                                                //$idrol = $row['idrol'];
                                                    $marca = $row['nombre_marca'];
                                                    $idmarca = $row['idmarca'];

													?>
													
                                                    <option value="<?php echo $idmarca; ?>"><?php echo $marca; ?></option>  

                                                    <?php
                                                     }
                                                    
                                                     ?>
								</select>
                          </div>

                          <div class="form-group">
                            <label>Locales</label>
                            <select name="locales" class="form-control" id="locales" style="width:40%;">
                    <?php
                                                        //traer sedes
                                                        include "../conexion.php";
                                                        $rs = mysqli_query($conexion, "SELECT usuario, idlocal FROM usuario WHERE idusuario='$id_user'");
                                                        while($row = mysqli_fetch_array($rs))
                                                        {
                                                            $idlocal1=$row['idlocal'];
                                                            $admin = $row['usuario'];
                                                            //echo $admin;
                                                        
                                                        }
                                                        if($admin=="admin"){

                                                            $query = mysqli_query($conexion, "SELECT idlocal,nombre_local FROM locales");

                                                        }else{

                                                            $query = mysqli_query($conexion, "SELECT idlocal,nombre_local FROM locales WHERE idlocal='$idlocal1'");

                                                        }    
                                                    
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
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label for="Imagen Actual">Imagen Actual</label><br>
                            <img width="120" src="data:image/jpeg/jpg/png;base64,<?php echo  base64_encode($data_producto['imagen']); ?>">
                            </div><br>

                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label for="Cambiar Imagen">Cambiar Imagen</label>
                            <input type="file" class="form-control" id="imagen" name="imagen" multiple>
                            <img width="120" id="imagenPrevisualizacion">
                            </div>
                            
                            <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> Guardar</button>
                            <a href="stock_producto.php" class="btn btn-danger"><i class="fa fa-arrow-circle-left"></i></a>
                        
                            
                       
                        </form>
                    </div>
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->


  <script type="text/javascript">
  function ShowSelected()
{
/* Para obtener el valor*/
var idmarca = document.getElementById("idmarca3").value;
alert(idmarca);
$('#idmarca').val(idmarca); 
/* Para obtener el texto 
var combo = document.getElementById("sedes");
var selected = combo.options[combo.selectedIndex].text;
$('#sede').val(selected);*/
//alert(selected);
}
//lista de marcas agregar producto
function listaMarcas2()
    { 
        
    	buscar = document.getElementById('idrubro').value;
      var parametros = 
      {
        
        "idrubro2" : buscar,
        "lista_marcas3" : "4"
      };
      
      $.ajax({
        data: parametros,
        url: 'tablas.php',
        type: 'POST',
        
        beforesend: function()
        {
          $('#mostrar_marcas2').html("Mensaje antes de Enviar");
          
        },

        success: function(mensaje)
        {
          $('#mostrar_marcas2').html(mensaje);
    
        }
      });
    }
function calcular_menor()
  {
    
    var miprecio = parseFloat($('#mi_precio').val());
    var porcen_menor = parseFloat($('#porcentaje_menor').val());
    var porcentaje = miprecio * porcen_menor / 100;
    var total = miprecio + porcentaje;
    $.ajax({
       
       beforesend: function()
       {
         alert("Error");
       },

       success: function()
       {
         
         $("#precio_menor").val(total);
       }
     });

    

  }

  function calcular_mayor()
  {

    var miprecio = parseFloat($('#mi_precio').val());
    var porcen_mayor = parseFloat($('#porcentaje_mayor').val());
    var porcentaje = miprecio * porcen_mayor / 100;
    var total = miprecio + porcentaje;
    $.ajax({
       
       beforesend: function()
       {
         alert("Error");
       },

       success: function()
       {
         
         $("#precio_mayor").val(total);
       }
     });

    

  }
 </script>

<script>
//previsualizar imagen  
const $seleccionArchivos = document.querySelector("#imagen"),
  $imagenPrevisualizacion = document.querySelector("#imagenPrevisualizacion");

// Escuchar cuando cambie
$seleccionArchivos.addEventListener("change", () => {
  // Los archivos seleccionados, pueden ser muchos o uno
  const archivos = $seleccionArchivos.files;
  // Si no hay archivos salimos de la función y quitamos la imagen
  if (!archivos || !archivos.length) {
    $imagenPrevisualizacion.src = "";
    return;
  }
  // Ahora tomamos el primer archivo, el cual vamos a previsualizar
  const primerArchivo = archivos[0];
  // Lo convertimos a un objeto de tipo objectURL
  const objectURL = URL.createObjectURL(primerArchivo);
  // Y a la fuente de la imagen le ponemos el objectURL
  $imagenPrevisualizacion.src = objectURL;
});
</script>
<?php include_once "vistas/footer.php"; ?>