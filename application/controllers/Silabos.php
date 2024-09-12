<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Silabos extends MY_Controller {
	private $data;
	public function __construct()
	{
		parent::__construct();
		$this->data["page_title"] = "Silabos";
	}

	public function index()
	{
		redirect(base_url());
	}

	public function silabo() {
        $this->data["uri"] = [
            "title"         => "Silabos",
            "list"          => base_url().$this->name()."/silabo_list",
            "create"        => base_url().$this->name()."/silabo_create",
            "save"          => base_url().$this->name()."/silabo_save",
            "remove"        => base_url().$this->name()."/silabo_delete",
        ];
		$this->load->view($this->name()."/list", $this->data);
	}

    public function silabo_list() {
		$requestData = $this->input->post();
		$columns = array(
			// datatable column index  => database column name
			0 => 'id',
			1 => 'fecha_reg',
			2 => 'fecha_vigencia',
			3 => 'sesion',
			4 => 'docente',
			5 => 'material_archivo',
			6 => 'status',
		);

        $id = $this->session->userdata("userID");
		$usernamer = $this->session->userdata("username");

		if($usernamer == USERNAME_ADMIN){

			$sql = "select 
						s.id, 
						s.fecha_reg,
						s.fecha_vigencia, 
						ss.nombre_grupo as sesion,
						concat(d.nombres,' ',d.apellidos) as docente,
						s.material_archivo,
						k1.valor as status 
					from silabo s
					inner join constante k1 on k1.idconstante = ".ID_CONST_REG_STATUS." and k1.codigo = s.status
					inner join sesion ss on ss.id = s.sesion_id
					inner join docente d on d.id = ss.docente_id
					where 1 = 1";

		} else {
			

				$sql = "select 
				s.id, 
				s.fecha_reg,
				s.fecha_vigencia, 
				ss.nombre_grupo as sesion,
				concat(d.nombres,' ',d.apellidos) as docente,
				s.material_archivo,
				k1.valor as status 
			from silabo s
			inner join constante k1 on k1.idconstante = ".ID_CONST_REG_STATUS." and k1.codigo = s.status
			inner join sesion ss on ss.id = s.sesion_id
			inner join docente d on d.id = ss.docente_id
			where 1 = 1 and s.created_user_id = $id";
		}

		$rs = $this->db->query($sql);

		$totalData = $rs->num_rows();
		$totalFiltered = $totalData;

		if ($totalData) {
			$sql .= " AND 1 = 1";

			if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
				$sql.=" AND ( s.id LIKE '".$requestData['search']['value']."%' ";
                $sql.=" OR s.fecha_reg LIKE '".$requestData['search']['value']."%'";
                $sql.=" OR ss.nombre_grupo LIKE '%".$requestData['search']['value']."%'";
				$sql.=" OR concat(d.nombres,' ',d.apellidos) LIKE '%".$requestData['search']['value']."%') ";
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

    public function silabo_create() {
		$data = [];
		if ($id = $this->input->post("id")){

			$sesion_id = gw("silabo", ["id" => $id])->row()->sesion_id;

			$sql_ = 
				"select 
					s.id as sesion_id,
					s.nombre_grupo,
					count(sd.id) as alumno_count,
					concat(d.nombres,' ',d.apellidos) as docente
				from sesion_det sd
				inner join sesion s on s.id = sd.sesion_id
				inner join docente d on d.id = s.docente_id
				where s.id = $sesion_id";
			$this->data["data_silabo"] = $this->db->query($sql_)->row_array();
			
			$this->data["rs"] = array_merge($data, gw("silabo", ["id" => $id ])->row_array());
		}
		
		$sesiones = gw("sesion", ["status" => RECORD_STATUS_ACTIVE])->result_array();
		$sesionData = [];
		foreach ($sesiones as $item) {
			$sesionData[] = [
				'id' => $item['id'],
				'text' => $item['nombre_grupo'],
				'alumnos' => $this->db->query("select count(sd.id) as alumno_count from sesion s inner join sesion_det sd on sd.sesion_id = s.id where s.id = ".$item['id'])->row_array(),
				'docente' => gw("docente", ["id" => $item['docente_id']])->row()->nombres . ' ' . gw("docente", ["id" => $item['docente_id']])->row()->apellidos,
			];
		}
		$this->data["sesiones"] = $sesionData;
		
		$this->load->view($this->name() . "/create", $this->data);
	}

    public function silabo_save() {
		$ret["success"] = false;

        date_default_timezone_set('America/Lima');

		$id = $this->input->post("id");
		$sesion_id = $this->input->post("sesion_id");
		$fecha_reg = $this->input->post("fecha_reg");
		$fecha_vigencia = $this->input->post("fecha_vigencia");
		$status = $this->input->post("status");
        $tm = date('Y-m-d H:i:s', time());

		if ($file = uploadFile("material_archivo", $id, UPLOAD_PATH_DOCUMENTS, ["pdf"])) {
			$__files = $file;
			$this->db->trans_start();
			$material["material_archivo"] = $__files;
			$this->Constant_model->updateData("silabo", $material, $id);
			$this->db->trans_complete();
			$ret["success"] = true;
		}				

        $data = [
            "sesion_id"			        => $sesion_id,
            "fecha_reg"			        => $fecha_reg,
            "fecha_vigencia"			=> $fecha_vigencia,
            "created_user_id"			=> $this->session->userdata("userID"),
            "created_datetime"			=> $tm,
            "status"			        => $status,
        ];

		#	die(var_dump($data));

		try {

			$this->db->trans_start();

			if ($id > 0) {
					
                $data["updated_user_id"] = $this->session->userdata("userID");
                $data["updated_datetime"] = $tm;

				$this->Constant_model->updateData("silabo", $data, $id);

            } else {
				$data["material_archivo"] = $__files;
				$silabo_id = $this->Constant_model->insertDataReturnLastId("silabo", $data);

            }

			$this->db->trans_complete();
			$ret["success"] = true;

		} catch (Exception $ex) {

			$ret["message"] = $ex->getMessage();
		}

		header('Content-Type: application/json');
		echo json_encode($ret);
	}

    public function silabo_delete() {
		$ret["success"] = false;
		$id = $this->input->post("id");
		try {
			if (!($record  = $this->Constant_model->getSingleOneColumn("silabo", "id", $id)))
				throw new Exception("Registro no encontrado");
			$this->Constant_model->updateData("silabo", ["status" => 0, "deleted_datetime" => date('Y-m-d H:i:s', time()) ], $id);
			$ret["success"] = true;
		} catch (Exception $ex) {
			$ret["message"] = $ex->getMessage();
		}
		header('Content-Type: application/json');
		echo json_encode($ret);
	}
}
