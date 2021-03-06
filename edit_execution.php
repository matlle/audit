<?php
    include 'header.php';
	require_once 'model.php';
	
	start_session();
    logout_protected();
	expired();
	
	$cid = getUserIdByName($_SESSION['login']);
	$cid = $cid['id_utilisateur'];
	
	$error = '';
	$nature = '';
	$unite = '';
	$quantite = '';
	$duree = '';
	$idp = '';
	
	
	if (isset($_POST['submit'])) {

        $nature =  (string) htmlspecialchars($_POST['naturetravaux']);
        $unite =  (string) htmlspecialchars($_POST['unitetravaux']);
	    $quantite =  (string) htmlspecialchars($_POST['quantitetravaux']);
	    $duree =  (string) htmlspecialchars($_POST['dureetravaux']);
		$idp = (int) htmlspecialchars($_POST['prid']);
		$idde = (int) htmlspecialchars($_POST['idde']);
                            
        if(empty($nature) || empty($unite) || empty($quantite) || empty($duree)) 
             $error = "Veuillez remplir tous les champs svp.";
        else if(!is_numeric($quantite))
		     $error = "Veuillez saisie des nombres pour l'unité et la quanté svp.";
		else {
			     editExecution($idp, $idde, $nature, $unite, $quantite, $duree, $cid);
		         
		 
		         $_SESSION['edited_execution'] = 'Données d\'execution modifié!';
		 
		         header('Location: liste_donnee_execution.php?idp='.$idp);
             }	 
    
      }
	
	
	
	
?>


<center>

    <?php
                    if(isset($_GET['idp']) && !empty($_GET['idp']) &&  isset($_GET['idde'])  && is_projet_exist(htmlspecialchars($_GET['idp'])) == true) {
					    
						$id =  (int) trim(htmlspecialchars($_GET['idp']));
		                $idde =  (int) trim(htmlspecialchars($_GET['idde']));
						
					    $projet = infos_projet($id);
						$execution = infos_execution($idde);
										
						
          ?>
		  
		  
		  	          <h4>Projet: <?php echo '<span style="color: #08c;;">'.$projet['objet_projet'].'</span>'; ?></h4>
					  
					  <h4>Modification d'exécution <?php echo '<span style="color: #08c;;">'.$execution['nature_travaux_execution'].'</span>'; ?></h4>


<div class="" style="background-color:#6DCCF4; margin-top: 20px; width: 600px; border: 2px solid black; border-radius: 4px;">
	     
		        
       <u><h5>Saisie de Données d'Execution</h5></u>
	  
              <center style="color: red;"><h4><?php if($error) echo $error; ?></h4></center>
		 
          <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'].'?idp='.$id.'&idde='.$idde; ?>" method="post" enctype="multipart/form-data" id="" style="padding-top: 50px;">
		                                
          
              <div class="control-group">
			  
               <label class="control-label" >Nature des Travaux:</label>
			   
								<div class="controls" style="margin-right: 150px;">
                   <input type="text" name="naturetravaux" id="naturetravaux" value="<?php if($nature) echo $nature; else echo $execution['nature_travaux_execution']; ?>" placeholder="Entrez la nature des travaux">
                              </div>
             </div>
			 
			 
			 
			 
			 
              <div class="control-group">
			  
               <label class="control-label">Unité:</label>
			   
								<div class="controls" style="margin-right: 150px;">
                   <input type="text" name="unitetravaux" id="objetprojet" value="<?php if($unite) echo $unite; else echo $execution['unite_execution']; ?>" placeholder="Entrez l'unité">
                              </div>
             </div>
			 
			 
			 
			 
              <div class="control-group">
			  
               <label class="control-label" >Quantité:</label>
			   
								<div class="controls" style="margin-right: 150px;">
                   <input type="text" name="quantitetravaux" id="objetprojet"  value="<?php if($quantite) echo $quantite; else echo $execution['quantite_execution']; ?>"  placeholder="Entrez la quantité">
                              </div>
             </div>
			 
			 
			      <div class="control-group">
			  
               <label class="control-label">Durée:</label>
			   
								<div class="controls" style="margin-right: 150px;">
                   <input type="text" name="dureetravaux" id="dureetravaux"  value="<?php if($duree) echo $duree; else echo $execution['duree_execution']; ?>"  placeholder="Entrez la durée">
                              </div>
             </div>
			 
			 
			 <input type="hidden" value="<?php echo $projet['id_projet']; ?>" name="prid">
			 <input type="hidden" value="<?php echo $idde; ?>" name="idde">
			 
			 
			 
         
             <span id="champ_cacheee">
			     <button type="submit" class="btn" name="submit" style="">Modifier</button>
			     <a href="liste_donnee_execution.php?idp=<?php echo $id; ?>">
			         <button style="margin-top: 0px;" class="btn btn-success" type="button" >Annuler</button>
				</a>
		    </span>
			 
          </form>	
</div>

 <?php 
	        } else {
			  echo '<h3 style="color: red;">Erreur: Aucun projet et/ou donnée d\'exécution selectionné!</h3><br/>';
			  
			}
        ?>
		
		
		<p>
		
		
		    <?php
                    if(isset($_GET['idp']) && !empty($_GET['idp']) && is_projet_exist(htmlspecialchars($_GET['idp'])) == true) {
					    
						$id =  (int) trim(htmlspecialchars($_GET['idp']));
		
					    $projet = infos_projet($id);
										
						
          ?>
		    
		  <a href="travaux.php?idp=<?php echo $projet['id_projet']; ?>"><button style="margin-top: 20px;" class="btn btn-primary btn-mini" type="button"><i class="icon icon-arrow-left icon-white"></i>  Retour</button></a>
		  &nbsp;<a href="liste_donnee_execution.php?idp=<?php echo $projet['id_projet']; ?>"><button style="margin-top: 20px;" class="btn btn-primary btn-mini" type="button">Voir la liste des données d'exécution</button></a>
		  
		  <?php } ?>
		  
		  &nbsp; <a href="liste_projet.php"><button style="margin-top: 20px;" class="btn btn-mini btn-primary" type="button">Liste des projets</button></a>
		  &nbsp; <a href="index.php"><button style="margin-top: 20px;" class="btn btn-primary btn-mini" type="button">Accueil  <i class="icon icon-home icon-white"></i></button></a>
      </p>
		

</center>





<?php include 'footer.php'; ?>