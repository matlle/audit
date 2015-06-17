<?php 
      require_once 'header.php';
	  require_once 'model.php';
	  
	  start_session();
      logout_protected();
	  expired();
	  
	  
	  if(isset($_GET['y']) && !empty($_GET['y'])) {
	     
		 $year = (int) htmlspecialchars($_GET['y']);
		 $projets = array();
		 $pro = listProByYear($year);
		 
		 foreach($pro as $p) {
		      if(is_projet_has_donnee_operation($p['id_projet']) === true)
			      $projets[] = $p;
		}
		 
	  
  }
	  
	  	  
	  
?>

<center>

      <?php
               if(isset($_POST['bvoir'])) {
	               $pn =  htmlspecialchars($_POST['pn']);
				   $year = htmlspecialchars($_POST['y']);
		               if(isset($_SESSION['section']) && $_SESSION['section'] == 'Comptable')
		                   header('location: recap.php?pn='.$pn.'&y='.$year);
	          }
	  
	  ?>

      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      <p>
		    <span>	 
					 <h4 style="color: #0188c9;"><u>Choisissez un projet</u></h4>
			         <select name="pn" class="input input-xxlarge">
				             <?php
                                        foreach($projets as $pi)
                                             echo '<option>'.$pi['objet_projet'].'</option>';										
					         ?> 
			         </select>
					 <input type="hidden" name="y" value="<?php echo $year; ?>">
			 </span>
      </p>
	  	  
	  
	    <a href="choose_year.php"><button style="margin-top: 10px; margin-bottom: 10px;" class="btn btn-mini btn-primary" type="button"><i class="icon icon-arrow-left icon-white"></i>  Retour</button></a>
	    &nbsp; <button name="bvoir" style="margin-top: 10px; margin-bottom: 10px;" class="btn btn-mini btn-primary">Voir  <i class="icon icon-arrow-right icon-white"></i></button>
	</form>
	
	  
	
	
</center>

<?php include 'footer.php'; ?>
