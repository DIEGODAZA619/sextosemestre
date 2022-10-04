<?php
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/CreatorJwt.php';

class Usuarios extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->objOfJwt = new CreatorJwt();
		$this->load->model('usuarios_model');
	}

	function getlistausuarios_get()
	{		
		try  //MANEJO DE EXCEPCIONES
		{
			$received_Token = $this->input->request_headers('Authorization');//  recuperamos el token
			if(array_key_exists('Authorization', $received_Token)) //VERIFICAMOS EL PARAMETRO DE AUTHORIZATION
			{
				$jwtData = $this->objOfJwt->DecodeToken($received_Token['Authorization']);
				$iduser  = $jwtData['idusuario'];

				
				$data = $this->usuarios_model->getUsuarios();
				//echo json_encode($data);		
				$respuesta = array(
									'error' 	=> false,
									'mensaje' 	=> "DATOS OBTENIDOS",
									'data'		=> $data,
									'iduser'	=> $iduser,
							);
				$this->response($respuesta, REST_Controller::HTTP_OK);	
			}
			else
			{
				$respuesta = array(
									'error' 	=> true,
									'mensaje' 	=> "ACCESO DENEGADO",								
							);
				$this->response($respuesta, REST_Controller::HTTP_NOT_FOUND);		
			}
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

	function registrar_post()
	{
		try  //MANEJO DE EXCEPCIONES
		{
			/*$received_Token = $this->input->request_headers('Authorization');//  recuperamos el token
			if(array_key_exists('Authorization', $received_Token)) //VERIFICAMOS EL PARAMETRO DE AUTHORIZATION
			{
				$jwtData = $this->objOfJwt->DecodeToken($received_Token['Authorization']);
				$iduser  = $jwtData['idusuario'];*/
				$iduser  = 1;				
				//Área de trabajo
				
				$data = $this->post();
				if(!(array_key_exists('nrodocumento',$data)
					&& array_key_exists('nombres',$data)
					&& array_key_exists('primer_apellido',$data)
					&& array_key_exists('segundo_apellido',$data)
					&& array_key_exists('tipo_usuario',$data)
					&& array_key_exists('clave',$data)))
				{
					$respuesta = array(
								'error' => true,
								'mensaje' => "Debe introducir los parámetros correctos"
								);
					$this->response($respuesta, REST_Controller::HTTP_BAD_REQUEST);
				}
				else
				{
					//echo json_encode($data);		
					$this->load->library('form_validation');
					$this->form_validation->set_data($data);
					//$this->form_validation->set_rules('nombres','nombres','required'); //aplicando reglas de validacion

					if($this->form_validation->run('usuarios_post'))
					{
						$respuesta = array(
										'error' 	=> false,
										'mensaje' 	=> "DATOS OBTENIDOS",
										'data'		=> $data,
										'iduser'	=> $iduser
									);					
					}
					else
					{
						$respuesta = array(
										'error' 	=> true,
										'mensaje' 	=> "DATOS INCORRECTOS",
										'errores'	=> $this->form_validation->get_errores_arreglo()
						);
														
					}
					$this->response($respuesta, REST_Controller::HTTP_OK);


						
				}
				
			/*}
			else
			{
				$respuesta = array(
									'error' 	=> true,
									'mensaje' 	=> "ACCESO DENEGADO",								
							);
				$this->response($respuesta, REST_Controller::HTTP_NOT_FOUND);		
			}*/
		} 
		catch (Exception $e) 
		{
			$respuesta = array(
									'error' 	=> true,
									'mensaje' 	=> "ACCESO DENEGADO EXCEPCION",
									"message"   => $e->getMessage()								
							);
			$this->response($respuesta, REST_Controller::HTTP_NOT_FOUND);		
		}
	}
	



}
?>