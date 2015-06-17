<?php

 include 'header.php';
 require_once 'model.php';
 
 
 logged_protected();
 

 $error = '';
 $login = '';
 $password = '';

 
 
 if (isset($_POST['submit'])) {

    $login = (string) htmlspecialchars($_POST['login']);
    $password = (string) htmlspecialchars($_POST['password']);
    
    if(empty($login) || empty($password)) {
        $error = "Veuillez remplir tous les champs svp.";
    }
    else if (login($login, $password) === false){
        $error = "Mot de passe ou login incorrect, ressayez svp.";
    }
    else if (login($login, $password) === true) {
	    

		
		$_SESSION['login'] = $login;
		$_SESSION['pwd'] = $password;
		
		$uid = getUserIdByName($login);
		$uid = $uid['id_utilisateur'];
		$_SESSION['section'] = getAccountNameByUserId($uid);
	    
		header('Location: gestion.php');
    }
    
 }
?>
  
  <center>

      <div class="" style="background-color:#6DCCF4; margin-top: 30px; height: 300px; width: 600px; border: 2px solid black;  border-radius: 4px;">

                    <h4>Connexion</h4>

          <form class="form-horizontal" action="index.php" method="post" enctype="multipart/form-data" id="" style="padding-top: 10px;">
              <center style="color: red; padding-bottom: 10px;"> <?php if($error) echo $error; ?> </center> 
              <div class="control-group">
               <label class="control-label" for="login">Login:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="text" name="login" id="login" value="<?php if($login) echo $login; else echo ""; ?>" placeholder="Login">
                  
               </div>
             </div>

           <div class="control-group">
               <label class="control-label" for="password">Password:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="password" name="password" id="password" value="<?php if($password) echo $password; else echo ""; ?>" placeholder="********">

               </div>
           </div>

           
             <button type="submit" class="btn" name="submit" style="">Connect</button>
               
          </form>
		  
		  
      </div>
  </center>

<?php include 'footer.php'; ?>
