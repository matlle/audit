<?php

    require_once '../model.php';
    

if(isset($_GET['idp']) && !empty($_GET['idp'])) {    
    $id = htmlspecialchars($_GET['idp']);
    $rub = getAllRubriqueByProjetId($id);
    echo json_encode(array("rubriques" => $rub));
}
