<?php
   require_once '../model.php';

if(isset($_GET['idp']) && !empty($_GET['idp'])) {
        $idp = htmlspecialchars($_GET['idp']);
        $rubriques = getAllRubriqueByProjetId($idp);
        echo json_encode(array("rubriques" => $rubriques));
} else {
    echo json_encode(array('error' => 'Break error'));
}
