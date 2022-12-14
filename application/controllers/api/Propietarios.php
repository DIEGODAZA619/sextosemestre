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

	public function verificarcadena_check($cadena)
	{
		$patron =  "/^[a-zA-Z\sñáéíóúÁÉÍÓÚ]+$/"; //EXPRESION REGULAR
		if(preg_match($patron, $cadena)) //verificamos el texto de la expresion regular con la cadena
		{
			return true;
		}
		else
		{
			$this->form_validation->set_message('verificarcadena_check', 'El campo {field} solo debe contener letras');
			return false;
		}

	}

	function registrar_post()
	{
		try  //MANEJO DE EXCEPCIONES
		{
			$received_Token = $this->input->request_headers('Authorization');//  recuperamos el token
			if(array_key_exists('Authorization', $received_Token)) //VERIFICAMOS EL PARAMETRO DE AUTHORIZATION
			{
				$jwtData = $this->objOfJwt->DecodeToken($received_Token['Authorization']);
				$iduser  = $jwtData['idusuario'];
				//$iduser  = 1;				
				//Área de trabajo
				
				$data = $this->post();
				if(!(array_key_exists('documento',$data)
					&& array_key_exists('nombres',$data)
					&& array_key_exists('telefono',$data)					
					&& array_key_exists('direccion',$data)))
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

					if($this->form_validation->run('propietarios_post'))
					{
						$respuesta = $this->registrarPropietario($data);
						/*$respuesta = array(
										'error' 	=> true,
										'mensaje' 	=> "DATOS CORRECTOS",
										'datos_enviados'	=> $data
						);*/
						/**/					
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
									'mensaje' 	=> "ACCESO DENEGADO EXCEPCION",
									"message"   => $e->getMessage()								
							);
			$this->response($respuesta, REST_Controller::HTTP_NOT_FOUND);		
		}
	}


	function registrarPropietario($data)
	{
		$documento = trim($data['documento']);
		$nombres = trim(strtoupper($data['nombres']));
		$telefono = trim($data['telefono']);
		$direccion = trim(strtoupper($data['direccion']));

		$data = array(
			'documento' => $documento,
			'nombres' => $nombres,
			'telefono' => $telefono,
			'direccion' => $direccion,
			'estado'    => 'AC'  
		);

		$idPropietario = $this->propietarios_model->guardarPropietarios($data);
		$respuesta = array(
							'error' 	=> true,
							'mensaje' 	=> "DATOS GUARDADOS CORRECTAMENTE",
							'id_propietario'	=> $idPropietario
			);	

		return $respuesta;
	}
}