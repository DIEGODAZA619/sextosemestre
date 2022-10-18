<?php
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/CreatorJwt.php';

class Propietarios extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->objOfJwt = new CreatorJwt();
		$this->load->model('usuarios_model');
		$this->load->model('propietarios_model');
	}

	function getlistapropietarios_get()
	{		
		try  //MANEJO DE EXCEPCIONES
		{
			/*VERIFICACION TOKEN*/
			$received_Token = $this->input->request_headers('Authorization');//  recuperamos el token
			if(array_key_exists('Authorization', $received_Token)) //VERIFICAMOS EL PARAMETRO DE AUTHORIZATION
			{
				$jwtData = $this->objOfJwt->DecodeToken($received_Token['Authorization']);
				$iduser  = $jwtData['idusuario'];

				/*FIN VERIFICACION TOKEN*/
				
				$data = $this->propietarios_model->getPropietarios();
					
				$respuesta = array(
									'error' 	=> false,
									'mensaje' 	=> "DATOS OBTENIDOS PROPIETARIOS",
									'data'		=> $data,
									'iduser'	=> $iduser,
							);
				$this->response($respuesta, REST_Controller::HTTP_OK);	
			
			/*MENSAJE ERROR TOKEN*/	
			}
			else
			{
				$respuesta = array(
									'error' 	=> true,
									'mensaje' 	=> "ACCESO DENEGADO",								
							);
				$this->response($respuesta, REST_Controller::HTTP_NOT_FOUND);		
			}
			/*FIN MENSAJE ERROR TOKEN*/
		} 
		catch (Exception $e) 
		{
			$respuesta = array(
									'error' 	=> true,
									'mensaje' 	=> "ACCESO DENEGADO",
									"message"   => $e->getMessage()								
							);
			$this->response($respuesta, REST_Controller::HTTP_NOT_FOUND);		
		}
	}
}