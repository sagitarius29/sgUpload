<?php
class sgUpload {
	var $file;
	private $data;

	//Opciones por default
	/*var $options = array(
		'max_size'		=>	8*1024*3,
		'mimes_accept'		=>	array(
				'application/pdf'
			),
		'folder'	=>	'./'
		);*/
	var $options;

	function __construct($file) {
		//Opciones como objeto
		$this->options = new stdClass();
		
		//Opciones por defecto
		$this->options->max_size = 8*1024*3; //3mb

		$this->options->mimes_accept = array(
			'application/pdf'
			);

		

		//Comprobaciones de archivo
		//Comprobando archivo válido
		if (!is_array($file)) {
			throw new Exception("El archivo no es válido.");
		}

		$this->file = $file;
	}

	private function seed_data()
	{
		$this->data = new stdClass();
		//Datos del archivo
//		$this->
	}

	private function check()
	{
		//Comprobando si el archivo es correcto...

	}
}
?>