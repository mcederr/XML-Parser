<?php
	
	require('header.php');
	require_once('Classes/ManagedObject.php');
	require_once('Classes/Task.php');
	require_once('Functions/methods.php');

	// Levantamos el XML
	//$objDOM = new DOMDocument();
	//$objDOM->load("Claro.xml");
	
	// Flag que indicara cuando se cambio de ImsTask, como es el primer elemento siempre tiene
	// que cambiar de fila para agregar el nuevo elemento
	$finalizo = true;

	// Flag que indicara si la tarea buscada existe en mi universo de tareas
	$existeTask = false;

	// Array que contendra la solucion del problema
	$auxArray = array();

	// Array que en caso de no encontrar la tarea sugerira posibles soluciones
	$suggestArray = array();

	// Atributo Buscado
	$task = $_POST['task'];

	// Obtengo todas las tareas
	$imsTask = $objDOM->getElementsByTagName("ImsTask");

	// Verifico si existe la tarea buscada dentro de mi universo de tareas
	foreach ($imsTask as $searchImsTask){

		// Si al buscar el Name o Tag de la tarea encuentro la tarea buscada
		if ($searchImsTask->getAttribute('name') == $task || $searchImsTask->getAttribute('tag') == $task){

			// Me guardo esos datos
			$taskName = $searchImsTask->getAttribute('name');
			$taskTag = $searchImsTask->getAttribute('tag');

  			// Indico que la tarea buscada existe
   			$existeTask = true;

   		}else{

   			if (stripos($searchImsTask->getAttribute('name'), $task) !== false || stripos($searchImsTask->getAttribute('tag'), $task) !== false){

   				$suggestion = new Task();
   				$suggestion->name = $searchImsTask->getAttribute('name');
   				$suggestion->tag = $searchImsTask->getAttribute('tag');
   				array_push($suggestArray, $suggestion);
   			}
   		}
   	}

?>

<?php 

	// Consulto si existe la tarea buscada dentro de mi universo de tareas
	if($existeTask){ 

?>
		<dl class="row">
		<dt class="col-sm-3">Task Name:</dt>
			<dd class="col-sm-9"><?php echo $taskName; ?></dd>
			<dt class="col-sm-3">Task Tag:</dt>
			<dd class="col-sm-9"><?php echo $taskTag; ?></dd>
		</dl>
<?php

	}else{

?>
		<dl class="row">
			<dt class="col-sm-3">Task Name:</dt>
			<dd class="col-sm-9"><?php echo $task; ?></dd>
			<dt class="col-sm-3">Task Tag:</dt>
			<dd class="col-sm-9"></dd>
		</dl>
<?php	
		}

	if ($existeTask) {

?>
		<table class="table table-hover table-dark table-bordered" id="task_table">
		  <thead>
		    <tr>
		      <th>Managed Object Type</th>
		      <th>Managed Object Friendly Name</th>
		      <th>Category</th>
		      <th>Attribute Type Value</th>
		      <th>Type</th>
		      <th>Step</th>
		      <th>Priority</th>
		      <th>Status</th>
		    </tr>
		  </thead>
		  <tbody>
		    
		    <?php

		    	//if ($existeTask) {
		    		
	    		// Obtengo todos los Managed Objects
	    		$managedObject = $objDOM->getElementsByTagName("ManagedObject");

	    		foreach ($managedObject as $searchManagedObject){

	    			$whenToRun = new ManagedObject();

	    			// Busco el tipo y el nombre de cada Managed Object
		    		$whenToRun->managedObjectType = $searchManagedObject->getAttribute('type');
	    			$whenToRun->friendlyName = $searchManagedObject->getAttribute('friendlyName');

	    			// Busco todos los Attributes de cada Managed Object
					foreach ($searchManagedObject->getElementsByTagName("Attribute") as $searchManagedObjectAttribute){

						// Obtengo el nombre de ese atributo
						$managedObjectAttributeName = $searchManagedObjectAttribute->getAttribute('name');

						// Verifico si el nombre de ese atributo especifica si esta habilitado el Managed Object
						if ($managedObjectAttributeName == 'enabled'){

							//Si lo es, obtengo el valor del atributo
							$whenToRun->status = $searchManagedObjectAttribute->nodeValue;

						}

						// Verifico si el nombre de ese atributo especifica la categoria del Managed Object
						if ($managedObjectAttributeName == 'category'){

							//Si lo es, obtengo el valor del atributo
							$whenToRun->category = $searchManagedObjectAttribute->nodeValue;

						}

						// Verifico si el nombre de ese atributo especifica la prioridad del Managed Object
						if ($managedObjectAttributeName == 'priority'){

							//Si lo es, obtengo el valor del atributo
							$whenToRun->priority = $searchManagedObjectAttribute->nodeValue;

						}

						// Verifico si el nombre de ese atributo especifica el tipo atributo del Managed Object
						if ($managedObjectAttributeName == 'type'){

							// Si lo es, obtengo el valor del atributo
							$whenToRun->attributeTypeValue = $searchManagedObjectAttribute->nodeValue;

						}

						// Verifico si el nombre de ese atributo especifica cuando se ejecuta el Managed Object
						if ($managedObjectAttributeName == 'whenToRun'){

							//Si lo es, obtengo el valor del atributo
							$managedObjectAttributeWhenToRun = $searchManagedObjectAttribute->nodeValue;

							// Hago un split por atributo para obtener toda la informacion de la
							// especificacion
							$arrayAttributes = explode("<Attribute", $managedObjectAttributeWhenToRun);

							//print_r($arrayAttributes);
							//echo "<br><br>";
							
							// Recorro todos los atributos obtenidos y busco la informacion que necesite
							for ($i=0; $i < sizeof($arrayAttributes); $i++) { 

								// Verifico si el atributo que estoy analizando corresponde al tipo
								// de evento que dispara la policy
								if(strpos($arrayAttributes[$i], 'type')){

									//Si lo es, obtengo ese valor
									$whenToRun->type = $arrayAttributes[$i];

									// Le quito el tag que tenia para quedarme unicamente con el valor 
									// que contenia
									$whenToRun->type = str_replace('name="type">','',$whenToRun->type);
								}

								// Verifico si el atributo que estoy analizando corresponde al Momento
								// en que dispara la policy
								if(strpos($arrayAttributes[$i], 'step')){

									// Si lo es, obtengo ese valor
									$whenToRun->step = $arrayAttributes[$i];

									// Le quito el tag que tenia para quedarme unicamente con el valor que
									// contenia
									$whenToRun->step = str_replace('name="step">','',$whenToRun->step);
								}

								// Verifico si el atributo que estoy analizando corresponde al nombre del evento
								// en el que se dispara y si el nombre de ese evento es exactamente igual
								// al nombre de la tarea que estoy buscando
								if(strpos($arrayAttributes[$i], 'eventName') && preg_match("~\b$task\b~",$arrayAttributes[$i])){

									// Si lo es, obtengo ese valor
									$whenToRun->event = $arrayAttributes[$i];

									// Le quito el tag que tenia para quedarme unicamente con el valor que
									// contenia
									$whenToRun->event = str_replace('name="eventName">','',$whenToRun->event);

								}
								
							}

							// Verifico si el objecto que estoy analizando es solucion de mi problema
							if (!is_null($whenToRun->event)){

								// Si lo es, lo guardo array
								array_push($auxArray, $whenToRun);

							}
						}
					}
	    		}

	    		// Ordeno el resultado obtenido antes de mostrar por pantalla
	    		// como parametro se envia lo que se quiere ordenar y la funcion
	    		// de comparacion que se quiere ejecutar, en este caso se ejecutara
	    		// la funcion compare()
	    		uasort ($auxArray,"compare");

	    		// Verifico si la tarea encontrada, tiene policies asociadas
	    		if (sizeof($auxArray) > 0) {
	    		

		    		// Muestro el resultado por pantalla		    	
			    	foreach ($auxArray as $resultado) {
			    		
		?>
			    		<tr>
			    			<td><?php echo $resultado->managedObjectType; ?></td>
							<td><?php echo $resultado->friendlyName; ?></td>
							<td><?php echo $resultado->category ?></td>
							<td style="text-align: center;"><?php echo $resultado->attributeTypeValue; ?></td>
							<td><?php echo $resultado->type; ?></td>
							<td><?php echo $resultado->step; ?></td>
							<td style="text-align: center;"><?php echo $resultado->priority; ?></td>
		<?php
							if ($resultado->status == 'true'){
		?>
								<td class="status" style="background-color: #00e500;"></td>
		<?php				
							}else{
		?>
								<td class="status" style="background-color: red;"></td>
		<?php				
							}
		?>
			    		</tr>
		<?php
			    	}

		    	}else{
		?>
					<tr>
						<td colspan="8" style="text-align: center;">Results Not Found</td>
					</tr>
		<?php
		    	}

		    // Si la tarea no existe en mi universo de tareas muestro una tabla vacia
		    //}else{
	}else{

			// Verifico si existen posibles soluciones
			if (sizeof($suggestArray)>0) {
			?>
				<div class="alert alert-secondary" role="alert"><b><?php echo $task ?></b> Not Found. Here are some suggestions</div>
				<table class="table table-hover table-dark table-bordered" id="task_table">
				  <thead>
				    <tr>
				      <th>Task Name</th>
				      <th>Task Tag</th>
				    </tr>
				  </thead>
				  <tbody>
						<?php  

							foreach ($suggestArray as $resultado) {
						?>
								<tr>
									<td><?php echo $resultado->name; ?></td>
									<td><a href="searchTask.php?task=<?php echo $resultado->tag;?>"><?php echo $resultado->tag; ?></a></td>
								</tr>
						<?php
							}
						?>
				  </tbody>
				</table>

			<?php

			// Si no existen posibles soluciones entonces muestro una tabla vacia
			}else{
			?>
				<table class="table table-hover table-dark table-bordered" id="task_table">
				  <thead>
				    <tr>
				      <th>Managed Object Type</th>
				      <th>Managed Object Friendly Name</th>
				      <th>Category</th>
				      <th>Attribute Type Value</th>
				      <th>Type</th>
				      <th>Step</th>
				      <th>Priority</th>
				      <th>Status</th>
				    </tr>
				  </thead>
				  <tbody>
						<tr>
							<td colspan="8" style="text-align: center;">Results Not Found</td>
						</tr>
				  </tbody>
				</table>
			<?php    	
			}
			    //}
	}
		    ?>
		  </tbody>
		</table>

<?php 
	require('export.php');
	require('footer.php'); 
?>