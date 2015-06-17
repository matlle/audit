<?php
    include 'header.php';
	require_once 'model.php';
	
	start_session();
    logout_protected();
	expired();
	
	
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
                            
        if(empty($nature) || empty($unite) || empty($quantite) || empty($duree)) 
             $error = "Veuillez remplir tous les champs svp.";
        else if(!is_numeric($quantite))
		     $error = "Veuillez saisie des nombres la quanté svp.";
		else {
			     enregistrer_previsionnelle($nature, $unite, $quantite, $duree, $idp, $_SESSION['login']);
		         
		 
		         $_SESSION['saved_prevision'] = 'Donnée previsionnelle enregistrée!';
		 
		         header('Location: liste_donnee_prevision.php?idp='.$idp);
             }	 
    
      }
	
	
	
	
?>


				 
<center>

     <?php
                    if(isset($_GET['idp']) && !empty($_GET['idp']) && is_projet_exist(htmlspecialchars($_GET['idp'])) == true) {
					    
						$id =  (int) trim(htmlspecialchars($_GET['idp']));
		
					    $projet = infos_projet($id);
										
						
          ?>

		  
		  	          <h4>Projet: <?php echo '<span style="color: #08c;;">'.$projet['objet_projet'].'</span>'; ?></h4>
		  
		  

<div class="" style="background-color:#6DCCF4; margin-top: 20px; width: 600px; border: 2px solid black; border-radius: 4px;">
	     
		        
       <u><h5>Saisie de Données prévisionnelles</h5></u>
	  
                             <center style="color: red;"><?php if($error) echo $error; ?></center>
							 
          <form class="form-horizontal" action="donnee_previ.php?idp=<?php echo $projet['id_projet']; ?>" method="post" enctype="multipart/form-data" id="" style="padding-top: 50px;">
		                                
          
              <div class="control-group">
			  
               <label class="control-label" >Nature des Travaux:</label>
			   
								<div class="controls" style="margin-right: 150px;">
                   <input type="text" name="naturetravaux" id="naturetravaux" value="<?php if($nature) echo $nature; ?>" placeholder="Entrez la nature des travaux">
                              </div>
             </div>
			 
			 
			 
			 
			 
              <div class="control-group">
			  
               <label class="control-label">Unité:</label>
			   
								<div class="controls" style="margin-right: 150px;">
                   <input type="text" name="unitetravaux" id="objetprojet" value="<?php if($unite) echo $unite; ?>" placeholder="Entrez l'unité">
                              </div>
             </div>
			 
			 
			 
			 
              <div class="control-group">
			  
               <label class="control-label" >Quantité:</label>
			   
								<div class="controls" style="margin-right: 150px;">
                   <input type="text" name="quantitetravaux" id="objetprojet" value="<?php if($quantite) echo $quantite; ?>" placeholder="Entrez la quantité">
                              </div>
             </div>
			 
			 
			      <div class="control-group">
			  
               <label class="control-label">Durée:</label>
			   
								<div class="controls" style="margin-right: 150px;">
                   <input type="text" name="dureetravaux" id="dureetravaux" value="<?php if($duree) echo $duree; ?>" placeholder="Entrez la durée">
                              </div>
             </div>
			 
			 <input type="hidden" value="<?php echo $projet['id_projet']; ?>" name="prid">
			 
			 
			 
			 
			 
         
             <button type="submit" class="btn" name="submit" style="">Enregistrer</button>
			 
          </form>	
</div>


     <?php 
	        } else {
			  echo '<h3 style="color: red;">Erreur: Aucun projet selectioné!</h3><br/>';
			}
        ?>

		 
		 <p>

		 <?php
                    if(isset($_GET['idp']) && !empty($_GET['idp']) && is_projet_exist(htmlspecialchars($_GET['idp'])) == true) {
					    
						$id =  (int) trim(htmlspecialchars($_GET['idp']));
		
					    $projet = infos_projet($id);
										
						
          ?>
		    
		  <a href="travaux.php?idp=<?php echo $projet['id_projet']; ?>"><button style="margin-top: 20px;" class="btn btn-primary btn-mini" type="button"><i class="icon icon-arrow-left icon-white"></i>  Retour</button></a>
		  &nbsp;<a href="liste_donnee_prevision.php?idp=<?php echo $projet['id_projet']; ?>"><button style="margin-top: 20px;" class="btn btn-primary btn-mini" type="button">Voir la liste des données previsionnelles</button></a>
		  
		  <?php } ?>
		   
		   &nbsp; <a href="liste_projet.php"><button style="margin-top: 20px;" class="btn btn-mini btn-primary" type="button">Liste des projets</button></a>
		  &nbsp; <a href="index.php"><button style="margin-top: 20px;" class="btn btn-primary btn-mini" type="button">Accueil  <i class="icon icon-home icon-white"></i></button></a>
      </p>
		
		

</center>




<?php include 'footer.php'; ?>