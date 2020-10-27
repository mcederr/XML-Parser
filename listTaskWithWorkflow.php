<?php
	
	require('header.php');
	require_once('Classes/Task.php');

	// Atributo Buscado
	$environmentName = $_GET['environment'];

	$found = false;

	$tasksArray = array();

	$objDOM = new DOMDocument();
	$objDOM->load($environmentName);

	$task = $objDOM->getElementsByTagName('ImsTask');

	foreach ($task as $searchTask) {

		foreach ($searchTask->getElementsByTagName('Property') as $searchWorkflowInTaskProperties) {
			
			// Verifico si la Property que estoy analizando corresponde al Workflow de Tarea
			//if ($searchWorkflowInTaskProperties->getAttribute('name') == 'WORKFLOW_PROCESS' && $searchWorkflowInTaskProperties->nodeValue  != "") {
			
			//Si quiero los workflows a nivel tarea y evento busco la palabra Workflow tanto en tabs como en la property de "Config" de la tarea
			if (stripos($searchWorkflowInTaskProperties->getAttribute('name'),'WORKFLOW') !== false && $searchWorkflowInTaskProperties->nodeValue  != "" && $found == false) {


				// Obtengo el nombre de cada ManagedObject
		    	$taskName = $searchTask->getAttribute('name');
		    	$taskDescription = $searchTask->getAttribute('description');
		    	$taskTag = $searchTask->getAttribute('tag');

		    	$solution = new Task();
				$solution->name = $taskName;
				$solution->description = $taskDescription;
				$solution->tag = $taskTag;
				array_push($tasksArray, $solution);

				$found = true;
			
			}

		}

		$found = false;

	}

?>
	<div class="alert alert-primary" role="alert">
		<dl class="row">
			<dt class="col-sm-3">Tasks Results:</dt>
			<dd class="col-sm-9"><?php echo sizeof($tasksArray); ?></dd>
		</dl>
	</div>
	
	<table class="table table-hover table-dark table-bordered">
		<thead>

		  	<tr>
		  		<th colspan="3">TASKS</th>
		  	</tr>
		    <tr>
		      <th>Name</th>
		      <th>Description</th>
		      <th>Tag</th>
		    </tr>
		
		</thead>
		
		<tbody>
		
		<?php

	    	if (sizeof($tasksArray) > 0) {
	    		
	    		foreach ($tasksArray as $solution) {

	    ?>
					<tr>
						<td><?php echo $solution->name; ?></td>
						<td><?php echo $solution->description; ?></td>
						<td><?php echo $solution->tag; ?></td>
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
	    ?>

	  </tbody>
	</table>
<?php 
require('export.php');
require('footer.php'); ?>