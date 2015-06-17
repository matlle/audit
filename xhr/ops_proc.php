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

    if(!isset($_POST['projet']) || empty($_POST['projet']) || !isset($_POST['montantOp']) || !isset($_POST['rubriques']) || empty($_POST['rubriques'])
        || !isset($_POST['dateOp']) || empty($_POST['dateOp']) || !isset($_POST['codeOp']) || empty($_POST['codeOp'])
        || !isset($_POST['libeleOp']) || empty($_POST['libeleOp']) || !isset($_POST['modePay']) || empty($_POST['modePay'])
     ) {
         $infos = array('statut' => 'failed', 'message' => 'Tous les champs sont requis.');
         echo json_encode(array('statut' => $infos));
    }
    else if(!is_numeric($_POST['montantOp'])) {
        $infos = array('statut' => 'failed', 'message' => 'Veuillez entrer des chiffres pour le montant specifié');
        echo json_encode(array('statut' => $infos));
    }
    else if(isDateValid($_POST['dateOp']) === false) {
        $infos = array('statut' => 'failed', 'message' => 'Veuillez saisir une date au format jj/mm/aaaa ou verifier que l\'année specifiée n\'est superieur à celle en cours.');
        echo json_encode(array('statut' => $infos));
    }
    else {
        $dateOp = htmlspecialchars($_POST['dateOp']);
        $rid = htmlspecialchars($_POST['rubriques']);
        $idp = htmlspecialchars($_POST['projet']);
        $codeOp = htmlspecialchars($_POST['codeOp']);
        $libeleOp = htmlspecialchars($_POST['libeleOp']);
        $modePay = htmlspecialchars($_POST['modePay']);
        $montant = htmlspecialchars($_POST['montantOp']);

        $newmontant = number_format($montant, 0, "", " ");

        $tdate = date_create($dateOp);
        $newdate = date_format($tdate, 'd/m/Y');
        $df = DateTime::createFromFormat("d/m/Y", $newdate);
        $year = $df->format("Y");
        $day = $df->format("d");
        $tmon = $df->format("F");
        $month = '';

        switch($tmon) {
            case 'January':
                $month = 'Janvier';
                break;
            case 'February':
                $month = 'Fevrier';
                break;
            case 'March':
                $month = 'Mars';
                break;
            case 'April':
                $month = 'Avril';
                break;
            case 'May':
                $month = 'Mai';
                break;
            case 'June':
                $month = 'Juin';
                break;
            case 'July':
                $month = 'Juillet';
                break;
            case 'August':
                $month = 'Août';
                break;
            case 'September':
                $month = 'Septembre';
                break;
            case 'October':
                $month = 'Octobre';
                break;
            case 'November':
                $month = 'Novembre';
                break;
            case 'December':
                $month = 'Decembre';
                break;
            default:
                $month = 'Unknown';
        }



        $idd = enregistrer_opdate($idp, $rid, $dateOp, $month, $year, $newdate);

        
        $nopid = new_operation($codeOp, $libeleOp, $montant, $modePay, $_SESSION['login'], $idp, $rid, $dateOp, $day, $month, $year, $newdate, $newmontant);

        $infos = array('statut' => 'ok', 'message' => 'Opération enregistrée');
        echo json_encode(array('statut' => $infos));
    }
