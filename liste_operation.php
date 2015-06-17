<?php
    require_once 'header.php';
    require_once 'model.php';
    
	start_session();
    logout_protected();
	expired();
	
	
      if(isset($_GET['idp']) && !empty($_GET['idp']) && is_projet_exist(htmlspecialchars($_GET['idp'])) == true && is_projet_has_donnee_operation(htmlspecialchars($_GET['idp'])) == true) {
					    
						$id =  (int) trim(htmlspecialchars($_GET['idp']));
		
					    $projet = infos_projet($id);
						$projet_id = $projet['id_projet'];
						
                       $donnees = liste_donnees_operation($id);
                       $i = 0;
	
	                  $style = '';						
?>

       <center>
	    
        <?php
            
			
		    if(isset($_SESSION['saved_operation'])) {
			    echo '<em><h3 style="color: #8AC007;">'.$_SESSION['saved_operation'].'</h3></em>';
				$style = 'background-color: #8AC007;';
				unset($_SESSION['saved_operation']);
		    }
			
			
			if(isset($_SESSION['removed_operation'])) {
			    echo '<em><h3 style="color: #8AC007;">'.$_SESSION['removed_operation'].'</h3></em>';
				//$style = 'background-color: #8AC007;';
				unset($_SESSION['removed_operation']);
		    }
			
			
			if(isset($_SESSION['edited_operation'])) {
			    echo '<em><h3 style="color: #8AC007;">'.$_SESSION['edited_operation'].'</h3></em>';
				//$style = 'background-color: #8AC007;';
				unset($_SESSION['edited_operation']);
		    }
			
			
			
		?>
		
		<h4>Liste d'operation</h4><h4>Projet: <u style="color: blue;"><?php echo $projet['objet_projet']; ?></u></h4>
		
    <table border="2 solid #ccc" class="tbliste table table-striped">
	
	    <tr>
	        <th style="color: white; background-color: #555555;">Code operation</th>
	        <th style="color: white; background-color: #555555;">Libelé</th>		
	        <th style="color: white; background-color: #555555;">Montant</th>
			<th style="color: white; background-color: #555555;">Date</th>
			<th style="color: white; background-color: #555555;">Date saisie operation</th>
			<th style="color: white; background-color: #555555;">Ajouté par</th>
			<th style="color: white; background-color: #aaa;"><center>Action</center></th>
        </tr>
		
		<?php
                for($i; $i < count($donnees); $i++) {
                
                   if($i == 0) {				
		?>
		
        <tr style="<?php if($style) echo $style; ?>">
	        <td><?php echo $donnees[$i]['operation_id']; ?></td>
			<td><?php echo$donnees[$i]['operation_libele']; ?></td>
	        <td><?php echo number_format( $donnees[$i]['operation_montant'], 2, ".", " "); ?></td>		
	        <td><?php echo $donnees[$i]['operation_date']; ?></td>					
	        <td>
			            <?php 
			                 $date = date_create($donnees[$i]['operation_date_saisie']);
							 echo date_format($date, 'j F Y  H:i:s');
			                 //echo date_format($date, 'd/m/Y H:i:s'); 
					    ?>
			</td>
			
			<td>
			    <?php echo $donnees[$i]['operation_created_by']; ?>
			</td>
			
			
			<td>
			
				<div class="btn-group">
                                        <a class="btn btn-info" href="#"><i class="icon- icon-white"></i>opération</a>
                                          
										
                                        <a class="btn btn-info dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                        <li><a href="edit_operation.php?idp=<?php echo $id.'&iddo='.$donnees[$i]['operation_id']; ?>"><i class="icon-pencil"></i> Modifier</a></li>
                                        <?php if(IsSuperUser($_SESSION['login'])) { ?>
                                        <li><a href="remove_operation.php?idp=<?php echo $id.'&iddo='.$donnees[$i]['operation_id']; ?>"><i class="icon-trash"></i> Supprimer</a></li>
                                        <?php } ?>                 

										<li class="divider"></li>
                                        <li><a href="logoperation.php?oid=<?php echo $donnees[$i]['operation_id'].'&in='.$donnees[$i]['operation_libele']; ?>"><i class=" icon-th"></i>  Historique</a></li>
										
										
									</ul>	
										
                 </div>
				
				
			</td>
			
        </tr>
		
		<?php 
		      } else {  ?>
			       <tr>
	        <td><?php echo $donnees[$i]['operation_id']; ?></td>
			<td><?php echo$donnees[$i]['operation_libele']; ?></td>
	        <td><?php echo number_format( $donnees[$i]['operation_montant'], 2, ".", " "); ?></td>		
	        <td><?php echo $donnees[$i]['operation_date']; ?></td>			
	        <td>
			            <?php 
			                 $date = date_create($donnees[$i]['operation_date_saisie']);
			                 echo date_format($date, 'j F Y  H:i:s'); 
					    ?>
			</td>
			
			<td>
			    <?php echo $donnees[$i]['operation_created_by']; ?>
			</td>
			
			
			
			<td>
			    
				<div class="btn-group">
                                        <a class="btn btn-info" href="#"><i class="icon- icon-white"></i>Opération</a>
                                          
										
                                        <a class="btn btn-info dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                        <li><a href="edit_operation.php?idp=<?php echo $id.'&idde='.$donnees[$i]['operation_id']; ?>"><i class="icon-pencil"></i> Modifier</a></li>
                                        <?php if(IsSuperUser($_SESSION['login'])) { ?>
                                        <li><a href="remove_operation.php?idp=<?php echo $id.'&idde='.$donnees[$i]['operation_id']; ?>"><i class="icon-trash"></i> Supprimer</a></li>
                                        <?php } ?>                 

										<li class="divider"></li>
                                        <li><a href="logoperation.php?oid=<?php echo $donnees[$i]['operation_id'].'&in='.$donnees[$i]['operation_libele']; ?>"><i class=" icon-th"></i>  Historique</a></li>
										
										
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
			
			     echo '<center>Le projet<span style="color: #08c;"> '.$projet['objet_projet'].'</span> n\'a pas de données d\'opération!<br/><br/></center>';
				 echo '<center><a href="operations.php?idp='.$projet_id.'"><button style="margin-top: 20px;" class="btn btn-mini btn-primary" type="button">Ajouter des données d\'operation <i class="icon icon-arrow-right icon-white"></i>  </button></a></center>';
			} else {
			  echo '<center><h3 style="color: red;">Erreur: Aucun projet selectioné!</h3><br/></center>';
			}
        ?>

		<center>
		 <p>

		 <?php
                    if(isset($_GET['idp']) && !empty($_GET['idp']) && is_projet_exist(htmlspecialchars($_GET['idp'])) == true) {
					    
						$id =  (int) trim(htmlspecialchars($_GET['idp']));
		
					    $projet = infos_projet($id);
										
						
          ?>
		    
		  <a href="c_inter.php?idp=<?php echo $projet['id_projet']; ?>"><button style="margin-top: 20px;" class="btn btn-primary btn-mini" type="button"><i class="icon icon-arrow-left icon-white"></i>  Retour</button></a>
		  
		  <?php } ?>
		   
		   &nbsp; <a href="operations.php?idp=<?php echo $projet['id_projet']; ?>"><button style="margin-top: 20px;" class="btn btn-mini btn-primary" type="button">Nouvelle donnée d'operation</button></a>
		   
		   &nbsp; <a href="apercu_resultat.php"><button style="margin-top: 20px;" class="btn btn-mini btn-primary" type="button">Aperçu de resultat</button></a>
		   
		   &nbsp; <a href="liste_projet.php"><button style="margin-top: 20px;" class="btn btn-mini btn-primary" type="button">Liste des projets</button></a>
		     <a href="nouveau_projet.php"><button style="margin-top: 20px;" class="btn btn-mini btn-primary" type="button">Créer un nouveau projet</button></a>
		  &nbsp; <a href="index.php"><button style="margin-top: 20px;" class="btn btn-primary btn-mini" type="button">Accueil  <i class="icon icon-home icon-white"></i></button></a>
      </p>
	   </center>
	  

    </center>



<?php include 'footer.php'; ?>