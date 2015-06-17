<?php

require_once '../model.php';

    start_session();
    logout_protected();




    $infos = array();
    $status = array();
    
    if(!isset($_POST['edit_op_code']) || empty($_POST['edit_op_code'])
        && !isset($_POST['edit_op_libele']) || empty($_POST['edit_op_libele'])
        && !isset($_POST['edit_op_mode_pay'])|| empty($_POST['edit_op_mode_pay'])
        && !isset($_POST['edit_op_montant']) || empty($_POST['edit_op_montant'])
    ) {

            $infos = array('statut' => 'failed', 'message' => 'Opération non modifiée. Veuillez remplir tous les champs.', 'field' => $_POST);
            echo json_encode(array('statut' => $infos));

    } else if(!is_numeric($_POST['edit_op_montant'])) {

            $infos = array('statut' => 'failed', 'message' => 'Opération non modifiée. Veuillez entrer des chiffres pour le montant.', 'field' => $_POST);
            echo json_encode(array('statut' => $infos));

     } else {

            $code = htmlspecialchars($_POST['edit_op_code']);    
            $libele = htmlspecialchars($_POST['edit_op_libele']);    
            $mode = htmlspecialchars($_POST['edit_op_mode_pay']);    
            $montant = htmlspecialchars($_POST['edit_op_montant']);    
            $opid = htmlspecialchars($_POST['opid']);

            editOp($opid, $code, $libele, $mode, $montant);

            $infos = array('statut' => 'success', 'message' => 'Operation modifiée!');
            echo json_encode(array('statut' => $infos));

    }
    
