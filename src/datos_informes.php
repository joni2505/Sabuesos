<?php
	require("../conexion.php");
  //$query = mysqli_query($conexion, "SELECT producto.nombre_producto, ventas.total_venta'total' FROM ventas INNER JOIN producto on ventas.idproducto=producto.idproducto where mes='$mes' ");
  //$query = mysqli_query($conexion, "SELECT DISTINCT ventas.mes'mes' FROM ventas ORDER BY fecha_venta");
  $mes = 'vacio';
  if(isset($_POST['informeProducto']))
	{
    echo 
    ' 
    <h5><center>Lista de Meses</center></h5> 
    <table class="table table-striped table-bordered" id="table" style="width: 47%">
    <thead class="thead-dark">
				<tr>
				<th></th>
				<th align="center">MENSUAL (M)</th>
				</tr>
				</thead>
    ';
    $idlocal = $_POST['idlocal'];
    $resultados = mysqli_query($conexion,"SELECT DISTINCT ventas.mes'mes' FROM ventas WHERE ventas.idlocal=$idlocal ORDER BY fecha_venta");
    
    while($consulta = mysqli_fetch_array($resultados))
	    {
        $mes = $consulta['mes'];
        if($mes == "Enero"){
          $mes_int = 1;
        }
        if($mes == "Febrero"){
          $mes_int = 2;
        }
        if($mes == "Marzo"){
          $mes_int = 3;
        }
        if($mes == "Abril"){
          $mes_int = 4;
        }
        if($mes == "Mayo"){
          $mes_int = 5;
        }
        if($mes == "Junio"){
          $mes_int = 6;
        }
        if($mes == "Julio"){
          $mes_int = 7;
        }
        if($mes == "Agosto"){
          $mes_int = 8;
        }
        if($mes == "Septiembre"){
          $mes_int = 9;
        }
        if($mes == "Octubre"){
          $mes_int = 10;
        }
        if($mes == "Noviembre"){
          $mes_int = 11;
        }
        if($mes == "Diciembre"){
          $mes_int = 12;
        }
        
            echo "<tr class='clickable' data-toggle='collapse' data-target='#collapseMES' onclick='informe($mes_int);'>";
            echo "<td><i class='fa fa-plus' aria-hidden='true' ></i></td>";
            echo "<td>" . $consulta['mes'] . "</td>";
     
             
            echo "</tr>";
            
	  }  
}

//datos clientes
if(isset($_POST['informeCliente']))
	{
    echo 
    ' 
    <h5><center>Lista de Clientes</center></h5> 
    <table class="table table-striped table-bordered" id="table" style="width: 47%">
    <thead class="thead-dark">
				<tr>
				<th></th>
				<th align="center">CLIANTELA</th>
				</tr>
				</thead>
    ';
    $idlocal = $_POST['idlocal'];
    $resultados = mysqli_query($conexion,"SELECT DISTINCT cliente.nombre, ventas.idcliente FROM ventas INNER JOIN cliente on ventas.idcliente=cliente.idcliente WHERE ventas.idlocal=$idlocal");
    
    while($consulta = mysqli_fetch_array($resultados))
	    {
        $idcliente = $consulta['idcliente'];
            echo "<tr class='clickable' data-toggle='collapse' data-target='#collapseMES' onclick='informe_cliente($idcliente);'>";
            echo "<td><i class='fa fa-plus' aria-hidden='true' ></i></td>";
            echo "<td>" . $consulta['nombre'] . "</td>";
     
             
            echo "</tr>";
            
	  }  
}

//informe ganancias
$mesg = 'vacio';
if(isset($_POST['informeGanancias']))
{
  echo 
  ' 
  <h5><center>Lista de Meses</center></h5> 
  <table class="table table-striped table-bordered" id="table" style="width: 47%">
  <thead class="thead-dark">
      <tr>
      <th></th>
      <th align="center">MENSUAL (M)</th>
      </tr>
      </thead>
  ';
  $idlocal = $_POST['idlocal'];
  $resultados = mysqli_query($conexion,"SELECT DISTINCT ventas.mes'mes' FROM ventas WHERE ventas.idlocal=$idlocal ORDER BY fecha_venta");
  
  while($consulta = mysqli_fetch_array($resultados))
    {
      $mesg = $consulta['mes'];
      if($mesg == "Enero"){
        $mes_int = 1;
      }
      if($mes == "Febrero"){
        $mes_int = 2;
      }
      if($mesg == "Marzo"){
        $mes_int = 3;
      }
      if($mesg == "Abril"){
        $mes_int = 4;
      }
      if($mesg == "Mayo"){
        $mes_int = 5;
      }
      if($mesg == "Junio"){
        $mes_int = 6;
      }
      if($mesg == "Julio"){
        $mes_int = 7;
      }
      if($mesg == "Agosto"){
        $mes_int = 8;
      }
      if($mesg == "Septiembre"){
        $mes_int = 9;
      }
      if($mes == "Octubre"){
        $mes_int = 10;
      }
      if($mesg == "Noviembre"){
        $mes_int = 11;
      }
      if($mesg == "Diciembre"){
        $mes_int = 12;
      }
      
          echo "<tr class='clickable' data-toggle='collapse' data-target='#collapseMES' onclick='informe_ganancias($mes_int);'>";
          echo "<td><i class='fa fa-plus' aria-hidden='true' ></i></td>";
          echo "<td>" . $consulta['mes'] . "</td>";
   
           
          echo "</tr>";

             
          
  }  
}

//infome mensual cuenta
if(isset($_POST['informeMensualCuenta']))
	{
    echo 
    ' 
    <h5><center>Lista de Meses</center></h5> 
    <table class="table table-striped table-bordered" id="table" style="width: 47%">
    <thead class="thead-dark">
				<tr>
				<th></th>
				<th align="center">MENSUAL (M)</th>
				</tr>
				</thead>
    ';
    $idlocal = $_POST['idlocal'];
    $resultados = mysqli_query($conexion,"SELECT DISTINCT carrito_cuenta.mes'mes' FROM carrito_cuenta WHERE carrito_cuenta.idlocal=$idlocal ORDER BY fecha");
    
    while($consulta = mysqli_fetch_array($resultados))
	    {
        $mes = $consulta['mes'];
        if($mes == "Enero"){
          $mes_int = 1;
        }
        if($mes == "Febrero"){
          $mes_int = 2;
        }
        if($mes == "Marzo"){
          $mes_int = 3;
        }
        if($mes == "Abril"){
          $mes_int = 4;
        }
        if($mes == "Mayo"){
          $mes_int = 5;
        }
        if($mes == "Junio"){
          $mes_int = 6;
        }
        if($mes == "Julio"){
          $mes_int = 7;
        }
        if($mes == "Agosto"){
          $mes_int = 8;
        }
        if($mes == "Septiembre"){
          $mes_int = 9;
        }
        if($mes == "Octubre"){
          $mes_int = 10;
        }
        if($mes == "Noviembre"){
          $mes_int = 11;
        }
        if($mes == "Diciembre"){
          $mes_int = 12;
        }
        
            echo "<tr class='clickable' data-toggle='collapse' data-target='#collapseMES' onclick='informe_mensualCuenta($mes_int);'>";
            echo "<td><i class='fa fa-plus' aria-hidden='true' ></i></td>";
            echo "<td>" . $consulta['mes'] . "</td>";
     
             
            echo "</tr>";
            
	  }  
}

//INFORME CLIENTE CUENTA 
if(isset($_POST['informeClienteCuenta']))
	{
    echo 
    ' 
    <h5><center>Lista de Clientes</center></h5> 
    <table class="table table-striped table-bordered" id="table" style="width: 47%">
    <thead class="thead-dark">
				<tr>
				<th></th>
				<th align="center">CLIANTELA</th>
				</tr>
				</thead>
    ';
    $idlocal = $_POST['idlocal'];
    $resultados = mysqli_query($conexion,"SELECT DISTINCT cliente.nombre, carrito_cuenta.idcliente FROM carrito_cuenta INNER JOIN cliente on carrito_cuenta.idcliente=cliente.idcliente WHERE carrito_cuenta.idlocal=$idlocal");
    
    while($consulta = mysqli_fetch_array($resultados))
	    {
        $idcliente = $consulta['idcliente'];
            echo "<tr class='clickable' data-toggle='collapse' data-target='#collapseMES' onclick='informe_cliente_cuenta($idcliente);'>";
            echo "<td><i class='fa fa-plus' aria-hidden='true' ></i></td>";
            echo "<td>" . $consulta['nombre'] . "</td>";
     
             
            echo "</tr>";
            
	  }  
}

//SELECT cliente.nombre, COUNT(ventas.idcliente) AS 'ventas' FROM ventas INNER JOIN cliente on ventas.idcliente=cliente.idcliente GROUP BY ventas.idcliente ASC LIMIT 5
//productos mas comprado por el cliente
//SELECT DISTINCT producto.nombre_producto, COUNT(ventas.idproducto) AS 'total_lista' FROM ventas INNER JOIN producto on ventas.idproducto=producto.idproducto WHERE ventas.idcliente=2 and año GROUP BY ventas.idproducto ORDER BY  COUNT(ventas.idproducto) DESC
?>

<script type="text/javascript">
function informe_ganancias(mes_int){
  var idlocal = document.getElementById("idlocal").value;
  var anio = document.getElementById("anio").value;  
  var mes;
  if(mes_int == 1){
        mes = "Enero";
  }
  if(mes_int == 2){
        mes = "Febrero";
  }
  if(mes_int == 3){
        mes = "Marzo";
  }
  if(mes_int == 4){
        mes = "Abril";
  }
  if(mes_int == 5){
        mes = "Mayo";
  }
  if(mes_int == 6){
        mes = "Junio";
  }
  if(mes_int == 7){
        mes = "Julio";
  }
  if(mes_int == 8){
        mes = "Agosto";
  }
  if(mes_int == 9){
        mes = "Septiembre";
  }
  if(mes_int == 10){
        mes = "Octubre";
  }
  if(mes_int == 11){
        mes = "Noviembre";
  }
  if(mes_int == 12){
        mes = "Diciembre";
  }
      //alert(mes);
      var parametros = 
      {
        "tblinfo_ganancias" : 1,
        "mes" : mes,
        "anio" : anio,
        "idlocal" : idlocal,
        "accion" : "4"
  
      };

      $.ajax({
        data: parametros,
        url: 'tabla_informe.php',
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

//informe mensual
function informe(mes_int){
  var idlocal = document.getElementById("idlocal").value;
  var anio = document.getElementById("anio").value;  
  var mes;
  if(mes_int == 1){
        mes = "Enero";
  }
  if(mes_int == 2){
        mes = "Febrero";
  }
  if(mes_int == 3){
        mes = "Marzo";
  }
  if(mes_int == 4){
        mes = "Abril";
  }
  if(mes_int == 5){
        mes = "Mayo";
  }
  if(mes_int == 6){
        mes = "Junio";
  }
  if(mes_int == 7){
        mes = "Julio";
  }
  if(mes_int == 8){
        mes = "Agosto";
  }
  if(mes_int == 9){
        mes = "Septiembre";
  }
  if(mes_int == 10){
        mes = "Octubre";
  }
  if(mes_int == 11){
        mes = "Noviembre";
  }
  if(mes_int == 12){
        mes = "Diciembre";
  }
      //alert(mes);
      var parametros = 
      {
        "informe_dato" : 1,
        "mes" : mes,
        "anio" : anio,
        "idlocal" : idlocal,
        "accion" : "4"
  
      };

      $.ajax({
        data: parametros,
        url: 'tabla_informe.php',
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

//LISTA CLIENTES INFORME
function informe_cliente(idcliente){
  var mes = document.getElementById("mes").value; 
  var idlocal = document.getElementById("idlocal").value; 
  var anio = document.getElementById("anio").value; 
      var id = idcliente;
      var parametros = 
      {
        "informe_dato_cliente" : 1,
        "id" : id,
        "mes" : mes,
        "anio" : anio,
        "idlocal" : idlocal,
        "accion" : "4"
  
      };

      $.ajax({
        data: parametros,
        url: 'tabla_informe.php',
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

//INFORME MENSUAL CUENTA
function informe_mensualCuenta(mes_int){
  var idlocal = document.getElementById("idlocal").value;
  var anio = document.getElementById("anio").value;  
  var mes;
  if(mes_int == 1){
        mes = "Enero";
  }
  if(mes_int == 2){
        mes = "Febrero";
  }
  if(mes_int == 3){
        mes = "Marzo";
  }
  if(mes_int == 4){
        mes = "Abril";
  }
  if(mes_int == 5){
        mes = "Mayo";
  }
  if(mes_int == 6){
        mes = "Junio";
  }
  if(mes_int == 7){
        mes = "Julio";
  }
  if(mes_int == 8){
        mes = "Agosto";
  }
  if(mes_int == 9){
        mes = "Septiembre";
  }
  if(mes_int == 10){
        mes = "Octubre";
  }
  if(mes_int == 11){
        mes = "Noviembre";
  }
  if(mes_int == 12){
        mes = "Diciembre";
  }
      //alert(mes);
      var parametros = 
      {
        "informe_mensual_cuenta" : 1,
        "mes" : mes,
        "anio" : anio,
        "idlocal" : idlocal,
        "accion" : "4"
  
      };

      $.ajax({
        data: parametros,
        url: 'tabla_informe.php',
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

//INFORME CLIENTE CUENTA
function informe_cliente_cuenta(idcliente){
  var mes = document.getElementById("mes").value; 
  var idlocal = document.getElementById("idlocal").value; 
  var anio = document.getElementById("anio").value; 
      var id = idcliente;
      var parametros = 
      {
        "informe_dato_cliente_cuenta" : 1,
        "id" : id,
        "mes" : mes,
        "anio" : anio,
        "idlocal" : idlocal,
        "accion" : "4"
  
      };

      $.ajax({
        data: parametros,
        url: 'tabla_informe.php',
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