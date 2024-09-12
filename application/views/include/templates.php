<script type="text/html" id="tplDtColumnBtnEdit">
    {{#.}}
    <a data-toggle="tooltip" title="Editar" class="btn btn-icon btn-primary btnEdit" href="javascript:;" data-row-id="{{row_id}}" >
        <i class="fe fe-edit"></i>
    </a>
    <a data-toggle="tooltip" title="Eliminar" class="btn btn-icon  btn-danger" onclick="jj.actionRem('{{uri_remove}}', '{{row_id}}', '{{callback_rem}}')"  href="ajavscript:;">
        <i class="fe fe-trash"></i>
    </a>
    {{/.}}
    {{> partialDetail }}
</script>

<script type="text/html" id="tplDtColumnUsers">
    {{#.}}
    <a data-toggle="tooltip" title="Editar" class="btn btn-icon btn-primary btnEdit" href="javascript:;" data-row-id="{{row_id}}" >
        <i class="fe fe-edit"></i>
    </a>
    <a data-toggle="tooltip" title="Accesos" class="btn btn-icon  btn-info" href="<?= $uri["create_access"] ?>?userID={{row_id}}">
        <i class="fa fa-list-ul"></i>
    </a>
    <a data-toggle="tooltip" title="Eliminar" class="btn btn-icon  btn-danger" onclick="jj.actionRem('{{uri_remove}}', '{{row_id}}', '{{callback_rem}}')"  href="ajavscript:;">
        <i class="fe fe-trash"></i>
    </a>
    {{/.}}
    {{> partialDetail }}
</script>

<script type="text/html" id="tplDtColumnPagosDet">
    {{#.}}
    <a data-toggle="tooltip" title="Editar" class="btn btn-icon btn-info btnEdit" href="javascript:;" data-row-id="{{row_id}}" >
        <i class="fe fe-eye"></i>
    </a>
    <a data-toggle="tooltip" title="Eliminar" class="btn btn-icon  btn-danger" onclick="jj.actionRem('{{uri_remove}}', '{{row_id}}', '{{callback_rem}}')"  href="ajavscript:;">
        <i class="fe fe-trash"></i>
    </a>
    {{/.}}
    {{> partialDetail }}
</script>

<script type="text/html" id="tplDtColumnPagos">
    {{#.}}
    <a data-toggle="tooltip" title="Editar" class="btn btn-icon btn-primary btnEdit" href="javascript:;" data-row-id="{{row_id}}" >
        <i class="fe fe-edit"></i>
    </a>
    <a data-toggle="tooltip" title="Eliminar" class="btn btn-icon  btn-danger" onclick="jj.actionRem('{{uri_remove}}', '{{row_id}}', '{{callback_rem}}')"  href="ajavscript:;">
        <i class="fe fe-trash"></i>
    </a>
    <a data-toggle="tooltip" title="Ir al Detalle" class="btn btn-icon  btn-warning btnShopDet" href="<?= base_url() ?>pagos/det_pago?ppID={{row_id}}">
        <i class="fa fa-arrow-right"></i>
    </a>
    {{/.}}
    {{> partialDetail }}
</script>

<script type="text/html" id="tplDtColumnJornada">
    {{#.}}
    <a data-toggle="tooltip" title="Jornadas" class="btn btn-icon  btn-primary" href="<?= $uri["jornadas"] ?>?num={{row_id}}">
        <i class="fa fa-briefcase"></i>
    </a>
    <!-- a data-toggle="tooltip" title="Eliminar" class="btn btn-icon  btn-danger" onclick="jj.actionRem('{{uri_remove}}', '{{row_id}}', '{{callback_rem}}')"  href="ajavscript:;">
        <i class="fe fe-trash"></i>
    </a -->
    {{/.}}
    {{> partialDetail }}
</script>

<script type="text/html" id="tplDtColumnCompra">
    {{#.}}
    <a data-toggle="tooltip" title="Compras" class="btn btn-icon  btn-primary" href="<?= $uri["compras"] ?>?num={{row_id}}">
        <i class="fa fa-shopping-bag"></i>
    </a>
    <!-- a data-toggle="tooltip" title="Eliminar" class="btn btn-icon  btn-danger" onclick="jj.actionRem('{{uri_remove}}', '{{row_id}}', '{{callback_rem}}')"  href="ajavscript:;">
        <i class="fe fe-trash"></i>
    </a -->
    {{/.}}
    {{> partialDetail }}
</script>

<script type="text/html" id="tplDtColumnJornadaPersonal">
    {{#.}}
    <a data-toggle="tooltip" title="Editar" class="btn btn-icon btn-primary btnEdit" href="javascript:;" data-row-id="{{row_id}}" >
        <i class="fe fe-edit"></i>
    </a>
    <a data-toggle="tooltip" title="Asistencia" class="btn btn-icon  btn-warning btnAsist" href="<?= base_url() ?>jornadas/asistencia?astID={{row_id}}">
        <i class="fe fe-book"></i>
    </a>
    <a data-toggle="tooltip" title="Eliminar" class="btn btn-icon  btn-danger" onclick="jj.actionRem('{{uri_remove}}', '{{row_id}}', '{{callback_rem}}')"  href="ajavscript:;">
        <i class="fe fe-trash"></i>
    </a>
    {{/.}}
    {{> partialDetail }}
</script>

<script type="text/html" id="tplDtColumnDetalleCompra">
    {{#.}}
    <a data-toggle="tooltip" title="Ver Compra" class="btn btn-icon  btn-primary btnEdit" href="<?= base_url() ?>compras/detalle_compra_create?shopID={{row_id}}&siteID=<?= $obra_id ?>">
        <i class="fe fe-eye"></i>
    </a>
    <a data-toggle="tooltip" title="Eliminar" class="btn btn-icon  btn-danger" onclick="jj.actionRem('{{uri_remove}}', '{{row_id}}', '{{callback_rem}}')"  href="ajavscript:;">
        <i class="fe fe-trash"></i>
    </a>
    {{/.}}
    {{> partialDetail }}
</script>

<script type="text/html" id="tplDtColumnAsistencia">
    {{#.}}
    <a data-toggle="tooltip" title="Asistencia" class="btn btn-icon  btn-light btnAsist" href="javascript:;" data-row-id="{{row_id}}">
        <i class="fa fa-calendar"></i>
    </a>
    <a data-toggle="tooltip" title="Eliminar" class="btn btn-icon  btn-danger" onclick="jj.actionRem('{{uri_remove}}', '{{row_id}}', '{{callback_rem}}')"  href="ajavscript:;">
        <i class="fe fe-trash"></i>
    </a>
    {{/.}}
    {{> partialDetail }}
</script>

<script id="productTemplate" type="text/html">
    <div class="row" style="margin-bottom: 1em;">
        <!-- input type="hidden" class="form-control producto-id" name="items[detalle_compra_id][]" -->
        <div class="col-md-4">
            <label class="form-label">Producto <span class="text-red">*</span> </label>
            <select required class="form-control select-producto" name="items[producto_id][]">
                <option value="" disabled selected hidden>-- Buscar producto --</option>
                {{#productos}}
                <option value="{{id}}">{{text}}</option>
                {{/productos}}
            </select>
        </div>
        <div class="col-md-1">
            <label class="form-label" >UM </label>
            <input type="text" class="form-control producto-undMedida" name="items[unidad_medida][]" placeholder="UM" readonly>
        </div>
        <div class="col-md-2">
            <label class="form-label" >Cant </label>
            <div class="input-group">
                <span class="input-group-btn">
                    <button type="button" class="btn btn-light border-0 br-0 minus">
                        <i class="fa fa-minus"></i>
                    </button>
                </span>
                <input type="text" class="form-control text-center qty" name="items[cantidad][]" value="1">
                <span class="input-group-btn">
                    <button type="button" class="btn btn-light border-0 br-0 add" >
                        <i class="fa fa-plus"></i>
                    </button>
                </span>
            </div>
        </div>
        <div class="col-md-1">
            <label class="form-label" >Prec. </label>
            <input type="text" class="form-control text-center producto-precUnitario" name="items[precio_unitario][]" value="0.00" readonly>
        </div>
        <div class="col-md-1">
            <label class="form-label" >SubTot </label>
            <input type="text" class="form-control text-center subtotal" name="items[subtotal][]" readonly>
        </div>
        <div class="col-md-1">
            <label class="form-label" >IGV </label>
            <input type="text" class="form-control text-center igv" name="items[igv][]" readonly>
        </div>
        <div class="col-md-1">
            <label class="form-label" >Total </label>
            <input type="text" class="form-control text-center total" name="items[total][]" readonly>
        </div>
        <div class="col-md-1">
            <label class="form-label" >&nbsp;</label>
            <a data-toggle="tooltip" title="Eliminar" class="btn btn-icon btn-danger" onclick="deleteProducto(this)"><i class="fe fe-trash"></i></a>
        </div>
    </div>
</script>

<script id="alumnoTemplate" type="text/html">
    <div class="row" style="margin-bottom: 1em;">
        <div class="row" style="margin-bottom: 1em;">
            <div class="col-md-6"> 
            <label class="form-label">Alumno <span class="text-red">*</span></label> 
                <select required class="form-control select-alumno" name="items[alumno_id][]">
                    <option value="" disabled selected hidden>-- Buscar Alumno --</option>
                    {{#alumnos}}
                    <option value="{{id}}">{{text}}</option>
                    {{/alumnos}}
                </select>
            </div> 
            <div class="col-md-2">
                <label class="form-label" >DNI </label>
                <input type="text" class="form-control alumno-dni" name="items[dni][]" placeholder="DNI" readonly>
            </div> 
            <div class="col-md-3"> 
                <label class="form-label" >Apoderado </label>
                <input type="text" class="form-control alumno-apoderado" name="items[apoderado][]" placeholder="Apoderado" readonly> 
            </div>
            <div class="col-md-1"> 
                <label class="form-label" >Acc. </label>
                <a data-toggle="tooltip" title="Eliminar" class="btn btn-icon  btn-danger" onclick="deleteAlumno(this)"><i class="fe fe-trash"></i></a>
            </div>
        </div>
    </div>
</script>

<script id="sesionPagoTemplate" type="text/html">
    <div class="row">
        <div class="col-md-9">
            <div class="form-group">
                <label class="form-label">Sesion <span class="text-red">*</span></label>
                <select required class="form-control select-sesion" name="sesion_id">
                    <option value="" disabled selected hidden>-- Buscar Sesion --</option>
                    {{#sesiones}}
                    <option value="{{id}}">{{text}}</option>
                    {{/sesiones}}
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <label class="form-label" >Apoderados Reg. </label>
            <input type="text" class="form-control sesion-num_apoderados" name="num_apoderados" placeholder="0" readonly> 
        </div> 
    </div>
</script>

<script id="apoderadosTemplate" type="text/html">
    {{#apoderados}}
    <div class="row">
        <input type="hidden" class="form-control sesion-id_apoderado" name="items[apoderado_id][]" value="{{apoderado_id}}">
        <div class="col-md-12">
            <label class="form-label" >Apoderado </label>
            <input type="text" class="form-control sesion-nombre_apoderado" name="items[nombre][]" value="{{nombre}}" readonly> 
        </div>
    </div>
    <br>
    {{/apoderados}}
</script>

<script id="sesionTemplate" type="text/html">
    <div class="row">
        <div class="col-md-5">
            <div class="form-group">
                <label class="form-label">Sesion <span class="text-red">*</span></label>
                <select required class="form-control select-sesion" name="sesion_id">
                    <option value="" disabled selected hidden>-- Buscar Sesion --</option>
                    {{#sesiones}}
                    <option value="{{id}}">{{text}}</option>
                    {{/sesiones}}
                </select>
            </div>
        </div>
        <div class="col-md-5">
            <label class="form-label" >Docente </label>
            <input type="text" class="form-control sesion-docente" name="docente" placeholder="Docente" readonly>
        </div> 
        <div class="col-md-2"> 
            <label class="form-label" >Alumnos </label>
            <input type="text" class="form-control sesion-alumnos" name="alumnos" placeholder="0" readonly> 
        </div>
    </div>
</script>

<script id="apoderadoTemplate" type="text/html">
    <div class="row" style="margin-bottom: 1em;">
        <div class="col-md-10">
            <label class="form-label">Apoderado <span class="text-red">*</span></label> 
            <select required class="form-control select-apoderado" name="items[apoderado_id][]">
                <option value="" disabled selected hidden>-- Buscar Apoderado --</option>
                {{#apoderados}}
                <option value="{{id}}">{{text}}</option>
                {{/apoderados}}
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label" >Acc. </label>
            <a data-toggle="tooltip" title="Eliminar" class="btn btn-icon  btn-danger" onclick="deleteApoderado(this)"><i class="fe fe-trash"></i></a>
        </div> 
    </div>
</script>