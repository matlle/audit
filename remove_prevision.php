<?php
    require_once 'header.php';
	require_once 'model.php';

	start_session();
    logout_protected();
	expired();
	
?>

    <center>
	
	
	<?php
	
	    if(isset($_POST['oui']) && isset($_POST['idp']) && !empty($_POST['idp']) && isset($_POST['iddp']) && !empty($_POST['iddp'])) {
		    
			$idp = (int)  htmlspecialchars($_POST['idp']);
			$iddp = (int)  htmlspecialchars($_POST['iddp']);
			removePrevision($idp, $iddp);
			
			 $_SESSION['removed_prevision'] = 'Donnée de privsion supprimée!';
			
			header('location: liste_donnee_prevision.php?idp='.$idp);
			
		}
	
	?>
	
	
	

	     <?php
                    if(isset($_GET['idp']) && !empty($_GET['idp']) && isset($_GET['iddp']) &&  !empty($_GET['iddp']) && is_projet_exist(htmlspecialchars($_GET['idp'])) == true) {
					    
						$id =  (int) trim(htmlspecialchars($_GET['idp']));
		                $iddp =  (int) trim(htmlspecialchars($_GET['iddp']));
						
					    $projet = infos_projet($id);
						$prevision = infos_previsionnelle($iddp);
										
						
          ?>
	
	          <h4>Voulez vous vraiment supprimer la donnée de prevision <?php echo '<span style="color: #08c;;">'.$prevision['nature_travaux_previsionnelle'].'</span>'; ?> et tous ses composants?</h4>
	
	
	     <p>
		     <form action="<?php echo $_SERVER['PHP_SELF'].'?idp='.$id; ?>" method="post">
			 
		         <span id="champ_cacheee"><a href="liste_donnee_prevision.php?idp=<?php echo $id; ?>"><button style="margin-top: 20px;" class="btn btn-success" type="button" ><i class="icon icon-arrow-left icon-white"></i> Non</button></a></span>
		         &nbsp; &nbsp; &nbsp; &nbsp;
		         <span id="champ_cachee"><button style="margin-top: 20px;" class="btn btn-danger" name="oui" type="submit" ><i class="icon icon-remove icon-white"></i> Oui</button></a></span>
			     <input type="hidden" name="idp" value="<?php echo $id; ?>" />
				 <input type="hidden" name="iddp" value="<?php echo $iddp; ?>" />
				 
			 </form>
         </p>
	  
	             

				 

        			
	  <?php 
	        } else {
			  echo '<h3 style="color: red;">Erreur: Aucun projet selectioné!</h3><br/>';
			}
        ?>
		
                   				   
		
		<p>
		    &nbsp; <a href="liste_projet.php"><button style="margin-top: 20px;" class="btn btn-mini btn-primary" type="button"><i class="icon icon-arrow-left icon-white"></i>  Liste des projets</button></a>
		</p>

		
		
	  
	</center>


<?php include 'footer.php'; ?>