<?php require_once  __DIR__.'/../include/header.php'; ?>
<?php require_once  __DIR__.'/../include/sidebar.php'; ?>
<!-- page content -->

    <!--Page header-->
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title mb-0"><?= $page_title ?></h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>"><i class="fe fe-layers mr-2 fs-14"></i>Inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="<?= base_url() ?>obras/obra"><?= $uri["title"] ?></a></li>
            </ol>
        </div>
        <div class="page-rightheader">
			<div class="btn btn-list">
                <a type="button" data-toggle="tooltip" data-placement="left" class="btn btn-primary" title="Volver" 
                    href="<?= base_url() ?>pagos/pago">
                    <i class="fe fe-arrow-left mr-1" ></i>Volver
                </a>
            </div>
        </div>
    </div>
    <!--End Page header-->

    <!-- Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="">
                        <table id="table1" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>id</th>
                                <th>apoderado</th>
                                <th>fregistro</th>
                                <th>fprogramado</th>
                                <th>fpago</th>
                                <th>formpago</th>
                                <th>monto</th>
                                <th>estado</th>
                                <th width="110px">acc.</th>
                            </tr>
                            </thead>
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

	function openForm(id) {
	    id = id || 0;
        jj.modalFormCreate({id:id}, '<?= $uri["create"] ?>', '<?= $uri["save"] ?>', false, refreshTable, 
            {
                title: (id ? "Editar" : "Nuevo") + " Registro",
            }
        );
	}

    function refreshTable(data) {
        table1.ajax.reload();
    }

	$(function(){

        table1 = $('#table1').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?= $uri["list"] ?>",
                "type": "POST"
            },
            "aaSorting": [[0, "desc"]],
            "columns": [
                { "data": "id" },
                { "data": "apoderado" },
                { "data": "fecha_reg" },
                { "data": "fecha_prog" },
                { "data": "fecha_pago" },
                { "data": "forma_pago" },
                { "data": "monto" },
                { "data": "status" },
                { "data": null },
            ],
            "columnDefs": [
                {
                    "targets": 0,
                    "visible": true,
                    "searchable": false
                },
                {
                    "targets": 8,
                    "render": function( data, type, row) {
                        var h = Mustache.render($("#tplDtColumnPagosDet").html(),
                                {
                                    row_id:  data.id,
                                    uri_remove: '<?= $uri["remove"] ?>',
                                    callback_rem: 'refreshTable'
                                }
                            );
                        return h;
                    },
                    "bSortable": false,
                },
            ],    
            "createdRow": function (row, data, index) {
                var status = data.status;
                if (status === '<?= RECORD_STATUS_CANCELADO_TEXT ?>') {
                    $(row).find('td:eq(7)').html('<span class="mb-0 text-success fs-13 font-weight-semibold">PAGADO</span>');
                } else if (status === '<?= RECORD_STATUS_PENDIENTE_TEXT ?>') {
                    $(row).find('td:eq(7)').html('<span class="mb-0 text-warning fs-13 font-weight-semibold">PENDIENTE</span>');
                }
            },     
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            }
    
        } );

        $("#table1").on("click", ".btnEdit", function() {
            openForm($(this).data("row-id"));
        });

	});
</script>
