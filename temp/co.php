<?php

    $username = "Sdz";
    $password = "salut";

    if(isset($_POST['username']) && isset($_POST['password'])) {

        if($_POST['username'] == $username && $_POST['password'] == $password) {
            echo '<p style="color: green;">Vous êtes connecté...</p>';
        } else {
            echo '<p style="color: red">Le nom d\'utilisateur et/ou mot de passe incorrect</p>';
        }

    } else {
        echo "Veuillez remplir tout les champs svp";
    } 
?>
