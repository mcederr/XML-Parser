<?php
	
	require('header.php');
	require('Classes/Task.php');
	require('Classes/Screen.php');
	require('Classes/ManagedObject.php');
	require('Classes/LogicalHandler.php');

	// Array que contendra todos los Screens que son solucion del problema
	$screensArray = array();

	// Array que contendra todos los Tasks que son solucion del problema
	$tasksArray = array();

	// Array que contendra todos los Managed Objects que son solucion del problema
	$managedObjectsArray = array();

	// Array que contendra todos los Logical Handles que son solucion del problema
	$logicalHandlerArray = array ();

	// Flag que indica si se terminaron de analizar los Handlers de las tareas
	$finalizo = true;

	// Atributo Buscado
	$className = $_GET['javaClass'];
	$environmentName = $_GET['environment'];

	// Levantamos el XML de Roles and Tasks
	$objDOM = new DOMDocument();
	$objDOM->load($environmentName);

	// Levantamos el XML de Advanced Settings
	$objDOM2 = new DOMDocument();
	$objDOM2->load("Files/XMLNAME_environment_settings.xml");

	// Obtengo todos los Screens
	$screens = $objDOM->getElementsByTagName("Screen");

	// Obtengo todos los ImsTask
	$imsTask = $objDOM->getElementsByTagName("ImsTask");

	// Obtengo todos los ManagedObject
	$managedObject = $objDOM->getElementsByTagName("ManagedObject");

	// Obtengo todos los Logical Handlers
	$businessLogicalHandler = $objDOM2->getElementsByTagName("BusinessLogicTaskHandler");
	$logicalAttributeHandler = $objDOM2->getElementsByTagName("LogicalAttributeHandler");




	// Verifico si existe la clase buscada dentro de mi universo de pantallas
	foreach ($screens as $searchClassInScreen){
		
		// Busco todas las Property de cada Screen
		foreach ($searchClassInScreen->getElementsByTagName("Property") as $searchClassInProperties){

			if ($searchClassInProperties->getAttribute("name") == 'InitJavaScript' || $searchClassInProperties->getAttribute("name") == 'ValidationJavaScript' || $searchClassInProperties->getAttribute("name") == 'jsOptions' || $searchClassInProperties->getAttribute("name") == 'FEEDER_PARSER' || $searchClassInProperties->getAttribute("name") == 'SnapshotExportGeneratorName' || $searchClassInProperties->getAttribute("name") == 'UserDetailsPolicyName') {

				// Verifico si esa propiedad contiene lo que estoy buscando
				if (stripos($searchClassInProperties->nodeValue, $className) !== false){

					$screen = new Screen();

					$screen->name = $searchClassInScreen->getAttribute('name');
					$screen->tag = $searchClassInScreen->getAttribute('tag');

					// Si lo contiene, lo agrego como solucion
					array_push($screensArray, $screen);
				}
			}
   		}
   	}




	// Verifico si existe la clase buscada dentro de mi universo de tareas
	foreach ($imsTask as $searchClassInImsTask){
		
		$task = new Task();

		// Busco todas las Property de cada ImsTask
		foreach ($searchClassInImsTask->getElementsByTagName("BusinessLogicTaskHandler") as $searchClassInTaskHandler){

			//$handlerName = $searchClassInTaskHandler->getAttribute('name');

			$handlerJavaClass = $searchClassInTaskHandler->getElementsByTagName("Java");

			// Verifico si la Property corresponde a la descripcion de una Pantalla y si la misma es la pantalla que estoy buscando

			foreach ($handlerJavaClass as $searchJavaClass) {

				if (stripos($searchJavaClass->getAttribute("class"), $className) !== false){

					$task->name = $searchClassInImsTask->getAttribute('name');
					$task->tag = $searchClassInImsTask->getAttribute('tag');
					array_push($task->handlers, $searchClassInTaskHandler->getAttribute('name'));
					array_push($tasksArray, $task);
				}	
			}
   		}
   	}




   	// Verifico si existe la clase buscada dentro de mi universo de Objetos no evaluados previamente
   	foreach ($managedObject as $searchClassInManagedObject) {
   		
   		$mObject = new ManagedObject();

    	// Busco todos los Attribute de cada ManagedObject
   		foreach ($searchClassInManagedObject->getElementsByTagName("Attribute") as $searchClassInManageObjectAttribute){

   			// Verifico si el Attribute contiene la clase que estoy buscando
   			if (stripos($searchClassInManageObjectAttribute->nodeValue, $className) !== false){

    			$mObject->managedObjectType = $searchClassInManagedObject->getAttribute('type');
    			$mObject->friendlyName = $searchClassInManagedObject->getAttribute('friendlyName');
   				array_push($managedObjectsArray, $mObject);
   			}
   		
   		}
   	}




   	// Verifico si existe la clase buscada dentro de mi universo de Business Logical Handlers
   	foreach ($businessLogicalHandler as $searchClassInBusinessLogicalHandlers) {

   		$blHandler = new LogicalHandler();

   		$blHandler->name = $searchClassInBusinessLogicalHandlers->getAttribute('name');

   		$blHandler->descripcion = $searchClassInBusinessLogicalHandlers->getAttribute('descripcion');

		$blHandler->isBusinessLogicalHandler = true;

		foreach ($searchClassInBusinessLogicalHandlers->getElementsByTagName("Java") as $searchClassInBusinessLogicalHandlersClass) {
			
			// Verifico si la Property corresponde a la descripcion de una Pantalla y si la misma es la pantalla que estoy buscando		
			if (stripos($searchClassInBusinessLogicalHandlersClass->getAttribute("class"), $className) !== false){

				array_push($logicalHandlerArray, $blHandler);
			}		
		}
   	}



   	// Verifico si existe la clase buscada dentro de mi universo de Logical Handlers
   	foreach ($logicalAttributeHandler as $searchClassInLogicalHandlers) {

		if (stripos($searchClassInLogicalHandlers->getAttribute('class'), $className) !== false){

			$lHandler = new LogicalHandler();

			$lHandler->name = $searchClassInLogicalHandlers->getAttribute('name');

			$lHandler->description = $searchClassInLogicalHandlers->getAttribute('description');

			$lHandler->isBusinessLogicalHandler = false;

			$lHandler->objectType = $searchClassInLogicalHandlers->getAttribute("objecttype");

			array_push($logicalHandlerArray, $lHandler);
		}

   	}


   	// Si existe solucion de mi problema
   	if (sizeof($screensArray) > 0 || sizeof($tasksArray) > 0 || sizeof($managedObjectsArray) > 0 || sizeof($logicalHandlerArray) > 0) {
   		
?>		

		<div class="alert alert-primary" role="alert">
			<dl class="row">
				<dt class="col-sm-3">Class:</dt>
				<dd class="col-sm-9"><?php echo $className; ?></dd>
			</dl>
		</div>




		<div class="row">
	    	<div class="col">
	      		<table class="table table-hover table-dark table-bordered" id="task_table">
					<thead>
						<tr>
							<th colspan="2">Screens</th>
						</tr>
						<tr>
							<th>Name</th>
							<th>Tag</th>
						</tr>
					</thead>
					<tbody>

						<?php

							if (sizeof($screensArray) > 0) {

								foreach ($screensArray as $solution) {

						?>

									<tr>
										<td><?php echo $solution->name ?></td>
										<td><?php echo $solution->tag ?></td>
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
						?>
					</tbody>
				</table>
	    	</div>




	    	<div class="col">
	      		<table class="table table-hover table-dark table-bordered" id="task_table">
					<thead>
						<tr>
							<th colspan="3">Tasks</th>
						</tr>
						<tr>
							<th>Name</th>
							<th>Tag</th>
							<th>Handler Name</th>
						</tr>
					</thead>
					<tbody>
						
						<?php

							if (sizeof($tasksArray) > 0) {

								foreach ($tasksArray as $solution) {

									foreach ($solution->handlers as $handlers) {
										
										if ($finalizo){

						?>
											<tr>
												<td><?php echo $solution->name; ?></td>
												<td><?php echo $solution->tag; ?></td>
												<td><?php echo $handlers; ?></td>
											</tr>
						<?php
											$finalizo = false;
										}else{
						?>
											<tr>
												<td></td>
												<td></td>
												<td><?php echo $handlers; ?></td>
											</tr>
						<?php
										}
									}

									$finalizo = true;
								}
								
							}else{
						?>
								<tr>
									<td colspan="3" style="text-align: center;">Results Not Found</td>
								</tr>
						<?php
							}
						?>
					</tbody>
				</table>
	    	</div>
	</div>
	
	<div class="row">



	    	<div class="col">
		      	<table class="table table-hover table-dark table-bordered" id="task_table">
					<thead>
						<tr>
							<th colspan="2">Managed Objects</th>
						</tr>
						<tr>
							<th>Type</th>
							<th>FriendlyName</th>
						</tr>
					</thead>
					<tbody>
						<?php

							if(sizeof($managedObjectsArray) > 0){

								foreach ($managedObjectsArray as $solution) {
									
						?>
									<tr>
										<td><?php echo $solution->managedObjectType; ?></td>
										<td><?php echo $solution->friendlyName; ?></td>
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
						
						?>
					</tbody>
				</table>
			</div>





			<div class="col">
		      	
		      	<table class="table table-hover table-dark table-bordered" id="task_table">

		      		<thead>
						<tr>
							<th colspan="4">Logical Handlers</th>
						</tr>
		      			<tr>
		      				<th>Name</th>
		      				<th>Description</th>
		      				<th>Handler</th>
		      				<th>ObjectType</th>
		      			</tr>
		      			
		      		</thead>

		      		<tbody>
		      			
		      			<?php

		      				if (sizeof($logicalHandlerArray) > 0) {

		      					foreach ($logicalHandlerArray as $solution) {

		      						if ($solution->isBusinessLogicalHandler == true) {
		      							
		      			?>
										<tr>
											<td><?php echo $solution->name; ?></td>
											<td><?php echo $solution->description; ?></td>
											<td>Business Logic Task</td>
											<td></td>
										</tr>
		      			<?php
		      						}else{

		      			?>

										<tr>
											<td><?php echo $solution->name; ?></td>
											<td><?php echo $solution->description; ?></td>
											<td>Logical Attribute</td>
											<td><?php echo $solution->objectType; ?></td>
										</tr>

		      			<?php

		      						}

		      					}
		      					
		      				}else{

		      			?>
		      					<tr>
									<td colspan="4" style="text-align: center;">Results Not Found</td>
								</tr>
		      			
		      			<?php

		      				}

		      			?>

		      		</tbody>

		      	</table>
				
			</div>
	  	
	  	</div>
<?php   	
   	
   	}else{

?>
		<div class="alert alert-primary" role="alert">
			<dl class="row">
				<dt class="col-sm-3">Class:</dt>
				<dd class="col-sm-9"><?php echo $className; ?></dd>
			</dl>
		</div>

		<table class="table table-hover table-dark table-bordered" id="task_table">
			<thead>
	      		<th>Screen Name</th>
	      		<th>Task Name</th>
	      		<th>Task Tag</th>
	      		<th>Handler Name</th>
	      		<th>Managed Object Type</th>
	      		<th>Managed Object FriendlyName</th>
			</thead>
			<tbody>
				<tr>
					<td colspan="6" style="text-align: center;">Results Not Found</td>
				</tr>
			</tbody>
		</table>

<?php
   	
   	}

	require('export.php');
	require('footer.php'); 

?>