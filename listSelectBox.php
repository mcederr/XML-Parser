<?php
	
	require('header.php');

	// Atributo Buscado
	$environmentName = $_GET['environment'];

	$selectBoxArray = array();
	$suggestionsArray = array();
	$taskArray = array();

	$objDOM = new DOMDocument();
	$objDOM->load($environmentName);

	$screens = $objDOM->getElementsByTagName('Screen');

	foreach ($screens as $searchScreens) {
		
		foreach ($searchScreens->getElementsByTagName('Property') as $searchSelectBoxInScreenProperties) {
			
			// Verifico si la Property que estoy analizando es el Select Box que estoy buscando
			if ($searchSelectBoxInScreenProperties->getAttribute('name') == 'auxDataPath' && $searchSelectBoxInScreenProperties->nodeValue  != "") {

				$searchSelectBoxInScreenProperties->nodeValue = str_replace('[', "", $searchSelectBoxInScreenProperties->nodeValue);
				$searchSelectBoxInScreenProperties->nodeValue = str_replace('"', "", $searchSelectBoxInScreenProperties->nodeValue);
				$searchSelectBoxInScreenProperties->nodeValue = str_replace(']', "", $searchSelectBoxInScreenProperties->nodeValue);
				array_push($selectBoxArray, $searchSelectBoxInScreenProperties->nodeValue);
			
			}

		}

	}

	$selectBoxArray = array_unique($selectBoxArray);

?>
	<div class="alert alert-primary" role="alert">
		<dl class="row">
			<dt class="col-sm-3">Screens Results:</dt>
			<dd class="col-sm-9"><?php echo sizeof($selectBoxArray); ?></dd>
		</dl>
	</div>
	
	<table class="table table-hover table-dark table-bordered">
		<thead>

		  	<tr>
		  		<th>Select Box</th>
		  	</tr>
		    <tr>
		      <th>Name</th>
		    </tr>
		
		</thead>
		
		<tbody>
		
		<?php

	    	if (sizeof($selectBoxArray) > 0) {
	    		
	    		foreach ($selectBoxArray as $solution) {

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