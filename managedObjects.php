<?php
	
	require('header.php');

	// Flag que indicara cuando se cambio de ImRole, como es el primer elemento siempre tiene
	// que cambiar de fila para agregar el nuevo elemento
	$finalizo = true;

	// Levantamos el XML
	$objDOM = new DOMDocument();
	$objDOM->load("YourXMLName.xml");

	// Atributo Buscado
	$attribute = $_GET['attribute'];
	$searchAttribute = '%'.$attribute.'%';

?>
	<table class="table table-hover table-dark table-bordered">
	  <thead>
	    <tr>
	      <th>Type</th>
	      <th>Friendly Name</th>
	    </tr>
	  </thead>
	  <tbody>
	    
	    <?php

	    	// Obtengo todos los ManagedObjects
	    	$managedObject = $objDOM->getElementsByTagName("ManagedObject");
	    	
	    	foreach ($managedObject as $searchManagedObject) {
	    		
	    		// Obtengo el nombre de cada ManagedObject
    			$managedObjectType = $searchManagedObject->getAttribute('type');
    			$managedObjectName = $searchManagedObject->getAttribute('friendlyName');

				// Busco todas las Property de cada ManagedObject
				foreach ($searchManagedObject->getElementsByTagName("Attribute") as $searchManagedObjectAttribute){

					// Verifico si esta Property contiene el atributo que estoy buscando
			    	//if ($searchManagedObjectAttribute->nodeValue == '%EMP_TYPE%' && $finalizo){
		?>
						<!-- 
							Si estoy analizando una nueva, debo agregarla en la tabla junto a la Tarea 
						-->
				    <!--	<tr>
				    		<td><?php echo $searchManagedObject->getAttribute('type'); ?></td>
				    		<td><?php echo $managedObjectName; ?></td>
				    	</tr>-->
		<?php

					//}

					// Verifico si esta Property contiene el atributo que estoy buscando
			    	
			    	if (strpos($searchManagedObjectAttribute->nodeValue, $searchAttribute) && $finalizo){
			    	//if (strpos($searchManagedObjectAttribute->nodeValue, '%EMP_TYPE%') && $finalizo){
?>
						<tr>
				    		<td><?php echo $managedObjectType; ?></td>
				    		<td><?php echo $managedObjectName; ?></td>
				    	</tr>
<?php

			    	$finalizo = false;
			    	}


				}

	    		$finalizo = true;
	    	}
	    
	    ?>

	  </tbody>
	</table>
<?php 
require('export.php');
require('footer.php'); ?>