<?php
session_start();
include "../clases/database.php";
include "../clases/articulos.php";

$guardar="'guardar'";
$consultar="'consultar'";
if(isset($_GET["barra"]))
	{
	$barra=$_GET["barra"];	
	}
	else{
		$barra="";
		}
//el id lo recibe de la funcion sacarArticulo y pasa la posicion del articulo a borrar del array
if(isset($_GET["id"]))
	{
	$id=$_GET["id"];
	$_SESSION["barra"][$id]="";	
	}
	
$db = new database();
$db->conectar();		
	
if($barra!=""&&$barra!="consultar"&&$barra!="guardar")
	{
	$_SESSION["barra"][$_SESSION["i"]]=$barra;
	$_SESSION["i"]+="1";			
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
if($barra=="consultar" || $barra=="guardar")
	{
	if($barra=="guardar")
		{
		//Guarda los articulos en la tabla listado	
		$consulta ="TRUNCATE TABLE listado;";	
		$resultado = mysqli_query($db->conexion, $consulta) 
		or die ("No se pudo mostrar el listado");
	
		foreach($_SESSION["barra"] as $codigo_barra)
			{
			if($codigo_barra!="")
				{		
				$consulta ="INSERT INTO listado (barra) VALUES ($codigo_barra);";				
				$resultado = mysqli_query($db->conexion, $consulta) 
				or die ("No se pudo guardar el codigo de barra en la base.");
				}
			}
		
		//Genera las filas de la tabla articulos
		$consulta ="SELECT P.marca, P.linea, P.modelo, P.codigo, P.DescMedida, L.barra, COUNT(L.barra) as cantidad 
					FROM listado L JOIN productos P ON L.barra = P.barra
					GROUP BY L.barra;";			
		$resultado = mysqli_query($db->conexion, $consulta) 
		or die ("No se pudo mostrar el listado");
		
		while($producto = mysqli_fetch_assoc($resultado))
			{
			echo'	
				  <tr>
					<td> '.$producto["linea"].' </td>
					<td> '.$producto["modelo"].' </td>
					<td> '.$producto["codigo"].' </td>
					<td> '.$producto["DescMedida"].' </td>
					<td> '.$producto["barra"].' </td>					
					<td> '.$producto["cantidad"].' </td>	
				  </tr>
				';	
			}
		
		//Articulos con codigo de barras inexistentes
		$consulta ="SELECT L.barra, COUNT(*) as cantidad 
					FROM listado L 
					WHERE L.barra NOT IN (SELECT P.barra FROM productos P) GROUP BY L.barra;"; 
		$resultado = mysqli_query($db->conexion, $consulta) 
		or die ("No se pudo mostrar el listado");
		while($producto = mysqli_fetch_assoc($resultado))
			{
			echo'	
				<tr>
					<td> No existe </td>
					<td> No existe </td>
					<td> No existe </td>
					<td> No existe </td>
					<td> '.$producto["barra"].' </td>				
					<td> '.$producto["cantidad"].' </td>			
				</tr>
				';			
			}
			
		$db->close();		
		}
		else{
			//Consulta informacion de articulos
			$i=0;
			foreach($_SESSION["barra"] as $codigo_barra)
				{
				if($codigo_barra!="")
					{	
					$consulta ="SELECT *
								FROM productos
								WHERE barra = $codigo_barra;";							
					$resultado = mysqli_query($db->conexion, $consulta) 
					or die ("No se encontro el codigo de barra en la base.");											
					
					while($producto = mysqli_fetch_assoc($resultado))
						{
						echo'	
							<tr>
								<td> '.$producto["linea"].' </td>
								<td> '.$producto["modelo"].' </td>
								<td> '.$producto["codigo"].' </td>
								<td> '.$producto["DescMedida"].' </td>
								<td> '.$producto["barra"].' </td>					
								<td> 
									<a onclick="sacarArticulo('.$i.'); restar()">
										<span class="glyphicon glyphicon-remove"></span> 
									</a>
								</td>					
							</tr>
							';	
							
						}
					
					if(0 == mysqli_num_rows($resultado))
						{
						echo'	
							<tr>
								<td> No existe </td>
								<td> No existe </td>
								<td> No existe </td>
								<td> No existe </td>
								<td> '.$codigo_barra.' </td>					
								<td> 
									<a onclick="sacarArticulo('.$i.'); restar()">
										<span class="glyphicon glyphicon-remove"></span> 
									</a>
								</td>					
							</tr>
							';			
						}
					}
				$i++;		
				}
			//$db->close();	
			}
	}
	else{
		$i=0;
		foreach($_SESSION["barra"] as $codigo_barra)
			{
			if($codigo_barra!="")
				{
				$consulta ="SELECT *
							FROM productos
							WHERE barra = $codigo_barra;";							
				$resultado = mysqli_query($db->conexion, $consulta) 
				or die ("No se encontro el codigo de barra en la base.");																							
					
				while($producto = mysqli_fetch_assoc($resultado))
					{
					echo'	
						<tr>
							<td> '.$producto["linea"].' </td>
							<td> '.$producto["modelo"].' </td>
							<td> '.$producto["codigo"].' </td>
							<td> '.$producto["DescMedida"].' </td>
							<td> '.$producto["barra"].' </td>					
							<td> 
								<a onclick="sacarArticulo('.$i.'); restar()">
									<span class="glyphicon glyphicon-remove"></span> 
								</a>
							</td>					
						</tr>
						';	
						
					}
				
				if(0 == mysqli_num_rows($resultado))
					{
					echo'	
						<tr>
							<td> No existe </td>
							<td> No existe </td>
							<td> No existe </td>
							<td> No existe </td>
							<td> '.$codigo_barra.' </td>					
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
		}
	
echo'	
		</tbody>
	  </table>
	  
	  <button type="button" class="btn btn-info" onclick="ingresarBarras('.$consultar.')"> Consultar </button>	
	  <button type="button" class="btn btn-info" onclick="ingresarBarras('.$guardar.')"> Guardar </button>	
	</div>
	';
	
	
	
?>