<?php
	session_start();
	include "clases/articulos.php";
	date_default_timezone_set('America/Argentina/Buenos_Aires');
	setlocale (LC_TIME,"spanish");
	$fecha = date("d-m-Y H:i:s");
	$fecha2 = strftime("%A %e de %B");
	
	$_SESSION["i"]=0;
	
?>

<html>

<head>
	<!--Bootstrap
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	-->
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<script src="jquery/jquery.min.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>	
	<script type="text/javascript" src="scripts/funciones.js"></script>
	<style>
	.form-control:focus 
		{
		border-color: #FF0000;
		box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(255, 0, 0, 0.6);
		}
	
	
	</style>	
</head>

<body>
	<!--div class="col-sm-6 col-md-6 form-group">
		<form action="php/uploadFile.php" method="post" enctype="multipart/form-data">		
			<label for="barras"> Actualizar articulos </label>
			<input type="file" class="btn btn-default" name="archivo" id="archivo"></input>			
			<br>
			<input type="submit" class="btn btn-danger" value="Actualizar" name="submit"></input>
		</form>							
	</div-->
	<div class="container">
	<!--div class="container-fluid"-->
		<div class="row">
			<div class="col-sm-12 col-md-12">				
				<img class="img-responsive" src="img/vans_banner.jpg" alt="vans">
			</div>		
		</div>
		 
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<ul class="nav navbar-nav">
					<li><img src="img/vans_logo_rojo.png" alt="vans_logo" style="margin: 10 0 0 0px"></li>
					<li><a href="home.php">Home</a></li>
					<li><a href="home.php">Nuevo Inventario</a></li>
					<li><a href="#" id="inventario" onclick="ver('inventario')">Ver Inventario</a></li>
					<li><a href="#" id="grilla" onclick="ver('grilla')" class="btn btn-link disabled">Ver grilla</a></li>
					<li><a href="#" id="update" onclick="ver('formularioActualizar')" class="btn btn-link disabled">Actualizar articulos</a></li>
				</ul>
			</div>
		</nav>
		
		<div class="row" id="comandos">
			<div class="col-sm-6 col-md-6 form-inline">	
				<div class="form-group">
					<label for="barra"> Codigo de barras: </label>
					<input id="barra" type="text" class="form-control" placeholder="Ingrese el codigo de barras" onkeypress="ingresarBarras(event)"></input>										
				</div>
				<button type="button" class="btn btn-danger" onclick="ingresarBarras('0'); callprogress('100')"> Ingresar </button>					
			</div>									
			<div class="col-sm-6 col-md-6" id="formularioActualizar">	
				<button type="button" class="btn btn-danger" onclick="ingresarBarras('guardar')"> Guardar </button>
				<button id="exportar" class="btn btn-default" onclick="fnExcelReport()"> Exportar </button>
				<iframe id="txtArea1" style="display:none"></iframe>		
			</div>			
		</div>
		
		<hr>
		<label>Articulos escaneados: </label>
		<span id="contador"></span>	
				
		<div class="row">
			<br>
			<div class="table-responsive">          
				<table id="articulos" class="table">
					<thead>
						<tr>						
							<?php					
							$encabezados = array("Linea", "Modelo", "Codigo", "Temporada", "Medida", "Barra", "Precio");					
							foreach($encabezados as $encabezado)
								{
								echo "<th>".$encabezado."</th>";												
								}
							
							echo "<th id='cantidad'></th>";		
							
							?>
						</tr>		
					</thead>

					<tbody id="listado">
						
					</tbody>							
				</table>					
			</div>

			<div class="col-sm-10 col-md-10">
			
			</div>	
		</div>

		<div class="row">
			
		</div>	
	</div>	
	
</body>


</html>

