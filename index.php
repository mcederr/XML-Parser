<?php require_once("header.php"); ?>
		<br>
		<h2><u>Search Object Type for Specific Attribute</u></h2>
		<br>
		<form action="procesar.php" method="GET">
			<div class="form-group row">
		    <label class="col-sm-2 col-form-label">Attribute:</label>
		    <div class="col-sm-10">
		      <input type="text" class="form-control" name="attribute" required="true">
		    </div>
		  </div>
		  <div class="form-group row">
		    <label class="col-sm-2 col-form-label">Object Type:</label>
		    <div class="col-sm-10">
		    	<select class="form-control" name="objectType"  required>
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
		</form>
<?php require_once("footer.php"); ?>