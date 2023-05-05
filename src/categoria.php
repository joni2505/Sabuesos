<?php
//require 'vistas/header.php';
require_once 'afip/src/Afip.php';
$afip = new Afip(array('CUIT' => 20397385028));

$currencies_types = $afip->ElectronicBilling->GetCurrenciesTypes();

?>
