<?php
	require("../conexion.php");
  if(isset($_POST['buscar_venta']))
	{
    
    echo 
    '   
      <h5><center>Lista Detallada</center></h5>    
      <table class="table table-bordered order-table ">
      <thead class="thead-dark">

        <tr>
        <th>#</th>
        <th>N°Factura</th>
        <th>Codigo</th>
        <th>Producto</th>
        <th>Precio</th>
        <th>Cantidad</th>
        <th>Descuento</th>
        <th>Total</th>
        <th>Caja</th>
        </tr>
        </thead> 
    ';

      $idcaja = $_POST['buscar_venta'];
      
     
      $resultados = mysqli_query($conexion,"SELECT numero_factura, producto.codigo_producto, producto.nombre_producto, subtotal, cantidad, descuento, total_venta, caja.nombre_caja FROM ventas 
      INNER JOIN producto on ventas.idproducto=producto.idproducto
      INNER JOIN caja on ventas.idcaja=caja.idcaja  WHERE ventas.mediodepago='Efectivo' and ventas.idcaja='$idcaja'");
      
    $i=1;
    while($consulta = mysqli_fetch_array($resultados))
	    {
            echo "<tr>";
            echo "<td>".$i."</td>";
            echo "<td>" . $consulta['numero_factura']. "</td>";
            echo "<td>" . $consulta['codigo_producto'] . "</td>";
            echo "<td>" . $consulta['nombre_producto'] . "</td>";
            echo "<td>" . $consulta['subtotal'] . "</td>";
            echo "<td>" . $consulta['cantidad'] . "</td>";
            echo "<td>" . $consulta['descuento'] . "</td>";
            echo "<td>" . $consulta['total_venta'] . "</td>";
            echo "<td>" . $consulta['nombre_caja'] . "</td>";
            //echo "<td><button type='button' class='btn btn-danger'  type='button' onclick='eliminar_pro(${consulta['idventa']});'><i class='fas fa-trash-alt'></i></button>";
            //echo "<td><a href='inscripcion.php?id=".$consulta['idalumno']."'><i class='fas fa-trash-alt'></i></a></td>";
            //echo "<td><a href='javascript: prueba();'> <img src='.' alt='Seleccionar'></a></td>";
            //echo "<td><input type='button' value='Seleccionar' class='btn btn-primary' name='btn_inscribir' onclick='prueba();'></td>";
            echo "</tr>";
            $i++;
	  }	

    }

    if(isset($_POST['buscar_gastos']))
    {
      
      echo 
      '   
        <h5><center>Lista Detallada</center></h5>    
        <table class="table table-bordered order-table ">
        <thead class="thead-dark">
  
          <tr>
          <th>#</th>
          <th>Descripcion</th>
          <th>Importe</th>
          <th>Fecha</th>
          <th>Caja</th>
          </tr>
          </thead> 
      ';
  
        $idcaja = $_POST['buscar_gastos'];
        
       
        $resultados = mysqli_query($conexion,"SELECT gastos.descripcion, gastos.importe, gastos.fecha, caja.nombre_caja FROM gastos
        INNER JOIN caja on gastos.idcaja=caja.idcaja WHERE gastos.idcaja='$idcaja'");
        
      $i=1;
      while($consulta = mysqli_fetch_array($resultados))
        {
              echo "<tr>";
              echo "<td>".$i."</td>";
              echo "<td>" . $consulta['descripcion']. "</td>";
              echo "<td>" . $consulta['importe'] . "</td>";
              echo "<td>" . $consulta['fecha'] . "</td>";
              echo "<td>" . $consulta['nombre_caja'] . "</td>";
              //echo "<td><button type='button' class='btn btn-danger'  type='button' onclick='eliminar_pro(${consulta['idventa']});'><i class='fas fa-trash-alt'></i></button>";
              //echo "<td><a href='inscripcion.php?id=".$consulta['idalumno']."'><i class='fas fa-trash-alt'></i></a></td>";
              //echo "<td><a href='javascript: prueba();'> <img src='.' alt='Seleccionar'></a></td>";
              //echo "<td><input type='button' value='Seleccionar' class='btn btn-primary' name='btn_inscribir' onclick='prueba();'></td>";
              echo "</tr>";
              $i++;
      }	
  
      }

      //buscar factura

      if(isset($_POST['buscar_factura']))
	{
    
    echo 
    '   
      <h5><center>Lista Detallada</center></h5>    
      <table class="table table-bordered order-table " id="tbl-factura">
      <thead class="thead-dark">

        <tr>
        <th>#</th>
        <th>N°Factura</th>
        <th>Cliente</th>
        <th>Importe</th>
        <th>Total</th>
        <th>Fecha</th>
        <th>Tipo de Venta</th>
        </tr>
        </thead> 
    ';

      $factura = $_POST['buscar_factura'];
      $idlocal = $_POST['idlocal'];
      if($factura>0){
        $resultados = mysqli_query($conexion,"SELECT idfactura, numero_factura, cliente.idcliente, cliente.nombre, importe, total,date_format(fecha, '%d-%m-%Y')'fecha',tipoventa, cliente.idcliente FROM factura 
        INNER JOIN cliente on factura.idcliente=cliente.idcliente WHERE factura.idlocal=$idlocal and numero_factura='$factura'  ");
      }else{
        $resultados = mysqli_query($conexion,"SELECT idfactura, numero_factura, cliente.idcliente, cliente.nombre, importe, total,date_format(fecha, '%d-%m-%Y')'fecha',tipoventa,  cliente.idcliente FROM factura 
      INNER JOIN cliente on factura.idcliente=cliente.idcliente WHERE factura.idlocal=$idlocal ");
      }
      
      
    $i=1;
    while($consulta = mysqli_fetch_array($resultados))
	    {
            echo "<tr>";
            echo "<td>".$i."</td>";
            $consulta['idfactura'];
            echo "<td>" . $consulta['numero_factura']. "</td>";
            echo "<td>" . $consulta['nombre']. "</td>";
            echo "<td>" . $consulta['importe'] . "</td>";
            echo "<td>" . $consulta['total'] . "</td>";
            echo "<td>" . $consulta['fecha'] . "</td>";
            echo "<td>" . $consulta['tipoventa'] . "</td>";
            echo "<td>" . $consulta['idcliente'] . "</td>";
            echo "<td><button type='button' class='btn btn-success'  type='button' onclick='editarFactura(${consulta['idfactura']});'><i class='fas fa-edit'></i></button>";
            echo "<td><button type='button' class='btn btn-danger'  type='button' onclick='eliminarFactura(${consulta['idfactura']});'><i class='fas fa-trash-alt'></i></button>";
            //echo "<td><button type='button' class='btn btn-danger'  type='button' onclick='eliminar_pro(${consulta['idventa']});'><i class='fas fa-trash-alt'></i></button>";
            //echo "<td><a href='inscripcion.php?id=".$consulta['idalumno']."'><i class='fas fa-trash-alt'></i></a></td>";
            //echo "<td><a href='javascript: prueba();'> <img src='.' alt='Seleccionar'></a></td>";
            //echo "<td><input type='button' value='Seleccionar' class='btn btn-primary' name='btn_inscribir' onclick='prueba();'></td>";
            echo "</tr>";
            $i++;
	  }	

    }
    
  ?>

<script type="text/javascript">

//editar factura
function editarFactura(idfactura){
 
  $("#cliente").val("");
  $('#tbl-factura tr').on('click', function(){
  var dato1 = $(this).find('td:first').html();
  var dato2 = $(this).find('td:nth-child(2)').html();
  var dato3 = $(this).find('td:nth-child(3)').html();
  var dato6 = $(this).find('td:nth-child(6)').html();
  var dato8 = $(this).find('td:nth-child(8)').html();
  $('#cliente').val(dato3);
  $('#numero_factura').val(dato2);
  $('#idcliente').val(dato8);
  listaClientes(dato8);
});
var parametros = 
  {
    "editar_factura": "1",
    idfactura : idfactura
   
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
      Swal
    .fire({
        title: "Atencion al Editar Factura no debe dejar pendiente la venta de lo contrario borrar todos lo producto del carrito, Gracias por su Atencion!",
        text: "¿Responder?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: "Sí, Editar",
        cancelButtonText: "Cancelar",
    })
    .then(resultado => {
        if (resultado.value) {
            // Hicieron click en "Sí"
            
            console.log("*se edito el producto*");

        } else {
            // Dijeron que no
            console.log("*NO edito el producto*");
        }
    });
    
      $('#mostrar_factura').html(mensaje); 

      listaFactura();
      //listaClientes(dato8);
      insertar_carrito_venta();
      tablacarrito_venta();
      //cerrar modal
      $("#lista_venta").modal("hide");
     //bloquear select 2
      $("#buscador_cliente").attr("disabled",true);
    }
    
  })   

}


//eliminar factura
function eliminarFactura(idfactura){
  $("#cliente").val("");
  $('#tbl-factura tr').on('click', function(){
  var dato1 = $(this).find('td:first').html();
  var dato2 = $(this).find('td:nth-child(2)').html();
  var dato3 = $(this).find('td:nth-child(3)').html();
  var dato6 = $(this).find('td:nth-child(6)').html();
  var dato8 = $(this).find('td:nth-child(8)').html();
});
var parametros = 
  {
    "borrar_factura": "1",
    idfactura : idfactura
   
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
      $('#mostrar_factura').html(mensaje); 

      listaFactura();
      //listaClientes(dato8);
      //insertar_carrito_venta();
      //tablacarrito_venta();
      //cerrar modal
      $("#lista_venta").modal("hide");
     //bloquear select 2
      //$("#buscador_cliente").attr("disabled",true);
    }
    
  })   

}


  </script>