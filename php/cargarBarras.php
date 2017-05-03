<?php
session_start();
include "../clases/database.php";
include "../clases/articulos.php";

$articulo = new articulo();

if(isset($_GET["barra"]))
	{
	$barra=$_GET["barra"];	
	}
	else{
		$barra="";
		}
				
//El id se obtiene de la funcion sacarArticulo y pasa la posicion del articulo a borrar del array
if(isset($_GET["id"]))
	{
	$id=$_GET["id"];
	$_SESSION["barra"][$id]="";	
	echo $_SESSION["i"]-$id;
	}
	
if($barra!=""&&$barra!="consultar"&&$barra!="guardar")
	{
	$_SESSION["barra"][$_SESSION["i"]]=$barra;
	$_SESSION["i"]+=1;			
	}
			
//Genera los listados 	
if($barra=="guardar")
	{	
	if($_SESSION["i"]==0)
		{
		echo "ERROR: Debe ingresar al menos un articulo.";	
		}
		else{
			if($barra!="")
				{
				$codigos=$_SESSION["barra"];	
				$articulo->guardarArticulo($codigos);
				}
			}	
	}
	else{
		if($barra!="")
			{
			//Consulta en la base el articulo ingresado	//array_reverse recorre el array a la inversa	
			$i=$_SESSION["i"];
			$articulo->consultarArticulo($barra, $i);	
			}
		}
	

	
	
	
?>