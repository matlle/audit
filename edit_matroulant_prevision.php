<?php
    require_once 'header.php';
	require_once 'model.php';
	
	start_session();
    logout_protected();
	expired();
	
	$cid = getUserIdByName($_SESSION['login']);
	$cid = $cid['id_utilisateur'];
	
	
	$error = '';
	$code = '';
	$nom = '';
	$puissance = '';
	$marque = '';
	$nbjour = '';
	$locationjour = '';
	$conso_car_jour = '';
	$prix_carburant = '';
	$conso_lub_jour = '';
	$prix_lubrifiant = '';
	$idp = '';
	$iddp = '';
	
	if (isset($_POST['submit'])) {

        $code =  (string) htmlspecialchars($_POST['code_materiel_roulant']);
        $nom =  (string) htmlspecialchars($_POST['nom_materiel_roulant']);
	    $puissance =  (string) htmlspecialchars($_POST['puissance_materiel_roulant']);
	    $marque =  (string) htmlspecialchars($_POST['marque_materiel_roulant']);
		$nbjour =  (string) htmlspecialchars($_POST['jour_materiel_roulant']);
        $locationjour =  (string) htmlspecialchars($_POST['location_materiel_roulant']);
	    $conso_car_jour =  (string) htmlspecialchars($_POST['carburant_materiel_roulant']);
	    $prix_carburant =  (string) htmlspecialchars($_POST['prix_carburant_materiel_roulant']);
		$conso_lub_jour =  (string) htmlspecialchars($_POST['lubrifiant_materiel_roulant']);
        $prix_lubrifiant =  (string) htmlspecialchars($_POST['prix_lubrifiant_materiel_roulant']);
		
		$idp = (int) htmlspecialchars($_POST['prid']);
		$iddp = (int) htmlspecialchars($_POST['iddp']);
		$idroulant = (int) htmlspecialchars($_POST['idroulant']);
                            
        if(empty($code) || empty($nom) || empty($puissance) || empty($marque) || empty($nbjour) || empty($locationjour) || empty($conso_car_jour) || empty($prix_carburant) || empty($conso_lub_jour) || empty($prix_lubrifiant)) 
             $error = "Veuillez remplir tous les champs svp.";
        else if(!is_numeric($nbjour) || !is_numeric($locationjour) || !is_numeric($prix_carburant) || !is_numeric($prix_lubrifiant))
		     $error = "Veuillez saisir des nombres pour le nombre de jour, la location par jour et les differents prix.";
		else {
			     
				 editMatRoulantPrevision($code, $nom, $puissance, $marque, $nbjour, $locationjour, $conso_car_jour, $prix_carburant, $conso_lub_jour, $prix_lubrifiant, $iddp, $idroulant, $cid);

		         $_SESSION['edited_matroulant_prevision'] = 'Materiel roulant modifié!';
		 
		         header('Location: liste_matroulant_prevision.php?idp='.$idp.'&iddp='.$iddp);
             }	 
    
      }
	
	
	
?>

    <center>

	     <?php
                    if(isset($_GET['idp']) && !empty($_GET['idp']) && is_projet_exist(htmlspecialchars($_GET['idp'])) == true && isset($_GET['iddp']) && !empty($_GET['iddp']) && isset($_GET['idroulant']) && !empty($_GET['idroulant'])) {
					    
						$id =  (int) trim(htmlspecialchars($_GET['idp']));
						$iddp = (int) trim(htmlspecialchars($_GET['iddp']));
						$idroulant = (int) trim(htmlspecialchars($_GET['idroulant']));
		
					    $projet = infos_projet($id);
						$roulant = infos_matroulant_prevision($idroulant);				
						
          ?>
	
	          <h4>Projet: <?php echo '<span style="color: #08c;;">'.$projet['objet_projet'].'</span>'; ?></h4>

			  <h4>Modification materiel roulant <span style="color: #08c;"><?php echo $roulant['nom_matroulant_previsionnel']; ?></span></h4>



 <center>

      <div class="" style="background-color:#6DCCF4; margin-top: 20px; width: 600px; border: 2px solid black; border-radius: 4px;">
	     
		        <u><h5>Modification d'un materiel roulant</h5></u>
				
				<center style="color: red;"><h4><?php if($error) echo $error; ?></center></h4>
	  
          <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'].'?idp='.$id.'&iddp='.$iddp.'&idroulant='.$idroulant; ?>" method="post" enctype="multipart/form-data" id="" style="padding-top: 50px;">
		                                
              <div class="control-group">
			  
               <label class="control-label">Code materiel:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="text" name="code_materiel_roulant" id="code_materiel_roulant" value="<?php if($code) echo $code; else echo $roulant['code_matroulant_previsionnel']; ?>" placeholder="Entrez le code du materiel roulant">
                   
               </div>
             </div>
				
				 <div class="control-group">
			  
               <label class="control-label">Nom materiel roulant:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="text" name="nom_materiel_roulant" id="nom_materiel_roulant" value="<?php if($nom) echo $nom;  else echo $roulant['nom_matroulant_previsionnel']; ?>" placeholder="Entrez le nom de l'engins">
                   
               </div>
             </div>
				
			
		 <div class="control-group">
			  
               <label class="control-label">Puissance matériel roulant:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="text" name="puissance_materiel_roulant" id="puissance_materiel_roulant" value="<?php if($puissance) echo $puissance;  else echo $roulant['puissance_matroulant_previsionnel']; ?>" placeholder="Entrez la puissance du materiel roulant">
                   
               </div>
             </div>
			 
			 
			 
			 <div class="control-group">
			  
               <label class="control-label">Marque matériel roulant:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="text" name="marque_materiel_roulant" id="marque_materiel_roulant" value="<?php if($marque) echo $marque;  else echo $roulant['marque_matroulant_previsionnel']; ?>" placeholder="Entrez la marque du materiel roulant">
                   
               </div>
             </div>
		
			 <div class="control-group">
			  
               <label class="control-label">Nombre de Jour matériel roulant:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="text" name="jour_materiel_roulant" id="jour_materiel_roulant" value="<?php if($nbjour) echo $nbjour;   else echo $roulant['nombre_jour_matroulant_previsionnel']; ?>" placeholder="Entrez le nombre de jours du matériel roulant">
                   
               </div>
             </div>
		
		
		
	 <div class="control-group">
			  
               <label class="control-label">Location par Jour matériel roulant:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="text" name="location_materiel_roulant" id="location_materiel_roulant" value="<?php if($locationjour) echo $locationjour;   else echo $roulant['location_par_jour_matroulant_previsionnel'];  ?>" placeholder="Entrez le montant de la location par jours de materiel roulant">
                   
               </div>
             </div>
			 
			 
			 	
	 <div class="control-group">
			  
               <label class="control-label">Consommation Carburant par Jour engins:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="text" name="carburant_materiel_roulant" id="carburant_materiel_roulant" value="<?php if($conso_car_jour) echo $conso_car_jour;   else echo $roulant['consommation_carburant_par_jour_matroulant_previsionnel']; ?>" placeholder="Entrez la consommation de carburant par Jour du matériel roulant">
                   
               </div>
             </div>
		
		
			 	
	 <div class="control-group">
			  
               <label class="control-label">Prix du Carburant du materiel roulant:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="text" name="prix_carburant_materiel_roulant" id="prix_carburant_materiel_roulant" value="<?php if($prix_carburant) echo $prix_carburant;   else echo $roulant['prix_carburant_matroulant_previsionnel'];  ?>" placeholder="Entrez le prix du carburant du materiel roulant">
                   
               </div>
             </div>
		
		
	 <div class="control-group">
			  
               <label class="control-label">Consommation lubrifiant par Jour matériel roulant:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="text" name="lubrifiant_materiel_roulant" id="lubrifiant_materiel_roulant" value="<?php if($conso_lub_jour) echo $conso_lub_jour;  else echo $roulant['consommation_lubrifiant_par_jour_matroulant_previsionnel']; ?>" placeholder="Entrez la consommation de lubrifiant par Jour du materiel roulant">
                   
               </div>
             </div>
		
				 	
	 <div class="control-group">
			  
               <label class="control-label">Prix du lubrifiant matériel roulant:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="text" name="prix_lubrifiant_materiel_roulant" id="prix_lubrifiant_materiel_roulant" value="<?php if($prix_lubrifiant) echo $prix_lubrifiant;   else echo $roulant['prix_lubrifiant_matroulant_previsionnel'];  ?>" placeholder="Entrez le prix du lubrifiant du materiel roulant">
                   
               </div>
             </div>
		
		     
			 <input type="hidden" name="iddp" value="<?php echo $iddp; ?>" />
             <input type="hidden" value="<?php echo $projet['id_projet']; ?>" name="prid" />
			 <input type="hidden" name="idroulant" value="<?php echo $idroulant; ?>" />
		
		    <span id="champ_cacheee">
                  <button type="submit" class="btn" name="submit" style="">Modifier</button>
			      <a href="liste_matroulant_prevision.php?idp=<?php echo $id.'&iddp='.$iddp; ?>">
			         <button style="margin-top: 0px;" class="btn btn-success" type="button" >Annuler</button>
				  </a>
		    </span>

		
             </div>
		
			 
          </form>		  
		  
    
	  
	 
	  
  </center>
  

				 

        			
	  <?php 
	        } else {
			  echo '<h3 style="color: red;">Erreur: Aucun projet selectioné!</h3><br/>';
			}
        ?>
		
                   				   
		
			<center>
		<p>
		    
			   
		   &nbsp;<a href="info_travauxp.php?idp=<?php echo $projet['id_projet'].'&iddp='.$iddp; ?>"><button style="margin-top: 20px;" class="btn btn-primary btn-mini" type="button"><i class="icon icon-arrow-left icon-white"></i>  Retour</button></a>
			 <?php
                    if(isset($_GET['idp']) && !empty($_GET['idp']) && is_projet_exist(htmlspecialchars($_GET['idp'])) == true  && isset($_GET['iddp']) && !empty($_GET['iddp']) && is_previsionnelle_has_donnee_matroulant(htmlspecialchars($_GET['iddp'])) == true) {
					    				
						
          ?>
		    
		  &nbsp;<a href="liste_matroulant_prevision.php?idp=<?php echo $projet['id_projet'].'&iddp='.$iddp; ?>"><button style="margin-top: 20px;" class="btn btn-primary btn-mini" type="button">Liste materiel roulant prevision <i class="icon icon-arrow-right icon-white"></i>  </button></a>
		  
		  <?php } ?>
			
		     &nbsp; <a href="liste_projet.php"><button style="margin-top: 20px;" class="btn btn-mini btn-primary" type="button">Liste des projets</button></a>
		     <a href="nouveau_projet.php"><button style="margin-top: 20px;" class="btn btn-mini btn-primary" type="button">Créer un nouveau projet</button></a>
		  &nbsp; <a href="index.php"><button style="margin-top: 20px;" class="btn btn-primary btn-mini" type="button">Accueil  <i class="icon icon-home icon-white"></i></button></a>
      </p>
		</p> 
	</center>

		
		
	  
	</center>


<?php include 'footer.php'; ?>