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

	function getUsuarios()
	{
		$query = $this->db_proyecto->query("select *
			                                  from personas p, usuarios u
			                                 where p.id = u.id_persona"
											);
		return $query->result();
	}
	function getUsuariosId($idUsuario)
	{
		$query = $this->db_proyecto->query("select *
			                                  from personas p, usuarios u
			                                 where p.id = u.id_persona
			                                   and p.id = ".$idUsuario
											);
		return $query->result();
	}

	function guardarPersona($data)
	{
		$this->db_proyecto->insert('personas',$data);
		return $this->db_proyecto->insert_id();
	}

	function guardarUsuario($data)
	{
		$this->db_proyecto->insert('usuarios',$data);
		return $this->db_proyecto->insert_id();
	}
	function updatePersona($id_persona,$datap)
	{
		$this->db_proyecto->where('id', $id_persona);
		return $this->db_proyecto->update('personas', $datap);
	}
}
?>