<?php
    require_once 'header.php';
	require_once 'model.php';
	
	start_session();
    logout_protected();
	expired();
	
	$cid = getUserIdByName($_SESSION['login']);
	$cid = $cid['id_utilisateur'];
	
	
	$error = '';
	$matricule = '';
	$fonction = '';
	$salaire = '';
	$nombre_h = '';
	$idp = '';
	$idde = '';
	
	if (isset($_POST['submit'])) {

        $matricule =  (string) htmlspecialchars($_POST['matricule_personnel']);
        $fonction =  (string) htmlspecialchars($_POST['fonction_personnel']);
	    $salaire =  (string) htmlspecialchars($_POST['salaire_personnel']);
	    $nombre_h =  (string) htmlspecialchars($_POST['horaire_personnel']);
		$idp = (int) htmlspecialchars($_POST['idp']);
		$idde = (int) htmlspecialchars($_POST['idde']);
		$idperso = (int) htmlspecialchars($_POST['idperso']);
                            
        if(empty($matricule) || empty($fonction) || empty($salaire) || empty($nombre_h)) 
             $error = "Veuillez remplir tous les champs svp.";
        else if(!is_numeric($salaire) || !is_numeric($nombre_h))
		     $error = "Veuillez saisir des nombres pour le salaire et le nombre horaire.";
		else {
		
			    EditPersonnelExecution($matricule, $fonction, $salaire, $nombre_h, $idde, $idperso, $cid);

		         $_SESSION['edited_person_execution'] = 'Nouveau personnel modifié!';
		 
		         header('Location: liste_personnelle_execution.php?idp='.$idp.'&idde='.$idde);
             }	 
    
      }
	
	
	
?>

    <center>

	     <?php
                    if(isset($_GET['idp']) && !empty($_GET['idp']) && is_projet_exist(htmlspecialchars($_GET['idp'])) == true && isset($_GET['idperso']) && !empty($_GET['idperso'])   && isset($_GET['idde']) && !empty($_GET['idde'])) {
					    
						$idp =  (int) trim(htmlspecialchars($_GET['idp']));
						$idde = (int) trim(htmlspecialchars($_GET['idde']));
						$idperso = (int) trim(htmlspecialchars($_GET['idperso']));
		
					    $projet = infos_projet($idp);
					    $personnel = infos_personnelle_execution($idperso);
										
						
          ?>
	
	          <h4>Projet: <?php echo '<span style="color: #08c;">'.$projet['objet_projet'].'</span>'; ?></h4>
			  
			  <h4>Modification du personnelle <span style="color: #08c;"><?php echo $personnel['matricule_personnel_execution']; ?></span></h4>
	
	
	
  <center>

      <div class="" style="background-color:#6DCCF4; margin-top: 20px; width: 600px; border: 2px solid black; border-radius: 4px;">
	     
		        <u><h5>Modification d'un personnel</h5></u>
	  
	              <center style="color: red;"><h4><?php if($error) echo $error; ?></h4></center>
	  
          <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'].'?idde='.$idde.'&idp='.$idp.'&idperso='.$idperso; ?>" method="post" enctype="multipart/form-data" id="" style="padding-top: 50px;">
		                                
              <div class="control-group">
			  
               <label class="control-label">Matricule Personnel:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="text" name="matricule_personnel" id="matricule_personnel" value="<?php if($matricule) echo $matricule; else echo $personnel['matricule_personnel_execution']; ?>" placeholder="Entrez le matricule  du personnel">
                   
                   
               </div>
             </div>
				
				 <div class="control-group">
			  
               <label class="control-label">Fonction Personnel:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="text" name="fonction_personnel" id="fonction_personnel" value="<?php if($fonction) echo $fonction; else echo $personnel['fonction_personnel_execution']; ?>" placeholder="Entrez la fonction du personnel">
                   
                   
               </div>
             </div>
				
				 <div class="control-group">
			  
               <label class="control-label">Salaire Horaire Personnel:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="text" name="salaire_personnel" id="salaire_personnel" value="<?php if($salaire) echo $salaire; else echo $personnel['salaire_horaire_personnel_execution']; ?>" placeholder="Entrez le salaire du personnel">
                   
                   
               </div>
             </div>
			 
			 
			 
			  <div class="control-group">
			  
               <label class="control-label">Nombre Horaire Personnel:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="text" name="horaire_personnel" id="horaire_personnel" value="<?php if($nombre_h) echo $nombre_h; else echo $personnel['nombre_horaire_personnel_execution']; ?>" placeholder="Entrez le nombre d'horaire du personnel">
                   
                   
               </div>
             </div>
			 
			 <input type="hidden" name="idde" value="<?php echo $idde; ?>" />
             <input type="hidden" value="<?php echo $projet['id_projet']; ?>" name="idp">
			 <input type="hidden" value="<?php echo $idperso; ?>" name="idperso">

			
			<span id="champ_cacheee">
             <button type="submit" class="btn" name="submit" style="">Modifier</button>
			 <a href="liste_personnelle_execution.php?idp=<?php echo $idp.'&idde='.$idde; ?>">
			         <button style="margin-top: 0px;" class="btn btn-success" type="button" >Annuler</button>
				</a>
		    </span>
			 
             </div>
		
			 
          </form>		  
		  
      </div>
	  
	 
	  
  </center>
	


        			
	  <?php 
	        } else {
			  echo '<h3 style="color: red;">Erreur: Aucun projet selectioné!</h3><br/>';
			}
        ?>
		
                   				   
		
			<center>
		<p>
		    &nbsp;<a href="info_travauxp.php?idp=<?php echo $projet['id_projet'].'&idde='.$idde; ?>"><button style="margin-top: 20px;" class="btn btn-primary btn-mini" type="button"><i class="icon icon-arrow-left icon-white"></i>  Retour</button></a>
			 
		     &nbsp; <a href="liste_projet.php"><button style="margin-top: 20px;" class="btn btn-mini btn-primary" type="button">Liste des projets</button></a>
		     <a href="nouveau_projet.php"><button style="margin-top: 20px;" class="btn btn-mini btn-primary" type="button">Créer un nouveau projet</button></a>
		  &nbsp; <a href="index.php"><button style="margin-top: 20px;" class="btn btn-primary btn-mini" type="button">Accueil  <i class="icon icon-home icon-white"></i></button></a>
      </p>
		</p> 
	</center>
		
		
	  
	</center>


<?php include 'footer.php'; ?>