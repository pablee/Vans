<?php

echo '<div class="col-sm-6 col-md-6 form-group">
		<form action="php/uploadFile.php" method="post" enctype="multipart/form-data">		
			<label for="barras"> Actualizar articulos </label>
			<input type="file" class="btn btn-default" name="archivo" id="archivo"></input>			
			<br>
			<input type="submit" class="btn btn-info" value="Actualizar" name="submit">						
		</form>							
	  </div>';

?>