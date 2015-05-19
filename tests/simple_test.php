<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Test Upload</title>
</head>
<body>
	<div>
		<!-- El tipo de codificación de datos, enctype, se DEBE especificar como a continuación -->
		<form enctype="multipart/form-data" action="" method="POST">
		    <!-- MAX_FILE_SIZE debe preceder el campo de entrada de archivo -->
		    <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
		    <!-- El nombre del elemento de entrada determina el nombre en el array $_FILES -->
		    Enviar este archivo: <input name="file" type="file" />
		    <input type="submit" name="send" value="Send File" />
		</form>
	</div>
	<div>
<?php
if(isset($_POST['send']))
{
	require_once('../src/sgUpload.php');

	$upload = new sgUpload($_FILES['file']);
	//$upload->options->max_size = '3';
	//echo $upload->options->max_size;
	print_r($upload->file);
}

?>
	</div>
</body>
</html>