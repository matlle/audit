<?php
    
function connection () {

        try {

             $db = new PDO('mysql:host=127.0.0.1;dbname=auditfaj', 'root', '');                  
             return $db;

        } catch(Exception $e) {

                 die('Erreur : ' .$e->getMessage());
         }
    }

	
function rand_color() {
    return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
}



function randomColor2() {
    $str = '#';
    for($i = 0 ; $i < 3 ; $i++) {
        $str .= dechex( rand(170 , 255) );
    }
    return $str;
}
	
	
function login($log, $pas) {
    
            $sql = 'SELECT  login, password
                        FROM utilisateur
                   ';

		    $db = connection();

            $query = $db->prepare($sql);
		    $query->execute() or die(print_r($query->errorInfo()));

		    $data = $query->fetchAll();
			
			$arlog = array();
			$arpass = array();
			
			foreach($data as $l)
			    $arlog[] = $l['login'];
			foreach($data as $p)
			    $arpass[] = $p['password'];
			
			$query->closeCursor();
		
		//hashing the supplied password and comparing it with the stored hashed password.
		    //if($stored_password === hash('sha512', $password)){
		    if(in_array($log, $arlog, true) && in_array($pas, $arpass, true)) {
			    return true;	
		    } else {
			    return false;	
		    }

    }


function changePassword($npass, $uid, $cid) {
       
	   $msg = 'Changé <em>password</em>';  
       logUser($cid, $uid, $msg);
	   
       $sql = 'UPDATE utilisateur
	             SET password = :npass
				 WHERE id_utilisateur = :uid';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':npass', $npass, PDO::PARAM_STR);
		$query->bindValue(':uid', $cid, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
	    $query->closeCursor();

}
	
	
function enregistrer_projet($code, $objet, $date, $taxe, $taux, $montant_ht, $user) {
	
	    $sql = 'INSERT INTO projet(
		      code_projet,
		      objet_projet,
			  date_projet,
			  taxe_projet,
			  taux,
			  montant_ht_projet,
			  created_by,
              date_saisie_projet,
              date_updated_projet)
			  VALUES(
			  :code,
			  :objet,
			  :datepro,
			  :taxe,
			  :taux,
			  :montant,
			  :user,
              NOW(),
              NOW())';
     		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':code', $code, PDO::PARAM_STR);
		$query->bindValue(':objet', $objet, PDO::PARAM_STR);
        $query->bindValue(':datepro', $date, PDO::PARAM_STR);
        $query->bindValue(':taxe', $taxe, PDO::PARAM_STR);
		$query->bindValue(':taux', $taux, PDO::PARAM_STR);
        $query->bindValue(':montant', $montant_ht, PDO::PARAM_STR);
		$query->bindValue(':user', $user, PDO::PARAM_STR);
		$query->execute() or die(print_r($query->errorInfo()));
		
		$query->closeCursor();
	    
}
    


function liste_projets() {
	    
		$sql = 'SELECT * FROM projet ORDER BY date_saisie_projet DESC';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $list = $query->fetchAll();
	   
	    $query->closeCursor();
	   
	    return $list;
	
}


	

	
function liste_projets_by_year($y) {
	    
		$r1 = $y.'-01-01';
		$r2 = $y.'-12-31';
		
		$sql = 'SELECT * 
		           FROM projet
				   WHERE date_projet BETWEEN :ra1 AND :ra2
				   ORDER BY date_projet DESC';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':ra1', $r1, PDO::PARAM_INT);
		$query->bindValue(':ra2', $r2, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $list = $query->fetchAll();
	   
	    $query->closeCursor();
	   
	    return $list;
	
}



function getProIdByName($proname) {
		
		$sql = 'SELECT id_projet 
		           FROM projet
				   WHERE objet_projet = :name';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':name', $proname, PDO::PARAM_STR);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $list = $query->fetch();
	   
	    $query->closeCursor();
	   
	    return $list['id_projet'];
	
}
	
	
	
	
	
	function liste_donnees_prevision($id) {
	    
		$sql = 'SELECT * FROM previsionnelle WHERE id_projet = :id ORDER BY date_saisie_previsionnelle DESC';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':id', $id, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $list = $query->fetchAll();
	   
	    $query->closeCursor();
	   
	    return $list;
	
	}
	
	
	
	
	function liste_donnees_person_prevision($iddp) {
	    
		$sql = 'SELECT * FROM personnel_prevision WHERE id_previsionnelle = :id_pre ORDER BY date_saisie_personnel_previsionnelle DESC';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':id_pre', $iddp, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $list = $query->fetchAll();
	   
	    $query->closeCursor();
	   
	    return $list;
	
	}
		
	
	
	
	
	function liste_donnees_autresfrais_prevision($iddp) {
	    
		$sql = 'SELECT * FROM autrefrais_prevision WHERE id_previsionnelle = :id_pre ORDER BY date_saisie_autresfrais_previsionnel DESC';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':id_pre', $iddp, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $list = $query->fetchAll();
	   
	    $query->closeCursor();
	   
	    return $list;
	
	}




    function liste_donnees_materiel_prevision($iddp) {
	    
		$sql = 'SELECT * FROM materiel_prevision WHERE id_previsionnelle = :id_pre ORDER BY date_saisie_materiel_previsionnel DESC';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':id_pre', $iddp, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $list = $query->fetchAll();
	   
	    $query->closeCursor();
	   
	    return $list;
	
	}
	
	
	
	
	
	 function liste_donnees_materiel_execution($idde) {
	    
		$sql = 'SELECT * FROM materiel_execution WHERE id_execution = :id_exe ORDER BY date_saisie_materiel_execution DESC';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':id_exe', $idde, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $list = $query->fetchAll();
	   
	    $query->closeCursor();
	   
	    return $list;
	
	}
	
	
	
	
	
	function liste_donnees_engin_prevision($iddp) {
	    
		$sql = 'SELECT * FROM engin_prevision WHERE id_previsionnelle = :id_pre ORDER BY date_saisie_engin_previsionnel DESC';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':id_pre', $iddp, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $list = $query->fetchAll();
	   
	    $query->closeCursor();
	   
	    return $list;
	
	}
	
	
	
	
	
	
	function liste_donnees_engin_execution($idde) {
	    
		$sql = 'SELECT * FROM engin_execution WHERE id_execution = :id_exe ORDER BY date_saisie_engin_execution DESC';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':id_exe', $idde, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $list = $query->fetchAll();
	   
	    $query->closeCursor();
	   
	    return $list;
	
	}
	
	
	
	
	
	
   	function liste_donnees_matroulant_prevision($iddp) {
	    
		$sql = 'SELECT * FROM matroulant_prevision WHERE id_previsionnelle = :id_pre ORDER BY date_saisie_matroulant_previsionnel DESC';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':id_pre', $iddp, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $list = $query->fetchAll();
	   
	    $query->closeCursor();
	   
	    return $list;
	
	}
	
	
	
	
	
	function liste_donnees_matroulant_execution($idde) {
	    
		$sql = 'SELECT * FROM matroulant_execution WHERE id_execution = :id_exe ORDER BY date_saisie_matroulant_execution DESC';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':id_exe', $idde, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $list = $query->fetchAll();
	   
	    $query->closeCursor();
	   
	    return $list;
	
	}
	
	
	
	
	
	
	
	function liste_donnees_autresfrais_execution($iddp) {
	    
		$sql = 'SELECT * FROM autrefrais_execution WHERE id_execution = :id_exe ORDER BY date_saisie_autresfrais_execution DESC';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':id_exe', $iddp, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $list = $query->fetchAll();
	   
	    $query->closeCursor();
	   
	    return $list;
	
	}
	
	
	
	
	
	function liste_donnees_person_execution($idde) {
	    
		$sql = 'SELECT * FROM personnel_execution WHERE id_execution = :id_exe ORDER BY date_saisie_personnel_execution DESC';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':id_exe', $idde, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $list = $query->fetchAll();
	   
	    $query->closeCursor();
	   
	    return $list;
	
	}
	
	
	
	
	function listePersByExe($idp) {
	    
		$sql = 'SELECT p.* 
		           FROM execution
                   RIGHT JOIN personnel_execution p USING(id_execution)
                   INNER JOIN projet USING(id_projet)				   
				   WHERE id_projet = :id ORDER BY p.date_saisie_personnel_execution DESC';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':id', $idp, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $liste = $query->fetchAll();
		
	    $query->closeCursor();
		
	   
	    return $liste;
	
	}
	

	
   
	function listeEngByExe($idp) {
	    
		$sql = 'SELECT e.* 
		           FROM execution
                   RIGHT JOIN engin_execution e USING(id_execution)
                   INNER JOIN projet USING(id_projet)				   
				   WHERE id_projet = :id ORDER BY e.date_saisie_engin_execution DESC';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':id', $idp, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $liste = $query->fetchAll();
		
	    $query->closeCursor();
		
	   
	    return $liste;
	
	}
	
	
	
	function listeRoulByExe($idp) {
	    
		$sql = 'SELECT r.* 
		           FROM execution
                   RIGHT JOIN matroulant_execution r USING(id_execution)
                   INNER JOIN projet USING(id_projet)				   
				   WHERE id_projet = :id ORDER BY r.date_saisie_matroulant_execution DESC';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':id', $idp, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $liste = $query->fetchAll();
		
	    $query->closeCursor();
		
	   
	    return $liste;
	
	}
	
	
	
	
    function listeMatByExe($idp) {
	    
		$sql = 'SELECT m.* 
		           FROM execution
                   RIGHT JOIN materiel_execution m USING(id_execution)
                   INNER JOIN projet USING(id_projet)				   
				   WHERE id_projet = :id ORDER BY m.date_saisie_materiel_execution DESC';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':id', $idp, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $liste = $query->fetchAll();
		
	    $query->closeCursor();
		
	   
	    return $liste;
	
	}
	
	
	
	 function listeAfraiByExe($idp) {
	    
		$sql = 'SELECT a.* 
		           FROM execution
                   RIGHT JOIN autrefrais_execution a USING(id_execution)
                   INNER JOIN projet USING(id_projet)				   
				   WHERE id_projet = :id ORDER BY a.date_saisie_autresfrais_execution DESC';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':id', $idp, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $liste = $query->fetchAll();
		
	    $query->closeCursor();
		
	   
	    return $liste;
	
	}
	
	
	
	
function liste_donnees_execution($id) {
	    
		$sql = 'SELECT * FROM execution WHERE id_projet = :id ORDER BY date_saisie_execution DESC';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':id', $id, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $list = $query->fetchAll();
	   
	    $query->closeCursor();
	   
	    return $list;
	
}



function liste_donnees_operation($id) {
	    
		$sql = 'SELECT * FROM operation WHERE id_projet = :id ORDER BY opdate_date';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':id', $id, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $list = $query->fetchAll();
	   
	    $query->closeCursor();
	   
	    return $list;
	
}





function liste_donnees_operation_date_filter($idp, $date1, $date2) {
	    
		$sql = 'SELECT * 
		            FROM operation 
					WHERE id_projet = :idp AND opdate_date BETWEEN :d1 AND :d2
					ORDER BY opdate_date';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':idp', $idp, PDO::PARAM_INT);
		$query->bindValue(':d1', $date1, PDO::PARAM_STR);
		$query->bindValue(':d2', $date2, PDO::PARAM_STR);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $list = $query->fetchAll();
	   
	    $query->closeCursor();
	   
	    return $list;
	
}
	
	
	
	
	
function infos_projet($idp) {
		
		$sql = 'SELECT * FROM projet WHERE id_projet = :id';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':id', $idp, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $projet = $query->fetch();
	   
	    $query->closeCursor();
	   
	    return $projet;
		
	}
	
	
	
	
   		function infos_previsionnelle($iddp) {
		
		$sql = 'SELECT * FROM previsionnelle WHERE id_previsionnelle = :id';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':id', $iddp, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $projet = $query->fetch();
	   
	    $query->closeCursor();
	   
	    return $projet;
		
	}
	

	function infos_personnelle_prevision($idperso) {
		
		$sql = 'SELECT * FROM personnel_prevision WHERE id_personnel_previsionnelle = :id';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':id', $idperso, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $projet = $query->fetch();
	   
	    $query->closeCursor();
	   
	    return $projet;
		
	}
	
	
	
	
		function infos_personnelle_execution($idperso) {
		
		$sql = 'SELECT * FROM personnel_execution WHERE id_personnel_execution = :id';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':id', $idperso, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $projet = $query->fetch();
	   
	    $query->closeCursor();
	   
	    return $projet;
		
	}
	
	
	
	
	function infos_frais_prevision($idfrais) {
		
		$sql = 'SELECT * FROM autrefrais_prevision WHERE id_autresfrais_previsionnel = :id';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':id', $idfrais, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $projet = $query->fetch();
	   
	    $query->closeCursor();
	   
	    return $projet;
		
	}
	
	
	
	
	
		
	function infos_engin_prevision($ideng) {
		
		$sql = 'SELECT * FROM engin_prevision WHERE id_engin_previsionnel = :id';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':id', $ideng, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $projet = $query->fetch();
	   
	    $query->closeCursor();
	   
	    return $projet;
		
	}
	
	
	
	
		
	function infos_engin_execution($ideng) {
		
		$sql = 'SELECT * FROM engin_execution WHERE id_engin_execution = :id';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':id', $ideng, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $projet = $query->fetch();
	   
	    $query->closeCursor();
	   
	    return $projet;
		
	}
	
	
	
	
	
	function infos_matroulant_prevision($idroulant) {
		
		$sql = 'SELECT * FROM matroulant_prevision WHERE id_matroulant_previsionnel = :id';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':id', $idroulant, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $projet = $query->fetch();
	   
	    $query->closeCursor();
	   
	    return $projet;
		
	}
	
	
	
	
		
	function infos_matroulant_execution($idroulant) {
		
		$sql = 'SELECT * FROM matroulant_execution WHERE id_matroulant_execution = :id';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':id', $idroulant, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $projet = $query->fetch();
	   
	    $query->closeCursor();
	   
	    return $projet;
		
	}
	
	
	
	
	
	function infos_materiel_prevision($idmateriel) {
		
		$sql = 'SELECT * FROM materiel_prevision WHERE id_materiel_previsionnel = :id';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':id', $idmateriel, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $projet = $query->fetch();
	   
	    $query->closeCursor();
	   
	    return $projet;
		
	}
	
	
	
	
		
	function infos_materiel_execution($idmateriel) {
		
		$sql = 'SELECT * FROM materiel_execution WHERE id_materiel_execution = :id';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':id', $idmateriel, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $projet = $query->fetch();
	   
	    $query->closeCursor();
	   
	    return $projet;
		
	}
	
	
	
	
	
	
	
	function infos_frais_execution($idfrais) {
		
		$sql = 'SELECT * FROM autrefrais_execution WHERE id_autresfrais_execution = :id';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':id', $idfrais, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $projet = $query->fetch();
	   
	    $query->closeCursor();
	   
	    return $projet;
		
	}
	
	
	
	
function removeEngPrevision($iddp, $ideng) {
   
       $sql = 'DELETE  logen.*,
	                                eng.*
	                FROM  engin_prevision eng
					LEFT JOIN logenginprevision logen ON logen.log_engin_prevision_engin_id = eng.id_engin_previsionnel
	                WHERE id_engin_previsionnel = :ideng AND id_previsionnelle = :iddp';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':ideng', $ideng, PDO::PARAM_INT);
		$query->bindValue(':iddp', $iddp, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	    
	    $query->closeCursor();
   
   }
	
	
function removeEngExecution($idde, $ideng) {
   
       $sql = 'DELETE logen.*,
	                              eng.*
	               FROM  engin_execution eng
				   LEFT JOIN logenginexecution logen ON logen.log_engin_execution_engin_id = eng.id_engin_execution
	               WHERE id_engin_execution = :ideng AND id_execution = :idde';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':ideng', $ideng, PDO::PARAM_INT);
		$query->bindValue(':idde', $idde, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	    
	    $query->closeCursor();
   
}
	
	
	
	
	
	
function removeMatRoulantPrevision($iddp, $idroulant) {
   
       $sql = 'DELETE logmatrou.*,
	                              matroul.*
	               FROM  matroulant_prevision matroul
				   LEFT JOIN logmatroulantprevision logmatrou ON logmatrou.log_matroulant_prevision_matroulant_id = matroul.id_matroulant_previsionnel
	               WHERE id_matroulant_previsionnel = :idroulant AND id_previsionnelle = :iddp';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':idroulant', $idroulant, PDO::PARAM_INT);
		$query->bindValue(':iddp', $iddp, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	    
	    $query->closeCursor();
   
   }
	
	
	function removeMatRoulantExecution($idde, $idroulant) {
   
       $sql = 'DELETE logmat.*, 
	                              mat.*
	             FROM  matroulant_execution mat
				 LEFT JOIN logmatroulantexecution logmat ON logmat.log_matroulant_execution_matroulant_id = mat.id_matroulant_execution
	             WHERE id_matroulant_execution = :idroulant AND id_execution = :idde';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':idroulant', $idroulant, PDO::PARAM_INT);
		$query->bindValue(':idde', $idde, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	    
	    $query->closeCursor();
   
   }
	
	
	
   
   
	  function removeMaterielPrevision($iddp, $idmateriel) {
   
       $sql = 'DELETE logmate.*,
	                              mate.*
	             FROM  materiel_prevision mate
				 LEFT JOIN logmatchantierprevision logmate ON logmate.log_matchantier_prevision_matchantier_id = mate.id_materiel_previsionnel
	             WHERE id_materiel_previsionnel = :idmateriel AND id_previsionnelle = :iddp';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':idmateriel', $idmateriel, PDO::PARAM_INT);
		$query->bindValue(':iddp', $iddp, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	    
	    $query->closeCursor();
   
   }
	
	
	function removeMaterielExecution($idde, $idmateriel) {
   
       $sql = 'DELETE logmate.*,
	                              mate.*
	               FROM  materiel_execution mate
				   LEFT JOIN logmatchantierexecution logmate ON logmate.log_matchantier_execution_matchantier_id = mate.id_materiel_execution
	               WHERE id_materiel_execution = :idmateriel AND id_execution = :idde';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':idmateriel', $idmateriel, PDO::PARAM_INT);
		$query->bindValue(':idde', $idde, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	    
	    $query->closeCursor();
   
}
	
	
	
	
	
	
	
function infos_execution($idde) {
		
		$sql = 'SELECT * FROM execution WHERE id_execution = :id';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':id', $idde, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $projet = $query->fetch();
	   
	    $query->closeCursor();
	   
	    return $projet;
		
	}
	
	
	


    function enregistrer_previsionnelle($nature, $unite, $quantite, $duree, $id, $user) {
	
	    $sql = 'INSERT INTO previsionnelle (
		      nature_travaux_previsionnelle,
			  unite_previsionnelle,
			  quantite_previsionnelle,
			  duree_previsionnelle,
			  id_projet,
			  created_by,
			  date_saisie_previsionnelle)
			  VALUES(
			  :nature,
			  :unite,
			  :quantite,
			  :duree,
			  :idprojet,
			  :user,
			  NOW())';
     		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':nature', $nature, PDO::PARAM_STR);
        $query->bindValue(':unite', $unite, PDO::PARAM_INT);
        $query->bindValue(':quantite', $quantite, PDO::PARAM_INT);
		$query->bindValue(':duree', $duree, PDO::PARAM_STR);
		$query->bindValue(':idprojet', $id, PDO::PARAM_INT);
		$query->bindValue(':user', $user, PDO::PARAM_STR);
		$query->execute() or die(print_r($query->errorInfo()));
		
		$query->closeCursor();
	    
	}
	
	
	
	
	
	 function enregistrer_personnelle_previsionnelle($matricule, $fonction, $salaire, $nombre_h, $iddp, $user) {
	
	    $sql = 'INSERT INTO personnel_prevision (
		      matricule_personnel_previsionnelle,
			  fonction_personnel_previsionnelle,
			  salaire_horaire_personnel_previsionnelle,
			  nombre_horaire_personnel_previsionnelle,
			  id_previsionnelle,
			  created_by,
			  date_saisie_personnel_previsionnelle)
			  VALUES(
			  :matricule,
			  :fonction,
			  :salaire,
			  :nombreh,
			  :iddp,
			  :user,
			  NOW())';
     		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':matricule', $matricule, PDO::PARAM_STR);
        $query->bindValue(':fonction', $fonction, PDO::PARAM_STR);
        $query->bindValue(':salaire', $salaire, PDO::PARAM_INT);
		$query->bindValue(':nombreh', $nombre_h, PDO::PARAM_INT);
		$query->bindValue(':iddp', $iddp, PDO::PARAM_INT);
		$query->bindValue(':user', $user, PDO::PARAM_STR);
		$query->execute() or die(print_r($query->errorInfo()));
		
		$query->closeCursor();
	    
	}
	
	
	
	
	function enregistrer_autresfrais_previsionnelle($objet, $unite, $quantite, $prix, $iddp, $user) {
	
	    $sql = 'INSERT INTO autrefrais_prevision (
		      objet_autresfrais_previsionnel,
			  unite_autresfrais_previsionnel,
			  quantite_autresfrais_previsionnel,
			  prix_autresfrais_previsionnel,
			  id_previsionnelle,
			  created_by,
			  date_saisie_autresfrais_previsionnel)
			  VALUES(
			  :objet,
			  :unite,
			  :quantite,
			  :prix,
			  :iddp,
			  :user,
			  NOW())';
     		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':objet', $objet, PDO::PARAM_STR);
        $query->bindValue(':unite', $unite, PDO::PARAM_STR);
        $query->bindValue(':quantite', $quantite, PDO::PARAM_INT);
		$query->bindValue(':prix', $prix, PDO::PARAM_INT);
		$query->bindValue(':iddp', $iddp, PDO::PARAM_INT);
		$query->bindValue(':user', $user, PDO::PARAM_STR);
		$query->execute() or die(print_r($query->errorInfo()));
		
		$query->closeCursor();
	    
	}
	
	
	
	
	
	function enregistrer_engin_previsionnelle($code,  $nom, $puissance, $marque, $nbjour, $locationjour, $conso_car_jour, $prix_carburant, $conso_lub_jour, $prix_lubrifiant, $iddp, $user) {
	
	    $sql = 'INSERT INTO engin_prevision (
		      code_engin_previsionnel,
			  nom_engin_previsionnel,
			  puissance_engin_previsionnel,
			  marque_engin_previsionnel,
			  nombre_jour_engin_previsionnel,
			  location_par_jour_engin_previsionnel,
			  consommation_carburant_par_jour_engin_previsionnel,
			  prix_carburant_engin_previsionnel,
			  consommation_lubrifiant_par_jour_engin_previsionnel,
			  prix_lubrifiant_engin_previsionnel,
			  id_previsionnelle,
			  created_by,
			  date_saisie_engin_previsionnel)
			  VALUES(
			  :code,
			  :nom,
			  :puissance,
			  :marque,
			  :nbjour,
			  :locationjour,
			  :carburant,
			  :prixcarburant,
			  :lubrifiant,
			  :prixlubrifiant,
			  :iddp,
			  :user,
			  NOW())';
     		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':code', $code, PDO::PARAM_STR);
        $query->bindValue(':nom', $nom, PDO::PARAM_STR);
        $query->bindValue(':puissance', $puissance, PDO::PARAM_STR);
		$query->bindValue(':marque', $marque, PDO::PARAM_INT);
		$query->bindValue(':nbjour', $nbjour, PDO::PARAM_INT);
        $query->bindValue(':locationjour', $locationjour, PDO::PARAM_INT);
		$query->bindValue(':carburant', $conso_car_jour, PDO::PARAM_STR);
        $query->bindValue(':prixcarburant', $prix_carburant, PDO::PARAM_STR);
		$query->bindValue(':lubrifiant', $conso_lub_jour, PDO::PARAM_STR);
		$query->bindValue(':prixlubrifiant', $prix_lubrifiant, PDO::PARAM_STR);
		$query->bindValue(':iddp', $iddp, PDO::PARAM_INT);
		$query->bindValue(':user', $user, PDO::PARAM_STR);
		$query->execute() or die(print_r($query->errorInfo()));
		
		$query->closeCursor();
	    
	}
	
	
	
	
	function enregistrer_engin_execution($code,  $nom, $puissance, $marque, $nbjour, $locationjour, $conso_car_jour, $prix_carburant, $conso_lub_jour, $prix_lubrifiant, $idde, $user) {
	
	    $sql = 'INSERT INTO engin_execution (
		      code_engin_execution,
			  nom_engin_execution,
			  puissance_engin_execution,
			  marque_engin_execution,
			  nombre_jour_engin_execution,
			  location_par_jour_engin_execution,
			  consommation_carburant_par_jour_engin_execution,
			  prix_carburant_engin_execution,
			  consommation_lubrifiant_par_jour_engin_execution,
			  prix_lubrifiant_engin_execution,
			  id_execution,
			  created_by,
			  date_saisie_engin_execution)
			  VALUES(
			  :code,
			  :nom,
			  :puissance,
			  :marque,
			  :nbjour,
			  :locationjour,
			  :carburant,
			  :prixcarburant,
			  :lubrifiant,
			  :prixlubrifiant,
			  :idde,
			  :user,
			  NOW())';
     		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':code', $code, PDO::PARAM_STR);
        $query->bindValue(':nom', $nom, PDO::PARAM_STR);
        $query->bindValue(':puissance', $puissance, PDO::PARAM_STR);
		$query->bindValue(':marque', $marque, PDO::PARAM_INT);
		$query->bindValue(':nbjour', $nbjour, PDO::PARAM_INT);
        $query->bindValue(':locationjour', $locationjour, PDO::PARAM_INT);
		$query->bindValue(':carburant', $conso_car_jour, PDO::PARAM_STR);
        $query->bindValue(':prixcarburant', $prix_carburant, PDO::PARAM_STR);
		$query->bindValue(':lubrifiant', $conso_lub_jour, PDO::PARAM_STR);
		$query->bindValue(':prixlubrifiant', $prix_lubrifiant, PDO::PARAM_STR);
		$query->bindValue(':idde', $idde, PDO::PARAM_INT);
		$query->bindValue(':user', $user, PDO::PARAM_STR);
		$query->execute() or die(print_r($query->errorInfo()));
		
		$query->closeCursor();
	    
	}
	
	
	
	
	
	
	function enregistrer_matroulant_previsionnelle($code,  $nom, $puissance, $marque, $nbjour, $locationjour, $conso_car_jour, $prix_carburant, $conso_lub_jour, $prix_lubrifiant, $iddp, $user) {
	
	    $sql = 'INSERT INTO matroulant_prevision (
		      code_matroulant_previsionnel,
			  nom_matroulant_previsionnel,
			  puissance_matroulant_previsionnel,
			  marque_matroulant_previsionnel,
			  nombre_jour_matroulant_previsionnel,
			  location_par_jour_matroulant_previsionnel,
			  consommation_carburant_par_jour_matroulant_previsionnel,
			  prix_carburant_matroulant_previsionnel,
			  consommation_lubrifiant_par_jour_matroulant_previsionnel,
			  prix_lubrifiant_matroulant_previsionnel,
			  id_previsionnelle,
			  created_by,
			  date_saisie_matroulant_previsionnel)
			  VALUES(
			  :code,
			  :nom,
			  :puissance,
			  :marque,
			  :nbjour,
			  :locationjour,
			  :carburant,
			  :prixcarburant,
			  :lubrifiant,
			  :prixlubrifiant,
			  :iddp,
			  :user,
			  NOW())';
     		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':code', $code, PDO::PARAM_STR);
        $query->bindValue(':nom', $nom, PDO::PARAM_STR);
        $query->bindValue(':puissance', $puissance, PDO::PARAM_STR);
		$query->bindValue(':marque', $marque, PDO::PARAM_INT);
		$query->bindValue(':nbjour', $nbjour, PDO::PARAM_INT);
        $query->bindValue(':locationjour', $locationjour, PDO::PARAM_INT);
		$query->bindValue(':carburant', $conso_car_jour, PDO::PARAM_STR);
        $query->bindValue(':prixcarburant', $prix_carburant, PDO::PARAM_STR);
		$query->bindValue(':lubrifiant', $conso_lub_jour, PDO::PARAM_STR);
		$query->bindValue(':prixlubrifiant', $prix_lubrifiant, PDO::PARAM_STR);
		$query->bindValue(':iddp', $iddp, PDO::PARAM_INT);
		$query->bindValue(':user', $user, PDO::PARAM_STR);
		$query->execute() or die(print_r($query->errorInfo()));
		
		$query->closeCursor();
	    
	}
	
	
	
	
	
	function enregistrer_matroulant_execution($code,  $nom, $puissance, $marque, $nbjour, $locationjour, $conso_car_jour, $prix_carburant, $conso_lub_jour, $prix_lubrifiant, $idde, $user) {
	
	    $sql = 'INSERT INTO matroulant_execution (
		      code_matroulant_execution,
			  nom_matroulant_execution,
			  puissance_matroulant_execution,
			  marque_matroulant_execution,
			  nombre_jour_matroulant_execution,
			  location_par_jour_matroulant_execution,
			  consommation_carburant_par_jour_matroulant_execution,
			  prix_carburant_matroulant_execution,
			  consommation_lubrifiant_par_jour_matroulant_execution,
			  prix_lubrifiant_matroulant_execution,
			  id_execution,
			  created_by,
			  date_saisie_matroulant_execution)
			  VALUES(
			  :code,
			  :nom,
			  :puissance,
			  :marque,
			  :nbjour,
			  :locationjour,
			  :carburant,
			  :prixcarburant,
			  :lubrifiant,
			  :prixlubrifiant,
			  :idde,
			  :user,
			  NOW())';
     		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':code', $code, PDO::PARAM_STR);
        $query->bindValue(':nom', $nom, PDO::PARAM_STR);
        $query->bindValue(':puissance', $puissance, PDO::PARAM_STR);
		$query->bindValue(':marque', $marque, PDO::PARAM_INT);
		$query->bindValue(':nbjour', $nbjour, PDO::PARAM_INT);
        $query->bindValue(':locationjour', $locationjour, PDO::PARAM_INT);
		$query->bindValue(':carburant', $conso_car_jour, PDO::PARAM_STR);
        $query->bindValue(':prixcarburant', $prix_carburant, PDO::PARAM_STR);
		$query->bindValue(':lubrifiant', $conso_lub_jour, PDO::PARAM_STR);
		$query->bindValue(':prixlubrifiant', $prix_lubrifiant, PDO::PARAM_STR);
		$query->bindValue(':idde', $idde, PDO::PARAM_INT);
		$query->bindValue(':user', $user, PDO::PARAM_STR);
		$query->execute() or die(print_r($query->errorInfo()));
		
		$query->closeCursor();
	    
	}
	
	
	
	
	
	
	function enregistrer_materiel_previsionnelle($code, $nom, $unite, $quantite, $cout, $iddp, $user) {
	
	    $sql = 'INSERT INTO materiel_prevision (
		      code_materiel_previsionnel,
			  nom_materiel_previsionnel,
			  unite_materiel_previsionnel,
			  quantite_materiel_previsionnel,
			  cout_materiel_previsionnel,
			  id_previsionnelle,
			  created_by,
			  date_saisie_materiel_previsionnel)
			  VALUES(
			  :code,
			  :nom,
			  :unite,
			  :quantite,
			  :cout,
			  :iddp,
			  :user,
			  NOW())';
     		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':code', $code, PDO::PARAM_STR);
		$query->bindValue(':nom', $nom, PDO::PARAM_STR);
        $query->bindValue(':unite', $unite, PDO::PARAM_STR);
        $query->bindValue(':quantite', $quantite, PDO::PARAM_INT);
		$query->bindValue(':cout', $cout, PDO::PARAM_INT);
		$query->bindValue(':iddp', $iddp, PDO::PARAM_INT);
		$query->bindValue(':user', $user, PDO::PARAM_STR);
		$query->execute() or die(print_r($query->errorInfo()));
		
		$query->closeCursor();
	    
	}
	
	
	
	
	function enregistrer_materiel_execution($code, $nom, $unite, $quantite, $cout, $idde, $user) {
	
	    $sql = 'INSERT INTO materiel_execution (
		      code_materiel_execution,
			  nom_materiel_execution,
			  unite_materiel_execution,
			  quantite_materiel_execution,
			  cout_materiel_execution,
			  id_execution,
			  created_by,
			  date_saisie_materiel_execution)
			  VALUES(
			  :code,
			  :nom,
			  :unite,
			  :quantite,
			  :cout,
			  :idde,
			  :user,
			  NOW())';
     		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':code', $code, PDO::PARAM_STR);
		$query->bindValue(':nom', $nom, PDO::PARAM_STR);
        $query->bindValue(':unite', $unite, PDO::PARAM_STR);
        $query->bindValue(':quantite', $quantite, PDO::PARAM_INT);
		$query->bindValue(':cout', $cout, PDO::PARAM_INT);
		$query->bindValue(':idde', $idde, PDO::PARAM_INT);
		$query->bindValue(':user', $user, PDO::PARAM_STR);
		$query->execute() or die(print_r($query->errorInfo()));
		
		$query->closeCursor();
	    
	}
	
	
	
	
	
	function enregistrer_personnelle_execution($matricule, $fonction, $salaire, $nombre_h, $idde, $user) {
	
	    $sql = 'INSERT INTO personnel_execution (
		      matricule_personnel_execution,
			  fonction_personnel_execution,
			  salaire_horaire_personnel_execution,
			  nombre_horaire_personnel_execution,
			  id_execution,
			  created_by,
			  date_saisie_personnel_execution)
			  VALUES(
			  :matricule,
			  :fonction,
			  :salaire,
			  :nombreh,
			  :idde,
			  :user,
			  NOW())';
     		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':matricule', $matricule, PDO::PARAM_STR);
        $query->bindValue(':fonction', $fonction, PDO::PARAM_STR);
        $query->bindValue(':salaire', $salaire, PDO::PARAM_INT);
		$query->bindValue(':nombreh', $nombre_h, PDO::PARAM_INT);
		$query->bindValue(':idde', $idde, PDO::PARAM_INT);
		$query->bindValue(':user', $user, PDO::PARAM_STR);
		$query->execute() or die(print_r($query->errorInfo()));
		
		$query->closeCursor();
	    
	}
	
	
	
	
	
	
	function enregistrer_autresfrais_execution($objet, $unite, $quantite, $prix, $idde, $user) {
	
	    $sql = 'INSERT INTO autrefrais_execution (
		      objet_autresfrais_execution,
			  unite_autresfrais_execution,
			  quantite_autresfrais_execution,
			  prix_autresfrais_execution,
			  id_execution,
			  created_by,
			  date_saisie_autresfrais_execution)
			  VALUES(
			  :objet,
			  :unite,
			  :quantite,
			  :prix,
			  :idde,
			  :user,
			  NOW())';
     		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':objet', $objet, PDO::PARAM_STR);
        $query->bindValue(':unite', $unite, PDO::PARAM_STR);
        $query->bindValue(':quantite', $quantite, PDO::PARAM_INT);
		$query->bindValue(':prix', $prix, PDO::PARAM_INT);
		$query->bindValue(':idde', $idde, PDO::PARAM_INT);
		$query->bindValue(':user', $user, PDO::PARAM_STR);
		$query->execute() or die(print_r($query->errorInfo()));
		
		$query->closeCursor();
	    
	}
	
	
	
	
function enregistrer_execution($nature, $unite, $quantite, $duree, $id, $user) {
	
	    $sql = 'INSERT INTO execution (
		      nature_travaux_execution,
			  unite_execution,
			  quantite_execution,
			  duree_execution,
			  id_projet,
			  created_by,
			  date_saisie_execution)
			  VALUES(
			  :nature,
			  :unite,
			  :quantite,
			  :duree,
			  :idprojet,
			  :user,
			  NOW())';
     		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':nature', $nature, PDO::PARAM_STR);
        $query->bindValue(':unite', $unite, PDO::PARAM_STR);
        $query->bindValue(':quantite', $quantite, PDO::PARAM_INT);
		$query->bindValue(':duree', $duree, PDO::PARAM_STR);
		$query->bindValue(':idprojet', $id, PDO::PARAM_INT);
		$query->bindValue(':user', $user, PDO::PARAM_STR);
		$query->execute() or die(print_r($query->errorInfo()));
		
		$query->closeCursor();
	    
}




function enregistrer_operation($date, $libele, $montant, $idp, $user) {
	
	    $sql = 'INSERT INTO operation (
		      operation_libele,
			  operation_montant,
			  operation_date,
			  operation_date_saisie,
			  operation_created_by,
			  id_projet)
			  VALUES(
			  :libele,
			  :montant,
			  :date,
			  NOW(),
			  :user,
			  :idp)';
     		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':libele', $libele, PDO::PARAM_STR);
        $query->bindValue(':montant', $montant, PDO::PARAM_STR);
        $query->bindValue(':date', $date, PDO::PARAM_STR);
		$query->bindValue(':user', $user, PDO::PARAM_STR);
		$query->bindValue(':idp', $idp, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
		
		$query->closeCursor();
	    
}


		
function is_projet_exist($id) {
	
	    $sql = "SELECT COUNT('id_projet')
                    FROM projet
                    WHERE id_projet = :id
                    ";
        $db = connection();
		 
        $query = $db->prepare($sql);
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->execute() or die(print_r($query->errorInfo()));

        $rows = $query->fetchColumn();
            
	    $query->closeCursor();
			
        if($rows == 1) 
            return true;
        else
            return false;
	
}
   
   
   
   function is_projet_has_donnee_prevision($id) {
	
	    $sql = "SELECT COUNT('id_projet')
                    FROM projet
					INNER JOIN previsionnelle USING(id_projet)
                    WHERE id_projet = :id
                    ";
        $db = connection();
		 
        $query = $db->prepare($sql);
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->execute() or die(print_r($query->errorInfo()));

        $rows = $query->fetchColumn();
            
	    $query->closeCursor();
			
        if($rows >= 1) 
            return true;
        else
            return false;
	
   }
	
	
   
   
   function is_previsionnelle_has_donnee_personnel($iddp) {
	
	    $sql = "SELECT COUNT('id_previsionnelle')
                    FROM previsionnelle
					INNER JOIN personnel_prevision USING(id_previsionnelle)
                    WHERE id_previsionnelle = :id
                    ";
        $db = connection();
		 
        $query = $db->prepare($sql);
        $query->bindValue(':id', $iddp, PDO::PARAM_INT);
        $query->execute() or die(print_r($query->errorInfo()));

        $rows = $query->fetchColumn();
            
	    $query->closeCursor();
			
        if($rows >= 1) 
            return true;
        else
            return false;
	
   }
	
	
	
	
	
   function is_previsionnelle_has_donnee_autresfrais($iddp) {
	
	    $sql = "SELECT COUNT('id_previsionnelle')
                    FROM previsionnelle
					INNER JOIN autrefrais_prevision USING(id_previsionnelle)
                    WHERE id_previsionnelle = :id
                    ";
        $db = connection();
		 
        $query = $db->prepare($sql);
        $query->bindValue(':id', $iddp, PDO::PARAM_INT);
        $query->execute() or die(print_r($query->errorInfo()));

        $rows = $query->fetchColumn();
            
	    $query->closeCursor();
			
        if($rows >= 1) 
            return true;
        else
            return false;
	
   }
   
   
   
   function is_previsionnelle_has_donnee_materiel($iddp) {
	
	    $sql = "SELECT COUNT('id_previsionnelle')
                    FROM previsionnelle
					INNER JOIN materiel_prevision USING(id_previsionnelle)
                    WHERE id_previsionnelle = :id
                    ";
        $db = connection();
		 
        $query = $db->prepare($sql);
        $query->bindValue(':id', $iddp, PDO::PARAM_INT);
        $query->execute() or die(print_r($query->errorInfo()));

        $rows = $query->fetchColumn();
            
	    $query->closeCursor();
			
        if($rows >= 1) 
            return true;
        else
            return false;
	
   }
  



  function is_execution_has_donnee_materiel($idde) {
	
	    $sql = "SELECT COUNT('id_execution')
                    FROM execution
					INNER JOIN materiel_execution USING(id_execution)
                    WHERE id_execution = :id
                    ";
        $db = connection();
		 
        $query = $db->prepare($sql);
        $query->bindValue(':id', $idde, PDO::PARAM_INT);
        $query->execute() or die(print_r($query->errorInfo()));

        $rows = $query->fetchColumn();
            
	    $query->closeCursor();
			
        if($rows >= 1) 
            return true;
        else
            return false;
	
   }
    
   
   
   
   
   function is_previsionnelle_has_donnee_engin($iddp) {
	
	    $sql = "SELECT COUNT('id_previsionnelle')
                    FROM previsionnelle
					INNER JOIN engin_prevision USING(id_previsionnelle)
                    WHERE id_previsionnelle = :id
                    ";
        $db = connection();
		 
        $query = $db->prepare($sql);
        $query->bindValue(':id', $iddp, PDO::PARAM_INT);
        $query->execute() or die(print_r($query->errorInfo()));

        $rows = $query->fetchColumn();
            
	    $query->closeCursor();
			
        if($rows >= 1) 
            return true;
        else
            return false;
	
   }
   
   
   
   
   
   function is_execution_has_donnee_engin($idde) {
	
	    $sql = "SELECT COUNT('id_execution')
                    FROM execution
					INNER JOIN engin_execution USING(id_execution)
                    WHERE id_execution = :id
                    ";
        $db = connection();
		 
        $query = $db->prepare($sql);
        $query->bindValue(':id', $idde, PDO::PARAM_INT);
        $query->execute() or die(print_r($query->errorInfo()));

        $rows = $query->fetchColumn();
            
	    $query->closeCursor();
			
        if($rows >= 1) 
            return true;
        else
            return false;
	
   }
   
   
   
   
   
   
   function is_previsionnelle_has_donnee_matroulant($iddp) {
	
	    $sql = "SELECT COUNT('id_previsionnelle')
                    FROM previsionnelle
					INNER JOIN  matroulant_prevision USING(id_previsionnelle)
                    WHERE id_previsionnelle = :id
                    ";
        $db = connection();
		 
        $query = $db->prepare($sql);
        $query->bindValue(':id', $iddp, PDO::PARAM_INT);
        $query->execute() or die(print_r($query->errorInfo()));

        $rows = $query->fetchColumn();
            
	    $query->closeCursor();
			
        if($rows >= 1) 
            return true;
        else
            return false;
	
   }
	
	
	
	
	
	function is_execution_has_donnee_matroulant($idde) {
	
	    $sql = "SELECT COUNT('id_execusion')
                    FROM execution
					INNER JOIN  matroulant_execution USING(id_execution)
                    WHERE id_execution = :id
                    ";
        $db = connection();
		 
        $query = $db->prepare($sql);
        $query->bindValue(':id', $idde, PDO::PARAM_INT);
        $query->execute() or die(print_r($query->errorInfo()));

        $rows = $query->fetchColumn();
            
	    $query->closeCursor();
			
        if($rows >= 1) 
            return true;
        else
            return false;
	
   }
	
	
	
	
	
	
	 function is_execution_has_donnee_personnel($idde) {
	
	    $sql = "SELECT COUNT('id_execution')
                    FROM execution
					INNER JOIN personnel_execution USING(id_execution)
                    WHERE id_execution = :id
                    ";
        $db = connection();
		 
        $query = $db->prepare($sql);
        $query->bindValue(':id', $idde, PDO::PARAM_INT);
        $query->execute() or die(print_r($query->errorInfo()));

        $rows = $query->fetchColumn();
            
	    $query->closeCursor();
			
        if($rows >= 1) 
            return true;
        else
            return false;
	
   }
   
   
   
   
   
	 function is_execution_has_donnee_autresfrais($idde) {
	
	    $sql = "SELECT COUNT('id_execution')
                    FROM execution
					INNER JOIN autrefrais_execution USING(id_execution)
                    WHERE id_execution = :id
                    ";
        $db = connection();
		 
        $query = $db->prepare($sql);
        $query->bindValue(':id', $idde, PDO::PARAM_INT);
        $query->execute() or die(print_r($query->errorInfo()));

        $rows = $query->fetchColumn();
            
	    $query->closeCursor();
			
        if($rows >= 1) 
            return true;
        else
            return false;
	
   }
	
   
function is_projet_has_donnee_execution($id) {
	
	    $sql = "SELECT COUNT('id_projet')
                    FROM projet
					INNER JOIN execution USING(id_projet)
                    WHERE id_projet = :id
                    ";
        $db = connection();
		 
        $query = $db->prepare($sql);
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->execute() or die(print_r($query->errorInfo()));

        $rows = $query->fetchColumn();
            
	    $query->closeCursor();
			
        if($rows >= 1) 
            return true;
        else
            return false;
	
}
   



function is_projet_has_donnee_operation($id) {
	
	    $sql = "SELECT COUNT('id_projet')
                    FROM projet
					INNER JOIN operation USING(id_projet)
                    WHERE id_projet = :id
                    ";
        $db = connection();
		 
        $query = $db->prepare($sql);
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->execute() or die(print_r($query->errorInfo()));

        $rows = $query->fetchColumn();
            
	    $query->closeCursor();
			
        if($rows >= 1) 
            return true;
        else
            return false;
	
}
   


   
   
   
function resultats_prevision($idp) {
   
       $sql = 'SELECT * 
	             FROM projet
                 INNER JOIN previsionnelle USING(id_projet)
				 ORDER BY date_saisie_projet DESC';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $list = $query->fetchAll();
	   
	    $query->closeCursor();
	   
	    return $list;
   
   
   }
   
   
   function resultats_execution($idp) {
   
       $sql = 'SELECT * 
	             FROM projet
                 INNER JOIN previsionnelle USING(id_projet)
				 ORDER BY date_saisie_projet DESC';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $list = $query->fetchAll();
	   
	    $query->closeCursor();
	   
	    return $list;
   
   }
   
   
   
   function salairePerExe($ide) {
   
       $sql = 'SELECT SUM(salaire_horaire_personnel_execution * nombre_horaire_personnel_execution)
	             FROM personnel_execution
				 WHERE id_execution = :ide';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':ide', $ide, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $list = $query->fetch();
	   
	    $query->closeCursor();
	   
	    return $list;
   
}
   
   
   
   function salairePerPrev($iddp) {
   
       $sql = 'SELECT SUM(salaire_horaire_personnel_previsionnelle * nombre_horaire_personnel_previsionnelle)
	             FROM personnel_prevision
				 WHERE id_previsionnelle = :iddp';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':iddp', $iddp, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $list = $query->fetch();
	   
	    $query->closeCursor();
	   
	    return $list;
   
   }
   
   
   
   function fraisEngExe($ide) {
   
       $sql = 'SELECT SUM(location_par_jour_engin_execution), SUM(nombre_jour_engin_execution), SUM(prix_carburant_engin_execution), SUM(prix_lubrifiant_engin_execution)
	             FROM engin_execution
				 WHERE id_execution = :ide';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':ide', $ide, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $list = $query->fetch();
	   
	    $query->closeCursor();
	   
	    return $list;
   
   }
   
   
   
    function fraisEngPrev($iddp) {
   
       $sql = 'SELECT SUM(location_par_jour_engin_previsionnel), SUM(nombre_jour_engin_previsionnel), SUM(prix_carburant_engin_previsionnel), SUM(prix_lubrifiant_engin_previsionnel)
	             FROM engin_prevision
				 WHERE id_previsionnelle = :iddp';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':iddp', $iddp, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $list = $query->fetch();
	   
	    $query->closeCursor();
	   
	    return $list;
   
   }
   
   
   
   
   function fraisRoulExe($ide) {
   
       $sql = 'SELECT SUM(location_par_jour_matroulant_execution), SUM(nombre_jour_matroulant_execution), SUM(prix_carburant_matroulant_execution), SUM(prix_lubrifiant_matroulant_execution)
	             FROM matroulant_execution
				 WHERE id_execution = :ide';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':ide', $ide, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $list = $query->fetch();
	   
	    $query->closeCursor();
	   
	    return $list;
   }
   
   
   
   
   
   function fraisRoulPrev($iddp) {
   
       $sql = 'SELECT SUM(location_par_jour_matroulant_previsionnel), SUM(nombre_jour_matroulant_previsionnel), SUM(prix_carburant_matroulant_previsionnel), SUM(prix_lubrifiant_matroulant_previsionnel)
	             FROM matroulant_prevision
				 WHERE id_previsionnelle = :iddp';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':iddp', $iddp, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $list = $query->fetch();
	   
	    $query->closeCursor();
	   
	    return $list;
   }
   
   
   
   
     function fraisMatChantExe($ide) {
   
       $sql = 'SELECT SUM(cout_materiel_execution * quantite_materiel_execution)
	             FROM materiel_execution
				 WHERE id_execution = :ide';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':ide', $ide, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $list = $query->fetch();
	   
	    $query->closeCursor();
	   
	    return $list;
   }
   
   
   

     function fraisMatChantPrev($iddp) {
   
       $sql = 'SELECT SUM(cout_materiel_previsionnel * quantite_materiel_previsionnel)
	             FROM materiel_prevision
				 WHERE id_previsionnelle = :iddp';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':iddp', $iddp, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $list = $query->fetch();
	   
	    $query->closeCursor();
	   
	    return $list;
   }
   
   
   
     function autresFraisExe($ide) {
   
       $sql = 'SELECT SUM(quantite_autresfrais_execution * prix_autresfrais_execution)
	             FROM autrefrais_execution
				 WHERE id_execution = :ide';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':ide', $ide, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $list = $query->fetch();
	   
	    $query->closeCursor();
	   
	    return $list;
   }
   
   
   
    function autresFraisPrev($iddp) {
   
       $sql = 'SELECT SUM(quantite_autresfrais_previsionnel * prix_autresfrais_previsionnel)
	             FROM autrefrais_prevision
				 WHERE id_previsionnelle = :iddp';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':iddp', $iddp, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $list = $query->fetch();
	   
	    $query->closeCursor();
	   
	    return $list;
   }
   
   
   
   function getProsDate() {
       
	   $sql = 'SELECT date_projet
	             FROM projet
				 ORDER BY date_projet DESC';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->execute() or die(print_r($query->errorInfo()));
	     
       $list = $query->fetchAll();
	   
	    $query->closeCursor();
	   
	    return $list;
	   
   }
   
   
   
     
   
  
   
  function DepexByPro($id) {
       
	   $d = 0.0;
	   $list = array();
	   
	   
       $sql = 'SELECT 
                             SUM(
                                      COALESCE((p.salaire_horaire_personnel_execution * p.nombre_horaire_personnel_execution), 0)
                            ) as personnel
       

                FROM execution
                RIGHT JOIN personnel_execution p USING(id_execution)
                INNER JOIN projet USING(id_projet)
                WHERE projet.id_projet = :id';
   
        $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':id', $id, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $tp = $query->fetch();
		$d += $tp[0];
	   
	    $query->closeCursor();
	   
	   
	    
		$sql = 'SELECT 
                             SUM(
                                      COALESCE((m.cout_materiel_execution * m.quantite_materiel_execution), 0)
                            ) as materiel
       

                FROM execution
                RIGHT JOIN materiel_execution m USING(id_execution)
                INNER JOIN projet USING(id_projet)
                WHERE projet.id_projet = :id';
   
        $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':id', $id, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $tm = $query->fetch();
		$d += $tm[0];
	   
	    $query->closeCursor();
		
	   
	   
	   
	   
	   $sql = 'SELECT 
                             SUM(
                                      COALESCE((en.location_par_jour_engin_execution + en.prix_carburant_engin_execution + en.prix_lubrifiant_engin_execution), 0)
                            ) as engin
       

                FROM execution
                RIGHT JOIN engin_execution en USING(id_execution)
                INNER JOIN projet USING(id_projet)
                WHERE projet.id_projet = :id';
   
        $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':id', $id, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $te = $query->fetch();
		$d += $te[0];
	   
	    $query->closeCursor();
	   
	   
	   
	   
	   
	    
	   $sql = 'SELECT 
                             SUM(
                                      COALESCE((roul.location_par_jour_matroulant_execution + roul.prix_carburant_matroulant_execution + roul.prix_lubrifiant_matroulant_execution), 0)
                            ) as roulant
       

                FROM execution
                RIGHT JOIN matroulant_execution roul USING(id_execution)
                INNER JOIN projet USING(id_projet)
                WHERE projet.id_projet = :id';
   
        $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':id', $id, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $tr = $query->fetch();
		$d += $tr[0];
	   
	    $query->closeCursor();
	   
	   
	    
	
		$sql = 'SELECT 
                             SUM(
                                      COALESCE((aut.quantite_autresfrais_execution * aut.prix_autresfrais_execution), 0)
                            ) as autrefrais
       

                FROM execution
                RIGHT JOIN autrefrais_execution aut USING(id_execution)
                INNER JOIN projet USING(id_projet)
                WHERE projet.id_projet = :id';
   
        $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':id', $id, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $ta = $query->fetch();
		$d += $ta[0];
	   
	    $query->closeCursor();
		
		
		
		
	    return $d;
   
   
   
   }
   
   
   
   
   
   function logout() {
	    
		session_unset();
		session_destroy();
		
		header('location: index.php');
	}
	
	
	function is_logged() {
	     
		 if (!session_id()) session_start();
		 
		 if(isset($_SESSION['login']) && isset($_SESSION['pwd']))
		     return true;
		 else
		     return false;
	
	}
	
	
	function logged_protected() {
	
	    if(is_logged() === true) header('location: gestion.php');
	}
	
	
function expired() {
	
	    $expire_time = 10 * 60;
		if( $_SESSION['la'] < time() - $expire_time) {
		    header('refresh :5 ; url=logout.php');
		    logout();
	    }
	}
	
	
	function logout_protected() {
	    
		if(is_logged() === false) header('location: index.php'); 
	}
	
	
	
function super_AND_chef_protected($login, $id) {
	    
		if(!isSuperUser($login) && !isUserIsChef($id))
		    logout();
		
		//if(is_logged() === false) header('location: index.php'); 
}




function super_protected($login, $id) {
	    
		if(!isSuperUser($login))
		    logout();
		
		//if(is_logged() === false) header('location: index.php'); 
}



	
function start_session() { 
	    if (!session_id()) session_start();
}
   
   
   
     
function isProNameExist($name) {
	    
		$name = strtolower($name);
		
	    $sql = "SELECT COUNT('objet_projet')
                    FROM projet
                    WHERE objet_projet = :name
                    ";
        $db = connection();
		 
        $query = $db->prepare($sql);
        $query->bindValue(':name', $name, PDO::PARAM_STR);
        $query->execute() or die(print_r($query->errorInfo()));

        $rows = $query->fetchColumn();
            
	    $query->closeCursor();
			
        if($rows >= 1) 
            return true;
        else
            return false;
	
   }
	
   
   
   
function removeProjet($idp) {
       
	   $sql = 'DELETE execution.*,
                               aut.*,
                               en.*,
                               mat.*,
                               roul.*,
                               pers.*,
							   logpers.*,
							   logau.*,
							   logeng.*,
							   logroul.*,
							   logchan.*
                               						   
	             FROM  execution
	             LEFT JOIN autrefrais_execution aut USING(id_execution)
				 LEFT JOIN engin_execution en USING(id_execution)
				 LEFT JOIN materiel_execution mat USING(id_execution)
				 LEFT JOIN matroulant_execution roul USING(id_execution)
				 LEFT JOIN personnel_execution pers USING(id_execution)

				 LEFT JOIN logpersonnelexecution logpers ON logpers.id_execution = execution.id_execution
				 LEFT JOIN logautresfraisexecution logau ON logau.id_execution = execution.id_execution
				 LEFT JOIN logenginexecution logeng ON logeng.id_execution = execution.id_execution
				 LEFT JOIN logmatroulantexecution logroul ON logroul.id_execution = execution.id_execution
                 LEFT JOIN logmatchantierexecution logchan ON logchan.id_execution = execution.id_execution 				 
				 
				 RIGHT JOIN projet pro USING(id_projet)
	             WHERE pro.id_projet = :id';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':id', $idp, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	    
	    $query->closeCursor();
				
		
		
		$sql = 'DELETE pro.*,
	                              previsionnelle.*,
                                  aut.*,
                                  en.*,
                                  mat.*,
                                  roul.*,
                                 pers.*,
								 logpers.*,
							     logau.*,
							     logeng.*,
							     logroul.*,
							     logchan.*
                               						   
	             FROM  previsionnelle
	             LEFT JOIN autrefrais_prevision aut USING(id_previsionnelle)
				 LEFT JOIN engin_prevision en USING(id_previsionnelle)
				 LEFT JOIN materiel_prevision mat USING(id_previsionnelle)
				 LEFT JOIN matroulant_prevision roul USING(id_previsionnelle)
				 LEFT JOIN personnel_prevision pers USING(id_previsionnelle)
				 
				 LEFT JOIN logpersonnelprevision logpers ON logpers.id_previsionnelle = previsionnelle.id_previsionnelle
				 LEFT JOIN logautresfraisprevision logau ON logau.id_previsionnelle = previsionnelle.id_previsionnelle
				 LEFT JOIN logenginprevision logeng ON logeng.id_previsionnelle = previsionnelle.id_previsionnelle
				 LEFT JOIN logmatroulantprevision logroul ON logroul.id_previsionnelle = previsionnelle.id_previsionnelle
				 LEFT JOIN logmatchantierprevision logchan ON logchan.id_previsionnelle = previsionnelle.id_previsionnelle
				 
				 RIGHT JOIN projet pro USING(id_projet)
	             WHERE pro.id_projet = :id';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':id', $idp, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	    
	    $query->closeCursor();
		
	   
}
   
   
   
   
      
 function editProjet($idp, $code, $objet, $date, $taxe, $taux, $montant, $cid) {
       
	    $msg = '';
        $fo = 0;
        $fd = 0;
        $ftax = 0;
		$ftau = 0;
        
        $oi = infos_projet($idp);
		
        if($oi['objet_projet'] != $objet) {
            $fo = 1;
            $msg .=  'Changé <em>objet du projet</em>';
        }
        if($oi['date_projet'] != $date) {
            $fd = 1;
            if($fo == 1)
                $msg .= ', changé <em>date du projet</em>';
            else
                $msg .= 'Changé <em>date du projet</em>';
        }
        if($oi['taxe_projet'] != $taxe) {
            $ftax = 1;
            if($fo == 1 || $fd == 1)
                $msg .= ', changé <em>la taxe</em>';
            else 
                $msg .= 'Changé <em>la taxe</em>';
        }
        if($oi['taux'] != $taux) {
            $ftau = 1;
            if($fo == 1 || $fd == 1 || $ftax == 1)
                $msg .= ', changé <em>le taux</em>';
            else 
                $msg .= 'Changé <em>le taux</em>';
        }if($oi['montant_ht_projet'] != $montant) {
            $ftax = 1;
            if($fo == 1 || $fd == 1 || $ftax == 1 || $ftau == 1)
                $msg .= ', changé <em>le montant hors taxe</em>';
            else 
                $msg .= 'Changé <em>le montant hors taxe</em>';
        }
	   
     
	  if(!empty($msg)) { 
           //$cid = getUserIdByName($cuser);
           logProjet($cid, $idp, $msg);
       }
	    
	 
   
       $sql = 'UPDATE projet
	             SET code_projet = :code, objet_projet = :objet, date_projet = :date, taxe_projet = :taxe, taux = :taux, montant_ht_projet = :mht, date_updated_projet = NOW()
				 WHERE id_projet = :id';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':code', $code, PDO::PARAM_STR);
		$query->bindValue(':objet', $objet, PDO::PARAM_STR);
		$query->bindValue(':date', $date, PDO::PARAM_STR);
		$query->bindValue(':taxe', $taxe, PDO::PARAM_STR);
		$query->bindValue(':taux', $taux, PDO::PARAM_STR);
		$query->bindValue(':mht', $montant, PDO::PARAM_STR);
		$query->bindValue(':id', $idp, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
	    $query->closeCursor();
	   
   }
   
   
   function removeExecution($idp, $idde) {
   
       $sql = 'DELETE execution.*,
                               aut.*,
                               en.*,
                               mat.*,
                               roul.*,
                               pers.*,
							   logexe.*
                               						   
	             FROM  execution
	             LEFT JOIN autrefrais_execution aut USING(id_execution)
				 LEFT JOIN engin_execution en USING(id_execution)
				 LEFT JOIN materiel_execution mat USING(id_execution)
				 LEFT JOIN matroulant_execution roul USING(id_execution)
				 LEFT JOIN personnel_execution pers USING(id_execution)
				 LEFT JOIN logexecution logexe ON logexe.log_execution_execution_id = execution.id_execution 
				 RIGHT JOIN projet pro USING(id_projet)
	             WHERE pro.id_projet = :idp AND execution.id_execution = :idde';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':idp', $idp, PDO::PARAM_INT);
		$query->bindValue(':idde', $idde, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	    
	    $query->closeCursor();
   
   }
   
   
   
   function removePrevision($idp, $iddp) {
   
       $sql = 'DELETE  previsionnelle.*,
                                aut.*,
                                en.*,
                                mat.*,
                                roul.*,
                                pers.*,
								logprevi.*
                               						   
	             FROM  previsionnelle
	             LEFT JOIN autrefrais_prevision aut USING(id_previsionnelle)
				 LEFT JOIN engin_prevision en USING(id_previsionnelle)
				 LEFT JOIN materiel_prevision mat USING(id_previsionnelle)
				 LEFT JOIN matroulant_prevision roul USING(id_previsionnelle)
				 LEFT JOIN personnel_prevision pers USING(id_previsionnelle)
				 LEFT JOIN logprevision logprevi ON logprevi.log_prevision_prevision_id = previsionnelle.id_previsionnelle
				 RIGHT JOIN projet pro USING(id_projet)
	             WHERE pro.id_projet = :idp AND previsionnelle.id_previsionnelle = :iddp';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':idp', $idp, PDO::PARAM_INT);
		$query->bindValue(':iddp', $iddp, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	    
	    $query->closeCursor();
   
   }
   
   
   
   
    function removePersonnellePrevision($iddp, $idperso) {
   
       $sql = 'DELETE logper.*,
	                               perso.*
	               FROM  personnel_prevision perso
				   LEFT JOIN logpersonnelprevision logper ON logper.log_personnel_prevision_personnel_id = perso.id_personnel_previsionnelle
	              WHERE id_personnel_previsionnelle = :idperso AND id_previsionnelle = :iddp';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':idperso', $idperso, PDO::PARAM_INT);
		$query->bindValue(':iddp', $iddp, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	    
	    $query->closeCursor();
   
   }
   
   
   
    function removePersonnelleExecution($idde, $idperso) {
   
       $sql = 'DELETE logper.*,
	                              perso.*
				   FROM  personnel_execution perso
				   LEFT JOIN logpersonnelexecution logper ON logper.log_personnel_execution_personnel_id = perso.id_personnel_execution
	               WHERE id_personnel_execution = :idperso AND id_execution = :idde';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':idperso', $idperso, PDO::PARAM_INT);
		$query->bindValue(':idde', $idde, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	    
	    $query->closeCursor();
   
   }
   
   
   
   
   function removeAufraisPrevision($iddp, $idfrais) {
   
       $sql = 'DELETE logau.*,
	                              frais.*
				 FROM  autrefrais_prevision frais
				 LEFT JOIN logautresfraisprevision logau ON logau.log_autresfrais_prevision_autresfrais_id = frais.id_autresfrais_previsionnel
	             WHERE id_autresfrais_previsionnel = :idfrais AND id_previsionnelle = :iddp';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':idfrais', $idfrais, PDO::PARAM_INT);
		$query->bindValue(':iddp', $iddp, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	    
	    $query->closeCursor();
   
   }
   
   
   
   
    function removeAufraisExecution($idde, $idfrais) {
   
       $sql = 'DELETE logau.*,
	                              frais.*
	             FROM  autrefrais_execution frais
				 LEFT JOIN logautresfraisexecution ON logau.log_autresfrais_execution_autresfrais_id = frais.id_autresfrais_execution
	             WHERE id_autresfrais_execution = :idfrais AND id_execution = :idde';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':idfrais', $idfrais, PDO::PARAM_INT);
		$query->bindValue(':idde', $idde, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	    
	    $query->closeCursor();
   
   }
   
   
   
   
   
   
function editAuFraisPrevision($objet, $unite, $quantite, $prix, $iddp, $idfrais, $cid) {
   
         
          $msg = '';
		  $fo = 0;
          $u = 0;
          $fq = 0;
		  $fp = 0;
		
        
        $oi = infos_frais_prevision($idfrais);
		
        if($oi['objet_autresfrais_previsionnel'] != $objet) {
            $fo = 1;
            $msg .=  'Changé <em>objet</em>';
        }
        if($oi['unite_autresfrais_previsionnel'] != $unite) {
            $fu = 1;
            if($fo == 1)
                $msg .= ', changé <em>unite</em>';
            else
                $msg .= 'Changé <em>unité</em>';
        }
        if($oi['quantite_autresfrais_previsionnel'] != $quantite) {
            $fq = 1;
            if($fo == 1 || $fu == 1)
                $msg .= ', changé <em>quantité</em>';
            else 
                $msg .= 'Changé <em>quantité</em>';
        }
        if($oi['prix_autresfrais_previsionnel'] != $prix) {
            $fnh = 1;
            if($fo == 1 || $fu == 1 || $fq == 1)
                $msg .= ', changé <em>prix</em>';
            else 
                $msg .= 'Changé <em>prix</em>';
        }
	   
     
	  if(!empty($msg)) { 
           //$cid = getUserIdByName($cuser);
           logAutresfraisPrevision($cid, $idfrais, $iddp, $msg);
       }
	   		 
		
   
   
       $sql = 'UPDATE autrefrais_prevision
	              SET objet_autresfrais_previsionnel = :objet,
				          unite_autresfrais_previsionnel = :unite,
				          quantite_autresfrais_previsionnel = :quantite,
				          prix_autresfrais_previsionnel = :prix,
				         date_updated_autresfrais_previsionnel = NOW()
				 WHERE id_autresfrais_previsionnel = :idfrais AND id_previsionnelle = :iddp';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':objet', $objet, PDO::PARAM_STR);
		$query->bindValue(':unite', $unite, PDO::PARAM_STR);
		$query->bindValue(':quantite', $quantite, PDO::PARAM_STR);
		$query->bindValue(':prix', $prix, PDO::PARAM_STR);
		$query->bindValue(':idfrais', $idfrais, PDO::PARAM_INT);
		$query->bindValue(':iddp', $iddp, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
	    $query->closeCursor();
	   
   }
   
   
   
   
function editAuFraisExecution($objet, $unite, $quantite, $prix, $idde, $idfrais, $cid) {
	
	      $msg = '';
		  $fo = 0;
          $u = 0;
          $fq = 0;
		  $fp = 0;
		
        
        $oi = infos_frais_execution($idfrais);
		
        if($oi['objet_autresfrais_execution'] != $objet) {
            $fo = 1;
            $msg .=  'Changé <em>objet</em>';
        }
        if($oi['unite_autresfrais_execution'] != $unite) {
            $fu = 1;
            if($fo == 1)
                $msg .= ', changé <em>unite</em>';
            else
                $msg .= 'Changé <em>unité</em>';
        }
        if($oi['quantite_autresfrais_execution'] != $quantite) {
            $fq = 1;
            if($fo == 1 || $fu == 1)
                $msg .= ', changé <em>quantité</em>';
            else 
                $msg .= 'Changé <em>quantité</em>';
        }
        if($oi['prix_autresfrais_execution'] != $prix) {
            $fnh = 1;
            if($fo == 1 || $fu == 1 || $fq == 1)
                $msg .= ', changé <em>prix</em>';
            else 
                $msg .= 'Changé <em>prix</em>';
        }
	   
     
	  if(!empty($msg)) { 
           //$cid = getUserIdByName($cuser);
           logAutresfraisExecution($cid, $idfrais, $idde, $msg);
       }

	
   
       $sql = 'UPDATE autrefrais_execution
	              SET objet_autresfrais_execution = :objet,
				          unite_autresfrais_execution = :unite,
				          quantite_autresfrais_execution = :quantite,
				          prix_autresfrais_execution = :prix,
				         date_updated_autresfrais_execution = NOW()
				 WHERE id_autresfrais_execution = :idfrais AND id_execution = :idde';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':objet', $objet, PDO::PARAM_STR);
		$query->bindValue(':unite', $unite, PDO::PARAM_STR);
		$query->bindValue(':quantite', $quantite, PDO::PARAM_STR);
		$query->bindValue(':prix', $prix, PDO::PARAM_STR);
		$query->bindValue(':idfrais', $idfrais, PDO::PARAM_INT);
		$query->bindValue(':idde', $idde, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
	    $query->closeCursor();
	   
   }
   
   
   
   
   
 function editEnginPrevision($code, $nom, $puissance, $marque, $nbjour, $locationjour, $conso_car_jour, $prix_carburant, $conso_lub_jour, $prix_lubrifiant, $iddp, $ideng, $cid) {
    
	      $msg = '';
		  $fc = 0;
          $fn = 0;
          $fp = 0;
		  $fm= 0;
		  $fnbj = 0;
		  $flj = 0;
		  $fccj = 0;
		  $fpc= 0;
		  $fclj = 0;
		  $fpl = 0;
		
        
        $oi = infos_engin_prevision($ideng);
		
        if($oi['code_engin_previsionnel'] != $code) {
            $fc = 1;
            $msg .=  'Changé <em>code</em>';
        }
        if($oi['nom_engin_previsionnel'] != $nom) {
            $fn = 1;
            if($fc == 1)
                $msg .= ', changé <em>nom</em>';
            else
                $msg .= 'Changé <em>nom</em>';
        }
        if($oi['puissance_engin_previsionnel'] != $puissance) {
            $fp = 1;
            if($fc == 1 || $fn == 1)
                $msg .= ', changé <em>puissance</em>';
            else 
                $msg .= 'Changé <em>puissance</em>';
        }
        if($oi['marque_engin_previsionnel'] != $marque) {
            $fm = 1;
            if($fc == 1 || $fn == 1 || $fp == 1)
                $msg .= ', changé <em>marque</em>';
            else 
                $msg .= 'Changé <em>marque</em>';
        }
		if($oi['nombre_jour_engin_previsionnel'] != $nbjour) {
            $fnbj = 1;
            if($fc == 1 || $fn == 1 || $fp == 1 || $fm == 1)
                $msg .= ', changé <em>nombre jour</em>';
            else 
                $msg .= 'Changé <em>nombre jour</em>';
        }
		if($oi['location_par_jour_engin_previsionnel'] != $locationjour) {
            $flj = 1;
            if($fc == 1 || $fn == 1 || $fp == 1 || $fm == 1 || $fnbj = 1)
                $msg .= ', changé <em>location jour</em>';
            else 
                $msg .= 'Changé <em>location jour</em>';
        }
		if($oi['consommation_carburant_par_jour_engin_previsionnel'] != $conso_car_jour) {
            $fccj = 1;
            if($fc == 1 || $fn == 1 || $fp == 1 || $fm == 1 || $fnbj == 1 || $flj == 1)
                $msg .= ', changé <em>consommation carburant jour</em>';
            else 
                $msg .= 'Changé <em>consommation carburant jour</em>';
        }
		if($oi['prix_carburant_engin_previsionnel'] != $prix_carburant) {
            $fpc = 1;
            if($fc == 1 || $fn == 1 || $fp == 1 || $fm == 1 || $fnbj == 1 || $flj == 1 || $fccj == 1)
                $msg .= ', changé <em>prix carburant</em>';
            else 
                $msg .= 'Changé <em>prix carburant</em>';
        }
		if($oi['consommation_lubrifiant_par_jour_engin_previsionnel'] != $conso_lub_jour) {
            $fclj = 1;
            if($fc == 1 || $fn == 1 || $fp == 1 || $fm == 1 || $fnbj == 1 || $flj == 1 || $fccj == 1 || $fpc == 1)
                $msg .= ', changé <em>consommation lubrifiant</em>';
            else 
                $msg .= 'Changé <em>consommation lubrifiant</em>';
        }
		if($oi['prix_lubrifiant_engin_previsionnel'] != $prix_lubrifiant) {
            $flp = 1;
            if($fc == 1 || $fn == 1 || $fp == 1 || $fm == 1 || $fnbj == 1 || $flj == 1 || $fccj == 1 || $fpc == 1 || $fclj == 1)
                $msg .= ', changé <em>prix lubrifiant</em>';
            else 
                $msg .= 'Changé <em>prix lubrifiant</em>';
        }
	   
     
	  if(!empty($msg)) { 
           //$cid = getUserIdByName($cuser);
           logEnginPrevision($cid, $ideng, $iddp, $msg);
       }
   
   
   
       $sql = 'UPDATE engin_prevision
	              SET code_engin_previsionnel = :code,
				          nom_engin_previsionnel = :nom,
				          puissance_engin_previsionnel = :puissance,
				          marque_engin_previsionnel = :marque,
						  nombre_jour_engin_previsionnel = :nombre,
						  location_par_jour_engin_previsionnel = :location,
						  consommation_carburant_par_jour_engin_previsionnel = :consocar,
						  prix_carburant_engin_previsionnel = :prixcar,
						  consommation_lubrifiant_par_jour_engin_previsionnel = :consolub,
						  prix_lubrifiant_engin_previsionnel = :prixlub,
				         date_updated_engin_previsionnel = NOW()
				 WHERE id_engin_previsionnel = :ideng AND id_previsionnelle = :iddp';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':code', $code, PDO::PARAM_STR);
		$query->bindValue(':nom', $nom, PDO::PARAM_STR);
		$query->bindValue(':puissance', $puissance, PDO::PARAM_STR);
		$query->bindValue(':marque', $marque, PDO::PARAM_STR);
		$query->bindValue(':nombre', $nbjour, PDO::PARAM_STR);
		$query->bindValue(':location', $locationjour, PDO::PARAM_STR);
		$query->bindValue(':consocar', $conso_car_jour, PDO::PARAM_STR);
		$query->bindValue(':prixcar', $prix_carburant, PDO::PARAM_STR);
		$query->bindValue(':consolub', $conso_lub_jour, PDO::PARAM_INT);
		$query->bindValue(':prixlub', $prix_lubrifiant, PDO::PARAM_STR);
		$query->bindValue(':ideng', $ideng, PDO::PARAM_STR);
		$query->bindValue(':iddp', $iddp, PDO::PARAM_STR);
		$query->execute() or die(print_r($query->errorInfo()));
	     
	    $query->closeCursor();
	   
   }
   
   
   
   
   
function editEnginExecution($code, $nom, $puissance, $marque, $nbjour, $locationjour, $conso_car_jour, $prix_carburant, $conso_lub_jour, $prix_lubrifiant, $idde, $ideng, $cid) {
       
          $msg = '';
		  $fc = 0;
          $fn = 0;
          $fp = 0;
		  $fm= 0;
		  $fnbj = 0;
		  $flj = 0;
		  $fccj = 0;
		  $fpc= 0;
		  $fclj = 0;
		  $fpl = 0;
		
        
        $oi = infos_engin_execution($ideng);
		
        if($oi['code_engin_execution'] != $code) {
            $fc = 1;
            $msg .=  'Changé <em>code</em>';
        }
        if($oi['nom_engin_execution'] != $nom) {
            $fn = 1;
            if($fc == 1)
                $msg .= ', changé <em>nom</em>';
            else
                $msg .= 'Changé <em>nom</em>';
        }
        if($oi['puissance_engin_execution'] != $puissance) {
            $fp = 1;
            if($fc == 1 || $fn == 1)
                $msg .= ', changé <em>puissance</em>';
            else 
                $msg .= 'Changé <em>puissance</em>';
        }
        if($oi['marque_engin_execution'] != $marque) {
            $fm = 1;
            if($fc == 1 || $fn == 1 || $fp == 1)
                $msg .= ', changé <em>marque</em>';
            else 
                $msg .= 'Changé <em>marque</em>';
        }
		if($oi['nombre_jour_engin_execution'] != $nbjour) {
            $fnbj = 1;
            if($fc == 1 || $fn == 1 || $fp == 1 || $fm == 1)
                $msg .= ', changé <em>nombre jour</em>';
            else 
                $msg .= 'Changé <em>nombre jour</em>';
        }
		if($oi['location_par_jour_engin_execution'] != $locationjour) {
            $flj = 1;
            if($fc == 1 || $fn == 1 || $fp == 1 || $fm == 1 || $fnbj = 1)
                $msg .= ', changé <em>location jour</em>';
            else 
                $msg .= 'Changé <em>location jour</em>';
        }
		if($oi['consommation_carburant_par_jour_engin_execution'] != $conso_car_jour) {
            $fccj = 1;
            if($fc == 1 || $fn == 1 || $fp == 1 || $fm == 1 || $fnbj == 1 || $flj == 1)
                $msg .= ', changé <em>consommation carburant jour</em>';
            else 
                $msg .= 'Changé <em>consommation carburant jour</em>';
        }
		if($oi['prix_carburant_engin_execution'] != $prix_carburant) {
            $fpc = 1;
            if($fc == 1 || $fn == 1 || $fp == 1 || $fm == 1 || $fnbj == 1 || $flj == 1 || $fccj == 1)
                $msg .= ', changé <em>prix carburant</em>';
            else 
                $msg .= 'Changé <em>prix carburant</em>';
        }
		if($oi['consommation_lubrifiant_par_jour_engin_execution'] != $conso_lub_jour) {
            $fclj = 1;
            if($fc == 1 || $fn == 1 || $fp == 1 || $fm == 1 || $fnbj == 1 || $flj == 1 || $fccj == 1 || $fpc == 1)
                $msg .= ', changé <em>consommation lubrifiant</em>';
            else 
                $msg .= 'Changé <em>consommation lubrifiant</em>';
        }
		if($oi['prix_lubrifiant_engin_execution'] != $prix_lubrifiant) {
            $flp = 1;
            if($fc == 1 || $fn == 1 || $fp == 1 || $fm == 1 || $fnbj == 1 || $flj == 1 || $fccj == 1 || $fpc == 1 || $fclj == 1)
                $msg .= ', changé <em>prix lubrifiant</em>';
            else 
                $msg .= 'Changé <em>prix lubrifiant</em>';
        }
	   
     
	  if(!empty($msg)) { 
           //$cid = getUserIdByName($cuser);
           logEnginExecution($cid, $ideng, $idde, $msg);
       }
	   
	
   
       $sql = 'UPDATE engin_execution
	              SET code_engin_execution = :code,
				          nom_engin_execution = :nom,
				          puissance_engin_execution = :puissance,
				          marque_engin_execution = :marque,
						  nombre_jour_engin_execution = :nombre,
						  location_par_jour_engin_execution = :location,
						  consommation_carburant_par_jour_engin_execution = :consocar,
						  prix_carburant_engin_execution = :prixcar,
						  consommation_lubrifiant_par_jour_engin_execution = :consolub,
						  prix_lubrifiant_engin_execution = :prixlub,
				         date_updated_engin_execution = NOW()
				 WHERE id_engin_execution = :ideng AND id_execution = :idde';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':code', $code, PDO::PARAM_STR);
		$query->bindValue(':nom', $nom, PDO::PARAM_STR);
		$query->bindValue(':puissance', $puissance, PDO::PARAM_STR);
		$query->bindValue(':marque', $marque, PDO::PARAM_STR);
		$query->bindValue(':nombre', $nbjour, PDO::PARAM_STR);
		$query->bindValue(':location', $locationjour, PDO::PARAM_STR);
		$query->bindValue(':consocar', $conso_car_jour, PDO::PARAM_STR);
		$query->bindValue(':prixcar', $prix_carburant, PDO::PARAM_STR);
		$query->bindValue(':consolub', $conso_lub_jour, PDO::PARAM_INT);
		$query->bindValue(':prixlub', $prix_lubrifiant, PDO::PARAM_STR);
		$query->bindValue(':ideng', $ideng, PDO::PARAM_STR);
		$query->bindValue(':idde', $idde, PDO::PARAM_STR);
		$query->execute() or die(print_r($query->errorInfo()));
	     
	    $query->closeCursor();
	   
   }
   
   
   
   
   
   
  function editMatRoulantPrevision($code, $nom, $puissance, $marque, $nbjour, $locationjour, $conso_car_jour, $prix_carburant, $conso_lub_jour, $prix_lubrifiant, $iddp, $idroulant, $cid) {
   
       
	      $msg = '';
		  $fc = 0;
          $fn = 0;
          $fp = 0;
		  $fm= 0;
		  $fnbj = 0;
		  $flj = 0;
		  $fccj = 0;
		  $fpc= 0;
		  $fclj = 0;
		  $fpl = 0;
		
        
        $oi = infos_matroulant_prevision($idroulant);
		
        if($oi['code_matroulant_previsionnel'] != $code) {
            $fc = 1;
            $msg .=  'Changé <em>code</em>';
        }
        if($oi['nom_matroulant_previsionnel'] != $nom) {
            $fn = 1;
            if($fc == 1)
                $msg .= ', changé <em>nom</em>';
            else
                $msg .= 'Changé <em>nom</em>';
        }
        if($oi['puissance_matroulant_previsionnel'] != $puissance) {
            $fp = 1;
            if($fc == 1 || $fn == 1)
                $msg .= ', changé <em>puissance</em>';
            else 
                $msg .= 'Changé <em>puissance</em>';
        }
        if($oi['marque_matroulant_previsionnel'] != $marque) {
            $fm = 1;
            if($fc == 1 || $fn == 1 || $fp == 1)
                $msg .= ', changé <em>marque</em>';
            else 
                $msg .= 'Changé <em>marque</em>';
        }
		if($oi['nombre_jour_matroulant_previsionnel'] != $nbjour) {
            $fnbj = 1;
            if($fc == 1 || $fn == 1 || $fp == 1 || $fm == 1)
                $msg .= ', changé <em>nombre jour</em>';
            else 
                $msg .= 'Changé <em>nombre jour</em>';
        }
		if($oi['location_par_jour_matroulant_previsionnel'] != $locationjour) {
            $flj = 1;
            if($fc == 1 || $fn == 1 || $fp == 1 || $fm == 1 || $fnbj = 1)
                $msg .= ', changé <em>location jour</em>';
            else 
                $msg .= 'Changé <em>location jour</em>';
        }
		if($oi['consommation_carburant_par_jour_matroulant_previsionnel'] != $conso_car_jour) {
            $fccj = 1;
            if($fc == 1 || $fn == 1 || $fp == 1 || $fm == 1 || $fnbj == 1 || $flj == 1)
                $msg .= ', changé <em>consommation carburant jour</em>';
            else 
                $msg .= 'Changé <em>consommation carburant jour</em>';
        }
		if($oi['prix_carburant_matroulant_previsionnel'] != $prix_carburant) {
            $fpc = 1;
            if($fc == 1 || $fn == 1 || $fp == 1 || $fm == 1 || $fnbj == 1 || $flj == 1 || $fccj == 1)
                $msg .= ', changé <em>prix carburant</em>';
            else 
                $msg .= 'Changé <em>prix carburant</em>';
        }
		if($oi['consommation_lubrifiant_par_jour_matroulant_previsionnel'] != $conso_lub_jour) {
            $fclj = 1;
            if($fc == 1 || $fn == 1 || $fp == 1 || $fm == 1 || $fnbj == 1 || $flj == 1 || $fccj == 1 || $fpc == 1)
                $msg .= ', changé <em>consommation lubrifiant</em>';
            else 
                $msg .= 'Changé <em>consommation lubrifiant</em>';
        }
		if($oi['prix_lubrifiant_matroulant_previsionnel'] != $prix_lubrifiant) {
            $flp = 1;
            if($fc == 1 || $fn == 1 || $fp == 1 || $fm == 1 || $fnbj == 1 || $flj == 1 || $fccj == 1 || $fpc == 1 || $fclj == 1)
                $msg .= ', changé <em>prix lubrifiant</em>';
            else 
                $msg .= 'Changé <em>prix lubrifiant</em>';
        }
	   
     
	  if(!empty($msg)) { 
           //$cid = getUserIdByName($cuser);
           logMatroulantPrevision($cid, $idroulant, $iddp, $msg);
       }
	   
	   
   
       $sql = 'UPDATE matroulant_prevision
	              SET code_matroulant_previsionnel = :code,
				          nom_matroulant_previsionnel = :nom,
				          puissance_matroulant_previsionnel = :puissance,
				          marque_matroulant_previsionnel = :marque,
						  nombre_jour_matroulant_previsionnel = :nombre,
						  location_par_jour_matroulant_previsionnel = :location,
						  consommation_carburant_par_jour_matroulant_previsionnel = :consocar,
						  prix_carburant_matroulant_previsionnel = :prixcar,
						  consommation_lubrifiant_par_jour_matroulant_previsionnel = :consolub,
						  prix_lubrifiant_matroulant_previsionnel = :prixlub,
				         date_updated_matroulant_previsionnel = NOW()
				 WHERE id_matroulant_previsionnel = :idroulant AND id_previsionnelle = :iddp';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':code', $code, PDO::PARAM_STR);
		$query->bindValue(':nom', $nom, PDO::PARAM_STR);
		$query->bindValue(':puissance', $puissance, PDO::PARAM_STR);
		$query->bindValue(':marque', $marque, PDO::PARAM_STR);
		$query->bindValue(':nombre', $nbjour, PDO::PARAM_STR);
		$query->bindValue(':location', $locationjour, PDO::PARAM_STR);
		$query->bindValue(':consocar', $conso_car_jour, PDO::PARAM_STR);
		$query->bindValue(':prixcar', $prix_carburant, PDO::PARAM_STR);
		$query->bindValue(':consolub', $conso_lub_jour, PDO::PARAM_INT);
		$query->bindValue(':prixlub', $prix_lubrifiant, PDO::PARAM_STR);
		$query->bindValue(':idroulant', $idroulant, PDO::PARAM_STR);
		$query->bindValue(':iddp', $iddp, PDO::PARAM_STR);
		$query->execute() or die(print_r($query->errorInfo()));
	     
	    $query->closeCursor();
	   
   }
   
   
   
   
   
   
   
function editMatRoulantExecution($code, $nom, $puissance, $marque, $nbjour, $locationjour, $conso_car_jour, $prix_carburant, $conso_lub_jour, $prix_lubrifiant, $idde, $idroulant, $cid) {
  
          $msg = '';
		  $fc = 0;
          $fn = 0;
          $fp = 0;
		  $fm= 0;
		  $fnbj = 0;
		  $flj = 0;
		  $fccj = 0;
		  $fpc= 0;
		  $fclj = 0;
		  $fpl = 0;
		
        
        $oi = infos_matroulant_execution($idroulant);
		
        if($oi['code_matroulant_execution'] != $code) {
            $fc = 1;
            $msg .=  'Changé <em>code</em>';
        }
        if($oi['nom_matroulant_execution'] != $nom) {
            $fn = 1;
            if($fc == 1)
                $msg .= ', changé <em>nom</em>';
            else
                $msg .= 'Changé <em>nom</em>';
        }
        if($oi['puissance_matroulant_execution'] != $puissance) {
            $fp = 1;
            if($fc == 1 || $fn == 1)
                $msg .= ', changé <em>puissance</em>';
            else 
                $msg .= 'Changé <em>puissance</em>';
        }
        if($oi['marque_matroulant_execution'] != $marque) {
            $fm = 1;
            if($fc == 1 || $fn == 1 || $fp == 1)
                $msg .= ', changé <em>marque</em>';
            else 
                $msg .= 'Changé <em>marque</em>';
        }
		if($oi['nombre_jour_matroulant_execution'] != $nbjour) {
            $fnbj = 1;
            if($fc == 1 || $fn == 1 || $fp == 1 || $fm == 1)
                $msg .= ', changé <em>nombre jour</em>';
            else 
                $msg .= 'Changé <em>nombre jour</em>';
        }
		if($oi['location_par_jour_matroulant_execution'] != $locationjour) {
            $flj = 1;
            if($fc == 1 || $fn == 1 || $fp == 1 || $fm == 1 || $fnbj = 1)
                $msg .= ', changé <em>location jour</em>';
            else 
                $msg .= 'Changé <em>location jour</em>';
        }
		if($oi['consommation_carburant_par_jour_matroulant_execution'] != $conso_car_jour) {
            $fccj = 1;
            if($fc == 1 || $fn == 1 || $fp == 1 || $fm == 1 || $fnbj == 1 || $flj == 1)
                $msg .= ', changé <em>consommation carburant jour</em>';
            else 
                $msg .= 'Changé <em>consommation carburant jour</em>';
        }
		if($oi['prix_carburant_matroulant_execution'] != $prix_carburant) {
            $fpc = 1;
            if($fc == 1 || $fn == 1 || $fp == 1 || $fm == 1 || $fnbj == 1 || $flj == 1 || $fccj == 1)
                $msg .= ', changé <em>prix carburant</em>';
            else 
                $msg .= 'Changé <em>prix carburant</em>';
        }
		if($oi['consommation_lubrifiant_par_jour_matroulant_execution'] != $conso_lub_jour) {
            $fclj = 1;
            if($fc == 1 || $fn == 1 || $fp == 1 || $fm == 1 || $fnbj == 1 || $flj == 1 || $fccj == 1 || $fpc == 1)
                $msg .= ', changé <em>consommation lubrifiant</em>';
            else 
                $msg .= 'Changé <em>consommation lubrifiant</em>';
        }
		if($oi['prix_lubrifiant_matroulant_execution'] != $prix_lubrifiant) {
            $flp = 1;
            if($fc == 1 || $fn == 1 || $fp == 1 || $fm == 1 || $fnbj == 1 || $flj == 1 || $fccj == 1 || $fpc == 1 || $fclj == 1)
                $msg .= ', changé <em>prix lubrifiant</em>';
            else 
                $msg .= 'Changé <em>prix lubrifiant</em>';
        }
	   
     
	  if(!empty($msg)) { 
           //$cid = getUserIdByName($cuser);
           logMatroulantExecution($cid, $idroulant, $idde, $msg);
       }
	   
   
       $sql = 'UPDATE matroulant_execution
	              SET code_matroulant_execution = :code,
				          nom_matroulant_execution = :nom,
				          puissance_matroulant_execution = :puissance,
				          marque_matroulant_execution = :marque,
						  nombre_jour_matroulant_execution = :nombre,
						  location_par_jour_matroulant_execution = :location,
						  consommation_carburant_par_jour_matroulant_execution = :consocar,
						  prix_carburant_matroulant_execution = :prixcar,
						  consommation_lubrifiant_par_jour_matroulant_execution = :consolub,
						  prix_lubrifiant_matroulant_execution = :prixlub,
				         date_updated_matroulant_execution = NOW()
				 WHERE id_matroulant_execution = :idroulant AND id_execution = :idde';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':code', $code, PDO::PARAM_STR);
		$query->bindValue(':nom', $nom, PDO::PARAM_STR);
		$query->bindValue(':puissance', $puissance, PDO::PARAM_STR);
		$query->bindValue(':marque', $marque, PDO::PARAM_STR);
		$query->bindValue(':nombre', $nbjour, PDO::PARAM_STR);
		$query->bindValue(':location', $locationjour, PDO::PARAM_STR);
		$query->bindValue(':consocar', $conso_car_jour, PDO::PARAM_STR);
		$query->bindValue(':prixcar', $prix_carburant, PDO::PARAM_STR);
		$query->bindValue(':consolub', $conso_lub_jour, PDO::PARAM_INT);
		$query->bindValue(':prixlub', $prix_lubrifiant, PDO::PARAM_STR);
		$query->bindValue(':idroulant', $idroulant, PDO::PARAM_STR);
		$query->bindValue(':idde', $idde, PDO::PARAM_STR);
		$query->execute() or die(print_r($query->errorInfo()));
	     
	    $query->closeCursor();
	   
   }
   
   
   
   
   
   function editPersonnelPrevision($matricule, $fonction, $salaire, $nombre_h, $iddp, $idperso, $cid) {
   
        $msg = '';
		$fm = 0;
        $ff = 0;
        $fs = 0;
		
        
        $oi = infos_personnelle_prevision($idperso);
		
        if($oi['matricule_personnel_previsionnelle'] != $matricule) {
            $fm = 1;
            $msg .=  'Changé <em>matricule</em>';
        }
        if($oi['fonction_personnel_previsionnelle'] != $fonction) {
            $ff = 1;
            if($fm == 1)
                $msg .= ', changé <em>fonction</em>';
            else
                $msg .= 'Changé <em>fonction</em>';
        }
        if($oi['salaire_horaire_personnel_previsionnelle'] != $salaire) {
            $fs = 1;
            if($fm == 1 || $ff == 1)
                $msg .= ', changé <em>salaire horaire</em>';
            else 
                $msg .= 'Changé <em>salaire horaire</em>';
        }
        if($oi['nombre_horaire_personnel_previsionnelle'] != $nombre_h) {
            $fnh = 1;
            if($fm == 1 || $ff == 1 || $fs == 1)
                $msg .= ', changé <em>nombre d\'heure</em>';
            else 
                $msg .= 'Changé <em>nombre d\'heure</em>';
        }
	   
     
	  if(!empty($msg)) { 
           //$cid = getUserIdByName($cuser);
           logPersonnellePrevision($cid, $idperso, $iddp, $msg);
       }
	   
   
       $sql = 'UPDATE personnel_prevision
	              SET matricule_personnel_previsionnelle = :matricule,
				         fonction_personnel_previsionnelle = :fonction,
				         salaire_horaire_personnel_previsionnelle = :salaire,
				         nombre_horaire_personnel_previsionnelle = :nombre,
				         date_updated_personnel_previsionnelle = NOW()
				 WHERE id_personnel_previsionnelle = :idperso AND id_previsionnelle = :iddp';
		
		
		
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':matricule', $matricule, PDO::PARAM_STR);
		$query->bindValue(':fonction', $fonction, PDO::PARAM_STR);
		$query->bindValue(':salaire', $salaire, PDO::PARAM_STR);
		$query->bindValue(':nombre', $nombre_h, PDO::PARAM_STR);
		$query->bindValue(':idperso', $idperso, PDO::PARAM_INT);
		$query->bindValue(':iddp', $iddp, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
	    $query->closeCursor();
	   
   }
   
   
   
   
   
function editPersonnelExecution($matricule, $fonction, $salaire, $nombre_h, $idde, $idperso, $cid) {
       
	   $msg = '';
		$fm = 0;
        $ff = 0;
        $fs = 0;
		
        
        $oi = infos_personnelle_execution($idperso);
		
        if($oi['matricule_personnel_execution'] != $matricule) {
            $fm = 1;
            $msg .=  'Changé <em>matricule</em>';
        }
        if($oi['fonction_personnel_execution'] != $fonction) {
            $ff = 1;
            if($fm == 1)
                $msg .= ', changé <em>fonction</em>';
            else
                $msg .= 'Changé <em>fonction</em>';
        }
        if($oi['salaire_horaire_personnel_execution'] != $salaire) {
            $fs = 1;
            if($fm == 1 || $ff == 1)
                $msg .= ', changé <em>salaire horaire</em>';
            else 
                $msg .= 'Changé <em>salaire horaire</em>';
        }
        if($oi['nombre_horaire_personnel_execution'] != $nombre_h) {
            $fnh = 1;
            if($fm == 1 || $ff == 1 || $fs == 1)
                $msg .= ', changé <em>nombre d\'heure</em>';
            else 
                $msg .= 'Changé <em>nombre d\'heure</em>';
        }
	   
     
	  if(!empty($msg)) { 
           //$cid = getUserIdByName($cuser);
           logPersonnelleExecution($cid, $idperso, $idde, $msg);
       }

	
       $sql = 'UPDATE personnel_execution
	              SET matricule_personnel_execution = :matricule,
				         fonction_personnel_execution = :fonction,
				         salaire_horaire_personnel_execution = :salaire,
				         nombre_horaire_personnel_execution = :nombre,
				         date_updated_personnel_execution = NOW()
				 WHERE id_personnel_execution = :idperso AND id_execution = :idde';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':matricule', $matricule, PDO::PARAM_STR);
		$query->bindValue(':fonction', $fonction, PDO::PARAM_STR);
		$query->bindValue(':salaire', $salaire, PDO::PARAM_STR);
		$query->bindValue(':nombre', $nombre_h, PDO::PARAM_STR);
		$query->bindValue(':idperso', $idperso, PDO::PARAM_INT);
		$query->bindValue(':idde', $idde, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
	    $query->closeCursor();
	   
   }
   
   
   
   
   
   
   
function editMaterielPrevision($code, $nom, $unite, $quantite, $cout, $iddp, $idmateriel, $cid) {
	  
	  
	      $msg = '';
		  $fc = 0;
          $fn = 0;
          $fu = 0;
		  $fcout= 0;
		  
        
        $oi = infos_materiel_prevision($idmateriel);
		
        if($oi['code_materiel_previsionnel'] != $code) {
            $fc = 1;
            $msg .=  'Changé <em>code</em>';
        }
        if($oi['nom_materiel_previsionnel'] != $nom) {
            $fn = 1;
            if($fc == 1)
                $msg .= ', changé <em>nom</em>';
            else
                $msg .= 'Changé <em>nom</em>';
        }
        if($oi['unite_materiel_previsionnel'] != $unite) {
            $fu = 1;
            if($fc == 1 || $fn == 1)
                $msg .= ', changé <em>unité</em>';
            else 
                $msg .= 'Changé <em>unité</em>';
        }
        if($oi['quantite_materiel_previsionnel'] != $quantite) {
            $fq = 1;
            if($fc == 1 || $fn == 1 || $fu == 1)
                $msg .= ', changé <em>quantité</em>';
            else 
                $msg .= 'Changé <em>quantité</em>';
        }
		if($oi['cout_materiel_previsionnel'] != $cout) {
            $fcout = 1;
            if($fc == 1 || $fn == 1 || $fu == 1 || $fq == 1)
                $msg .= ', changé <em>coût</em>';
            else 
                $msg .= 'Changé <em>coût</em>';
        }
		
     
	  if(!empty($msg)) { 
           //$cid = getUserIdByName($cuser);
           logMaterielPrevision($cid, $idmateriel, $iddp, $msg);
       }
	   
	  
	  
   
       $sql = 'UPDATE materiel_prevision
	              SET code_materiel_previsionnel = :code,
				         nom_materiel_previsionnel = :nom,
				         unite_materiel_previsionnel = :unite,
				         quantite_materiel_previsionnel = :quantite,
						 cout_materiel_previsionnel = :cout,
				         date_updated_materiel_previsionnel = NOW()
				 WHERE id_materiel_previsionnel = :idmateriel AND id_previsionnelle = :iddp';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':code', $code, PDO::PARAM_STR);
		$query->bindValue(':nom', $nom, PDO::PARAM_STR);
		$query->bindValue(':unite', $unite, PDO::PARAM_STR);
		$query->bindValue(':quantite', $quantite, PDO::PARAM_STR);
		$query->bindValue(':cout', $cout, PDO::PARAM_STR);
		$query->bindValue(':idmateriel', $idmateriel, PDO::PARAM_INT);
		$query->bindValue(':iddp', $iddp, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
	    $query->closeCursor();
	   
   }
   
   
     
   
      
function editMaterielExecution($code, $nom, $unite, $quantite, $cout, $idde, $idmateriel, $cid) {
	
	      $msg = '';
		  $fc = 0;
          $fn = 0;
          $fu = 0;
		  $fcout= 0;
		  
        
        $oi = infos_materiel_execution($idmateriel);
		
        if($oi['code_materiel_execution'] != $code) {
            $fc = 1;
            $msg .=  'Changé <em>code</em>';
        }
        if($oi['nom_materiel_execution'] != $nom) {
            $fn = 1;
            if($fc == 1)
                $msg .= ', changé <em>nom</em>';
            else
                $msg .= 'Changé <em>nom</em>';
        }
        if($oi['unite_materiel_execution'] != $unite) {
            $fu = 1;
            if($fc == 1 || $fn == 1)
                $msg .= ', changé <em>unité</em>';
            else 
                $msg .= 'Changé <em>unité</em>';
        }
        if($oi['quantite_materiel_execution'] != $quantite) {
            $fq = 1;
            if($fc == 1 || $fn == 1 || $fu == 1)
                $msg .= ', changé <em>quantité</em>';
            else 
                $msg .= 'Changé <em>quantité</em>';
        }
		if($oi['cout_materiel_execution'] != $cout) {
            $fcout = 1;
            if($fc == 1 || $fn == 1 || $fu == 1 || $fq == 1)
                $msg .= ', changé <em>coût</em>';
            else 
                $msg .= 'Changé <em>coût</em>';
        }
		
     
	  if(!empty($msg)) { 
           //$cid = getUserIdByName($cuser);
           logMaterielExecution($cid, $idmateriel, $idde, $msg);
       }

	   
   
       $sql = 'UPDATE materiel_execution
	              SET code_materiel_execution = :code,
				         nom_materiel_execution = :nom,
				         unite_materiel_execution = :unite,
				         quantite_materiel_execution = :quantite,
						 cout_materiel_execution = :cout,
				         date_updated_materiel_execution = NOW()
				 WHERE id_materiel_execution = :idmateriel AND id_execution = :idde';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':code', $code, PDO::PARAM_STR);
		$query->bindValue(':nom', $nom, PDO::PARAM_STR);
		$query->bindValue(':unite', $unite, PDO::PARAM_STR);
		$query->bindValue(':quantite', $quantite, PDO::PARAM_STR);
		$query->bindValue(':cout', $cout, PDO::PARAM_STR);
		$query->bindValue(':idmateriel', $idmateriel, PDO::PARAM_INT);
		$query->bindValue(':idde', $idde, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
	    $query->closeCursor();
	   
   }
   
   
   
   
   
 
function editExecution($idp, $idde, $nature, $unite, $quantite, $duree, $cid) {
   
        
		 $msg = '';
		$fn = 0;
        $fu = 0;
        $fq = 0;
        $fd = 0;
		
        
        $oi = infos_execution($idde);
		
        if($oi['nature_travaux_execution'] != $nature) {
            $fn = 1;
            $msg .=  'Changé <em>nature travaux</em>';
        }
        if($oi['unite_execution'] != $unite) {
            $fu = 1;
            if($fn == 1)
                $msg .= ', changé <em>unité</em>';
            else
                $msg .= 'Changé <em>unité</em>';
        }
        if($oi['quantite_execution'] != $quantite) {
            $fq = 1;
            if($fn == 1 || $fu == 1)
                $msg .= ', changé <em>quantité</em>';
            else 
                $msg .= 'Changé <em>quantité</em>';
        }
        if($oi['duree_execution'] != $duree) {
            $fd = 1;
            if($fn == 1 || $fu == 1 || $fq == 1)
                $msg .= ', changé <em>durée</em>';
            else 
                $msg .= 'Changé <em>durée</em>';
        }
	   
     
	  if(!empty($msg)) { 
           //$cid = getUserIdByName($cuser);
           logExecution($cid, $idde, $msg);
       }

   
   
       $sql = 'UPDATE execution
	             SET nature_travaux_execution = :nature, unite_execution = :unite, quantite_execution = :quantite, duree_execution = :duree, date_updated_execution = NOW()
				 WHERE id_projet = :idp AND id_execution = :idde';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':nature', $nature, PDO::PARAM_STR);
		$query->bindValue(':unite', $unite, PDO::PARAM_STR);
		$query->bindValue(':quantite', $quantite, PDO::PARAM_STR);
		$query->bindValue(':duree', $duree, PDO::PARAM_STR);
		$query->bindValue(':idp', $idp, PDO::PARAM_INT);
		$query->bindValue(':idde', $idde, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
	    $query->closeCursor();
	   
   }
   
   
   
   
   
   function editPrevision($idp, $iddp, $nature, $unite, $quantite, $duree, $cid) {
   
        $msg = '';
		$fn = 0;
        $fu = 0;
        $fq = 0;
        $fd = 0;
		
        
        $oi = infos_previsionnelle($iddp);
		
        if($oi['nature_travaux_previsionnelle'] != $nature) {
            $fn = 1;
            $msg .=  'Changé <em>nature travaux</em>';
        }
        if($oi['unite_previsionnelle'] != $unite) {
            $fu = 1;
            if($fn == 1)
                $msg .= ', changé <em>unité</em>';
            else
                $msg .= 'Changé <em>unité</em>';
        }
        if($oi['quantite_previsionnelle'] != $quantite) {
            $fq = 1;
            if($fn == 1 || $fu == 1)
                $msg .= ', changé <em>quantité</em>';
            else 
                $msg .= 'Changé <em>quantité</em>';
        }
        if($oi['duree_previsionnelle'] != $duree) {
            $fd = 1;
            if($fn == 1 || $fu == 1 || $fq == 1)
                $msg .= ', changé <em>durée</em>';
            else 
                $msg .= 'Changé <em>durée</em>';
        }
	   
     
	  if(!empty($msg)) { 
           //$cid = getUserIdByName($cuser);
           logPrevisionnelle($cid, $iddp, $msg);
       }
   
    
   
       $sql = 'UPDATE previsionnelle
	             SET nature_travaux_previsionnelle = :nature, unite_previsionnelle = :unite, quantite_previsionnelle = :quantite, duree_previsionnelle = :duree, date_updated_previsionnelle = NOW()
				 WHERE id_projet = :idp AND id_previsionnelle = :iddp';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':nature', $nature, PDO::PARAM_STR);
		$query->bindValue(':unite', $unite, PDO::PARAM_STR);
		$query->bindValue(':quantite', $quantite, PDO::PARAM_STR);
		$query->bindValue(':duree', $duree, PDO::PARAM_STR);
		$query->bindValue(':idp', $idp, PDO::PARAM_INT);
		$query->bindValue(':iddp', $iddp, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
	    $query->closeCursor();
	   
   }
   
   
   function isSuperUser($login) {
       $sql = 'SELECT  superuser
                  FROM utilisateur
				  WHERE login = :login AND superuser = 1
                   ';

	    $db = connection();

        $query = $db->prepare($sql);
		$query->bindValue(':login', $login, PDO::PARAM_STR);
		$query->execute() or die(print_r($query->errorInfo()));
		
		$data = $query->fetch();
		//$rows = $query->fetchColumn();    
		
	    $query->closeCursor();
		if($data[0]  == 1)
		    return true;
		else
		    return false;
   }   
   
   
function getAllUsers() {
   
         $sql = 'SELECT  * FROM utilisateur ORDER BY date_saisie_user DESC';
		 
	    $db = connection();

        $query = $db->prepare($sql);
		$query->execute() or die(print_r($query->errorInfo()));
		$data  = $query->fetchAll();    
		
	    $query->closeCursor();
		
		return $data;
   
 }

 
 
function getNbUsers() {
   
         $sql = 'SELECT  COUNT(*) nb FROM utilisateur';
		 
	    $db = connection();

        $query = $db->prepare($sql);
		$query->execute() or die(print_r($query->errorInfo()));
		$data  = $query->fetch();    
		
	    $query->closeCursor();
		
		return $data;
   
}
  
   
   
   
function getAllUsersByAccount($aid) {
   
         $sql = 'SELECT * 
		             FROM  utilisateur
					 LEFT JOIN account a using(account_id)
					 WHERE a.account_id = :id
					 ORDER BY date_saisie_user DESC';
		 
	    $db = connection();

        $query = $db->prepare($sql);
		$query->bindValue(':id', $aid, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
		$data  = $query->fetchAll();    
		
	    $query->closeCursor();
		
		return $data;
   
}
   
   
   
   function getAllUsersNotChef() {
   
         $sql = 'SELECT * 
		             FROM  utilisateur u
					 WHERE u.account_chef = 0
					 ORDER BY date_saisie_user DESC';
		 
	    $db = connection();

        $query = $db->prepare($sql);
		$query->execute() or die(print_r($query->errorInfo()));
		$data  = $query->fetchAll();    
		
	    $query->closeCursor();
		
		return $data;
   
   }
   
   
   
   function getAllAccounts() {
   
         $sql = 'SELECT  * FROM account ORDER BY account_created_at DESC';
		 
	    $db = connection();

        $query = $db->prepare($sql);
		$query->execute() or die(print_r($query->errorInfo()));
		$data  = $query->fetchAll();    
		
	    $query->closeCursor();
		
		return $data;
   
   }
   
   
  
  
  
  function getAccountById($aid) {
       $sql = 'SELECT  *
                  FROM account
				  WHERE account_id = :id
                   ';

	    $db = connection();

        $query = $db->prepare($sql);
		$query->bindValue(':id', $aid, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
		$data  = $query->fetch();    
		
	    $query->closeCursor();
		
		return $data;
   }



function getAllAccountByIdExceptThisId($aid) {
       $sql = 'SELECT  *
               FROM account
			   WHERE account_id != :id
               ORDER BY account_type;
              ';

	    $db = connection();

        $query = $db->prepare($sql);
		$query->bindValue(':id', $aid, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
		$data  = $query->fetchAll();    
		
	    $query->closeCursor();
		
		return $data;
}

  
  
  
    function getAccountIdByName($name) {
       $sql = 'SELECT  account_id
                  FROM account
				  WHERE account_type = :name
                   ';

	    $db = connection();

        $query = $db->prepare($sql);
		$query->bindValue(':name', $name, PDO::PARAM_STR);
		$query->execute() or die(print_r($query->errorInfo()));
		$data  = $query->fetch();    
		
	    $query->closeCursor();
		
		return $data;
   }
  
  
  
  function getAllAccountNames() {
   
         $sql = 'SELECT account_type FROM account';
		 
	    $db = connection();

        $query = $db->prepare($sql);
		$query->execute() or die(print_r($query->errorInfo()));
		$data  = $query->fetchAll();    
		
	    $query->closeCursor();
		
		return $data;
   
   }
   
   
   	function isUserExist($name) {
	    
		$name = strtolower($name);
		
	    $sql = "SELECT COUNT('matricule')
                    FROM utilisateur
                    WHERE matricule = :mat
                    ";
        $db = connection();
		 
        $query = $db->prepare($sql);
        $query->bindValue(':mat', $name, PDO::PARAM_STR);
        $query->execute() or die(print_r($query->errorInfo()));

        $rows = $query->fetchColumn();
            
	    $query->closeCursor();
			
        if($rows >= 1) 
            return true;
        else
            return false;
	
    }


  function isUserExistById($uid) {
		
	    $sql = "SELECT COUNT(id_utilisateur)
                FROM utilisateur
                WHERE id_utilisateur = :id
                    ";
        $db = connection();
		 
        $query = $db->prepare($sql);
        $query->bindValue(':id', $uid, PDO::PARAM_INT);
        $query->execute() or die(print_r($query->errorInfo()));

        $rows = $query->fetchColumn();
            
	    $query->closeCursor();
			
        if($rows == 1) 
            return true;
        else
            return false;
	
   }

  
  
   
   function isUserIsChef($uid) {
		
	    $sql = "SELECT account_chef
                    FROM utilisateur
                    WHERE id_utilisateur = :id
                    ";
        $db = connection();
		 
        $query = $db->prepare($sql);
        $query->bindValue(':id', $uid, PDO::PARAM_INT);
        $query->execute() or die(print_r($query->errorInfo()));

        $data = $query->fetch();
            
	    $query->closeCursor();
			
        if($data[0] == 1) 
            return true;
        else
            return false;
	
   }
  
  
  
  
  
 function isUserIsDg($uid) {
		
	    $sql = "SELECT login
                    FROM utilisateur
                    WHERE id_utilisateur = :id
                    ";
        $db = connection();
		 
        $query = $db->prepare($sql);
        $query->bindValue(':id', $uid, PDO::PARAM_INT);
        $query->execute() or die(print_r($query->errorInfo()));

        $data = $query->fetch();
            
	    $query->closeCursor();
			
        if($data[0] == 'dg') 
            return true;
        else
            return false;
	
}
  
  
   
  
 function enregistrer_user($matricule, $nom, $password, $groupe_id, $chef, $by) {
	
	    $sql = 'INSERT INTO utilisateur(
		      matricule,
			  login,
			  password,
			  account_id,
			  account_chef,
              superuser,
			  created_by,
			  date_saisie_user)
			  VALUES(
			  :matricule,
			  :nom,
			  :password,
			  :account_id,
              :chef,
              0,
			  :created_by,
			  NOW())';
     		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':matricule', $matricule, PDO::PARAM_STR);
        $query->bindValue(':nom', $nom, PDO::PARAM_STR);
        $query->bindValue(':password', $password, PDO::PARAM_STR);
		$query->bindValue(':account_id', $groupe_id, PDO::PARAM_INT);
        $query->bindValue(':chef', $chef, PDO::PARAM_INT);
		$query->bindValue(':created_by', $by, PDO::PARAM_STR);
		$query->execute() or die(print_r($query->errorInfo()));
		
        $query->closeCursor();

        return $db->lastInsertId();

	}
  
  
    
	   
function updateUserByName($name, $aid) {
   
       $sql = 'UPDATE utilisateur
	              SET account_chef = 1, accound_id = :aid
				  WHERE login = :name';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':name', $name, PDO::PARAM_STR);
		$query->bindValue(':aid', $aid, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
	    $query->closeCursor();
	   
 }
  
  
  
   
   function is_account_exist($aid) {
	
	    $sql = "SELECT COUNT('account_id')
                    FROM account
                    WHERE account_id = :id
                    ";
        $db = connection();
		 
        $query = $db->prepare($sql);
        $query->bindValue(':id', $aid, PDO::PARAM_INT);
        $query->execute() or die(print_r($query->errorInfo()));

        $rows = $query->fetchColumn();
            
	    $query->closeCursor();
			
        if($rows == 1) 
            return true;
        else
            return false;
	
   }
   
   
   
  function accountHasChef($aid, $uid) {
	
	    $sql = "SELECT account_chef
                    FROM utilisateur u
					LEFT JOIN account a using(account_id)
                    WHERE a.account_id = :aid AND u.id_utilisateur = :uid
                    ";
        $db = connection();
		 
        $query = $db->prepare($sql);
        $query->bindValue(':aid', $aid, PDO::PARAM_INT);
		$query->bindValue(':uid', $uid, PDO::PARAM_INT);
        $query->execute() or die(print_r($query->errorInfo()));

        $rows = $query->fetchColumn();
            
	    $query->closeCursor();
			
        if($rows == 1) 
            return true;
        else
            return false;
	
   }
   
   
   
   
function enregistrer_service($nom, $by) {
	
	    $sql = 'INSERT INTO account (
			  account_type,
			  created_by,
			  account_created_at)
			  VALUES(
			  :type,
			  :by,
			  NOW())';
     		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':type', $nom, PDO::PARAM_STR);
        $query->bindValue(':by', $by, PDO::PARAM_STR);
		$query->execute() or die(print_r($query->errorInfo()));
		
		$query->closeCursor();
		
		return $db->lastInsertId();
	    
}
  
  
  
function dochef($aid, $uid, $cid) {
     
       $msg = 'Changé <em>devenu chef</em>';  
       logUser($cid, $uid, $msg);
   
       $sql = 'UPDATE utilisateur
	              SET account_chef = 0
				  WHERE account_id = :aid AND id_utilisateur != :uid';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':aid', $aid, PDO::PARAM_INT);
		$query->bindValue(':uid', $uid, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
	    $query->closeCursor();
		
		$sql = 'UPDATE utilisateur
	              SET account_chef = 1
				  WHERE account_id = :aid AND id_utilisateur = :uid';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':aid', $aid, PDO::PARAM_INT);
		$query->bindValue(':uid', $uid, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
	    $query->closeCursor();
		
	   
}


function unchef($aid) {
   
       $sql = 'UPDATE utilisateur
	           SET account_chef = 0
			   WHERE account_id = :aid';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':aid', $aid, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
	    $query->closeCursor();
		
			     
 }

  



function getUserById($uid) {
       $sql = 'SELECT  *
               FROM utilisateur 
			   WHERE id_utilisateur  = :id
                   ';

	    $db = connection();

        $query = $db->prepare($sql);
		$query->bindValue(':id', $uid, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
		$data  = $query->fetch();    
		
	    $query->closeCursor();
		
		return $data;
 }



function getUserIdByName($name) {
       $sql = 'SELECT  id_utilisateur
               FROM utilisateur 
			   WHERE login  = :name
                   ';

	    $db = connection();

        $query = $db->prepare($sql);
		$query->bindValue(':name', $name, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
		$data  = $query->fetch();    
		
	    $query->closeCursor();
		
		return $data;
}




function removeUser($uid) {
       $sql = 'DELETE logu.*,
	                              user.*
	               FROM utilisateur user
				   LEFT JOIN loguser logu ON logu.log_user_user_id = user.id_utilisateur
			       WHERE id_utilisateur  = :id
                   ';

	    $db = connection();

        $query = $db->prepare($sql);
		$query->bindValue(':id', $uid, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
		$data  = $query->fetch();    
		
	    $query->closeCursor();
		
}


function removeAccount($aid) {
    $sql = 'DELETE u.*,
	                           a.*,
							   log.*
                FROM account a
                LEFT JOIN utilisateur u using(account_id)
				LEFT JOIN logaccount log ON log.log_account_account_id = a.account_id
			   WHERE account_id  = :aid
                   ';

	    $db = connection();

        $query = $db->prepare($sql);
		$query->bindValue(':aid', $aid, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
		$data  = $query->fetch();    
		
	    $query->closeCursor();
		
 }





function updateUserById($uid, $nom, $password, $aid, $chef, $cuser) {

        $msg = '';
        $fl = 0;
        $fp = 0;
        $faid = 0;
        
        $oi = getUserById($uid);
		
        if($oi['login'] != $nom) {
            $fl = 1;
            $msg .=  'Changé <em>nom</em>';
        }
        if($oi['password'] != $password) {
            $fp = 1;
            if($fl == 1)
                $msg .= ', changé <em>mot de passe</em>';
            else
                $msg .= 'Changé <em>mot de pase</em>';
        }
        if($oi['account_id'] != $aid) {
            $faid = 1;
            if($fl == 1 || $fp == 1)
                $msg .= ', changé <em>de service</em>';
            else 
                $msg .= 'Changé <em> de service</em>';
        }


        if(isUserIsChef($uid) === false && $chef == 1) {
            if ($fl == 1 || $fp == 1 || $faid ==1 ) {
                $msg .= ', changé <em>devenu chef</em>';
            } else {
                $msg .= 'Changé <em>devenu chef</em>';
            }
        } else if($chef == 0 && isUserIsChef($uid) === true) {
            unchef($io['account_id']);
            if ($fl == 1 || $fp == 1 || $faid == 1) {
                $msg .= ', changé <em>n\'est plus chef</em>';
            } else {
                $msg .= 'Changé <em>n\'est plus chef</em>';
            }
        }



       if(!empty($msg)) { 
           $cid = getUserIdByName($cuser);
           logUser($cid['id_utilisateur'], $uid, $msg);
       }

       $sql = 'UPDATE utilisateur
               SET 
                   login = :nom,
                   password = :pass,
                   account_chef = :chef,
                   account_id = :aid
			   WHERE id_utilisateur = :uid';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':nom', $nom, PDO::PARAM_STR);
		$query->bindValue(':pass', $password, PDO::PARAM_STR);
		$query->bindValue(':chef', $chef, PDO::PARAM_INT);
		$query->bindValue(':aid', $aid, PDO::PARAM_INT);
		$query->bindValue(':uid', $uid, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
	    $query->closeCursor();
        

        	   
 }


function logUser($cid, $uid, $msg) {
	
	    $sql = 'INSERT INTO loguser (
			        log_user_time,
                    log_user_current_user_id,
                    log_user_user_id,
                    log_user_msg)
			    VALUES(
			        NOW(),
			        :cid,
                    :uid,
			        :msg)';
     		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':cid', $cid, PDO::PARAM_INT);
		$query->bindValue(':uid', $uid, PDO::PARAM_INT);
        $query->bindValue(':msg', $msg, PDO::PARAM_STR);
		$query->execute() or die(print_r($query->errorInfo()));
	
		$query->closeCursor();
		
		//return $db->lastInsertId();
	    
}



function getLogUser($uid) {
       $sql = 'SELECT  *
               FROM loguser
			   WHERE log_user_user_id  = :uid
              ';

	    $db = connection();

        $query = $db->prepare($sql);
		$query->bindValue(':uid', $uid, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
		$data  = $query->fetchAll();    
		
	    $query->closeCursor();
		
		return $data;
}





function logAccount($cid, $aid, $msg) {
	
	    $sql = 'INSERT INTO logaccount (
			        log_account_time,
                    log_account_current_user_id,
                    log_account_account_id,
                    log_account_msg)
			    VALUES(
			        NOW(),
			        :cid,
                    :aid,
			        :msg)';
     		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':cid', $cid, PDO::PARAM_INT);
		$query->bindValue(':aid', $aid, PDO::PARAM_INT);
        $query->bindValue(':msg', $msg, PDO::PARAM_STR);
		$query->execute() or die(print_r($query->errorInfo()));
	
		$query->closeCursor();
		
		//return $db->lastInsertId();
	    
}



function getLogAccount($aid) {
       $sql = 'SELECT  *
               FROM logaccount
			   WHERE log_account_account_id  = :aid
              ';

	    $db = connection();

        $query = $db->prepare($sql);
		$query->bindValue(':aid', $aid, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
		$data  = $query->fetchAll();    
		
	    $query->closeCursor();
		
		return $data;
}







function logProjet($cid, $idp, $msg) {
	
	    $sql = 'INSERT INTO logprojet (
			        log_projet_time,
                    log_projet_current_user_id,
                    log_projet_projet_id,
                    log_projet_msg)
			    VALUES(
			        NOW(),
			        :cid,
                    :idp,
			        :msg)';
     		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':cid', $cid, PDO::PARAM_INT);
		$query->bindValue(':idp', $idp, PDO::PARAM_INT);
        $query->bindValue(':msg', $msg, PDO::PARAM_STR);
		$query->execute() or die(print_r($query->errorInfo()));
	
		$query->closeCursor();
		
		//return $db->lastInsertId();
	    
}



function getLogProjet($idp) {
       $sql = 'SELECT  *
               FROM logprojet
			   WHERE log_projet_projet_id  = :idp
              ';

	    $db = connection();

        $query = $db->prepare($sql);
		$query->bindValue(':idp', $idp, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
		$data  = $query->fetchAll();    
		
	    $query->closeCursor();
		
		return $data;
}





function logPrevisionnelle($cid, $iddp, $msg) {
	
	    $sql = 'INSERT INTO logprevision (
			        log_prevision_time,
                    log_prevision_current_user_id,
                    log_prevision_prevision_id,
                    log_prevision_msg)
			    VALUES(
			        NOW(),
			        :cid,
                    :iddp,
			        :msg)';
     		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':cid', $cid, PDO::PARAM_INT);
		$query->bindValue(':iddp', $iddp, PDO::PARAM_INT);
        $query->bindValue(':msg', $msg, PDO::PARAM_STR);
		$query->execute() or die(print_r($query->errorInfo()));
	
		$query->closeCursor();
		
		//return $db->lastInsertId();
	    
}



function getLogPrevisionnelle($iddp) {
       $sql = 'SELECT  *
               FROM logprevision
			   WHERE log_prevision_prevision_id  = :iddp
              ';

	    $db = connection();

        $query = $db->prepare($sql);
		$query->bindValue(':iddp', $iddp, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
		$data  = $query->fetchAll();    
		
	    $query->closeCursor();
		
		return $data;
}





function logExecution($cid, $idde, $msg) {
	
	    $sql = 'INSERT INTO logexecution (
			        log_execution_time,
                    log_execution_current_user_id,
                    log_execution_execution_id,
                    log_execution_msg)
			    VALUES(
			        NOW(),
			        :cid,
                    :idde,
			        :msg)';
     		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':cid', $cid, PDO::PARAM_INT);
		$query->bindValue(':idde', $idde, PDO::PARAM_INT);
        $query->bindValue(':msg', $msg, PDO::PARAM_STR);
		$query->execute() or die(print_r($query->errorInfo()));
	
		$query->closeCursor();
		
		//return $db->lastInsertId();
	    
}



function getLogExecution($idde) {
       $sql = 'SELECT  *
               FROM logexecution
			   WHERE log_execution_execution_id  = :idde
              ';

	    $db = connection();

        $query = $db->prepare($sql);
		$query->bindValue(':idde', $idde, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
		$data  = $query->fetchAll();    
		
	    $query->closeCursor();
		
		return $data;
}





function logPersonnellePrevision($cid, $idperso, $iddp, $msg) {
	
	    $sql = 'INSERT INTO logpersonnelprevision (
			        log_personnel_prevision_time,
                    log_personnel_prevision_current_user_id,
                    log_personnel_prevision_personnel_id,
                    log_personnel_prevision_msg,
					id_previsionnelle)
			    VALUES(
			        NOW(),
			        :cid,
                    :idperso,
			        :msg,
					:iddp)';
     		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':cid', $cid, PDO::PARAM_INT);
		$query->bindValue(':idperso', $idperso, PDO::PARAM_INT);
		$query->bindValue(':iddp', $iddp, PDO::PARAM_INT);
        $query->bindValue(':msg', $msg, PDO::PARAM_STR);
		$query->execute() or die(print_r($query->errorInfo()));
	
		$query->closeCursor();
		
		//return $db->lastInsertId();
	    
}



function getLogPersonnellePrevision($idperso) {
       $sql = 'SELECT  *
               FROM logpersonnelprevision
			   WHERE log_personnel_prevision_personnel_id  = :idperso
              ';

	    $db = connection();

        $query = $db->prepare($sql);
		$query->bindValue(':idperso', $idperso, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
		$data  = $query->fetchAll();    
		
	    $query->closeCursor();
		
		return $data;
}




function logPersonnelleExecution($cid, $idperso, $idde, $msg) {
	
	    $sql = 'INSERT INTO logpersonnelexecution (
			        log_personnel_execution_time,
                    log_personnel_execution_current_user_id,
                    log_personnel_execution_personnel_id,
                    log_personnel_execution_msg,
					id_execution)
			    VALUES(
			        NOW(),
			        :cid,
                    :idperso,
			        :msg,
					:idde)';
     		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':cid', $cid, PDO::PARAM_INT);
		$query->bindValue(':idperso', $idperso, PDO::PARAM_INT);
		$query->bindValue(':idde', $idde, PDO::PARAM_INT);
        $query->bindValue(':msg', $msg, PDO::PARAM_STR);
		$query->execute() or die(print_r($query->errorInfo()));
	
		$query->closeCursor();
		
		//return $db->lastInsertId();
	    
}



function getLogPersonnelleExecution($idperso) {
       $sql = 'SELECT  *
               FROM logpersonnelexecution
			   WHERE log_personnel_execution_personnel_id  = :idperso
              ';

	    $db = connection();

        $query = $db->prepare($sql);
		$query->bindValue(':idperso', $idperso, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
		$data  = $query->fetchAll();    
		
	    $query->closeCursor();
		
		return $data;
}






function logAutresfraisPrevision($cid, $idfrais, $iddp, $msg) {
	
	    $sql = 'INSERT INTO logautresfraisprevision (
			        log_autresfrais_prevision_time,
                    log_autresfrais_prevision_current_user_id,
                    log_autresfrais_prevision_autresfrais_id,
                    log_autresfrais_prevision_msg,
					id_previsionnelle)
			    VALUES(
			        NOW(),
			        :cid,
                    :idfrais,
			        :msg,
					:iddp)';
     		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':cid', $cid, PDO::PARAM_INT);
		$query->bindValue(':idfrais', $idfrais, PDO::PARAM_INT);
		$query->bindValue(':iddp', $iddp, PDO::PARAM_INT);
        $query->bindValue(':msg', $msg, PDO::PARAM_STR);
		$query->execute() or die(print_r($query->errorInfo()));
	
		$query->closeCursor();
		
		//return $db->lastInsertId();
	    
}



function getLogAutresfraisPrevision($idfrais) {
       $sql = 'SELECT  *
               FROM logautresfraisprevision
			   WHERE log_autresfrais_prevision_autresfrais_id  = :idfrais
              ';

	    $db = connection();

        $query = $db->prepare($sql);
		$query->bindValue(':idfrais', $idfrais, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
		$data  = $query->fetchAll();    
		
	    $query->closeCursor();
		
		return $data;
}





function logAutresfraisExecution($cid, $idfrais, $idde, $msg) {
	
	    $sql = 'INSERT INTO logautresfraisexecution (
			        log_autresfrais_execution_time,
                    log_autresfrais_execution_current_user_id,
                    log_autresfrais_execution_autresfrais_id,
                    log_autresfrais_execution_msg,
					id_execution)
			    VALUES(
			        NOW(),
			        :cid,
                    :idfrais,
			        :msg,
					:idde)';
     		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':cid', $cid, PDO::PARAM_INT);
		$query->bindValue(':idfrais', $idfrais, PDO::PARAM_INT);
		$query->bindValue(':idde', $idde, PDO::PARAM_INT);
        $query->bindValue(':msg', $msg, PDO::PARAM_STR);
		$query->execute() or die(print_r($query->errorInfo()));
	
		$query->closeCursor();
		
		//return $db->lastInsertId();
	    
}



function getLogAutresfraisExecution($idfrais) {
       $sql = 'SELECT  *
               FROM logautresfraisexecution
			   WHERE log_autresfrais_execution_autresfrais_id  = :idfrais
              ';

	    $db = connection();

        $query = $db->prepare($sql);
		$query->bindValue(':idfrais', $idfrais, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
		$data  = $query->fetchAll();    
		
	    $query->closeCursor();
		
		return $data;
}





function logEnginPrevision($cid, $ideng, $iddp, $msg) {
	
	    $sql = 'INSERT INTO logenginprevision (
			        log_engin_prevision_time,
                    log_engin_prevision_current_user_id,
                    log_engin_prevision_engin_id,
                    log_engin_prevision_msg,
					id_previsionnelle)
			    VALUES(
			        NOW(),
			        :cid,
                    :ideng,
			        :msg,
					:iddp)';
     		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':cid', $cid, PDO::PARAM_INT);
		$query->bindValue(':ideng', $ideng, PDO::PARAM_INT);
		$query->bindValue(':iddp', $iddp, PDO::PARAM_INT);
        $query->bindValue(':msg', $msg, PDO::PARAM_STR);
		$query->execute() or die(print_r($query->errorInfo()));
	
		$query->closeCursor();
		
		//return $db->lastInsertId();
	    
}




function getLogEnginPrevision($ideng) {
       $sql = 'SELECT  *
               FROM logenginprevision
			   WHERE log_engin_prevision_engin_id  = :ideng
              ';

	    $db = connection();

        $query = $db->prepare($sql);
		$query->bindValue(':ideng', $ideng, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
		$data  = $query->fetchAll();    
		
	    $query->closeCursor();
		
		return $data;
}





function logEnginExecution($cid, $ideng, $idde, $msg) {
	
	    $sql = 'INSERT INTO logenginexecution (
			        log_engin_execution_time,
                    log_engin_execution_current_user_id,
                    log_engin_execution_engin_id,
                    log_engin_execution_msg,
					id_execution)
			    VALUES(
			        NOW(),
			        :cid,
                    :ideng,
			        :msg,
					:idde)';
     		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':cid', $cid, PDO::PARAM_INT);
		$query->bindValue(':ideng', $ideng, PDO::PARAM_INT);
		$query->bindValue(':idde', $idde, PDO::PARAM_INT);
        $query->bindValue(':msg', $msg, PDO::PARAM_STR);
		$query->execute() or die(print_r($query->errorInfo()));
	
		$query->closeCursor();
		
		//return $db->lastInsertId();
	    
}




function getLogEnginExecution($ideng) {
       $sql = 'SELECT  *
               FROM logenginexecution
			   WHERE log_engin_execution_engin_id  = :ideng
              ';

	    $db = connection();

        $query = $db->prepare($sql);
		$query->bindValue(':ideng', $ideng, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
		$data  = $query->fetchAll();    
		
	    $query->closeCursor();
		
		return $data;
}




function logMatroulantPrevision($cid, $idroulant, $iddp, $msg) {
	
	    $sql = 'INSERT INTO logmatroulantprevision (
			        log_matroulant_prevision_time,
                    log_matroulant_prevision_current_user_id,
                    log_matroulant_prevision_matroulant_id,
                    log_matroulant_prevision_msg,
					id_previsionnelle)
			    VALUES(
			        NOW(),
			        :cid,
                    :idroulant,
			        :msg,
					:iddp)';
     		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':cid', $cid, PDO::PARAM_INT);
		$query->bindValue(':idroulant', $idroulant, PDO::PARAM_INT);
		$query->bindValue(':iddp', $iddp, PDO::PARAM_INT);
        $query->bindValue(':msg', $msg, PDO::PARAM_STR);
		$query->execute() or die(print_r($query->errorInfo()));
	
		$query->closeCursor();
		
		//return $db->lastInsertId();
	    
}



function getLogMatroulantPrevision($idroulant) {
       $sql = 'SELECT  *
               FROM logmatroulantprevision
			   WHERE log_matroulant_prevision_matroulant_id  = :idroulant
              ';

	    $db = connection();

        $query = $db->prepare($sql);
		$query->bindValue(':idroulant', $idroulant, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
		$data  = $query->fetchAll();    
		
	    $query->closeCursor();
		
		return $data;
}





function logMatroulantExecution($cid, $idroulant, $idde, $msg) {
	
	    $sql = 'INSERT INTO logmatroulantexecution (
			        log_matroulant_execution_time,
                    log_matroulant_execution_current_user_id,
                    log_matroulant_execution_matroulant_id,
                    log_matroulant_execution_msg,
					id_execution)
			    VALUES(
			        NOW(),
			        :cid,
                    :idroulant,
			        :msg,
					:idde)';
     		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':cid', $cid, PDO::PARAM_INT);
		$query->bindValue(':idroulant', $idroulant, PDO::PARAM_INT);
		$query->bindValue(':idde', $idde, PDO::PARAM_INT);
        $query->bindValue(':msg', $msg, PDO::PARAM_STR);
		$query->execute() or die(print_r($query->errorInfo()));
	
		$query->closeCursor();
		
		//return $db->lastInsertId();
	    
}



function getLogMatroulantExecution($idroulant) {
       $sql = 'SELECT  *
               FROM logmatroulantexecution
			   WHERE log_matroulant_execution_matroulant_id  = :idroulant
              ';

	    $db = connection();

        $query = $db->prepare($sql);
		$query->bindValue(':idroulant', $idroulant, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
		$data  = $query->fetchAll();    
		
	    $query->closeCursor();
		
		return $data;
}






function logMaterielPrevision($cid, $idmateriel, $iddp, $msg) {
	
	    $sql = 'INSERT INTO logmatchantierprevision (
			        log_matchantier_prevision_time,
                    log_matchantier_prevision_current_user_id,
                    log_matchantier_prevision_matchantier_id,
                    log_matchantier_prevision_msg,
					id_previsionnelle)
			    VALUES(
			        NOW(),
			        :cid,
                    :idmateriel,
			        :msg,
					:iddp)';
     		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':cid', $cid, PDO::PARAM_INT);
		$query->bindValue(':idmateriel', $idmateriel, PDO::PARAM_INT);
		$query->bindValue(':iddp', $iddp, PDO::PARAM_INT);
        $query->bindValue(':msg', $msg, PDO::PARAM_STR);
		$query->execute() or die(print_r($query->errorInfo()));
	
		$query->closeCursor();
		
		//return $db->lastInsertId();
	    
}



function getLogMaterielPrevision($idmateriel) {
       $sql = 'SELECT  *
               FROM logmatchantierprevision
			   WHERE log_matchantier_prevision_matchantier_id  = :idmateriel
              ';

	    $db = connection();

        $query = $db->prepare($sql);
		$query->bindValue(':idmateriel', $idmateriel, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
		$data  = $query->fetchAll();    
		
	    $query->closeCursor();
		
		return $data;
}




function logMaterielExecution($cid, $idmateriel, $idde, $msg) {
	
	    $sql = 'INSERT INTO logmatchantierexecution (
			        log_matchantier_execution_time,
                    log_matchantier_execution_current_user_id,
                    log_matchantier_execution_matchantier_id,
                    log_matchantier_execution_msg,
					id_execution)
			    VALUES(
			        NOW(),
			        :cid,
                    :idmateriel,
			        :msg,
					:idde)';
     		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':cid', $cid, PDO::PARAM_INT);
		$query->bindValue(':idmateriel', $idmateriel, PDO::PARAM_INT);
		$query->bindValue(':idde', $idde, PDO::PARAM_INT);
        $query->bindValue(':msg', $msg, PDO::PARAM_STR);
		$query->execute() or die(print_r($query->errorInfo()));
	
		$query->closeCursor();
		
		//return $db->lastInsertId();
	    
}



function getLogMaterielExecution($idmateriel) {
       $sql = 'SELECT  *
               FROM logmatchantierexecution
			   WHERE log_matchantier_execution_matchantier_id  = :idmateriel
              ';

	    $db = connection();

        $query = $db->prepare($sql);
		$query->bindValue(':idmateriel', $idmateriel, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
		$data  = $query->fetchAll();    
		
	    $query->closeCursor();
		
		return $data;
}





function updateAccountById($nom, $aid, $cid) {
       
	   $msg = 'Changé <em>nom</em>';  
       logAccount($cid, $aid, $msg);
	   
       $sql = 'UPDATE account
               SET 
               account_type = :nom
			   WHERE account_id = :aid';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':nom', $nom, PDO::PARAM_STR);
		$query->bindValue(':aid', $aid, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
	    $query->closeCursor();
	   
 }

 
function getAccountNameByUserId($uid) {

     $sql = 'SELECT account_type
		         FROM  account
			     INNER JOIN utilisateur u using(account_id)
			     WHERE u.id_utilisateur = :uid';
		 
	    $db = connection();

        $query = $db->prepare($sql);
		$query->bindValue(':uid', $uid, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
		$data  = $query->fetch();    
		
	    $query->closeCursor();
		
		return $data['account_type'];

}



function totalMontantOperatioByProjet($idp) {
   
       $sql = 'SELECT SUM(operation_montant) as montant
	             FROM operation
				 WHERE id_projet = :idp';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':idp', $idp, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $list = $query->fetch();
	   
	    $query->closeCursor();
	   
	    return $list['montant'];
   
}




function totalMontantOperatioByProjetOnDateFilter($idp, $date1, $date2) {
   
       $sql = 'SELECT SUM(operation_montant) as montant
	             FROM operation
				 WHERE id_projet = :idp AND opdate_date BETWEEN :d1 AND :d2';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':idp', $idp, PDO::PARAM_INT);
		$query->bindValue(':d1', $date1, PDO::PARAM_STR);
		$query->bindValue(':d2', $date2, PDO::PARAM_STR);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $list = $query->fetch();
	   
	    $query->closeCursor();
	   
	    return $list['montant'];
   
}




function getAllRubriqueByProjetId($id) {
       $sql = 'SELECT  r.*
               FROM rubrique r
               INNER JOIN projet p ON p.id_projet = r.id_projet
               WHERE p.id_projet = :id
              ';

	    $db = connection();

        $query = $db->prepare($sql);
		$query->bindValue(':id', $id, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
		$data  = $query->fetchAll();
		
	    $query->closeCursor();
		
		return $data;
}



function enregistrer_rubrique($idp, $rubrique_name) {
	
	    $sql = 'INSERT INTO rubrique (
		      rubrique_name,
			  id_projet)
			  VALUES(
			  :name,
			  :idp)';
     		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':name', $rubrique_name, PDO::PARAM_STR);
		$query->bindValue(':idp', $idp, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
		
		$query->closeCursor();
        
        return  $db->lastInsertId();       
}



function getRubriqueById($rid) {
       $sql = 'SELECT  *
               FROM rubrique
			   WHERE rubrique_id = :id
                   ';

	    $db = connection();

        $query = $db->prepare($sql);
		$query->bindValue(':id', $rid, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
		$data  = $query->fetch();    
		
	    $query->closeCursor();
		
		return $data;
}




function enregistrer_opdate($idp, $rid, $opdate_date, $month, $year, $formated_date) {
	
	    $sql = 'INSERT INTO opdate (
                   opdate_date,
                   rubrique_id,
                   id_projet,
                   opdate_month,
                   opdate_year,
                   opdate_formated_date)
			    VALUES(
                  :date,
                  :rid,
                  :idp,
                  :month,
                  :year,
                  :formated)';
     		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':date', $opdate_date, PDO::PARAM_STR);
		$query->bindValue(':rid', $rid, PDO::PARAM_INT);
		$query->bindValue(':idp', $idp, PDO::PARAM_INT);
		$query->bindValue(':month', $month, PDO::PARAM_STR);
		$query->bindValue(':year', $year, PDO::PARAM_INT);
		$query->bindValue(':formated', $formated_date, PDO::PARAM_STR);
		$query->execute() or die(print_r($query->errorInfo()));
		
		$query->closeCursor();
        
        return  $db->lastInsertId();       
}



function new_operation($code, $libele, $montant, $modePay, $user, 
                  $idp, $rid, $opdate, $day, $month, $year,
                   $newdate, $newmontant) {
	
	    $sql = 'INSERT INTO operation (
                   operation_code,
		           operation_libele,
			       operation_montant,
			       operation_date_saisie,
			       operation_created_by,
                   id_projet,
                   opdate_date,
                   rubrique_id,
                   operation_mode_pay,
                   operation_day,
                   operation_month,
                   operation_year,
                   operation_formated_date,
                   operation_formated_montant)
              VALUES(
                   :code,
			       :libele,
			       :montant,
			       NOW(),
			       :user,
			       :idp,
                   :date,
                   :rid,
                   :mode,
                   :day,
                   :month,
                   :year,
                   :newdate,
                   :newmontant)';
     		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':code', $code, PDO::PARAM_STR);
		$query->bindValue(':libele', $libele, PDO::PARAM_STR);
        $query->bindValue(':montant', $montant, PDO::PARAM_INT);
        $query->bindValue(':mode', $modePay, PDO::PARAM_STR);
		$query->bindValue(':user', $user, PDO::PARAM_STR);
		$query->bindValue(':idp', $idp, PDO::PARAM_INT);
		$query->bindValue(':rid', $rid, PDO::PARAM_INT);
		$query->bindValue(':date', $opdate, PDO::PARAM_STR);
		$query->bindValue(':day', $day, PDO::PARAM_INT);
		$query->bindValue(':month', $month, PDO::PARAM_STR);
		$query->bindValue(':year', $year, PDO::PARAM_STR);
		$query->bindValue(':newdate', $newdate, PDO::PARAM_STR);
		$query->bindValue(':newmontant', $newmontant, PDO::PARAM_STR);
		$query->execute() or die(print_r($query->errorInfo()));
		
		$query->closeCursor();

        return  $db->lastInsertId();       
	    
}



function isOpAvaible($idp, $rid, $opdate) {
	
	    $sql = "SELECT COUNT('operation_id')
                FROM operation
                WHERE id_projet = :idp AND rubrique_id = :rid
                                      AND opdate_date = :date
                    ";
        $db = connection();
		 
        $query = $db->prepare($sql);
        $query->bindValue(':idp', $idp, PDO::PARAM_INT);
        $query->bindValue(':rid', $rid, PDO::PARAM_INT);
        $query->bindValue(':date', $opdate, PDO::PARAM_STR);
        $query->execute() or die(print_r($query->errorInfo()));

        $rows = $query->fetchColumn();
            
	    $query->closeCursor();
			
        if($rows >= 1) 
            return true;
        else
            return false;
	
}



function previewListOp($idp, $rid, $opdate) {
	    
       $sql = 'SELECT * 
               FROM operation 
               WHERE id_projet = :idp AND rubrique_id = :rid
                                      AND opdate_date = :date
               ORDER BY opdate_date';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':idp', $idp, PDO::PARAM_INT);
		$query->bindValue(':rid', $rid, PDO::PARAM_INT);
		$query->bindValue(':date', $opdate, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $list = $query->fetchAll();
	   
	    $query->closeCursor();
	   
	    return $list;
	
}
	



function removeOp($opid) {
   
       $sql = 'DELETE
	           FROM operation
			   WHERE operation_id = :id';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':id', $opid, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	    
	    $query->closeCursor();
   
}





function removeRub($rid) {
   
       $sql = 'DELETE op.*, rub.*
               FROM rubrique rub
               LEFT JOIN operation op ON op.rubrique_id = rub.rubrique_id
			   WHERE rub.rubrique_id = :id';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':id', $rid, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	    
	    $query->closeCursor();
   
}




  
function editOp($opid, $code, $libele, $mode, $montant) {
    
   
        $sql = 'UPDATE operation
	            SET operation_code = :code, operation_libele = :libele, operation_mode_pay = :mode, operation_montant = :montant
				 WHERE operation_id = :opid';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':code', $code, PDO::PARAM_STR);
		$query->bindValue(':libele', $libele, PDO::PARAM_STR);
		$query->bindValue(':mode', $mode, PDO::PARAM_STR);
		$query->bindValue(':montant', $montant, PDO::PARAM_STR);
		$query->bindValue(':opid', $opid, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
	    $query->closeCursor();
	   
}
 


function getListMonthByPro($idp) {
	    
       $sql = 'SELECT DISTINCT operation_month
               FROM operation
               WHERE id_projet = :idp
               ORDER BY opdate_date';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':idp', $idp, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $list = $query->fetchAll();
	   
	    $query->closeCursor();
	   
	    return $list;
	
}



function getAllRubAndOpOnMonthByPro($month, $idp) {
	    
       $sql = 'SELECT op.*, rub.*
               FROM operation op
               INNER JOIN rubrique rub USING(rubrique_id)
               WHERE op.operation_month = :month AND op.id_projet = :idp
               ORDER BY op.opdate_date';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':month', $month, PDO::PARAM_STR);
		$query->bindValue(':idp', $idp, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $list = $query->fetchAll();
	   
	    $query->closeCursor();
	   
	    return $list;
	
}


function getAllOpOnMonth($month, $idp, $rubname) {
	    
       $sql = 'SELECT op.*, rub.rubrique_name
               FROM operation op
               INNER JOIN rubrique rub USING(rubrique_id)
               WHERE op.operation_month = :month AND op.id_projet = :idp
                                                 AND rub.rubrique_name = :rubname
               ORDER BY op.opdate_date';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':month', $month, PDO::PARAM_STR);
		$query->bindValue(':idp', $idp, PDO::PARAM_INT);
		$query->bindValue(':rubname', $rubname, PDO::PARAM_STR);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $list = $query->fetchAll();
	   
	    $query->closeCursor();
	   
	    return $list;
	
}



function totalOpByRubrique($idp, $month, $rubname) {
   
       $sql = 'SELECT SUM(operation_montant) as montant_rubrique
               FROM operation op
               INNER JOIN rubrique rub USING(rubrique_id)
               WHERE op.id_projet = :idp AND op.operation_month = :month
                                        AND rub.rubrique_name = :rubname
                 ';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':idp', $idp, PDO::PARAM_INT);
		$query->bindValue(':month', $month, PDO::PARAM_STR);
		$query->bindValue(':rubname', $rubname, PDO::PARAM_STR);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $list = $query->fetch();
	   
	    $query->closeCursor();
	   
	    return $list['montant_rubrique'];
   
}






function totalOpByRub($idp, $rubname) {
   
       $sql = 'SELECT SUM(operation_montant) as montant_rubrique
               FROM operation op
               INNER JOIN rubrique rub USING(rubrique_id)
               WHERE op.id_projet = :idp AND rub.rubrique_name = :rubname
                 ';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':idp', $idp, PDO::PARAM_INT);
		$query->bindValue(':rubname', $rubname, PDO::PARAM_STR);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $list = $query->fetch();
	   
	    $query->closeCursor();
	   
	    return $list['montant_rubrique'];
   
}





function totalOpByMonth($idp, $month) {
   
       $sql = 'SELECT SUM(operation_montant) as montant_month
	             FROM operation
				 WHERE id_projet = :idp AND operation_month = :month';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':idp', $idp, PDO::PARAM_INT);
		$query->bindValue(':month', $month, PDO::PARAM_STR);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $list = $query->fetch();
	   
	    $query->closeCursor();
	   
	    return $list['montant_month'];
   
}



//   <=============================================================  FOR ZAK ============================================================>



function listRubByMonth($month) {
	    
       $sql = 'SELECT DISTINCT rubrique_name
	               FROM rubrique
				   INNER JOIN operation op USING(rubrique_id)
				   WHERE operation_month = :month
				   ORDER BY rubrique_name';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':month', $month, PDO::PARAM_STR);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $list = $query->fetchAll();
	   
	    $query->closeCursor();
	   
	    return $list;
	
}


function listOp($month, $rubrique, $idp) {
	    
       $sql = 'SELECT *
	               FROM operation op
				   INNER JOIN rubrique rub USING(rubrique_id)
				   WHERE op.operation_month = :month AND rub.rubrique_name = :rubname AND op.id_projet = :idp';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':month', $month, PDO::PARAM_STR);
		$query->bindValue(':rubname', $rubrique, PDO::PARAM_STR);
		$query->bindValue(':idp', $idp, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $list = $query->fetchAll();
	   
	    $query->closeCursor();
	   
	    return $list;
	
}


function listRubByYear($year) {
        
	   $r1 = $year.'-01-01';
	   $r2 = $year.'-12-31';    
	    
       $sql = 'SELECT DISTINCT rub.rubrique_name
	               FROM operation op
				   INNER JOIN rubrique rub USING(rubrique_id) 
				   INNER JOIN projet pro ON pro.id_projet = op.id_projet
				   WHERE pro.date_projet BETWEEN :ra1 AND :ra2';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':ra1', $r1, PDO::PARAM_INT);
		$query->bindValue(':ra2', $r2, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $list = $query->fetchAll();
	   
	    $query->closeCursor();
	   
	    return $list;
	
}




function listRubByPro($idp) {
        
       $sql = 'SELECT DISTINCT rub.rubrique_name
	               FROM operation op
				   INNER JOIN rubrique rub USING(rubrique_id) 
				   INNER JOIN projet pro ON pro.id_projet = op.id_projet
				   WHERE pro.id_projet = :idp';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':idp', $idp, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $list = $query->fetchAll();
	   
	    $query->closeCursor();
	   
	    return $list;
	
}





function listOpByRubAndByPro($rubrique, $idp) {
	    
       $sql = 'SELECT *
	               FROM operation op
				   INNER JOIN rubrique rub USING(rubrique_id)
				   WHERE rub.rubrique_name = :rubname AND op.id_projet = :idp
				   ORDER BY opdate_date';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':rubname', $rubrique, PDO::PARAM_STR);
		$query->bindValue(':idp', $idp, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $list = $query->fetchAll();
	   
	    $query->closeCursor();
	   
	    return $list;
	
}





function listRubByYearAndByPro($year, $pname) {
        
	   $r1 = $year.'-01-01';
	   $r2 = $year.'-12-31';    
	    
       $sql = 'SELECT DISTINCT rub.rubrique_name
	               FROM operation op
				   INNER JOIN rubrique rub USING(rubrique_id) 
				   INNER JOIN projet pro ON pro.id_projet = op.id_projet
				   WHERE pro.date_projet BETWEEN :ra1 AND :ra2
				                   AND pro.objet_projet = :pname';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':ra1', $r1, PDO::PARAM_INT);
		$query->bindValue(':ra2', $r2, PDO::PARAM_INT);
		$query->bindValue(':pname', $pname, PDO::PARAM_STR);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $list = $query->fetchAll();
	   
	    $query->closeCursor();
	   
	    return $list;
	
}




function listProByYear($year) {
        
	   $r1 = $year.'-01-01';
	   $r2 = $year.'-12-31';    
	    
       $sql = 'SELECT DISTINCT objet_projet, id_projet
	               FROM projet
				   WHERE date_projet BETWEEN :ra1 AND :ra2';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':ra1', $r1, PDO::PARAM_INT);
		$query->bindValue(':ra2', $r2, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $list = $query->fetchAll();
	   
	    $query->closeCursor();
	   
	    return $list;
	
}





function totalRubByYear($year, $rubrique) {
        
	   $r1 = $year.'-01-01';
	   $r2 = $year.'-12-31';    
		
       $sql = 'SELECT SUM(op.operation_montant) as montant_rubrique
               FROM operation op
               INNER JOIN rubrique rub USING(rubrique_id)
			   INNER JOIN projet pro ON pro.id_projet = op.id_projet
			   WHERE rub.rubrique_name = :rubrique AND pro.date_projet BETWEEN :ra1 AND :ra2';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':rubrique', $rubrique, PDO::PARAM_STR);
		$query->bindValue(':ra1', $r1, PDO::PARAM_INT);
		$query->bindValue(':ra2', $r2, PDO::PARAM_INT);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $list = $query->fetch();
	   
	    $query->closeCursor();
	   
	    return $list['montant_rubrique'];
   
}




function totalRubByYearByPro($year, $rubrique, $pname)  {
        
	   $r1 = $year.'-01-01';
	   $r2 = $year.'-12-31';    
		
       $sql = 'SELECT SUM(op.operation_montant) as montant_rubrique
               FROM operation op
               INNER JOIN rubrique rub USING(rubrique_id)
			   INNER JOIN projet pro ON pro.id_projet = op.id_projet
			   WHERE rub.rubrique_name = :rubrique AND pro.date_projet BETWEEN :ra1 AND :ra2
			                  AND pro.objet_projet = :pname';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':rubrique', $rubrique, PDO::PARAM_STR);
		$query->bindValue(':ra1', $r1, PDO::PARAM_INT);
		$query->bindValue(':ra2', $r2, PDO::PARAM_INT);
		$query->bindValue(':pname', $pname, PDO::PARAM_STR);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $list = $query->fetch();
	   
	    $query->closeCursor();
	   
	    return $list['montant_rubrique'];
   
}




function getProByName($pname) {
   
         $sql = 'SELECT * 
		             FROM  projet
					 WHERE projet.objet_projet = :pname
					';
		 
	    $db = connection();

        $query = $db->prepare($sql);
		$query->bindValue(':pname', $pname, PDO::PARAM_STR);
		$query->execute() or die(print_r($query->errorInfo()));
		$data  = $query->fetch();    
		
	    $query->closeCursor();
		
		return $data;
   
}




function totalDepByProAndPyYear($year, $pname)  {
        
	   $r1 = $year.'-01-01';
	   $r2 = $year.'-12-31';    
		
       $sql = 'SELECT SUM(op.operation_montant) as tdp
               FROM operation op
			   INNER JOIN projet pro ON pro.id_projet = op.id_projet
			   WHERE pro.date_projet BETWEEN :ra1 AND :ra2
			                  AND pro.objet_projet = :pname';
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':ra1', $r1, PDO::PARAM_INT);
		$query->bindValue(':ra2', $r2, PDO::PARAM_INT);
		$query->bindValue(':pname', $pname, PDO::PARAM_STR);
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $list = $query->fetch();
	   
	    $query->closeCursor();
	   
	    return $list['tdp'];
   
}




function build_query($user_search) {

        $search_query = "SELECT *
                                      FROM operation
                                    ";
         
		$user_search = strtolower($user_search);
		$user_search = mysql_escape_string($user_search);
		
		$search_query .= " WHERE LOWER(operation_libele) LIKE '%$user_search%' ";
		 
       /* $user_search = strtolower($user_search);

        // Extract the search keywords into an array
        $bad = array('.',',','?',';',':','/','!','§','%','ù','*','µ','¨','^','$','£','ø','=','+','}',')','°',']','@','^','\\','|','[','{','#','~','}',']','&','²'); 
        $clean_search = str_replace($bad, ' ', $user_search);
        $search_words = explode(' ', $clean_search);

        $final_search_words = array();

        if (count($search_words) > 0) {
            foreach ($search_words as $word) {
                if (!empty($word)) {
                    $final_search_words[] = $word;
                }
            }
        }

		
        // Generate a WHERE clause using all of the search keywords       
        $where_list = array();
        if (count($final_search_words) > 0) {
            foreach($final_search_words as $word) {
                $where_list[] = "LOWER(operation_libele) LIKE '%$word%'";
                //$where_list[] = "LOWER(file_title) LIKE '%$word%'";
                //$where_list[] = "LOWER(author_pseudo) LIKE '%$word%'";
            }
        }

        $where_clause = implode(' OR ', $where_list);
        
        // Add the keyword WHERE clause to the search query
        if (!empty($where_clause)) {
            $search_query .= " WHERE $where_clause";
        }
		
		*/
		
		$search_query .= " AND id_projet = :pid ";
		$search_query .= " ORDER BY opdate_date";

        return $search_query; 

        
        
 }
   

function getSearchResult($getsql, $pid) {
	    
       $sql = $getsql;
		
	    $db = connection();
		$query = $db->prepare($sql);
		$query->bindValue(':pid', $pid, PDO::PARAM_INT);
		/*$query->bindValue(':rubname', $rubrique, PDO::PARAM_STR);
		$query->bindValue(':idp', $idp, PDO::PARAM_INT);*/
		$query->execute() or die(print_r($query->errorInfo()));
	     
        $list = $query->fetchAll();
	   
	    $query->closeCursor();
	   
	    return $list;
	
}
   



