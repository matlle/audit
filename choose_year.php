<?php 
      require_once 'header.php';
	  require_once 'model.php';
	  
	  start_session();
      logout_protected();
	  expired();
	  
	  $i = 0;
	  $j = 0;
	  $ta = array();
	  $y = array();
	  $dates = getProsDate();
	
	 
	
	  for($i; $i < count($dates); $i++) {
	      $ta = $dates[$i][0];
		  $dt = new DateTime($ta);
		  $y[] = $dt->format('Y');
	  }
	  
	  if(isset($_POST['bvoir'])) {
	      $ye =  htmlspecialchars($_POST['year']);
		  if(isset($_SESSION['section']) && $_SESSION['section'] == 'Comptable')
		      header('location: choose_pro_on_year.php?y='.$ye);
		  else
		      header('location: res_pros_by_year.php?y='.$ye);
	  }
	  
	  
?>

<center>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      <p>
		    <span>
			     <h4 style="color: #0188c9;"><u>Choisissez une année</u></h4>
			         <select name="year">
				             <?php
					                $n = 0;
								    $u = array_unique($y);
                                        foreach($u as $ind)
                                             echo '<option>'.$ind.'</option>';										
					         ?> 
			         </select>
					 
			 </span>
      </p>
	    <a href="apercu_resultat.php"><button style="margin-top: 10px; margin-bottom: 10px;" class="btn btn-mini btn-primary" type="button"><i class="icon icon-arrow-left icon-white"></i>  Retour</button></a>
	    &nbsp; <button name="bvoir" style="margin-top: 10px; margin-bottom: 10px;" class="btn btn-mini btn-primary">Voir  <i class="icon icon-arrow-right icon-white"></i></button>
	</form>
</center>

<?php include 'footer.php'; ?>
