<?php
	
	require('header.php');

	// Levantamos el XML
	$objDOM = new DOMDocument();
	$objDOM->load("YourXMLName.xml");

	// Atributo Buscado
	$screen = $_GET['screen'];

?>
	<table class="table table-hover table-dark table-bordered" id="task_table">
	  <thead>
	    <tr>
	      <th>Screen: <?php echo $screen; ?></th>
	      <th>Task Name</th>
	      <th>Task Tag Name</th>
	    </tr>
	  </thead>
	  <tbody>
	    
	    <?php

	    	// Obtengo todos los ImsTask
	    	$imsTask = $objDOM->getElementsByTagName("ImsTask");
	    	
	    	foreach ($imsTask as $searchImsTask) {
	    		
	    		// Obtengo el nombre de cada ImsTask
    			$imsTaskName = $searchImsTask->getAttribute('name');

    			$imsTaskTag = $searchImsTask->getAttribute('tag');
					
				// Busco todas las Property de cada ImsTask
				foreach ($searchImsTask->getElementsByTagName("Property") as $searchTaskProperty){

					$imsTaskPropertyAttributeName = $searchTaskProperty->getAttribute('name');

					// Verifico si la Property corresponde a la descripcion de una Pantalla
					// y si la misma es la pantalla que estoy buscando

					if ($imsTaskPropertyAttributeName == 'Screen' && $searchTaskProperty->nodeValue == $screen) {

		?>
						<!-- 
							Lo muestro por pantalla 
						-->
				    	<tr>
				    		<td></td>
				    		<td><?php echo $imsTaskName; ?></td>
				    		<td><?php echo $imsTaskTag; ?></td>
				    	</tr>
		<?php

					}
				}

	    	}
	    
	    ?>

	  </tbody>
	</table>
<?php 
require('export.php');
require('footer.php'); ?>