<?php
include_once "includes/header.php"; 
include "../conexion.php";
$id_user = $_SESSION['idUser'];
$permiso = "productos";
$sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
$existe = mysqli_fetch_all($sql);
if (empty($existe) && $id_user != 1) {
    echo "<script> window.location.replace('permisos.php') </script>";
}
foreach($_POST as $rownumber_name => $val) {

//remember to clean post values
        $rownumber = $rownumber_name;
        $val = $val;

        //from the fieldname:rownumber_id we need to get rownumber_id
        $split_data = explode(':', $rownumber);
        $rownumber_id = $split_data[1];
        $rownumber_name = $split_data[0];
        //echo $val;
        $rs = mysqli_query($conexion, "UPDATE producto SET $rownumber_name = '$val' WHERE idproducto = '$rownumber_id'");
        if ($rs) {
                echo "<img src='images/loader.gif' height='25px'>";
    
            } else{
                printf("Errormessage: %s\n", $rs);
    
        
            }

}
?>