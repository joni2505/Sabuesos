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
		<h2 class="h3 mb-0 text-gray-800"> INFORME DEL PRODUCTO
    <input style="font-size: 16px; width:10%; text-transform: uppercase; color: black;" value="<?php echo $año?>" id="anio">
    <input type="hidden" id="idlocal" name="idlocal" value="<?php echo $idlocal; ?>" >
    </h2>
	</div>
	<div class="row">
    <div class="form-group">  
                       
                            <input type="hidden"  class="input-group-addon" name="codigo" id="codigo" style="width:15%;" onkeyup="if(event.keyCode ==13) buscar_datos_Producto();" required>
                            <select name="buscador" class="input-group-addon" id="buscador2" onchange="ShowSelected();">
                                <option value="">Buscar Producto</option> 
                                <?php
                                                        //traer sedes
                                                        include "../conexion.php";
                                                          
                                                    
                                                    $query = mysqli_query($conexion, "SELECT * FROM producto ");
                                            
                                                    while($row = mysqli_fetch_assoc($query))
                                                    {
	                                                
                                                    $producto = $row['nombre_producto'];
                                                    $idproducto = $row['idproducto'];
                                                    $codigo = $row['codigo_producto']
													?>
													
                                                    <option value="<?php echo $codigo; ?>"><?php echo $codigo."-".$producto; ?></option>  
                                                    
                                                    <?php
                                                     }
                                                    
                                                     ?>
                                </select>

                                Precio de Compra <input type="number"  class="input-group-addon" name="mi_precio" id="mi_precio" style="width:15%;" onkeyup="if(event.keyCode ==13) buscar_datos_Producto();" required>

                      </div>
                      

</div>
<div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1" _msthash="2191176" _msttexthash="418860">PRECIO X MENOR</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800" _msthash="2191319" _msttexthash="42484" ><input type="number" id="precio_menor" class="input-group-addon" name="precio_menor" style="width:70%;" required>
</div>
                                        </div>
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1" _msthash="2192242" _msttexthash="339118">PRECIO X MAYOR</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800" _msthash="2192385" _msttexthash="52013"><input type="number" id="precio_mayor" class="input-group-addon"  name="precio_mayor" style="width:70%;"  required>
</div>
                                        </div>
                                        <div class="col-auto">
                                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1" _msthash="2193308" _msttexthash="76011">GANANCIA X MENOR</div>
                                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800" _msthash="3116425" _msttexthash="14144"><input type="number" id="ganancia_menor" class="input-group-addon" style="width:90%;"  name="ganancia_menor" required>
</div>
                                        </div>
                                        <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1" _msthash="2194374" _msttexthash="496548">GANANCIA X Mayor</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800" _msthash="2192385" _msttexthash="52013"><input type="number" id="ganancia_mayor" class="input-group-addon"  name="ganancia_mayor" style="width:90%;"  required>
                                        </div>
                                        

                                        </div>
                                        <div class="col-auto">
                                            
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
</div>

<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <script src="http://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
  $("#buscador2").select2(); 

</script>
<script> 
  function ShowSelected()
{
/* Para obtener el valor */
var cod = document.getElementById("buscador2").value;
$('#codigo').val(cod);
//alert(cod);
buscar_datos_Producto(cod);
}
function buscar_datos_Producto(codigo) 
  {
    codigo = $("#codigo").val();
    idlocal = $("#idlocal").val();
    //alert(codigo);
    
    var parametros = 
    {
    "codigo" : codigo,
    "idlocal": idlocal,
    "buscar_producto": "1"
      
      
      
    };
    $.ajax(
    {
      data:  parametros,
      dataType: 'json',
      url:   'datos_producto.php',
      type:  'POST',
     
      error: function()
      {alert("Error");},
    
      success:  function (valores) 
      {
        $("#idproducto").val(valores.idproducto); 
        $("#nombre_producto").val(valores.nombre_producto);
        $("#precio_menor").val(valores.precio);
        $("#precio_mayor").val(valores.precio_mayor);
        $("#stock").val(valores.stock);
        $("#mi_precio").val(valores.mi_precio);
        var mi_precio = parseFloat($('#mi_precio').val());
        var precio_mayor = parseFloat($('#precio_mayor').val());
        var precio_menor = parseFloat($('#precio_menor').val());
        var ganancia_mayor = precio_mayor - mi_precio;
        var ganancia_menor = precio_menor - mi_precio;
        $("#ganancia_mayor").val(ganancia_mayor);
        $("#ganancia_menor").val(ganancia_menor);
        //insertar_carrito();
        /*stock = $("#stock").val();
        listaClientes();
       
       
        if(stock > 0 ){ //cambiar para stock
          
          
        }*/
        
        
      }
    }) 
  }
</script>
<?php include_once "includes/footer.php"; ?>