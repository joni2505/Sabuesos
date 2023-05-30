<?php include_once "includes/header.php";
include "../conexion.php";
//phpinfo();
$id_user = $_SESSION['idUser'];
  $permiso = "venta";
  $sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
  $existe = mysqli_fetch_all($sql);
  if (empty($existe) && $id_user != 1) {
    echo "<script> window.location.replace('permisos.php') </script>";
  }
date_default_timezone_set('America/Argentina/Buenos_Aires');
$feha_actual=date("d-m-Y");

            $rs = mysqli_query($conexion,"SELECT usuario.idlocal, locales.nombre_local FROM usuario INNER JOIN locales on usuario.idlocal=locales.idlocal WHERE usuario.idusuario ='$id_user'");
            while($row = mysqli_fetch_array($rs))
            {
              //$valores['existe'] = "1"; //Esta variable no la usamos en el vídeo (se me olvido, lo siento xD). Aqui la uso en la linea 97 de registro.php
              $local = $row['nombre_local'];
              $idlocal = $row['idlocal'];
            }
$nf=0;
$rs = mysqli_query($conexion, "SELECT * FROM ventas WHERE idlocal = $idlocal ");
while($row = mysqli_fetch_array($rs))
            {
                $nf=$row['numero_factura'];
                
            } 
            $nf++;
             
?>
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
  
                        <div class="box-header with-border" id="nuevo">
                        <h6 class="box-title">Nueva venta/ USUARIO: <?php echo $_SESSION['user']; ?> / LOCAL: <?php echo $local; ?> </h6>

                        <input style="visibility:hidden" value="<?php echo $idlocal;?>" id="idlocal" readonly="readonly">
                        <input style="visibility:hidden" value="<?php echo $id_user;?>" id="idusuario" readonly="readonly">

                        <div class="box-tools pull-right">
                        

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12" style="width:20%; float:right;">
                            <label>Numero Factura:</label>
                            <input type="text" class="form-control"  value="<?php echo $nf; ?>"   name="numero_factura" id="numero_factura" maxlength="50" required>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12" style="width:20%; float:right;" >
                            <label>Local:</label>
                            <input type="text" class="form-control" value="<?php echo $local ?>"   name="local" id="local" maxlength="50" required>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12" style="width:20%; float:right;" >
                            <label>Fecha Vencimiento:</label>
                            <input type="date" class="form-control" value="<?php echo date('Y-m-d', strtotime($feha_actual)) ?>"   name="fecha_vencimiento" id="fecha_vencimiento"  required>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12" style="width:20%; float:right;" >
                            <label>Fecha Factura:</label>
                            <input type="date" class="form-control" value="<?php echo date('Y-m-d', strtotime($feha_actual)) ?>"   name="fecha" id="fecha"  required>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Nombre del Cliente:</label><br>
                                <input type='hidden' name="cliente" id="cliente" class='form-control' style='font-size: 15px; text-transform: uppercase; color: black;' onkeydown="">                                        
                        
                                <select name="buscador_cliente" class="input-group-addon" id="buscador_cliente" style="width:38%;" onchange="ShowSelected_cliente();">
                                <option value="">Buscar Cliente</option> 
                                <?php
                                                        //traer sedes
                                                        include "../conexion.php";
                                                          
                                                    
                                                    $query = mysqli_query($conexion, "SELECT * FROM cliente ");
                                            
                                                    while($row = mysqli_fetch_assoc($query))
                                                    {
	                                                
                                                    $cliente = $row['nombre'];
                                                    $idcliente = $row['idcliente'];
                                                   
													?>
													
                                                    <option value="<?php echo $idcliente; ?>"><?php echo $cliente; ?></option>  
                                                    
                                                    <?php
                                                     }
                                                    
                                                     ?>
                                </select>
                                </div>
                          <!--<div id="response2"></div><br>-->
                                <label>Datos del Cliente:</label>
                                <div id="mostrar_clientes"></div>                             
                            
                        </div>
                        </div>
                          </div>
                            <!--<div class="form-group">
                                <a href="#" class="btn btn-primary btn_new_cliente"><i class="fas fa-user-plus"></i> Nuevo Cliente</a>
                            </div>-->
                            

                  

                </div>
                <!-- /.container-fluid -->
              
            </div>
            <!-- End of Main Content -->
            <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                        <div class="box-header with-border"  id="nuevo">
                        <input type="hidden" id="idproducto" name="idproducto"> 
                        <div class="form-group">
                            <label style='color: #9932CC;'>Codigo Producto:</label>
                            <label style='color: white;'>.................</label>
                            <label style='color: #9932CC;'>Nombre del Producto:</label>
                            <label style='color: white;'>......................................................</label>
                            <label style='color: black;'>Stock Producto:</label>
                            <label style='color: white;'>..........</label>
                            <label style='color: black;'>Precio Especial:</label>
                            <br>
                            <input type="number" class="input-group-addon" name="codigo" id="codigo" style="width:15%; " maxlength="50" onkeyup="if(event.keyCode ==13) buscar_datos_Producto();" required>
                            
                            
                        
                                <select name="buscador" class="input-group-addon" id="buscador" style="width:23%;" onchange="ShowSelected();">
                                <option value="">Buscar Producto</option> 
                                <?php
                                                        //traer sedes
                                                        include "../conexion.php";
                                                          
                                                    
                                                    $query = mysqli_query($conexion, "SELECT * FROM producto where idlocal=$idlocal ");
                                            
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
                                <input type="number" id="stock" class="input-group-addon" style="width:9%;"  name="stock" maxlength="150" required>
                                <label style='color: white;'>.....</label> 
                                <input type="number" id="mi_precio" class="input-group-addon" style="width:9%;"  name="mi_precio" maxlength="150" required>
                      
                             
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
                            <label>Interes</label>
                            <label style='color: white;'>..........</label>
                            <label>Precio de Venta</label>
                            <label style='color: white;'>..........</label>
                            <label>Medio de Pago</label>
                            <label style='color: white;'>..........</label>
                            <label>Vendedores</label>
                            <br>
                            <input class="input-group-addon" style="width:9%;" type="number" id="precio_menor" class="form-control" name="precio_menor" maxlength="100" required>
                            <label >  </label>
                            <input class="input-group-addon" type="number" id="precio_mayor" style="width:9%;" class="form-control"  name="precio_mayor" maxlength="50" required>
                            <label>   </label>
                            <input class="input-group-addon" type="number" id="cantidad"  style="width:9%;" class="form-control" value="1" name="cantidad" maxlength="50" required>
                            <label>   </label>
                            <input class="input-group-addon" type="number" id="descuento" style="width:9%;" class="form-control" value="0" name="descuento" maxlength="50" required>
                            <label>   </label>
                            <input class="input-group-addon" type="number" id="interes" style="width:9%;" class="form-control" value="0" name="interes" maxlength="50" required>
                            <label>   </label>
                            <select class="input-group-addon"  name="tipo" class="form-control" id="tipo" onchange="ShowSelected();" style="width:11%;">
                                <option value="Precio x Menor">Precio x Menor</option>
                                <option value="Precio x Mayor">Precio x Mayor</option>
                                <option value="Precio x Suelto">Precio x Suelto</option>
                            </select>
                            <label>    </label>
                            <select class="input-group-addon" name="mediodePago" class="form-control" id="mediodePago" style='width:11%;' onchange="interes();">
                                <option value="Efectivo">Efectivo</option>
                                <option value="Transferencia">Transferencia</option>
                                <option value="Tarjeta de Credito">Tarjeta de Credito</option>
                                <option value="Tarjeta de debito">Tarjeta de debito</option>
                            </select>
                            <label>    </label>
                            <select name="buscador" class="input-group-addon" id="vendedor" style="width:15%;" onchange="">
                                <option value="<?php echo $id_user; ?>">Buscar Vendedor</option>
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
                            </select><br><br>
                            <div class="form-group col-lg-6">
                            <!--<label>Interes:</label>-->
                            </div>                            
                          <button class="btn btn-success" style="height:35px;"   id="btnGuardar" onclick="insertar_carrito_venta();"><i class="fa fa-plus"></i> Añadir Producto</button>
                          <button class="btn btn-primary" style="height:35px;"  data-toggle="modal" data-target="#modal-cobrar"><i class="fa fa-plus"></i> Cobrar Venta</button>
                          <button class="btn btn-info" style="height:35px;" data-toggle="modal" data-target="#modal-suelto"><i class="fa fa-plus"></i> Producto Suelto</button>

                          </div>

                          <table class="table table-hover" id="tblDetalle">
                                <div id="mostrar_mensaje"></div>
                                <div id="mostrar_ventas"></div>
                                <div id="mostrar_carrito"></div>
                                
                          </table>

                        </div>
                        </div>
                    
                    </div>
            </div>
            <div class="modal-footer ">
                                                   
             </div>
<!--Modales -->
<div class="modal"  role="dialog" id="modal-suelto">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Suelto</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" >
      <div class="form-group">
                            <label>Nombre del Producto:</label>
                              <p>
                                <select name="buscador2" class="form-control" id="buscador2" style="width:36%; " onchange="ShowSelected2();">
                                <option value="">Buscar Producto</option> 
                                <?php
                                                        //traer sedes
                                                        include "../conexion.php";
                                                          
                                                    
                                                    $query = mysqli_query($conexion, "SELECT * FROM producto where suelto=1 ");
                                            
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
                              </p>
          </div><br>
          
          <div class="form-group">
               <label>Precio x KG:</label>
               <input type="number" name="precio_suelto" id="precio_suelto"  class="input-group-addon" value="0" style='font-size: 20px; width:15%; text-transform: uppercase; color: black;'  required>
      
               <label>Gramos bolsa:</label>
               <input type="number" name="gramos_muestra" id="gramos_muestra" class="input-group-addon" style='font-size: 20px; width:15%; text-transform: uppercase; color: black;' required>
          
               <label>Stock Suelto:</label>
               <input type="number" name="stock_suelto" id="stock_suelto" class="input-group-addon" style='font-size: 20px; width:15%; text-transform: uppercase; color: black;' required>
          </div>
          
          
                          <div class="form-group">
                          <label></label>
                          <input type="hidden" name="codigo_suelto" id="codigo_suelto" class="form-control">                    
                          <input type="hidden" name="gramos_total" id="gramos_total" class="form-control">
                          </div>
                          <div class="form-group col-lg-6">
                          <label>Importe Cliente</label>
                          <input type="number" name="importe_suelto" id="importe_suelto" value="0"  class="form-control" style='font-size: 20px; width:75%; text-transform: uppercase; color: red;' onkeyup="if(event.keyCode ==13) calcularGramos();"> <!-- <button type="button" class="btn btn-outline-secondary" onclick="calcular_interes();">Calcular</button>-->
                          </div>
                          <div class="form-group col-lg-6">
                          <label>Descuento:</label>
                          <input type="number" name="descuento_suelto" value="0" id="descuento_suelto" class="form-control"  style='font-size: 20px; width:75%; text-transform: uppercase; color: black;' required>
                          </div>
                          <div class="form-group col-lg-6">
                            <label>Gramos Cliente</label>
                          <input type="number" name="total_gramos" id="total_gramos" value="0"  class="form-control" style='font-size: 20px; width:75%; text-transform: uppercase; color: red;'> <!-- <button type="button" class="btn btn-outline-secondary" onclick="calcular_interes();">Calcular</button>-->
                          </div>
                          <div class="form-group col-lg-6">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                          <button type="button" class="btn btn-primary" onclick="insertar_carrito_suelto();" data-dismiss="modal" >Agregar al Carrito</button>
                          </div>                 
                          
      </div>
      
      <div class="modal-footer ">
      
      </div>
    </div>
  </div>
</div>
<!--Modal Cobrar -->
<div class="modal" tabindex="-1" id="modal-cobrar" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Cobrar Carrito</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>

          <div class="card-header text-center bg-blue ">
                          <div class="form-group">
                            <div class="form-check form-switch">
                              <input class="form-check-input" type="checkbox" id="checkN" checked onchange="comprobarN();">
                              <label class="form-check-label" for="flexSwitchCheckDefault">Fact. Comun</label>
                            </div>
                              <div class="form-check form-switch">
                              <input class="form-check-input" type="checkbox" id="checkB" onchange="comprobarB();">
                              <label class="form-check-label" for="flexSwitchCheckDefault">Fact. Electronica B</label>
                              </div>
                              <div class="form-check form-switch">
                              <input class="form-check-input" type="checkbox" id="checkA" onchange="comprobarA();" >
                              <label class="form-check-label" for="flexSwitchCheckChecked">Fact. Electronica A</label>
                            </div>   
                            <label>CUIT</label>
                            <input readonly="readonly" type="number" placeholder="CUIT o DNI" class="form-control" name="cuit" value="" id="cuit" style='font-size: 20px; text-transform: uppercase; color: blue;' spa required>
                          </div> 
                          <div class="form-group">
                            <label>Total Carrito</label>
                            <input readonly="readonly" type="number" class="form-control" name="total_input" value="0" id="total_input" style='font-size: 20px; text-transform: uppercase; color: green;' required>
                          </div>
                          <div class="form-group">
                            <label>Importe</label>
                            <input type="number" id="importe" class="form-control" value="0" style='font-size: 20px; text-transform: uppercase; color: black;' onkeyup="if(event.keyCode ==13) calcular_cambio();" required>
                          </div>
                          <div class="form-group">
                            <label>Cambio</label>
                            <input type="number" id="cambio" class="form-control" value="0" style='font-size: 20px; text-transform: uppercase; color: red;'required>
                          </div>
                          <div class="input-group">
                          <span class="input-group-text">Observacion</span>
                          <textarea class="form-control" id="observacion" aria-label="Observacion"></textarea>
                        </div>
                          <div class="form-group">
                          <label>Tipo factura</label>
                          <select name="impresion" class="form-control" id="impresion" style='font-size: 15px; width:100%; text-transform: uppercase; color: black;'>
                                <option value="Orizontal-A4">Orizontal-A4</option>
                                <option value="Ticket_comun">Ticket Comun</option>      
                                <option value="Ticket_B">Ticket "B"</option>
                                <option value="Factura_A">factura "A"</option>
                                <option value="Factura_B">factura "B"</option>
                          </select>
                          </div>
                          <div class="form-group">
                          <label>CAJA</label>
                                    <select class="form-control" name="caja" id="caja" style='font-size: 15px; width:100%; text-transform: uppercase; color: black;'>
                                                  <?php
                                                        //traer sedes
                                                        include "../conexion.php";
                                                    $query = mysqli_query($conexion, "SELECT * FROM supercaja where estado=0 ");
                                                     
                                                    while($row = mysqli_fetch_assoc($query))
                                                    {
	                                                
                                                    $nom_caja = $row['nombreCaja'];
                                                    $idcaja = $row['idsuperCaja'];
													                        ?>
													
                                                    <option value="<?php echo $idcaja; ?>"><?php echo $nom_caja; ?></option>  

                                                    <?php
                                                     }
                                                    
                                                     ?>
								                      </select>
                           </div>            
                          <!-- Medio de Pago -->
                          <!--<div class="form-group">  
                            
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="efectivo">
                              <label class="form-check-label" for="inlineCheckbox1">Efectivo</label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="Debito">
                              <label class="form-check-label" for="inlineCheckbox2">Debito</label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="Credito">
                              <label class="form-check-label" for="inlineCheckbox3">Credito</label>
                            </div>                                            

                          </div>-->

                          <div class="form-group">
                          <button  type="button" class="btn btn-primary"  onclick="cobrar_venta();" data-dismiss="modal">Cobrar</button>
                          <button type="button" class="btn btn-info" onclick="limpiar_modal_compra();" data-dismiss="modal">Cancelar</button>
                          </div>                           
           </div>
        
      </div>
      <div class="modal-body">
        
      </div>
    </div>
  </div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="lista_venta">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Facturas Ventas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <input class="form-control col-md-3 light-table-filter" id="buscar" data-table="order-table" type="text" placeholder="N°Factura" onkeypress="listaFactura()"><br>
      <table class="table table-bordered order-table ">
      <div id="mostrar_factura"></div>
      </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>
 <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
 <script src="http://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
 <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
 <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  
  <script>
  $('#buscador').select2();  
  $('#buscador_cliente').select2();  
  
  </script>
  
  <script type="text/javascript">
  function comprobarA()
{   
    if (document.getElementById("checkA").checked)
      document.getElementById('cuit').readOnly = false;
      
    else
      document.getElementById('cuit').readOnly = true;
      document.getElementById('checkB').checked = false;
      document.getElementById('checkN').checked = false;
      document.getElementById("impresion").value="Factura_A";
        
}

function comprobarB()
{   
    if (document.getElementById("checkB").checked)
      document.getElementById('cuit').readOnly = true;
      document.getElementById('checkA').checked = false;
      document.getElementById('checkN').checked = false;
      document.getElementById('cuit').value="";
      document.getElementById("impresion").value="Factura_B";
}

function comprobarN()
{   
    if (document.getElementById("checkN").checked)
      document.getElementById('cuit').readOnly = true;
      document.getElementById('checkA').checked = false;
      document.getElementById('checkB').checked = false;
      document.getElementById('cuit').value="";
      document.getElementById("impresion").value="Orizontal-A4";
}

  //input alert
  let interes1=0
  function interes(){
    var medio=document.getElementById("mediodePago").value;
    if(medio =="Tarjeta de Credito"){
      interes1 = prompt('Ingrese el Interes');
      //let resul = confirm('Estas Seguro?'); //result boleano
      //console.log(interes1);
      document.getElementById("interes").value=interes1;
      
    }
    
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
//lista de facturas    
function listaFactura()
    { 
      
      buscar = document.getElementById('buscar').value;
      idlocal = $("#idlocal").val();
      var parametros = 
      {
        "buscar_factura" : buscar,
        "idlocal" : idlocal,
        "accion" : "4"
        
        
      };

      $.ajax({
        data: parametros,
        url: 'tabla_venta.php',
        type: 'POST',
        
        beforesend: function()
        {
          $('#mostrar_factura').html("Mensaje antes de Enviar");
        },

        success: function(mensaje)
        {
          $('#mostrar_factura').html(mensaje);
          
        }
      });
    }
//cobrar carrito
function cobrar_venta()
  {

    idusuario = $("#idusuario").val();
    idlocal = $("#idlocal").val();
    idcliente = $("#idcliente").val();
    tipoFactura = $("#impresion").val();
    total_input = $("#total_input").val();
    cambio = $("#cambio").val();
    numero_factura = $("#numero_factura").val();
    importe = $("#importe").val();
    impresion = $("#impresion").val();
    observacion = $("#observacion").val();
    vendedor = $("#vendedor").val();
    idcaja = $("#caja").val();
    var parametros = 
    {
      "cobrar_carrito_venta": "1",
      "idusuario" : idusuario,
      "idcliente" : idcliente,
       "idlocal" : idlocal,
       "tipoFactura" : tipoFactura,
       "total_input" : total_input,
       "cambio" : cambio,
       "numero_factura" : numero_factura,
       "importe" : importe,
       "impresion" : impresion,
       "observacion" : observacion,
       "idcaja" : idcaja,
       "vendedor" : vendedor

    };
    $.ajax(
    {
      data:  parametros,
      url:   'datos_producto.php',
      type:  'post',
     
      error: function()
      {alert("Error");},
      
      success:  function (mensaje) 
      {
        
        if(total_input==0){

        }else{
        $('#mostrar_carrito').html(mensaje);

        if(impresion=="Ticket_B"){
        url = 'pdf/ticket_B.php?factura=' + factura;
        window.open(url, '_blank')
        location.href="nueva_venta.php";
        //limpiar();
        tablacarrito_venta();
        }

        if(impresion=="Ticket_comun"){
        url = 'pdf/ticket_pg.php?factura=' + factura + '&local=' + idlocal + '&cliente=' +idcliente;
        window.open(url, '_blank')
        location.href="nueva_venta.php";
        //limpiar();
        tablacarrito_venta();
        }
        
        if(impresion=="Factura_B"){
        url = 'pdf/factura_B.php?factura=' + factura;
        window.open(url, '_blank')
        location.href="nueva_venta.php";
        //limpiar();
        tablacarrito_venta();
        }
        
        if(impresion=="Factura_A"){
          url = 'pdf/factura_A.php?factura=' + factura;
          window.open(url, '_blank')
          location.href="nueva_venta.php";
          //limpiar();
          tablacarrito_venta();
          
        }if(impresion=="Orizontal-A4"){
          url = 'pdf/ticket.php?factura=' + factura + '&local=' + idlocal + '&cliente=' +idcliente;
          window.open(url, '_blank')
          location.href="nueva_venta.php";
          tablacarrito_venta();

        }
         
        
        }
        
      }
      
    }) 
    
  }

    //limpiar modal cambio
      function limpiar_modal_compra(){
        $("#importe").val(0);
        $("#cambio").val(0);
      }
      //calcular cambio
      function calcular_cambio()
  {
    
    var totalM = parseFloat($('#total_input').val());
    var importe = parseFloat($('#importe').val());
    var cambio = importe - totalM;
    $.ajax({
       
       beforesend: function()
       {
         alert("Error");
       },

       success: function()
       {
         
         $("#cambio").val(cambio);
       }
     });

    

  }
     //calcular gramos por clientes
  function calcularGramos()
  {
    
    
    var precio_suelto = parseFloat($('#precio_suelto').val());
    var gramos = parseFloat($('#gramos_total').val());
    var importe_suelto = parseFloat($('#importe_suelto').val());
    

    //con funcion para redondear
    ;

    if(importe_suelto == precio_suelto){

      var resultado = (1000 / precio_suelto);
      var gramos_cliente = Math.round(resultado * importe_suelto);
      var gramos_restante = Math.round(gramos - gramos_cliente);
    }

    if(importe_suelto > precio_suelto){

      var resultado = (1000 / precio_suelto);
      var gramos_cliente = Math.round(resultado * importe_suelto);
      var gramos_restante = Math.round(gramos - gramos_cliente);

    }

    if(importe_suelto < precio_suelto){

    var resultado = (1000 / precio_suelto);
    var gramos_cliente = Math.round(resultado * importe_suelto);
    var gramos_restante = Math.round(gramos - gramos_cliente);

    }

    $.ajax({
       
       beforesend: function()
       {
         alert("Error");
       },

       success: function()
       {
         
         $("#total_gramos").val(gramos_cliente);
         $("#gramos_muestra").val(gramos_restante);
         //alert(resultado);
       }
     });
  }

    //datos clientes
    function listaClientes(id)
    { 
      //alert(id);
      //buscar = document.getElementById('cliente').value;
      var parametros = 
      {
        "mi_busqueda_clientes" : id,
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

  //auto completado input
$(document).ready(function () {
    $("#buscador_cliente").keyup(function () {
       
        var query = $("#buscador_cliente").val();
  
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
    idlocal = $("#idlocal").val();
    
    var parametros = 
    {
      "buscar_producto": "1",
      "codigo" : codigo,
      "idlocal" : idlocal
     
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

  //buscar datos suelto
  function buscar_datos_suelto() 
  {
    codigo = $("#codigo_suelto").val();
  
    
    var parametros = 
    {
    "codigo" : codigo,
    "buscar_producto_suelto": "1"
      
      
      
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
        $("#gramos_muestra").val(valores.gramos_fijos);
        $("#precio_suelto").val(valores.precio_suelto);
        $("#stock_suelto").val(valores.stock_suelto);
        $("#gramos_total").val(valores.gramos);
        //$("#mi_precio").val(valores.mi_precio);
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
    total = $("#totalC").val();
   
    var parametros = 
    {
      "insertar_cuenta": "1",
       "fecha" : fecha,
       "fecha_vencimiento" : fecha_vencimiento,
       "numero_factura" : numero_factura,
       "idcliente" : idcliente,
       "total" : total
       
       
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

//buscar datos del cliente segun cmb
function ShowSelected_cliente()
{
/* Para obtener el valor */
var id = document.getElementById("buscador_cliente").value;
//alert(id);
listaClientes(id);
}

//suelto
function ShowSelected2()
{
/* Para obtener el valor */
var cod = document.getElementById("buscador2").value;
$('#codigo_suelto').val(cod);
//alert(cod);
buscar_datos_suelto();
}

//carrito de compra
function insertar_carrito_venta()
  {
    
    idcliente = $("#idcliente").val();
    idproducto = $("#idproducto").val();
    idusuario = $("#idusuario").val();
    idlocal = $("#idlocal").val();
    idcaja = $("#caja").val();
    numero_factura = $("#numero_factura").val();
    idvendedor = $("#vendedor").val();
    //fecha = $("#fecha").val();
    //fecha_vencimiento = $("#fecha_vencimiento").val();
    cantidad = $("#cantidad").val();
    mi_precio = $("#mi_precio").val();
    precio_menor = $("#precio_menor").val();
    precio_mayor = $("#precio_mayor").val();
    tipo = $("#tipo").val();
    descuento = $("#descuento").val();
    interes = $("#interes").val();
    stock = $("#stock").val();  
    total_gramos =  $("#total_gramos").val();
    gramos_muestra =  $("#gramos_muestra").val();
    var parametros = 
    {
      "carrito_cuenta_venta": "1",
       "idcliente" : idcliente,
       "idproducto" : idproducto,
       "idusuario" : idusuario,
       "idlocal" : idlocal,
       "idcaja" : idcaja,
       //"fecha" : fecha,
       //"fecha_vencimiento" : fecha_vencimiento,
       "cantidad" : cantidad,
       "mi_precio" : mi_precio,
       "precio_menor" : precio_menor,
       "precio_mayor" : precio_mayor,
       "tipo" : tipo,
       "descuento" : descuento,
       "interes" : interes,
       "numero_factura" : numero_factura,
       "idvendedor" : idvendedor,
       "stock" : stock,
       "total_gramos" : total_gramos,
       "gramos_muestra" : gramos_muestra,
       "mediodePago" : $("#mediodePago").val()
       
       
    };
    $.ajax(
    {
      data:  parametros,
      url:   'datos_producto.php',
      type:  'post',
     
      error: function()
      {alert("Error evento");},
      
      success:  function (mensaje) 
      {
        $('#mostrar_mensaje').html(mensaje);
        //document.getElementById("interes").value
        document.getElementById("interes").value=0;
        
        tablacarrito_venta();
        
      }
      
    }) 
    
  }
     //insertar suelto en carrito
  function insertar_carrito_suelto()
  {
    
    idcliente = $("#idcliente").val();
    idproducto = $("#idproducto").val();
    idusuario = $("#idusuario").val();
    idlocal = $("#idlocal").val();
    numero_factura = $("#numero_factura").val();;
    cantidad = $("#cantidad").val();
    descuento_suelto = $("#descuento_suelto").val();
    stock_suelto = $("#stock_suelto").val();  
    total_gramos =  $("#total_gramos").val();
    gramos_muestra =  $("#gramos_muestra").val();
    
    var parametros = 
    {
      "carrito_cuenta_suelto": "1",
       "idcliente" : idcliente,
       "idproducto" : idproducto,
       "idusuario" : idusuario,
       "idlocal" : idlocal,
       "cantidad" : cantidad,
       "descuento_suelto" : descuento_suelto,
       "numero_factura" : numero_factura,
       "stock_suelto" : stock_suelto,
       "total_gramos" : total_gramos,
       "gramos_muestra" : gramos_muestra,
       "importe_suelto" : $("#importe_suelto").val(),
       "mediodePago" : $("#mediodePago").val()
       
       
    };
    $.ajax(
    {
      data:  parametros,
      url:   'datos_producto.php',
      type:  'post',
     
      error: function()
      {alert("Error evento");},
      
      success:  function (mensaje) 
      {
        $('#mostrar_mensaje').html(mensaje);
        tablacarrito_venta();
        $("#modal-suelto").modal("hide");
      }
      
    }) 
    
  }
    //tabla carrito de venta
    function tablacarrito_venta()
    { 
      
      factura =  $("#numero_factura").val();
      idcliente = $("#idcliente").val();
      idlocal = $("#idlocal").val();
      var parametros = 
      {
        "mostrar_tabla_carrito" : 1,
        "numero_factura" : factura,
        "idcliente" : idcliente,
        "idlocal" : idlocal,
        "accion" : "4"
        
        
      };

      $.ajax({
        data: parametros,
        url: 'tablas.php',
        type: 'POST',
        
        beforesend: function()
        {
          $('#mostrar_ventas').html("Mensaje antes de Enviar");
        },

        success: function(mensaje)
        {
          $('#mostrar_ventas').html(mensaje);
          $("#descuento").val("0");
          $("#interes").val("0");
          document.getElementById("total_input").value = document.getElementById("totalC").value;
          //limpiar();
         

        }
      });
    }
</script>
  <?php include_once "includes/footer.php"; ?>
