<?php
    require_once 'header.php';
	require_once 'model.php';
	
	
	start_session();
    logout_protected();
	expired();
	
	
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
		$idp = (int) htmlspecialchars($_POST['prid']);
		$idde = (int) htmlspecialchars($_POST['idde']);
                            
        if(empty($matricule) || empty($fonction) || empty($salaire) || empty($nombre_h)) 
             $error = "Veuillez remplir tous les champs svp.";
        else if(!is_numeric($salaire) || !is_numeric($nombre_h))
		     $error = "Veuillez saisir des nombres pour le salaire et le nombre horaire.";
		else {
			     enregistrer_personnelle_execution($matricule, $fonction, $salaire, $nombre_h, $idde, $_SESSION['login']);
	
		         $_SESSION['saved_person_execution'] = 'Nouveau personnel enregistrée!';
		 
		         header('Location: liste_personnelle_execution.php?idp='.$idp.'&idde='.$idde);
             }	 
    
      }
	
	
	
?>


    <center>

	     <?php
                    if(isset($_GET['idp']) && !empty($_GET['idp']) && is_projet_exist(htmlspecialchars($_GET['idp'])) == true && isset($_GET['idde']) && !empty($_GET['idde'])) {
					    
						$id =  (int) trim(htmlspecialchars($_GET['idp']));
						$idde = (int) trim(htmlspecialchars($_GET['idde']));
		
					    $projet = infos_projet($id);
										
						
          ?>
	
	          <h4>Projet: <?php echo '<span style="color: #08c;;">'.$projet['objet_projet'].'</span>'; ?></h4>
	
	
	
  <center>

      <div class="" style="background-color:#6DCCF4; margin-top: 20px; width: 600px; border: 2px solid black; border-radius: 4px;">
	     
		        <u><h5>Création d'un nouveau personnel</h5></u>
				
				<center style="color: red;"><?php if($error) echo $error; ?></center>
	  
          <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'].'?idp='.$id.'&idde='.$idde; ?>" method="post" enctype="multipart/form-data" id="" style="padding-top: 50px;">
		                                
              <div class="control-group">
			  
               <label class="control-label">Matricule Personnel:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="text" name="matricule_personnel" id="matricule_personnel" value="" placeholder="Entrez le matricule  du personnel">
                   
                   
               </div>
             </div>
				
				 <div class="control-group">
			  
               <label class="control-label">Fonction Personnel:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="text" name="fonction_personnel" id="fonction_personnel" value="" placeholder="Entrez la fonction du personnel">
                   
                   
               </div>
             </div>
				
				 <div class="control-group">
			  
               <label class="control-label">Salaire Horaire Personnel:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="text" name="salaire_personnel" id="salaire_personnel" value="" placeholder="Entrez le salaire du personnel">
                   
                   
               </div>
             </div>
			 
			 
			 
			  <div class="control-group">
			  
               <label class="control-label">Nombre Horaire Personnel:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="text" name="horaire_personnel" id="horaire_personnel" value="" placeholder="Entrez le nombre d'horaire du personnel">
                   
                   
               </div>
             </div>
			 
			 <input type="hidden" name="idde" value="<?php echo $idde; ?>" />
             <input type="hidden" value="<?php echo $projet['id_projet']; ?>" name="prid">
			 
             <button type="submit" class="btn" name="submit" style="">Enregistrer</button>
			 
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
			
			
		
		  
			 
			 &nbsp;<a href="info_travauxe.php?idp=<?php echo $projet['id_projet'].'&idde='.$idde; ?>"><button style="margin-top: 20px;" class="btn btn-primary btn-mini" type="button"><i class="icon icon-arrow-left icon-white"></i>  Retour</button></a>
			 <?php
                    if(isset($_GET['idp']) && !empty($_GET['idp']) && is_projet_exist(htmlspecialchars($_GET['idp'])) == true  && isset($_GET['idde']) && !empty($_GET['idde']) && is_execution_has_donnee_personnel(htmlspecialchars($_GET['idde'])) == true) {
					    				
						
          ?>
		    
		  &nbsp;<a href="liste_personnelle_execution.php?idp=<?php echo $projet['id_projet'].'&idde='.$idde; ?>"><button style="margin-top: 20px;" class="btn btn-primary btn-mini" type="button">Liste personnelle prevision <i class="icon icon-arrow-right icon-white"></i>  </button></a>
		  
		  <?php } ?>
		
			 
		     &nbsp; <a href="liste_projet.php"><button style="margin-top: 20px;" class="btn btn-mini btn-primary" type="button">Liste des projets</button></a>
		     <a href="nouveau_projet.php"><button style="margin-top: 20px;" class="btn btn-mini btn-primary" type="button">Créer un nouveau projet</button></a>
		  &nbsp; <a href="index.php"><button style="margin-top: 20px;" class="btn btn-primary btn-mini" type="button">Accueil  <i class="icon icon-home icon-white"></i></button></a>
      </p>
		</p> 
	</center>
		
		
	  
	</center>


<?php include 'footer.php'; ?>