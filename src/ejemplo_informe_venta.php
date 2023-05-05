<?php include_once "includes/header.php"; ?>

<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Panel de Administración</h1>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="table-responsive">
				<table class="table table-striped table-bordered" id="table">
				<thead>
				<tr>
				<th></th>
				<th></th>
				<th align="center">CUMPLIMIENTO (%)</th>
				<th align="center">NO CUMPLIMIENTO (%)</th>
				</tr>
				</thead>
				<tbody>
					<tr class="clickable" data-toggle="collapse" data-target="#group-of-rows-1">
					<td><i class="fa fa-plus" aria-hidden="true"></i></td>
					<td align="center">COCINAS A GAS</td>
					<td align="center">63.97</td>
					<td align="center">36.03</td>
					</tr>
				</tbody>

				<tbody id="group-of-rows-1" class="collapse">
				<tr>
				<td></td>
				<td align="center">Campo / Carpa</td>
				<td></td>
				<td align="center">0.40</td>
				</tr>
				<tr>
				<td></td>
				<td align="center">No hay stock</td>
				<td></td>
				<td align="center">7.69</td>
				</tr>
				<tr class="clickable" data-toggle="collapse" data-target=".group-of-cau-1">
				<td></td>
				<td align="center">Se encuentra en otro lugar exhibido</td>
				<td></td>
				<td align="center">25.51</td>
				</tr>
				<tr class="group-of-cau-1 collapse">
				<td></td>
				<td>Solucionado</td>
				<td>data 1</td>
				<td>data 1</td>
				</tr>
				<tr class="group-of-cau-1 collapse">
				<td></td>
				<td>No Solucionado</td>
				<td>data 1</td>
				<td>data 1</td>
				</tr>
				</tbody>
  <tbody>
    <tr class="clickable" data-toggle="collapse" data-target="#group-of-cau-2">
      <td></td>
      <td align="center">Stock en almacén</td>
      <td></td>
      <td align="center">2.43</td>
    </tr>
  </tbody>
  <tbody id="group-of-cau-2" class="collapse">
    <tr>
      <td></td>
      <td>Solucionado</td>
      <td>data 1</td>
      <td>data 1</td>
    </tr>
    <tr>
      <td></td>
      <td>No Solucionado</td>
      <td>data 1</td>
      <td>data 1</td>
    </tr>
  </tbody>
</table>
			</div>
		</div>
	</div>



</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>
<?php include_once "includes/footer.php"; ?>