<?php

	# Incluyendo librerias necesarias #
    require "fpdf/code128.php";
    require_once '../../conexion.php';
    //require_once 'fpdf/fpdf.php';
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $feha_actual=date("d-m-Y ");
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $hora_actual=date("H:i:s");
    $numFactura = $_GET['factura'];
    $idlocal = $_GET['local'];
    $idcliente = $_GET['cliente'];
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
        $cuitCliente = (Double)$cuitString;  
        $puntoVenta = $datosfac['puntoVenta'];
        $caja = $datosfac['caja'];
        $vendedor = $datosfac['vendedor'];
        if($puntoVenta == 5){
          $direccion = "VELEZ SARSFIELD 436 - SAN PEDRO DE JUJUY - JUJUY";
        }
        if($puntoVenta == 6){
          $direccion = "9 DE JULIO 432 - SAN PEDRO DE JUJUY - JUJUY";
        }

    $pdf = new PDF_Code128('P','mm',array(80,244));
    $pdf->SetMargins(5,10,5);
    $pdf->AddPage();
    
    # Encabezado y datos de la empresa #
    $pdf->SetFont('Arial','B',10);
    $pdf->SetTextColor(0,0,0);
    $pdf->MultiCell(0,5,utf8_decode(strtoupper("Sabuesos Petshop")),0,'C',false);
    $pdf->SetFont('Arial','',9);
    $pdf->MultiCell(0,5,utf8_decode("CUIT: ".$cuit),0,'C',false);
    $pdf->MultiCell(0,5,utf8_decode("Direccion: ".$direccion),0,'C',false);
    $pdf->MultiCell(0,5,utf8_decode("Teléfono: 3888462499"),0,'C',false);
    //$pdf->MultiCell(0,5,utf8_decode("Email: correo@ejemplo.com"),0,'C',false);

    $pdf->Ln(1);
    $pdf->Cell(0,5,utf8_decode("------------------------------------------------------"),0,0,'C');
    $pdf->Ln(5);

    $pdf->MultiCell(0,5,utf8_decode("Fecha: ".date("d/m/Y", strtotime($feha_actual))." ".date("h:s", strtotime($hora_actual))),0,'C',false);
    $pdf->MultiCell(0,5,utf8_decode($caja),0,'C',false);
    $pdf->MultiCell(0,5,utf8_decode("Cajero: ".$vendedor),0,'C',false);
    $pdf->SetFont('Arial','B',10);
    $pdf->MultiCell(0,5,utf8_decode(strtoupper("Ticket Nro: ".$numFactura)),0,'C',false);
    $pdf->SetFont('Arial','',9);

    $pdf->Ln(1);
    $pdf->Cell(0,5,utf8_decode("------------------------------------------------------"),0,0,'C');
    $pdf->Ln(5);
    
    $pdf->MultiCell(0,5,utf8_decode("Cliente: ".$datosfac['nombre']),0,'C',false);
    $pdf->MultiCell(0,5,utf8_decode("CUIT: ".$datosfac['cuit']),0,'C',false);
    $pdf->MultiCell(0,5,utf8_decode("Teléfono: ".$datosfac['celular']),0,'C',false);
    $pdf->MultiCell(0,5,utf8_decode("Dirección: ".$datosfac['direccion']),0,'C',false);

    $pdf->Ln(1);
    $pdf->Cell(0,5,utf8_decode("-------------------------------------------------------------------"),0,0,'C');
    $pdf->Ln(3);

    # Tabla de productos #
    $pdf->Cell(15,5,utf8_decode("Cant."),0,0,'C');
    $pdf->Cell(5,5,utf8_decode("Precio"),0,0,'C');
    $pdf->Cell(28,5,utf8_decode("Desc."),0,0,'C');
    $pdf->Cell(2,5,utf8_decode("Prec.Final"),0,0,'C');
    $pdf->Cell(28,5,utf8_decode("Total"),0,0,'C');

    $pdf->Ln(3);
    $pdf->Cell(72,5,utf8_decode("-------------------------------------------------------------------"),0,0,'C');
    $pdf->Ln(3);
    $sum=0;
    $query = mysqli_query($conexion, "SELECT cliente.nombre, cliente.celular, usuario.nombre'vendedor', ventas.cantidad, producto.nombre_producto, ventas.subtotal, ventas.gramos, ventas.preciofinal, ventas.total_venta,
    ventas.descuento, ventas.interes FROM ventas 
    INNER JOIN producto on ventas.idproducto=producto.idproducto
    INNER JOIN locales on ventas.idlocal=locales.idlocal 
    INNER JOIN usuario on ventas.idusuario=usuario.idusuario
    INNER JOIN cliente on ventas.idcliente=cliente.idcliente WHERE numero_factura=$numFactura and ventas.idcliente=$idcliente and ventas.idlocal=$idlocal");
    //$datosCarrito = mysqli_fetch_assoc($query);    
    while ($datosCarrito = mysqli_fetch_assoc($query)) {
    /*----------  Detalles de la tabla  ----------*/
    $pdf->MultiCell(0,4,utf8_decode("Producto: ".$datosCarrito['nombre_producto']),0,'C',false);
    $pdf->Cell(9,2,utf8_decode($datosCarrito['cantidad']),0,0,'C');
    $pdf->Cell(19,4,utf8_decode("$".$datosCarrito['subtotal']),0,0,'C');
    $pdf->Cell(15,4,utf8_decode($datosCarrito['descuento']."%"),0,0,'C');
    $pdf->Cell(17,4,utf8_decode("$".$datosCarrito['preciofinal']),0,0,'C');
    $pdf->Cell(5,4,utf8_decode("$".$datosCarrito['total_venta']),0,0,'C');
    $cantidad = $datosCarrito['cantidad'];
    $sum = $sum + $cantidad;
    $pdf->Ln(2);
    //$pdf->MultiCell(0,4,utf8_decode("Garantía de fábrica: 2 Meses"),0,'C',false);
    $pdf->Ln(7);
    /*----------  Fin Detalles de la tabla  ----------*/
    }


    $pdf->Cell(72,5,utf8_decode("-------------------------------------------------------------------"),0,0,'C');

        $pdf->Ln(5);
        $factura = mysqli_query($conexion, "SELECT total, observacion FROM factura WHERE numero_factura='$numFactura' and factura.idlocal = $idlocal and factura.idcliente=$idcliente");
        while ($row = mysqli_fetch_assoc($factura)) {
         
            $total = $row['total'];
            $oberservacion = $row['observacion'];
        }
    # Impuestos & totales #
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(18,5,utf8_decode(""),0,0,'C');
    $pdf->Cell(22,5,utf8_decode("TOTAL VENTA"),0,0,'C');
    $pdf->Cell(32,5,utf8_decode("$".$total),0,0,'C');

    $pdf->Ln(5);
    $pdf->SetFont('Arial','',10);    
    $pdf->Cell(18,5,utf8_decode(""),0,0,'C');
    $pdf->Cell(22,5,utf8_decode("Bultos"),0,0,'C');
    $pdf->Cell(32,5,utf8_decode($sum),0,0,'C');

    $pdf->Ln(5);
   
    $pdf->Cell(18,5,utf8_decode(""),0,0,'C');
    $pdf->Cell(22,5,utf8_decode("Observacion: "),0,0,'C');
    $pdf->Cell(32,5,utf8_decode($oberservacion),0,0,'C');

    $pdf->Ln(5);

    $pdf->Cell(72,5,utf8_decode("-------------------------------------------------------------------"),0,0,'C');

    $pdf->Ln(5);

    /*$pdf->Cell(18,5,utf8_decode(""),0,0,'C');
    $pdf->Cell(22,5,utf8_decode("TOTAL A PAGAR"),0,0,'C');
    $pdf->Cell(32,5,utf8_decode("$70.00 USD"),0,0,'C');

    $pdf->Ln(5);
    
    $pdf->Cell(18,5,utf8_decode(""),0,0,'C');
    $pdf->Cell(22,5,utf8_decode("TOTAL PAGADO"),0,0,'C');
    $pdf->Cell(32,5,utf8_decode("$100.00 USD"),0,0,'C');

    $pdf->Ln(5);

    $pdf->Cell(18,5,utf8_decode(""),0,0,'C');
    $pdf->Cell(22,5,utf8_decode("CAMBIO"),0,0,'C');
    $pdf->Cell(32,5,utf8_decode("$30.00 USD"),0,0,'C');

    $pdf->Ln(5);

    $pdf->Cell(18,5,utf8_decode(""),0,0,'C');
    $pdf->Cell(22,5,utf8_decode("USTED AHORRA"),0,0,'C');
    $pdf->Cell(32,5,utf8_decode("$0.00 USD"),0,0,'C');

    $pdf->Ln(10);*/

    $pdf->MultiCell(0,5,utf8_decode("*** Para poder realizar un reclamo o devolución debe de presentar este ticket ***"),0,'C',false);

    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(0,7,utf8_decode("Gracias por su compra"),'',0,'C');

    $pdf->Ln(0);

    /*
    # Codigo de barras #
    $pdf->Code128(5,$pdf->GetY(),"COD000001V0001",70,20);
    $pdf->SetXY(0,$pdf->GetY()+21);
    $pdf->SetFont('Arial','',14);
    $pdf->MultiCell(0,5,utf8_decode("COD000001V0001"),0,'C',false);*/
    
    # Nombre del archivo PDF #
    $pdf->Output("I","Ticket N° ".$numFactura." "."Clt ".$datosfac['nombre']." "."Cuit ".$cuit.".pdf",true);