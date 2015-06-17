<?php
    require_once 'header.php';
	require_once 'model.php';

	start_session();
    logout_protected();
	expired();
	
	
?>

    <center>
	
	
	<?php
	
	    if(isset($_POST['oui']) && isset($_POST['uid']) && !empty($_POST['uid'])) {
		    
			$uid = (int) htmlspecialchars($_POST['uid']);
		    	
			removeUser($uid);
			
			$_SESSION['removed_user'] = 'Utilisateur supprimé!';

            if(isset($_POST['p']) && !empty($_POST['p']))
			    header('location:'.htmlspecialchars($_POST['p']));
            else
                header('location: manage_user.php');
			
		}
	
	?>
	
	
	

	     <?php
                    if(isset($_GET['uid']) && !empty($_GET['uid']) && isUserExistById(htmlspecialchars($_GET['uid'])) === true) {
					    
						$uid =  (int) trim(htmlspecialchars($_GET['uid']));
			            $user = getUserById($uid);							
						
          ?>
	
	          <h4>Voulez vous vraiment supprimer l'utilisateur <?php echo '<span style="color: #08c;;">'.$user['matricule'].'</span>'; ?> ?</h4>
	
	
	     <p>
		     <form action="<?php echo $_SERVER['PHP_SELF'].'?uid='.$uid; ?>" method="post">
			 
                 <span id="champ_cacheee">
                    <?php if(isset($_GET['p'])) {?>
                    <a href="<?php echo htmlspecialchars($_GET['p']); ?>"><button style="margin-top: 20px;" class="btn btn-success" type="button" ><i class="icon icon-arrow-left icon-white"></i> Non</button></a>
                    <?php } else { ?>
                        <a href="manage_user.php"><button style="margin-top: 20px;" class="btn btn-success" type="button" ><i class="icon icon-arrow-left icon-white"></i> Non</button></a>
                    <?php } ?>
                </span>
		         &nbsp; &nbsp; &nbsp; &nbsp;
		         <span id="champ_cachee"><button style="margin-top: 20px;" class="btn btn-danger" name="oui" type="submit" ><i class="icon icon-remove icon-white"></i> Oui</button></a></span>
			     <input type="hidden" name="uid" value="<?php echo $uid; ?>" />
			     <input type="hidden" name="p" value="<?php if(isset($_GET['p']) && !empty($_GET['p'])) echo $_GET['p']; ?>" />
				 
			 </form>
         </p>
	  
	             

				 

        			
	  <?php 
	        } else {
			  echo '<h3 style="color: red;">Erreur: Aucun utilisateur selectioné!</h3><br/>';
			}
        ?>
		
                   				   
		
		<p>
		    &nbsp; <a href="manage_user.php"><button style="margin-top: 20px;" class="btn btn-mini btn-primary" type="button"><i class="icon icon-arrow-left icon-white"></i>  Gérer les  utilisateurs</button></a>
		</p>

		
		
	  
	</center>


<?php include 'footer.php'; ?>
