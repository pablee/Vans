<?php
include_once ("database.php");

class articulo	{
				public $linea;
				public $modelo;
				public $codigo;
				public $temporada;
				public $medida;
				public $barra;
				public $precio;
				public $cantidad;
				
				private $campo_tabla = array("linea","modelo","codigo","temporada","medida","barra","precio","cantidad");
				//public function __construct(){}
				
				public function consultarArticulo($codigo_barra, $i)
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
								<tr id='.$i.'>
									<td> '.$producto["linea"].' </td>
									<td> '.$producto["modelo"].' </td>
									<td> '.$producto["codigo"].' </td>
									<td> '.$producto["temporada"].' </td>
									<td> '.$producto["DescMedida"].' </td>
									<td> '.$producto["barra"].' </td>																	
									<td> '.$producto["precio"].' </td>									
								';											
							}
						
						if(0 == mysqli_num_rows($resultado))
							{
							echo'	
								<tr id='.$i.'>
									<td> No existe </td>
									<td> No existe </td>
									<td> No existe </td>
									<td> No existe </td>
									<td> No existe </td>									
									<td> '.$codigo_barra.' </td>																
									<td> No existe </td>
								
								';			
							}

						echo'			
							<td> 
								<a onclick="sacarArticulo('.$i.'); restar()">
									<span class="glyphicon glyphicon-remove"></span> 
								</a>
							</td>	
							';
							
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
								$resultado = mysqli_query($db->conexion, $consulta);
								//or die ("No se pudo guardar el codigo de barra en la tabla listado.");
								}
							}	
						
						$this->verInventario();	
						$db->close();	
						}
						
				public function verInventario() 
						{
						$db=new database();
						$db->conectar();	
							
						$consulta ="SELECT P.marca, P.linea, P.modelo, P.codigo, P.temporada, P.DescMedida, L.barra, P.precio, COUNT(L.barra) as cantidad 
									FROM listado L JOIN productos P ON L.barra = P.barra
									GROUP BY L.barra;";											
						$resultado = mysqli_query($db->conexion, $consulta) 
						or die ("No se encontro el ultimo inventario en la base.");	

												
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
									<td> '.$producto["precio"].' </td>									
									<td> '.$producto["cantidad"].' </td>	
								  </tr>
								';	
							}
						/*	
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
									<td> '.$producto["precio"].' </td>									
									<td> '.$producto["cantidad"].' </td>	
								  </tr>
								';	
							}
						*/
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
									<td> No existe </td>									
									<td> '.$producto["barra"].' </td>				
									<td> No existe </td>
									<td> '.$producto["cantidad"].' </td>			
								</tr>
								';			
							}
						
						}
						
				public function verGrilla() 
						{
						$db=new database();
						$db->conectar();	
							
						//Consulta las lineas y los modelos ingresados.
						$consulta="SELECT DISTINCT P.linea, P.modelo FROM listado L JOIN productos P ON L.barra = P.barra GROUP BY L.barra";
						$lineas_modelos=mysqli_query($db->conexion, $consulta) 
						or die ("No se pudo consultar las lineas y modelos ingresados.");							
						$grilla[0][0]='Linea';
						$grilla[0][1]='Modelo';						
						$grilla[0][2]='Codigo';
						$grilla[0][3]='Temporada';
						$y=1;
						while($linea_modelo = mysqli_fetch_assoc($lineas_modelos))
							{
							//Guarda las lineas y modelos. ($grilla[y][x])
							$grilla[$y][0]=$linea_modelo["linea"];
							$grilla[$y][1]=$linea_modelo["modelo"];
							$y++;
							}
						
						//Consulta las medidas de los productos ingresados.	
						$consulta="SELECT DISTINCT DescMedida FROM productos ORDER BY DescMedida ASC";
						$medidas=mysqli_query($db->conexion, $consulta) 
						or die ("No se pudo consultar las lineas y modelos ingresados.");							
						$x=4;
						while($medida = mysqli_fetch_assoc($medidas))
							{
							//Guarda los tipos de medidas. ($grilla[y][x])
							$grilla[0][$x]=$medida["DescMedida"];							
							$x++;
							}
						
						//Inicializa celdas vacias. ($grilla[y][x])
						for($i=1;$i<$y;$i++)
							{
							for($j=4;$j<$x;$j++)
								{								
								$grilla[$i][$j]="";								
								}						
							}
												
						//Imprimir la grilla
						echo '<div class="table-responsive">';
						echo '<table class="table table-striped">';
						echo '<thead>';
						
						echo '</thead>';
						echo '<tbody>';

						$consulta ="SELECT P.marca, P.linea, P.modelo, P.codigo, P.temporada, P.DescMedida, L.barra, P.precio, COUNT(L.barra) as cantidad 
									FROM listado L JOIN productos P ON L.barra = P.barra
									GROUP BY L.barra;";										
						$resultado = mysqli_query($db->conexion, $consulta) 
						or die ("No se encontro el ultimo inventario en la base.");	
						
						//Carga los datos en la matriz.
						while($producto = mysqli_fetch_assoc($resultado))
							{
							for($i=1;$i<$y;$i++)
								{
								//$grilla[y][x]
								if($grilla[$i][0]==$producto["linea"])
									{
									if($grilla[$i][1]==$producto["modelo"])
										{										
										//Codigo
										$grilla[$i][2]=$producto["codigo"];	
										//Temporada
										$grilla[$i][3]=$producto["temporada"];
										//Medida (cantidad)
										for($j=4;$j<$x;$j++)
											{
											if($grilla[0][$j]==$producto["DescMedida"])
												{
												$grilla[$i][$j]=$producto["cantidad"];
												}												
											}										
										}
									}									
								}								
							}
							
						//$grilla[y][x]	
						for($i=0;$i<$y;$i++)
							{
							echo '<tr>';
							for($j=0;$j<$x;$j++)
								{								
								echo '<td>'.$grilla[$i][$j].'<td>';								
								}
							echo '</tr>';	
							}
						
						echo '</tbody>';
						echo '</table>
							</div>';
						}
						
				//No es utilizado en la aplicacion
				public function ingresarArticulo($linea,$modelo,$codigo,$temporada,$medida,$barra,$cantidad) 
						{
						foreach($this->campo_tabla as $campo)
							{
							$this->$campo=$$campo;
							}							
						}
				
				//No es utilizado en la aplicacion	
				public function verCamposArticulos() 
						{
						foreach($this->campo_tabla as $campo)
							{
							echo $campo;
							echo '<br>';	
							}					
						}		
							
				}		
						
						
				
				
?>						