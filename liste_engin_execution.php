<?php
    require_once 'header.php';
    require_once 'model.php';
	
	start_session();
    logout_protected();
	expired();
    
	
                    if(isset($_GET['idp']) && !empty($_GET['idp']) && is_projet_exist(htmlspecialchars($_GET['idp'])) == true  &&  is_projet_has_donnee_execution(htmlspecialchars($_GET['idp'])) == true && isset($_GET['idde']) && !empty($_GET['idde'])) {
					    
						$idp =  (int) trim(htmlspecialchars($_GET['idp']));
						$idde =  (int) trim(htmlspecialchars($_GET['idde']));
		
					    $projet = infos_projet($idp);
						$execution = infos_execution($idde);
						
						$projet_id = $projet['id_projet'];
					    $donnees_engin = liste_donnees_engin_execution($idde); 
                        $i = 0;
	
	                  $style = '';						
?>


        <center>
	    
        <?php
            
		    if(isset($_SESSION['saved_engin_execution'])) {
			    echo '<em><h3 style="color: #8AC007;">'.$_SESSION['saved_engin_execution'].'</h3></em>';
				$style = 'background-color: #8AC007;';
				unset($_SESSION['saved_engin_execution']);
		    }
			
			
			
			if(isset($_SESSION['removed_engin_execution'])) {
			    echo '<em><h3 style="color: #8AC007;">'.$_SESSION['removed_engin_execution'].'</h3></em>';
				//$style = 'background-color: #8AC007;';
				unset($_SESSION['removed_engin_execution']);
		    }
			
			
			if(isset($_SESSION['edited_engin_execution'])) {
			    echo '<em><h3 style="color: #8AC007;">'.$_SESSION['edited_engin_execution'].'</h3></em>';
				//$style = 'background-color: #8AC007;';
				unset($_SESSION['edited_engin_execution']);
		    }
			
			
			
			
		?>
		
		<h4>Projet: <u style="color: blue;"><?php echo $projet['objet_projet']; ?></h4></u>
		
		<h4>Engin - Liste des données d'execution de: <span style="color: blue;"><?php echo $execution['nature_travaux_execution']; ?></span>
		
    <table border="2 solid #ccc" class="tbliste table table-striped">
	
	    <tr>
	        <th style="color: white; background-color: #555555;">Id  engin</th>
	        <th style="color: white; background-color: #555555;">Code</th>		
	        <th style="color: white; background-color: #555555;">Nom</th>
			<th style="color: white; background-color: #555555;">Puissance</th>		
	        <th style="color: white; background-color: #555555;">Marque</th>
		    <th style="color: white; background-color: #555555;">Jour</th>
	        <th style="color: white; background-color: #555555;">Location</th>		
	        <th style="color: white; background-color: #555555;">Carburant</th>
			<th style="color: white; background-color: #555555;">Prix carburant</th>		
	        <th style="color: white; background-color: #555555;">Lubrifiant</th>
			<th style="color: white; background-color: #555555;">Prix lubrifiant</th>
			<!-- <th style="color: white; background-color: #555555;">Id execution</th> -->
			<th style="color: white; background-color: #555555;">Date saisie engin</th>
			<th style="color: white; background-color: #555555;">Ajouté par</th>
			<th style="color: white; background-color: #aaa;"><center>Action</center></th>
        </tr>
		
		<?php
                for($i; $i < count($donnees_engin); $i++) {
                
                   if($i == 0) {				
		?>
		
        <tr style="<?php if($style) echo $style; ?>">
	        <td><?php echo $donnees_engin[$i]['id_engin_execution']; ?></td>
            <td><?php echo$donnees_engin[$i]['code_engin_execution']; ?></td>
	        <td><?php echo $donnees_engin[$i]['nom_engin_execution']; ?></td>
            <td><?php echo $donnees_engin[$i]['puissance_engin_execution']; ?></td>			
	        <td><?php echo $donnees_engin[$i]['marque_engin_execution']; ?></td>
			<td><?php echo $donnees_engin[$i]['nombre_jour_engin_execution']; ?></td>
	        <td><?php echo $donnees_engin[$i]['location_par_jour_engin_execution']; ?></td>
            <td><?php echo $donnees_engin[$i]['consommation_carburant_par_jour_engin_execution']; ?></td>			
	        <td><?php echo $donnees_engin[$i]['prix_carburant_engin_execution']; ?></td>
			<td><?php echo $donnees_engin[$i]['consommation_lubrifiant_par_jour_engin_execution']; ?></td>
            <td><?php echo $donnees_engin[$i]['prix_lubrifiant_engin_execution']; ?></td>			
            <!-- <td><?php //echo $donnees_engin[$i]['id_execution']; ?></td> -->				
	        <td>
			            <?php 
			                 $date = date_create($donnees_engin[$i]['date_saisie_engin_execution']);
							 echo date_format($date, 'j F Y  H:i:s');
			                 //echo date_format($date, 'd/m/Y H:i:s'); 
					    ?>
			</td>
			
			<td>
			    <?php echo $donnees_engin[$i]['created_by']; ?>
			</td>
			
		    <td>
			  
				<div class="btn-group">
                                        <a class="btn btn-info" href="#"><i class="icon- icon-white"></i>Engin execution</a>
                                          
										
                                        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                        <li><a href="edit_engin_execution.php?idde=<?php echo $idde.'&idp='.$idp.'&ideng='.$donnees_engin[$i]['id_engin_execution']; ?>"><i class="icon-pencil"></i> Modifier</a></li>
                                        <?php if(IsSuperUser($_SESSION['login'])) { ?>
                                        <li><a href="remove_engin_execution.php?idde=<?php echo $idde.'&idp='.$idp.'&ideng='.$donnees_engin[$i]['id_engin_execution']; ?>"><i class="icon-trash"></i> Supprimer</a></li>
                                        <?php } ?>                 

										<li class="divider"></li>
                                        <li><a href="logenginexecution.php?oid=<?php echo $donnees_engin[$i]['id_engin_execution'].'&in='.$donnees_engin[$i]['nom_engin_execution']; ?>"><i class=" icon-th"></i>  Historique</a></li>
										
										
									</ul>	
										
                </div>
				
				
				
			</td>
			
        </tr>
		
		<?php 
		      } else {  ?>
			       <tr>
	        <td><?php echo $donnees_engin[$i]['id_engin_execution']; ?></td>
            <td><?php echo$donnees_engin[$i]['code_engin_execution']; ?></td>
	        <td><?php echo $donnees_engin[$i]['nom_engin_execution']; ?></td>
            <td><?php echo $donnees_engin[$i]['puissance_engin_execution']; ?></td>			
	        <td><?php echo $donnees_engin[$i]['marque_engin_execution']; ?></td>
			<td><?php echo $donnees_engin[$i]['nombre_jour_engin_execution']; ?></td>
	        <td><?php echo $donnees_engin[$i]['location_par_jour_engin_execution']; ?></td>
            <td><?php echo $donnees_engin[$i]['consommation_carburant_par_jour_engin_execution']; ?></td>			
	        <td><?php echo $donnees_engin[$i]['prix_carburant_engin_execution']; ?></td>
			<td><?php echo $donnees_engin[$i]['consommation_lubrifiant_par_jour_engin_execution']; ?></td>
            <td><?php echo $donnees_engin[$i]['prix_lubrifiant_engin_execution']; ?></td>			
            <!-- <td><?php //echo $donnees_engin[$i]['id_execution']; ?></td> -->
	        <td>
			            <?php 
			                 $date = date_create($donnees_engin[$i]['date_saisie_engin_execution']);
			                 echo date_format($date, 'j F Y  H:i:s'); 
					    ?>
			</td>
			
			
			<td>
			    <?php echo $donnees_engin[$i]['created_by']; ?>
			</td>
			
			
			<td>
			
				<div class="btn-group">
                                        <a class="btn btn-info" href="#"><i class="icon- icon-white"></i>Engin execution</a>
                                          
										
                                        <a class="btn  dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                        <li><a href="edit_engin_execution.php?idde=<?php echo $idde.'&idp='.$idp.'&ideng='.$donnees_engin[$i]['id_engin_execution']; ?>"><i class="icon-pencil"></i> Modifier</a></li>
                                        <?php if(IsSuperUser($_SESSION['login'])) { ?>
                                        <li><a href="remove_engin_execution.php?idde=<?php echo $idde.'&idp='.$idp.'&ideng='.$donnees_engin[$i]['id_engin_execution']; ?>"><i class="icon-trash"></i> Supprimer</a></li>
                                        <?php } ?>                 

										<li class="divider"></li>
                                        <li><a href="logenginexecution.php?oid=<?php echo $donnees_engin[$i]['id_engin_execution'].'&in='.$donnees_engin[$i]['nom_engin_execution']; ?>"><i class=" icon-th"></i>  Historique</a></li>
										
										
									</ul>	
										
                </div>
				
				
				
			</td>
			
        </tr>
		
       <?php }  ?>
		
		<?php } ?>
       
		 
</table>

	
	

	 
		
	  
	  
	   <?php 
	        } else if (isset($_GET['idp']) && !empty($_GET['idp']) && is_projet_exist(htmlspecialchars($_GET['idp'])) == true) {
			     
				        $id =  (int) trim(htmlspecialchars($_GET['idp']));
		
					    $projet = infos_projet($id);
						$projet_id = $projet['id_projet'];
			
			     echo '<span style="color: #08c;">Le projet '.$projet['objet_projet'].'</span> n\'a pas de données previsionnelles!<br/><br/>';
				 echo '<a href="donnee_previ.php?idp='.$projet_id.'"><button style="margin-top: 20px;" class="btn btn-mini btn-primary" type="button"><i class="icon icon-arrow-left icon-white"></i>  Ajouter des données de prevision</button></a>';
			} else {
			  echo '<h3 style="color: red;">Erreur: Aucun projet selectioné!</h3><br/>';
			}
        ?>

		 
		 <p>

		 <?php
                    if(isset($_GET['idp']) && !empty($_GET['idp']) && is_projet_exist(htmlspecialchars($_GET['idp'])) == true) {
					    
						$id =  (int) trim(htmlspecialchars($_GET['idp']));
		
					    $projet = infos_projet($id);
										
						
          ?>
		    
		  <a href="travaux.php?idp=<?php echo $projet['id_projet']; ?>"><button style="margin-top: 20px;" class="btn btn-primary btn-mini" type="button"><i class="icon icon-arrow-left icon-white"></i>  Retour</button></a>
		  
		  <?php } ?>
		  
		  
		  
		   &nbsp; <a href="liste_projet.php"><button style="margin-top: 20px;" class="btn btn-mini btn-primary" type="button">Liste des projets</button></a>
		     &nbsp; <a href="nouveau_projet.php"><button style="margin-top: 20px;" class="btn btn-mini btn-primary" type="button">Créer un nouveau projet</button></a>
		  &nbsp; <a href="index.php"><button style="margin-top: 20px;" class="btn btn-primary btn-mini" type="button">Accueil  <i class="icon icon-home icon-white"></i></button></a>
      </p>
	  
	  

    </center>



<?php include 'footer.php'; ?>
