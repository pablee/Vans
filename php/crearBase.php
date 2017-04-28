<?php
session_start();

$db = new database();
$db->conectar();	
/*
$consulta ="CREATE DATABASE IF NOT EXISTS vans;";	
$resultado = mysqli_query($db->conexion, $consulta) 
or die ("No se pudo crear la base de datos");
*/
$consulta ="CREATE TABLE IF NOT EXISTS productos 
				(
				marca varchar(5) DEFAULT NULL,
				linea varchar(31) DEFAULT NULL,
				modelo varchar(50) DEFAULT NULL,
				codigo char(20) DEFAULT NULL,
				temporada VARCHAR(31) NOT NULL,
				DescMedida char(5) DEFAULT NULL,
				barra varchar(50) NOT NULL,
				PRIMARY KEY (barra),
				KEY barra (barra)
				) ENGINE=InnoDB DEFAULT CHARSET=latin1;
			";
$resultado = mysqli_query($db->conexion, $consulta) 
or die ("No se pudo crear la tabla productos");	

$consulta ="CREATE TABLE IF NOT EXISTS listado 
				(
				id int(11) NOT NULL AUTO_INCREMENT,
				barra varchar(50) NOT NULL,
				PRIMARY KEY (id)
				) ENGINE=InnoDB DEFAULT CHARSET=latin1;
			";
$resultado = mysqli_query($db->conexion, $consulta) 
or die ("No se pudo crear la tabla listado");

$db->close();		
		
?>