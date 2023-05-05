<?php
	require("../conexion.php");
//tabla carrito de venta
  if(isset($_POST['mostrar_ventas']))
	{
    
    echo 
    '   
    <h5><center>Lista Detallada</center></h5>    
      <table id="tablaVentas" class="table table-hover">
      <thead class="thead-dark">
        <tr bgcolor="#ADD8E6">
          <th scope="col" style="color:#FFFFFF; width:2%;" >#</th>
          <th scope="col" style="width:5%;">N°Factura</th>
          <th scope="col">Codigo</th>
          <th scope="col">Producto</th>
          <th scope="col">Precio</th>
          <th scope="col">Cantidad</th>
          <th scope="col">Des.%</th>
          <th scope="col">Precio Final</th>
          <th scope="col">Subtotal</th>
          <th scope="col">M.D.P.</th>
        </tr>
        </thead>    
    ';

      $numFactura = $_POST['numero_factura'];
      $idcliente = $_POST['idcliente'];
      //$apellido = $_POST['apellido'];
      //traer id Cliente
      /*$rs = mysqli_query($conexion, "SELECT idcliente FROM cliente WHERE nombre ='$nombre'");
      while($row = mysqli_fetch_array($rs))
      {
       $idcliente=$row['idcliente'];
   
      }*/
      $resultados = mysqli_query($conexion,"SELECT carrito_cuenta.idproducto, idcarrito_cuenta,numero_factura, producto.codigo_producto'codigo', producto.nombre_producto'producto', carrito_cuenta.precio_producto, subtotal, carrito_cuenta.cantidad, carrito_cuenta.descuento, carrito_cuenta.total, carrito_cuenta.mediodepago, carrito_cuenta.subtotal FROM carrito_cuenta
      INNER JOIN producto on carrito_cuenta.idproducto=producto.idproducto WHERE numero_factura='$numFactura' and idcliente='$idcliente' ");
      
    $contador=0;
    $num=0;
    $i=1;
    while($consulta = mysqli_fetch_array($resultados))
	    {
            echo "<tr style='font-weight:bold;'>";
            $consulta['idproducto'];
            //$consulta['idventa'];
            echo "<td style='color:#FFFFFF'>".$consulta['idcarrito_cuenta']."</td>";
            echo "<td>" . $consulta['numero_factura'] . "</td>";
            $num = $consulta['numero_factura'];
            echo "<td style='width:12%;'  >" . $consulta['codigo'] . "</td>";
            echo "<td >" . $consulta['producto'] . "</td>";
            echo "<td>" . $consulta['precio_producto'] . "</td>";
            echo "<td>" . $consulta['cantidad'] . "</td>";
            echo "<td>" . $consulta['descuento'] . "</td>";
            echo "<td>" . $consulta['subtotal'] . "</td>";
            echo "<td>" . $consulta['total'] . "</td>";
            echo "<td>" . $consulta['mediodepago'] . "</td>";
            echo "<td><button type='button' class='btn btn-danger'  type='button' onclick='eliminar_pro(${consulta['idcarrito_cuenta']});'><i class='fas fa-trash-alt'></i></button>";
            echo "<td'><button type='button' class='btn btn-success'  type='button' onclick='preguntar(${consulta['idcarrito_cuenta']});'><i class='fas fa-edit'></i></button>";

            //echo "<td><a href='inscripcion.php?id=".$consulta['idalumno']."'><i class='fas fa-trash-alt'></i></a></td>";
            //echo "<td><a href='javascript: prueba();'> <img src='.' alt='Seleccionar'></a></td>";
            //echo "<td><input type='button' value='Seleccionar' class='btn btn-primary' name='btn_inscribir' onclick='prueba();'></td>";
            echo "</tr>";
            $i++;
	  }	
    
    
    $Sumcan=0;
    $CanVen=0;
    $totalProductos=0;
    $resultados = mysqli_query($conexion,"SELECT COUNT(idcarrito_cuenta)'cantventa', SUM(cantidad)'sumcantidad' FROM carrito_cuenta WHERE numero_factura = '$numFactura' ");
    while($consulta = mysqli_fetch_array($resultados))
	    {
        //$CanVen = $consulta['cantventa'];
        //$Sumcan = $consulta['sumcantidad'];
        //$totalProductos = $Sumcan + $CanVen;
        $totalProductos = $consulta['sumcantidad'];
        

      }
      echo "<h4 style='font-weight:bold;'>Total de Bultos: $totalProductos </h4>";

      echo "<tfoot>";
      $resultados = mysqli_query($conexion,"SELECT SUM(total)'total' FROM carrito_cuenta where numero_factura='$num'");
        while($consulta = mysqli_fetch_array($resultados))
       {
         $total = $consulta['total'];        
      echo"<tfoot>
                    <tr class='font-weight-bold'>
                        <td colspan=3 style='font-weight:bold;'>Total al Pagar $
                        <input type='number' name='total' id='totalC' class='form-control' value='$total' style='font-size: 20px; width:60%; text-transform: uppercase; color: black; font-weight:bold;'> </td>
                        <td></td>
                    </tr> ";

      echo "</tfoot>";
             
       }
       
  }


  //tabla cuenta corriente listas de cuentas
  if(isset($_POST['mostrar_cuentas']))
	{
    
    echo 
    '   
    <h5><center>Lista Detallada</center></h5>    
      <table id="tablaVentas" class="table table-bordered order-table ">
      <thead class="thead-dark">
        <tr bgcolor="#C0C0C0" style="color: black;">
          <th scope="col">Fecha</th>
          <th scope="col">Fecha Vencimiento</th>
          <th scope="col" style="width:5%;">N°Factura</th>
          <th scope="col">Cliente</th>
          <th scope="col">Estado</th>
          <th scope="col">Gran Total</th>
          <th scope="col">Restante</th>
          <th scope="col">Cantidad Recibida</th>
      
        </tr>
      </thead>    
    ';

      //$numFactura = $_POST['numero_factura'];
      //$idcliente = $_POST['idcliente'];
    
      $resultados = mysqli_query($conexion," SELECT idcuenta_corrientes, fecha, fecha_vencimiento, numero_factura, cliente.nombre, cuenta_corrientes.estado, gran_total, restante, cantidad_recibida, cliente.idcliente  FROM cuenta_corrientes LEFT JOIN cliente on cuenta_corrientes.idcliente=cliente.idcliente ");
      

    while($consulta = mysqli_fetch_array($resultados))
	    {
            //style='font-weight:bold;'
            $idcuenta = $consulta['idcuenta_corrientes'];
            $idclt = $consulta['idcliente'];
            $num_Factura = $consulta['numero_factura'];
            $cliente = $consulta['nombre'];
            echo "<tr style='font-size: 16px;'>";
            echo "<td>".$consulta['fecha']."</td>";
            echo "<td >" . $consulta['fecha_vencimiento'] . "</td>";
            echo "<td style='width:12%;'  >" . $consulta['numero_factura'] . "</td>";
            echo "<td >" . $consulta['nombre'] . "</td>";
            $estado = $consulta['estado'];
            $gran_total = $consulta['gran_total'];
            $cantidad_recibida_cuenta = $consulta['cantidad_recibida'];
 
            if($estado=="Recibido"){
               echo "<td bgcolor='#90EE90'>" . $consulta['estado'] . "</td>";
            }
            if($estado=="Recibido Parcial"){
              echo "<td bgcolor='#F0E68C'>" . $consulta['estado'] . "</td>";
            }
            
            if($estado=="No Recibido"){
              echo "<td bgcolor='#F08080'>" . $consulta['estado'] . "</td>";
            }

            echo "<td>"."$"  . $consulta['gran_total'] . "</td>";
            echo "<td>"."$"  . $consulta['restante'] . "</td>";
            echo "<td>"."$"  . $consulta['cantidad_recibida'] . "</td>";
            
            echo "<td><a href='editar_cuenta.php?id=$idcuenta&numero_factura=$num_Factura&cliente=$cliente&idcliente=$idclt' class='btn btn-success'><i class='fas fa-edit'></i></a>
            ";
            echo "<td><a href='pdf/reporteCuenta.php?factura=$num_Factura' target='_blank' rel='noopener noreferrer' class='btn btn-info'><i class='fa fa-print' aria-hidden='true'></i></a>
            ";

										 
            echo "</tr>";
            
	    }	
    
       
  }

  //tabla cuenta para pagar pagos cuenta corrientes
  if(isset($_POST['mostrar_tabla_pagos']))
	{
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $feha_actual=date("d-m-Y ");
    
    echo 
    '   
    <h5><center>Lista Detallada</center></h5>    
      <table id="tblpagos" class="table table-bordered order-table ">
      <thead class="thead-dark">
        <tr bgcolor="#C0C0C0" style="color: black;">
          <th scope="col">Seleccionar</th>
          <th scope="col" style="width:5%;">N°Factura</th>
          <th scope="col" style="width: 25%;">Fecha</th>
          <th scope="col" style="width: 15%;">Monto de la Factura</th>
          <th scope="col" style="width: 15%;">Recibido Antes</th>
          <th scope="col" style="width: 15%;">Recibido Ahora</th>
          <th scope="col" style="width: 15%;">Saldo por Recibir</th>
          <th scope="col">Estado</th>
      
        </tr>
        </thead>    
    ';

      //$numFactura = $_POST['numero_factura'];
      $buscar = $_POST['buscar'];
      $saldo = 0;
      $antes = 0;
    
      $resultados = mysqli_query($conexion," SELECT idcuenta_corrientes, fecha, fecha_vencimiento, numero_factura, cliente.nombre, cuenta_corrientes.estado, gran_total, restante, cantidad_recibida, cuenta_corrientes.estado  FROM cuenta_corrientes LEFT JOIN cliente on cuenta_corrientes.idcliente=cliente.idcliente
      where cliente.idcliente = $buscar and cuenta_corrientes.estado='No Recibido'");
      

    while($consulta = mysqli_fetch_array($resultados))
	    {
            //style='font-weight:bold;'
            $id_cuenta=$consulta['idcuenta_corrientes'];
            $cantidad_recibida_cuenta = $consulta['cantidad_recibida'];
            $restante = $consulta['restante'];
            echo "<tr bgcolor='#F8F8FF' style='font-size: 18px; cursor:pointer; '>";
           // echo "<td>".$consulta['fecha']."</td>";
            echo "<td>
            <div class='checkbox'>
            <label>
              <input style='width:255%;' type='checkbox' value='$id_cuenta' id='opcion' name='opcion' class='chkseleccion'>
            </label>
            </div>
                  </td>";
            echo "<td style='width:12%;'  >" . $consulta['numero_factura'] . "</td>";
            echo "<td >".$feha_actual."</td>";
            
            $gran_total = $consulta['gran_total'];
            echo "<td style='width: 15%;'>
            
            <label>
              <input id='gran_total' value='$gran_total' disabled >
            </label>
            
            </td>";

            echo "<td style='width: 15%;'>
            <label>
              <input id='recibido_antes' value='$cantidad_recibida_cuenta' disabled >
            </label>
            
            </td>";

            echo "<td bgcolor='#EEE8AA' style='width: 15%;'>
            <label>
              <input id='recibido_ahora' onkeyup='if(event.keyCode ==13) calcular_saldo();'>
            </label>
            </td>";
            
            echo "<td style='width: 15%;'>
            <label>
              <input id='saldo_por_recibir' value='' disabled>
            </label>
            </td>";
            $estado = $consulta['estado'];
            if($estado=="Recibido"){
              
              echo "<td bgcolor='#90EE90'>$estado
              <input type='hidden' id='estado' value='$estado' disabled>
              </td>";
            }
            if($estado=="Recibido Parcial"){
              
              echo "<td bgcolor='#F0E68C'>$estado
              <input type='hidden' id='estado' value='$estado' disabled>
              </td>";
              
            }
            if($estado=="No Recibido"){
              echo "<td bgcolor='#F08080'>$estado
              <input type='hidden' id='estado' value='$estado' disabled>
              </td>";
            }
            

            echo "</tr>";
            
            
	    }	
    
       
  }
  ?>

<script type="text/javascript">
    
    function borrarproducto(idcarrito_cuenta){

        var parametros = 
        {
            "borrarpro": "1",
            
            idcarrito_cuenta : idcarrito_cuenta
        
        };
        $.ajax(
        {
            data:  parametros,
            url:   'datos_carrito_cuenta.php',
            type:  'post',
        
            error: function()
            {alert("Error");},
            
            success:  function (mensaje) 
            {
            $('#mostrar_carrito').html(mensaje); 
            tablacarrito();
            
            }
            
        }) 
  
}
//editar producto
function preguntar(idcarrito_cuenta)
  {
    swal({
    title: "Editar el Producto?",
    text: "Responder?",
    type: "warning",
    showCancelButton: true,
    confirmButtonText: "SI",
    confirmButtonClass: "btn-warning",
    cancelButtonText: "No",
    cancelButtonClass: "btn-danger"
},
function(isConfirm) {
    if (isConfirm) {
      $('#tablaVentas tr').on('click', function(){
      var idcarrito_cuenta = $(this).find('td:nth-child(1)').html();
      var dato3 = $(this).find('td:nth-child(3)').html();

      $('#codigo').val(dato3);
      buscar_datos_Producto();
 
});  
borrarproducto(idcarrito_cuenta);
    } else {
        /* AQUI UNA ALERTA "TU REGISTRO ESTA A SALVO" */
    }
});     

 
}

//calcular saldo por recibir
function calcular_saldo()
{
total=0;
var monto_factura = parseFloat($('#recibido_ahora').val());
var gran_total = parseFloat($('#gran_total').val());
var anticipo = parseFloat($('#anticipo').val());
//var restante = parseFloat($('#restante').val());
var recibido_antes = parseFloat($('#recibido_antes').val());
//alert(restante);
var total = parseFloat(monto_factura + anticipo);

if(gran_total>recibido_antes){
  var saldo_por_recibir = parseFloat(gran_total - monto_factura - anticipo - recibido_antes);

}else{
  var saldo_por_recibir = 0;
}


$.ajax({

beforesend: function()
{
alert("Error");
},

success: function()
{
document.getElementById("monto_factura").value = document.getElementById("recibido_ahora").value;  
$("#total_pagado").val(total);
$("#saldo_por_recibir").val(saldo_por_recibir);
if(saldo_por_recibir == 0){

  $("#estado").val("Recibido");

}
}
});

}



//click tabla pagos
$('#tblpagos tr').on('click', function(){

  var dato1 = $(this).find('td:first').html();
  var dato2 = $(this).find('td:nth-child(2)').html();
  const id = document.querySelector('#opcion');
  $('#idcuenta_corriente').val(id.value);
  $('#numero_factura').val(dato2);

  var monto = parseFloat($('#gran_total').val());
  //alert(monto);
  var recibido = parseFloat($('#recibido_antes').val());
  //alert(recibido);
  if(monto>=recibido){
    var saldo = parseFloat(monto - recibido);
    $('#saldo_por_recibir').val(saldo);

  }else{
    $('#saldo_por_recibir').val(0);
  }
  
  //js.checked
  //alert(js.value);
  //$('#monto_factura').val(dato8);
  
  
});

$(function(){
  //Mensaje
    var message_status = $("#tblpagos");
    $("td[contenteditable=true]").blur(function(){
        var rownumber = $(this).attr("id");
        var value = $(this).text();
        $.post('proceso.php' , rownumber + "=" + value, function(data){
            if(data != '')
      {
        message_status.show();
        message_status.html(data);
        //hide the message
        //setTimeout(function(){message_status.html("REGISTRO ACTUALIZADO CORRECTAMENTE");},2000);
        //window.location.href = "stock_producto.php";
      } else {
        //message_status().html = data;
      }




        });
    });
});
</script>    