<?php
session_start();
include_once "../clases/database.php";
include_once "../clases/articulos.php";

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

if($barra!=""&&$barra!="guardar")
	{
	$_SESSION["barra"][$_SESSION["i"]]=$barra;
	$_SESSION["i"]+=1;		
	}
	
//Tabla articulos	
echo'	
	<div class="table-responsive">          
	  <table id="articulos" class="table">
		<thead>
		  <tr>
			<th> Linea </th>
			<th> Modelo </th>
			<th> Codigo </th>
			<th> Medida </th>
			<th> Barra </th>
	';		
	
	if($barra=="guardar")
		{
		echo'<th> Cantidad </th>';
		}
	
echo'	  </tr>
		</thead>
		
		<tbody>
	';
					
//Genera los listados 	
if($barra=="guardar")
	{	
	$codigos=$_SESSION["barra"];
	$articulo->guardarArticulo($codigos);
	session_unset();
	}
	else{
		//Consulta en la base el articulo ingresado
		$i=0;
		foreach($_SESSION["barra"] as $codigo_barra)
			{
			if($codigo_barra!="")
				{
				$articulo->consultarArticulo($codigo_barra);
				echo'						
						<td> 
							<a onclick="sacarArticulo('.$i.'); restar()">
								<span class="glyphicon glyphicon-remove"></span> 
							</a>
						</td>
					</tr>	
					';			
				}	
			$i++;	
			}		
		}
	
echo'	
		</tbody>
	  </table>
	  
	  <button type="button" class="btn btn-info" onclick="ingresarBarras('.$guardar.')"> Guardar </button>	
	</div>
	';
	
	
	
?>