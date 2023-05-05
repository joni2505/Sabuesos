<?php 
//include_once "includes/header.php";
include "../conexion.php";
$config = mysqli_query($conexion, "SELECT * FROM configuracion");
$datos = mysqli_fetch_assoc($config);
$idcierre = $_GET['id'];
date_default_timezone_set('America/Argentina/Buenos_Aires');
$feha_actual=date("d-m-Y H:i:s");

$rs = mysqli_query($conexion, "SELECT idcaja FROM cierre WHERE cierre.idcierre='$idcierre' LIMIT 1");
        while($row = mysqli_fetch_array($rs))
        {
            $idcaja=$row['idcaja'];
            //$numero_factura=$row['numero_factura'];
        
        }

$datosTotal = mysqli_query($conexion, "SELECT COUNT(idventa)'total' FROM ventas WHERE idcaja='$idcaja'");
while($row = mysqli_fetch_array($datosTotal))
        {
            $total=$row['total'];
          
        
        }

?>
<!DOCTYPE HTML5>
<html>
	<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Recaudacion de la Caja</title>
    
    <link href="../assets/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <link rel="stylesheet" href="../assets/js/jquery-ui/jquery-ui.min.css">
    <script src="../assets/js/all.min.js" crossorigin="anonymous"></script>
	</head >
    
	
    <body onload="window.print()">
    
    <img class="img-thumbnail" src="sabueso.jpg" width="400">

    <h4>Fecha y Hora <?php echo $feha_actual?></h4>
    <h4>Celular: <?php echo $datos['telefono'];?>  </h4> 
    <h4>Direccion: <?php echo $datos['direccion'];?>  </h4>
    <h4>Correo: <?php echo $datos['email'];?>  </h4>
     

<h4 class="font-weight-light my-4"><center>Detalle de Caja</center></h4>
		<table style="border-collapse: collapse;" border="1"; width="700"; height= "100px";>
		
        <thead class="thead-dark">
		<tr width="100"  rowspan="4">
                 <th>#</th>
                 <th>Efectivo de Venta</th>
                 <th>Gastos en Efectivo</th>
                 <th>Saldo Inicial</th>
                 <th>Fecha de Cierre</th>
                 <th>Hora de Cierre</th>
                 <th>Caja</th>
                
           
		<tr>
        </thead>
         <tbody>
         <?php
                $query = mysqli_query($conexion, "SELECT cierre.efectivo_venta, cierre.gastos, cierre.saldo_caja,
                date_format(cierre.fecha_cierre, '%d-%m-%Y')'fecha_cierre', cierre.hora_cierre, caja.nombre_caja, apertura.saldo_inicial FROM cierre 
                INNER JOIN caja on cierre.idcaja=caja.idcaja
                INNER JOIN apertura on caja.idcaja=apertura.idcaja
                 WHERE cierre.idcierre='$idcierre';");

                $i=1;
                while ($data = mysqli_fetch_assoc($query)) {
                      
                ?>
                     <tr style=" border: inset 0pt" colspan="23" align="center">
                     <td><?php echo $i; ?></td>
                     <td><?php echo $data['efectivo_venta']; ?></td>
                         <td><?php echo $data['gastos']; ?></td>
                         <td><?php echo $data['saldo_inicial']; ?></td>
                         <td><?php echo $data['fecha_cierre']; ?></td>
                         <td><?php echo $data['hora_cierre']; ?></td>
                         <td><?php echo $data['nombre_caja']; ?></td>
                         
                     </tr>
             <?php $i++; }
            ?>
        </tbody>
		</table>

        <?php 
         
         $rs = mysqli_query($conexion,"SELECT efectivo, transferencia, credito, debito, cuenta_corriente, venta_total, saldo_inicial  FROM cajadetalle WHERE idcierre='$idcierre'");
                while($row = mysqli_fetch_array($rs))
                {
                  $efectivo= $row['efectivo'];
                  $transferencia = $row['transferencia'];
                  $credito = $row['credito'];
                  $debito = $row['debito'];
                  $cuenta = $row['cuenta_corriente'];
                  $venta_total = $row['venta_total'];
                  $saldo_inicio = $row['saldo_inicial'];
                  
                }
                  $total_efectivo=$efectivo+$saldo_inicio;
                echo '
                
                <h3>Recaudacion de la Caja</h3>
                <h3>Efectivo: '.'$'.$total_efectivo.'</h3>
                <h3>Transferencia: '.'$'.$transferencia.'</h3>
                <h3>Tarjeta de Credito: '.'$'.$credito.'</h3>
                <h3>Tarjeta de Debito: '.'$'.$debito.'</h3>
                <h3>Cuenta Corriente: '.'$'.$cuenta.'</h3>
                ------------------------------------------
                <h3>Recaudacion Total</h3>
                <h3>Total: '.'$'.$venta_total.'</h3>
                <h3>Productos Vendidos: '.$total.'</h3>
                
                ';
        
        ?>


	</body>
</html>