
<?php
    require_once 'header.php';
    require_once 'model.php';
    
	start_session();
    logout_protected();
	expired();
	
                    if(isset($_GET['idp']) && !empty($_GET['idp']) && is_projet_exist(htmlspecialchars($_GET['idp'])) == true  &&  is_projet_has_donnee_prevision(htmlspecialchars($_GET['idp'])) == true) {
					    
						$id =  (int) trim(htmlspecialchars($_GET['idp']));
		
					    $projet = infos_projet($id);
						$projet_id = $projet['id_projet'];
						
                       $donnees = liste_donnees_prevision($projet_id);
                       $i = 0;
	
	                  $style = '';						
?>



        <center>
	    
        <?php
            
			
		    if(isset($_SESSION['saved_prevision'])) {
			    echo '<em><h3 style="color: #8AC007;">'.$_SESSION['saved_prevision'].'</h3></em>';
				$style = 'background-color: #8AC007;';
				unset($_SESSION['saved_prevision']);
		    }
			
			
			if(isset($_SESSION['removed_prevision'])) {
			    echo '<em><h3 style="color: #8AC007;">'.$_SESSION['removed_prevision'].'</h3></em>';
				//$style = 'background-color: #8AC007;';
				unset($_SESSION['removed_prevision']);
		    }
			
			
			if(isset($_SESSION['edited_prevision'])) {
			    echo '<em><h3 style="color: #8AC007;">'.$_SESSION['edited_prevision'].'</h3></em>';
				//$style = 'background-color: #8AC007;';
				unset($_SESSION['edited_prevision']);
		    }
			
			
			
		?>
		
		<h4>Liste des données de prevision</h4><u style="color: blue;"><h4><?php echo $projet['objet_projet']; ?></h4></u>
		
    <table border="2 solid #ccc" class="tbliste table table-striped">
	
	    <tr>
	        <th style="color: white; background-color: #555555;">Id prevision</th>
	        <th style="color: white; background-color: #555555;">Nature travaux previsionnelle</th>		
	        <th style="color: white; background-color: #555555;">Unité</th>
			<th style="color: white; background-color: #555555;">Quantité</th>		
	        <th style="color: white; background-color: #555555;">Durée</th>
			<th style="color: white; background-color: #555555;">Id Projet</th>
			<th style="color: white; background-color: #555555;">Date saisie previsionnelle</th>
			<th style="color: white; background-color: #555555;">Ajouté par</th>
			<th style="color: white; background-color: #aaa;"><center>Action</center></th>
        </tr>
		
		<?php
                for($i; $i < count($donnees); $i++) {
                
                   if($i == 0) {				
		?>
		
        <tr style="<?php if($style) echo $style; ?>">
	        <td><?php echo $donnees[$i]['id_previsionnelle']; ?></td>
			
<td><a href="info_travauxp.php?idp=<?php echo $donnees[$i]['id_projet'].'&iddp='.$donnees[$i]['id_previsionnelle']; ?>"><?php echo$donnees[$i]['nature_travaux_previsionnelle']; ?></a></td>



			
	        <td><?php echo $donnees[$i]['unite_previsionnelle']; ?></td>
            <td><?php echo $donnees[$i]['quantite_previsionnelle']; ?></td>			
	        <td><?php echo $donnees[$i]['duree_previsionnelle']; ?></td>
            <td><?php echo $donnees[$i]['id_projet']; ?></td>					
	        <td>
			            <?php 
			                 $date = date_create($donnees[$i]['date_saisie_previsionnelle']);
							 echo date_format($date, 'j F Y  H:i:s');
			                 //echo date_format($date, 'd/m/Y H:i:s'); 
					    ?>
			</td>
			
			<td>
			    <?php echo $donnees[$i]['created_by']; ?>
			</td>
			
			<td>
			    
				<div class="btn-group">
                                        <a class="btn btn-info" href="#"><i class="icon- icon-white"></i> Donnée prevision</a>
                                          
										
                                        <a class="btn btn-info dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                        <li><a href="edit_prevision.php?idp=<?php echo $id.'&iddp='.$donnees[$i]['id_previsionnelle']; ?>"><i class="icon-pencil"></i> Modifier</a></li>
                                        <?php if(IsSuperUser($_SESSION['login'])) { ?>
                                        <li><a href="remove_prevision.php?idp=<?php echo $id.'&iddp='.$donnees[$i]['id_previsionnelle']; ?>"><i class="icon-trash"></i> Supprimer</a></li>
                                        <?php } ?>                 

										<li class="divider"></li>
                                        <li><a href="logprevisionnelle.php?oid=<?php echo $donnees[$i]['id_previsionnelle'].'&in='.$donnees[$i]['nature_travaux_previsionnelle']; ?>"><i class=" icon-th"></i>  Historique</a></li>
										
										
									</ul>	
										
                 </div>
				
				
				
			</td>
			
        </tr>
		
		<?php 
		      } else {  ?>
			       <tr>
	        <td><?php echo $donnees[$i]['id_previsionnelle']; ?></td>
	      	        	        <td><a href="info_travauxp.php?idp=<?php echo $donnees[$i]['id_projet'].'&iddp='.$donnees[$i]['id_previsionnelle']; ?>"><?php echo $donnees[$i]['nature_travaux_previsionnelle']; ?></a></td>
	        <td><?php echo $donnees[$i]['unite_previsionnelle']; ?></td>
            <td><?php echo $donnees[$i]['quantite_previsionnelle']; ?></td>			
	        <td><?php echo $donnees[$i]['duree_previsionnelle']; ?></td>
            <td><?php echo $donnees[$i]['id_projet']; ?></td>			
	        <td>
			            <?php 
			                 $date = date_create($donnees[$i]['date_saisie_previsionnelle']);
			                 echo date_format($date, 'j F Y  H:i:s'); 
					    ?>
			</td>
			
			
			<td>
			    <?php echo $donnees[$i]['created_by']; ?>
			</td>
			
			
			<td>
		
				<div class="btn-group">
                                        <a class="btn btn-info" href="#"><i class="icon- icon-white"></i> Donnée prevision</a>
                                          
										
                                        <a class="btn btn-info dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                        <li><a href="edit_prevision.php?idp=<?php echo $id.'&iddp='.$donnees[$i]['id_previsionnelle']; ?>"><i class="icon-pencil"></i> Modifier</a></li>
                                        <?php if(IsSuperUser($_SESSION['login'])) { ?>
                                        <li><a href="remove_prevision.php?idp=<?php echo $id.'&iddp='.$donnees[$i]['id_previsionnelle']; ?>"><i class="icon-trash"></i> Supprimer</a></li>
                                        <?php } ?>                 

										<li class="divider"></li>
                                        <li><a href="logprevisionnelle.php?oid=<?php echo $donnees[$i]['id_previsionnelle'].'&in='.$donnees[$i]['nature_travaux_previsionnelle']; ?>"><i class=" icon-th"></i>  Historique</a></li>
										
										
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
		     <a href="nouveau_projet.php"><button style="margin-top: 20px;" class="btn btn-mini btn-primary" type="button">Créer un nouveau projet</button></a>
		  &nbsp; <a href="index.php"><button style="margin-top: 20px;" class="btn btn-primary btn-mini" type="button">Accueil  <i class="icon icon-home icon-white"></i></button></a>
      </p>
	  
	  

    </center>



<?php include 'footer.php'; ?>