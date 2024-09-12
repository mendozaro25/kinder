<form name="frmModal" autocomplete="off" action="javascript:;" enctype="multipart/form-data">
	<input name="id" id="id" value="<?= $id ?>" type="hidden"  />
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label class="form-label">Nombres <span class="text-red">*</span></label>
				<input autofocus required class="form-control" name="nombres" id="nombres" placeholder="Nombres" value="<?= $nombres ?>">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label class="form-label">Apellidos <span class="text-red">*</span></label>
				<input required class="form-control" name="apellidos" id="apellidos" placeholder="Apellidos" value="<?= $apellidos ?>">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label class="form-label">Fecha Nacimiento <span class="text-red">*</span></label>
				<input required type="date" class="form-control" name="fecha_nac" id="fecha_nac" value="<?= $fecha_nac ?>">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label class="form-label">DNI <span class="text-red">*</span></label>
				<input required maxlength="8" class="form-control" name="dni" id="dni" placeholder="DNI" value="<?= $dni ?>">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label class="form-label">Apoderado Nro. 1 <span class="text-red">*</span></label>
				<?php
				form_dropdown_array("apoderado_1",
					$apoderados,
					" required class='form-control select2-show-search'"
					, $apoderado_1, OPTION_DEFAULT_TEXT, "id", "nombres");
				?>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label class="form-label">Apoderado Nro. 2 (Opcional)</label>
				<?php
				form_dropdown_array("apoderado_2",
					$apoderados,
					" class='form-control select2-show-search'"
					, $apoderado_2, OPTION_DEFAULT_TEXT, "id", "nombres");
				?>
			</div>
		</div>
	</div>	
	<div class="form-group">
		<label class="form-label">Perfil Alumno (.pdf) </label>
		<div class="custom-file">
			<input type="file" id="archivo_input" name="perfil_archivo" class="custom-file-input" onchange="showFileName()">
			<label accept=".pdf" for="archivo_input" id="archivo_label" class="custom-file-label">Seleccionar archivo</label>
		</div>
	</div>
	<div class="form-group">
		<label class="form-label">Observación </label>
		<?php if($id > 0){ ?><input type="text" class="form-control" name="observacion" id="observacion" placeholder="Observación" value="<?= $observacion ?>"> 
		<?php }else{ ?><textarea class="form-control mb-4" rows="2" name="observacion" id="observacion" placeholder="Observación"></textarea><?php } ?>
	</div>
	<div  class="form-group">
		<label class="form-label" >Estado <span class="text-red">*</span></label>
		<?php
		form_dropdown_array("status",
			getConstante(ID_CONST_REG_STATUS, TRUE),
			["class" => "form-control"], $status, FALSE, "codigo", "valor");
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
	
	function showFileName() {
        var input = document.getElementById('archivo_input');
        var label = document.getElementById('archivo_label');
        label.innerHTML = input.files[0].name;
    }
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