<?php
    require_once 'header.php';
	require_once 'model.php';

	start_session();
    logout_protected();
	expired();
	
?>

    <center>
	
	
	<?php
	
	    if(isset($_POST['oui']) && isset($_POST['idp']) && !empty($_POST['idp']) && isset($_POST['idde']) && !empty($_POST['idde'])) {
		    
			$idp = (int)  htmlspecialchars($_POST['idp']);
			$idde = (int)  htmlspecialchars($_POST['idde']);
			removeExecution($idp, $idde);
			
			 $_SESSION['removed_execution'] = 'Donnée d\'exécution supprimée!';
			
			header('location: liste_donnee_execution.php?idp='.$idp);
			
		}
	
	?>
	
	
	

	     <?php
                    if(isset($_GET['idp']) && !empty($_GET['idp']) && isset($_GET['idde']) && is_projet_exist(htmlspecialchars($_GET['idp'])) == true) {
					    
						$id =  (int) trim(htmlspecialchars($_GET['idp']));
		                $idde =  (int) trim(htmlspecialchars($_GET['idde']));
						
					    $projet = infos_projet($id);
						$execution = infos_execution($idde);
										
						
          ?>
	
	          <h4>Voulez vous vraiment supprimer la donnée d'exécution <?php echo '<span style="color: #08c;;">'.$execution['nature_travaux_execution'].'</span>'; ?> et tous ses composants?</h4>
	
	
	     <p>
		     <form action="<?php echo $_SERVER['PHP_SELF'].'?idp='.$id; ?>" method="post">
			 
		         <span id="champ_cacheee"><a href="liste_donnee_execution.php?idp=<?php echo $id; ?>"><button style="margin-top: 20px;" class="btn btn-success" type="button" ><i class="icon icon-arrow-left icon-white"></i> Non</button></a></span>
		         &nbsp; &nbsp; &nbsp; &nbsp;
		         <span id="champ_cachee"><button style="margin-top: 20px;" class="btn btn-danger" name="oui" type="submit" ><i class="icon icon-remove icon-white"></i> Oui</button></a></span>
			     <input type="hidden" name="idp" value="<?php echo $id; ?>" />
				 <input type="hidden" name="idde" value="<?php echo $idde; ?>" />
				 
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