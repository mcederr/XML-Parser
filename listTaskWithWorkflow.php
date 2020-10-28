<?php
	
	require('header.php');
	require_once('Classes/Task.php');
	require_once('Classes/Event.php');

	// Atributo Buscado
	$environmentName = $_GET['environment'];

	$found = false;

	$tasksArray = array();

	$objDOM = new DOMDocument();
	$objDOM->load($environmentName);

	$task = $objDOM->getElementsByTagName('ImsTask');

	$arrayTaskEventWorkFlows = array();

	foreach ($task as $searchTask) {
		
		$aux = $searchTask->getElementsByTagName('Property');
		$finish = false;

		// Busco si hay workflows de eventos (por policies, etc)
		for ($i =0; $i < sizeof($aux);$i++){

			$taskEventWorkFlows = new Event();

			// Si la property que analizo tiene la palabra "event" en el nombre, no contiene un "." y el valor que contiene ese tag es un string
			if (stripos($aux[$i]->getAttribute('name'),'event') !== false && strpos($aux[$i]->getAttribute('name'),'.') === false && is_numeric($aux[$i]->nodeValue) == false){

				if ($finish == false){

					/*
					
					echo "-------------------------------- <br>";
					echo "Tarea: ".$searchTask->getAttribute('name');
					echo "<br>";

					*/
					
					$finish = true;

				}

				/*
				
				echo "PropertyName: ".$aux[$i]->getAttribute('name');
				echo "<br>";
				echo "TagValue: ".$aux[$i]->nodeValue;
				echo "<br>";

				*/
				

				$taskEventWorkFlows->taskName = $searchTask->getAttribute('name');
				$taskEventWorkFlows->event = $aux[$i]->getAttribute('name');
				$taskEventWorkFlows->workFlow = $aux[$i]->nodeValue;
				array_push($arrayTaskEventWorkFlows, $taskEventWorkFlows);

			}

			if (stripos($aux[$i]->getAttribute('name'),'Event.selectedWorkFlowType') !== false){
				
				

				if ($finish == false){
					
					/*
					echo "-------------------------------- <br>";
					echo "Tarea: ".$searchTask->getAttribute('name');
					echo "<br>";
					*/
					
					$finish = true;
					
				}
				
				

				if (is_numeric($aux[$i+1]->nodeValue) == false){

					//echo "WorkFlow: ".$aux[$i+1]->nodeValue;
					//echo "<br>";

					$taskEventWorkFlows->taskName = $searchTask->getAttribute('name');
					$taskEventWorkFlows->workFlow = $aux[$i+1]->nodeValue;
				
				}else{
					
					/*
					echo "WorkFlow: ".$aux[$i]->nodeValue;
					echo "<br>";
					*/

					$taskEventWorkFlows->taskName = $searchTask->getAttribute('name');
					$taskEventWorkFlows->workFlow = $aux[$i]->nodeValue;

				}

				if ($i>0 && is_numeric($aux[$i-1]->nodeValue) == true){

				/*	

					echo "EventName: ".str_replace("Event.selectedWorkFlowType","",$aux[$i]->getAttribute('name'));
					echo "<br>";
					echo "EventWorkFlow: ".$aux[$i]->nodeValue;
					echo "<br>";
				*/	
					

					$taskEventWorkFlows->taskName = $searchTask->getAttribute('name');
					$taskEventWorkFlows->event = str_replace("Event.selectedWorkFlowType","",$aux[$i]->getAttribute('name'));
					$taskEventWorkFlows->workFlow = $aux[$i]->nodeValue;

				}

				array_push($arrayTaskEventWorkFlows, $taskEventWorkFlows);
				//echo "<br>";
			
			}


		}

		foreach ($searchTask->getElementsByTagName('Property') as $searchWorkflowInTaskProperties) {
			
			// Busco si existen tareas con WorkFlows asociados (independientemente de si son de tareas o eventos)
			if (stripos($searchWorkflowInTaskProperties->getAttribute('name'),'WORKFLOW') !== false && $searchWorkflowInTaskProperties->nodeValue  != "" && $found == false) {

				// Obtengo el nombre de cada Tarea
		    	$taskName = $searchTask->getAttribute('name');
		    	$taskDescription = $searchTask->getAttribute('description');
		    	$taskTag = $searchTask->getAttribute('tag');

		    	$solution = new Task();
				$solution->name = $taskName;
				$solution->description = $taskDescription;
				$solution->tag = $taskTag;
				$solution->taskWorkFlows = " ";

				// Busco si hay workflows de tareas
				if (stripos($searchWorkflowInTaskProperties->getAttribute('name'),'WORKFLOW_PROCESS') !== false && $found == false){
					
					$solution->taskWorkFlows = $searchWorkflowInTaskProperties->nodeValue;
				
				}

				// Busco si hay workflows de eventos (por policies, etc)
				if (stripos($searchWorkflowInTaskProperties->getAttribute('name'),'WorkFlowType') !== false && $found == false){

					//echo "Evento: ".$searchWorkflowInTaskProperties->nodeValue;

				}

				array_push($tasksArray, $solution);

				$found = true;
			
			}

		}

		$found = false;

	}

	// Asocio todos los eventos con las tareas correspondientes
	foreach ($tasksArray as $tasks) {
		
		foreach ($arrayTaskEventWorkFlows as $eventWorkFlows) {

			if ($eventWorkFlows->taskName == $tasks->name){

				array_push($tasks->eventWorkflows, $eventWorkFlows);

			}

		}

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
		  		<th colspan="6">TASKS</th>
		  	</tr>
		    <tr>
		      <th>NAME</th>
		      <th>DESCRIPTION</th>
		      <th>TAG</th>
		      <th>TASK WORKFLOW</th>
		      <th>EVENT</th>
		      <th>EVENT WORKFLOW</th>
		    </tr>
		
		</thead>
		
		<tbody>
		
		<?php

	    	if (sizeof($tasksArray) > 0) {
	    		
	    		foreach ($tasksArray as $solution) {

	    			// Si la tarea no tiene workflows de eventos asociados
	    			if (sizeof($solution->eventWorkflows) == 0){

	    			
	    ?>
						<tr>
							<td><?php echo $solution->name; ?></td>
							<td><?php echo $solution->description; ?></td>
							<td><?php echo $solution->tag; ?></td>
							<td><?php echo $solution->taskWorkFlows; ?></td>
							<td></td>
							<td></td>
						</tr>
	    
	    <?php
	    			
	    			//Si la tarea tiene workflows de eventos asociados
	    			}else{
	    				
	    				$finalizo = true;

	    				foreach ($solution->eventWorkflows as $eventWorkflow) {

	    					if ($finalizo){

	    ?>

	    						<tr>
									<td><?php echo $solution->name; ?></td>
									<td><?php echo $solution->description; ?></td>
									<td><?php echo $solution->tag; ?></td>
									<td><?php echo $solution->taskWorkFlows; ?></td>
									<td><?php echo $eventWorkflow->event; ?></td>
									<td><?php echo $eventWorkflow->workFlow; ?></td>
								</tr>

	    <?php

	    						$finalizo = false;

	    					}else{

	    ?>

	    						<tr>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td><?php echo $eventWorkflow->event; ?></td>
									<td><?php echo $eventWorkflow->workFlow; ?></td>
								</tr>

	    <?php

	    					}

	    				}	
	    
	    			}

	    		}

	    	}else{

	    ?>
	    			<tr>
						<td colspan="6" style="text-align: center;">Results Not Found</td>
					</tr>
		<?php
				
			}
	    ?>

	  </tbody>
	</table>
<?php 
require('export.php');
require('footer.php'); ?>