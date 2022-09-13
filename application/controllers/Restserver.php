<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Restserver extends REST_Controller
{
	public function index()
	{
		//echo "HOLA MUNDO";
		$this->load->view('welcome_message');
	}
	/*
	TIPO DE PETICIONES
	GET  nombreMetodo_get  =  SON PARA SOLICITAR INFORMACION
	POST nombreMetodo_post =  SON PARA MANDAR UN REQUEST O CONJUNTO DE DATOS PARA GUARDAR
	PUT  nombreMetodo_put  =  SE MANDA PARAMETROS POR LA URL Y MEDIANTE REQUEST O CONJUNTO DE DATOS PARA ACTUALIZARLOS	
	IMPORTANTE 	

	*/

	function saludo_get()
	{
		/*todas las respuestas seran de tipo ARRAY*/
		$data = array('HOLA','DATOS','CodeIgniter');
		$data2 = array(
						'uno' => 1,
						'dos' => 2,
						'tres' => 3,
						'otros' => $data
					);
		$respuesta  = array(
						'error' =>false,
						'mensaje' => 'Correcto, información',
						'datos' => $data2
					  );
		$this->response($respuesta, REST_Controller::HTTP_OK);
	}

	function guardar_post()
	{
		$data = $this->post();  //recuperar todos los valores enviados por post

		$nombre = $data['nombre']; // recuperar individualmente cada campo
		
		//armando variable array de respuesta
		$respuesta  = array(
						'error' =>false,
						'mensaje' => 'Correcto, información',
						'nombre'  => $nombre,
						'datos' => $data
					  );
		//devolvemos respuesta
		$this->response($respuesta, REST_Controller::HTTP_OK);
	}

	function datos_get()
	{

		//http://localhost/sextosemestre/index.php/Restserver/datos/DIEGO/DAZA 
		$nombre = $this->uri->segment(3);
		$apellido = $this->uri->segment(4);
		$edad = $this->uri->segment(5);
		$respuesta  = array(
						'error' =>false,
						'mensaje' => 'Correcto, información',
						'nombre'  => $nombre,
						'apellido'  => $apellido,
						'edad'  => $edad,
					  );
		//devolvemos respuesta
		$this->response($respuesta, REST_Controller::HTTP_OK);
	}




}


?>
