<?php
	
	require('header.php');
	require_once('Classes/PolicyExpress.php');
	require_once('Classes/Event.php');

	// Atributo Buscado
	$event = $_GET['event'];
	$environmentName = $_GET['environment'];

	// Array Solucion
	$policiesArray = array();

	$foundPossibleSolution = false;

	$objDOM = new DOMDocument();
	$objDOM->load($environmentName);

	$policies = $objDOM->getElementsByTagName('ManagedObject');

	// Busco todas las policies express
	foreach ($policies as $searchPolicy){


		// Verifico si el Managed Object es una policy Express
		if ($searchPolicy->getAttribute('type') == 'POLICY XPRESS EXPORT'){

			// Si lo es, busco todos los Attributes de esa policy
			foreach ($searchPolicy->getElementsByTagName("Attribute") as $searchPolicyAttributes){

				// Obtengo el nombre de ese attribute
				$policyAttributeName = $searchPolicyAttributes->getAttribute('name');

				// Obtengo el valor de ese attribute
				$policyAttributeValue = $searchPolicyAttributes->nodeValue;

				// Verifico si el tipo de policy es de tipo "EVENT"
				if ($policyAttributeName == 'type' && $policyAttributeValue == 'EVENT' || $policyAttributeValue == 'TASK'){

					// Guardo el valor
					$policy = new PolicyExpress();
					$policy->name = $searchPolicy->getAttribute('friendlyName');
					$policy->type = $policyAttributeValue;
					
					// Marco que encontre una posible solucion
					$foundPossibleSolution = true;

				}

				// Si es de tipo evento, tengo que buscar todos los eventos asociados a dicha policy
				
				// Verifico si el nombre de ese atributo especifica cuando se ejecuta la policy
				if ($foundPossibleSolution && $policyAttributeName == 'whenToRun'){

					// Hago un split por atributo para obtener toda la informacion de la
					// especificacion
					$arrayAttributes = explode("<Attribute", $policyAttributeValue);

					//print_r($arrayAttributes);
					//echo "<br><br>";
					
					// Recorro todos los atributos obtenidos y busco la informacion que necesite
					for ($i=0; $i < sizeof($arrayAttributes); $i++) { 

						// Verifico si el atributo que estoy analizando corresponde al nombre del evento
						// en el que se dispara y si el nombre de ese evento es exactamente igual
						// al nombre del evento que estoy buscando
						if(strpos($arrayAttributes[$i], 'eventName') && preg_match("~\b$event\b~",$arrayAttributes[$i])){

							// Lo agrego como solucion
							array_push($policiesArray, $policy);
							$foundPossibleSolution = false;
						}
						
					}
				}
			}
   		}
   	}

?>

	<div class="alert alert-primary" role="alert">
		<dl class="row">
			<dt class="col-sm-3">Event:</dt>
			<dd class="col-sm-9"><?php echo $event; ?></dd>
			<dt class="col-sm-3">Results:</dt>
			<dd class="col-sm-9"><?php echo sizeof($policiesArray); ?></dd>
		</dl>
	</div>

	<table class="table table-hover table-dark table-bordered" id="task_table">
	  <thead>
	    <tr>
	      <th>Policy Name</th>
	      <th>Policy Type</th>
	    </tr>
	  </thead>
	  <tbody>
	    
		<?php

			if (sizeof($policiesArray)>0) {
				
				foreach ($policiesArray as $solution) {
		?>

					<tr>
				    	<td><?php echo $solution->name; ?></td>
				    	<td><?php echo $solution->type; ?></td>
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

<?php 
	
	require('export.php');
	require('footer.php'); 

?>