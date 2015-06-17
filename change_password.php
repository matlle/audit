<?php

 require_once 'header.php';
 require_once 'model.php';
 
 start_session();
  logout_protected();
  expired();
 
$cid = getUserIdByName($_SESSION['login']);
$cid = $cid['id_utilisateur'];
 

 $error = '';
 $opass = '';
 $npass1 = '';
 $npass2 = '';

 
 
 if (isset($_POST['submit'])) {

    $opass = (string) htmlspecialchars($_POST['opass']);
    $npass1 = (string) htmlspecialchars($_POST['npass1']);
	$npass2 = (string) htmlspecialchars($_POST['npass2']);
    
    if(empty($opass) || empty($npass1) || empty($npass2)) {
        $error = "Veuillez remplir tous les champs svp.";
    }
    else if (login($_SESSION['login'], $opass) === false){
        $error = "Actuel mot de passe incorrect, ressayez svp.";
    }
    else if ($npass1 != $npass2) {
	     $error = "La confirmation du mot de passe ne correspond pas, ressayez svp";
    } else {
		
		changePassword($npass1, $cid, $cid);
		
		$_SESSION['login'] = $_SESSION['login'];
		$_SESSION['pwd'] = $npass1;
		$_SESSION['new_password'] = 'Mot de passe changé avec success!';
		
         header('Location: gestion.php');
    }
    
 }
?>
  
  <center>

      <div class="" style="background-color:#6DCCF4; margin-top: 30px; height: 300px; width: 600px; border: 2px solid black;  border-radius: 4px;">
                         <h4>Changer mot de passe</4>
          <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" id="" style="padding-top: 25px;">
              <center style="color: red; padding-bottom: 10px;"> <?php if($error) echo $error; ?> </center> 
              <div class="control-group">
               <label class="control-label" for="login">Actuel mot de passe:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="password" name="opass" id="login" value="<?php if($opass) echo $opass; else echo ""; ?>" placeholder="********">
                  
               </div>
             </div>

           <div class="control-group">
               <label class="control-label" for="password">Nouveau mot de passe:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="password" name="npass1" id="password" value="<?php if($npass1) echo $npass1; else echo ""; ?>" placeholder="********">

               </div>
           </div>
		   
		   
           <div class="control-group">
               <label class="control-label" for="password">Confirmer mot de passe:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="password" name="npass2" id="password" value="<?php if($npass2) echo $npass2; else echo ""; ?>" placeholder="********">

               </div>
           </div>

           
             <button type="submit" class="btn" name="submit" style="">Valider</button>
               
          </form>
		  
		  
      </div>
  </center>

<?php include 'footer.php'; ?>
