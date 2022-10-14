<?php
$config = array(
	'usuarios_post' => array(
		array('field' => 'nrodocumento',
			  'label' => 'nrodocumento',
			  'rules' => 'trim|required|numeric|min_length[3]|max_length[9]'),

		array('field' => 'nombres',
			  'label' => 'nombres',
			  'rules' => 'trim|required|min_length[3]|max_length[20]|callback_verificarcadena_check'),

		array('field' => 'primer_apellido',
			  'label' => 'primer_apellido',
			  'rules' => 'trim|required|min_length[3]|max_length[20]|callback_verificarcadena_check'),

		array('field' => 'segundo_apellido',
			  'label' => 'segundo_apellido',
			  'rules' => 'trim|required|min_length[3]|max_length[20]|callback_verificarcadena_check'),

		array('field' => 'tipo_usuario',
			  'label' => 'tipo_usuario',
			  'rules' => 'trim|required|min_length[1]|max_length[2]|callback_verificarusuario_ckeck'),
		
		array('field' => 'clave',
			  'label' => 'clave',
			  'rules' => 'trim|required|min_length[6]|max_length[20]|alpha_numeric'),
		
	),
	'usuarios_modificar_post'=> array(
		array('field' => 'nrodocumento',
			  'label' => 'nrodocumento',
			  'rules' => 'trim|required|numeric|min_length[3]|max_length[9]'),

		array('field' => 'nombres',
			  'label' => 'nombres',
			  'rules' => 'trim|required|min_length[3]|max_length[20]|callback_verificarcadena_check'),

		array('field' => 'primer_apellido',
			  'label' => 'primer_apellido',
			  'rules' => 'trim|required|min_length[3]|max_length[20]|callback_verificarcadena_check'),

		array('field' => 'segundo_apellido',
			  'label' => 'segundo_apellido',
			  'rules' => 'trim|required|min_length[3]|max_length[20]|callback_verificarcadena_check'),
		
		array('field' => 'idpersona',
			  'label' => 'idpersona',
			  'rules' => 'trim|required|numeric'),
		
	),
	'cambiarclave_post'=> array(
		array('field' => 'claveactual',
			  'label' => 'claveactual',
			  'rules' => 'trim|required|alpha_numeric|min_length[6]|max_length[20]'),

		array('field' => 'clavenueva',
			  'label' => 'clavenueva',
			  'rules' => 'trim|required|alpha_numeric|min_length[6]|max_length[20]'),

		array('field' => 'confirmacion',
			  'label' => 'confirmacion',
			  'rules' => 'trim|required|alpha_numeric|min_length[6]|max_length[20]'),
	)
	
);
?>