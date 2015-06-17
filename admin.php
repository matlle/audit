<?php
    require_once 'header.php';
	require_once 'model.php';
	
	
	start_session();
    logout_protected();
	expired();
	
	$cid = getUserIdByName($_SESSION['login']);
	$cid = $cid['id_utilisateur'];
    super_AND_chef_protected($_SESSION['login'], $cid);

	
?>

    <center>
	
	          <h4 style="color: #08c;;">Administration</h4>
	
	
	     <p>
		    <span id="champ_cacheee"><a href="manage_user.php"><button style="margin-top: 20px;" class="btn btn-info btn-small" type="button" >Gérer les utilisateurs  <i class="icon icon-user icon-white"></i></button></a></span>
		     &nbsp; &nbsp; &nbsp; &nbsp;
			 <?php  if(isSuperUser($_SESSION['login'])) { ?>
		     <span id="champ_cachee"><a href="manage_group.php"><button style="margin-top: 20px;" class="btn btn-small btn-info" type="button" >Gérer les services <i class="icon icon-user icon-white"></i> <i class="icon icon-user icon-white"></i></button></a></span>
			 <?php } ?>
         </p>
	  
	             

				                    				   
		
		<p>
		    &nbsp; <a href="liste_projet.php"><button style="margin-top: 20px;" class="btn btn-mini btn-primary" type="button"><i class="icon icon-arrow-left icon-white"></i>  Retour</button></a>
			&nbsp; <a href="liste_projet.php"><button style="margin-top: 20px;" class="btn btn-mini btn-primary" type="button">Liste des projets</button></a>
		</p>

		
		
	  
	</center>


<?php include 'footer.php'; ?>
