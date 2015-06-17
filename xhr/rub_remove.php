<?php

require_once '../model.php';

    start_session();
    logout_protected();




    $infos = array();
    $status = array();

    if(isset($_POST['rrid']) && !empty($_POST['rrid'])) {
            
            $rid = (int) htmlspecialchars($_POST['rrid']);

            removeRub($rid); 

            $infos = array('statut' => 'success', 'message' => 'Rubrique supprimée');
            echo json_encode(array('statut' => $infos));

    } else {
            $infos = array('statut' => 'failed', 'message' => 'Rubrique non supprimée');
            echo json_encode(array('statut' => $infos));
    }
    
