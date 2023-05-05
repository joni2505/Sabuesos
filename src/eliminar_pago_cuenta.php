<?php
require("../conexion.php");
if (!empty($_GET['id'])) {
    $id = $_GET['id'];
    $recibido_ahora = $_GET['recibido'];
    $numero_factura = $_GET['numero'];
    //$gran_total = 0;
    //$cantidad_recibida = 0;
    $rs = mysqli_query($conexion, "SELECT gran_total, restante, cantidad_recibida, estado FROM cuenta_corrientes WHERE numero_factura='$numero_factura'");
                while($row = mysqli_fetch_array($rs))
                {
                    $gran_total=$row['gran_total'];
                    // = $row['restante'];
                    $cantidad_recibida = $row['cantidad_recibida'];
                    $estado = $row['estado'];
    
                }
    if($estado == "No recibido"){            
    $regreso = $gran_total + $recibido_ahora;
    $cantidadrecibida_regreso = $cantidad_recibida - $recibido_ahora;
    $restante_regreso = $regreso - $cantidadrecibida_regreso;
    //echo $restante_regreso;
    $restante =0;
      if($restante_regreso == $regreso){
        $restante = 0;
      }
      if ($restante_regreso < $regreso){
        $restante = $restante_regreso;
      }
    $rs = mysqli_query($conexion, "UPDATE cuenta_corrientes SET gran_total='$regreso', cantidad_recibida='$cantidadrecibida_regreso', restante='$restante' WHERE numero_factura='$numero_factura' ");
      if ($rs) {
          echo '<script language="javascript">';
          //echo 'alert("se regresaron los datos");';
          echo '</script>';
      } else {
          echo '<script language="javascript">';
          //echo 'alert("Error al regresar");';
          echo '</script>';
      }
    

        $query_delete = mysqli_query($conexion, "DELETE FROM pagos_cuenta WHERE idpagos_cuenta='$id'");
        mysqli_close($conexion);
        header("Location: cobrar_cuenta_corriente.php");
    }
    else
    if($estado == "Recibido"){
    
        header("Location: cobrar_cuenta_corriente.php");
      
    }             
    
}