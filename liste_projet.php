<?php
    require_once 'header.php';
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
				unset($_SESSION['saved_projet']);
		    }
			
			
			if(isset($_SESSION['removed_projet'])) {
			    echo '<em><h3 style="color: #8AC007;">'.$_SESSION['removed_projet'].'</h3></em>';
				unset($_SESSION['removed_projet']);
		    }
			
			
			
			if(isset($_SESSION['edited_projet'])) {
			    echo '<em><h3 style="color: #8AC007;">'.$_SESSION['edited_projet'].'</h3></em>';
				unset($_SESSION['edited_projet']);
		    }
			
			
			
		?>
		
		<u style="color: blue;"><h4>Sélectionner un projet</h4></u>
		
    <table border="2 solid #ccc" class="tbliste table table-striped">
	
	    <tr>
	        <th style="color: white; background-color: #555555;">Id projet</th>
	        <th style="color: white; background-color: #555555;">Objet du projet</th>		
	        <th style="color: white; background-color: #555555;">Date du projet</th>
			<th style="color: white; background-color: #555555;">Taxe</th>		
	        <th style="color: white; background-color: #555555;">Taux</th>
			<th style="color: white; background-color: #555555;">Montant hors taxe</th>		
	        <th style="color: white; background-color: #555555;">Date/heure de saisie projet</th>
			<th style="color: white; background-color: #555555;">Ajouté par</th>
			<th style="color: white; background-color: #aaa;"><center>Action</center></th>
        </tr>
		
		<?php																																																	
                for($i; $i < count($projets); $i++) {
                
                   if($i == 0) {				
		?>
		
        <tr style="<?php if($style) echo $style; ?>">
	        <td><?php echo $projets[$i]['id_projet']; ?></td>
			
	        <td>
			     <?php if(isset($_SESSION['section']) && $_SESSION['section'] == 'Comptable') { ?>
				     <a href="c_inter.php?idp=<?php echo $projets[$i]['id_projet']; ?>"><?php echo $projets[$i]['objet_projet']; ?></a>
			     <?php } else { ?>
			         <a href="travaux.php?idp=<?php echo $projets[$i]['id_projet']; ?>"><?php echo $projets[$i]['objet_projet']; ?></a>
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
			<td>
			    <?php echo $projets[$i]['created_by']; ?>
			</td>
			<td>
			    
				
				
				<div class="btn-group">
                                        <a class="btn btn-info" href="#"><i class="icon- icon-white"></i> Projet</a>
                                        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                        <li><a href="edit_projet.php?idp=<?php echo $projets[$i]['id_projet']; ?>"><i class="icon-pencil"></i> Modifier</a></li>
                                        <?php if(IsSuperUser($_SESSION['login'])) { ?>
                                        <li><a href="remove_projet.php?idp=<?php echo $projets[$i]['id_projet']; ?>"><i class="icon-trash"></i> Supprimer</a></li>
                                        <?php } ?>                 

										<li class="divider"></li>
                                        <li><a href="logprojet.php?oid=<?php echo $projets[$i]['id_projet'].'&in='.$projets[$i]['objet_projet']; ?>"><i class=" icon-th"></i>  Historique</a></li>
										
										
									</ul>	
										
                </div>
				
				
				
		   </td>
        </tr>
		
		<?php 
		      } else {  ?>
			       <tr>
	        <td><?php echo $projets[$i]['id_projet']; ?></td>
			
	        <td>
			      
				  <?php if(isset($_SESSION['section']) && $_SESSION['section'] == 'Comptabilité') { ?>
				     <a href="c_inter.php?idp=<?php echo $projets[$i]['id_projet']; ?>"><?php echo $projets[$i]['objet_projet']; ?></a>
			     <?php } else { ?>
			         <a href="travaux.php?idp=<?php echo $projets[$i]['id_projet']; ?>"><?php echo $projets[$i]['objet_projet']; ?></a>
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
			<td>
			    <?php echo $projets[$i]['created_by']; ?>
			</td>
			<td>
			    
             <div class="btn-group">
                                        <a class="btn btn-info" href="#"><i class="icon- icon-white"></i> Projet</a>
                                          
										
                                        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                        <li><a href="edit_projet.php?idp=<?php echo $projets[$i]['id_projet']; ?>"><i class="icon-pencil"></i> Modifier</a></li>
                                        <?php if(IsSuperUser($_SESSION['login'])) { ?>
                                        <li><a href="remove_projet.php?idp=<?php echo $projets[$i]['id_projet']; ?>"><i class="icon-trash"></i> Supprimer</a></li>
                                        <?php } ?>                 

										<li class="divider"></li>
                                        <li><a href="logprojet.php?oid=<?php echo $projets[$i]['id_projet'].'&in='.$projets[$i]['objet_projet']; ?>"><i class=" icon-th"></i>  Historique</a></li>
										
										
									</ul>	
										
                               </div>

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
