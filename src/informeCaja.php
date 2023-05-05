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


?>

<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Detalles de Caja</h1>
        <a href="#" onclick="printHTML()"; class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i><font _mstmutation="1" _msthash="507598" _msttexthash="259831">Imprimir</font></a>
           
	</div>
	<div class="row">
		<div class="col-lg-12">
<div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                          
                                    <select class="form-control" name="caja" id="caja" style='font-size: 15px; width:100%; text-transform: uppercase; color: black;' onchange="detalleCaja()">
                                           <option value="0">Seleccionar Caja</option>       
                                                  <?php
                                                        //traer sedes
                                                        include "../conexion.php";
                                                    $query = mysqli_query($conexion, "SELECT * FROM supercaja where estado=1 ");
                                                     
                                                    while($row = mysqli_fetch_assoc($query))
                                                    {
	                                                
                                                    $nom_caja = $row['nombreCaja'];
                                                    $idcaja = $row['idsuperCaja'];
                                                    $fechaAper = $row['fechaApertura'];
                                                    
													                        ?>
													
                                                    <option value="<?php echo $idcaja; ?>"><?php echo $nom_caja."  ".date('d-m-Y',strtotime($fechaAper));?></option>  

                                                    <?php
                                                     }
                                                    
                                                     ?>
								                      </select>
                           
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
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1" _msthash="2191176" _msttexthash="418860" style='font-size: 15px;'> Total Efectivo</div>
                                            <!--<div class="h5 mb-0 font-weight-bold text-gray-800" _msthash="2191319" _msttexthash="42484">$40,000</div>-->
                        
								<tr>
                                <input id="efectivo" style="border: none; text-align:center; font-weight: bold; font-size: 35px; width:100%;">                   
								</tr>
	
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
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1" _msthash="2192242" _msttexthash="339118" style='font-size: 15px;'>TOTAL CREDITO</div>
                                            <!--<div class="h5 mb-0 font-weight-bold text-gray-800" _msthash="2192385" _msttexthash="52013">$ 215.000</div>-->
                                          
								<tr>
                                <input id="credito" style="border: none; text-align:center; font-weight: bold; font-size: 35px; width:100%;">                   
									
									
								</tr>
						
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
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1" _msthash="2193308" _msttexthash="76011" style='font-size: 15px;'>TOTAL DEBITO </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    
                                            
								<tr>
                                <input id="debito" style="border: none; text-align:center; font-weight: bold; font-size: 35px; width:100%;">                   
									<!--<a href="" style='font-size: 20px; text-transform: uppercase; color: black;'><?php echo "AÑO: ".$año=2023 ?> </a>-->
									
								</tr>
						

                                                 
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

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1" _msthash="2193308" _msttexthash="76011" style='font-size: 15px;'>TOTAL TRANSFERENCIA </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    
                                            
								<tr>
                                <input id="transferencia" style="border: none; text-align:center; font-weight: bold; font-size: 35px; width:100%;">                   
									<!--<a href="" style='font-size: 20px; text-transform: uppercase; color: black;'><?php echo "AÑO: ".$año=2023 ?> </a>-->
									
								</tr>
						

                                                 
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

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1" _msthash="2193308" _msttexthash="76011" style='font-size: 15px;'>TOTAL FACTURA A </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    
                                            
								<tr>
                                <input id="facturaA" style="border: none; text-align:center; font-weight: bold; font-size: 35px; width:100%;">                   
									<!--<a href="" style='font-size: 20px; text-transform: uppercase; color: black;'><?php echo "AÑO: ".$año=2023 ?> </a>-->
									
								</tr>
						

                                                 
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

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1" _msthash="2193308" _msttexthash="76011" style='font-size: 15px;'>TOTAL FACTURA B </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    
                                            
								<tr>
                                <input id="facturaB" style="border: none; text-align:center; font-weight: bold; font-size: 35px; width:100%;">                   
									<!--<a href="" style='font-size: 20px; text-transform: uppercase; color: black;'><?php echo "AÑO: ".$año=2023 ?> </a>-->
									
								</tr>
						

                                                 
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

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1" _msthash="2193308" _msttexthash="76011" style='font-size: 15px;'>TOTAL EN COMPRAS </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    
                                            
								<tr>
                                <input id="compras" style="border: none; text-align:center; font-weight: bold; font-size: 35px; width:100%;">                   
									<!--<a href="" style='font-size: 20px; text-transform: uppercase; color: black;'><?php echo "AÑO: ".$año=2023 ?> </a>-->
									
								</tr>
						

                                                 
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

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1" _msthash="2193308" _msttexthash="76011" style='font-size: 15px;'>TOTAL EN GASTOS </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    
                                            
								<tr>
                                <input id="gastos" style="border: none; text-align:center; font-weight: bold; font-size: 35px; width:100%;">                   
									<!--<a href="" style='font-size: 20px; text-transform: uppercase; color: black;'><?php echo "AÑO: ".$año=2023 ?> </a>-->
									
								</tr>
						

                                                 
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
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1" _msthash="2194374" _msttexthash="496548" style='font-size: 15px;'> Recaudacion Total</div>
                                           
								<tr>
                                <input id="transferencia" style="border: none; text-align:center; font-weight: bold; font-size: 35px; width:100%;">                   

								
								</tr>
						
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                                        </div>
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
<div id="mostrar"></div>
<!-- End of Main Content -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script> 

function detalleCaja() 
  {
    idcaja = $("#caja").val();
    var parametros = 
        {
        "datos" : 1,
        "idcaja" : idcaja
        
      };

      $.ajax({
        data: parametros,
        url: 'datosCaja.php',
        type: 'POST',
        
        beforesend: function()
        {
          $('#mostrar').html("Mensaje antes de Enviar");
          
        },
        
        error: function()
        {alert("Error evento");},

        success: function(mensaje)
        {
            $('#mostrar').html(mensaje);
            agregar();
        }
      });
  }

</script>
<?php include_once "includes/footer.php"; ?>