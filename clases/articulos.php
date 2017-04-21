<?php

class articulo	{
				public $linea;
				public $modelo;
				public $codigo;
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
						echo $this->medida;
						echo '<br>';
						echo $this->barra;
						echo '<br>';
						echo $this->cantidad;
						}

				}		
?>						