<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

	<!-- Sidebar - Brand -->
	<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
		<div class="sidebar-brand-icon rotate-n-15">
			<img src="img/sabueso.jpg" class="img-thumbnail">
		</div>
		<div class="sidebar-brand-text mx-3">Sabuesos Petshop</div>
	</a>

	<!-- Divider -->
	<hr class="sidebar-divider my-0">

	<!-- Divider -->
	<hr class="sidebar-divider">

	<!-- Heading -->
	<div class="sidebar-heading">
		Interface
	</div>

	<!-- Nav Item - Pages Collapse Menu -->
	<li class="nav-item">
		<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
		<i class="bi bi-coin"></i>
			<span>Ventas</span>
		</a>
		<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
			<div class="bg-white py-2 collapse-inner rounded">
				<a class="collapse-item" href="nueva_venta.php"><i class="bi bi-caret-right-fill"></i>Nueva venta</a>
				<a class="collapse-item" href="lista_ventas.php"><i class="bi bi-caret-right-fill"></i>Listas Ventas</a>
				<a class="collapse-item" href="#" data-toggle="modal" data-target="#lista_venta" onclick="listaFactura();"><i class="bi bi-caret-right-fill"></i>Listas Facturas</a>
				<a class="collapse-item" href="lista_ventas_vendedores.php"><i class="bi bi-caret-right-fill"></i>Ventas Vendedores</a>
			</div>
		</div>
	</li>
	
	<li class="nav-item">
                         <a href="#" class="nav-link collapsed" data-toggle="collapse" data-target="#collapseCuenta" aria-expanded="true" aria-controls="collapseUtilities">
						 <i class="bi bi-cash-coin"></i>
                           <span>Cuenta Corriente</span>
                         </a>
						 <div id="collapseCuenta" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
						 <div class="bg-white py-2 collapse-inner rounded">
                           <a class="collapse-item" href="nueva_cuenta.php"><i class="bi bi-caret-right-fill"></i>Nueva Cuenta</a>
						   <a class="collapse-item" href="factura_cuenta_corriente.php"><i class="bi bi-caret-right-fill"></i>Lista Cuenta</a>
						   <a class="collapse-item" href="cobrar_cuenta_corriente.php"><i class="bi bi-caret-right-fill"></i>Cobrar Cuenta</a>
						 </div>	
						</div>
                       </li> 

	<!-- Nav Item - Productos Collapse Caja -->
	<li class="nav-item">
		<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCaja" aria-expanded="true" aria-controls="collapseUtilities">
		<i class="bi bi-file-ppt-fill"></i>
			<span>Caja</span>
		</a>
		<div id="collapseCaja" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
			<div class="bg-white py-2 collapse-inner rounded">
				<a class="collapse-item" href="superCaja.php">Nueva Caja</a>
				<a class="collapse-item" href="informeCaja.php">Detalle Caja</a>
			</div>
			
		</div>
	</li>

	<!-- Nav Item - Productos Collapse Menu -->
	<li class="nav-item">
		<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
		<i class="bi bi-file-ppt-fill"></i>
			<span>Productos</span>
		</a>
		<div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
			<div class="bg-white py-2 collapse-inner rounded">
				<a class="collapse-item" href="registro_producto.php">Nuevo Producto</a>
				<a class="collapse-item" href="lista_productos.php">Lista Productos</a>
				<a class="collapse-item" data-toggle="modal" data-target="#rubro">Nuevo Rubro</a>
				<a class="collapse-item" data-toggle="modal" data-target="#marca">Nueva Marca</a>
				<a class="collapse-item" data-toggle="modal" data-target="#imprimir">Imprimir Lista</a>
			</div>
		</div>
	</li>

	<!-- Nav Item - Clientes Collapse Menu -->
	<li class="nav-item">
		<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseClientes" aria-expanded="true" aria-controls="collapseUtilities">
		<i class="bi bi-person-lines-fill"></i>
			<span>Clientes</span>
		</a>
		<div id="collapseClientes" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
			<div class="bg-white py-2 collapse-inner rounded">
				<a class="collapse-item" href="registro_cliente.php">Nuevo Clientes</a>
				<a class="collapse-item" href="lista_cliente.php">Lista Clientes</a>
				<a class="collapse-item" data-toggle="modal" data-target="#nuevo_cliente">Modal Cliente</a>
			</div>
		</div>
	</li>
	<!-- Nav Item - Utilities Collapse Menu -->
	<li class="nav-item">
		<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProveedor" aria-expanded="true" aria-controls="collapseUtilities">
		<i class="bi bi-bus-front"></i>
			<span>Proveedor</span>
		</a>
		<div id="collapseProveedor" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
			<div class="bg-white py-2 collapse-inner rounded">
				<a class="collapse-item" href="registro_proveedor.php">Nuevo Proveedor</a>
				<a class="collapse-item" href="lista_proveedor.php">Lista Proveedores</a>
			</div>
		</div>
	</li>
	<!-- Nav Item - Utilities Collapse Menu -->
	<li class="nav-item">
		<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCompra" aria-expanded="true" aria-controls="collapseUtilities">
		<i class="bi bi-minecart-loaded"></i>
			<span>Compras</span>
		</a>
		<div id="collapseCompra" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
			<div class="bg-white py-2 collapse-inner rounded">
				<a class="collapse-item" href="compras.php">Nueva Compra</a>
				
			</div>
		</div>
	</li>
	<!-- Nav Item - Utilities Collapse Menu -->
	<li class="nav-item">
		<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseInforme" aria-expanded="true" aria-controls="collapseUtilities">
		<i class="bi bi-bar-chart-fill"></i>
			<span>Informes</span>
		</a>
		<div id="collapseInforme" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
			<div class="bg-white py-2 collapse-inner rounded">
				<a class="collapse-item" href="informe_venta.php">Informes Estadisticos</a>
				<a class="collapse-item" href="informe_producto.php">Informe Mensual Venta</a>
				<a class="collapse-item" href="informe_mensual_cuenta.php">Informe Mensual Cuenta</a>
				<a class="collapse-item" href="informe_cliente.php">Informe del Cliente Venta</a>
				<a class="collapse-item" href="informe_cliente_cuenta.php">Informe del Cliente Cuenta</a>
				<a class="collapse-item" href="informe_ganancias.php">Informe del Ganancias</a>
				<a class="collapse-item" href="informe_datos_producto.php">Informe del Producto</a>
			</div>
		</div>
	</li>
	<?php if ($_SESSION['rol'] == 1) { ?>
		<!-- Nav Item - Usuarios Collapse Menu -->
		<li class="nav-item">
			<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsuarios" aria-expanded="true" aria-controls="collapseUtilities">
			<i class="bi bi-person-circle"></i>
				<span>Usuarios</span>
			</a>
			<div id="collapseUsuarios" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
				<div class="bg-white py-2 collapse-inner rounded">
					<a class="collapse-item" href="registro_usuario.php">Nuevo Usuario</a>
					<a class="collapse-item" href="lista_usuarios.php">Lista Usuarios</a>
				</div>
			</div>
		</li>
	<?php } ?>

	<!-- Nav Item - Utilities Collapse Menu -->
	<li class="nav-item">
		<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLocal" aria-expanded="true" aria-controls="collapseUtilities">
		<i class="bi bi-building"></i>
			<span>Locales</span>
		</a>
		<div id="collapseLocal" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
			<div class="bg-white py-2 collapse-inner rounded">
				<a class="collapse-item" href="locales.php">Lista de Locales</a>
				
			</div>
		</div>
	</li>

</ul>
