<?php
	
	require('header.php');

	// Atributo Buscado
	$environmentName = $_GET['environment'];

	$emailsArray = array();

	$objDOM = new DOMDocument();
	$objDOM->load($environmentName);

	$managedObject = $objDOM->getElementsByTagName('ManagedObject');

	foreach ($managedObject as $searchManagedObject) {

		// Obtengo el nombre de cada ManagedObject
    	$managedObjectType = $searchManagedObject->getAttribute('type');
    	$managedObjectName = $searchManagedObject->getAttribute('friendlyName');
		
		// Si es una Policy Xpress
		if ($managedObjectType == "EMAIL EXPORT"){

			// Lo agrego a mi array solucion
			array_push($emailsArray, $managedObjectName);
		}

	}

	$emailsArray = array_unique($emailsArray);

?>
	<div class="alert alert-primary" role="alert">
		<dl class="row">
			<dt class="col-sm-3">Emails Results:</dt>
			<dd class="col-sm-9"><?php echo sizeof($emailsArray); ?></dd>
		</dl>
	</div>
	
	<table class="table table-hover table-dark table-bordered">
		<thead>

		  	<tr>
		  		<th>EMAILS NOTIFICATIONS</th>
		  	</tr>
		    <tr>
		      <th>Name</th>
		    </tr>
		
		</thead>
		
		<tbody>
		
		<?php

	    	if (sizeof($emailsArray) > 0) {
	    		
	    		foreach ($emailsArray as $solution) {

	    ?>
					<tr>
						<td><?php echo $solution; ?></td>
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