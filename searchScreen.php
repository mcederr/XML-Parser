<?php
	
	require('header.php');
	require_once('Classes/Task.php');

	// Array que contendra la solucion del problema
	$auxArray = array();

	// Array que en caso de no encontrar la pantalla sugerira posibles soluciones
	$suggestArray = array();

	// Atributo Buscado
	$screen = $_GET['screen'];
	$environmentName = $_GET['environment'];

	$objDOM = new DOMDocument();
	$objDOM->load($environmentName);

	// Obtengo todos los ImsTask
	$imsTask = $objDOM->getElementsByTagName("ImsTask");

	// Verifico si existe la pantalla buscada dentro de mi universo de tareas
	foreach ($imsTask as $searchImsTask){
		
		// Busco todas las Property de cada ImsTask
		foreach ($searchImsTask->getElementsByTagName("Property") as $searchTaskProperty){

			$imsTaskPropertyAttributeName = $searchTaskProperty->getAttribute('name');

			// Verifico si la Property corresponde a la descripcion de una Pantalla
			// y si la misma es la pantalla que estoy buscando

			if ($imsTaskPropertyAttributeName == 'Screen' && $searchTaskProperty->nodeValue == $screen) {

				$solution = new Task();
				$solution->name = $searchImsTask->getAttribute('name');
				$solution->tag = $searchImsTask->getAttribute('tag');
				array_push($auxArray, $solution);

   			}else{

	   			// Verifico si es una posible solucion es decir, si el nombre de la tarea o el tag contiene lo que estoy buscando
	   			if ($imsTaskPropertyAttributeName == 'Screen' && stripos($searchTaskProperty->nodeValue, $screen) !== false){

	   				// Si lo es me lo guardo como posible solucion a mi problema
	   				$suggestion = $searchTaskProperty->nodeValue;
	   				array_push($suggestArray, $suggestion);
	   			}
   			}
   		}
   	}

?>
	<table class="table table-hover table-dark table-bordered" id="task_table">
	  <thead>
	    <tr>
	      <th>Screen: <?php echo $screen; ?></th>
	      <th>Task Name</th>
	      <th>Task Tag Name</th>
	    </tr>
	  </thead>
	  <tbody>
	    
		<?php

			if (sizeof($auxArray)>0) {
				
				foreach ($auxArray as $solution) {
		?>

					<tr>
						<td></td>
				    	<td><?php echo $solution->name; ?></td>
				    	<td><?php echo $solution->tag; ?></td>
					</tr>

		<?php
				}

			}else{

				if (sizeof($suggestArray)>0) {
		?>
		
					<div class="alert alert-secondary" role="alert"><b><?php echo $screen ?></b> Not Found. Here are some suggestions</div>

		<?php
		
					foreach ($suggestArray as $solution) {
		
		?>
						<tr>
							<td></td>
							<td><?php echo $solution?></td>
							<td><a href="searchScreen.php?screen=<?php echo $solution;?>&environment=<?php echo $environmentName; ?>"><?php echo $solution; ?></a></td>
						</tr>
		<?php
					}

				}else{
		?>
					<tr>
						<td colspan="3" style="text-align: center;">Results Not Found</td>
					</tr>
		<?php
				}
			}

		?>

	    <!--<?php

	    	// Obtengo todos los ImsTask
	    	$imsTask = $objDOM->getElementsByTagName("ImsTask");
	    	
	    	foreach ($imsTask as $searchImsTask) {
	    		
	    		// Obtengo el nombre de cada ImsTask
    			$imsTaskName = $searchImsTask->getAttribute('name');

    			$imsTaskTag = $searchImsTask->getAttribute('tag');
					
				// Busco todas las Property de cada ImsTask
				foreach ($searchImsTask->getElementsByTagName("Property") as $searchTaskProperty){

					$imsTaskPropertyAttributeName = $searchTaskProperty->getAttribute('name');

					// Verifico si la Property corresponde a la descripcion de una Pantalla
					// y si la misma es la pantalla que estoy buscando

					if ($imsTaskPropertyAttributeName == 'Screen' && $searchTaskProperty->nodeValue == $screen) {

		?>-->
						<!-- 
							Lo muestro por pantalla 
						-->
				    	<!--<tr>
				    		<td></td>
				    		<td><?php echo $imsTaskName; ?></td>
				    		<td><?php echo $imsTaskTag; ?></td>
				    	</tr>-->
		<!--<?php

					}
				}

	    	}
	    
	    ?>-->

	  </tbody>
	</table>
<?php 
require('export.php');
require('footer.php'); ?>