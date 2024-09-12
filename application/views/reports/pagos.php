<?php require_once  __DIR__.'/../include/header.php'; ?>
<?php require_once  __DIR__.'/../include/sidebar.php'; ?>
<!-- page content -->
<!--Page header-->
<div class="page-header">
	<div class="page-leftheader">
		<h4 class="page-title mb-0"><?= $page_title ?></h4>
		<ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>"><i class="fe fe-layers mr-2 fs-14"></i>Inicio</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="<?= base_url() ?>jornadas/jornada"><?= $page_title ?></a></li>
		</ol>
	</div>
    <!-- div class="page-rightheader">
        <div class="btn btn-list">
            <a type="button" data-toggle="tooltip" data-placement="left" class="btn btn-primary" title="Volver" 
                href="<?= base_url() ?>jornadas/list_jornadas?num=<?= $obra_id ?>">
                <i class="fe fe-arrow-left mr-1" ></i>Volver
            </a>
        </div>
    </div -->
</div>
<!--End Page header-->

<!-- Row -->
<div class="row">
    <div class="col-md-12">     
        <div class="pull-right" style="width: 17em;">
            <label for="status" > Selec. Estado :</label>
            <?php
            form_dropdown_array("status",
                $estados,
                " id='status' class='form-control select2-show-search' "
                , $status, OPTION_DEFAULT_ALL, "codigo", "valor");
            ?>
            &nbsp;
        </div>               
        <div class="pull-right" style="width: 17em; margin-right: 1em;">
            <label for="forma_pago" > Selec. Forma Pago :</label>
            <?php
            form_dropdown_array("forma_pago",
                $forma_pagos,
                " id='forma_pago' class='form-control select2-show-search' "
                , $forma_pago, OPTION_DEFAULT_ALL, "codigo", "valor");
            ?>
            &nbsp;
        </div>                  
        <div class="pull-right" style="width: 17em; margin-right: 1em;">
            <label for="apoderado" > Selec. Apoderado :</label>
            <?php
            form_dropdown_array("apoderado",
                $apoderados,
                " id='apoderado' class='form-control select2-show-search' "
                , $apoderado, OPTION_DEFAULT_ALL, "id", "apoderado");
            ?>
            &nbsp;
        </div>    
    </div>
</div>
<div class="row">
	<div class="col-md-12">        
		<div class="card">
			<div class="card-body">
				<div class="">
					<table id="table1" class="table table-striped table-bordered">
						<thead>
						<tr>
							<th>Apoderado</th>
                            <th>Estado</th>
							<th>Fecha Registro</th>
							<th>Fecha Programación</th>
							<th>Fecha Pago</th>
							<th>Forma Pago</th>
							<th>Monto</th>
						</tr>
						</thead>
                            <tfoot>
                            <tr>
                                <td colspan="6" style="text-align: right;letter-spacing: 0.3px;"></td>
                                <td></td>
                            </tr>
                            </tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End Row -->
<!-- /page content -->
<?php require_once  __DIR__.'/../include/footer.php'; ?>

<script type="text/javascript">

    var table1 = undefined;

    $(function(){
            
        $("#apoderado").on("change", function() {
            table1.draw();
        });

        $("#forma_pago").on("change", function() {
            table1.draw();
        });

        $("#status").on("change", function() {
            table1.draw();
        });

        table1 = $('#table1').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?= $uri["report"] ?>",
                "type": "POST",
                "data":
                function(data) {                       
                    data.apoderado = $('#apoderado').val();
                    data.forma_pago = $('#forma_pago').val();  
                    data.status = $('#status').val();  
                },
            },
            "aaSorting": [[0, "desc"]],
            "columns": [
                { "data": "apoderado" },
                { "data": "status" },
                { "data": "fecha_reg" },
                { "data": "fecha_prog" },
                { "data": "fecha_pago" },
                { "data": "forma_pago" },
                { "data": "monto" },
            ],
            "footerCallback": function ( row, data, start, end, display ) {
                var api = this.api();
                api.columns().every(function (index) {
                var column = this;
                var sum = column.data().reduce(function (a, b) {
                    return parseFloat(a) + parseFloat(b);
                }, 0);				
                $(column.footer()).html("<b>" + (index <=5 ? "TOTAL MONTO: " : sum.toFixed(2)) + "</b>" );
                });
            },
            "columnDefs": [
                {
                    "targets": [6],
                    "render": function(d){
                        var m = parseFloat(d || .0);
                        return m.toFixed(2);
                    },
                }
            ],       
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            // Aquí agregas la opción dom
            dom: '<"mb-2"<"d-flex justify-content-between"Blf>>t<"mt-2"ip>',
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o mr-1"></i> Exportar a Excel',
                    titleAttr: 'Exportar a Excel',
                    className: 'btn btn-excel mr-2',
                    title: function(){
                        return 'Reporte de Pagos';
                    },    
                    filename: function(){
                        var date = new Date().toISOString().slice(0,19).replace(/[-T]/g,'').replace(/:/g,'');
                        return 'report_' + date + '_excel';
                    },
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fa fa-file-pdf-o mr-1"></i> Exportar a PDF',
                    titleAttr: 'Exportar a PDF',
                    className: 'btn btn-pdf',
                    title: function(){
                        return 'Reporte de Pagos';
                    },    
                    filename: function(){
                        var date = new Date().toISOString().slice(0,19).replace(/[-T]/g,'').replace(/:/g,'');
                        return 'report_' + date + '_pdf';
                    }     
                }
            ]
        });
    });

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

</script>

<!-- Style. Juanciño -->
<style>
    .btn-pdf {
        background-color: #ff0000;
        border-color: #ff0000;
    }
    .btn-excel {
        background-color: #38cb89;
        border-color: #38cb89;
    }
    .dataTables_wrapper .dt-buttons .btn-pdf:hover {
        background-color: #ff0000a6;
    }
    .dataTables_wrapper .dt-buttons .btn-excel:hover {
        background-color: #38cb89d6;
    }
	.select2-selection__rendered {
		color: #9cc3b4 !important;
	}
</style>