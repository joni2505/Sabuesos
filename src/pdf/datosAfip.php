<?php
include 'afip.php-master\src\Afip.php';
//datos de AFIP
//afip
if (isset($_POST['facturaA'])) {

    $ImporteNeto = $_POST['ImporteNeto'];
    $iva = $_POST['iva'];
    $totalFactura = $_POST['totalFactura'];
    $cuitCliente = (float)$_POST['cuitCliente'];
    $puntoVenta = $_POST['puntoVenta'];

    $afip = new Afip([
        'CUIT' => (float)20403303462, //<-- ojo ahi!
        'cert' => 'wsaa_homologacion.pem',
        'key' => 'clave-antonio.key',
        'production' => false
    ]);

    /*$afip = new Afip([
                'CUIT'=> (double)20403303462, //<-- ojo ahi!
                'cert' => 'sabuesosproduccion.crt',
                'key'=> 'key_antonio.key',
                'production' => true
                ]);*/

    $server_status = $afip->RegisterScopeTen->GetServerStatus();
    /*echo 'Este es el estado del servidor:';
            echo '<pre>';
            print_r($server_status);
            echo '</pre>';*/

    /*$venta=8300;
            $neto = round($venta / 1.21, 2);
            $iva =  round($neto * 0.21, 2);*/
    $PtoVta = $puntoVenta; //punto de venta segun direccion
    $CbteTipo = 1;

    $data = array(
        'CantReg'     => 1,  // Cantidad de comprobantes a registrar
        'PtoVta'     => $PtoVta,  // Punto de venta
        'CbteTipo'     => $CbteTipo,  // Tipo de comprobante (ver tipos disponibles) 
        'Concepto'     => 1,  // Concepto del Comprobante: (1)Productos, (2)Servicios, (3)Productos y Servicios
        'DocTipo'     => 80, // Tipo de documento del comprador (99 consumidor final, ver tipos disponibles)
        'DocNro'     => $cuitCliente,  // Número de documento del comprador (0 consumidor final)
        'CbteDesde'     => 1,  // Número de comprobante o numero del primer comprobante en caso de ser mas de uno
        'CbteHasta'     => 1,  // Número de comprobante o numero del último comprobante en caso de ser mas de uno
        'CbteFch'     => intval(date('Ymd')), // (Opcional) Fecha del comprobante (yyyymmdd) o fecha actual si es nulo
        'ImpTotal'     => $totalFactura, // Importe total del comprobante
        'ImpTotConc'     => 0,   // Importe neto no gravado
        'ImpNeto'     => $ImporteNeto, // Importe neto gravado
        'ImpOpEx'     => 0,   // Importe exento de IVA
        'ImpIVA'     => $iva,  //Importe total de IVA
        'ImpTrib'     => 0,   //Importe total de tributos
        'MonId'     => 'PES', //Tipo de moneda usada en el comprobante (ver tipos disponibles)('PES' para pesos argentinos) 
        'MonCotiz'     => 1,     // Cotización de la moneda usada (1 para pesos argentinos)  
        'Iva'         => array( // (Opcional) Alícuotas asociadas al comprobante
            array(
                'Id'         => 5, // Id del tipo de IVA (5 para 21%)(ver tipos disponibles) 
                'BaseImp'     => $ImporteNeto, // Base imponible
                'Importe'     => $iva // Importe 
            )
        ),
    );
    //datos de contribuyente solo en produccion
    //$taxpayer_details = $afip->RegisterScopeFive->GetTaxpayerDetails(20397385028); //Devuelve los datos del contribuyente correspondiente al identificador 20111111111 
    //print_r($taxpayer_details);

    //Pido ultimo numero autorizado
    $nro = $afip->ElectronicBilling->GetLastVoucher($data['PtoVta'], $data['CbteTipo']);
    if (!is_numeric($nro)) {
        //echo "<br>Error al obtener el ultimo numero autorizado<br>";

    }
    $numero = $nro + 1;

    //$res = $afip->ElectronicBilling->CreateVoucher($data);
    $res = $afip->ElectronicBilling->CreateNextVoucher($data);
    $cae = $res['CAE']; //CAE asignado el comprobante
    //$caefvt = $res['CAEFchVto']; //Fecha de vencimiento del CAE (yyyy-mm-dd)
    $fechaComprobante = $res['CbteFch'] = intval(date('Ymd'));
    $caefvt = date("d/m/Y", strtotime($res['CAEFchVto']));

    //QR = cuit + tipo de comprobante + punto de venta + cae + fecha ven cae
    $cuit = '20403303462';
    $qr = $cuit . str_pad($CbteTipo, 3, "0", STR_PAD_LEFT) . str_pad($PtoVta, 5, "0", STR_PAD_LEFT) . $cae . $caefvt;
}

//factura B
if (isset($_POST['facturaB'])) {

    $ImporteNeto = $_POST['ImporteNeto'];
    $iva = $_POST['iva'];
    $totalFactura = $_POST['totalFactura'];
    $cuitCliente = (float)$_POST['cuitCliente'];
    $puntoVenta = $_POST['puntoVenta'];

    $afip = new Afip([
        'CUIT' => (float)20403303462, //<-- ojo ahi!
        'cert' => 'wsaa_homologacion.pem',
        'key' => 'clave-antonio.key',
        'production' => false
    ]);

    /*$afip = new Afip([
                'CUIT'=> (double)20403303462, //<-- ojo ahi!
                'cert' => 'sabuesosproduccion.crt',
                'key'=> 'key_antonio.key',
                'production' => true
                ]);*/

    $server_status = $afip->RegisterScopeTen->GetServerStatus();
    /*echo 'Este es el estado del servidor:';
            echo '<pre>';
            print_r($server_status);
            echo '</pre>';*/

    /*$venta=8300;
            $neto = round($venta / 1.21, 2);
            $iva =  round($neto * 0.21, 2);*/
    $PtoVta = $puntoVenta; //direccion punto de venta
    $CbteTipo = 6;

    $data = array(
        'CantReg'     => 1,  // Cantidad de comprobantes a registrar
        'PtoVta'     => $PtoVta,  // Punto de venta
        'CbteTipo'     => $CbteTipo,  // Tipo de comprobante (ver tipos disponibles) 
        'Concepto'     => 1,  // Concepto del Comprobante: (1)Productos, (2)Servicios, (3)Productos y Servicios
        'DocTipo'     => 99, // Tipo de documento del comprador (99 consumidor final, ver tipos disponibles)
        'DocNro'     => 0,  // Número de documento del comprador (0 consumidor final)
        'CbteDesde'     => 1,  // Número de comprobante o numero del primer comprobante en caso de ser mas de uno
        'CbteHasta'     => 1,  // Número de comprobante o numero del último comprobante en caso de ser mas de uno
        'CbteFch'     => intval(date('Ymd')), // (Opcional) Fecha del comprobante (yyyymmdd) o fecha actual si es nulo
        'ImpTotal'     => $totalFactura, // Importe total del comprobante
        'ImpTotConc'     => 0,   // Importe neto no gravado
        'ImpNeto'     => $ImporteNeto, // Importe neto gravado
        'ImpOpEx'     => 0,   // Importe exento de IVA
        'ImpIVA'     => $iva,  //Importe total de IVA
        'ImpTrib'     => 0,   //Importe total de tributos
        'MonId'     => 'PES', //Tipo de moneda usada en el comprobante (ver tipos disponibles)('PES' para pesos argentinos) 
        'MonCotiz'     => 1,     // Cotización de la moneda usada (1 para pesos argentinos)  
        'Iva'         => array( // (Opcional) Alícuotas asociadas al comprobante
            array(
                'Id'         => 5, // Id del tipo de IVA (5 para 21%)(ver tipos disponibles) 
                'BaseImp'     => $ImporteNeto, // Base imponible
                'Importe'     => $iva // Importe 
            )
        ),
    );
    //datos de contribuyente solo en produccion
    //$taxpayer_details = $afip->RegisterScopeFive->GetTaxpayerDetails(20397385028); //Devuelve los datos del contribuyente correspondiente al identificador 20111111111 
    //print_r($taxpayer_details);

    //Pido ultimo numero autorizado
    $nro = $afip->ElectronicBilling->GetLastVoucher($data['PtoVta'], $data['CbteTipo']);
    if (!is_numeric($nro)) {
        //echo "<br>Error al obtener el ultimo numero autorizado<br>";

    }
    $numero = $nro + 1;

    //$res = $afip->ElectronicBilling->CreateVoucher($data);
    $res = $afip->ElectronicBilling->CreateNextVoucher($data);
    $cae = $res['CAE']; //CAE asignado el comprobante
    //$caefvt = $res['CAEFchVto']; //Fecha de vencimiento del CAE (yyyy-mm-dd)
    $fechaComprobante = $res['CbteFch'] = intval(date('Ymd'));
    $caefvt = date("d/m/Y", strtotime($res['CAEFchVto']));

    //QR = cuit + tipo de comprobante + punto de venta + cae + fecha ven cae
    $cuit = '20403303462';
    $qr = $cuit . str_pad($CbteTipo, 3, "0", STR_PAD_LEFT) . str_pad($PtoVta, 5, "0", STR_PAD_LEFT) . $cae . $caefvt;
}
?>
<script type="text/javascript">
    function a() {
        //alert("Ready!");
        var numFactura = <?= json_encode($numero) ?>;
        alert(numFactura);
        var cae = <?= json_encode($cae) ?>;
        var caefvt = <?= json_encode($caefvt) ?>;
        var qr = <?= json_encode($qr) ?>;
        var caefvt = <?= json_encode($caefvt) ?>;
        var fechaComprobante = <?= json_encode(date("d/m/Y", strtotime($fechaComprobante))) ?>;
        $("#numFactura").val(numFactura);
        $("#numFactura2").val(numFactura);
        $("#cae").val("CAE: " + cae);
        $("#caefvt").val("Fecha Vto. CAE: " + caefvt);
        $("#cae2").val("CAE: " + cae);
        $("#caefvt2").val("Fecha Vto. CAE: " + caefvt);
        $("#fecha").val("Fecha: " + fechaComprobante);
        $("#fecha2").val("Fecha: " + fechaComprobante);
        $("#qr").val(qr);
        $("#qr2").val(qr);
        window.print();
    }

    function b() {
        //alert("Ready!");
        var numFactura = <?= json_encode($numero) ?>;
        var cae = <?= json_encode($cae) ?>;
        var caefvt = <?= json_encode($caefvt) ?>;
        var qr = <?= json_encode($qr) ?>;
        var caefvt = <?= json_encode($caefvt) ?>;
        var fechaComprobante = <?= json_encode(date("d/m/Y", strtotime($fechaComprobante))) ?>;
        $("#numFactura").val(numFactura);
        $("#numFactura2").val(numFactura);
        $("#cae").val("CAE: " + cae);
        $("#caefvt").val("Fecha Vto. CAE: " + caefvt);
        $("#cae2").val("CAE: " + cae);
        $("#caefvt2").val("Fecha Vto. CAE: " + caefvt);
        $("#fecha").val("Fecha: " + fechaComprobante);
        $("#fecha2").val("Fecha: " + fechaComprobante);
        $("#qr").val(qr);
        $("#qr2").val(qr);
        window.print();
    }
</script>