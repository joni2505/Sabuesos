<?php
	require("../conexion.php");
$var = 0;

   //lista de clientes modal
   if(isset($_POST['lista_clientes']))
   {
 
     echo 
     '   
       <h5><center>Lista Cliantela</center></h5>    
       <table id="tablaClientes" class="table table-bordered order-table ">
       <thead class="thead-dark">
         <tr bgcolor="">
           <th scope="col">#</th>
           <th scope="col">Nombre</th>
           <th scope="col">Direccion</th>
           <th scope="col">Celular</th>
         </tr>
         </thead>  
     ';
     $buscar = $_POST['buscar'];
    
 
       $resultados = mysqli_query($conexion,"SELECT * FROM cliente WHERE nombre LIKE '%$buscar%' limit 50 ");
       
     
     while($consulta = mysqli_fetch_array($resultados))
       {
             echo "<tr style='cursor:pointer;'>";
             echo "<td>" . $consulta['idcliente'] . "</td>";
             echo "<td>" . $consulta['nombre'] . "</td>";
            
             echo "<td>" . $consulta['direccion'] . "</td>";
             echo "<td>" . $consulta['celular'] . "</td>";
             //echo "<td><a href='inscripcion.php?id=".$consulta['idalumno']."'><i class='fas fa-trash-alt'></i></a></td>";
             //echo "<td><a href='javascript: prueba();'> <img src='.' alt='Seleccionar'></a></td>";
             //echo "<td><input type='button' value='Seleccionar' class='btn btn-primary' name='btn_inscribir' onclick='prueba();'></td>";
             echo "</tr>";
     }
     
     
 
             
   }

  //buscar suelto
  if(isset($_POST['lista_suelto']))
	{
 
    echo 
    '   
      <h5><center>Lista</center></h5>    
      <table id="tablaSuelto" class="table table-hover">
      <thead class="thead-dark">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Codigo</th>
          <th scope="col">Producto</th>
          <th scope="col">Precio x 1kg</th>
          <th scope="col">Stock Suelto</th>
          <th scope="col">kg</th>
          <th scope="col">Gramos</th>
          <th scope="col">Precio Suelto</th>
        </tr>
        </thead>  
    ';
      $suelto = $_POST['lista_suelto'];
      $resultados = mysqli_query($conexion,"SELECT * FROM producto WHERE nombre_producto LIKE '%$suelto%' and suelto='1' ");
      
    $i=1;
    while($consulta = mysqli_fetch_array($resultados))
	    {
            echo "<tr>";
            echo "<td>" . $consulta['idproducto'] . "</td>";
            echo "<td>" . $consulta['codigo_producto'] . "</td>";
            $consulta['idproducto'];
            $suelto = $consulta['nombre_producto'];
            echo "<td>" . $consulta['nombre_producto'] . "</td>";
            echo "<td>" . $consulta['precio_suelto'] . "</td>";
            echo "<td>" . $consulta['stock_suelto'] . "</td>";
            echo "<td>" . $consulta['kg'] . "</td>";
            $gramos = $consulta['gramos'];
            echo "<td>" . $consulta['gramos'] . "</td>";
            //echo "<td> <input type='text' name='codigo' id='codigo' class='form-control' value='$gramos'> </td>";                                      

            echo "<td>" . $consulta['precio_suelto'] . "</td>";
            //echo "<td><button type='button' class='btn btn-danger'  type='button' onclick='eliminar_suelto(${consulta['idsuelto']});'><i class='fas fa-trash-alt'></i></button>";

            echo "</tr>";
    $i++;        
	  }	  
                    
  }

  //tbl producto sueltos
  if(isset($_POST['tabla_suelto']))
	{
 
    echo 
    '   
      <h5><center>Lista</center></h5>    
      <table class="table table-bordered order-table" id="tblsuelto">
      <thead class="thead-dark">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Producto</th>
          <th scope="col">Stock suelto</th>
          <th scope="col">KG</th>
          <th scope="col">Gramos</th>
          <th scope="col">Precio</th>
        </tr>
        </thead>  
    ';
     $id_local = $_POST['idlocal'];
      $resultados = mysqli_query($conexion,"SELECT * FROM producto where suelto=1 and idlocal='$id_local' ");
      
    $i=1;
    while($consulta = mysqli_fetch_array($resultados))
	    {
            echo "<tr>";
            echo "<td>" . $i . "</td>";
            $consulta['idproducto'];
            $suelto = $consulta['nombre_producto'];
            echo "<td>" . $consulta['nombre_producto'] . "</td>";
            echo "<td>" . $consulta['stock_suelto'] . "</td>";
            echo "<td>" . $consulta['kg'] . "</td>";
            $gramos = $consulta['gramos'];
            //echo "<td width='60'>" . $consulta['gramos'] . "</td>";
            echo "<td>" . $consulta['gramos'] . "</td>";                                      

            echo "<td>" . $consulta['precio_suelto'] . "</td>";
            echo "<td><button type='button' class='btn btn-susses'  type='button' onclick='eliminar_suelto();'><i class='fas fa-edit'></i></button>";

            echo "</tr>";
    $i++;        
	  }	  
                    
  }

   //cmb lista de marcas segun rubros
  if(isset($_POST['lista_marcas']))
	{
    $rubro=$_POST['idrubro'];

    

      //$resultados = mysqli_query($conexion,"SELECT * FROM marcas WHERE idrubro='$idrubro'");
      echo "
      <div class='form-group'>
      <label for='rubro'>Lista de Marcas</label>
      <select name='idmarca1' class='form-control' id='idmarca1' style='width:40%;'>
 <option value='vacio'>Select Marca</option>";


                       
                                 $query = mysqli_query($conexion, "SELECT * FROM marcas LEFT JOIN rubro on marcas.idrubro=rubro.idrubro WHERE rubro.nombre_rubro='$rubro'");
                                 $result = mysqli_num_rows($query);
                                 
                                 while($row = mysqli_fetch_assoc($query))
                                 {
                               //$idrol = $row['idrol'];
                                 $marca = $row['nombre_marca'];
                                 $idmarca = $row['idmarca'];

                                 
       
                                 echo "<option value='$marca'> $marca </option>";  

                            
                                  }
                                 
                                
echo "</select>
</div> ";
                    
  }

  //tabla lista de productos pdf
  if(isset($_POST['tabla_lista']))
	{
 
    echo 
    '   
      <h5><center>Lista</center></h5>    
      <table id="tablaClientes" class="table table-hover">
      <thead class="thead-dark">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Rubros</th>
          <th scope="col">Marcas</th>
      
        </tr>
        </thead>  
    ';

      $resultados = mysqli_query($conexion,"SELECT * FROM lista LIMIT 5");
      
    $i=1;
    while($consulta = mysqli_fetch_array($resultados))
	    {
            echo "<tr>";
            echo "<td>" . $i . "</td>";
            echo "<td>" . $consulta['rubro'] . "</td>";
            echo "<td>" . $consulta['marca'] . "</td>";
            echo "</tr>";
    $i++;        
	  }	  
    echo "<button type='button' class='btn btn-warning'' onclick='imprimirTabla();'> <i class='fa fa-print' aria-hidden='true'></i>Imprimir Lista</button>";
    echo "<button type='button' class='btn btn-danger'' onclick='eliminarLista();'> <i class='fas fa-trash-alt' aria-hidden='true'></i>Eliminar Lista</button>";
                    
  }

  if(isset($_POST['mi_busqueda_clientes']))
	{
    
    /*echo 
    '   
      <h5><center>Lista Detallada</center></h5>    
      <table id="tablaClientes" class="table table-hover">
      <thead class="thead-dark">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Nombre</th>
          <th scope="col">Direccion</th>
          <th scope="col">Celular</th>
        </tr>
        </thead>  
    ';*/
    $mi_busqueda_clientes = $_POST['mi_busqueda_clientes'];
   

      //$resultados = mysqli_query($conexion,"SELECT * FROM cliente WHERE nombre LIKE '%$mi_busqueda_clientes%' LIMIT 1");
      $resultados = mysqli_query($conexion,"SELECT * FROM cliente WHERE idcliente = $mi_busqueda_clientes LIMIT 1");

    
    while($consulta = mysqli_fetch_array($resultados))
	    {
        echo "<h6>"."Cliente: ". $consulta['nombre'] . "</h6>";
        echo "<h6>"."Celular: ". $consulta['celular'] . "</h6>";
        echo "<h6>"."Direccion: " . $consulta['direccion'] . "</h6>";
        //obtener idcliente
        $idclt=$consulta['idcliente'];
        echo "<input type='hidden' name='idcliente' id='idcliente' class='form-control' value='$idclt'>"; 
        
            /*echo "<tr>";
            echo "<td>" . $consulta['idcliente'] . "</td>";
            echo "<td>" . $consulta['nombre'] . "</td>";
           
            echo "<td>" . $consulta['direccion'] . "</td>";
            echo "<td>" . $consulta['celular'] . "</td>";
            //echo "<td><a href='inscripcion.php?id=".$consulta['idalumno']."'><i class='fas fa-trash-alt'></i></a></td>";
            //echo "<td><a href='javascript: prueba();'> <img src='.' alt='Seleccionar'></a></td>";
            //echo "<td><input type='button' value='Seleccionar' class='btn btn-primary' name='btn_inscribir' onclick='prueba();'></td>";
            echo "</tr>";*/
	  }	

            
  }

  if(isset($_POST['mi_busqueda_producto']))
	{
    
    echo 
    '   
      <h5><center>Lista Detallada</center></h5>    
      <table id="tablaProducto" class="table table-hover" >
        <tr bgcolor="#ADD8E6">
          <th scope="col">#</th>
          <th scope="col">Codigo</th>
          <th scope="col">Producto</th>
          <th scope="col">Precio</th>
          <th scope="col">precio x menor</th>
          <th scope="col">precio x mayor</th>
          <th scope="col">stock</th>
          <th scope="col">Unidad</th>
       
        </tr>
          
    ';
    $mi_busqueda_producto = $_POST['mi_busqueda_producto'];
   

      $resultados = mysqli_query($conexion,"SELECT * FROM producto WHERE nombre_producto LIKE '%$mi_busqueda_producto%' LIMIT 5");
      
    
    while($consulta = mysqli_fetch_array($resultados))
	    {
            echo "<tr>";
            echo "<td>" . $consulta['idproducto'] . "</td>";
            echo "<td>" . $consulta['codigo_producto'] . "</td>";
            echo "<td>" . $consulta['nombre_producto'] . "</td>";
            echo "<td>" . $consulta['mi_precio'] . "</td>";
            echo "<td bgcolor='#F0E68C'>" . $consulta['precio_producto'] . "</td>";
            echo "<td bgcolor='#FAFAD2'>" . $consulta['precio_mayor'] . "</td>";

            if($consulta['stock_producto'] <= 0){

              echo "<td bgcolor='#F08080'>" . $consulta['stock_producto'] . "</td>";
            }else{

              echo "<td bgcolor='#90EE90'>" . $consulta['stock_producto'] . "</td>";


            }
            echo "<td>" . $consulta['unidad_producto'] . "</td>";
            //echo "<td>" . <img width='100' src='data:image/jpeg/jpg/png;base64, base64_encode($data['imagen']); . "</td>";
            //echo "<td><a href='inscripcion.php?id=".$consulta['idalumno']."'><i class='fas fa-trash-alt'></i></a></td>";
            //echo "<td><a href='javascript: prueba();'> <img src='.' alt='Seleccionar'></a></td>";
            //echo "<td><img width='100' src='data:image/jpeg/jpg/png;base64'></td>;
            

            echo "</tr>";
	  }	

            
  }

  if(isset($_POST['mostrar_tabla_carrito']))
	{
    
    echo 
    '   
      <h5><center>Lista Detallada</center></h5>    
      <table id="tablaVentas" class="table table-hover">
      <thead class="thead-dark">
        <tr>
          <th scope="col">#</th>
          
          <th scope="col">Codigo</th>
          <th scope="col">Producto</th>
          <th scope="col">Precio/Imp</th>
          <th scope="col">Gramos</th>
          <th scope="col">Cantidad</th>
          <th scope="col">Des.%</th>
          <th scope="col">Int.%</th>
          <th scope="col">Precio Final</th>
          <th scope="col">Total</th>
          <th scope="col">M.D.P.</th>
        </tr>
        </thead>  
          
    ';

      $numFactura = $_POST['numero_factura'];
      $idcliente = $_POST['idcliente'];
      $idlocal = $_POST['idlocal'];
      //$apellido = $_POST['apellido'];
      //traer id Cliente
      /*$rs = mysqli_query($conexion, "SELECT idcliente FROM cliente WHERE nombre ='$nombre'");
      while($row = mysqli_fetch_array($rs))
      {
       $idcliente=$row['idcliente'];
   
      }*/
      $resultados = mysqli_query($conexion,"SELECT ventas.idproducto, idventa,numero_factura, producto.codigo_producto'codigo', producto.nombre_producto'producto', subtotal, ventas.cantidad, ventas.descuento, ventas.interes, ventas.total_venta, ventas.mediodepago, ventas.preciofinal, ventas.gramos FROM ventas
      INNER JOIN producto on ventas.idproducto=producto.idproducto WHERE numero_factura='$numFactura' and idcliente='$idcliente' and ventas.idlocal='$idlocal' ");
      
    $contador=0;
    $num=0;
    $i=1;
    while($consulta = mysqli_fetch_array($resultados))
	    {
            echo "<tr>";
            $consulta['idproducto'];
            //$consulta['idventa'];
            echo "<td style='color:#FFFFFF'>".$consulta['idventa']."</td>";
            //echo "<td>" . $consulta['numero_factura'] . "</td>";
            $num = $consulta['numero_factura'];
            echo "<td>" . $consulta['codigo'] . "</td>";
            echo "<td>" . $consulta['producto'] . "</td>";
            echo "<td>" . $consulta['subtotal'] . "</td>";
            echo "<td>" . $consulta['gramos'] . "</td>";
            echo "<td>" . $consulta['cantidad'] . "</td>";
            echo "<td>" . $consulta['descuento'] . "</td>";
            echo "<td>" . $consulta['interes'] . "</td>";
            echo "<td>" . $consulta['preciofinal'] . "</td>";
            echo "<td>" . $consulta['total_venta'] . "</td>";
            echo "<td>" . $consulta['mediodepago'] . "</td>";
            echo "<td><button type='button' class='btn btn-danger'  type='button' onclick='eliminar_pro(${consulta['idventa']});'><i class='fas fa-trash-alt'></i></button>";
            echo "<td><button type='button' class='btn btn-success'  type='button' onclick='preguntar(${consulta['idventa']});'><i class='fas fa-edit'></i></button>";

            //echo "<td><a href='inscripcion.php?id=".$consulta['idalumno']."'><i class='fas fa-trash-alt'></i></a></td>";
            //echo "<td><a href='javascript: prueba();'> <img src='.' alt='Seleccionar'></a></td>";
            //echo "<td><input type='button' value='Seleccionar' class='btn btn-primary' name='btn_inscribir' onclick='prueba();'></td>";
            echo "</tr>";
            $i++;
	  }	
    
    
    $Sumcan=0;
    $CanVen=0;
    $totalProductos=0;
    $resultados = mysqli_query($conexion,"SELECT COUNT(idventa)'cantventa', SUM(cantidad)'sumcantidad' FROM ventas WHERE numero_factura = '$num' and ventas.idlocal=$idlocal and ventas.idcliente=$idcliente ");
    while($consulta = mysqli_fetch_array($resultados))
	    {
        $CanVen = $consulta['cantventa'];
        $CanVen = $consulta['sumcantidad'];
        $totalProductos = $Sumcan + $CanVen;

      }
      echo "<h5>Total de Bultos: $totalProductos </h5>";
      echo "
      <input type='hidden' id='bultos2' value='$totalProductos'>";
      echo "<tfoot>";
      $resultados = mysqli_query($conexion,"SELECT SUM(total_venta)'total' FROM ventas where numero_factura='$numFactura' and ventas.idlocal=$idlocal and ventas.idcliente=$idcliente");
        while($consulta = mysqli_fetch_array($resultados))
       {
         $total = $consulta['total'];        
      echo"<tfoot>
                    <tr class='font-weight-bold'>
                        <td colspan=3>TOTAL CARRITO $
                        <input type='number' name='total' id='totalC' class='form-control' value='$total' style='font-size: 20px; width:60%; text-transform: uppercase; color: black;'> </td>
                        <td></td>
                    </tr> ";

      echo "</tfoot>";
             
       }
       
  }

     //tbl cuenta
if(isset($_POST['buscar_cuenta']))
{
  
  echo 
  '   
    <h5><center>Lista Detallada</center></h5>    
    <table id="tablaCuenta" class="table table-hover">
   
      <tr class="thead-dark">
      <th scope="col">ID</th>
        <th scope="col">N°Factura</th>
        <th scope="col">Fecha</th>
        <th scope="col">Pago</th>
        <th scope="col">Importe</th>
        <th scope="col">Saldo</th>
        
        <th scope="col">Total Cuenta</th>
        <th scope="col">Condicion</th>
      </tr>
     
  ';
  
   $buscar_cuenta = $_POST['buscar_cuenta'];
 

    $resultados = mysqli_query($conexion,"SELECT date_format(fecha, '%d-%m-%Y')'fecha', idcuota, numero_factura, cuota, importe, saldo, total, condicion FROM cuotas WHERE numero_factura  LIKE '%$buscar_cuenta%'");
    
  
  while($consulta = mysqli_fetch_array($resultados))
    {
          echo "<tr>";
          echo "<td>" . $consulta['idcuota'] . "</td>";
          echo "<td>" . $consulta['numero_factura'] . "</td>";
    
          echo "<td>" . $consulta['fecha'] . "</td>";
          echo "<td>" . $consulta['cuota'] . "</td>";
          echo "<td >" . $consulta['importe'] . "</td>";
          echo "<td>" . $consulta['saldo'] . "</td>";
          //echo "<td>" . $consulta['descuento'] . "</td>";
          echo "<td>" . $consulta['total'] . "</td>";
          if($consulta['condicion']=="IMPAGA"){

            echo "<td bgcolor='#F08080'>" . $consulta['condicion'] . "</td>";

          }else if($consulta['condicion']=="PAGADO"){

            echo "<td bgcolor='#FFFACD'>" . $consulta['condicion'] . "</td>";

          } else if($consulta['saldo']==0 AND $consulta['condicion']=="IMPAGA" ){

            echo "<td bgcolor='#FFFACD'>" . $consulta['condicion'] . "</td>";

          } else if($consulta['saldo']==0 AND $consulta['condicion']=="CANCELADO"){
          
            echo "<td bgcolor='#90EE90'>" . $consulta['condicion'] . "</td>";
              
          }
          
          echo "<td><button type='button' class='btn btn-danger'  type='button' onclick='eliminar_cuota(${consulta['idcuota']});'><i class='fas fa-trash-alt'></i></button>";
          echo "<td><a href='pdf/cuota_pdf.php?idcuota=".$consulta['idcuota']."'target='_blank''><i class='fa fa-print' aria-hidden='true'></i></a></td>";

          //echo "<td><a href='inscripcion.php?id=".$consulta['idalumno']."'><i class='fas fa-trash-alt'></i></a></td>";
          //echo "<td><a href='javascript: prueba();'> <img src='.' alt='Seleccionar'></a></td>";
          //echo "<td><input type='button' value='Seleccionar' class='btn btn-primary' name='btn_inscribir' onclick='prueba();'></td>";
          echo "</tr>";
  }	


 

          
}

?>
<script type="text/javascript">
  //eliminar para editar suelto
function eliminar_suelto(){
  

  $('#tblsuelto tr').on('click', function(){
  var dato1 = $(this).find('td:first').html();
  var producto = $(this).find('td:nth-child(2)').html();
  var stock = $(this).find('td:nth-child(3)').html();
  var kg = $(this).find('td:nth-child(4)').html();
  var gramos = $(this).find('td:nth-child(5)').html();
  var precio = $(this).find('td:nth-child(6)').html();
  $('#producto').val(producto);
  $('#kg').val(kg);
  $('#gramos').val(gramos);
  $('#precio3').val(precio);
  $('#stock3').val(stock);
  editar_suelto(producto);
});
}
//elimanar de bd suelto
function editar_suelto(producto)
  {
  idlocal = $("#idlocal").val();
  producto = $("#producto").val();
  kg = $("#kg").val();
  gramos = $("#gramos").val();
  gramosFijos = $("#gramos").val();
  precio = $("#precio3").val();
  stock = $("#stock3").val();
  
  var parametros = 
  {
  "editarSuelto": "1",
  "producto" : producto,
  "kg" : kg,
  "gramos" : gramos,
  "gramosFijos" : gramosFijos,
  "precio" : precio,
  "idlocal" : idlocal,
  "stock" : stock
  
  
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
  $('#mostrar_mensaje').html(mensaje); 
  tabla_suelto();
  
  }
  
  }) 
  
  }  

//eliminar producto  
function eliminar_pro(idventa)
  {    
//Ingresamos un mensaje a mostrar
var mensaje = confirm("Borrar Producto");
//Detectamos si el usuario acepto el mensaje
if (mensaje) {
borrarproducto(idventa);
}
   
}

function eliminar_cuota(idcuota)
  {    
//Ingresamos un mensaje a mostrar
var mensaje = confirm("Borrar Pago");
//Detectamos si el usuario acepto el mensaje
if (mensaje) {
borrarpago(idcuota);
}
   
}

function borrarpago(idcuota){

var parametros = 
  {
    "eliminar_pago": "1",
    idcuota : idcuota
   
  };
  $.ajax(
  {
    data:  parametros,
    url:   'datos_cuenta.php',
    type:  'post',
   
    error: function()
    {alert("Error");},
    
    success:  function (mensaje) 
    {
      $('#mostrar_cobro').html(mensaje); 
      listaCuenta();
      buscar_datos_cuenta();
    }
    
  })   

}

function borrarproducto(idventa){

  var parametros = 
    {
      "borrarpro": "1",
      
      idventa : idventa
     
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
        $('#mostrar_cobro').html(mensaje); 
        tablacarrito_venta();
        
      }
      
    }) 
    
}



function PasarValor()
{
document.getElementById("totalC").value = document.getElementById("totalM").value;
}

//click tabla clientes
$('#tablaClientes tr').on('click', function(){
  var dato1 = $(this).find('td:first').html();
  var dato2 = $(this).find('td:nth-child(2)').html();
  var dato3 = $(this).find('td:nth-child(3)').html();
  var dato4 = $(this).find('td:nth-child(4)').html();
  $('#idcliente').val("");
  $('#idcliente').val(dato1);
  $('#nombre_cliente').val(dato2);
  $('#direccion').val(dato3);
  $('#celular').val(dato4);
  //cerrar modal
  $("#buscarCliente").modal("hide");
  tablacuenta_pagos();
  
});


//click en tabla funcion	
$('#tablaProducto tr').on('click', function(){
  var dato1 = $(this).find('td:first').html();
  var dato2 = $(this).find('td:nth-child(2)').html();
  var dato3 = $(this).find('td:nth-child(3)').html();
  var dato4 = $(this).find('td:nth-child(4)').html();
  var dato5 = $(this).find('td:nth-child(5)').html();
  var dato6 = $(this).find('td:nth-child(6)').html();
  var dato7 = $(this).find('td:nth-child(7)').html();
  var dato8 = $(this).find('td:nth-child(8)').html();
  
  var i=1;
 
  $('#stock').val(dato7);
  /*if( dato7<=0){
    alert("Sin stock");
  }else{*/
  $('#idproducto').val(dato1);   
  $('#codigo').val(dato2);
  $('#nombre_producto').val(dato3);
  $('#mi_precio').val(dato4);
  $('#precio_menor').val(dato5);
  $('#precio_mayor').val(dato6);
  $('#cantidad').val(i++);

  //}
  

});

//click tabla Cuentas
$('#tablaCuenta tr').on('click', function(){
  var dato1 = $(this).find('td:first').html();
  var dato2 = $(this).find('td:nth-child(2)').html();
  var dato4 = $(this).find('td:nth-child(4)').html();
  var dato5 = $(this).find('td:nth-child(5)').html();
  $('#idcuota').val(dato1);
  $('#cuota').val(dato4);
  $('#cuota2').val(dato4);
});

//click tabla ventas
$('#tablaVentass tr').on('click', function(){
  var idventa = $(this).find('td:nth-child(1)').html();
  var dato3 = $(this).find('td:nth-child(3)').html();

  $('#codigo').val(dato3);
  buscar_datos_Producto();
  preguntar(idventa);
});

function preguntar(idventa)
  {
 
    Swal
    .fire({
        title: "Editar Producto? ",
        text: "¿Responder?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: "Sí, Editar",
        cancelButtonText: "Cancelar",
    })
    .then(resultado => {
        if (resultado.value) {
            // Hicieron click en "Sí"
            $('#tablaVentas tr').on('click', function(){
            var idventa = $(this).find('td:nth-child(1)').html();
            var dato3 = $(this).find('td:nth-child(2)').html();
            $('#codigo').val(dato3);
            buscar_datos_Producto();
 
        });  
        borrarproducto(idventa);
        console.log("*se edito el producto*");

        } else {
            // Dijeron que no
            console.log("*NO edito el producto*");
        }
    });

}

//click en tabla suelto
$('#tablaSuelto tr').on('click', function(){
  var dato1 = $(this).find('td:first').html();
  var dato2 = $(this).find('td:nth-child(2)').html();
  var dato3 = $(this).find('td:nth-child(3)').html();
  var dato4 = $(this).find('td:nth-child(4)').html();
  var dato5 = $(this).find('td:nth-child(5)').html();
  var dato6 = $(this).find('td:nth-child(6)').html();
  var dato7 = $(this).find('td:nth-child(7)').html();
  var dato8 = $(this).find('td:nth-child(8)').html();
  
  var i=1;
 
  $('#stock').val(dato5);
  /*if( dato7<=0){
    alert("Sin stock");
  }else{*/
  $('#idproducto').val(dato1);   
  $('#codigo').val(dato2);
  $('#nombre_producto').val(dato3);
  $('#mi_precio').val(dato4);
  $('#precio_suelto').val(dato8);
  $('#gramos').val(dato7);
  $('#gramos_muestra').val(dato7);
  $('#cantidad').val(i++);

  //}
  

});

</script>