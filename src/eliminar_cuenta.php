<?php
require("../conexion.php");
$id_user = $_SESSION['idUser'];
$permiso = "cuenta_corriente";
$sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
$existe = mysqli_fetch_all($sql);
if (empty($existe) && $id_user != 1) {
    header("Location: factura_cuenta_corriente.php");
}
if (!empty($_GET['id'])) {
    $id = $_GET['id'];
    $numero_factura = $_GET['numero_factura'];
    $cliente = $_GET['cliente'];
    $query_delete = mysqli_query($conexion, "DELETE FROM cuenta_corrientes WHERE idcuenta_corrientes=$id");
    if ($query_delete) {
        echo '<script language="javascript">';
        echo "<script> window.location.replace('editar_cuenta.php?numero_factura=$numero_factura'&cliente=$cliente) </script>";
        echo '</script>';
        $stock2=0;
    } else {
        echo '<script language="javascript">';
        echo 'alert("Error para eliminar factura");';
        echo '</script>';
    } 
    //$query_delete2 = mysqli_query($conexion, "DELETE FROM carrito_cuenta WHERE numero_factura=$numero_factura");
    mysqli_close($conexion);
    header("Location: factura_cuenta_corriente.php");
}