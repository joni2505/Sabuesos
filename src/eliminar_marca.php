<?php
require("../conexion.php");

if (!empty($_GET['id'])) {
    $id = $_GET['id'];
    $query_delete = mysqli_query($conexion, "DELETE FROM marcas WHERE idmarca = $id");
    if($query_delete){
        echo '<script language="javascript">';
        echo 'alert("Eliminar Marca");';
        echo 'window.location.href = "lista_productos.php"';
        echo '</script>';
    }
    
    mysqli_close($conexion);
    //header("Location: lista_productos.php");
}