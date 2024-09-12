<form name="frmModal" autocomplete="off" action="javascript:;" enctype="multipart/form-data">
	<input name="apoderado_count" id="apoderado_count" value="<?= $pcount["apoderado_count"] ?? 0 ?>" type="hidden" >
	<input name="id" id="id" value="<?= $rs["id"] ?>" type="hidden"  />
	<div class="row">
		<div class="col-md-5">
			<div class="form-group">
				<label class="form-label">Concepto <span class="text-red">*</span></label>
				<?php
					form_dropdown_array("concepto_id",
					getConstante(ID_CONST_REG_CONCEP, TRUE),
					["class" => "form-control"], $rs["concepto_id"], FALSE, "codigo", "valor");
				?>
			</div>
		</div>
		<div class="col-md-2">
			<div class="form-group">
				<label class="form-label">Monto <span class="text-red">*</span></label>
				<input required class="form-control" name="monto" id="monto" placeholder="0.00" value="<?= $rs["monto"] ?>"/>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label class="form-label">Fecha Registro <span class="text-red">*</span></label>
				<input required type="date" class="form-control" name="fecha_reg" id="fecha_reg" value="<?= $rs["fecha_reg"] ?? date('Y-m-d') ?>"/>
			</div>
		</div>
		<div class="col-md-2">
			<div class="form-group">
				<label class="form-label">Días Prog. <span class="text-red">*</span></label>
				<?php
					form_dropdown_array("dias_prog",
					getConstante(ID_CONST_REG_FECHAPROG, TRUE),
					["class" => "form-control"], $rs["dias_prog"], FALSE, "codigo", "valor");
				?>
			</div>
		</div>
	</div>	
	
	<div id="sesiones"></div>
	<div id="apoderados"></div>

	<?php if($rs["id"] > 0): ?>
		<div class="row" id="sesionContainer">
			<div class="col-md-9">
				<div class="form-group">
					<label class="form-label">Sesión 
						<button style="padding: 0px 0px 0px 3px;" 
								type="button" 
								data-toggle="tooltip" 
								data-placement="right" 
								class="btn btn-danger" 
								title="Cambiar Sesion" 
								onclick="removeSesion()">
							<i class="fa fa-refresh mr-1"></i>
						</button>
					</label>
					<select class="form-control" name="sesion_id" readonly>
						<option value="<?= $data_ses_det[0]["sesion_id"] ?>"><?= gw("sesion", ["id" => $data_ses_det[0]["sesion_id"]])->row()->nombre_grupo ?></option>
					</select>
				</div>
			</div>
			<div class="col-md-3">
				<label class="form-label" >Apoderados Reg. </label>
				<input type="text" class="form-control sesion-num_apoderados" name="num_apoderados" value="<?= $pcount["apoderado_count"]?>" readonly> 
			</div> 
		</div>
		<div class="row" id="apoderadoContainer">
			<div class="col-md-12">
				<div class="card mb-4">   
					<div class="card-body">
						<h3 class="page-title mb-0">Apoderados
							<div class="btn btn-list">
								<button style="padding: 0px 0px 0px 3px;" 
										type="button" 
										data-toggle="tooltip" 
										data-placement="right" 
										class="btn btn-danger" 
										title="Agregar Apoderado" 
										onclick="addApoderado()">
									<i class="fe fe-plus mr-1"></i>
								</button>
							</div>
						</h3>
						<hr class="my-1" /><br>
						<?php if($rs["id"] > 0): ?>
							<?php foreach ($data_ses_det as $item) : ?>
								<div class="row" style="margin-bottom: 1em;">
									<div class="col-md-10">
										<input type="hidden" class="form-control apoderado-id" name="items[progr_pago_det_id][]" value="<?= $item["progr_pago_det_id"] ?>">
										<label class="form-label">Apoderado <span class="text-red">*</span></label>									
										<select class="form-control select-apoderado" name="items[apoderado_id][]" readonly>
											<option value="<?= $item["apoderado_id"] ?>"><?= $item["nombre_apoderado"] ?></option>
										</select>
									</div>
									<div class="col-md-2">
										<label class="form-label" >Acc. </label>
										<a data-toggle="tooltip" title="Eliminar" class="btn btn-icon  btn-danger" onclick="deleteApoderado(this)"><i class="fe fe-trash"></i></a>
									</div> 
								</div>
							<?php endforeach; ?>
						<?php endif; ?>
						<div id="add_apoderado"></div>
					</div>
				</div>  
			</div>
		</div>
	<?php endif; ?>
	<div  class="form-group">
		<label class="form-label" >Estado <span class="text-red">*</span></label>
		<?php
		form_dropdown_array("status",
			getConstante(ID_CONST_REG_STATUS, TRUE),
			["class" => "form-control"], $rs["status"], FALSE, "codigo", "valor");
		?>
	</div>
</form>

<script type="text/javascript">
	$(document).ready(function() {
		$('.select2-show-search').select2({
		language: {
			noResults: function() {
				return "No se encontraron resultados";        
			},
			searching: function() {
				return "Buscando...";
			}
		}
		});
    });

	var apoderadoCount = <?= $pcount["apoderado_count"] ?? 0 ?>;
	var selectedApoderados = [];

    function addApoderado() {
		apoderadoCount++;
        $('#apoderado_count').val(apoderadoCount);

        var template = $('#apoderadoTemplate').html();
        var rendered = Mustache.render(template, {apoderados: <?= json_encode($apoderados) ?> });
        $('#add_apoderado').append(rendered);

        // Inicializar Select2 para el campo de nombre del alumno
        var selectapoderado = $('.select-apoderado').last();
        selectapoderado.select2({
            language: {
            noResults: function () {
                return "No se encontraron resultados";
            },
            searching: function () {
                return "Buscando...";
            }
            },
            data: <?= json_encode($apoderado) ?>,
            id: function (apoderado) { return apoderado.id; },
            text: function (apoderado) { return apoderado.text; }
        }).on('select2:select', function (e) {
            var selectedData = e.params.data;
            var selectPersonID = selectedData.id;

            selectedApoderados.push(selectPersonID);
        });
	}

	function deleteApoderado(button) {
		// Obtener el elemento <div class="row"> padre del botón "Eliminar"
		var row = $(button).closest('.row');

		// Eliminar el elemento <div class="row"> de la lista
		row.remove();

		apoderadoCount--;
		$('#apoderado_count').val(apoderadoCount);
	}

	var selectedSesiones = [];

	function viewSesion() {
		var template = $('#sesionPagoTemplate').html();
		var rendered = Mustache.render(template, {sesiones: <?= json_encode($sesiones) ?> });
		$('#sesiones').append(rendered);

		// Inicializar Select2 para el campo de nombre del alumno
		var selectsesion = $('.select-sesion').last();
		selectsesion.select2({
			language: {
			noResults: function () {
				return "No se encontraron resultados";
			},
			searching: function () {
				return "Buscando...";
			}
			},
			data: <?= json_encode($sesiones) ?>,
			id: function (sesion) { return sesion.id; },
			text: function (sesion) { return sesion.text; }
		}).on('select2:select', function (e) {
			var selectedData = e.params.data;
			var selectSesionID = selectedData.id;

			selectedSesiones.push(selectSesionID);

			var apoderadosData = selectedData.apoderados;
			var num_apoderados = selectedData.num_apoderados.apoderado_count;

			$('#apoderados').empty();

			var template = $('#apoderadosTemplate').html();
			var rendered = Mustache.render(template, {apoderados: apoderadosData });
			$('#apoderados').append(rendered);

			$(this).closest('.row').find('.sesion-num_apoderados').val(num_apoderados);
			$('#apoderado_count').val(num_apoderados);
		});
	}

	function removeSesion() {
		var sesionContainer = document.getElementById('sesionContainer');
		sesionContainer.parentNode.removeChild(sesionContainer);
		var apoderadoContainer = document.getElementById('apoderadoContainer');
		apoderadoContainer.parentNode.removeChild(apoderadoContainer);
		viewSesion();
	}

	$(document).ready(function () {
        <?php if($rs["id"] == 0): ?>
            viewSesion();
        <?php endif; ?>
    });
</script>

<style>
	/*Style-Juanciño*/
	.select2-container {
		width: 585px !important;
	}
	.select2-selection__rendered {
		color: #9cc3b4 !important;
	}
</style>