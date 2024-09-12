<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alumnos extends MY_Controller {
	private $data;
	public function __construct()
	{
		parent::__construct();
		$this->data["page_title"] = "Alumnos";
	}

	public function index()
	{
		redirect(base_url());
	}

	public function alumno() {
        $this->data["uri"] = [
            "title"         => "Alumnos",
            "list"          => base_url().$this->name()."/alumno_list",
            "create"        => base_url().$this->name()."/alumno_create",
            "save"          => base_url().$this->name()."/alumno_save",
            "remove"        => base_url().$this->name()."/alumno_delete",
        ];
		$this->load->view($this->name()."/list", $this->data);
	}

    public function alumno_list() {
		$requestData = $this->input->post();
		$columns = array(
			// datatable column index  => database column name
			0 => 'id',
			1 => 'alumno',
			2 => 'dni',
			3 => 'apoderado_1',
			4 => 'apoderado_2',
			5 => 'fecha_nac',
			6 => 'perfil_alumno',
			7 => 'status',
		);

        $id = $this->session->userdata("userID");

		$sql = "select 
					a.id, 
					concat(a.nombres,' ',a.apellidos) as alumno,
					a.dni, 
					concat(ap1.nombres,' ',ap1.apellidos) as apoderado_1,
					ifnull(concat(ap2.nombres, ' ', ap2.apellidos), '') as apoderado_2,
					a.fecha_nac, 
					a.perfil_archivo as perfil_alumno,
					k1.valor as status 
				from alumno a
				inner join constante k1 on k1.idconstante = ".ID_CONST_REG_STATUS." and k1.codigo = a.status
				inner join apoderado ap1 on ap1.id = a.apoderado_1
				left join apoderado ap2 ON ap2.id = a.apoderado_2
				where 1 = 1";

		$rs = $this->db->query($sql);

		$totalData = $rs->num_rows();
		$totalFiltered = $totalData;

		if ($totalData) {
			$sql .= " AND 1 = 1";

			if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
				$sql.=" AND ( a.id LIKE '".$requestData['search']['value']."%' ";
                $sql.=" OR concat(a.nombres,' ',a.apellidos) LIKE '%".$requestData['search']['value']."%'";
                $sql.=" OR a.fecha_nac LIKE '".$requestData['search']['value']."%'";
                $sql.=" OR ifnull(concat(ap2.nombres, ' ', ap2.apellidos), '') LIKE '%".$requestData['search']['value']."%'";
				$sql.=" OR concat(ap1.nombres,' ',ap1.apellidos) LIKE '%".$requestData['search']['value']."%') ";
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

    public function alumno_create() {
		$data = [];
		if ($id = $this->input->post("id"))
			$this->data = array_merge($data, gw("alumno", ["id" => $id ])->row_array());
		
		$this->data["apoderados"] = gw("apoderado", ["status" => RECORD_STATUS_ACTIVE ])->result_array(); 	
		
		$this->load->view($this->name() . "/create", $this->data);
	}

    public function alumno_save() {
		$ret["success"] = false;

        date_default_timezone_set('America/Lima');

		$id = $this->input->post("id");
		$nombres = $this->input->post("nombres");
		$apellidos = $this->input->post("apellidos");
		$fecha_nac = $this->input->post("fecha_nac");
		$dni = $this->input->post("dni");
		$apoderado_1 = $this->input->post("apoderado_1");
		$apoderado_2 = $this->input->post("apoderado_2");
		$observacion = $this->input->post("observacion");
		$status = $this->input->post("status");
        $tm = date('Y-m-d H:i:s', time());

		if ($file = uploadFile("perfil_archivo", $id, UPLOAD_PATH_DOCUMENTS, ["pdf"])) {
			$__files = $file;
			$this->db->trans_start();
			$perfil["perfil_archivo"] = $__files;
			$this->Constant_model->updateData("alumno", $perfil, $id);
			$this->db->trans_complete();
			$ret["success"] = true;
		}

        $data = [
            "nombres"			        => $nombres,
            "apellidos"			        => $apellidos,
            "fecha_nac"			    	=> $fecha_nac,
            "dni"			   	 		=> $dni,
            "apoderado_1"			    => $apoderado_1,
            "apoderado_2"			    => $apoderado_2,
            "created_user_id"			=> $this->session->userdata("userID"),
            "created_datetime"			=> $tm,
            "status"			        => $status,
        ];

		try {

			$this->db->trans_start();

			if ($id > 0) {
					
                $data["updated_user_id"] = $this->session->userdata("userID");
                $data["updated_datetime"] = $tm;

				$this->Constant_model->updateData("alumno", $data, $id);

            } else {
				$data["perfil_archivo"] = $__files;
				#	die(var_dump($data["perfil_archivo"]));
				$alumno_id = $this->Constant_model->insertDataReturnLastId("alumno", $data);

            }

			$this->db->trans_complete();
			$ret["success"] = true;

		} catch (Exception $ex) {

			$ret["message"] = $ex->getMessage();
		}

		header('Content-Type: application/json');
		echo json_encode($ret);
	}

    public function alumno_delete() {
		$ret["success"] = false;
		$id = $this->input->post("id");
		try {
			if (!($record  = $this->Constant_model->getSingleOneColumn("alumno", "id", $id)))
				throw new Exception("Registro no encontrado");
			$this->Constant_model->updateData("alumno", ["status" => 0, "deleted_datetime" => date('Y-m-d H:i:s', time()) ], $id);
			$ret["success"] = true;
		} catch (Exception $ex) {
			$ret["message"] = $ex->getMessage();
		}
		header('Content-Type: application/json');
		echo json_encode($ret);
	}
}
