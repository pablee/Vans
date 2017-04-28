<?php
session_start();
include "../clases/database.php";
include "../clases/articulos.php";

$guardar="'guardar'";
$consultar="'consultar'";
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
	}
	
if($barra!=""&&$barra!="consultar"&&$barra!="guardar")
	{
	$_SESSION["barra"][$_SESSION["i"]]=$barra;
	$_SESSION["i"]+="1";			
	}

$encabezados = array("Linea", "Modelo", "Codigo", "Temporada", "Medida", "Barra");
	
//Tabla articulos	
echo'	
	<div class="table-responsive">          
	  <table id="articulos" class="table">
		<thead>
			<tr>			
	';		
		foreach($encabezados as $encabezado)
			{
			echo "<th>".$encabezado."</th>";	
			}

		if($barra=="guardar")
			{
			echo'<th> Cantidad </th>';
			}
	
echo'	  	</tr>
		</thead>
		
		<tbody>
	';
					
//Genera los listados 	
if($barra=="guardar")
	{	
	$codigos=$_SESSION["barra"];
	$articulo->guardarArticulo($codigos);
	}
	else{
		//Consulta en la base el articulo ingresado		
		$i=$_SESSION["i"]-"1";
		
		//Orden menor a mayor:
		//foreach($_SESSION["barra"] as $codigo_barra)
		
		//Orden mayor a menor:
		foreach(array_reverse($_SESSION["barra"]) as $codigo_barra)		
			{
			if($codigo_barra!="")
				{
				$articulo->consultarArticulo($codigo_barra, $i);		
				}	
			$i--;	
			}		
		}
	
echo'		</tr>
		</tbody>
	  </table>
	  
	  <button type="button" class="btn btn-info" onclick="ingresarBarras('.$guardar.')"> Guardar </button>	
	</div>
	';
	
	
	
?>