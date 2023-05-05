<?php include_once "includes/header.php";
    include "../conexion.php";
$id_user = $_SESSION['idUser'];
//$permiso = "gastos";
//$sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
//$existe = mysqli_fetch_all($sql);
//if (empty($existe) && $id_user != 1) {
  //header("Location: permisos.php");
//}
if (!empty($_POST)) {
    $alert = "";
     
        $rubro= $_POST['rubro'];
        $detalle = $_POST['detalle'];
           

        
        if (empty($rubro)) {
            echo '<script language="javascript">';
            echo 'alert("todos los campos son Obligatorios");';
            echo 'window.location.href = "lista_productos.php"';
            echo '</script>';
            
            
            
        } else {
            $query = mysqli_query($conexion, "SELECT * FROM rubro WHERE nombre_rubro ='$rubro'");
            $result = mysqli_fetch_array($query);
            if ($result > 0) {
                echo '<script language="javascript">';
                echo 'alert("Ya existe el rubro");';
                echo 'window.location.href = "lista_productos.php"';
                echo '</script>';    
            } else {
				$query_insert = mysqli_query($conexion,"INSERT INTO rubro(nombre_rubro, detalle) values ('$rubro', '$detalle')");
                if ($query_insert) {
                    echo '<script language="javascript">';
                    echo 'alert("Se Agrego el Rubro correctamente");';
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