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
	function verificarusuario_ckeck($tipo)
	{
		if($tipo == 1 || $tipo == 2)
		{
			return true;
		}
		else
		{
			$this->form_validation->set_message('verificarusuario_ckeck', 'El valor del campo {field} no es correcto');
			return false;
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
						$respuesta = $this->registrarusuario($data);
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
	

	function registrarusuario($data)
	{
		$nrodocumento = trim($data['nrodocumento']);
		$nombres           = trim(strtoupper($data['nombres']));
		$primer_apellido   = trim(strtoupper($data['primer_apellido']));
		$segundo_apellido  = trim(strtoupper($data['segundo_apellido']));
		$tipo_usuario      = trim($data['tipo_usuario']);
		$clave 			   = trim($data['clave']);


		$datap = array(
			'numero_doc'      => $nrodocumento,
			'nombres'         => $nombres,
			'primer_apellido' => $primer_apellido,
			'segundo_apellido'=> $segundo_apellido,
			'estado'          => 'AC',
		);
		$id_persona = $this->usuarios_model->guardarPersona($datap);

		//alvaro diego.daza
		$nombres_user = str_replace(" ","",$nombres);
		$apellido_user = str_replace(" ","",$primer_apellido);		
		$username = $nombres_user.".".$apellido_user;
		$clavemd5 = md5($clave);
		
		$datau = array(
			'id_persona'    => $id_persona,
			'tipo_usuario'  => $tipo_usuario,
			'username' 		=> $username,
			'clave'         => $clavemd5,
			'estado'        => 'AC',
		);
		$id_usuario = $this->usuarios_model->guardarUsuario($datau);



		$respuesta = array(
			'error' 	=> false,
			'mensaje' 	=> "GUARDADO CORRECTAMENTE",
			'id_persona'		=> $id_persona,
			'id_usuario' => $id_usuario			
		);
		return $respuesta;
	}


	function getlistausuariosId_get()
	{		
		try  //MANEJO DE EXCEPCIONES
		{
			/*$received_Token = $this->input->request_headers('Authorization');//  recuperamos el token
			if(array_key_exists('Authorization', $received_Token)) //VERIFICAMOS EL PARAMETRO DE AUTHORIZATION
			{*/
				/*$jwtData = $this->objOfJwt->DecodeToken($received_Token['Authorization']);
				$iduser  = $jwtData['idusuario'];*/

				$idUsuario = $this->uri->segment(4);
				
				if($idUsuario > 0)
				{
					$data = $this->usuarios_model->getUsuariosId($idUsuario);
					//echo json_encode($data);		
					$respuesta = array(
										'error' 	=> false,
										'mensaje' 	=> "DATOS OBTENIDOS",
										'data'		=> $data,										
								);
					$this->response($respuesta, REST_Controller::HTTP_OK);	
				}
				else
				{
					$respuesta = array(
										'error' 	=> false,
										'mensaje' 	=> "DEBE ENVIAR LOS PARAMETROS CORRECTOS",										
								);
					$this->response($respuesta, REST_Controller::HTTP_NOT_FOUND);	
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
									'mensaje' 	=> "ACCESO DENEGADO",
									"message"   => $e->getMessage()								
							);
			$this->response($respuesta, REST_Controller::HTTP_NOT_FOUND);		
		}
	}

	function modificar_post()
	{
		try  //MANEJO DE EXCEPCIONES
		{
			$received_Token = $this->input->request_headers('Authorization');//  recuperamos el token
			if(array_key_exists('Authorization', $received_Token)) //VERIFICAMOS EL PARAMETRO DE AUTHORIZATION
			{
				$jwtData = $this->objOfJwt->DecodeToken($received_Token['Authorization']);
				$iduser  = $jwtData['idusuario'];
				$iduser  = 1;				
				//Área de trabajo
				
				$data = $this->post();
				if(!(array_key_exists('nrodocumento',$data)
					&& array_key_exists('nombres',$data)
					&& array_key_exists('primer_apellido',$data)
					&& array_key_exists('segundo_apellido',$data)					
					&& array_key_exists('idpersona',$data)))
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

					if($this->form_validation->run('usuarios_modificar_post'))
					{
						$respuesta = $this->modificarpersona($data);
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
	function modificarpersona($data)
	{
		$id_persona = trim($data['idpersona']);
		if($this->usuarios_model->getUsuariosId($id_persona))
		{
			$nrodocumento = trim($data['nrodocumento']);
			$nombres           = trim(strtoupper($data['nombres']));
			$primer_apellido   = trim(strtoupper($data['primer_apellido']));
			$segundo_apellido  = trim(strtoupper($data['segundo_apellido']));


			$datap = array(
			'numero_doc'      => $nrodocumento,
			'nombres'         => $nombres,
			'primer_apellido' => $primer_apellido,
			'segundo_apellido'=> $segundo_apellido,
			);
			$id_persona_update = $this->usuarios_model->updatePersona($id_persona,$datap);
			
			$respuesta = array(
			'error' 	=> false,
			'mensaje' 	=> "DATOS ACTUALIZADOS CORRECTAMENTE"
			);
		}
		else
		{
			$respuesta = array(
			'error' 	=> true,
			'mensaje' 	=> "Error, el id de persona no ese encuentra registrado"			
			);		
		}
		return $respuesta;
	}

	function cambiarClave_post()
	{

		try  //MANEJO DE EXCEPCIONES
		{
			$received_Token = $this->input->request_headers('Authorization');//  recuperamos el token
			if(array_key_exists('Authorization', $received_Token)) //VERIFICAMOS EL PARAMETRO DE AUTHORIZATION
			{
				$jwtData = $this->objOfJwt->DecodeToken($received_Token['Authorization']);
				$iduser  = $jwtData['idusuario'];


				$iduser  = 1;				
				//Área de trabajo
				
				$data = $this->post();
				if(!(array_key_exists('claveactual',$data)
					&& array_key_exists('clavenueva',$data)
					&& array_key_exists('confirmacion',$data)))
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

					if($this->form_validation->run('cambiarclave_post'))
					{
						$respuesta = $this->actulizarclaveusuario($iduser,$data);
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

	function actulizarclaveusuario($iduser,$data)
	{
		$claveactual = md5(trim($data['claveactual']));
		$clavenueva = md5(trim($data['clavenueva']));
		$confirmacion = md5(trim($data['confirmacion']));

		if($clavenueva == $confirmacion)
		{
			if($claveactual != $clavenueva)
			{
				if($this->usuarios_model->getVerificacionClaveUsuario($iduser,$claveactual))
				{
					$datau = array(
						'clave' => $clavenueva,						
					);

					$id_usuario = $this->usuarios_model->updateUsuario($iduser,$datau);

					$respuesta = array(
						'error' 	=> false,
						'mensaje' 	=> "CLAVE ACTUALIZADA CORRECTAMENTE, INICIE SESSION CON LAS NUEVAS CREDENCIALES"
					);		
				}
				else
				{
					$respuesta = array(
					'error' 	=> true,
					'mensaje' 	=> "Error, La contrasenha actual no es correcta"
					);	
				}
			}
			else
			{
				$respuesta = array(
				'error' 	=> true,
				'mensaje' 	=> "Error, La nueva contrasenha no debe ser igual a la actual"
				);	
			}
		}
		else
		{
			$respuesta = array(
			'error' 	=> true,
			'mensaje' 	=> "Error, No coinciden la nueva contrasenha con la confirmacion"
			);		
		}
		return $respuesta;

	}

}
?>