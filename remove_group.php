<?php
    require_once 'header.php';
	require_once 'model.php';

	start_session();
    logout_protected();
	expired();
	
	
?>

    <center>
	
	
	<?php
	
	    if(isset($_POST['oui']) && isset($_POST['aid']) && !empty($_POST['aid'])) {
		    
			$aid = (int) htmlspecialchars($_POST['aid']);
		    	
			removeAccount($aid);
			
			$_SESSION['removed_group'] = 'Service supprimé!';

            header('location: manage_group.php');
			
		}
	
	?>
	
	
	

	     <?php
                    if(isset($_GET['aid']) && !empty($_GET['aid']) && is_account_exist(htmlspecialchars($_GET['aid'])) === true) {
					    
						$aid =  (int) trim(htmlspecialchars($_GET['aid']));
			            $account = getAccountById($aid);							
						
          ?>
	
	          <h4>Voulez vous vraiment supprimer le service <?php echo '<span style="color: #08c;;">'.$account['account_type'].'</span>'; ?> avec tous ses probables utilisateurs?</h4>
	
	
	     <p>
		     <form action="<?php echo $_SERVER['PHP_SELF'].'?aid='.$aid; ?>" method="post">
			 
                 <span id="champ_cacheee">
                    <a href="manage_group.php"><button style="margin-top: 20px;" class="btn btn-success" type="button" ><i class="icon icon-arrow-left icon-white"></i> Non</button></a>
                </span>
		         &nbsp; &nbsp; &nbsp; &nbsp;
		         <span id="champ_cachee"><button style="margin-top: 20px;" class="btn btn-danger" name="oui" type="submit" ><i class="icon icon-remove icon-white"></i> Oui</button></a></span>
			     <input type="hidden" name="aid" value="<?php echo $aid; ?>" />
				 
			 </form>
         </p>
	  
	             

				 

        			
	  <?php 
	        } else {
			  echo '<h3 style="color: red;">Erreur: Aucun service selectioné!</h3><br/>';
			}
        ?>
		
                   				   
		
		<p>
		    &nbsp; <a href="manage_user.php"><button style="margin-top: 20px;" class="btn btn-mini btn-primary" type="button"><i class="icon icon-arrow-left icon-white"></i>  Gérer les  utilisateurs</button></a>
		</p>

		
		
	  
	</center>


<?php include 'footer.php'; ?>
