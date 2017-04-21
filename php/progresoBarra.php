<?php
$porcentaje = $i * 100 / $ValorTotal; //saco mi valor en porcentaje
echo "<script>callprogress(".round($porcentaje).")</script>"; //llamo a la función JS(JavaScript) para actualizar el progreso

/*
$ValorTotal=$_SESSION["i"];	

for($i=1;$i<=$ValorTotal;$i++)
	{	
	//le digo que si es igual al total detengo el bucle
	sleep(1); //descanso 1 minuto para mostrar de forma pausada el proceso
	$porcentaje = $i * 100 / $ValorTotal; //saco mi valor en porcentaje
	echo "<script>callprogress(".round($porcentaje).")</script>"; //llamo a la función JS(JavaScript) para actualizar el progreso
	flush(); //con esta funcion hago que se muestre el resultado de inmediato y no espere a terminar todo el bucle con los 25 registros para recien mostrar el resultado
	ob_flush();
	$j++;
	}
	
/*	
$ValorTotal=$i; //Valor total de registros

	for($i=1;$i<=$ValorTotal;$i++)
		{ //le digo que si es igual al total detengo el bucle
		sleep(1); //descanso 1 minuto para mostrar de forma pausada el proceso
		$porcentaje = $i * 100 / $ValorTotal; //saco mi valor en porcentaje
		echo "<script>callprogress(".round($porcentaje).")</script>"; //llamo a la función JS(JavaScript) para actualizar el progreso
		flush(); //con esta funcion hago que se muestre el resultado de inmediato y no espere a terminar todo el bucle con los 25 registros para recien mostrar el resultado
		ob_flush();
		}	
*/
?>