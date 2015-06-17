<?php
    require_once 'header.php';
	require_once 'model.php';
	
	start_session();
    logout_protected();
	expired();
	
	
	$cid = getUserIdByName($_SESSION['login']);
	$cid = $cid['id_utilisateur'];
	
	
    $error = '';
	$objet = '';
	$unite = '';
	$quantite = '';
	$prix = '';
	$idp = '';
	$iddp = '';
	
	if (isset($_POST['submit'])) {

        $objet =  (string) htmlspecialchars($_POST['objet_frais']);
        $unite =  (string) htmlspecialchars($_POST['unite_frais']);
	    $quantite =  (string) htmlspecialchars($_POST['quantite_frais']);
	    $prix =  (string) htmlspecialchars($_POST['prix_frais']);
		$idp = (int) htmlspecialchars($_POST['idp']);
		$iddp = (int) htmlspecialchars($_POST['iddp']);
		$idfrais = (int) htmlspecialchars($_POST['idfrais']);
                            
        if(empty($objet) || empty($unite) || empty($quantite) || empty($prix)) 
             $error = "Veuillez remplir tous les champs svp.";
        else if(!is_numeric($quantite) || !is_numeric($prix))
		     $error = "Veuillez saisir des nombres pour la quantite et le prix.";
		else {
			     
				 editAuFraisPrevision($objet, $unite, $quantite, $prix, $iddp, $idfrais, $cid);

		         $_SESSION['edited_autresfrais_prevision'] = 'Autre frais modifié!';
		 
		         header('Location: liste_autresfrais_prevision.php?idp='.$idp.'&iddp='.$iddp);
             }	 
    
      }
	
	
	
?>

    <center>

	     <?php
                    if(isset($_GET['idp']) && !empty($_GET['idp']) && is_projet_exist(htmlspecialchars($_GET['idp'])) == true  && isset($_GET['idfrais']) && !empty($_GET['idfrais']) && isset($_GET['iddp']) && !empty($_GET['iddp'])) {
					    
						$idp =  (int) trim(htmlspecialchars($_GET['idp']));
						$iddp = (int) trim(htmlspecialchars($_GET['iddp']));
						$idfrais = (int) trim(htmlspecialchars($_GET['idfrais']));
		
					    $projet = infos_projet($idp);
						$frais = infos_frais_prevision($idfrais);
						
          ?>
	
	          <h4>Projet: <?php echo '<span style="color: #08c;;">'.$projet['objet_projet'].'</span>'; ?></h4>
			  
			  <h4>Modification frais <span style="color: #08c;"><?php echo $frais['objet_autresfrais_previsionnel']; ?></span></h4>




 <center>

      <div class="" style="background-color:#6DCCF4; margin-top: 20px; width: 600px; border: 2px solid black; border-radius: 4px;">
	     
		        <u><h5>Autres Frais</h5></u>
	  
	                <center style="color: red;"><h4><?php if($error) echo $error; ?></h4></center>
	  
          <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'].'?idp='.$idp.'&iddp='.$iddp.'&idfrais='.$idfrais; ?>" method="post" enctype="multipart/form-data" id="" style="padding-top: 20px;">
		                                
              <div class="control-group">
			  
               <label class="control-label">Objet Autres Frais:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="text" name="objet_frais" id="objet_frais" value="<?php if($objet) echo $objet; else echo $frais['objet_autresfrais_previsionnel']; ?>" placeholder="Entrez l'objet">
                
               </div>
             </div>
				
				 <div class="control-group">
			  
               <label class="control-label">Unité Autres Frais:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="text" name="unite_frais" id="unite_frais" value="<?php if($unite) echo $unite; else echo $frais['unite_autresfrais_previsionnel']; ?>" placeholder="Entrez l'unité">
                  
               </div>
             </div>
				
			
		 <div class="control-group">
			  
               <label class="control-label">Quantité Autres Frais:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="text" name="quantite_frais" id="quantite_frais" value="<?php if($quantite) echo $quantite; else echo $frais['quantite_autresfrais_previsionnel']; ?>" placeholder="Entrez la puissance du materiel roulant">
           
               </div>
             </div>
			 
			 
			 
			 <div class="control-group">
			  
               <label class="control-label">Prix Unitaire Autres Frais:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="text" name="prix_frais" id="prix_frais" value="<?php if($prix) echo $prix; else echo $frais['prix_autresfrais_previsionnel']; ?>" placeholder="Entrez le prix unitaire Autres Frais">
         
               </div>
             </div>
		     
			 <input type="hidden" name="iddp" value="<?php echo $iddp; ?>" />
             <input type="hidden" value="<?php echo $projet['id_projet']; ?>" name="idp">
			 <input type="hidden" value="<?php echo $idfrais; ?>" name="idfrais">

			  <span id="champ_cacheee">
                  <button type="submit" class="btn" name="submit" style="">Modifier</button>
			      <a href="liste_autresfrais_prevision.php?idp=<?php echo $idp.'&iddp='.$iddp; ?>">
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
		    
			
			 <?php
                    if(isset($_GET['idp']) && !empty($_GET['idp']) && is_projet_exist(htmlspecialchars($_GET['idp'])) == true  && isset($_GET['iddp']) && !empty($_GET['iddp']) && is_previsionnelle_has_donnee_autresfrais(htmlspecialchars($_GET['iddp'])) == true) {
					    				
						
          ?>
		    
		  &nbsp;<a href="liste_autresfrais_prevision.php?idp=<?php echo $projet['id_projet'].'&iddp='.$iddp; ?>"><button style="margin-top: 20px;" class="btn btn-primary btn-mini" type="button"> <i class="icon icon-arrow-left icon-white"></i> Retour</button></a>
		  
		  <?php } ?>
			
			
		     &nbsp; <a href="liste_projet.php"><button style="margin-top: 20px;" class="btn btn-mini btn-primary" type="button">Liste des projets</button></a>
		     <a href="nouveau_projet.php"><button style="margin-top: 20px;" class="btn btn-mini btn-primary" type="button">Créer un nouveau projet</button></a>
		  &nbsp; <a href="index.php"><button style="margin-top: 20px;" class="btn btn-primary btn-mini" type="button">Accueil  <i class="icon icon-home icon-white"></i></button></a>
      </p>
		</p> 
	</center>

		
		
	  
	</center>


<?php include 'footer.php'; ?>