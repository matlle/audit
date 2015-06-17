<?php
    require_once 'header.php';
	require_once 'model.php';

	start_session();
    logout_protected();
	expired();
	
	
	$cid = getUserIdByName($_SESSION['login']);
	$cid = $cid['id_utilisateur'];
    super_AND_chef_protected($_SESSION['login'], $cid);
	
	
	$users = getAllUsersNotChef();
	
	
    $error = '';
	$nom = '';
	$chef = '';

	
	
	if (isset($_POST['submit'])) {

    $nom =  htmlspecialchars($_POST['nom']);
    $chef =  htmlspecialchars($_POST['chef']);
    
    if(empty($nom))  {
        $error = "Veuillez specifié le nom du service svp.";
	  } else {
	    $sid = enregistrer_service($nom, $_SESSION['login']);
		 if(!empty($chef))
		     updateUserByName($chef, $sid);
		 
		 $_SESSION['saved_group'] = 'Service crée!';
		 
		 header('Location: manage_group.php');
     }	 
    
 }
	
	
?>


  <center>

                   <h4 style="color: #08c;">Créer un service</h4>
  
  
      <div class="" style="background-color:#6DCCF4; margin-top: 20px; width: 600px; border: 1px solid black;">
	     
		        
	       
          <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data" id="" style="padding-top: 10px;">
		                                
              <center style="color: red; margin-bottom: 10px;"><?php if($error) echo $error; ?></center> 
              <div class="control-group">
			  
               <label class="control-label" for="login">Nom du service:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="text" name="nom" id="" value="<?php if($nom) echo $nom; ?>" placeholder="Nom du service">
                   
               </div>
             </div>
		    
			 
			  <!-- <div class="control-group">  
               <label class="control-label" for="login">Chef de service:</label>
               <div class="controls" style="margin-right: 150px;">
                   <select name="chef">
				       <?php
					            //echo '<option></option>';
                                //$j = 0;
                                /*$t = getAllUsersNotChef();
                                 foreach($t as $ind) {
                                     echo '<option>'.$ind['login'].'</option>';
                                 }*/									 
					   ?> 
								
				   </select>
               </div>
             </div> -->
			 
			  
             <button type="submit" class="btn" name="submit" style="">Enregistrer</button>
			 <a href="manage_group.php"><button type="button" class="btn btn-success" name="cancel" style="">Annuler</button></a>
			 
          </form>		  
		  
      </div>
	  
	  <p>
		  <a href="index.php"><button style="margin-top: 20px;" class="btn btn-primary btn-mini" type="button">Accueil  <i class="icon icon-home icon-white"></i></button></a>
		  <a href="liste_projet.php"><button style="margin-top: 20px;" class="btn btn-mini btn-primary" type="button">Liste des projets</button></a>
		  
      </p>
	  
  </center>


<?php include 'footer.php'; ?>
