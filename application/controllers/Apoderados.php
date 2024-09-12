<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Apoderados extends MY_Controller {
	private $data;
	public function __construct()
	{
		parent::__construct();
		$this->data["page_title"] = "Apoderados";
	}

	public function index()
	{
		redirect(base_url());
	}

	public function apoderado() {
        $this->data["uri"] = [
            "title"         => "Apoderados",
            "list"          => base_url().$this->name()."/apoderado_list",
            "create"        => base_url().$this->name()."/apoderado_create",
            "save"          => base_url().$this->name()."/apoderado_save",
            "remove"        => base_url().$this->name()."/apoderado_delete",
        ];
		$this->load->view($this->name()."/list", $this->data);
	}

    public function apoderado_list() {
		$requestData = $this->input->post();
		$columns = array(
			// datatable column index  => database column name
			0 => 'id',
			1 => 'apoderado',
			2 => 'dni',
			3 => 'fecha_nac',
			4 => 'email',
			5 => 'telefono_1',
			6 => 'telefono_2',
			7 => 'fono_casa',
			8 => 'direccion',
			9 => 'status',
		);

        $id = $this->session->userdata("userID");

		$sql = "select 
					a.id, 
					concat(a.nombres,' ',a.apellidos) as apoderado,
					a.dni, 
					a.fecha_nac,
					a.email,
					a.telefono_1,
					a.telefono_2,
					a.fono_casa,
					a.direccion,
					k1.valor as status 
				from apoderado a
				inner join constante k1 on k1.idconstante = ".ID_CONST_REG_STATUS." and k1.codigo = a.status
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

    public function apoderado_create() {
		$data = [];
		if ($id = $this->input->post("id"))
			$this->data = array_merge($data, gw("apoderado", ["id" => $id ])->row_array());
		
		$this->load->view($this->name() . "/create", $this->data);
	}

    public function apoderado_save() {
		$ret["success"] = false;

        date_default_timezone_set('America/Lima');

		$id = $this->input->post("id");
		$nombres = $this->input->post("nombres");
		$apellidos = $this->input->post("apellidos");
		$fecha_nac = $this->input->post("fecha_nac");
		$dni = $this->input->post("dni");
		$telefono_1 = $this->input->post("telefono_1");
		$telefono_2 = $this->input->post("telefono_2");
		$fono_casa = $this->input->post("fono_casa");
		$email = $this->input->post("email");
		$direccion = $this->input->post("direccion");
		$status = $this->input->post("status");
        $tm = date('Y-m-d H:i:s', time());		

        $data = [
            "nombres"			        => $nombres,
            "apellidos"			        => $apellidos,
            "fecha_nac"			    	=> $fecha_nac,
            "dni"			   	 		=> $dni,
            "telefono_1"			    => $telefono_1,
            "telefono_2"			    => $telefono_2,
            "fono_casa"			    	=> $fono_casa,
            "email"			    		=> $email,
            "direccion"			    	=> $direccion,
            "created_user_id"			=> $this->session->userdata("userID"),
            "created_datetime"			=> $tm,
            "status"			        => $status,
        ];

		try {

			$this->db->trans_start();

			if ($id > 0) {
					
                $data["updated_user_id"] = $this->session->userdata("userID");
                $data["updated_datetime"] = $tm;

				$this->Constant_model->updateData("apoderado", $data, $id);

            } else {

				$obra_id = $this->Constant_model->insertDataReturnLastId("apoderado", $data);

            }

			$this->db->trans_complete();
			$ret["success"] = true;

		} catch (Exception $ex) {

			$ret["message"] = $ex->getMessage();
		}

		header('Content-Type: application/json');
		echo json_encode($ret);
	}

    public function apoderado_delete() {
		$ret["success"] = false;
		$id = $this->input->post("id");
		try {
			if (!($record  = $this->Constant_model->getSingleOneColumn("apoderado", "id", $id)))
				throw new Exception("Registro no encontrado");
			$this->Constant_model->updateData("apoderado", ["status" => 0, "deleted_datetime" => date('Y-m-d H:i:s', time()) ], $id);
			$ret["success"] = true;
		} catch (Exception $ex) {
			$ret["message"] = $ex->getMessage();
		}
		header('Content-Type: application/json');
		echo json_encode($ret);
	}
}
