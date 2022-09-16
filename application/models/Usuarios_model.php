<?php 

class Usuarios_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->db_proyecto = $this->load->database('proyecto', TRUE);
	}

	function verificar_login($username, $clave)
	{
		$query = $this->db_proyecto->query("select * 
			                                 FROM usuarios 
			                                WHERE username = '".$username ."' 
			                                  and clave = '".$clave."'"
											);	
		return $query->result();
	}
}
?>