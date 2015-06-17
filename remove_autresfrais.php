<?php
    require_once 'header.php';
	require_once 'model.php';

	start_session();
    logout_protected();
	expired();
	
	
?>

    <center>
	
	
	<?php
	
	    if(isset($_POST['oui']) && isset($_POST['iddp']) && !empty($_POST['iddp'])  && isset($_POST['idp']) && !empty($_POST['idp'])  && isset($_POST['idfrais']) && !empty($_POST['idfrais'])) {
		    
			$iddp = (int)  htmlspecialchars($_POST['iddp']);
			$idp = (int)  htmlspecialchars($_POST['idp']);
			$idfrais = (int)  htmlspecialchars($_POST['idfrais']);
			
			removeAufraisPrevision($iddp, $idfrais);
			
			 $_SESSION['removed_autresfrais_prevision'] = 'Autres frais supprimée!';
			
			header('location: liste_autresfrais_prevision.php?iddp='.$iddp.'&idp='.$idp);
			
		}
	
	?>
	
	
	

	     <?php
                    if(isset($_GET['idp']) && !empty($_GET['idp']) && isset($_GET['idfrais']) && !empty($_GET['idfrais']) && isset($_GET['iddp']) && !empty($_GET['iddp']) && is_projet_exist(htmlspecialchars($_GET['idp'])) == true) {
					    
						$idp =  (int) trim(htmlspecialchars($_GET['idp']));
		                $iddp =  (int) trim(htmlspecialchars($_GET['iddp']));
						$idfrais =  (int) trim(htmlspecialchars($_GET['idfrais']));
						
					    $projet = infos_projet($idp);
						$frais = infos_frais_prevision($idfrais);
										
						
          ?>
	
	          <h4>Voulez vous vraiment supprimer les frais <?php echo '<span style="color: #08c;;">'.$frais['objet_autresfrais_previsionnel'].'</span>'; ?> de prevision?</h4>
	
	
	     <p>
		     <form action="<?php echo $_SERVER['PHP_SELF'].'?iddp='.$iddp.'&idp='.$idp.'&idfrais='.$idfrais; ?>" method="post">
			 
		         <span id="champ_cacheee"><a href="liste_autresfrais_prevision.php?idp=<?php echo $idp.'&iddp='.$iddp; ?>"><button style="margin-top: 20px;" class="btn btn-success" type="button" ><i class="icon icon-arrow-left icon-white"></i> Non</button></a></span>
		         &nbsp; &nbsp; &nbsp; &nbsp;
		         <span id="champ_cachee"><button style="margin-top: 20px;" class="btn btn-danger" name="oui" type="submit" ><i class="icon icon-remove icon-white"></i> Oui</button></a></span>
			     <input type="hidden" name="idp" value="<?php echo $idp; ?>" />
				 <input type="hidden" name="iddp" value="<?php echo $iddp; ?>" />
				  <input type="hidden" name="idfrais" value="<?php echo $idfrais; ?>" />
				 
			 </form>
         </p>
	  
	             

				 

        			
	  <?php 
	        } else {
			  echo '<h3 style="color: red;">Erreur: Aucun projet et/ou frais selectioné!</h3><br/>';
			}
        ?>
		
                   				   
		
		<p>
		    &nbsp; <a href="liste_projet.php"><button style="margin-top: 20px;" class="btn btn-mini btn-primary" type="button"><i class="icon icon-arrow-left icon-white"></i>  Liste des projets</button></a>
		</p>

		
		
	  
	</center>


<?php include 'footer.php'; ?>