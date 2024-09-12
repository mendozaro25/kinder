<form name="frmModal" autocomplete="off" action="javascript:;" enctype="multipart/form-data">
	<input name="id" id="id" value="<?= $rs["id"] ?>" type="hidden"  />
	<?php if($rs["id"] > 0): ?>
	<div class="row" id="sesionContainer">
		<div class="col-md-5">
            <div class="form-group">
                <label class="form-label">Sesion 
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
					<option value="<?= $rs["sesion_id"] ?>"><?= $data_silabo["nombre_grupo"] ?></option>
				</select>
            </div>
        </div>
        <div class="col-md-5">
            <label class="form-label" >Docente </label>
            <input type="text" class="form-control sesion-docente" name="docente" value="<?= $data_silabo["docente"] ?>" readonly>
        </div> 
        <div class="col-md-2"> 
            <label class="form-label" >Alumnos </label>
            <input type="text" class="form-control sesion-alumnos" name="alumnos" value="<?= $data_silabo["alumno_count"] ?>" readonly> 
        </div>
	</div>
	<?php endif; ?>
	<div id="sesiones"></div>
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label class="form-label">Fecha Registro <span class="text-red">*</span></label>
				<input required type="date" class="form-control" name="fecha_reg" id="fecha_reg" value="<?= $rs["fecha_reg"] ?? date('Y-m-d') ?>"/>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label class="form-label">Fecha Vigencia <span class="text-red">*</span></label>
				<input required type="date" class="form-control" name="fecha_vigencia" id="fecha_vigencia" value="<?= $rs["fecha_vigencia"] ?>"/>
			</div>
		</div>
	</div>
	<div class="form-group">
		<label class="form-label">Material Silabo (.pdf) </label>
		<div class="custom-file">
			<input type="file" id="archivo_input" name="material_archivo" class="custom-file-input" onchange="showFileName()">
			<label accept=".pdf" for="archivo_input" id="archivo_label" class="custom-file-label">Seleccionar archivo</label>
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
	function removeSesion() {
		var sesionContainer = document.getElementById('sesionContainer');
		sesionContainer.parentNode.removeChild(sesionContainer);
		viewSesion();
	}
	
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
	
	var selectedSesiones = [];

    function viewSesion() {

        var template = $('#sesionTemplate').html();
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

            $(this).closest('.row').find('.sesion-alumnos').val(selectedData.alumnos.alumno_count);
            $(this).closest('.row').find('.sesion-docente').val(selectedData.docente);
        });
	}

	$(document).ready(function () {
		<?php if($rs["id"] == 0): ?>
        	viewSesion();
        <?php endif; ?>
    });
	
	function showFileName() {
        var input = document.getElementById('archivo_input');
        var label = document.getElementById('archivo_label');
        label.innerHTML = input.files[0].name;
    }

	// Obtener referencia a los elementos de fecha de registro y fecha de vigencia
	var fechaRegInput = document.getElementById('fecha_reg');
	var fechaVigenciaInput = document.getElementById('fecha_vigencia');
	
	// Obtener la fecha actual
	var fechaActual = new Date();
	
	// Establecer la fecha actual como valor predeterminado del campo de fecha de registro
	if (!fechaRegInput.value) {
		fechaRegInput.value = fechaActual.toISOString().slice(0, 10);
	}
	
	// Verificar si existe un valor en el campo de fecha de vigencia
	var fechaVigenciaExistente = (fechaVigenciaInput.value !== '');
	
	// Calcular la fecha de vigencia inicial solo si no existe un valor de fecha_vigencia
	if (!fechaVigenciaExistente) {
		var fechaVigenciaInicial = new Date(fechaActual.getFullYear(), fechaActual.getMonth(), fechaActual.getDate() + 30);
		var formattedFechaVigenciaInicial = fechaVigenciaInicial.toISOString().slice(0, 10);
		fechaVigenciaInput.value = formattedFechaVigenciaInicial;
	}
	
	// Escuchar el evento 'change' en el campo de fecha de registro
	fechaRegInput.addEventListener('change', function() {
		var fechaReg = new Date(fechaRegInput.value);
		
		// Calcular la fecha de vigencia solo si no existe un valor de fecha_vigencia o si se cambia el valor de fecha_reg
		if (!fechaVigenciaExistente || fechaRegInput.value !== '<?= $fecha_reg ?? '' ?>') {
		var fechaVigencia = new Date(fechaReg.getFullYear(), fechaReg.getMonth(), fechaReg.getDate() + 30);
		var formattedFechaVigencia = fechaVigencia.toISOString().slice(0, 10);
		fechaVigenciaInput.value = formattedFechaVigencia;
		}
	});
</script>

<style>
	/*Style-Juanciño*/
	.select2-container {
		width: 300px !important;
	}
	.select2-selection__rendered {
		color: #9cc3b4 !important;
	}
</style>