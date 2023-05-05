<?php
	require("../conexion.php");
  
  //traer datos de cuenta
  if(isset($_POST['datos']))
  {
    
    $valores = array();
    $numero = $_POST['numero_factura'];
    
    //CONSULTAR
    $resultados = mysqli_query($conexion,"SELECT cliente.nombre, cliente.apellido, cliente.direccion, cuentas.total, cuentas.fecha,
    cuentas.tipo_cuenta, cuentas.cantidad  FROM cuentas
    INNER JOIN cliente on cuentas.idcliente=cliente.idcliente WHERE cuentas.numero_factura='$numero' ");
    while($consulta = mysqli_fetch_array($resultados))
    {
      
      
      $valores['nombre'] = $consulta['nombre'];
      $valores['apellido'] = $consulta['apellido'];
      $valores['direccion'] = $consulta['direccion'];
      $valores['total_cuenta'] = $consulta['total'];
      $valores['fecha'] = $consulta['fecha'];
      $valores['tipo_cuenta'] = $consulta['tipo_cuenta'];
      $valores['cantidad'] = $consulta['cantidad'];

      
           
    }
    
    
    sleep(1);
    $valores = json_encode($valores);
    echo $valores;
  }

  //datos x clientes nombre
  if(isset($_POST['datos2']))
  {
    
    $valores = array();
    $cliente = $_POST['cliente'];
    
    //CONSULTAR
    $resultados = mysqli_query($conexion,"SELECT cliente.apellido, cliente.direccion, cuentas.total, cuentas.fecha,
    cuentas.tipo_cuenta, cuentas.cantidad, cuentas.numero_factura  FROM cuentas
    INNER JOIN cliente on cuentas.idcliente=cliente.idcliente WHERE cliente.nombre='$cliente'");
    while($consulta = mysqli_fetch_array($resultados))
    {
      
      
      $valores['numero_factura'] = $consulta['numero_factura'];
      $valores['apellido'] = $consulta['apellido'];
      $valores['direccion'] = $consulta['direccion'];
      $valores['total_cuenta'] = $consulta['total'];
      $valores['fecha'] = $consulta['fecha'];
      $valores['tipo_cuenta'] = $consulta['tipo_cuenta'];
      $valores['cantidad'] = $consulta['cantidad'];

      
           
    }
    
    
    sleep(1);
    $valores = json_encode($valores);
    echo $valores;
  }

  //cobrar Cuota
  if(isset($_POST['cobrar_cuotas']))
	{
         $idusuario = $_POST['idusuario'];
        $cuota2 = $_POST['cuota2'];
        $importe = $_POST['importe'];
        $saldo = $_POST['saldo'];
        $mediodepago = $_POST['mediodepago'];
        $numero_factura = $_POST['numero_factura'];
        $total_cuenta = $_POST['total_cuenta'];
        $condicion = 'PAGADO';

        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $fecha_cuota=date("Y-m-d");
        $fechaComoEntero = strtotime($fecha_cuota);
            $año = date("Y", $fechaComoEntero);
            $mes = date("M", $fechaComoEntero);

  
        //validar que no esten los campos vacios de ventas
        $alert = "";
        if (empty($idusuario) || empty($importe)) {
          echo '<script language="javascript">';
          echo 'alert("Campos vacios");';
          echo '</script>';
        }else {

            if($saldo==0){

                $total_cuenta=0;
                $condicion = 'CANCELADO';
                //condicion en 1 borrado logico en cuenta corriente
                $rs = mysqli_query($conexion, "UPDATE cuentas SET estado='1' WHERE cuentas.numero_factura='$numero_factura'");
                if ($rs) {
                    echo '<script language="javascript">';
                    echo 'alert("Se cancelo la Cuenta");';
                    echo '</script>';
                } else {
                    echo '<script language="javascript">';
                    echo 'alert("Error al cancelar cuenta");';
                    echo '</script>';
                }
                $rs = mysqli_query($conexion, "UPDATE cuotas SET estado='1' WHERE cuotas.numero_factura='$numero_factura'");


            }
             //traer ultimo id cuenta
        $rs = mysqli_query($conexion, "SELECT idcuenta, numero_factura FROM cuentas WHERE cuentas.numero_factura='$numero_factura' ORDER BY idcuenta desc LIMIT 1");
        while($row = mysqli_fetch_array($rs))
        {
            $idcuenta=$row['idcuenta'];
            //$numero_factura=$row['numero_factura'];
        
        }

            $rs = mysqli_query($conexion, "INSERT INTO cuotas(idcuenta, numero_factura, fecha, cuota, importe, saldo, total, condicion, mediodepago, idusuario) values ('$idcuenta', '$numero_factura', '$fecha_cuota', '$cuota2', '$importe', '$saldo', '$total_cuenta', '$condicion' , '$mediodepago', '$idusuario')");        
        if ($rs) {
            echo '<script language="javascript">';
            //echo 'alert("Se Cobro la Cuota Correctamente");';
            echo '</script>';
        } else {
            echo '<script language="javascript">';
            echo 'alert("Error al cobrar la cuota");';
            echo '</script>';
        }
        
        //modificar total de cuenta
        $rs = mysqli_query($conexion, "UPDATE cuentas SET total='$saldo' WHERE numero_factura='$numero_factura'");
        if ($rs) {
            echo '<script language="javascript">';
            //echo 'alert("Se Modifico total cuenta");';
            echo '</script>';
        } else {
            echo '<script language="javascript">';
            echo 'alert("Error al modificar Cuenta");';
            echo '</script>';
        }
            
        }
            
        
    }


    //borrar Pago cuota
if(isset($_POST['eliminar_pago']))
{
    
      $idcuota=$_POST['idcuota'];
      date_default_timezone_set('America/Argentina/Buenos_Aires');
      $feha_cuota=date("d-m-Y");
      $rs = mysqli_query($conexion, "SELECT * FROM cuotas WHERE idcuota='$idcuota'");
        while($row = mysqli_fetch_array($rs))
        {
            $importe2=$row['importe'];
            //$saldo2=$row['saldo'];
            $numero_factura2=$row['numero_factura'];
            
            
        
        }
        $rs = mysqli_query($conexion, "SELECT * FROM cuentas WHERE numero_factura='$numero_factura2'");
        while($row = mysqli_fetch_array($rs))
        {
            $total2=$row['total'];
           
        }


        $total3 = $total2 + $importe2;

        //modificar total de la cuenta incrementar
        $rs = mysqli_query($conexion, "UPDATE cuentas SET total='$total3' WHERE numero_factura='$numero_factura2'");
       if ($rs) {
           echo '<script language="javascript">';
           //echo 'alert("Incremente el total de la cuenta ");';
           echo '</script>';
           
       } else {
           echo '<script language="javascript">';
           echo 'alert("error al incrementar");';
           echo '</script>';
       } 

       $rs = mysqli_query($conexion, "DELETE FROM cuotas WHERE idcuota='$idcuota'");
       if ($rs) {
           echo '<script language="javascript">';
           //echo 'alert("Se elimino el pago ");';
           echo '</script>';
           
       } else {
           echo '<script language="javascript">';
           //echo 'alert("Se elimino el pago");';
           echo '</script>';
       }  

}

//eliminar factura cuenta
if(isset($_POST['borrar_factura_cuenta']))
{

  //subir stock al borrar producto de la venta
     $idcuenta=$_POST['idcuenta'];
     
        
     $numero_factura = $_GET['numero_factura'];
     $query_delete = mysqli_query($conexion, "DELETE FROM cuenta_corrientes WHERE idcuenta_corrientes=$idcuenta");
       if ($query_delete) {
           echo '<script language="javascript">';
           echo 'alert("Se elimino la Factura Cuenta Corriente ");';
           echo '</script>';
           $stock2=0;
       } else {
           echo '<script language="javascript">';
           echo 'alert("Error para eliminar factura");';
           echo '</script>';
       } 
  }

?>


