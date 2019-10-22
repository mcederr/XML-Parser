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
		?>

		<br>
		<br>
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
		  <input type="hidden" name="environment" value="<?php echo $environmentXML; ?>">
		</form>
		<br>
		<br>
		<h2><u>Search Policies Express for Specific Task</u></h2>
		<br>
		<form action="searchTask.php" method="GET">
			<div class="form-group row">
		    <label class="col-sm-2 col-form-label">Task Name/Tag:</label>
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
		<br>
		<br>
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
		<br>
		<br>
		<h2><u>Search JAVA Class</u></h2>
		<br>
		<form action="searchJavaClass.php" method="GET">
			<div class="form-group row">
		    <label class="col-sm-2 col-form-label">Class Name:</label>
		    <div class="col-sm-10">
		      <input type="text" class="form-control" name="className" required="true">
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
<?php require_once("footer.php"); ?>