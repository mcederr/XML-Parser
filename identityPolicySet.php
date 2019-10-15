<?php
	
	require('header.php');

	// Flag que indicara cuando se cambio de Identity Policy Set, como es el primer elemento siempre tiene
	// que cambiar de fila para agregar el nuevo elemento
	$finalizo = true;

	// Flag que indicara si se esta analizando o no Attribute Expressions de una misma Identity Policy
	// Al principio siempre se indica que no se esta analizando la misma
	$mismaIdentityPolicy = false;

	// Flag que indicara si se esta analizando o no Admin Attribute Expressions de una misma Identity Policy
	// Al principio siempre se indica que no se esta analizando la misma
	$mismAdminAttributeExpression = false;

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
	      <th>Identity Policy Set</th>
	      <th>Identity Policy</th>
	    </tr>
	  </thead>
	  <tbody>
	    
	    <?php

	    	// Obtengo todos los Identity Policy Set
	    	$identityPoliciesSet = $objDOM->getElementsByTagName("IdentityPolicySet");
	    	
	    	foreach ($identityPoliciesSet as $searchIdentityPolicySet) {
	    	
	    		// Obtengo el nombre de cada Identity Policie Set
    			$identityPolicieSetName = $searchIdentityPolicySet->getAttribute('name');

    			// Buscos todas las Identity Policies asociadas al Identity Policie Set
    			foreach ($searchIdentityPolicySet->getElementsByTagName("IdentityPolicy") as $searchIdentityPolicies){
		
					// Obtengo el nombre de cada Identity Policie asociada al Identity Policie Set
					$identityPoliciesName = $searchIdentityPolicies->getAttribute('name');

					// Busco todos los Attribute Expression
					foreach ($searchIdentityPolicies->getElementsByTagName("AttributeExpression") as $searchAttributeExpression){

						// Obtengo el nombre del atributo de cada Attribute Expression
						$attributeExpressionAttributeName = $searchAttributeExpression->getAttribute('attribute');

						// Verifico si esta Identity Policie contiene el atributo que estoy buscando
			    		
			    		if ($attributeExpressionAttributeName == $searchAttribute && !$mismaIdentityPolicy){
			    		//if ($attributeExpressionAttributeName == '%EMP_TYPE%'){
			    			
			    			// Verifico si estoy analizando una nueva Identity Policy Set o estoy sobre la misma
			    			if ($finalizo){
		?>
								<!-- 
									Si estoy analizando una nueva, debo agregarla en la tabla junto a la Identity Policy 
								-->
				    			<tr>
				    				<td style="background-color: red"><?php echo $identityPolicieSetName; ?></td>
				    				<td><?php echo $identityPoliciesName; ?></td>
				    			</tr>
		<?php
								// Indico que, las Identity Policies que se estan analizando en este momento corresponden
								// al mismo Identity Policy Set
								$finalizo = false;

			    			}else{
		?>
								<!-- 
									Si estoy analizando Identity Policies de una misma Identity Policy Set,
									entonces solo tengo que agregar a la tabla el nombre de la Identity Policy
								-->
			 					<tr>
				    				<td></td>
				    				<td><?php echo $identityPoliciesName; ?></td>
				    			</tr>
				    			
		<?php
		
			    			}
			    			$mismaIdentityPolicy = true;
			    		}
					}
					$mismaIdentityPolicy = false;

					foreach ($searchIdentityPolicies->getElementsByTagName("AdminAttributeExpression") as $searchAdminAttributeExpression){

						// Obtengo el nombre del atributo de cada Attribute Expression
						$attributeAdminExpressionAttributeName = $searchAdminAttributeExpression->getAttribute('attribute');

						// Verifico si esta Identity Policie contiene el atributo que estoy buscando
			    		
			    		if ($attributeAdminExpressionAttributeName == $searchAttribute && !$mismAdminAttributeExpression){
		?>
							<tr>
				    			<td></td>
				    			<td><?php echo $identityPoliciesName; ?></td>
				    		</tr>
		<?php
							$mismAdminAttributeExpression = true;
						}
					}
					$mismAdminAttributeExpression = false;
				}

				$finalizo = true;
	    	}
	    
	    ?>

	  </tbody>
	</table>
	

<?php 
require ('export.php');
require ('footer.php'); ?>