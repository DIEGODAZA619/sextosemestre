<?php
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/CreatorJwt.php';

class Login extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->objOfJwt = new CreatorJwt();

		$this->load->model('usuarios_model');	

	}

	public function index_post()
	{
		
		$data = $this->post();
		if (array_key_exists('username', $data) && array_key_exists('clave', $data))
		{
			$username = $this->post("username");
			$clave    = md5($this->post("clave"));
			$login = $this->usuarios_model->verificar_login($username,$clave);
			if($login)
			{
				if($login[0]->estado == 'AC')
				{
					$date = new DateTime();
					$tokenData['idusuario'] = $login[0]->id;
					$tokenData['fecha']     = Date('Y-m-d h:i:s');
					$tokenData['iat']		= $date->getTimestamp();
					$tokenData['exp']		= $date->getTimestamp() + $this->config->item('jwt_token_expire');

					$jwtToken				= $this->objOfJwt->GenerateToken($tokenData); // GENERA EL TOKEM

					$respuesta = array(
							'error' 	=> false,
							'mensaje' 	=> "BIENVENIDO AL SISTEMA",
							'username' 	=> $username,
							'clave'		=> $clave,
							'data'		=> $data,
							'login'		=> $login,
							'token'		=> $jwtToken
					);
					$this->response($respuesta, REST_Controller::HTTP_OK);	
				}
				else
				{
					$respuesta = array(
								'error' => true,
								'mensaje' => "El usuario no se encuentra habilitado"
								);
				$this->response($respuesta, REST_Controller::HTTP_OK);
				}
			}
			else
			{
				$respuesta = array(
								'error' => true,
								'mensaje' => "Datos no existentes"
								);
				$this->response($respuesta, REST_Controller::HTTP_OK);
			}
			
		}
		else
		{
			$respuesta = array(
								'error' => true,
								'mensaje' => "Debe introducir los parámetros correctos"
								);
			$this->response($respuesta, REST_Controller::HTTP_OK);
		}
		

	}








}




?>