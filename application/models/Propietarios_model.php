<?php 

class Propietarios_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->db_proyecto = $this->load->database('proyecto', TRUE);
	}

	
	function getPropietarios()
	{
		$query = $this->db_proyecto->query("select * 
			                                  from propietarios
			                                 where estado = 'AC'"
											);
		return $query->result();
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
	function getVerificacionClaveUsuario($idUsuario, $clave)
	{
		$query = $this->db_proyecto->query("select *
			                                  from usuarios u
			                                 where u.id = ".$idUsuario."
			                                   and u.clave = '".$clave."'");
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
	function updateUsuario($iduser,$datau)
	{
		$this->db_proyecto->where('id', $iduser);
		return $this->db_proyecto->update('usuarios', $datau);
	}
}
?>