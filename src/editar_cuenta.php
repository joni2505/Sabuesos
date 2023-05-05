<?php include_once "includes/header.php";
include "../conexion.php";
date_default_timezone_set('America/Argentina/Buenos_Aires');
$id_user = $_SESSION['idUser'];
$permiso = "cuenta_corriente";
  $sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
  $existe = mysqli_fetch_all($sql);
  if (empty($existe) && $id_user != 1) {
    echo "<script> window.location.replace('permisos.php') </script>";
  }
  if (!empty($_GET['numero_factura'])) {
    
    $numero_factura = $_GET['numero_factura'];
    $cliente = $_GET['cliente'];
    $idcliente = $_GET['idcliente'];
    
    $rs = mysqli_query($conexion, "SELECT * FROM cliente WHERE nombre='$cliente' ");

        while($row = mysqli_fetch_array($rs))
            {
                $idcliente=$row['idcliente'];
                
            }
    //eliminar cuenta
    $id = $_GET['id'];
    $query_delete = mysqli_query($conexion, "DELETE FROM cuenta_corrientes WHERE idcuenta_corrientes=$id");        
  }
  
$feha_actual=date("d-m-Y ");
$nf=0;
$rs = mysqli_query($conexion, "SELECT * FROM carrito_cuenta ");

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
<div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
  
                        <div class="box-header with-border" id="nuevo">
                          <h6 class="box-title">Nueva Cuenta Corriente</h6><br>

                          <input style="visibility:hidden" value="<?php echo $idlocal;?>" id="idlocal" readonly="readonly">
                        <input style="visibility:hidden" value="<?php echo $id_user;?>" id="idusuario" readonly="readonly">
                        
                        <div class="box-tools pull-right">
                        
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12" style="width:20%; float:right;" >
                            <label>Fecha Vencimiento:</label>
                            <input type="date" class="form-control" value="<?php echo date('Y-m-d', strtotime($feha_actual)) ?>"   name="fecha" id="fecha_vencimiento" maxlength="50" required>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12" style="width:20%; float:right;">
                            <label>Numero Factura:</label>
                            <input type="text" class="form-control"  value="<?php echo $numero_factura; ?>"   name="numero_factura" id="numero_factura" maxlength="50" required>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12" style="width:20%; float:right;" >
                            <label>Fecha Factura:</label>
                            <input type="date" class="form-control" value="<?php echo date('Y-m-d', strtotime($feha_actual)) ?>"   name="fecha" id="fecha" maxlength="50" required>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12" style="width:20%; float:right;" >
                            <label>Local:</label>
                            <input type="text" class="form-control" value="<?php echo $local ?>"   name="local" id="local" maxlength="50" required>
                          </div>
                          
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12" style="width:20%;">
                            <label>Nombre del Cliente:</label>
                            <input type='text' name="cliente" id="cliente" class='form-control' value="<?php echo $cliente; ?>" style='font-size: 15px; text-transform: uppercase; color: black;' onkeydown="" disabled>                                           
                            <input type='hidden' id="idcliente" class='form-control' value="<?php echo $idcliente; ?>" style='font-size: 15px; text-transform: uppercase; color: black;' onkeydown="" disabled>                                           

                            <div id="response2"></div><br>
                            <label>Datos del Cliente:</label>
                            <div id="mostrar_clientes"></div>
                          </div>
                    </div>

                    </div>
                        </div>
                          </div>
                            
                    <div class="container-fluid">
                        <div class="row">
                        <div class="col-lg-12">
                        <div class="box-header with-border"  id="nuevo">
                        <input type="hidden" id="idproducto" name="idproducto"> 
                    <div class="form-group">  
                        <label style='color: #9932CC;'>Codigo Producto:</label>
                            <label style='color: white;'>.................</label>
                            <label style='color: #9932CC;'>Nombre del Producto:</label>
                            <label style='color: white;'>....................................................</label>
                            <label style='color: black;'>Stock Producto:</label>
                            <label style='color: white;'>......</label>
                            <label style='color: black;'>Precio Especial:</label>
                            <br>
                            
                            <input type="number"  class="input-group-addon" name="codigo" id="codigo" style="width:15%;" onkeyup="if(event.keyCode ==13) buscar_datos_Producto();" required>
                            <select name="buscador" class="input-group-addon" id="buscador" style="width:23%;" onchange="ShowSelected();">
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

                            <label style='color: white;'>.................</label> 
                            <input type="number" id="stock" class="input-group-addon" style="width:9%;" name="stock"  required>
                            <label style='color: white;'>.....</label> 
                            <input type="number" id="mi_precio" class="input-group-addon" style="width:9%;"  name="mi_precio" required>

                      </div>

                      <div class="form-group">

                      <label >Precio X Menor</label>
                            <label >  </label>
                            <label>Precio X Mayor</label>
                            <label style='color: white;'>...  </label>
                            <label>Cantidad</label>
                            <label style='color: white;'>..............</label>
                            <label>Descuento</label>
                            <label style='color: white;'>..........</label>
                            <label>Precio de Venta</label>
                            <label style='color: white;'>..........</label>
                            <label>Medio de Pago</label>
                            <br>
                            <input type="number" id="precio_menor" class="input-group-addon" name="precio_menor" style="width:9%;" required>
                            <label >  </label>
                            <input type="number" id="precio_mayor" class="input-group-addon"  name="precio_mayor" style="width:9%;"  required>
                            <label >  </label>
                            <input type="number" id="cantidad" class="input-group-addon" value="1"  name="cantidad" style="width:9%;"   required>
                            <label >  </label>
                            <input type="number" id="descuento" class="input-group-addon" value="0" name="descuento" style="width:9%;"  required>
                            
                            <label >  </label>
                            <select name="tipo" class="input-group-addon" id="tipo" onchange="ShowSelected();" style='width:11%;' >
                                <option value="Precio x Menor">Precio x Menor</option>
                                <option value="Precio x Mayor">Precio x Mayor</option>
                                <option value="Precio x Suelto">Precio x Suelto</option>
                            </select>

                            <label >  </label>
                            <select name="mediodePago" class="input-group-addon" id="mediodePago" style='width:11%;'>
                                <option value="Efectivo">Efectivo</option>
                                <option value="Transferencia">Transferencia</option>
                                <option value="Tarjeta de Credito">Tarjeta de Credito</option>
                                <option value="Tarjeta de debito">Tarjeta de debito</option>
                                <option value="Cuenta Corriente">Cuenta Corriente</option>
                            </select><br><br>

                          <button class="btn btn-success" type="" id="btnGuardar" onclick="insertar_carrito();"><i class="fa fa-plus"></i> Añadir Producto</button>
                          <button class="btn btn-primary" type="" id="btnGuardar" onclick="guardar_cuenta();"><i class="fa fa-plus"></i> Guardar Cuenta</button>                          
                          <div id="mostrar_mensaje"></div>
                          <div id="mostrar_ventas"></div>
                          <div id="mostrar_carrito"></div>                           
                      </div>

                        </div>
                        </div>
                      </div>      

                      <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <script src="http://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script>
  $("#buscador").select2();  
  </script>
  <script> 
  window.onload = function () {
    document.getElementById("cliente").focus();
    listaClientes();
    insertar_carrito();
}
  
  function buscarSelect()
{
	// creamos un variable que hace referencia al select
	var select=document.getElementById("elementos");
 
	// obtenemos el valor a buscar
	var buscar=document.getElementById("buscar").value;
 
	// recorremos todos los valores del select
	for(var i=0;i<select.length;i++)
	{
		if(select.options[i].text==buscar)
		{
			// seleccionamos el valor que coincide
			select.selectedIndex=i;
		}
	}
}
    //datos clientes
    function listaClientes()
    { 
      
      buscar = document.getElementById('idcliente').value;
      var parametros = 
      {
        "mi_busqueda_clientes" : buscar,
        "accion" : "4"
        
        
      };

      $.ajax({
        data: parametros,
        url: 'tablas.php',
        type: 'POST',
        
        beforesend: function()
        {
          $('#mostrar_producto').html("Mensaje antes de Enviar");
        },

        success: function(mensaje)
        {
          $('#mostrar_clientes').html(mensaje);
        }
      });
    }

  //auto completado input
$(document).ready(function () {
    $("#cliente").keyup(function () {
       
        var query = $("#cliente").val();
  
        if (query.length > 0) {
            $.ajax(
                {
                    url: 'autocompletado.php',
                    method: 'POST',
                    data: {
                      search_cliente: 1,
                        q: query
                    },
                    success: function (data) {
                        $("#response2").html(data);
                    },
                    dataType: 'text'
                }
            );
        }
    });
    
    $(document).on('click', 'li', function () {
        var country = $(this).text();
        $("#cliente").val(country);
        $("#response2").html("");
    });
  })   

  //datos del producto
  function buscar_datos_Producto() 
  {
    codigo = $("#codigo").val();
  
    
    var parametros = 
    {
    "codigo" : codigo,
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
        //insertar_carrito();
        /*stock = $("#stock").val();
        listaClientes();
       
       
        if(stock > 0 ){ //cambiar para stock
          
          
        }*/
        
        
      }
    }) 
  }

  //guardar cuenta en bd
  function guardar_cuenta()
  {
    
    fecha = $("#fecha").val();
    fecha_vencimiento = $("#fecha_vencimiento").val();
    numero_factura = $("#numero_factura").val();
    idcliente = $("#idcliente").val();
    idlocal = $("#idlocal").val();
    idusuario = $("#idusuario").val();
    total = $("#totalC").val();
    observaciones = $("#observaciones").val();
   
    var parametros = 
    {
      "insertar_cuenta": "1",
       "fecha" : fecha,
       "fecha_vencimiento" : fecha_vencimiento,
       "numero_factura" : numero_factura,
       "idcliente" : idcliente,
       "idlocal" : idlocal,
       "idusuario" : idusuario,
       "total" : total,
       "observaciones" : observaciones
       
       
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
        url = 'pdf/reporteCuenta.php?factura=' + numero_factura;
        window.open(url, '_blank')
    
      }
      
    }) 
    
  }

  function ShowSelected()
{
/* Para obtener el valor */
var cod = document.getElementById("buscador").value;
$('#codigo').val(cod);
//alert(cod);
buscar_datos_Producto();
}

//carrito de compra
function insertar_carrito()
  {
      
    idcliente = $("#idcliente").val();
    idproducto = $("#idproducto").val();
    numero_factura = $("#numero_factura").val();
    fecha = $("#fecha").val();
    fecha_vencimiento = $("#fecha_vencimiento").val();
    cantidad = $("#cantidad").val();
    mi_precio = $("#mi_precio").val();
    precio_menor = $("#precio_menor").val();
    precio_mayor = $("#precio_mayor").val();
    tipo = $("#tipo").val();
    descuento = $("#descuento").val();
    stock = $("#stock").val();  
    var parametros = 
    {
      "carrito_cuenta": "1",
       "idcliente" : idcliente,
       "idproducto" : idproducto,
       "fecha" : fecha,
       "fecha_vencimiento" : fecha_vencimiento,
       "cantidad" : cantidad,
       "mi_precio" : mi_precio,
       "precio_menor" : precio_menor,
       "precio_mayor" : precio_mayor,
       "tipo" : tipo,
       "descuento" : descuento,
       "numero_factura" : numero_factura,
       "stock" : stock,
       "mediodePago" : $("#mediodePago").val()
       
       
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
        tablacarrito();
        
       
      }
      
    }) 
    
  }
    //tabla carrito de venta
    function tablacarrito()
    { 
      
      numero_factura = codigo = $("#numero_factura").val();
      idcliente = codigo = $("#idcliente").val();
    
      var parametros = 
      {
        "mostrar_ventas" : buscar,
        "numero_factura" : numero_factura,
        "idcliente" : idcliente,
        "accion" : "4"
        
        
      };

      $.ajax({
        data: parametros,
        url: 'tabla_cuenta.php',
        type: 'POST',
        
        beforesend: function()
        {
          $('#mostrar_carrito').html("Mensaje antes de Enviar");
        },

        success: function(mensaje)
        {
          $('#mostrar_carrito').html(mensaje);
       
        }
      });
    }

    //reporte cuenta
    
    
  </script>
<?php include_once "includes/footer.php"; ?>