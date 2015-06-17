<?php
    require_once 'header.php';
	require_once 'model.php';

	start_session();
    logout_protected();
	expired();
	
?>

    <center>

	     <?php
                    if(isset($_GET['idp']) && !empty($_GET['idp']) && is_projet_exist(htmlspecialchars($_GET['idp'])) == true) {
					    
						$id =  (int) trim(htmlspecialchars($_GET['idp']));
		
					    $projet = infos_projet($id);
										
						
          ?>
	
	          <h4>Projet: <?php echo '<span style="color: #08c;;">'.$projet['objet_projet'].'</span>'; ?></h4>
	

	
	     <p>
		    <span id="champ_cacheee"><a href="liste_operation.php?idp=<?php echo $projet['id_projet']; ?>"><button style="margin-top: 20px;" class="btn btn-info btn-small" type="button" >Voir les données d'operations  <i class="icon-eye-open"></i></button></a></span>
		     &nbsp; &nbsp; &nbsp; &nbsp;
		     <span id="champ_cachee"><a href="operations.php?idp=<?php echo $projet['id_projet']; ?>"><button style="margin-top: 20px;" class="btn btn-small btn-info" type="button" >Nouvelle donnée d'operation  <i class="icon icon-pencil"></i></button></a></span>
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