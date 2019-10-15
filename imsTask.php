<?php
	
	require('header.php');

	// Flag que indicara cuando se cambio de ImsTask, como es el primer elemento siempre tiene
	// que cambiar de fila para agregar el nuevo elemento
	$finalizo = true;

	// Levantamos el XML
	$objDOM = new DOMDocument();
	$objDOM->load("YourXMLName.xml");

	// Atributo Buscado
	$attribute = $_GET['attribute'];
	$searchAttribute = '%'.$attribute.'%';

?>
	<table class="table table-hover table-dark table-bordered" id="task_table">
	  <thead>
	    <tr>
	      <th>Attribute: <?php echo $searchAttribute; ?></th>
	      <th>Task Name</th>
	      <th>Business Logic Task Handler Name</th>
	    </tr>
	  </thead>
	  <tbody>
	    
	    <?php

	    	// Obtengo todos los ImsTask
	    	$imsTask = $objDOM->getElementsByTagName("ImsTask");
	    	
	    	foreach ($imsTask as $searchImsTask) {
	    		
	    		// Obtengo el nombre de cada ImsTask
    			$imsTaskName = $searchImsTask->getAttribute('name');
					
				// Busco todas las Property de cada ImsTask
				foreach ($searchImsTask->getElementsByTagName("Property") as $searchTaskProperty){

					// Verifico si esta Property contiene el atributo que estoy buscando
			    	
			    	if ($searchTaskProperty->nodeValue == $searchAttribute && $finalizo){
			    	//if ($searchTaskProperty->nodeValue == '%EMP_TYPE%' && $finalizo){
		?>
						<!-- 
							Si estoy analizando una nueva, debo agregarla en la tabla junto a la Tarea 
						-->
				    	<tr>
				    		<td></td>
				    		<td><?php echo $imsTaskName; ?></td>
				    		<td></td>
				    	</tr>
		<?php

						$finalizo = false;
					}
				}

				// Busco todos los Business Logic Task Handler de cada ImsTask
				foreach ($searchImsTask->getElementsByTagName("BusinessLogicTaskHandler") as $searchBusinessLogicTaskHandler){

					// Verifico si ese Business Logic Task Handler contiene el valor que estoy buscando
					// strpos busca si existe el subString especifico (en este caso %EMP_TYPE%) dentro de otro String
					// (en este caso, como valor en algun tag BusinessLogicTaskHandler)
			    	
			    	if (strpos($searchBusinessLogicTaskHandler->nodeValue, $searchAttribute) && $finalizo){
			    	//if (strpos($searchBusinessLogicTaskHandler->nodeValue, '%EMP_TYPE%') && $finalizo){
?>
						<tr>
							<td></td>
				    		<td><?php echo $imsTaskName; ?></td>
				    		<td><?php echo $searchBusinessLogicTaskHandler->getAttribute('name'); ?></td>
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