<?php
	
	require('header.php');

	// Flag que indicara cuando se cambio de Screen, como es el primer elemento siempre tiene
	// que cambiar de fila para agregar el nuevo elemento
	$finalizo = true;

	// Atributo Buscado
	$attribute = $_GET['attribute'];
	$searchAttribute = '%'.$attribute.'%';
	$environmentName = $_GET['environment'];

	$objDOM = new DOMDocument();
	$objDOM->load($environmentName);

?>
	<div class="alert alert-primary" role="alert">
		<dl class="row">
			<dt class="col-sm-3">Attribute:</dt>
			<dd class="col-sm-9"><?php echo $attribute; ?></dd>
		</dl>
	</div>

	<table class="table table-hover table-dark table-bordered">
	  <thead>
	    <tr>
	      <th>Screen Name</th>
	      <th>Screen Tag</th>
	    </tr>
	  </thead>
	  <tbody>
	    
	    <?php

	    	// Obtengo todas las Pantallas
	    	$screens = $objDOM->getElementsByTagName("Screen");
	    	//$screens = $environmentXML->getElementsByTagName("Screen");
	    	
	    	foreach ($screens as $searchScreens) {
	    	
	    		// Obtengo los atributos utilizados por cada pantalla
    			$screenName = $searchScreens->getAttribute('name');
    			$screenTag = $searchScreens->getAttribute('tag');

    			// Busco las pantallas que utilicen el atributo especifico
    			foreach ($searchScreens->getElementsByTagName("ScreenField") as $searchScreenFields){
					
					if ($searchScreenFields->getAttribute('attribute') == $searchAttribute && $finalizo){
		    		//if ($searchScreenFields->getAttribute('attribute') == '%EMP_TYPE%' && $finalizo){

		   ?>
		   				<tr>
		   					<td><?php echo $screenName; ?></td>
		   					<td><?php echo $screenTag; ?></td>
		   				</tr>
		<?php
						$finalizo = false;
		    		}
		    	}

		    	// Busco las pantallas que utilicen el atributo especifico en alguna propiedad
    			foreach ($searchScreens->getElementsByTagName("Property") as $searchProperty){

    				if ($searchProperty->nodeValue == $searchAttribute && $finalizo){
    				//if ($searchProperty->nodeValue == '%EMP_TYPE%' && $finalizo){
?>
    					<tr>
		   					<td><?php echo $screenName; ?></td>
		   					<td><?php echo $screenTag; ?></td>
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