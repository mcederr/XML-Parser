<?php
	
	require('header.php');

	set_time_limit(300);

	$environmentName = $_GET['environment'];

	$objDOM = new DOMDocument();
	$objDOM->load($environmentName);

	$screenTableArray = array();

	// Obtengo todas las Pantallas
	$screens = $objDOM->getElementsByTagName("Screen");
	$tasks = $objDOM->getElementsByTagName("ImsTask");

	foreach ($screens as $searchScreens) {
		
		foreach ($searchScreens->getElementsByTagName("ScreenField") as $searchTablesInScreenFields) {
			
			if (stripos($searchTablesInScreenFields->getAttribute('attribute'),'tbl') !== false) {
			
				array_push($screenTableArray, $searchTablesInScreenFields->getAttribute('attribute'));

			}
		}
	}

	foreach ($tasks as $searchTasks) {
		
		foreach ($searchTasks->getElementsByTagName("Property") as $searchTablesInTaskProperty) {

			//if (stripos($searchTablesInTaskProperty->getAttribute('name'),'SourceObjectAttribute') !== false) {
			if (stripos($searchTablesInTaskProperty->getAttribute('name'),'SourceObjectAttribute') !== false && stripos($searchTablesInTaskProperty->nodeValue,'tbl') !== false) {

				array_push($screenTableArray, $searchTablesInTaskProperty->nodeValue);
			}

		}
	}

	$screenTableArray = array_unique($screenTableArray);

?>
	<div class="row">
	    <div class="col">
			<table class="table table-hover table-dark table-bordered">
				<thead>
				  	<tr>
				  		<th>Tables</th>
				  	</tr>
				    <tr>
				      <th>Screen Name</th>
				    </tr>
			  	</thead>
			  	<tbody>
			  		
			  		<?php

			  			foreach ($screenTableArray as $solution) {
			  				
			  		?>
			  				
			  				<tr>
			  					<td><?php echo $solution; ?></td>
			  				</tr>

			  		<?php		
			  			}

			  		?>
			  	</tbody>
			</table>
		</div>
	</div>
<?php 
require('export.php');
require('footer.php'); ?>