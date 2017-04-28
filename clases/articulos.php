<?php

class articulo	{
				public $linea;
				public $modelo;
				public $codigo;
				public $temporada;
				public $medida;
				public $barra;
				public $cantidad;
								
				//public function __construct(){}
				
				public function ver() 
						{
						echo $this->linea;
						echo '<br>';
						echo $this->modelo;
						echo '<br>';
						echo $this->codigo;
						echo '<br>';
						echo $this->temporada;
						echo '<br>';
						echo $this->medida;
						echo '<br>';
						echo $this->barra;
						echo '<br>';
						echo $this->cantidad;
						}
						
				public function consultarArticulo($codigo_barra)
						{
						$db=new database();
						$db->conectar();	
						
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
									<td> '.$producto["temporada"].' </td>
									<td> '.$producto["DescMedida"].' </td>
									<td> '.$producto["barra"].' </td>																	
									
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
									<td> No existe </td>
									<td> '.$codigo_barra.' </td>																
								
								';			
							}
						$db->close();	
						}
					
				public function guardarArticulo($codigos)
						{
						$db=new database();
						$db->conectar();	
						
						//Guarda los articulos en la tabla listado	
						$consulta ="TRUNCATE TABLE listado;";	
						$resultado = mysqli_query($db->conexion, $consulta) 
						or die ("No se pudo borrar la tabla listado");										
						
						foreach($codigos as $codigo_barra)
							{
							if($codigo_barra!="")
								{		
								$consulta ="INSERT INTO listado (barra) VALUES ($codigo_barra);";				
								$resultado = mysqli_query($db->conexion, $consulta) 
								or die ("No se pudo guardar el codigo de barra en la base.");
								}
							}	
						
						//Genera las filas de la tabla articulos
						$consulta ="SELECT P.marca, P.linea, P.modelo, P.codigo, P.temporada, P.DescMedida, L.barra, COUNT(L.barra) as cantidad 
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
									<td> '.$producto["temporada"].' </td>
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
				}		
						
						
				
				
?>						