<?php include_once "includes/header.php"; 
require("../conexion.php");
$id_user = $_SESSION['idUser'];
$permiso = "informes";
  $sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
  $existe = mysqli_fetch_all($sql);
  if (empty($existe) && $id_user != 1) {
    echo "<script> window.location.replace('permisos.php') </script>";
  }
$id_user = $_SESSION['idUser'];
$rs = mysqli_query($conexion,"SELECT usuario.idlocal, locales.nombre_local FROM usuario INNER JOIN locales on usuario.idlocal=locales.idlocal WHERE usuario.idusuario ='$id_user'");
            while($row = mysqli_fetch_array($rs))
            {
              //$valores['existe'] = "1"; //Esta variable no la usamos en el vídeo (se me olvido, lo siento xD). Aqui la uso en la linea 97 de registro.php
              $local = $row['nombre_local'];
              $idlocal = $row['idlocal'];
            }
date_default_timezone_set('America/Argentina/Buenos_Aires');
$fecha=date("Y-m-d H:i:s");
$fechaComoEntero = strtotime($fecha);
$año = date("Y", $fechaComoEntero);
$mes = date("m", $fechaComoEntero);
$mesText="";
//echo $mes;
if($mes==1){
    $mesText="Enero";
  }
  if($mes==2){
    $mesText="Febrero";
  }
  if($mes==3){
    $mesText="Marzo";
  }
  if($mes==4){
    $mesText="Abril";
  }
  if($mes==5){
    $mesText="Mayo";
  }
  if($mes==6){
    $mesText="Junio";
  }
  if($mes==7){
    $mesText="Julio";
  }
  if($mes==8){
    $mesText="Agosto";
  }
  if($mes==9){
    $mesText="Septiembre";
  }
  if($mes==10){
    $mesText="Octubre";
  }
  if($mes==11){
    $mesText="Noviembre";
  }
  if($mes==12){
    $mesText="Diciembre";
  }

?>

<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Panel de Administración</h1>
        <a href="#" onclick="printHTML()"; class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i><font _mstmutation="1" _msthash="507598" _msttexthash="259831">Imprimir</font></a>

	</div>
	<div class="row">
		<div class="col-lg-12">
<div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800" _msthash="538967" _msttexthash="177827">Informes estadisticos</h1>
                        <!--<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i><font _mstmutation="1" _msthash="507598" _msttexthash="259831"> Generar informe</font></a>-->
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1" _msthash="2191176" _msttexthash="418860" style='font-size: 15px;'> Productos mas Vendidos (TOP5)</div>
                                            <!--<div class="h5 mb-0 font-weight-bold text-gray-800" _msthash="2191319" _msttexthash="42484">$40,000</div>-->
                                           <?php
                                            include "../conexion.php";

						$query = mysqli_query($conexion, "SELECT DISTINCT producto.nombre_producto, COUNT(ventas.idproducto) AS 'total_lista' FROM ventas INNER JOIN producto on ventas.idproducto=producto.idproducto WHERE ventas.idlocal=$idlocal GROUP BY ventas.idproducto ORDER BY  COUNT(ventas.idproducto) DESC LIMIT 5");
						$result = mysqli_num_rows($query);
						if ($result > 0) {
                            $i = 1;
							while ($data = mysqli_fetch_assoc($query)) { ?>
								<tr>
									<a href="" style='color: black'><?php echo $i."-".$data['nombre_producto']; ?></a><br>
									
									<?php if ($_SESSION['idUser'] == 1) { ?>
									
									<?php } ?>
								</tr>
						<?php  $i++; }
                       
						} ?>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1" _msthash="2192242" _msttexthash="339118" style='font-size: 15px;'> Mejores Clientes (TOP 5)</div>
                                            <!--<div class="h5 mb-0 font-weight-bold text-gray-800" _msthash="2192385" _msttexthash="52013">$ 215.000</div>-->
                                            <?php
                                            include "../conexion.php";

						$query = mysqli_query($conexion, "SELECT cliente.nombre, COUNT(ventas.idcliente) AS 'ventas' FROM ventas INNER JOIN cliente on ventas.idcliente=cliente.idcliente WHERE ventas.idlocal=$idlocal  GROUP BY ventas.idcliente ORDER BY COUNT(ventas.idcliente) DESC LIMIT 5");
						$result = mysqli_num_rows($query);
						if ($result > 0) {
                            $i = 1;
							while ($data = mysqli_fetch_assoc($query)) { ?>
								<tr>
									<a href="" style='color: black'><?php echo $i."-".$data['nombre']; ?></a><br>
									
									<?php if ($_SESSION['idUser'] == 1) { ?>
									
									<?php } ?>
								</tr>
						<?php  $i++; }
                       
						} ?>
                                        </div>
                                        <div class="col-auto">
                                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1" _msthash="2193308" _msttexthash="76011" style='font-size: 15px;'>Recaudacion Anual </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    
                                                <?php
                                            include "../conexion.php";

						$query = mysqli_query($conexion, "SELECT COUNT(ventas.idventa)'cantidad_anual', SUM(ventas.total_venta)'total_anual'  FROM ventas WHERE año=$año and ventas.idlocal=$idlocal ");
						$result = mysqli_num_rows($query);
						if ($result > 0) {
                            $i = 1;
							while ($data = mysqli_fetch_assoc($query)) { ?>
								<tr>
									<a href="" style='font-size: 40px; text-transform: uppercase; color: black;'><?php echo "$". $data['total_anual']; ?></a><br>
									<a href="" style='font-size: 20px; text-transform: uppercase; color: black;'><?php echo "AÑO: ".$año ?> </a>
									<?php if ($_SESSION['idUser'] == 1) { ?>
									
									<?php } ?>
								</tr>
						<?php  $i++; }
                       
						} ?>

                                                 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                          
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1" _msthash="2194374" _msttexthash="496548" style='font-size: 15px;'> Recaudacion Mensual</div>
                                            <?php
                                            include "../conexion.php";
                        
						$query = mysqli_query($conexion, "SELECT  SUM(ventas.total_venta)'total_anual'  FROM ventas WHERE mes='$mesText' and ventas.idlocal=$idlocal ");
						$result = mysqli_num_rows($query);
						if ($result > 0) {
                            $i = 1;
							while ($data = mysqli_fetch_assoc($query)) { ?>
								<tr>
									<a href="" style='font-size: 40px; text-transform: uppercase; color: black;'><?php echo "$". $data['total_anual']; ?></a><br>
                                    <a href="" style='font-size: 20px; text-transform: uppercase; color: black;'><?php echo "MES: ".$mesText ?> </a>

									<?php if ($_SESSION['idUser'] == 1) { ?>
									
									<?php } ?>
								</tr>
						<?php  $i++; }
                       
						} ?>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Project Card Example -->
                    <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Portada</h6>
                                </div>
                                <div class="card-body">
                                <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                    <img class="d-block w-10" src="img/logo.jpg" alt="First slide">
                                    </div>
                                    <div class="carousel-item">
                                    <img class="d-block w-10" src="img/sabueso.jpg" alt="Second slide">
                                    </div>
                                    <div class="carousel-item">
                                    <img class="d-block w-10" src="img/portada.jpg"  alt="Third slide">
                                    </div>
                                </div>
                                </div>
                                </div>
                            </div>


                            


                    </div>
		</div>
	</div>



</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<script>   
    function printHTML() { 
  if (window.print) { 
    window.print();
  }
}
</script>  
<?php include_once "includes/footer.php"; ?>