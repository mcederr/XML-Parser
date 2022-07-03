<?php require_once("header.php"); ?>
		
		<?php

			if (isset($_FILES['fileInput']) && ($_FILES['fileInput']['error'] == UPLOAD_ERR_OK)) {
    			
    			//$environmentXML = simplexml_load_file($_FILES['fileInput']['tmp_name']);	
    			
				//Obtengo el archivo cargado
    			$environmentXML = $_FILES['fileInput'];

    			//Lo guardo en la carpeta FILES
    			saveFileUploaded($environmentXML);

    			// Obtengo el nombre del archivo que guarde
    			$environmentXML = $environmentXML['name'];
			}

			/*if (isset($_FILES['fileInput']) && ($_FILES['fileInput']['error'] == UPLOAD_ERR_OK)) {

				// Obtengo el archivo que cargue
				$environment = $_FILES['fileInput'];

				// Si no existe la carpeta que va a contener los archivos del zip o del rar la creo en la carpeta FILES
				$file = 'Files/'.$environment['name'];
				
				if (!file_exists($file)) {
    				
    				mkdir($file, 0777, true);
				
				}

				// Extraigo el contenido del ZIP/RAR en la carpeta que se creo previamente
				$zipArchive = new ZipArchive();
				
				$result = $zipArchive->open($environment['name']);
				
				if ($result === TRUE) {
				    
				    $zipArchive ->extractTo("Files/".$environment['name']);
				    
				    $zipArchive ->close();
				
				}else{
				    
				    // Do something on error
				    echo "Fail To Extract Files";
				
				}
			}*/
		?>

		<br>
		<br>

		<div class="row">
	    	<div class="col">
				<h2><u>Search Object Type for Specific Attribute</u></h2>
				<br>
				<form action="Functions/process.php" method="POST">
					<div class="form-group row">
				    	<label class="col-sm-2 col-form-label">Attribute:</label>
				    	<div class="col-sm-10">
				    		<input type="text" class="form-control" name="attribute" required="true" placeholder="ex: FIRST_NAME">
				    	</div>
				  	</div>
				  	<div class="form-group row">
				    	<label class="col-sm-2 col-form-label">Object Type:</label>
				    	<div class="col-sm-10">
				    		<select class="form-control pointer" name="objectType"  required>
								<option value="">Select Object Type</option>
								<option>Screens</option>
								<option>Identity Policy Set</option>
								<option>Role</option>
								<option>Task</option>
								<option>Others</option>
							</select>
				    	</div>
				 	</div>
				  	<br>
				  	<div class="form-group row">
				    	<div class="col-sm-10">
				      		<button type="submit" class="btn btn-primary">Submit</button>
				    	</div>
				  	</div>
				  	<!--<input type="hidden" name="environment" value="<?php echo $environmentXML; ?>">-->
				  	<input type="hidden" name="environment" value="<?php echo $environment; ?>">
				</form>
	    	</div>

	    	<div class="col">
	    		<h2><u>Search Policies Express for Specific Task</u></h2>
				<br>
				<form action="searchTask.php" method="GET">
					<div class="form-group row">
				    	<label class="col-sm-2 col-form-label">Task/Tag Name:</label>
				    	<div class="col-sm-10">
				      		<input type="text" class="form-control" name="task" required="true">
				    	</div>
				  	</div>
				  	<br>
				  	<div class="form-group row">
				    	<div class="col-sm-10">
				      		<button type="submit" class="btn btn-primary">Submit</button>
				    	</div>
				  	</div>
					<input type="hidden" name="environment" value="<?php echo $environmentXML; ?>">
				</form>
	    	</div>
	    </div>

	    <div class="row">
	    	<div class="col">
				<h2><u>Search Tasks for Specific Screen</u></h2>
				<br>
				<form action="searchScreen.php" method="GET">
					<div class="form-group row">
				    	<label class="col-sm-2 col-form-label">Screen Name:</label>
				    	<div class="col-sm-10">
				      		<input type="text" class="form-control" name="screen" required="true">
				    	</div>
				  	</div>
				  	<br>
				  	<div class="form-group row">
				   		<div class="col-sm-10">
				      		<button type="submit" class="btn btn-primary">Submit</button>
				    	</div>
				  	</div>
				  	<input type="hidden" name="environment" value="<?php echo $environmentXML; ?>">
				</form>
	    	</div>
	    	
	    	<div class="col">
	    		<h2><u>Search JAVA Class</u></h2>
				<br>
				<form action="searchJavaClass.php" method="GET">
					<div class="form-group row">
				    	<label class="col-sm-2 col-form-label">Class Name:</label>
				    	<div class="col-sm-10">
				      		<input type="text" class="form-control" name="javaClass" required="true">
				    	</div>
				  	</div>
				  	<br>
				  	<div class="form-group row">
				    	<div class="col-sm-10">
				      		<button type="submit" class="btn btn-primary">Submit</button>
				    	</div>
				  	</div>
				  	<input type="hidden" name="environment" value="<?php echo $environmentXML; ?>">
				</form>		
	    	</div>
	    </div>

		<div class="row">
	    	<div class="col">
	    		<h2><u>Search Screens for Specific Select Box</u></h2>
				<br>
				<form action="searchSelectBox.php" method="GET">
					<div class="form-group row">
				    	<label class="col-sm-2 col-form-label">Select Box Name:</label>
				    	<div class="col-sm-10">
				      		<input type="text" class="form-control" name="selectBox" required="true">
				    	</div>
				  	</div>
				 	<br>
				  	<div class="form-group row">
				  		<div class="col-sm-10">
				      		<button type="submit" class="btn btn-primary">Submit</button>
				    	</div>
				  	</div>
				  	<input type="hidden" name="environment" value="<?php echo $environmentXML; ?>">
				</form>
	    	</div>

	    	<div class="col">
	    		<h2><u>Search Policies Express for Specific Event</u></h2>
				<br>
				<form action="searchEvent.php" method="GET">
					<div class="form-group row">
				    	<label class="col-sm-2 col-form-label">Event Name:</label>
				    	<div class="col-sm-10">
				      		<input type="text" class="form-control" name="event" required="true">
				    	</div>
				  	</div>
				 	<br>
				  	<div class="form-group row">
				  		<div class="col-sm-10">
				      		<button type="submit" class="btn btn-primary">Submit</button>
				    	</div>
				  	</div>
				  	<input type="hidden" name="environment" value="<?php echo $environmentXML; ?>">
				</form>
	    	</div>
	    </div>

	    <div class="row">

	    	<div class="col">
	    		<h2><u>List Select Box</u></h2>
				<br>
				<div class="form-group row">
					<div class="alert alert-secondary" role="alert">List all the Select Box in use</div>
				</div>
				<br>
				<div class="form-group row">
					<div class="col-sm-10">
						<a href="listSelectBox.php?environment=<?php echo $environmentXML; ?>"><button class="btn btn-primary">List Select Box</button></a>
				    </div>
				</div>
	    	</div>

	    	<div class="col">
	    		<h2><u>List Tables</u></h2>
				<br>
				<div class="form-group row">
					<div class="alert alert-secondary" role="alert">List all the Tables in use</div>
				</div>
				<br>
				<div class="form-group row">
					<div class="col-sm-10">
						<a href="listTables.php?environment=<?php echo $environmentXML; ?>"><button class="btn btn-primary">List Tables</button></a>
				    </div>
				</div>
	    	</div>

	    </div>

	    <div class="row">

	    	<div class="col">
	    		<h2><u>List Stored Procedures</u></h2>
				<br>
				<div class="form-group row">
					<div class="alert alert-secondary" role="alert">List all the Stored Procedures in use</div>
				</div>
				<br>
				<div class="form-group row">
					<div class="col-sm-10">
						<a href="listStoredProcedures.php?environment=<?php echo $environmentXML; ?>"><button class="btn btn-primary">List Stored Procedures</button></a>
				    </div>
				</div>
	    	</div>

	    	<div class="col">
	    		<h2><u>List Select Box</u></h2>
				<br>
				<div class="form-group row">
					<div class="alert alert-secondary" role="alert">List all the Select Box in Use With Screens and Tasks</div>
				</div>
				<br>
				<div class="form-group row">
					<div class="col-sm-10">
						<a href="listSelectBox2.php?environment=<?php echo $environmentXML; ?>"><button class="btn btn-primary">List Select Box</button></a>
				    </div>
				</div>
	    	</div>

	    </div>

	    <div class="row">
	    	
	    	<div class="col">
	    		<h2><u>List Policies Xpress</u></h2>
				<br>
				<div class="form-group row">
					<div class="alert alert-secondary" role="alert">List all the Policies Xpress</div>
				</div>
				<br>
				<div class="form-group row">
					<div class="col-sm-10">
						<a href="listPolicies.php?environment=<?php echo $environmentXML; ?>"><button class="btn btn-primary">List Policies</button></a>
				    </div>
				</div>
	    	</div>

	    	<div class="col">
	    		<h2><u>List Screens</u></h2>
				<br>
				<div class="form-group row">
					<div class="alert alert-secondary" role="alert">List all the Screens</div>
				</div>
				<br>
				<div class="form-group row">
					<div class="col-sm-10">
						<a href="listScreens.php?environment=<?php echo $environmentXML; ?>"><button class="btn btn-primary">List Screens</button></a>
				    </div>
				</div>
	    	</div>

	    </div>

	    <div class="row">
	    	
	    	<div class="col">
	    		<h2><u>List Tasks</u></h2>
				<br>
				<div class="form-group row">
					<div class="alert alert-secondary" role="alert">List all the Tasks</div>
				</div>
				<br>
				<div class="form-group row">
					<div class="col-sm-10">
						<a href="listTasks.php?environment=<?php echo $environmentXML; ?>"><button class="btn btn-primary">List Tasks</button></a>
				    </div>
				</div>
	    	</div>

	    	<div class="col">
	    		<h2><u>List Roles</u></h2>
				<br>
				<div class="form-group row">
					<div class="alert alert-secondary" role="alert">List all the Roles</div>
				</div>
				<br>
				<div class="form-group row">
					<div class="col-sm-10">
						<a href="listRoles.php?environment=<?php echo $environmentXML; ?>"><button class="btn btn-primary">List Roles</button></a>
				    </div>
				</div>
	    	</div>

	    </div>

	    <div class="row">
	    	
	    	<div class="col">
	    		<h2><u>List Emails Notifications</u></h2>
				<br>
				<div class="form-group row">
					<div class="alert alert-secondary" role="alert">List all the Emails Notifications</div>
				</div>
				<br>
				<div class="form-group row">
					<div class="col-sm-10">
						<a href="listEmailsNotifications.php?environment=<?php echo $environmentXML; ?>"><button class="btn btn-primary">List Emails</button></a>
				    </div>
				</div>
	    	</div>

	    	<div class="col">
	    		<h2><u>List JAVA Class</u></h2>
				<br>
				<div class="form-group row">
					<div class="alert alert-secondary" role="alert">List all the JAVA Clases</div>
				</div>
				<br>
				<div class="form-group row">
					<div class="col-sm-10">
						<a href="listJavaClass.php?environment=<?php echo $environmentXML; ?>"><button class="btn btn-primary">List JAVA Class</button></a>
				    </div>
				</div>
	    	</div>

	    </div>

	    <div class="row">
	    	
	    	<div class="col">
	    		<h2><u>List Directory Attributes</u></h2>
				<br>
				<div class="form-group row">
					<div class="alert alert-secondary" role="alert">List all the Attributes</div>
				</div>
				<br>
				<div class="form-group row">
					<div class="col-sm-10">
						<a href="listDirectoryAttributes.php?environment=<?php echo $environmentXML; ?>"><button class="btn btn-primary">List Directory Attributes</button></a>
				    </div>
				</div>
	    	</div>

	    	<div class="col">
	    		<h2><u>List Tasks With Workflow</u></h2>
				<br>
				<div class="form-group row">
					<div class="alert alert-secondary" role="alert">Lists the tasks that have an associated Workflow</div>
				</div>
				<br>
				<div class="form-group row">
					<div class="col-sm-10">
						<a href="listTaskWithWorkflow.php?environment=<?php echo $environmentXML; ?>"><button class="btn btn-primary">List Tasks</button></a>
				    </div>
				</div>
	    	</div>

	    </div>
		

<?php require_once("footer.php"); ?>