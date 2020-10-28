<?php
	
	require('header.php');
	require_once('Classes/UserDirectory.php');

	$solArray = array();

	// Levantamos el XML de Advanced Settings
	$objDOM = new DOMDocument();
	$objDOM->load("Files/itau_environment_settings.xml");

	// Obtengo todos los Logical Handlers
	$provisioning = $objDOM->getElementsByTagName("Provisioning");

	// Verifico si existe la clase buscada dentro de mi universo de pantallas
	foreach ($provisioning as $searchProvisioning){
		
		// Busco todas las Property de cada Screen
		foreach ($searchProvisioning->getElementsByTagName("ProvisioningAttrMapping") as $searchAttributes){

			if ($searchAttributes->getAttribute("userattr") != "" || $searchAttributes->getAttribute("provisionattr") != ""){ 

				$solution = new UserDirectory();
				$solution->usrAttr = $searchAttributes->getAttribute("userattr");
				$solution->provAttr = $searchAttributes->getAttribute("provisionattr");

				array_push($solArray, $solution);
			}

   		}

   		// Busco todas las Property de cada Screen
		foreach ($searchProvisioning->getElementsByTagName("ProvisioningAttrMapping") as $searchAttributes){

			if ($searchAttributes->getAttribute("imsevent") != "" || $searchAttributes->getAttribute("provisioningevent") != ""){ 
				
				$solution = new UserDirectory();
				$solution->usrAttr = $searchAttributes->getAttribute("imsevent");
				$solution->provAttr = $searchAttributes->getAttribute("provisioningevent");

				array_push($solArray, $solution);
			}

   		}
   	}

   	//$solArray = array_unique($solArray);
   		
?>		
	<div class="alert alert-primary" role="alert">
			<dl class="row">
				<dt class="col-sm-3">Directory Attributes Results:</dt>
				<dd class="col-sm-9"><?php echo sizeof($solArray); ?></dd>
			</dl>
		</div>
		
		<table class="table table-hover table-dark table-bordered">
			<thead>

			  	<tr>
			  		<th colspan="2">DIRECTORY ATTRIBUTES</th>
			  	</tr>
			    <tr>
			      <th>Directory Name</th>
			      <th>Provisioning Name</th>
			    </tr>
			
			</thead>
			
			<tbody>
			
			<?php

		    	if (sizeof($solArray) > 0) {
		    		
		    		foreach ($solArray as $solution) {

		    ?>
						<tr>
							<td><?php echo $solution->usrAttr; ?></td>
							<td><?php echo $solution->provAttr; ?></td>
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
require('footer.php'); ?>