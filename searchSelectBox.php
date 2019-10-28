<?php
	
	require('header.php');
	require('Classes/Screen.php');
	require('Classes/Task.php');

	// Atributo Buscado
	$selectBox = $_GET['selectBox'];
	$selectBox = '["'.$selectBox.'"]';
	$environmentName = $_GET['environment'];

	$finalizo = true;
	$counter = 0;

	$selectBoxArray = array();
	$suggestionsArray = array();
	$taskArray = array();

	$objDOM = new DOMDocument();
	$objDOM->load($environmentName);

	$screens = $objDOM->getElementsByTagName('Screen');



	foreach ($screens as $searchScreens) {
		
		foreach ($searchScreens->getElementsByTagName('Property') as $searchSelectBoxInScreenProperties) {
			
			// Verifico si la Property que estoy analizando es el Select Box que estoy buscando
			if ($searchSelectBoxInScreenProperties->getAttribute('name') == 'auxDataPath' && $searchSelectBoxInScreenProperties->nodeValue  == $selectBox) {

				$screen = new Screen();
				$screen->name = $searchScreens->getAttribute('name');
				$screen->tag = $searchScreens->getAttribute('tag');
				array_push($selectBoxArray, $screen);
			
			}else{

				// Quito los parametros que se agregaron previamente para realizar la busqueda si no se realiza esto, no se puede buscar resultados 
				// que contengan la Select Box que estoy buscando

				$selectBox = str_replace('["', "", $selectBox);
				$selectBox = str_replace('"]', "", $selectBox);

				// Verifico si la Property que estoy analizando contiene el Select Box que estoy buscando
				if ($searchSelectBoxInScreenProperties->getAttribute('name') == 'auxDataPath' && stripos($searchSelectBoxInScreenProperties->nodeValue, $selectBox)) {
					
					$suggestion = $searchSelectBoxInScreenProperties->nodeValue;
					$suggestion = str_replace('["', '', $suggestion);
					$suggestion = str_replace('"]', '', $suggestion);
					array_push($suggestionsArray, $suggestion);

				}

				$selectBox = '["'.$selectBox.'"]';
			}

		}

	}

	// Quito los parametros que se agregaron previamente para realizar la busqueda
	$selectBox = str_replace('["', "", $selectBox);
	$selectBox = str_replace('"]', "", $selectBox);

	// Elimino los valores duplicados
	//$selectBoxArray = array_unique($selectBoxArray);
	$suggestionsArray = array_unique($suggestionsArray);

	if (sizeof($selectBoxArray) > 0) {

		// Obtengo todos los ImsTask
		$tasks = $objDOM->getElementsByTagName("ImsTask");
		
		foreach ($tasks as $searchTask) {

			$task = new Task();
			$task->name = $searchTask->getAttribute('name');
			$task->tag = $searchTask->getAttribute('tag');
			
			// Busco todas las Property de cada ImsTask
			foreach ($searchTask->getElementsByTagName("Property") as $searchTaskProperty){

				// Verifico si la Property corresponde a la descripcion de una Pantalla
				// y si la misma es la pantalla que estoy buscando

				if ($searchTaskProperty->getAttribute('name') == 'Screen') {

					foreach ($selectBoxArray as $searchScreenTasks) {

						//echo "Task Screen: ".$searchTaskProperty->nodeValue."<br>";
						//echo "Screen Name: ".$searchScreenTasks->name."<br>";

						if ($searchTaskProperty->nodeValue == $searchScreenTasks->name || $searchTaskProperty->nodeValue == $searchScreenTasks->tag){

							$counter++;

							array_push($searchScreenTasks->tasks, $task);

						}
					}

				}
			}
		}
	}
	

?>
	<div class="alert alert-primary" role="alert">
		<dl class="row">
			<dt class="col-sm-3">Select Box:</dt>
			<dd class="col-sm-9"><?php echo $selectBox; ?></dd>
		</dl>
		<dl class="row">
			<dt class="col-sm-3">Screens Results:</dt>
			<dd class="col-sm-9"><?php echo sizeof($selectBoxArray); ?></dd>
		</dl>
		<dl class="row">
			<dt class="col-sm-3">Tasks Results:</dt>
			<dd class="col-sm-9"><?php echo $counter; ?></dd>
		</dl>
	</div>
	
	<table class="table table-hover table-dark table-bordered">
		<thead>
	  	
		<?php

			if (sizeof($selectBoxArray) > 0 || sizeof($suggestionsArray) == 0){

		?>

			  	<tr>
			  		<th colspan="2">Screens</th>
			  		<th colspan="2">Tasks</th>
			  	</tr>
			    <tr>
			      <th>Name</th>
			      <th>Tag</th>
			      <th>Name</th>
			      <th>Tag</th>
			    </tr>
	    
	    <?php
			
			}else{
				
				if (sizeof($suggestionsArray) > 0){
		?>
					<tr>
			  			<th colspan="2">Select Box</th>
			  		</tr>
			    	<tr>
			      		<th>Name</th>
			    	</tr>
		<?php
				}
			}
		?>
		
		</thead>
		
		<tbody>
		
		<?php

	    	if (sizeof($selectBoxArray) > 0) {
	    		
	    		foreach ($selectBoxArray as $solution) {
	    			
	    			if (sizeof($solution->tasks) > 0) {
	    				
		    			foreach ($solution->tasks as $solutionTasks) {
							
							if ($finalizo){

								$finalizo = false;
		?>
			    				<tr>
			    					<td><?php echo $solution->name; ?></td>
			    					<td><?php echo $solution->tag; ?></td>
			    					<td><?php echo $solutionTasks->name; ?></td>
			    					<td><?php echo $solutionTasks->tag; ?></td>
			    				</tr>
		<?php
							}else{
		?>
								<tr>
									<td></td>
									<td></td>
									<td><?php echo $solutionTasks->name; ?></td>
			    					<td><?php echo $solutionTasks->tag; ?></td>
								</tr>
		<?php
							}
						}

						$finalizo = true;
	    			
	    			}else{

	    ?>
						<tr>
							<td><?php echo $solution->name; ?></td>
			    			<td><?php echo $solution->tag; ?></td>
							<td></td>
							<td></td>
						</tr>
	    <?php
	    			}
	    		
	    		}

	    	}else{

	    		if (sizeof($suggestionsArray) > 0) {
	    ?>

	    			<div class="alert alert-secondary" role="alert">Select Box Not Found. Here are some suggestions</div>
		
		<?php
	    			foreach ($suggestionsArray as $solution) {
	    
	    ?>
	    				<tr>
	    					<td><a href="searchSelectBox.php?selectBox=<?php echo $solution;?>&environment=<?php echo $environmentName; ?>"><?php echo $solution; ?></a></td>
	    				</tr>

	    <?php
	    			}

	    		}else{

	    ?>
	    			<tr>
						<td colspan="2" style="text-align: center;">Results Not Found</td>
					</tr>
		<?php
				}
	    	
	    	}

	    ?>

	  </tbody>
	</table>
<?php 
require('export.php');
require('footer.php'); ?>