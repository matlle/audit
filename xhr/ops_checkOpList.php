<?php

require_once '../model.php';

    start_session();
    logout_protected();


function isDateValid($date) {

        //$uyear = DateTime::createFromFormat("d/m/Y", $date);
        //$uy = $uyear->format("Y");
        //$sy = date("Y");
    
    if(preg_match('^(((0[1-9]|[12]\d|3[01])\/(0[13578]|1[02])\/((19|[2-9]\d)\d{2}))|((0[1-9]|[12]\d|30)\/(0[13456789]|1[012])\/((19|[2-9]\d)\d{2}))|((0[1-9]|1\d|2[0-8])\/02\/((19|[2-9]\d)\d{2}))|(29\/02\/((1[6-9]|[2-9]\d)(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00))))$^', $date))
        return false;
    else
        return true;
   
}






    $infos = array();
    $status = array();

    if(isset($_POST['projet']) && !empty($_POST['projet'])
        && isset($_POST['rubrique']) && !empty($_POST['rubrique'])
        && isset($_POST['dateOp']) && !empty($_POST['dateOp'])
        && isDateValid($_POST['dateOp']) === true
    ) {

        $idp = $_POST['projet'];
        $rid = $_POST['rubrique'];
        $date = $_POST['dateOp'];

        if(isOpAvaible($idp, $rid, $date) === true) {
            $infos = array('statut' => 'yes', 'message' => 'Opération(s) disponible(s)');
            echo json_encode(array('statut' => $infos));
        } else {
            $infos = array('statut' => 'no', 'message' => 'Auccune opération disponible');
            echo json_encode(array('statut' => $infos));
        }
    }
    
