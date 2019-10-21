<?php 

function compare($a, $b){

	// El criterio sera el siguiente:
	// Se ordenara por Tipo -> Step -> Prioridad
    	
   	// Verifico si tienen el mismo Tipo
   	if ($a->type == $b->type) {
       	
       	// Si lo tienen, verifico si tienen el mismo Step
      	if ($a->step == $b->step){
      		
      		// Si lo tienen, verifico quien tiene la menor prioridad
       		return (intval($a->priority) < intval($b->priority)) ? -1 : 1;
      
       	}else{
      		
      		// Si no lo tienen, ordeno alfabeticamente
       		return strcasecmp($a->step, $b->step);
  	
  		}
   	
   	}else{

   		// Si no lo tienen, ordeno alfabeticamente
    	return strcasecmp($a->type, $b->type);

    }
}

function saveFileUploaded ($fileUploaded){
  
  if (($fileUploaded['name'] != "")){
    
    // Where the file is going to be stored
    $target_dir = "Files/";
    
    $file = $fileUploaded['name'];
    $path = pathinfo($file);
    $filename = $path['filename'];
    $ext = $path['extension'];
    $temp_name = $fileUploaded['tmp_name'];
    $path_filename_ext = $target_dir.$filename.".".$ext;
       
    // Check if file already exists
    if (file_exists($path_filename_ext)) {
      
      // Delete File
      unlink($path_filename_ext);
      
      // And Upload The New File
      move_uploaded_file($temp_name,$path_filename_ext);

    }else{
      
      move_uploaded_file($temp_name,$path_filename_ext);
      
    }
  }
}

?>