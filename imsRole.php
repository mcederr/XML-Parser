<?php
	
	require('header.php');

	// Como se deben analizar muchos roles, php tiene por default seteado un tiempo de ejecucion de 30 seg
	// por lo cual, no puede encontrar todos los roles. Para resolver esto se cambio el tiempo de ejecucion
	// de 30 seg a 5 minutos
	set_time_limit(300);

	// Flag que indicara cuando se cambio de ImRole, como es el primer elemento siempre tiene
	// que cambiar de fila para agregar el nuevo elemento
	$finalizo = true;

	// Flag que indicara si se esta analizando o no Attribute Expressions de una misma Identity Policy
	// Al principio siempre se indica que no se esta analizando la misma
	$mismaAttributeExpression = false;

	// Flag que indicara si se esta analizando o no Admin Attribute Expressions de una misma Identity Policy
	// Al principio siempre se indica que no se esta analizando la misma
	$mismAdminAttributeExpression = false;

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
	      <th>Role Name</th>
	    </tr>
	  </thead>
	  <tbody>
	    
	    <?php

	    	// Obtengo todos los ImsRole
	    	$imsRoles = $objDOM->getElementsByTagName("ImsRole");
	    	
	    	foreach ($imsRoles as $searchImsRoles) {
	    		
	    		// Obtengo el nombre de cada ImsRole
    			$imsRoleName = $searchImsRoles->getAttribute('name');

    			// Buscos todas las Identity Policies asociadas al Identity Policie Set
    			//foreach ($searchImsRoles->getElementsByTagName("MemberPolicy") as $searchMemberPolicies){
		
					// Busco todos los Attribute Expression
					foreach ($searchImsRoles->getElementsByTagName("AttributeExpression") as $searchAttributeExpression){

						// Obtengo el nombre del atributo de cada Attribute Expression
						$attributeExpressionAttributeName = $searchAttributeExpression->getAttribute('attribute');

						// Verifico si esta Identity Policie contiene el atributo que estoy buscando
			    		
			    		if ($attributeExpressionAttributeName == $searchAttribute && !$mismaAttributeExpression){
			    		//if ($attributeExpressionAttributeName == '%EMP_TYPE%'){
			    			
			    			// Verifico si estoy analizando una nueva Identity Policy Set o estoy sobre la misma
			    			if ($finalizo){
		?>
								<!-- 
									Si estoy analizando una nueva, debo agregarla en la tabla junto a la Identity Policy 
								-->
				    			<tr>
				    				<td><?php echo $imsRoleName; ?></td>
				    			</tr>
		<?php
								// Indico que, las Identity Policies que se estan analizando en este momento corresponden
								// al mismo Identity Policy Set
								$finalizo = false;
		
			    			
			    			}
						}
						$mismaAttributeExpression = true;
					}
					$mismaAttributeExpression = false;
	    		//}

	    			$finalizo = true;

		    		// Busco todos los Admin Attribute Expression
					foreach ($searchImsRoles->getElementsByTagName("AdminAttributeExpression") as $searchAdminAttributeExpression){

						if ($searchAdminAttributeExpression->getAttribute('attribute') == $searchAttribute && !$mismAdminAttributeExpression){
		?>
							<tr>
					    		<td><?php echo $imsRoleName; ?></td>
					    	</tr>
		<?php
							$mismAdminAttributeExpression = true;
						}

					}
					$mismAdminAttributeExpression = false;
	    	}
	    
	    ?>

	  </tbody>
	</table>
		

<?php
require('export.php'); 
require('footer.php'); ?>