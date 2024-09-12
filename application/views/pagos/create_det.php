<form name="frmModal" autocomplete="off" action="javascript:;" enctype="multipart/form-data">
	<input name="id" id="id" value="<?= $id ?>" type="hidden"  />
	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<label class="form-label">Fecha Registro <span class="text-red">*</span></label>
				<input readonly class="form-control" name="fecha_reg" id="fecha_reg" value="<?= $fecha_reg ?>"/>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label class="form-label">Fecha Programado <span class="text-red">*</span></label>
				<input readonly class="form-control" name="fecha_prog" id="fecha_prog" value="<?= $fecha_prog ?>"/>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label class="form-label">Fecha Pago <span class="text-red">*</span></label>
				<input readonly class="form-control" name="fecha_pago" id="fecha_pago" value="<?= $fecha_pago ?? date('Y-m-d') ?>"/>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<label class="form-label">Forma Pago <span class="text-red">*</span></label>
				<?php
					form_dropdown_array("forma_pago_id",
					getConstante(ID_CONST_REG_FPAGO, TRUE),
					["class" => "form-control"], $forma_pago_id, FALSE, "codigo", "valor");
				?>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label class="form-label" >Estado <span class="text-red">*</span></label>
				<?php
				form_dropdown_array("estado_id",
					getConstante(ID_CONST_REG_ESTADOPAG, TRUE),
					["class" => "form-control"], $estado_id, FALSE, "codigo", "valor");
				?>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label class="form-label">Monto <span class="text-red">*</span></label>
				<input readonly class="form-control" name="monto" id="monto" value="<?= number_format($monto ,2)?>"/>
			</div>
		</div>
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

	$(document).ready(function () {
        <?php if($rs["id"] == 0): ?>
            addApoderado();
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