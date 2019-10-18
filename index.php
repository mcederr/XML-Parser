<?php require_once("header.php"); ?>
		<br>
		<br>
		<h2><u>Environment</u></h2>
		<br>
		<div class="input-group">
  			<div class="input-group-prepend">
    			<span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
  			</div>
  			<div class="custom-file">
    			<input type="file" class="custom-file-input pointer" id="inputGroupFile" aria-describedby="inputGroupFileAddon" onchange="ValidateFileInput(this);">
    			<label class="custom-file-label" for="inputGroupFile" id="fileField">Choose XML File</label>
  			</div>
		</div>
		<br>
		<br>
		<h2><u>Search Object Type for Specific Attribute</u></h2>
		<br>
		<form action="Functions/process.php" onsubmit="return validateForm();" method="POST">
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
		</form>
		<br>
		<br>
		<h2><u>Search Policies Express for Specific Task</u></h2>
		<br>
		<form action="searchTask.php" method="POST">
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
		<form action="searchScreen.php" method="POST">
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
		

		<script>
			
			// Add the following code if you want the name of the file appear on select
			/*$(".custom-file-input").on("change", function() {
			  var fileName = $(this).val().split("\\").pop();
			  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
			});*/

			

			function validateForm() {

  				if (document.getElementById("inputGroupFile").value == ""){

  					// this adds the error class
  					document.getElementById("fileField").className = document.getElementById("fileField").className + " error";
  					
  					// Colocar un mensaje de error en rojo debajo del campo que tiene errores y no utilizar Pop-Ups
  					alert("You Must Select a File");

  					return false;
  				
  				}else{

  					// this removes the error class
					document.getElementById("fileField").className = document.getElementById("fileField").className.replace(" error", "");
  					
  					return true;
  				}
			}
			
			function ValidateFileInput(oInput) {
			    
			    if (oInput.type == "file") {
			        
					var sFileName = oInput.value;
			        
			        if (sFileName.length > 0) {
			            
			            var sCurExtension = ".xml";
			            
			            if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()){
							
			            	// this removes the error class
							document.getElementById("fileField").className = document.getElementById("fileField").className.replace(" error", "");

							return true;
						
						}else{
							
							// Colocar un mensaje de error en rojo debajo del campo que tiene errores y no utilizar Pop-Ups
							alert("Select XML File");
			            	
			            	// this adds the error class
  							document.getElementById("fileField").className = document.getElementById("fileField").className + " error";
			                
			                oInput.value = "Choose XML File";
			            
			                return false;
						}
					}
				}
			}
		</script>
<?php require_once("footer.php"); ?>