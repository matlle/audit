<?php

require_once '../model.php';

    start_session();
    logout_protected();




    $infos = array();
    $status = array();

    if(isset($_POST['opid']) && !empty($_POST['opid'])) {
            
            $opid = (int) htmlspecialchars($_POST['opid']);

            removeOp($opid); 

            $infos = array('statut' => 'success', 'message' => 'Operation supprimée');
            echo json_encode(array('statut' => $infos));

    } else {
            $infos = array('statut' => 'failed', 'message' => 'Opération non modifiée');
            echo json_encode(array('statut' => $infos));
    }
    
