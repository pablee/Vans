<?php
session_start();
include "../clases/database.php";

//antes de subir el archivo se debe borrar el \r
$target_path = "../../../../mysql/data/vans/";
$target_path = $target_path . basename($_FILES['archivo']['name']); 

if(move_uploaded_file($_FILES['archivo']['tmp_name'], $target_path)) 
	{ 
	echo "El archivo ". basename($_FILES['archivo']['name']). " ha sido subido<br>";
	} 
	else
		{
		echo "Ha ocurrido un error, trate de nuevo!<br>";
		} 
		
$db = new database();
$db->conectar();

$borrar_tabla="TRUNCATE TABLE productos;";

$resultado = mysqli_query($db->conexion, $borrar_tabla) 
or die ("No se pudo cargar el archivo en la base<br>");

$consulta = "LOAD DATA INFILE 'vans/".$_FILES['archivo']['name']."' 
			INTO TABLE productos
			FIELDS TERMINATED BY ','
			LINES TERMINATED BY '\n';";

$resultado = mysqli_query($db->conexion, $consulta) 
or die ("No se pudo cargar el archivo en la base<br>");

header("location: ../home.php");	

?>