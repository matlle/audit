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
	$nom = '';
	$password = '';
	$groupe = '';
	$chef = '';
	$uid = '';
	
	
	if (isset($_POST['submit'])) {

    $nom =  htmlspecialchars($_POST['nom']);
	$password =  htmlspecialchars($_POST['password']);
	$groupe =  htmlspecialchars($_POST['groupe']);
	$chef =  htmlspecialchars($_POST['chef']);
	$uid =  htmlspecialchars($_POST['uid']);
    
    if(empty($nom) || empty($password) || empty($groupe)) {  
        $error = "Veuillez remplir tous les champs svp.";
	  } else {
	      $groupe = getAccountIdByName($groupe);
	      $chef = ($chef == 'oui' ? 1 : 0);

              if($chef == 0) {
                  if(isUserIsChef($uid)) {
                      //unchef($groupe['account_id']);
                      updateUserById($uid, $nom, $password, $groupe['account_id'], $chef, $_SESSION['login']);
                  } else
                      updateUserById($uid, $nom, $password, $groupe['account_id'], $chef, $_SESSION['login']);
              } else if($chef == 1) { 
                  updateUserById($uid, $nom, $password, $groupe['account_id'], $chef, $_SESSION['login']);
                  //dochef($groupe['account_id'], $uid, $cid);
             }
 
		 $_SESSION['updated_user'] = 'Utilisateur modifié!';

         if(isset($_POST['p']) && !empty($_POST['p']))
             header('Location: '.htmlspecialchars($_POST['p']).$groupe['account_id']);
         else
             header('Location: manage_user.php');

     }	 
    
 }



	
?>


  <center>

      <?php
          if(isset($_GET['uid']) && !empty($_GET['uid']) && !empty($_GET['aid']) && isset($_GET['aid']) && !empty($_GET['aid']) && isUserExistById(htmlspecialchars($_GET['uid'])) === true) {
              $aid = (int) htmlspecialchars($_GET['aid']);
              $uid = (int) htmlspecialchars($_GET['uid']);
              $user = getUserById($uid);

     ?>           

       <h4 style="color: #08c;">Modifier l'utilisateur <?php echo $user['matricule']; ?></h4>
  
  
      <div class="" style="background-color:#6DCCF4; margin-top: 20px; width: 600px; border: 1px solid black;">
	     
		        
	       
          <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'].'?uid='.$uid;?>" method="post" enctype="multipart/form-data" id="" style="padding-top: 10px;">
		                                
              <center style="color: red; margin-bottom: 10px;"><?php if($error) echo $error; ?></center> 
			
			 <div class="control-group">  
               <label class="control-label" for="login">Nom:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="text" name="nom" id="" value="<?php if($nom) echo $nom; else echo $user['login']; ?>" placeholder="Nom">
                   
               </div>
             </div>
			 
			 
			 <div class="control-group">  
               <label class="control-label" for="login">Mot de passe:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="text" name="password" id="mht" value="<?php if($password) echo $password; else echo $user['password']; ?>" placeholder="**********">
                   
               </div>
             </div>
			 
			 
			  <div class="control-group">  
               <label class="control-label" for="login">Service:</label>
               <div class="controls" style="margin-right: 150px;">
                   <select name="groupe">
				       <?php
                                $service = getAccountById($aid);
                                echo '<option>'.$service['account_type'].'</option>';										

                                $t = getAllAccountByIdExceptThisId($aid);
                                 foreach($t as $ind)
                                     echo '<option>'.$ind['account_type'].'</option>';									
					         ?> 
				   </select>
               </div>
             </div>
			 
			 
			 <div class="control-group">  
               <label class="control-label" for="login">Est chef du service?:</label>
               <div class="controls" style="margin-right: 270px;">
                   
               <input type="radio" name="chef" id="" value="oui" <?php if(isUserIschef($uid) === true) echo 'checked="checked"'; ?>>Oui
               &nbsp;&nbsp;&nbsp;<input type="radio" name="chef" id="" value="non" <?php if(isUserIschef($uid) === false) echo 'checked="checked"'; ?>>Non
				   
               </div>
             </div>
			 
             <input type="hidden" name="uid" value="<?php echo $uid?>" />
             <input type="hidden" name="p" value="<?php if(isset($_GET['p']) && !empty($_GET['p'])) echo $_GET['p']; ?>" />

             <button type="submit" class="btn" name="submit" style="">Modifier</button>
             <a href="<?php if(isset($_GET['p']) && !empty($_GET['p']) && isset($_GET['aid']) && !empty($_GET['aid'])) echo $_GET['p'].$_GET['aid']; ?>"><button type="button" class="btn btn-success" name="cancel" style="">Annuler</button></a>
			 
          </form>		  
		  
      </div>

      <?php
          } else {
              echo '<h3 style="color: red;">Erreur: Aucun utilisateur selectionné!</h3>';
          }
      ?>
	  
	  <p>
		  <a href="index.php"><button style="margin-top: 20px;" class="btn btn-primary btn-mini" type="button">Accueil  <i class="icon icon-home icon-white"></i></button></a>
		  <a href="liste_projet.php"><button style="margin-top: 20px;" class="btn btn-mini btn-primary" type="button">Liste des projets</button></a>
		  
      </p>
	  
  </center>


<?php include 'footer.php'; ?>
