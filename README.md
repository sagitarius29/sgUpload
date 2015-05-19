# sgUpload

Descripción
=======
Clase para subir archivos mediante php

Uso Basico
===========
Para usar la subida de archivos es necesario un formulario basico con seleccion de ficheros.


```html
<form enctype="multipart/form-data" action="" method="POST">
    <!-- MAX_FILE_SIZE debe preceder el campo de entrada de archivo -->
    <input type="hidden" name="MAX_FILE_SIZE" value="80000" />
    <!-- El nombre del elemento de entrada determina el nombre en el array $_FILES -->
    Enviar este archivo: <input name="file" type="file" />
    <input type="submit" name="send" value="Send File" />
</form>
```

Script al momento de recibir el archivo
```php
	//Hacemos la llamada a la librería
	require_once('../src/sgUpload.php');

	try {
		//Iniciamos la subida indicando el array del archivo
		$upload = new sgUpload($_FILES['file']);

		//Indicamos la carpeta a donde ira el archivo
		$upload->config->dir = './uploads/';

		//movemos el archivo nos devolvera la nueva ruta
		$ruta = $upload->move_file('probando');

		echo $ruta;
	} catch (Exception $e) {
		//En caso de error imprimimos
		print_r($e->getMessage());
	}
```



Dudas y Consultas
====================

Para cualquier duda, consulta o sugerencia envie un mensaje a ronnie.adolfo[at]gmail.com