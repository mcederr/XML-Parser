<?php 
	
	$objectType = $_POST['objectType'];
	$attribute = $_POST['attribute'];

	
	$attribute = strtoupper($attribute);
	
	switch ($objectType) {
		
		case 'Screens':

			header('Location: ../screens.php?attribute='.$attribute);

			break;

		case 'Identity Policy Set':
			
			header('Location: ../identityPolicySet.php?attribute='.$attribute);

			break;

		case 'Role':
			
			header('Location: ../imsRole.php?attribute='.$attribute);
			
			break;

		case 'Task':
			
			header('Location: ../imsTask.php?attribute='.$attribute);
			
			break;

		case 'Others':
			
			header('Location: ../managedObjects.php?attribute='.$attribute);

			break;
	}

?>