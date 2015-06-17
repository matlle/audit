<?php
    require_once 'header.php';
	require_once 'model.php';

	start_session();
    logout_protected();
	expired();
	
	
?>

    <center>
	
	
	<?php
	
	    if(isset($_POST['oui']) && isset($_POST['iddp']) && !empty($_POST['iddp'])  && isset($_POST['idp']) && !empty($_POST['idp'])  && isset($_POST['idperso']) && !empty($_POST['idperso'])) {
		    
			$iddp = (int)  htmlspecialchars($_POST['iddp']);
			$idp = (int)  htmlspecialchars($_POST['idp']);
			$idperso = (int)  htmlspecialchars($_POST['idperso']);
			
			removePersonnellePrevision($iddp, $idperso);
			
			 $_SESSION['removed_person_prevision'] = 'Personnelle supprimée!';
			
			header('location: liste_personnelle_prevision.php?iddp='.$iddp.'&idp='.$idp);
			
		}
	
	?>
	
	
	

	     <?php
                    if(isset($_GET['idp']) && !empty($_GET['idp']) && isset($_GET['idperso']) && !empty($_GET['idperso']) && isset($_GET['iddp']) && !empty($_GET['iddp']) && is_projet_exist(htmlspecialchars($_GET['idp'])) == true) {
					    
						$idp =  (int) trim(htmlspecialchars($_GET['idp']));
		                $iddp =  (int) trim(htmlspecialchars($_GET['iddp']));
						$idperso =  (int) trim(htmlspecialchars($_GET['idperso']));
						
					    $projet = infos_projet($idp);
						$personnel = infos_personnelle_prevision($idperso);
										
						
          ?>
	
	          <h4>Voulez vous vraiment supprimer le personnel <?php echo '<span style="color: #08c;;">'.$personnel['matricule_personnel_previsionnelle'].'</span>'; ?> de prevision?</h4>
	
	
	     <p>
		     <form action="<?php echo $_SERVER['PHP_SELF'].'?iddp='.$iddp.'&idp='.$idp.'&idperso='.$idperso; ?>" method="post">
			 
		         <span id="champ_cacheee"><a href="liste_personnelle_prevision.php?idp=<?php echo $idp.'&iddp='.$iddp; ?>"><button style="margin-top: 20px;" class="btn btn-success" type="button" ><i class="icon icon-arrow-left icon-white"></i> Non</button></a></span>
		         &nbsp; &nbsp; &nbsp; &nbsp;
		         <span id="champ_cachee"><button style="margin-top: 20px;" class="btn btn-danger" name="oui" type="submit" ><i class="icon icon-remove icon-white"></i> Oui</button></a></span>
			     <input type="hidden" name="idp" value="<?php echo $idp; ?>" />
				 <input type="hidden" name="iddp" value="<?php echo $iddp; ?>" />
				  <input type="hidden" name="idperso" value="<?php echo $idperso; ?>" />
				 
			 </form>
         </p>
	  
	             

				 

        			
	  <?php 
	        } else {
			  echo '<h3 style="color: red;">Erreur: Aucun projet et/ou personnelle selectioné!</h3><br/>';
			}
        ?>
		
                   				   
		
		<p>
		    &nbsp; <a href="liste_projet.php"><button style="margin-top: 20px;" class="btn btn-mini btn-primary" type="button"><i class="icon icon-arrow-left icon-white"></i>  Liste des projets</button></a>
		</p>

		
		
	  
	</center>


<?php include 'footer.php'; ?>