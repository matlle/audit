<?php
    require_once '../model.php';
	
	$projets = liste_projets();
    	
	echo json_encode(array("projets" => $projets));

    
