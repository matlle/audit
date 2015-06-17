<?php
    require_once 'header.php';
	require_once 'model.php';
	
	start_session();
    logout_protected();
	expired();

	
?>

    <center>

	     <?php
                    if(isset($_GET['idp']) && !empty($_GET['idp']) && is_projet_exist(htmlspecialchars($_GET['idp'])) == true && isset($_GET['iddp']) && !empty($_GET['iddp'])) {
					    
						$id =  (int) trim(htmlspecialchars($_GET['idp']));
						$iddp = (int) trim(htmlspecialchars($_GET['iddp']));
					    $projet = infos_projet($id);
										
						
          ?>
	
	          <h4>Projet: <?php echo '<span style="color: #08c;;">'.$projet['objet_projet'].'</span>'; ?></h4>
	
	


	
	
	
	
	     <p>
		   
				    <center><a href="personnel_prev.php?idp=<?php echo $projet['id_projet'].'&iddp='.$iddp; ?>"><button style="margin-top: 20px;" class="btn btn-info btn-small" type="button">ENREGISTRER UN PERSONNEL <i class="icon icon-pencil"></i></button></a></center> </center>

 
  

				 
		     
			 <center><a href="frais_prev.php?idp=<?php echo $projet['id_projet'].'&iddp='.$iddp; ?>"><button style="margin-top: 20px;" class="btn btn-small btn-info" type="button">ENREGISTRER LES AUTRES FRAIS <i class="icon icon-pencil"></i></button></a></center>
			 
			 			 
		  
 
  
		     <center><a href="matengins_prev.php?idp=<?php echo $projet['id_projet'].'&iddp='.$iddp; ?>"><button style="margin-top: 20px;" class="btn btn-small btn-info" type="button">ENREGISTRER UN MATERIEL ENGINS  <i class="icon icon-pencil"></i></button></a></center>
			 
			 
  

			 <center><a href="matroulant_prev.php?idp=<?php echo $projet['id_projet'].'&iddp='.$iddp; ?>"><button style="margin-top: 20px;" class="btn btn-small btn-info" type="button" onClick="afficher4();">ENREGISTRER UN MATERIEL  ROULANT <i class="icon icon-pencil"></i></button></a></center>
			 
		

			 
			<center><a href="matchantier_prev.php?idp=<?php echo $projet['id_projet'].'&iddp='.$iddp; ?>"> <button style="margin-top: 20px;" class="btn btn-small btn-info" type="button" onClick="afficher5();">ENREGISTRER UN MATERIEL  CHANTIER <i class="icon icon-pencil"></i></button></a></center>
			
			
  

   
         </p>
	  
	             

   

				 
				 
				 
				 
				 
				 
				 
				 
				 
				 
				 
				 
				 
				 
				 
				 
				 
				 
				 
				 
				 
				 
				 
        			
	  <?php 
	        } else {
			  echo '<h3 style="color: red;">Erreur: Aucun projet selectioné!</h3><br/>';
			}
        ?>
		
                   				   
		<center>
		<p>
		    &nbsp; <a href="liste_projet.php"><button style="margin-top: 20px;" class="btn btn-mini btn-primary" type="button"><i class="icon icon-arrow-left icon-white"></i>  Liste des projets</button></a>
			
			
			 <a href="liste_donnee_prevision.php?idp=<?php echo $projet['id_projet']; ?>"><button style="margin-top: 20px;" class="btn btn-primary btn-mini" type="button"><i class="icon icon-arrow-left icon-white"></i>  Retour</button></a>
		  
		  
		  
		   &nbsp; <a href="liste_projet.php"><button style="margin-top: 20px;" class="btn btn-mini btn-primary" type="button">Liste des projets</button></a>
		     <a href="nouveau_projet.php"><button style="margin-top: 20px;" class="btn btn-mini btn-primary" type="button">Créer un nouveau projet</button></a>
		  &nbsp; <a href="index.php"><button style="margin-top: 20px;" class="btn btn-primary btn-mini" type="button">Accueil  <i class="icon icon-home icon-white"></i></button></a>
      </p>
	  
			
			
		</p>

		
		
	  
	</center>


<?php include 'footer.php'; ?>