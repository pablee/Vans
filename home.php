<?php
	session_start();
	include_once "clases/database.php";
	include_once "clases/articulos.php";
	
	date_default_timezone_set('America/Argentina/Buenos_Aires');
	setlocale (LC_TIME,"spanish");
	$fecha = date("d-m-Y H:i:s");
	$fecha2 = strftime("%A %e de %B");
	
	//$_SESSION["barra"]="";
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
	
</head>

<body onload="crearBase()">
	<div class="container">
	<!--div class="container-fluid"-->
		<div class="row">
			<div class="col-sm-4 col-md-8">
				<h1>Vans<h1>
			</div>		
		</div>
		
		<div class="row" id="contenido">
			<div class="col-sm-3 col-md-6">	
				<div class="form-group">
					<label for="barra"> Codigo de barras </label>
					<input id="barra" type="text" class="form-control" placeholder="Ingrese el codigo de barras" onkeypress="ingresarBarras(event)"></input>
				</div>
				<button type="button" class="btn btn-info" onclick="ingresarBarras('0'); callprogress('100')"> Ingresar </button>	
				<a href="home.php" class="btn btn-info"> Nuevo </a>	
			</div>
												
			<div class="col-sm-3 col-md-6">	
				<div class="form-group">
					<form action="php/uploadFile.php" method="post" enctype="multipart/form-data">		
						<label for="barras"> Actualizar articulos </label>
						<input type="file" class="btn btn-default" name="archivo" id="archivo"></input>			
						<br>
						<input type="submit" class="btn btn-info" value="Actualizar" name="submit">
					</form>							
				</div>				
			</div>
		</div>
		
		<label>Articulos escaneados: </label>
		<span id="contador"></span>	
				
		<div class="row">
			<br>
			<div class="col-sm-6 col-md-10" id="lista">
			
			</div>	
		</div>

		<div>	
			<button id="exportar" class="btn btn-default" onclick="fnExcelReport()"> Exportar </button>
			<iframe id="txtArea1" style="display:none"></iframe>
		</div>	
	</div>	
	
</body>


</html>

