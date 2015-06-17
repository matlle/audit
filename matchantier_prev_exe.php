<?php
    require_once 'header.php';
	require_once 'model.php';
	
	start_session();
    logout_protected();
	expired();
	
	$error = '';
	$code = '';
	$nom = '';
	$unite = '';
	$quantite = '';
	$cout = '';
	$idp = '';
	$idde = '';
	
	if (isset($_POST['submit'])) {

        $code =  (string) htmlspecialchars($_POST['code_materiel']);
		$nom =  (string) htmlspecialchars($_POST['nom_materiel']);
        $unite =  (string) htmlspecialchars($_POST['unite_materiel']);
	    $quantite =  (string) htmlspecialchars($_POST['quantite_materiel']);
	    $cout =  (string) htmlspecialchars($_POST['cout_materiel']);
		$idp = (int) htmlspecialchars($_POST['prid']);
		$idde = (int) htmlspecialchars($_POST['idde']);
                            
        if(empty($code) || empty($nom) || empty($unite) || empty($quantite) || empty($cout)) 
             $error = "Veuillez remplir tous les champs svp.";
        else if(!is_numeric($quantite) || !is_numeric($cout))
		     $error = "Veuillez saisir des nombres pour la quantite et le prix.";
		else {
			     enregistrer_materiel_execution($code, $nom, $unite, $quantite, $cout, $idde, $_SESSION['login']);
		 
		         $_SESSION['saved_materiel_execution'] = 'Nouveau materiel enregistrée!';
		 
		         header('Location: liste_materiel_execution.php?idp='.$idp.'&idde='.$idde);
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
	     
		        <u><h5>Création d'un materiel chantier</h5></u>
				
				
				<center style="color: red;"><h4><?php if($error) echo $error; ?></h4></center>
	  
          <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'].'?idp='.$id.'&idde='.$idde; ?>" method="post" enctype="multipart/form-data" id="" style="padding-top: 50px;">
		                                
              <div class="control-group">
			  
               <label class="control-label">Code materiel chantier:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="text" name="code_materiel" id="code_materiel" value="<?php if($code) echo $code; ?>" placeholder="Entrez le code du matériel chantier">
                   
                   <!-- {% if er_fname %} <span class="profile-er"> {{ er_fname }} </span> {% endif %} -->
                   
               </div>
             </div>
				
				 <div class="control-group">
			  
               <label class="control-label">Nom Matériel:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="text" name="nom_materiel" id="nom_materiel" value="<?php if($nom) echo $nom; ?>" placeholder="Entrez le nom materiel">
                   
                   <!-- {% if er_fname %} <span class="profile-er"> {{ er_fname }} </span> {% endif %} -->
                   
               </div>
             </div>
				
			
		 <div class="control-group">
			  
               <label class="control-label">Unité:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="text" name="unite_materiel" id="unite_materiel" value="<?php if($unite) echo $unite; ?>" placeholder="Entrez l'unité du matériel">
                   
                   <!-- {% if er_fname %} <span class="profile-er"> {{ er_fname }} </span> {% endif %} -->
                   
               </div>
             </div>
			 
			 
			 
			  <div class="control-group">
			  
               <label class="control-label">Quantité:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="text" name="quantite_materiel" id="quantite_materiel" value="<?php if($quantite) echo $quantite; ?>" placeholder="Entrez la quantité du matériel">
                   
                   <!-- {% if er_fname %} <span class="profile-er"> {{ er_fname }} </span> {% endif %} -->
                   
               </div>
             </div>
			 
			 
			 
			  <div class="control-group">
			  
               <label class="control-label">Coût  Unitaire:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="text" name="cout_materiel" id="cout_materiel" value="<?php if($cout) echo $cout; ?>" placeholder="Entrez le coût  du matériel">
                   
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
		    
			
			       &nbsp;<a href="info_travauxp.php?idp=<?php echo $projet['id_projet'].'&idde='.$idde; ?>"><button style="margin-top: 20px;" class="btn btn-primary btn-mini" type="button"><i class="icon icon-arrow-left icon-white"></i>  Retour</button></a>
			 <?php
                    if(isset($_GET['idp']) && !empty($_GET['idp']) && is_projet_exist(htmlspecialchars($_GET['idp'])) == true  && isset($_GET['idde']) && !empty($_GET['idde']) && is_execution_has_donnee_materiel(htmlspecialchars($_GET['idde'])) == true) {
					    				
						
          ?>
		    
		  &nbsp;<a href="liste_materiel_execution.php?idp=<?php echo $projet['id_projet'].'&idde='.$idde; ?>"><button style="margin-top: 20px;" class="btn btn-primary btn-mini" type="button">Liste materiel d'execution <i class="icon icon-arrow-right icon-white"></i>  </button></a>
		  
		  <?php } ?>
			
		     &nbsp; <a href="liste_projet.php"><button style="margin-top: 20px;" class="btn btn-mini btn-primary" type="button">Liste des projets</button></a>
		     <a href="nouveau_projet.php"><button style="margin-top: 20px;" class="btn btn-mini btn-primary" type="button">Créer un nouveau projet</button></a>
		  &nbsp; <a href="index.php"><button style="margin-top: 20px;" class="btn btn-primary btn-mini" type="button">Accueil  <i class="icon icon-home icon-white"></i></button></a>
      </p>
		</p> 
	</center>
	  
	</center>


<?php include 'footer.php'; ?>