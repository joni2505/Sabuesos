<?php 
include 'afip.php-master\src\Afip.php';
//$afip = new Afip(array('CUIT' => 20397385028));
$afip = new Afip([
    'CUIT'=> 20403303462, //<-- ojo ahi!
    'cert' => 'wsaa_homologacion.pe   m',
    'key'=> 'clave-antonio.key',
    'production' => FALSE
    ]);

    $data = array(
        'CantReg' 	=> 1,  // Cantidad de comprobantes a registrar
        'PtoVta' 	=> 1,  // Punto de venta
        'CbteTipo' 	=> 6,  // Tipo de comprobante (ver tipos disponibles) 
        'Concepto' 	=> 1,  // Concepto del Comprobante: (1)Productos, (2)Servicios, (3)Productos y Servicios
        'DocTipo' 	=> 99, // Tipo de documento del comprador (99 consumidor final, ver tipos disponibles)
        'DocNro' 	=> 0,  // Número de documento del comprador (0 consumidor final)
        'CbteDesde' 	=> 1,  // Número de comprobante o numero del primer comprobante en caso de ser mas de uno
        'CbteHasta' 	=> 1,  // Número de comprobante o numero del último comprobante en caso de ser mas de uno
        'CbteFch' 	=> intval(date('Ymd')), // (Opcional) Fecha del comprobante (yyyymmdd) o fecha actual si es nulo
        'ImpTotal' 	=> 121, // Importe total del comprobante
        'ImpTotConc' 	=> 0,   // Importe neto no gravado
        'ImpNeto' 	=> 100, // Importe neto gravado
        'ImpOpEx' 	=> 0,   // Importe exento de IVA
        'ImpIVA' 	=> 21,  //Importe total de IVA
        'ImpTrib' 	=> 0,   //Importe total de tributos
        'MonId' 	=> 'PES', //Tipo de moneda usada en el comprobante (ver tipos disponibles)('PES' para pesos argentinos) 
        'MonCotiz' 	=> 1,     // Cotización de la moneda usada (1 para pesos argentinos)  
        'Iva' 		=> array( // (Opcional) Alícuotas asociadas al comprobante
            array(
                'Id' 		=> 5, // Id del tipo de IVA (5 para 21%)(ver tipos disponibles) 
                'BaseImp' 	=> 100, // Base imponible
                'Importe' 	=> 21 // Importe 
            )
        ), 
    );

    /*$data = array(
        'CantReg' => 1, // Cantidad de comprobantes a registrar
        'PtoVta' => 5, // Punto de venta
        'CbteTipo' => 6, // Tipo de comprobante (ver tipos disponibles)
        'Concepto' => 2, // Concepto del Comprobante: (1)Productos, (2)Servicios, (3)Productos y Servicios
        'DocTipo' => 80, // Tipo de documento del comprador (ver tipos disponibles)(80 CUIT)(96 DNI)
        'DocNro' => 20403303462, // Numero de documento del comprador
        'CbteDesde' => 1, // Numero de comprobante o numero del primer comprobante en caso de ser mas de uno
        'CbteHasta' => 1, // Numero de comprobante o numero del ultimo comprobante en caso de ser mas de uno
        'CbteFch' => intval(date('Ymd')), // (Opcional) Fecha del comprobante (yyyymmdd) o fecha actual si es nulo
        'ImpTotal' => 121, // Importe total del comprobante
        'ImpTotConc' => 0, // Importe neto no gravado
        'ImpNeto' => 100, // Importe neto gravado
        'ImpOpEx' => 0, // Importe exento de IVA
        'ImpIVA' => 21, //Importe total de IVA
        'ImpTrib' => 0, //Importe total de tributos
        'FchServDesde' => NULL, // (Opcional) Fecha de inicio del servicio (yyyymmdd), obligatorio para Concepto 2 y 3
        'FchServHasta' => NULL, // (Opcional) Fecha de fin del servicio (yyyymmdd), obligatorio para Concepto 2 y 3
        'FchVtoPago' => NULL, // (Opcional) Fecha de vencimiento del servicio (yyyymmdd), obligatorio para Concepto 2 y 3
        'MonId' => 'PES', //Tipo de moneda usada en el comprobante (ver tipos disponibles)('PES' para pesos argentinos)
        'MonCotiz' => 1 // Cotización de la moneda usada (1 para pesos argentinos)
        );*/
    

    $res = $afip->ElectronicBilling->CreateNextVoucher($data);

    $res['CAE']; //CAE asignado el comprobante
    $res['CAEFchVto']; //Fecha de vencimiento del CAE (yyyy-mm-dd)
    //$res['voucher_number']; //Número asignado al comprobante
    echo 'CAE: ';
    print_r($res['CAE']);
    echo '<br>';
    echo 'F/V: ';
    print_r($res['CAEFchVto']);
    echo '<br>';
    echo 'N°Factura: ';
    print_r($res['voucher_number']);
    echo '<br>';
    echo 'TOTAL: ';
    print_r('$'.$data['ImpTotal']);
    echo '<br>';
   

    function generateVerifyNumber($res) 
    {
    
        $evens = '';
        $unevens = '';
        $string = strrev($res);
    
        $i = 0;
        
        while ($i < strlen($res))
        {
        
            if ($i % 2 == 0) $unevens += $res[$i];
            else $evens += $res[$i];
            $i++;
        
        }
    
        $sum = $evens + ($unevens * 3);
    
        if (10 - ($sum % 10) == 10) 
        {
        
            $verify_number = 0;
        
        } 
        else 
        {
        
            $verify_number = 10 - ($sum % 10);
        
        }
        
        return $verify_number;
    
    }
   
?>
