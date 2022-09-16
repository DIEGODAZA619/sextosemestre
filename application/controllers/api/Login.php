<?php
require APPPATH . 'libraries/REST_Controller.php';

class Login extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();		
	}

	public function index_post()
	{
		
		$data = $this->post();
		if (array_key_exists('username', $data) && array_key_exists('clave', $data))
		{
			$username = $this->post("username");
			$clave    = $this->post("clave");
			$respuesta = array(
						'error' 	=> false,
						'mensaje' 	=> "BIENVENIDO AL SISTEMA",
						'username' 	=> $username,
						'clave'		=> $clave,
						'data'		=> $data
			);
			$this->response($respuesta, REST_Controller::HTTP_OK);	
		}
		else
		{
			$respuesta = array(
								'error' => true,
								'mensaje' => "Debe introducir los parámetros correctos"
								);
			$this->response($respuesta, REST_Controller::HTTP_BAD_REQUEST);
		}
		

	}








}




?>