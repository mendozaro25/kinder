<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sesiones extends MY_Controller {
	private $data;
	public function __construct()
	{
		parent::__construct();
		$this->data["page_title"] = "Sesiones";
	}

	public function index()
	{
		redirect(base_url());
	}

	public function sesion() {
        $this->data["uri"] = [
            "title"         => "Sesiones",
            "list"          => base_url().$this->name()."/sesion_list",
            "create"        => base_url().$this->name()."/sesion_create",
            "save"          => base_url().$this->name()."/sesion_save",
            "remove"        => base_url().$this->name()."/sesion_delete",
        ];
		$this->load->view($this->name()."/list", $this->data);
	}

    public function sesion_list() {
		$requestData = $this->input->post();
		$columns = array(
			// datatable column index  => database column name
			0 => 'id',
			1 => 'sesion',
			2 => 'docente',
			3 => 'alumnos',
			4 => 'auxiliar',
			5 => 'status',
		);

		$sql = "select
					s.id, 
					s.nombre_grupo as sesion,
					concat(d.nombres,' ',d.apellidos) as docente,
					(
						select COUNT(alumno_id)
						from sesion_det
						where sesion_id = s.id
					) as alumnos,
					ifnull(concat(a.nombres, ' ', a.apellidos), '') as auxiliar,
					k1.valor as status
				from sesion s
				inner join constante k1 on k1.idconstante = ".ID_CONST_REG_STATUS." and k1.codigo = s.status
				inner join docente d on d.id = s.docente_id
				left join auxiliar a on a.id = s.auxiliar_id
				where 1 = 1";

		$rs = $this->db->query($sql);

		$totalData = $rs->num_rows();
		$totalFiltered = $totalData;

		if ($totalData) {
			$sql .= " AND 1 = 1";

			if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
				$sql.=" AND ( a.id LIKE '".$requestData['search']['value']."%' ";
                $sql.=" OR s.nombre_grupo LIKE '".$requestData['search']['value']."%'";
                $sql.=" OR concat(d.nombres,' ',d.apellidos) LIKE '".$requestData['search']['value']."%'";
				$sql.=" OR ifnull(concat(a.nombres, ' ', a.apellidos), '') LIKE '".$requestData['search']['value']."%') ";
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

    public function sesion_create() {
		$data = [];
		if ($id = $this->input->post("id")){
			$sql__ = 
				"select 
					count(sd.id) as alumno_count
				from sesion s
				inner join sesion_det sd on sd.sesion_id = s.id
				where s.id = $id";
			$this->data["pcount"] =  $this->db->query($sql__)->row_array();

			$sql_ = 
				"select 
					sd.id as sesion_det_id,
					s.id as sesion_id,
					a.id as alumno_id,
					concat(a.nombres,' ',a.apellidos) as nombre_alumno,
					a.dni,
					concat(ap.nombres,' ',ap.apellidos) as nombre_apoderado
				from sesion_det sd
				inner join sesion s on s.id = sd.sesion_id
				inner join alumno a on a.id = sd.alumno_id
				inner join apoderado ap on ap.id = a.apoderado_1
				where s.id = $id";
			$this->data["data_ses_det"] = $this->db->query($sql_)->result_array();

			$this->data["rs"] = array_merge($data, gw("sesion", ["id" => $id ])->row_array());

		}

		#	die(var_dump($this->data["docentes"]));

		$alumnos = gw("alumno", ["status" => RECORD_STATUS_ACTIVE])->result_array();
		$alumnoData = [];
		foreach ($alumnos as $item) {
			$alumnoData[] = [
				'id' => $item['id'],
				'text' => $item['nombres'].' '.$item['apellidos'],
				'dni' => $item['dni'],
				'apoderado' => gw("apoderado", ["id" => $item['apoderado_1']])->row()->nombres,
			];
		}
		$this->data["alumnos"] = $alumnoData;
		
		
		$this->data["docentes"] = gw("docente", ["status" => RECORD_STATUS_ACTIVE ])->result_array();
		$this->data["auxiliares"] = gw("auxiliar", ["status" => RECORD_STATUS_ACTIVE ])->result_array();
		
		$this->load->view($this->name() . "/create", $this->data);
	}

    public function sesion_save() {
		$ret["success"] = false;

        date_default_timezone_set('America/Lima');

		$id = $this->input->post("id");
		$nombre_grupo = $this->input->post("nombre_grupo");
		$docente_id = $this->input->post("docente_id");
		$auxiliar_id = $this->input->post("auxiliar_id");
		$items = $_POST["items"];
		#	die(var_dump($items));
		$status = $this->input->post("status");
        $tm = date('Y-m-d H:i:s', time());		
		$alumno_count = $this->input->post("alumno_count");

		$data = [
            "nombre_grupo"			    => $nombre_grupo,
            "docente_id"			    => $docente_id,
            "auxiliar_id"			   	=> $auxiliar_id,
            "created_user_id"			=> $this->session->userdata("userID"),
            "created_datetime"			=> $tm,
            "status"			        => $status,
        ];

		$detalle_sesion_data = [];

		try {

			$this->db->trans_start();

			if ($id > 0) {

				$data["updated_user_id"] = $this->session->userdata("userID");
                $data["updated_datetime"] = $tm;

				$this->Constant_model->updateData("sesion", $data, $id);

				$this->Constant_model->deleteByColumn("sesion_det", "sesion_id", $id);

				for ($i = 0; $i < $alumno_count; $i++) {
					$alumno_id = $items["alumno_id"][$i];
					
					$detalle_sesion_data = [
						"alumno_id"        	=> $alumno_id,
						"sesion_id"       	=> $id,
					];
	
					$sesion_det_id = $this->Constant_model->insertDataReturnLastId("sesion_det", $detalle_sesion_data);
				}

            } else {

				$sesion_id = $this->Constant_model->insertDataReturnLastId("sesion", $data);

				for ($i = 0; $i < $alumno_count; $i++) {
					$alumno_id = $items["alumno_id"][$i];
					
					$detalle_sesion_data = [
						"alumno_id"        	=> $alumno_id,
						"sesion_id"       	=> $sesion_id,
					];
	
					$sesion_det_id = $this->Constant_model->insertDataReturnLastId("sesion_det", $detalle_sesion_data);
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

    public function sesion_delete() {
		$ret["success"] = false;
		$id = $this->input->post("id");
		try {
			if (!($record  = $this->Constant_model->getSingleOneColumn("sesion", "id", $id)))
				throw new Exception("Registro no encontrado");
			$this->Constant_model->updateData("sesion", ["status" => 0, "deleted_datetime" => date('Y-m-d H:i:s', time()) ], $id);
			$ret["success"] = true;
		} catch (Exception $ex) {
			$ret["message"] = $ex->getMessage();
		}
		header('Content-Type: application/json');
		echo json_encode($ret);
	}
}
