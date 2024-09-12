<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pagos extends MY_Controller {
	private $data;
	public function __construct()
	{
		parent::__construct();
		$this->data["page_title"] = "Pagos";
	}

	public function index()
	{
		redirect(base_url());
	}

	public function pago() {
        $this->data["uri"] = [
            "title"         => "Pagos",
            "list"          => base_url().$this->name()."/pago_list",
            "create"        => base_url().$this->name()."/pago_create",
            "save"          => base_url().$this->name()."/pago_save",
            "remove"        => base_url().$this->name()."/pago_delete",
        ];
		$this->load->view($this->name()."/list", $this->data);
	}

    public function pago_list() {
		$requestData = $this->input->post();
		$columns = array(
			// datatable column index  => database column name
			0 => 'id',
			1 => 'fecha_reg',
			2 => 'dias_prog',
			3 => 'fecha_prog',
			4 => 'concepto',
			5 => 'sesion',
			6 => 'monto',
			7 => 'apoderados',
			8 => 'pagados',
			9 => 'finalizados',
			10 => 'status',
		);

		$sql = "select distinct
					pp.id,
					pp.fecha_reg,
					k3.valor as dias_prog,
					ppd.fecha_prog,
					k2.valor as concepto,
					s.nombre_grupo as sesion,
					format(pp.monto, 2) as monto,
					(
						select count(apoderado_id)
						from prog_pago_det
						where progr_pago_id = pp.id
					) as apoderados,
					(
						select sum(estado_id = '".VALUE_PAG."')
						from prog_pago_det
						where progr_pago_id = pp.id
					) as pagados,
					cast(
						(
							select sum(estado_id = '".VALUE_PAG."')
							from prog_pago_det
							where progr_pago_id = pp.id
						) / (
							select count(apoderado_id)
							from prog_pago_det
							where progr_pago_id = pp.id
						) * 100 as unsigned
					) as finalizados,
					k1.valor as status
				from progr_pago pp
				inner join prog_pago_det ppd on ppd.progr_pago_id = pp.id
				inner join sesion s on s.id = ppd.sesion_id
				inner join constante k1 on k1.idconstante = ".ID_CONST_REG_STATUS." and k1.codigo = pp.status
				inner join constante k3 on k3.idconstante = ".ID_CONST_REG_FECHAPROG." and k3.codigo = pp.dias_prog
				inner join constante k2 on k2.idconstante = ".ID_CONST_REG_CONCEP." and k2.codigo = pp.concepto_id
				where 1 = 1";

		$rs = $this->db->query($sql);

		$totalData = $rs->num_rows();
		$totalFiltered = $totalData;

		if ($totalData) {
			$sql .= " AND 1 = 1";

			if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
				$sql.=" AND ( pp.id LIKE '".$requestData['search']['value']."%' ";
                $sql.=" OR k3.valor LIKE '".$requestData['search']['value']."%'";
                $sql.=" OR pp.fecha_reg LIKE '".$requestData['search']['value']."%'";
                $sql.=" OR ppd.fecha_prog LIKE '".$requestData['search']['value']."%'";
                $sql.=" OR s.nombre_grupo LIKE '%".$requestData['search']['value']."%'";
				$sql.=" OR k2.valor LIKE '%".$requestData['search']['value']."%') ";
			}

			$rs = $this ->db->query($sql);
			$totalFiltered = $rs->num_rows();

			$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']] ."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

			$rs = $this ->db->query($sql)->result_array();
		}

		echo json_encode([
			    "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
			    "recordsTotal"    => intval( $totalData ),  // total number of records
			    "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			    "data"            => $rs   // total data array
		    ]);
		exit;
	}

    public function pago_create() {
		$data = [];
		if ($id = $this->input->post("id")){
			$sql__ = 
				"select 
					count(ppd.id) as apoderado_count
				from progr_pago pp
				inner join prog_pago_det ppd on ppd.progr_pago_id = pp.id
				where pp.id = $id";
			$this->data["pcount"] =  $this->db->query($sql__)->row_array();

			$sql_ = 
				"select 
					ppd.id as progr_pago_det_id,
					pp.id as progr_pago_id,
					ap.id as apoderado_id,
					concat(ap.nombres,' ',ap.apellidos) as nombre_apoderado,
					ppd.sesion_id
				from prog_pago_det ppd
				inner join progr_pago pp on pp.id = ppd.progr_pago_id
				inner join apoderado ap on ap.id = ppd.apoderado_id
				where pp.id = $id";
			$this->data["data_ses_det"] = $this->db->query($sql_)->result_array();

			$this->data["rs"] = array_merge($data, gw("progr_pago", ["id" => $id ])->row_array());

			$apoderados = gw("apoderado", ["status" => RECORD_STATUS_ACTIVE])->result_array();
			$apoderadoData = [];
			foreach ($apoderados as $item) {
				$apoderadoData[] = [
					'id' => $item['id'],
					'text' => $item['nombres'].' '.$item['apellidos'],
				];
			}
			$this->data["apoderados"] = $apoderadoData;

		}

		#	die(var_dump($this->data["docentes"]));

		$sesiones = gw("sesion", ["status" => RECORD_STATUS_ACTIVE])->result_array();
		$sesionData = [];
		foreach ($sesiones as $item) {
			$sesionData[] = [
				'id' => $item['id'],
				'text' => $item['nombre_grupo'],
				'num_apoderados' => $this->db->query("select count(distinct ap.id) as apoderado_count from sesion s inner join sesion_det sd on sd.sesion_id = s.id inner join alumno a on a.id = sd.alumno_id inner join apoderado ap on ap.id = a.apoderado_1 where s.id = ".$item['id'])->row_array(),
				'apoderados' => $this->db->query("select distinct ap.id as apoderado_id, concat(ap.nombres,' ',ap.apellidos) as nombre from sesion s inner join sesion_det sd on sd.sesion_id = s.id inner join alumno a on a.id = sd.alumno_id inner join apoderado ap on ap.id = a.apoderado_1 where s.id = ".$item['id'])->result_array(),
			];
		}
		$this->data["sesiones"] = $sesionData;
		
		$this->load->view($this->name() . "/create", $this->data);
	}

    public function pago_save() {
		$ret["success"] = false;

        date_default_timezone_set('America/Lima');

		$id = $this->input->post("id");
		$concepto_id = $this->input->post("concepto_id");
		$sesion_id = $this->input->post("sesion_id");
		#	die(var_dump($concepto_id));
		$monto = $this->input->post("monto");
		$fecha_reg = $this->input->post("fecha_reg");
		$dias_prog = $this->input->post("dias_prog");
		$items = $_POST["items"];
		#	die(var_dump($items));
		$status = $this->input->post("status");
        $tm = date('Y-m-d H:i:s', time());
		$apoderado_count = $this->input->post("apoderado_count");

		$ddif = (int) gw("constante", ["idconstante" => ID_CONST_REG_FECHAPROG, "codigo" => $dias_prog])->row()->descripcion;
		$fecha_prog = date("Y-m-d",strtotime($fecha_reg."+ $ddif days"));

		#	die(var_dump($fecha_reg));

		$data = [
            "concepto_id"			    => $concepto_id,
            "monto"			    		=> $monto,
            "fecha_reg"			   		=> $fecha_reg,
            "dias_prog"			   		=> $dias_prog,
            "created_user_id"			=> $this->session->userdata("userID"),
            "created_datetime"			=> $tm,
            "status"			        => $status,
        ];

		$detalle_prog_pago_data = [];

		try {

			$this->db->trans_start();

			if ($id > 0) {

				$data["updated_user_id"] = $this->session->userdata("userID");
                $data["updated_datetime"] = $tm;

				$this->Constant_model->updateData("progr_pago", $data, $id);

				$this->Constant_model->deleteByColumn("prog_pago_det", "progr_pago_id", $id);

				for ($i = 0; $i < $apoderado_count; $i++) {
					$apoderado_id = $items["apoderado_id"][$i];
					
					$detalle_prog_pago_data = [
						"progr_pago_id"     => $id,
						"sesion_id"     	=> $sesion_id,
						"apoderado_id"      => $apoderado_id,
						"estado_id"      	=> 'PNT',
						"fecha_reg"      	=> $fecha_reg,
						"fecha_prog"      	=> $fecha_prog,
						"monto"      		=> $monto,
					];
	
					$progr_pago_det_id = $this->Constant_model->insertDataReturnLastId("prog_pago_det", $detalle_prog_pago_data);
				}

            } else {

				$progr_pago_id = $this->Constant_model->insertDataReturnLastId("progr_pago", $data);

				for ($i = 0; $i < $apoderado_count; $i++) {
					$apoderado_id = $items["apoderado_id"][$i];

					$detalle_prog_pago_data = [
						"progr_pago_id"     => $progr_pago_id,
						"sesion_id"     	=> $sesion_id,
						"apoderado_id"      => $apoderado_id,
						"estado_id"      	=> 'PNT',
						"fecha_reg"      	=> $fecha_reg,
						"fecha_prog"      	=> $fecha_prog,
						"monto"      		=> $monto,
					];
	
					$progr_pago_det_id = $this->Constant_model->insertDataReturnLastId("prog_pago_det", $detalle_prog_pago_data);
				}

            }

			$this->db->trans_complete();
			$ret["success"] = true;

		} catch (Exception $ex) {

			$ret["message"] = $ex->getMessage();
		}

		header('Content-Type: application/json');
		echo json_encode($ret);
	}

    public function pago_delete() {
		$ret["success"] = false;
		$id = $this->input->post("id");
		try {
			if (!($record  = $this->Constant_model->getSingleOneColumn("progr_pago", "id", $id)))
				throw new Exception("Registro no encontrado");
			$this->Constant_model->updateData("progr_pago", ["status" => 0, "deleted_datetime" => date('Y-m-d H:i:s', time()) ], $id);
			$ret["success"] = true;
		} catch (Exception $ex) {
			$ret["message"] = $ex->getMessage();
		}
		header('Content-Type: application/json');
		echo json_encode($ret);
	}

	public function det_pago() {
		$progr_pago_id = $this->input->get("ppID");
        $this->data["uri"] = [
            "title"         => "Detalle Pago",
            "list"          => base_url().$this->name()."/det_pago_list?ppID=$progr_pago_id",
            "create"        => base_url().$this->name()."/det_pago_create",
            "save"          => base_url().$this->name()."/det_pago_save",
            "remove"        => base_url().$this->name()."/det_pago_delete",
        ];		
		$this->load->view($this->name()."/list_det", $this->data);
	}

	public function det_pago_list() {
		$requestData = $this->input->post();
		$progr_pago_id = $this->input->get("ppID");
		$columns = array(
			// datatable column index  => database column name
			0 => 'id',
			1 => 'apoderado',
			2 => 'fecha_reg',
			3 => 'fecha_prog',
			4 => 'fecha_pago',
			5 => 'forma_pago',
			6 => 'monto',
			7 => 'status',
		);

		$sql = "select
					ppd.id, 
					concat(ap.nombres,' ',ap.apellidos) as apoderado,
					ppd.fecha_reg,
					ppd.fecha_prog,
					ppd.fecha_pago,
					ifnull(k1.valor, '') as forma_pago,
					format(ppd.monto, 2) as monto,
					k2.valor as status
				from prog_pago_det ppd
				inner join apoderado ap on ap.id = ppd.apoderado_id
				left join constante k1 on k1.idconstante = ".ID_CONST_REG_FPAGO." and k1.codigo = ppd.forma_pago_id
				inner join constante k2 on k2.idconstante = ".ID_CONST_REG_ESTADOPAG." and k2.codigo = ppd.estado_id
				where 1 = 1 and ppd.progr_pago_id = $progr_pago_id ";

		$rs = $this->db->query($sql);

		$totalData = $rs->num_rows();
		$totalFiltered = $totalData;

		if ($totalData) {
			$sql .= " AND 1 = 1";

			if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
				$sql.=" AND ( ppd.id LIKE '".$requestData['search']['value']."%' ";
				$sql.=" OR concat(ap.nombres,' ',ap.apellidos) LIKE '".$requestData['search']['value']."%') ";
			}

			$rs = $this ->db->query($sql);
			$totalFiltered = $rs->num_rows();

			$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']] ."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

			$rs = $this ->db->query($sql)->result_array();
		}

		echo json_encode([
			    "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
			    "recordsTotal"    => intval( $totalData ),  // total number of records
			    "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			    "data"            => $rs   // total data array
		    ]);
		exit;
	}

	public function det_pago_create() {
		$data = [];
		if ($id = $this->input->post("id"))
			$this->data = array_merge($data, gw("prog_pago_det", ["id" => $id ])->row_array());
		
		$this->load->view($this->name() . "/create_det", $this->data);
	}

    public function det_pago_save() {
		$ret["success"] = false;

        date_default_timezone_set('America/Lima');

		$id = $this->input->post("id");
		$fecha_pago = $this->input->post("fecha_pago");
		$forma_pago_id = $this->input->post("forma_pago_id");
		$estado_id = $this->input->post("estado_id");

		if($estado_id == VALUE_PNT) {
			$forma_pago_id = null;
			$fecha_pago = null;
		} else {
			$forma_pago_id = $this->input->post("forma_pago_id");
			$fecha_pago = $this->input->post("fecha_pago");
		}

		$data = [
            "fecha_pago"			    => $fecha_pago,
            "forma_pago_id"			    => $forma_pago_id,
            "estado_id"			   		=> $estado_id,
        ];

		try {

			$this->db->trans_start();

			if ($id > 0) {

				$data["updated_user_id"] = $this->session->userdata("userID");
                $data["updated_datetime"] = $tm;

				$this->Constant_model->updateData("prog_pago_det", $data, $id);

            }

			$this->db->trans_complete();
			$ret["success"] = true;

		} catch (Exception $ex) {

			$ret["message"] = $ex->getMessage();
		}

		header('Content-Type: application/json');
		echo json_encode($ret);
	}

    public function det_pago_delete() {
		$ret["success"] = false;
		$id = $this->input->post("id");
		try {
			if (!($record  = $this->Constant_model->getSingleOneColumn("prog_pago_det", "id", $id)))
				throw new Exception("Registro no encontrado");
			$this->Constant_model->deleteData("prog_pago_det", $id);
			$ret["success"] = true;
		} catch (Exception $ex) {
			$ret["message"] = $ex->getMessage();
		}
		header('Content-Type: application/json');
		echo json_encode($ret);
	}
}
