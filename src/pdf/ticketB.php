<?php
//include_once "includes/header.php";
require_once '../../conexion.php';
//require_once('qrcode/qrcode.class.php');
//include 'afip.php-master\src\Afip.php';
// Llamando a la libreria PHPQRCODE
include('phpqrcode/qrlib.php');
$config = mysqli_query($conexion, "SELECT * FROM configuracion");
$datos = mysqli_fetch_assoc($config);

date_default_timezone_set('America/Argentina/Buenos_Aires');
$feha_actual = date("d-m-Y");
date_default_timezone_set('America/Argentina/Buenos_Aires');
$hora_actual = date("H:i:s");
$numFactura = $_GET['factura'];
$cuit = 20403303462;
$factura = mysqli_query($conexion, "SELECT cliente.celular,cliente.direccion, cliente.cuit, cliente.nombre, cliente.celular, usuario.usuario,
factura.numero_factura, total, ventas.descuento, ventas.interes, factura.importe, factura.cambio, factura.fecha,
producto.codigo_producto'codigo', producto.nombre_producto, ventas.cantidad, factura.tipoventa, factura.mediopago,
factura.observacion, usuario.usuario'vendedor', factura.idlocal, locales.puntoVenta, supercaja.nombreCaja'caja'
FROM factura 
INNER JOIN ventas on factura.numero_factura=ventas.numero_factura
INNER JOIN producto on ventas.idproducto=producto.idproducto
INNER JOIN cliente on factura.idcliente=cliente.idcliente
INNER JOIN usuario on factura.idusuario=usuario.idusuario
INNER JOIN supercaja on factura.idcaja=supercaja.idsuperCaja
INNER JOIN locales on factura.idlocal=locales.idlocal WHERE factura.numero_factura='$numFactura'");
$datosfac = mysqli_fetch_assoc($factura);
$cuitString = $datosfac['cuit'];
$cuitCliente = (float)$cuitString;
$puntoVenta = $datosfac['puntoVenta'];
$caja = $datosfac['caja'];
$vendedor = $datosfac['vendedor'];
if ($puntoVenta == 5) {
    $direccion = "VELEZ SARSFIELD 436 - SAN PEDRO DE JUJUY - JUJUY";
}
if ($puntoVenta == 6) {
    $direccion = "9 DE JULIO 432 - SAN PEDRO DE JUJUY - JUJUY";
}

?>

<!DOCTYPE html>
<html>

<head>
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <style>
        html {
            margin-left: 0;
            margin-right: 0;
            min-height: none;
            min-width: none;
            max-width: 300px;
            max-height: 60px;
            /*background-color: papayawhip; 
        margin: 0 auto;*/
        }
    </style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>FACTURA A WEBSERVICE</title>
</head>

<body onload="myFunctionB()">
    <p style="font-size: 16px; font-family: Arial, Helvetica, sans-serif; text-align:center; font-weight: bold;">--SABUESOS PETSHOP--</p>
    <span style="border-image: initial; border: 0px solid blue; font-family: Arial, Helvetica">
        <p style="font-size: 12px; text-align:center;"> CUIT:</b> 20403303462</p>
        <p style="font-size: 12px; text-align:center;"> Ingresos Brutos:</b> 20403303462</p>
        <p style="font-size: 12px; text-align:center;"> Inicio de Actividad:</b> 01/03/2021</p>
        <p style="font-size: 12px; text-align:center;"> Domicilio:</b> <?php echo $direccion; ?></p>
    </span>
    <p>--------------------------------------</p>
    <span style="border-image: initial; border: 0px solid blue; font-family: Arial, Helvetica">
        <p style="font-size: 12px; text-align:center;"><input id="fecha" style="border: none; text-align:center;"></p>
        <p style="font-size: 12px; text-align:center;"> <?php echo $caja; ?></p>
        <p style="font-size: 12px; text-align:center;"> Cajero: <?php echo $vendedor; ?> </p>
        <p style="font-size: 14px;"> Ticket <span style="border: 1px solid black; font-size: 20px;">B</span> </p>
        <p style="font-size: 12px;">N°0000 <?php echo $puntoVenta; ?> <input id="numFactura" style="border: none; font-size: 12px; text-align:left;"></p>
    </span>
    <p>--------------------------------------</p>
    <span style="border-image: initial; border: 0px solid blue; font-family: Arial, Helvetica">
        <p style="font-size: 12px; text-align:center;"> Cliente: <?php echo $datosfac['nombre'] ?></p>
        <p style="font-size: 12px; text-align:center;"> CUIT: <?php echo $datosfac['cuit']  ?></p>
        <p style="font-size: 12px; text-align:center;"> Domicilio: <?php echo $datosfac['direccion'] ?></p>
    </span>
    <p>--------------------------------------</p>
    <table>
        <thead class="thead-dark" style="align-content: center;">
            <tr style='font-size: 12px;' width="12" rowspan="4">

                <th>Cant.</th>
                <th>Precio</th>
                <th>Desc.</th>
                <th>Int.</th>
                <th>Prec.Final</th>
                <!--<th>SubTotal</th>-->
                <th>SubTotal</th>
                <th></th>

            </tr>
        </thead>
        <tbody>
            <?php
            $contadorCantidad = 0;
            $contadorSubTotal = 0;
            $acInteres = 0;
            require_once '../../conexion.php';
            $sum = 0;
            $query = mysqli_query($conexion, "SELECT cliente.nombre, cliente.celular, usuario.usuario, factura.numero_factura, total, ventas.descuento, ventas.interes, factura.importe, factura.cambio, factura.fecha, producto.nombre_producto, producto.codigo_producto'codigo',
                    ventas.cantidad, factura.tipoventa, producto.precio_producto'precio', ventas.interes, ventas.total_venta, factura.mediopago,ventas.gramos, ventas.subtotal, ventas.preciofinal FROM factura 
                            INNER JOIN ventas on factura.numero_factura=ventas.numero_factura
                            INNER JOIN producto on ventas.idproducto=producto.idproducto
                            INNER JOIN cliente on factura.idcliente=cliente.idcliente
                            INNER JOIN usuario on factura.idusuario=usuario.idusuario WHERE factura.numero_factura='$numFactura'");


            $i = 1;
            $result = mysqli_num_rows($query);
            if ($result > 0) {
                while ($data = mysqli_fetch_assoc($query)) {

            ?>
                    <tr style="font-family: Arial;">
                        <?php

                        if ($data['gramos'] > 0) {
                            echo "<td colspan='6' style='font-size: 12px;'>" . $data['nombre_producto'] . " " . "(suelto)" . "</td>";
                            $gr = $data['gramos'] . "gr";
                        } else {

                            echo "<td  colspan='6' style='font-size: 12px; text-align:center;'>" . $data['nombre_producto'] . "</td>";
                            $gr = "gr";
                        }
                        ?>
                    </tr>
                    <tr style="font-family: Arial;" colspan="23" align="center">

                        <td style='font-size: 12px;'><?php echo $data['cantidad']; ?></td>

                        <?php
                        $subInteres2 = 0;
                        $precioPro = $data['precio'];
                        $cantidad = $data['cantidad'];
                        $precioFinal = $data['subtotal'];
                        $Subtotal = $data['total_venta'];
                        $subInteres = 0;
                        //acumal los importes en credito
                        $interes = $data['interes'];
                        if ($interes > 0) {
                            $subInteres = $acInteres + $Subtotal;
                            $subInteres2 = $subInteres;
                            //echo $subInteres2;
                        }

                        ?>
                        <td style='font-size: 12px;'><?php echo "$" . $precioPro; ?></td>
                        <!--<td style='font-size: 12px;'><?php echo $gr; ?></td>-->
                        <td style='font-size: 12px;'><?php echo $data['descuento']; ?></td>
                        <td style='font-size: 12px;'><?php echo $data['interes']; ?></td>
                        <td style='font-size: 12px;'><?php echo "$" . $precioFinal; ?></td>
                        <td style='font-size: 12px;'><?php echo "$" . $Subtotal; ?></td>


                    </tr>

            <?php

                    //total de bultos
                    $contadorCantidad = $cantidad + $contadorCantidad;
                    $totalBultos = $contadorCantidad;
                    //total Factura
                    $contadorSubTotal = $Subtotal + $contadorSubTotal;

                    $i++;
                    $ImporteNeto = round($contadorSubTotal / 1.21, 2);

                    $iva =  round($ImporteNeto * 0.21, 2);
                    $totalFactura = round($ImporteNeto + $iva, 2);
                }
            } ?>
        </tbody>
    </table>
    <div id="mostrar_mensaje"></div>
    <p>--------------------------------------</p>
    <p><?php echo"TOTAL BULTOS: ".$totalBultos; ?></p>
    <p><?php echo"TOTAL VENTA: ".$totalFactura; ?></p>
    <p>--------------------------------------</p>
    <div class="col-md-6">
        <?php
        // Ingresamos el contenido de nuestro Código QR
        $contenido = '<input type="hidden" id="qr">';
        echo $contenido;
        // Exportamos una imagen llamado resultado.png que contendra el valor de la avriable $content
        QRcode::png($contenido, "resultado.png", QR_ECLEVEL_L, 3, 2);

        // Impresión de la imagen en el navegador listo para usarla
        echo "<div'><img style='float:left' src='resultado.png'/></div>";
        ?>
    </div>
</body>


<?php echo "<div><img src='afip.jpg' width='140' height='80'/></div>"; ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script>
    function myFunctionB() {
        //obtener variables php
        var ImporteNeto = <?= json_encode($ImporteNeto) ?>;
        var iva = <?= json_encode($iva) ?>;
        var totalFactura = <?= json_encode($totalFactura) ?>;
        var cuitCliente = <?= json_encode($cuitCliente) ?>;
        var puntoVenta = <?= json_encode($puntoVenta) ?>;
        var parametros = {
            "facturaB": "1",
            "ImporteNeto": ImporteNeto,
            "iva": iva,
            "totalFactura": totalFactura,
            "cuitCliente": cuitCliente,
            "puntoVenta": puntoVenta



        };
        $.ajax({
            data: parametros,
            url: 'datosAfip.php',
            type: 'post',

            error: function() {
                alert("Error evento");
            },

            success: function(mensaje) {
                $('#mostrar_mensaje').html(mensaje);
                b();

            }

        })

    }
</script>