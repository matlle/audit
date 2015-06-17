<?php
    include 'header.php';
    require_once 'model.php';
    
	
	start_session();
    logout_protected();
	expired();
	
	$projets = liste_projets();
    $i = 0;
	
	$style = '';
	
?>



    <center>
	    
        <?php
           
			
		    if(isset($_SESSION['saved_projet'])) {
			    echo '<em><h3 style="color: #8AC007;">'.$_SESSION['saved_projet'].'</h3></em>';
				$style = 'background-color: #8AC007;';
		    }
			
						
			
		?>
		<h3><u>Résultats d'exécution</u></h3>
		
		
		
        <?php if(isset($_SESSION['section']) && $_SESSION['section'] == 'Comptable') { ?>
				     <h4>Selectionner un projet ou <a href="choose_year.php"><u>Voir le recaputulatif des dépenses par année</u></a></h4>
	    <?php } else { ?>
			         <h4>Selectionner un projet ou <a href="choose_year.php"><u>Voir les resultas des projet par année</u></a></h4>
	    <?php } ?>
		
		
    <table border="2 solid #ccc" class="tbliste table table-striped">
	
	    <tr>
	        <th style="color: white; background-color: #555555;">Id projet</th>
	        <th style="color: white; background-color: #555555;">Objet du projet</th>		
	        <th style="color: white; background-color: #555555;">Date du projet</th>
			<th style="color: white; background-color: #555555;">Taxe</th>		
	        <th style="color: white; background-color: #555555;">Taux</th>
			<th style="color: white; background-color: #555555;">Montant hors taxe</th>		
	        <th style="color: white; background-color: #555555;">Date/heure de saisie projet </th>
        </tr>
		
		<?php																																																	
                for($i; $i < count($projets); $i++) {
                
                   if($i == 0) {				
		?>
		
        <tr style="<?php if($style) echo $style; ?>">
	        <td><?php echo $projets[$i]['id_projet']; ?></td>
	        <td>
			
				<?php if(isset($_SESSION['section']) && $_SESSION['section'] == 'Comptable') { ?>
				     <a href="c_resultats.php?idp=<?php echo $projets[$i]['id_projet']; ?>"><?php echo $projets[$i]['objet_projet']; ?></a>
			     <?php } else { ?>
			         <a href="type_resultat.php?idp=<?php echo $projets[$i]['id_projet']; ?>"><?php echo $projets[$i]['objet_projet']; ?></a>
			     <?php } ?>
				
			</td>
	        <td><?php echo $projets[$i]['date_projet']; ?></td>		
	        <td><?php echo $projets[$i]['taxe_projet']; ?></td>
			<td><?php echo $projets[$i]['taux']; ?></td>		
	        <td><?php echo number_format($projets[$i]['montant_ht_projet'], 2, ".", " "); ?></td>		
	        <td>
			
			            <?php 
			                 $date = date_create($projets[$i]['date_saisie_projet']);
							 echo date_format($date, 'j F Y  H:i:s');
			                 //echo date_format($date, 'd/m/Y H:i:s'); 
					    ?>
			</td>
        </tr>
		
		<?php 
		      } else {  ?>
			       <tr>
	        <td><?php echo $projets[$i]['id_projet']; ?></td>
						
	        <td>
			    
				<?php if(isset($_SESSION['section']) && $_SESSION['section'] == 'Comptable') { ?>
				     <a href="c_resultats.php?idp=<?php echo $projets[$i]['id_projet']; ?>"><?php echo $projets[$i]['objet_projet']; ?></a>
			     <?php } else { ?>
			         <a href="type_resultat.php?idp=<?php echo $projets[$i]['id_projet']; ?>"><?php echo $projets[$i]['objet_projet']; ?></a>
			     <?php } ?>
				
			</td>
			
	        <td><?php echo $projets[$i]['date_projet']; ?></td>		
	        <td><?php echo $projets[$i]['taxe_projet']; ?></td>
			<td><?php echo $projets[$i]['taux']; ?></td>		
	        <td><?php echo number_format($projets[$i]['montant_ht_projet'], 2, ".", " "); ?></td>		
	        <td>
			            <?php 
			                 $date = date_create($projets[$i]['date_saisie_projet']);
			                 echo date_format($date, 'j F Y  H:i:s'); 
					    ?>
			</td>
        </tr>
		
       <?php }  ?>
		
		<?php } ?>
       
		 
</table>

	
	

	  <p>
		  <a href="index.php"><button style="margin-top: 20px;" class="btn btn-primary btn-mini" type="button">Accueil  <i class="icon icon-home icon-white"></i></button></a>
		  <a href="nouveau_projet.php"><button style="margin-top: 20px;" class="btn btn-mini btn-primary" type="button">Créer un nouveau projet</button></a>
		  
      </p>

    </center>



<?php include 'footer.php'; ?>