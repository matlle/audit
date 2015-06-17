<?php
    require_once '../model.php';
     
    $msg = array();
    $msg['ok'] = '';
    $msg['error'] = '';


    if(isset($_POST['rubrique_name']) && !empty($_POST['rubrique_name']) && isset($_POST['proid']) && !empty($_POST['proid'])) {

       $idp = (int) htmlspecialchars($_POST['proid']);
       $rubname = htmlspecialchars($_POST['rubrique_name']);

       if(is_numeric($rubname)) {
           $msg['error'] = "Le nom de la rubrique doit être alphabetique";
           echo json_encode(array("msg" => $msg));
       } else {
           $lrid = enregistrer_rubrique($idp, $rubname);
           $nrub = getRubriqueById($lrid);
           $msg['rubrique'] = $nrub;
           $msg['ok'] = "Rubrique enregistrée...!";
           echo json_encode(array("msg" => $msg));
       }
    } else { 
            $msg['error'] = "Veuyez entrer un nom de rubrique svp.";
            echo json_encode(array("msg" => $msg));
    }

            
