<?php require_once  __DIR__.'/include/header.php'; ?>
<?php require_once  __DIR__.'/include/sidebar.php'; ?>
<br>
<!-- Row -->
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
				<!-- Widgets -->
				<div class="row">
					<div class="col-sm-12 col-md-6 col-xl-3">
						<a href="<?= base_url().$url_alumnos ?>">
							<div class="card bg-primary">
								<div class="card-body">
									<div class="d-flex no-block align-items-center">
										<div>
											<h6 class="text-white">Alumnos</h6>
											<h2 class="text-white m-0 font-weight-bold"><?= $alumnos["alumnos"] ?></h2>
										</div>
										<div class="ml-auto">
											<span class="text-white display-6"><i class="fa fa-child fa-2x"></i></span>
										</div>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div class="col-sm-12 col-md-6 col-xl-3">
						<a href="<?= base_url().$url_reports ?>">
							<div class="card bg-secondary">
								<div class="card-body">
									<div class="d-flex no-block align-items-center">
										<div>
											<h6 class="text-white">Monto Total (Pagados)</h6>
											<h2 id="monto-total-pen" class="text-white m-0 font-weight-bold"><?= $monto["monto_total"] ?></h2>
										</div>
										<div class="ml-auto">
											<span class="text-white display-6"><i class="fa fa-money fa-2x"></i></span>
										</div>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div class="col-sm-12 col-md-6 col-xl-3">
						<a href="<?= base_url().$url_sesiones ?>">
							<div class="card bg-info">
								<div class="card-body">
									<div class="d-flex no-block align-items-center">
										<div>
											<h6 class="text-white">Sesiones</h6>
											<h2 class="text-white m-0 font-weight-bold"><?= $sesion["sesiones"] ?></h2>
										</div>
										<div class="ml-auto">
											<span class="text-white display-6"><i class="fa fa-folder-open fa-2x"></i></span>
										</div>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div class="col-sm-12 col-md-6 col-xl-3">
						<a href="<?= base_url().$url_pagos ?>">
							<div class="card bg-warning">
								<div class="card-body">
									<div class="d-flex no-block align-items-center">
										<div>
											<h6 class="text-white">Pagos Pendientes</h6>
											<h2 class="text-white m-0 font-weight-bold"><?= $pendientes["pendientes"] ?></h2>
										</div>
										<div class="ml-auto">
											<span class="text-white display-6"><i class="fa fa-history fa-2x"></i></span>
										</div>
									</div>
								</div>
							</div>
						</a>
					</div>
				</div>
				<!-- Pagos Recientes -->
				<div class="row">					
					<div class="col-xl-5 col-md-12">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title">Pagos Procesados</h3>
							</div>
							<div class="card-body">
								<?php foreach ($pg_aceptados as $row): ?>
								<a href="<?= base_url().$url_det_pagos.$row["pago_prog_id"] ?>">
									<div class="list-card">
										<?php if($row["estado"] == RECORD_STATUS_CANCELADO_TEXT) { ?>
										<span class="bg-success list-bar"></span>
										<?php } else {  ?>
										<span class="bg-warning list-bar"></span>
										<?php }  ?>
										<div class="row align-items-center">
											<div class="col-8 col-sm-8">
												<div class="media mt-0">
													<div class="media-body">
														<div class="d-md-flex align-items-center mt-1">
															<h6 class="mb-1"><?= $row["apoderado"] ?></h6>
														</div>
														<span class="mb-0 fs-13 text-muted"><b>DNI: </b><?= $row["dni"] ?></span><br>
														<span class="mb-0 fs-13 text-muted"><b>FECHA PAGO: </b><?= $row["fecha_pago"] ?? '-'?></span><br>
														<span class="mb-0 fs-13 text-muted"><b>CONDICIÓN: </b></span>
															<?php if($row["estado"] == RECORD_STATUS_CANCELADO_TEXT) { ?>
															<span class="mb-0 text-success fs-13 font-weight-semibold"><?= $row["estado"] ?></span>
															<?php } else {  ?>
															<span class="mb-0 text-warning fs-13 font-weight-semibold"><?= $row["estado"] ?></span>
															<?php }  ?>
													</div>
												</div>
											</div>
											<div class="col-4 col-sm-4">
												<div class="text-right">
													<span class="font-weight-semibold fs-16 number-font"><?= $row["moneda"] ?> <?= $row["monto"] ?></span>
												</div>
											</div>
										</div>
									</div>
								</a>
								<?php endforeach; ?>
								<a class="btn btn-primary" style="width: 100%;" href="<?= base_url().$url_pagos ?>">Ver más</a>
							</div>
						</div>
					</div>
					<div class="col-xl-7 col-lg-12 col-md-12">
						<div class="row">
							<div class="card">
								<div class="card-header">
									<h3 class="card-title">Alumnos Cumpleañeros Mes (<?= $mes_actual ?>)</h3>
								</div>
								<div class="card-body">	
									<ul class="list-group">								
									<?php foreach ($alum_cum as $row): ?>
											<li class="listunorder">
												<?= $row["nombres"].' '.$row["apellidos"] ?>
												<span class="badgetext badge badge-default badge-pill"><?= $row["fecha_nac"] ?></span>
											</li>
									<?php endforeach; ?>
									</ul>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="card">
								<div class="card-header">
									<h3 class="card-title">Alumnos Recientes</h3>
								</div>
								<div class="card-body">
									<div class="">
										<table id="table1" class="table table-striped table-bordered">
											<thead>
											<tr>
												<th>dni</th>
												<th>alumno</th>
												<th>perfil</th>
												<th>apoderado</th>
												<th>fechanac</th>
												<th>estado</th>
											</tr>
											</thead>
											<?php foreach ($alum_rec as $row): ?>
											<tbody>
												<tr>
													<td><span class="badge badge-info"><?= $row["dni"] ?></span></td>
													<td class="font-weight-bold"><?= $row["nombres"].' '.$row["apellidos"] ?></td>
													<td><a href="<?= base_url().$row["perfil_archivo"] ?>" target="_blank" class="btn btn-danger"><i class="fa fa-file-pdf-o" data-toggle="tooltip" title="Perfil Alumno"></i></a></td>
													<td><?= gw("apoderado", ["id" => $row['apoderado_1']])->row()->nombres . ' ' . gw("apoderado", ["id" => $row['apoderado_1']])->row()->apellidos ?></td>
													<td><?= $row["fecha_nac"] ?></td>
													<?php if($row["status"] == RECORD_STATUS_ACTIVE) { ?>
														<td><i class="fa fa-check mr-5 text-success"></i></td>
													<?php } else { ?>
														<td><i class="fa fa-exclamation-triangle text-danger"></i></td>
													<?php } ?>
												</tr>
											</tbody>
											<?php endforeach; ?>
										</table>
										<a class="btn btn-primary" style="width: 100%;" href="<?= base_url().$url_alumnos ?>">Ver más</a>
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
<!-- End Row -->
<!-- /page content -->
<?php require_once  __DIR__.'/include/footer.php'; ?>

<script type="text/javascript">
	function formatNumber(num) {
		if (num >= 1000000) {
			return (num / 1000000).toFixed(1) + "M";
		} else if (num >= 1000) {
			if (num % 1000 === 0) {
				return (num / 1000).toFixed(0) + "k";
			} else {
				return (num / 1000).toFixed(1) + "k";
			}
		} else {
			return num.toString();
		}
	}

	// Soles
	let monto_total_pen = <?= $monto_total_pen[0]["monto_total_pen"] ?>;
	let monto_formateado_pen = formatNumber(monto_total_pen);
	document.querySelector('#monto-total-pen').textContent = monto_formateado_pen;
</script>
