<?php

require_once '../model.php';

    start_session();
    logout_protected();
    
    $idp = htmlspecialchars($_GET['projet']);
    $rid = htmlspecialchars($_GET['rubrique']);
    $opdate = htmlspecialchars($_GET['dateOp']);

    $data = previewListOp($idp, $rid, $opdate);

    echo json_encode(array('liste' => $data));
    
