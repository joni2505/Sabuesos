<?php
require("../conexion.php");

if (!empty($_GET['id'])) {
    $id = $_GET['id'];
    $query_delete = mysqli_query($conexion, "DELETE FROM producto WHERE idproducto = $id");
    mysqli_close($conexion);
    header("Location: lista_productos.php");
}
