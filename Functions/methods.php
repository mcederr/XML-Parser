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
?>