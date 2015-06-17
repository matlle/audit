<?php
    require_once 'header.php';
	require_once 'model.php';
	
	start_session();
    logout_protected();
	expired();
	
    $error = '';
	$objet = '';
	$unite = '';
	$quantite = '';
	$prix = '';
	$idp = '';
	$idde = '';
	
	if (isset($_POST['submit'])) {

        $objet =  (string) htmlspecialchars($_POST['objet_frais']);
        $unite =  (string) htmlspecialchars($_POST['unite_frais']);
	    $quantite =  (string) htmlspecialchars($_POST['quantite_frais']);
	    $prix =  (string) htmlspecialchars($_POST['prix_frais']);
		$idp = (int) htmlspecialchars($_POST['prid']);
		$idde = (int) htmlspecialchars($_POST['idde']);
                            
        if(empty($objet) || empty($unite) || empty($quantite) || empty($prix)) 
             $error = "Veuillez remplir tous les champs svp.";
        else if(!is_numeric($quantite) || !is_numeric($prix))
		     $error = "Veuillez saisir des nombres pour la quantite et le prix.";
		else {
			     enregistrer_autresfrais_execution($objet, $unite, $quantite, $prix, $idde, $_SESSION['login']);
				 
		 
		         $_SESSION['saved_autresfrais_execution'] = 'Nouveau frais enregistré!';
		 
		         header('Location: liste_autresfrais_execution.php?idp='.$idp.'&idde='.$idde);
             }	 
    
      }
	
	
	
?>

    <center>

	     <?php
                    if(isset($_GET['idp']) && !empty($_GET['idp']) && is_projet_exist(htmlspecialchars($_GET['idp'])) == true  && isset($_GET['idde']) && !empty($_GET['idde'])) {
					    
						$id =  (int) trim(htmlspecialchars($_GET['idp']));
						$idde = (int) trim(htmlspecialchars($_GET['idde']));
		
					    $projet = infos_projet($id);
										
						
          ?>
	
	          <h4>Projet: <?php echo '<span style="color: #08c;;">'.$projet['objet_projet'].'</span>'; ?></h4>




 <center>

      <div class="" style="background-color:#6DCCF4; margin-top: 20px; width: 600px; border: 2px solid black; border-radius: 4px;">
	     
		        <u><h5>Autres Frais</h5></u>
	  
	                <center style="color: red;"><h4><?php if($error) echo $error; ?></h4></center>
	  
          <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'].'?idp='.$id.'&idde='.$idde; ?>" method="post" enctype="multipart/form-data" id="" style="padding-top: 20px;">
		                                
              <div class="control-group">
			  
               <label class="control-label">Objet Autres Frais:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="text" name="objet_frais" id="objet_frais" value="" placeholder="Entrez l'objet">
                   
                   <!-- {% if er_fname %} <span class="profile-er"> {{ er_fname }} </span> {% endif %} -->
                   
               </div>
             </div>
				
				 <div class="control-group">
			  
               <label class="control-label">Unité Autres Frais:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="text" name="unite_frais" id="unite_frais" value="" placeholder="Entrez l'unité">
                   
                   <!-- {% if er_fname %} <span class="profile-er"> {{ er_fname }} </span> {% endif %} -->
                   
               </div>
             </div>
				
			
		 <div class="control-group">
			  
               <label class="control-label">Quantité Autres Frais:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="text" name="quantite_frais" id="quantite_frais" value="" placeholder="Entrez la puissance du materiel roulant">
                   
                   <!-- {% if er_fname %} <span class="profile-er"> {{ er_fname }} </span> {% endif %} -->
                   
               </div>
             </div>
			 
			 
			 
			 <div class="control-group">
			  
               <label class="control-label">Prix Unitaire Autres Frais:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="text" name="prix_frais" id="prix_frais" value="" placeholder="Entrez le prix unitaire Autres Frais">
                   
                   <!-- {% if er_fname %} <span class="profile-er"> {{ er_fname }} </span> {% endif %} -->
                   
               </div>
             </div>
		     
			 <input type="hidden" name="idde" value="<?php echo $idde; ?>" />
             <input type="hidden" value="<?php echo $projet['id_projet']; ?>" name="prid">
		
			  <button type="submit" class="btn" name="submit" style="">Enregistrer</button>
			 
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
		    
			&nbsp;<a href="info_travauxe.php?idp=<?php echo $projet['id_projet'].'&idde='.$idde; ?>"><button style="margin-top: 20px;" class="btn btn-primary btn-mini" type="button"><i class="icon icon-arrow-left icon-white"></i>  Retour</button></a>
			 <?php
                    if(isset($_GET['idp']) && !empty($_GET['idp']) && is_projet_exist(htmlspecialchars($_GET['idp'])) == true  && isset($_GET['idde']) && !empty($_GET['idde']) && is_execution_has_donnee_autresfrais(htmlspecialchars($_GET['idde'])) == true) {
					    				
						
          ?>
		    
		  &nbsp;<a href="liste_autresfrais_execution.php?idp=<?php echo $projet['id_projet'].'&idde='.$idde; ?>"><button style="margin-top: 20px;" class="btn btn-primary btn-mini" type="button">Liste frais d'execution <i class="icon icon-arrow-right icon-white"></i>  </button></a>
		  
		  <?php } ?>
			
			
		     &nbsp; <a href="liste_projet.php"><button style="margin-top: 20px;" class="btn btn-mini btn-primary" type="button">Liste des projets</button></a>
		     <a href="nouveau_projet.php"><button style="margin-top: 20px;" class="btn btn-mini btn-primary" type="button">Créer un nouveau projet</button></a>
		  &nbsp; <a href="index.php"><button style="margin-top: 20px;" class="btn btn-primary btn-mini" type="button">Accueil  <i class="icon icon-home icon-white"></i></button></a>
      </p>
		</p> 
	</center>

		
		
	  
	</center>


<?php include 'footer.php'; ?>