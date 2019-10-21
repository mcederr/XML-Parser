<?php 
	
	$objectType = $_POST['objectType'];
	$attribute = $_POST['attribute'];

	$environmentXML = $_POST['environment'];
	
	$attribute = strtoupper($attribute);
	
	switch ($objectType) {
		
		case 'Screens':

			header('Location: ../screens.php?attribute='.$attribute.'&'.'environment='.$environmentXML);

			break;

		case 'Identity Policy Set':
			
			header('Location: ../identityPolicySet.php?attribute='.$attribute.'&environment='.$environmentXML);

			break;

		case 'Role':
			
			header('Location: ../imsRole.php?attribute='.$attribute.'&environment='.$environmentXML);
			
			break;

		case 'Task':
			
			header('Location: ../imsTask.php?attribute='.$attribute.'&environment='.$environmentXML);
			
			break;

		case 'Others':
			
			header('Location: ../managedObjects.php?attribute='.$attribute.'&environment='.$environmentXML);

			break;
	}

?>