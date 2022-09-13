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








}




?>