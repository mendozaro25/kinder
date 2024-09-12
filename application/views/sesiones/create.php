<form name="frmModal" autocomplete="off" action="javascript:;" enctype="multipart/form-data">
	<input name="alumno_count" id="alumno_count" value="<?= $pcount["alumno_count"] ?? 0 ?>" type="hidden" >
	<input name="id" id="id" value="<?= $rs["id"] ?>" type="hidden"  />
	<div class="form-group">
		<label class="form-label">Nombre de Grupo <span class="text-red">*</span></label>
		<input autofocus required class="form-control" name="nombre_grupo" id="nombre_grupo" placeholder="Nombre de Grupo" value="<?= $rs["nombre_grupo"] ?>">
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label class="form-label">Docente <span class="text-red">*</span></label>
				<?php
				form_dropdown_array("docente_id",
					$docentes,
					" required class='form-control select2-show-search'"
					, $rs["docente_id"], OPTION_DEFAULT_TEXT, "id", "nombres");
				?>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label class="form-label">Auxiliar (Opcional)</label>
				<?php
				form_dropdown_array("auxiliar_id",
					$auxiliares,
					" class='form-control select2-show-search'"
					, $rs["auxiliar_id"], OPTION_DEFAULT_TEXT, "id", "nombres");
				?>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="card mb-4">   
				<div class="card-body">
					<h3 class="page-title mb-0">Alumno
						<div class="btn btn-list">
							<button style="padding: 0px 0px 0px 3px;" 
									type="button" 
									data-toggle="tooltip" 
									data-placement="right" 
									class="btn btn-danger" 
									title="Agregar Alumno" 
									onclick="addAlumno()">
								<i class="fe fe-plus mr-1"></i>
							</button>
						</div>
					</h3>
                    <hr class="my-1" />
					<?php if($rs["id"] > 0): ?>
						<?php foreach ($data_ses_det as $item) : ?>
							<div class="row" style="margin-bottom: 1em;">
								<input type="hidden" class="form-control alumno-id" name="items[sesion_det_id][]" value="<?= $item["sesion_det_id"] ?>">
								<div class="col-md-6"> 
									<label class="form-label">Alumno </label> 
									<select class="form-control select-alumno" name="items[alumno_id][]" readonly>
										<option value="<?= $item["alumno_id"] ?>"><?= $item["nombre_alumno"] ?></option>
									</select>
								</div>
								<div class="col-md-2">
									<label class="form-label" >DNI </label>
									<input type="text" class="form-control alumno-dni" name="items[dni][]" value="<?= $item["dni"] ?>" readonly>
								</div> 
								<div class="col-md-3"> 
									<label class="form-label" >Apoderado </label>
									<input type="text" class="form-control alumno-apoderado" name="items[apoderado][]" value="<?= $item["nombre_apoderado"] ?>" readonly> 
								</div>
								<div class="col-md-1"> 
									<label class="form-label" >Acc. </label>
									<a data-toggle="tooltip" title="Eliminar" class="btn btn-icon  btn-danger" onclick="deleteAlumno(this)"><i class="fe fe-trash"></i></a>
								</div>
							</div>
						<?php endforeach; ?>
					<?php endif; ?>
					<div id="add_alumno"></div>
				</div>
			</div>  
		</div>
	</div>
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

	var alumnoCount = <?= $pcount["alumno_count"] ?? 0 ?>;
	var selectedAlumnos = [];

    function addAlumno() {
		alumnoCount++;
        $('#alumno_count').val(alumnoCount);

        var template = $('#alumnoTemplate').html();
        var rendered = Mustache.render(template, {alumnos: <?= json_encode($alumnos) ?> });
        $('#add_alumno').append(rendered);

        // Inicializar Select2 para el campo de nombre del alumno
        var selectalumno = $('.select-alumno').last();
        selectalumno.select2({
            language: {
            noResults: function () {
                return "No se encontraron resultados";
            },
            searching: function () {
                return "Buscando...";
            }
            },
            data: <?= json_encode($alumnos) ?>,
            id: function (alumno) { return alumno.id; },
            text: function (alumno) { return alumno.text; }
        }).on('select2:select', function (e) {
            var selectedData = e.params.data;
            var selectPersonID = selectedData.id;

            selectedAlumnos.push(selectPersonID);

            $(this).closest('.row').find('.alumno-dni').val(selectedData.dni);
            $(this).closest('.row').find('.alumno-apoderado').val(selectedData.apoderado);
        });
	}


	function deleteAlumno(button) {
		// Obtener el elemento <div class="row"> padre del botón "Eliminar"
		var row = $(button).closest('.row');

		// Eliminar el elemento <div class="row"> de la lista
		row.remove();

		alumnoCount--;
		$('#alumno_count').val(alumnoCount);
	}

	$(document).ready(function () {
        <?php if($rs["id"] == 0): ?>
            addAlumno();
        <?php endif; ?>
    });
</script>

<style>
	/*Style-Juanciño*/
	.select2-container {
		width: 370px !important;
	}
	.select2-selection__rendered {
		color: #9cc3b4 !important;
	}
</style>