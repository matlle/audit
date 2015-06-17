<?php
    require_once 'header.php';
	require_once 'model.php';
	
	start_session();
    logout_protected();
	expired();
	
	
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
	$idde = '';
	
	if (isset($_POST['submit'])) {

        $code =  (string) htmlspecialchars($_POST['code_engins']);
        $nom =  (string) htmlspecialchars($_POST['nom_engins']);
	    $puissance =  (string) htmlspecialchars($_POST['puissance_engins']);
	    $marque =  (string) htmlspecialchars($_POST['marque_engins']);
		$nbjour =  htmlspecialchars($_POST['jour_engins']);
        $locationjour =  htmlspecialchars($_POST['location_engins']);
	    $conso_car_jour =   htmlspecialchars($_POST['carburant_engins']);
	    $prix_carburant =   htmlspecialchars($_POST['prix_carburant']);
		$conso_lub_jour =  htmlspecialchars($_POST['lubrifiant_engins']);
        $prix_lubrifiant =   htmlspecialchars($_POST['prix_lubrifiant']);
		
		$idp = (int) htmlspecialchars($_POST['prid']);
		$idde = (int) htmlspecialchars($_POST['idde']);
                            
        if(empty($code) || empty($nom) || empty($puissance) || empty($marque) || empty($nbjour) || empty($locationjour) || empty($conso_car_jour) || empty($prix_carburant) || empty($conso_lub_jour) || empty($prix_lubrifiant)) 
             $error = "Veuillez remplir tous les champs svp.";
        else if(!is_numeric($nbjour) || !is_numeric($locationjour) || !is_numeric($prix_carburant) || !is_numeric($prix_lubrifiant))
		     $error = "Veuillez saisir des nombres pour le nombre de jour, la location par jour et les differents prix.";
		else {
			     enregistrer_engin_execution($code, $nom, $puissance, $marque, $nbjour, $locationjour, $conso_car_jour, $prix_carburant, $conso_lub_jour, $prix_lubrifiant, $idde, $_SESSION['login']);
				 
		         $_SESSION['saved_engin_execution'] = 'Nouveau engin enregistré!';
		 
		         header('Location: liste_engin_execution.php?idp='.$idp.'&idde='.$idde);
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
	     
		        <u><h5>Création d'un materiel engins</h5></u>
				
				<center style="color: red;"><h4><?php if($error) echo $error; ?></center></h4>
	  
          <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'].'?idp='.$id.'&idde='.$idde; ?>" method="post" enctype="multipart/form-data" id="" style="padding-top: 50px;">
		                                
              <div class="control-group">
			  
               <label class="control-label">Code engins:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="text" name="code_engins" id="code_engins" value="<?php if($code) echo $code; ?>" placeholder="Entrez le code de l'engins du personnel">
                   
                   
               </div>
             </div>
				
				 <div class="control-group">
			  
               <label class="control-label">Nom engins:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="text" name="nom_engins" id="nom_engins" value="<?php if($nom) echo $nom; ?>" placeholder="Entrez le nom de l'engins">
                   
                   <!-- {% if er_fname %} <span class="profile-er"> {{ er_fname }} </span> {% endif %} -->
                   
               </div>
             </div>
				
			
		 <div class="control-group">
			  
               <label class="control-label">Puissance engins:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="text" name="puissance_engins" id="puissance_engins" value="<?php if($puissance) echo $puissance; ?>" placeholder="Entrez la puissance de l'engins">
                   
                   <!-- {% if er_fname %} <span class="profile-er"> {{ er_fname }} </span> {% endif %} -->
                   
               </div>
             </div>
			 
			 
			 
			 <div class="control-group">
			  
               <label class="control-label">Marque engins:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="text" name="marque_engins" id="marque_engins" value="<?php if($marque) echo $marque; ?>" placeholder="Entrez la marque de l'engins">
                   
                   <!-- {% if er_fname %} <span class="profile-er"> {{ er_fname }} </span> {% endif %} -->
                   
               </div>
             </div>
		
			 <div class="control-group">
			  
               <label class="control-label">Nombre de Jour engins:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="text" name="jour_engins" id="jour_engins" value="<?php if($nbjour) echo $nbjour; ?>" placeholder="Entrez le nombre de jours de l'engins">
                   
                   <!-- {% if er_fname %} <span class="profile-er"> {{ er_fname }} </span> {% endif %} -->
                   
               </div>
             </div>
		
		
		
	 <div class="control-group">
			  
               <label class="control-label">Location par Jour engins:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="text" name="location_engins" id="location_engins" value="<?php if($locationjour) echo $locationjour; ?>" placeholder="Entrez le montant de la location par jours de l'engins">
                   
                   <!-- {% if er_fname %} <span class="profile-er"> {{ er_fname }} </span> {% endif %} -->
                   
               </div>
             </div>
			 
			 
			 	
	 <div class="control-group">
			  
               <label class="control-label">Consommation Carburant par Jour engins:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="text" name="carburant_engins" id="carburant_engins" value="<?php if($conso_car_jour) echo $conso_car_jour; ?>" placeholder="Entrez la consommation de carburant par Jour de l'engins">
                   
                   <!-- {% if er_fname %} <span class="profile-er"> {{ er_fname }} </span> {% endif %} -->
                   
               </div>
             </div>
		
		
			 	
	 <div class="control-group">
			  
               <label class="control-label">Prix du Carburant:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="text" name="prix_carburant" id="prix_carburant" value="<?php if($prix_carburant) echo $prix_carburant; ?>" placeholder="Entrez le prix du carburant">
                   
                   <!-- {% if er_fname %} <span class="profile-er"> {{ er_fname }} </span> {% endif %} -->
                   
               </div>
             </div>
		
		
	 <div class="control-group">
			  
               <label class="control-label">Consommation lubrifiant par Jour engins:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="text" name="lubrifiant_engins" id="lubrifiant_engins" value="<?php if($conso_lub_jour) echo $conso_lub_jour; ?>" placeholder="Entrez la consommation de lubrifiant par Jour de l'engins">
                   
                   <!-- {% if er_fname %} <span class="profile-er"> {{ er_fname }} </span> {% endif %} -->
                   
               </div>
             </div>
		
				 	
	 <div class="control-group">
			  
               <label class="control-label">Prix du lubrifiant:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="text" name="prix_lubrifiant" id="prix_lubrifiant" value="<?php if($prix_lubrifiant) echo $prix_lubrifiant; ?>" placeholder="Entrez le prix du lubrifiant">
                   
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
                    if(isset($_GET['idp']) && !empty($_GET['idp']) && is_projet_exist(htmlspecialchars($_GET['idp'])) == true  && isset($_GET['idde']) && !empty($_GET['idde']) && is_execution_has_donnee_engin(htmlspecialchars($_GET['idde'])) == true) {
					    				
						
          ?>
		    
		  &nbsp;<a href="liste_engin_execution.php?idp=<?php echo $projet['id_projet'].'&idde='.$idde; ?>"><button style="margin-top: 20px;" class="btn btn-primary btn-mini" type="button">Liste engin execution <i class="icon icon-arrow-right icon-white"></i>  </button></a>
		  
		  <?php } ?>
			
			
		     &nbsp; <a href="liste_projet.php"><button style="margin-top: 20px;" class="btn btn-mini btn-primary" type="button">Liste des projets</button></a>
		     <a href="nouveau_projet.php"><button style="margin-top: 20px;" class="btn btn-mini btn-primary" type="button">Créer un nouveau projet</button></a>
		  &nbsp; <a href="index.php"><button style="margin-top: 20px;" class="btn btn-primary btn-mini" type="button">Accueil  <i class="icon icon-home icon-white"></i></button></a>
      </p>
		</p> 
	</center>
		
	  
	</center>


<?php include 'footer.php'; ?>