<?php
/**
* Clase para subir archivos sgUpload v0.1.0
* -------------------------------------------------
* @author: Adolfo Cuadros
* @version: 0.1.0
* @license: MIT
* Github: github.com/sagitarius29/sgUpload
* email: ronnie.adolfo@gmail.com
* Año: 2015
* web: www.adolfocuadros.com
*/
class sgUpload {
	
	private $file;
	private $data;
	private $multiple =  false;

	var $config;

	function __construct($file) {
		//Comprobaciones de archivo
		//Comprobando archivo válido
		if (!is_array($file)) {
			throw new Exception("El archivo no es válido.");
		}

		//Opciones como objeto
		$this->set_options_default();

		//Pasando file
		$this->file =& $file;

		//Añadiendo informacion de a data
		$this->set_info_data();

		//Comprobaciones
		$this->general_check();
	}

	private function set_options_default()
	{
		$this->config = new stdClass();
		
		//Opciones por defecto
		$this->config->max_size 		= 8*1024*3; //3mb

		$this->config->mimetypes_accept = array(
			'application/pdf'
			);
		$this->config->dir 				= realpath('.');
		$this->config->ds 				= DIRECTORY_SEPARATOR;
	}

	private function set_info_data()
	{
		$this->data = new stdClass();
		
		//total de archivos
		$this->data->total = ($this->multiple == true) ? count($this->file) : 1 ;

		if($this->data->total != 1)
		{
			for ($i=0; $i < $this->data->total; $i++) { 
				$this->data->mimetype[$i] 	= $this->file[$i]['type'];
				$this->data->size[$i] 		= $this->file[$i]['type'];
				$this->data->extension[$i] 	= pathinfo($this->file[$i]['name'], PATHINFO_EXTENSION);
			}
		}
		else
		{
			$this->data->mimetype 	= $this->file['type'];
			$this->data->size 		= $this->file['size'];
			$this->data->extension 	= pathinfo($this->file['name'], PATHINFO_EXTENSION);
		}
		
	}

	//Checks

	private function general_check()
	{
		//Comprobando si el archivo se subió correctamente
		if ($this->file['error'] != 0) {
			throw new Exception("Un error ocurrió al momento de cargar el archivo :");
		}

		//Chekando si es multiple
		$this->check_multiple();
		//Check tipo de archivo
		$this->check_mimetype();
	}

	private function check_multiple()
	{
		if (isset($this->file[0])) {
			$this->multiple = true;
		}
	}

	private function check_mimetype()
	{
		if ($this->multiple == false)
		{
			if (!in_array($this->file['type'], $this->config->mimetypes_accept)) {
				$this->delete_temp();
				throw new Exception("Este tipo de archivo no es permitido");
			}
		}
		else
		{
			for ($i=0; $i < $this->data->total; $i++)
			{
				if (!in_array($this->file[$i]['type'], $this->config->mimetypes_accept)) {
					$this->delete_temp();
					throw new Exception("Este tipo de archivo no es permitido " . $this->file[$i]['name']);
				}
			}
		}
	}

	//Eliminando
	private function delete_temp()
	{
		if ($this->multiple == false)
		{
			if (file_exists($this->file['tmp_name']))
			{
				if(!unlink($this->file['tmp_name']))
				{
					throw new Exception("El archivo temporal de ".$this->file['name'].' no pudo ser eliminado.');
				}
			}
		}
		else
		{
			for ($i=0; $i < $this->data->total; $i++)
			{ 
				if (file_exists($this->file[$i]['tmp_name'])) {
					if(!unlink($this->file[$i]['tmp_name']))
					{
						throw new Exception("El archivo temporal de ".$this->file[$i]['name'].' no pudo ser eliminado.');
					}
				}
			}
		}
	}
	//Moviendo archivo

	public function move_file($new_name, $index = false)
	{
		if($index == false)
		{
			if (move_uploaded_file($this->file['tmp_name'],$this->config->dir . $new_name . '.' . $this->data->extension)) {
				return $this->config->dir . $new_name . '.' . $this->data->extension;
			}
			else
			{
				throw new Exception("No es posible mover archivo temporal, no existe o no hay permisos.");
				
			}
		}
	}

	//Metodos publicos

	/*public function set_directory($dir)
	{
		$this->realpath($dir);
	}*/

	public function get_data()
	{
		return $this->data;
	}

}
?>