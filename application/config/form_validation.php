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
			  'rules' => 'trim|required'),
		)
);
?>