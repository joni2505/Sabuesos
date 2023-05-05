<?php include_once "includes/header.php";
    include "../conexion.php";
$id_user = $_SESSION['idUser'];
$permiso = "productos";
//$sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
//$existe = mysqli_fetch_all($sql);
//if (empty($existe) && $id_user != 1) {
  //header("Location: permisos.php");
//}
if (!empty($_POST)) {
  
     
        $marca= $_POST['marca'];
        $detalle = $_POST['detalle'];
        $rubros = $_POST['rubros'];   

        
        if (empty($marca)) {
            echo '<script language="javascript">';
            echo 'alert("todos los campos son Obligatorios");';
            echo 'window.location.href = "lista_productos.php"';
            echo '</script>';
            
            
            
        } else {
            $query = mysqli_query($conexion, "SELECT * FROM marcas WHERE nombre_marca ='$marca'");
            $result = mysqli_fetch_array($query);
            if ($result > 0) {
                echo '<script language="javascript">';
                echo 'alert("Ya existe esa marca");';
                echo 'window.location.href = "lista_productos.php"';
                echo '</script>';    
            } else {
				$query_insert = mysqli_query($conexion,"INSERT INTO marcas(nombre_marca, detalle, idrubro) values ('$marca', '$detalle', '$rubros')");
                if ($query_insert) {
                    echo '<script language="javascript">';
                    echo 'alert("Se Agrego la marca correctamente");';
                    echo 'window.location.href = "lista_productos.php"';
                    echo '</script>';
                    
                } else {
                    echo '<script language="javascript">';
                    echo 'alert("Error al Crear");';
                    echo 'window.location.href = "lista_productos.php"';
                    echo '</script>';
                    
              
              
                }
            }
        }
}
?> 