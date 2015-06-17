<?php 
      require_once 'header.php';
	  require_once 'model.php';
	  
	  start_session();
	  logout_protected();
	  expired();
       
	  $cu = getUserIdByName($_SESSION['login']);
	 $idcu = $cu['id_utilisateur'];
	 
	 if(isset($_SESSION['new_password'])) {
			    echo '<center><em><h3 style="color: #8AC007;">'.$_SESSION['new_password'].'</h3></em></center>';
				$style = 'background-color: #8AC007;';
				unset($_SESSION['new_password']);
    }
	
	 
	   
?>

<center>


    <div class="" style="background-color:#6DCCF4; width: 600px; margin-left: 100px; margin-top: 20px; border: 1px solid black;">
	    <?php if(!IsUserIsDg($idcu)) { ?>
        <a href="nouveau_projet.php"><h3><button type="submit" class="btn input-xlarge"><i class="icon-folder-open"></i> NOUVEAU PROJET</button></h3></a><br/><br/>
			 
			 <?php if(isset($_SESSION['section']) && $_SESSION['section'] == 'Comptable') { ?>
				      <a href="ops.php"><h3><button type="submit" class="btn input-xlarge"><i class="icon-tasks"></i> OPERATIONS SUR PROJET</button></h3></a><br/><br/>
			 <?php } else { ?>
			          <a href="liste_projet.php"><h3><button type="submit" class="btn input-xlarge"><i class="icon-tasks"></i> OPERATIONS SUR PROJET</button></h3></a><br/><br/>
			 <?php } ?>
		
		     
		
		
		
        <a href="apercu_resultat.php"><h3><button type="submit" class="btn input-xlarge"><i class="icon-eye-open"></i> APERCU DE RESULTAT</button></h3></a>
		<?php } else { ?>
		<a href="apercu_resultat.php"><h3><button type="submit" class="btn input-xlarge"><i class="icon-eye-open"></i> APERCU DE RESULTAT</button></h3></a>
		<?php } ?>
    </div>
	
	<p style="margin-top: 10px; margin-bottom: 50px;">
	</p>
	
</center>

<?php include 'footer.php'; ?>
