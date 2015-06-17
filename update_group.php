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
	//$chef = '';

	
	$cid = getUserIdByName($_SESSION['login']);
	$cid = $cid['id_utilisateur'];
	
	
	if (isset($_POST['submit'])) {

    $nom =  htmlspecialchars($_POST['nom']);
    //$chef =  htmlspecialchars($_POST['chef']);
    $aid =  htmlspecialchars($_POST['aid']);
    
    if(empty($nom))  {
        $error = "Veuillez specifié le nom du service svp.";
	  } else {
	   updateAccountById($nom, $aid, $cid);
		 /*if(!empty($chef))
             updateUserByName($chef, $sid);*/
		 
		 $_SESSION['updated_group'] = 'Service modifié!';
		 
		 header('Location: manage_group.php');
     }	 
    
 }
	
	
?>


  <center>

     <?php if(isset($_GET['aid']) && !empty($_GET['aid']) && is_account_exist($_GET['aid']) === true) {
         $aid = htmlspecialchars($_GET['aid']);
         $account = getAccountById($aid);
     ?>

         <h4 style="color: #08c;">Modifier le service <?php echo $account['account_type']; ?> </h4>
  
  
      <div class="" style="background-color:#6DCCF4; margin-top: 20px; width: 600px; border: 1px solid black;">
	     
		        
	       
          <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data" id="" style="padding-top: 10px;">
		                                
              <center style="color: red; margin-bottom: 10px;"><?php if($error) echo $error; ?></center> 
              <div class="control-group">
			  
               <label class="control-label" for="login">Nom du service:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="text" name="nom" id="" value="<?php if($nom) echo $nom; else echo $account['account_type']; ?>" placeholder="Nom du service">
                   
               </div>
             </div>
		    
            <input type="hidden" name="aid" value="<?php echo $aid?>" />
			 
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
			 
			  
             <button type="submit" class="btn" name="submit" style="">Modifier</button>
             <a href="manage_group.php"><button type="button" class="btn btn-success" name="cancel" style="">Annuler</button></a>
			 
          </form>		  
		  
      </div>

       <?php
            } else {
             echo 'Erreur: Aucun service selectioné!';
            }
       ?>
	  
	  <p>
		  <a href="index.php"><button style="margin-top: 20px;" class="btn btn-primary btn-mini" type="button">Accueil  <i class="icon icon-home icon-white"></i></button></a>
		  <a href="liste_projet.php"><button style="margin-top: 20px;" class="btn btn-mini btn-primary" type="button">Liste des projets</button></a>
		  
      </p>
	  
  </center>


<?php include 'footer.php'; ?>
