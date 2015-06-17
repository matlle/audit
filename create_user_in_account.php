<?php
    require_once 'header.php';
	require_once 'model.php';

	start_session();
    logout_protected();
	expired();
	
	$cid = getUserIdByName($_SESSION['login']);
	$cid = $cid['id_utilisateur'];
    super_AND_chef_protected($_SESSION['login'], $cid);
	
	
    $error = '';
	$matricule = '';
	$nom = '';
	$password = '';
	$groupe = '';
	$chef = '';
	$aid = '';
	
	
	if (isset($_POST['submit'])) {

    $matricule =  htmlspecialchars($_POST['matricule']);
    $nom =  htmlspecialchars($_POST['nom']);
	$password =  htmlspecialchars($_POST['password']);
	$groupe =  htmlspecialchars($_POST['groupe']);
	$chef =  htmlspecialchars($_POST['chef']);
	$aid =  htmlspecialchars($_POST['aid']);
    
    if(empty($matricule) || empty($nom) || empty($password) || empty($groupe)) 
        $error = "Veuillez remplir tous les champs svp.";
     else if(isUserExist(strtolower($matricule)) === true) {
	    $error = "Un utilisateur avec ce matricule existe dejà. Choisissez un autre matricule svp";
	  } else {
	      $groupe = getAccountIdByName($groupe);
	      $chef = ($chef == 'oui' ? 1 : 0);
	      $nuid =enregistrer_user($matricule, $nom, $password, $aid, $chef, $_SESSION['login']);

          if($chef == 1)
              dochef($aid, $nuid, $cid);
 
		 $_SESSION['saved_user'] = 'Utilisateur enregistré!';
		 
		 header('Location: service.php?aid='.$aid);
     }	 
    
 }
	
	
?>


         <?php
		             
					  if(isset($_GET['aid']) && !empty($_GET['aid']) && is_account_exist(htmlspecialchars($_GET['aid'])) == true) {
					    
	                     $aid =  (int) trim(htmlspecialchars($_GET['aid']));
						 
		                 $users = getAllUsersByAccount($aid);
		                 $account = getAccountById($aid);
					  
		 ?>




  <center>

                   <h4>Créer un utilisateur dans le service <span style="color: #08c;"><?php echo $account['account_type']; ?></span></h4>
  
  
      <div class="" style="background-color:#6DCCF4; margin-top: 20px; width: 600px; border: 1px solid black;">
	     
		        
	       
          <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'].'?aid='.$aid; ?>" method="post" enctype="multipart/form-data" id="" style="padding-top: 10px;">
		                                
              <center style="color: red; margin-bottom: 10px;"><?php if($error) echo $error; ?></center> 
              <div class="control-group">
			  
               <label class="control-label" for="login">Matricule:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="text" name="matricule" id="objetprojet" value="<?php if($matricule) echo $matricule; ?>" placeholder="Matricule">
                   
               </div>
             </div>
		    
			 
			 <div class="control-group">  
               <label class="control-label" for="login">Nom:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="text" name="nom" id="" value="<?php if($nom) echo $nom; ?>" placeholder="Nom">
                   
               </div>
             </div>
			 
			 
			 <div class="control-group">  
               <label class="control-label" for="login">Mot de passe:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="text" name="password" id="" value="<?php if($password) echo $password; ?>" placeholder="**********">
                   
               </div>
             </div>
			 
			 
			  <div class="control-group">  
               <label class="control-label" for="login">Service:</label>
               <div class="controls" style="margin-right: 150px;">
                   <select name="groupe">
				       <?php
                                echo '<option>'.$account['account_type'].'</option>';										
					    ?> 
				   </select>
               </div>
             </div>
			 
			 
			 <div class="control-group">  
               <label class="control-label" for="login">Est chef du service?:</label>
               <div class="controls" style="margin-right: 270px;">
                   
				   <input type="radio" name="chef" id="" value="oui">Oui
				   &nbsp;&nbsp;&nbsp;<input type="radio" name="chef" id="" value="non" checked="checked">Non
				   
               </div>
             </div>
			 
			 <input type="hidden" name="aid" value="<?php echo $account['account_id']; ?>">
			 
             <button type="submit" class="btn" name="submit" style="">Enregistrer</button>
			 <a href="manage_user.php"><button type="button" class="btn btn-success" name="cancel" style="">Annuler</button></a>
			 
          </form>		  
		  
      </div>

	      <?php

                      } else {
						          echo "<span style='color: red;'>Error: Aucun service selectionné</span>";
                      }				  
				 
		  ?>
	  
	  <p>
		  <a href="index.php"><button style="margin-top: 20px;" class="btn btn-primary btn-mini" type="button">Accueil  <i class="icon icon-home icon-white"></i></button></a>
		  <a href="liste_projet.php"><button style="margin-top: 20px;" class="btn btn-mini btn-primary" type="button">Liste des projets</button></a>
		  
      </p>
	  
  </center>


<?php include 'footer.php'; ?>
