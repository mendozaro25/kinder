<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auxiliares extends MY_Controller {
	private $data;
	public function __construct()
	{
		parent::__construct();
		$this->data["page_title"] = "Auxiliares";
	}

	public function index()
	{
		redirect(base_url());
	}

	public function auxiliar() {
        $this->data["uri"] = [
            "title"         => "Auxiliares",
            "list"          => base_url().$this->name()."/auxiliar_list",
            "create"        => base_url().$this->name()."/auxiliar_create",
            "save"          => base_url().$this->name()."/auxiliar_save",
            "remove"        => base_url().$this->name()."/auxiliar_delete",
        ];
		$this->load->view($this->name()."/list", $this->data);
	}

    public function auxiliar_list() {
		$requestData = $this->input->post();
		$columns = array(
			// datatable column index  => database column name
			0 => 'id',
			1 => 'apoderado',
			2 => 'dni',
			3 => 'fecha_nac',
			4 => 'email',
			5 => 'nivel_educativo',
			6 => 'experiencia',
			7 => 'status',
		);

        $id = $this->session->userdata("userID");

		$sql = "select 
					a.id, 
					concat(a.nombres,' ',a.apellidos) as auxiliar,
					a.dni, 
					a.fecha_nac,
					a.email,
					k2.valor as nivel_educativo,
					a.experiencia,
					k1.valor as status
				from auxiliar a
				inner join constante k1 on k1.idconstante = ".ID_CONST_REG_STATUS." and k1.codigo = a.status
				inner join constante k2 on k2.idconstante = ".ID_CONST_REG_NIVEDUC." and k2.codigo = a.nivel_educativo
				where 1 = 1";

		$rs = $this->db->query($sql);

		$totalData = $rs->num_rows();
		$totalFiltered = $totalData;

		if ($totalData) {
			$sql .= " AND 1 = 1";

			if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
				$sql.=" AND ( a.id LIKE '".$requestData['search']['value']."%' ";
                $sql.=" OR concat(a.nombres,' ',a.apellidos) LIKE '".$requestData['search']['value']."%'";
                $sql.=" OR a.dni LIKE '".$requestData['search']['value']."%'";
				$sql.=" OR a.email LIKE '".$requestData['search']['value']."%') ";
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

    public function auxiliar_create() {
		$data = [];
		if ($id = $this->input->post("id"))
			$this->data = array_merge($data, gw("auxiliar", ["id" => $id ])->row_array());
		
		$this->load->view($this->name() . "/create", $this->data);
	}

    public function auxiliar_save() {
		$ret["success"] = false;

        date_default_timezone_set('America/Lima');

		$id = $this->input->post("id");
		$nombres = $this->input->post("nombres");
		$apellidos = $this->input->post("apellidos");
		$fecha_nac = $this->input->post("fecha_nac");
		$dni = $this->input->post("dni");
		$nivel_educativo = $this->input->post("nivel_educativo");
		$experiencia = $this->input->post("experiencia");
		$email = $this->input->post("email");
		$status = $this->input->post("status");
        $tm = date('Y-m-d H:i:s', time());		

        $data = [
            "nombres"			        => $nombres,
            "apellidos"			        => $apellidos,
            "fecha_nac"			    	=> $fecha_nac,
            "dni"			   	 		=> $dni,
            "nivel_educativo"			=> $nivel_educativo,
            "experiencia"			    => $experiencia,
            "email"			    		=> $email,
            "created_user_id"			=> $this->session->userdata("userID"),
            "created_datetime"			=> $tm,
            "status"			        => $status,
        ];

		try {

			$this->db->trans_start();

			if ($id > 0) {
					
                $data["updated_user_id"] = $this->session->userdata("userID");
                $data["updated_datetime"] = $tm;

				$this->Constant_model->updateData("auxiliar", $data, $id);

            } else {

				$obra_id = $this->Constant_model->insertDataReturnLastId("auxiliar", $data);

            }

			$this->db->trans_complete();
			$ret["success"] = true;

		} catch (Exception $ex) {

			$ret["message"] = $ex->getMessage();
		}

		header('Content-Type: application/json');
		echo json_encode($ret);
	}

    public function auxiliar_delete() {
		$ret["success"] = false;
		$id = $this->input->post("id");
		try {
			if (!($record  = $this->Constant_model->getSingleOneColumn("auxiliar", "id", $id)))
				throw new Exception("Registro no encontrado");
			$this->Constant_model->updateData("auxiliar", ["status" => 0, "deleted_datetime" => date('Y-m-d H:i:s', time()) ], $id);
			$ret["success"] = true;
		} catch (Exception $ex) {
			$ret["message"] = $ex->getMessage();
		}
		header('Content-Type: application/json');
		echo json_encode($ret);
	}
}
