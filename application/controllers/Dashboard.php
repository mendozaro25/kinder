<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->data["page_title"] = "Tablero";
		
		$this->data["url_alumnos"] = "alumnos/alumno";
		$this->data["url_reports"] = "reports/report_pago";
		$this->data["url_pagos"] = "pagos/pago";
		$this->data["url_det_pagos"] = "pagos/det_pago?ppID=";
		$this->data["url_sesiones"] = "sesiones/sesion";

		// Alumnos
		$sql_alumno = "select 
							count(a.id) as alumnos
						from alumno a
						where a.status = ".RECORD_STATUS_ACTIVE;
		$data_alumnos = $this->db->query($sql_alumno);
		$alumnos = $data_alumnos->row_array();
		$this->data["alumnos"] = $alumnos;

		// Sesiones
		$sql_sesion = "select 
							count(s.id) as sesiones
						from sesion s
						where s.status = ".RECORD_STATUS_ACTIVE;
		$data_sesion = $this->db->query($sql_sesion);
		$sesion = $data_sesion->row_array();
		$this->data["sesion"] = $sesion;

		// Pagos Pendientes
		$sql_pendientes = "select 
								count(ppt.id) as pendientes
							from prog_pago_det ppt
							where ppt.estado_id = '".VALUE_PNT."'";
		$data_pendientes = $this->db->query($sql_pendientes);
		$pendientes = $data_pendientes->row_array();
		$this->data["pendientes"] = $pendientes;

		// Monto Pago Aceptado
		$sql_monto = "select 
								coalesce(sum(ppt.monto), 0) as monto_total
							from prog_pago_det ppt
							where ppt.estado_id = '".VALUE_PAG."'";
		$data_monto = $this->db->query($sql_monto);
		$monto = $data_monto->row_array();
		$this->data["monto"] = $monto;

		// Pagos Aceptados
		$sql_pg_aceptados = "select
								pp.id as pago_prog_id,
								concat(ap.nombres,' ',ap.apellidos) as apoderado,
								ap.dni,
								ppt.fecha_pago,
								format(ppt.monto, 2) as monto,
								k2.valor as estado
							from prog_pago_det ppt 
							inner join apoderado ap on ap.id = ppt.apoderado_id
							inner join progr_pago pp on pp.id = ppt.progr_pago_id
							inner join constante k2 on k2.idconstante = ".ID_CONST_REG_ESTADOPAG." and k2.codigo = ppt.estado_id
							order by ppt.fecha_pago asc
							limit 10";
		$data_pg_aceptados = $this->db->query($sql_pg_aceptados);
		$pg_aceptados = $data_pg_aceptados->result_array();
		#die(var_dump($pg_aceptados));
		$this->data["pg_aceptados"] = $pg_aceptados;

		// Alumnos Cumpleañeros
		$sql_alum_cum = "select 
							a.* 
						from alumno a
						where month(a.fecha_nac) = month(current_date())
						order by a.fecha_nac asc";
		$data_alum_cum = $this->db->query($sql_alum_cum);
		$alum_cum = $data_alum_cum->result_array();
		$this->data["alum_cum"] = $alum_cum;

		// Alumnos Recientes
		$sql_alum_rec = "select 
							a.*
						from alumno a
						order by a.id desc
						limit 6";
		$data_alum_rec = $this->db->query($sql_alum_rec);
		$alum_rec = $data_alum_rec->result_array();
		$this->data["alum_rec"] = $alum_rec;

		$meses = [
			1 => 'ENERO',
			2 => 'FEBRERO',
			3 => 'MARZO',
			4 => 'ABRIL',
			5 => 'MAYO',
			6 => 'JUNIO',
			7 => 'JULIO',
			8 => 'AGOSTO',
			9 => 'SEPTIEMBRE',
			10 => 'OCTUBRE',
			11 => 'NOVIEMBRE',
			12 => 'DICIEMBRE'
		];
		
		$mes_actual = date('n');
		$nombre_mes = $meses[$mes_actual];
		$this->data["mes_actual"] = $nombre_mes;

		$this->load->view('dashboard', $this->data);
	}
}
