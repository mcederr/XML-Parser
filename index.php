<?php require_once("header.php"); ?>
		<br>
		<br>
		<h2><u>Environment</u></h2>
		<br>
		<form action="mainMenu.php" method="POST" onsubmit="return validateForm()" enctype="multipart/form-data">
			<div class="input-group">
	  			<div class="input-group-prepend">
	    			<span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
	  			</div>
	  			<div class="custom-file">
	    			<input name="fileInput" type="file" class="custom-file-input pointer" id="inputGroupFile" aria-describedby="inputGroupFileAddon" onchange="validateFileInput(this);">
	    			<label class="custom-file-label" for="inputGroupFile" id="fileField">Choose XML File</label>
	  			</div>
			</div>
			<br>
			<input type="submit" class="btn btn-primary" value="Submit">
		</form>

		<script>
			
			// Add the following code if you want the name of the file appear on select
			$(".custom-file-input").on("change", function() {
			  var fileName = $(this).val().split("\\").pop();
			  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
			});

			

			function validateForm() {

  				if (document.getElementById("inputGroupFile").value == ""){

  					// this adds the error class
  					document.getElementById("fileField").className = document.getElementById("fileField").className + " error";

  					return false;
  				
  				}else{

  					// this removes the error class
					document.getElementById("fileField").className = document.getElementById("fileField").className.replace(" error", "");
  					
					var file = document.getElementById("inputGroupFile").value;
					
					var sCurExtension = ".xml";

					if (file.substr(file.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()){

  						return true;
  					
  					}else{

  						// this adds the error class
  						document.getElementById("fileField").className = document.getElementById("fileField").className + " error";
  						
  						return false;
  					}
  				}
			}
			
			function validateFileInput(oInput) {
			    
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
			            
			                return false;
						}
					}
				}
			}
		</script>
<?php require_once("footer.php"); ?>