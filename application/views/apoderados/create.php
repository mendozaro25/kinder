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
		<div class="col-md-4">
			<div class="form-group">
				<label class="form-label">Telefono 1 <span class="text-red">*</span></label>
				<input required maxlength="9" class="form-control" name="telefono_1" id="telefono_1" placeholder="000000000" value="<?= $telefono_1 ?>">
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label class="form-label">Telefono 2 (Opcional) </label>
				<input maxlength="9" class="form-control" name="telefono_2" id="telefono_2" placeholder="000000000" value="<?= $telefono_2 ?>">
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label class="form-label">Fijo (Casa) </label>
				<input maxlength="6" class="form-control" name="fono_casa" id="fono_casa" placeholder="000000" value="<?= $fono_casa ?>">
			</div>
		</div>
	</div>	
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label class="form-label">Email <span class="text-red">*</span></label>
				<input required type="email" class="form-control" name="email" id="email" placeholder="Email" value="<?= $email ?>">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label class="form-label">Dirección </label>
				<input class="form-control" name="direccion" id="direccion" placeholder="Dirección" value="<?= $direccion ?>">
			</div>
		</div>
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