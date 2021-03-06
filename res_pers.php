<center>
<?php
    require_once 'header.php';
    require_once 'model.php';
    
	start_session();
    logout_protected();
	expired();
	
	
	$i = 0;
	$j = 0;
	
	
	    if(isset($_GET['idp']) && !empty($_GET['idp']) && is_projet_exist(htmlspecialchars($_GET['idp'])) == true  &&  is_projet_has_donnee_execution(htmlspecialchars($_GET['idp']))) {
					    
						$idp =  (int) trim(htmlspecialchars($_GET['idp']));
						
	                   $projets = infos_projet($idp);
	                   $exe_res = liste_donnees_execution($idp);
                      
					   
	
?>



    
	
		<h3><u>Résulats d'exécution</u></h3>
		
		<h2 style="background-color: #b5ecb5;; width: 40%;">Detail du personnel</h2>
		
		<div>
		    
			 <table border="2 solid #ccc" width="40%;" style="background-color: #F5F5F5;">
			 
			     <tr>
				     <td><strong>Objet du Projet</strong></td>
					 <td><strong><?php echo $projets['objet_projet']; ?></strong></td>
				 </tr>
				 <tr>
				     <td><strong>Date</strong></td>
					 <td><strong><?php echo date_format(date_create($projets['date_projet']), 'd/m/Y'); ?></strong></td>
				 </tr>
				 <tr>
				     <td><strong>Montant HT</strong></td>
					 <td><strong><?php echo number_format($projets['montant_ht_projet'], 2, ".", " "); ?></strong></td>
				 </tr>
				 <tr>
				     <td><strong><?php echo ucfirst($projets['taxe_projet']); ?>(<?php echo $projets['taux'].'%'; ?>)</strong></td>
					 <td><strong><?php echo number_format(($projets['montant_ht_projet'] * $projets['taux'] / 100), 2, ".", " "); ?></strong></td>
				 </tr>
				 <tr>
				     <td><strong>Montant TTC</strong></td>
					 <?php $montpro = $projets['montant_ht_projet'] + ($projets['montant_ht_projet'] * $projets['taux'] / 100); ?>
					 <td><strong><?php echo number_format($montpro, 2, ".", " "); ?></strong></td>
				 </tr>
				 
			 </table>
			 
			
			 
		</div>
		
    <table border="2 solid #ccc" class="tbliste table table-striped">
	
	    <tr>
	        <th style="color: white; background-color: #555555;">Id personnel</th>
	        <th style="color: white; background-color: #555555;">Matricule personnel</th>		
	        <th style="color: white; background-color: #555555;">Fonction personnel</th>
			<th style="color: white; background-color: #555555;">Salaire horaire</th>		
	        <th style="color: white; background-color: #555555;">Nombre d'heure</th>
            <th style="color: white; background-color: #555555;">Total</th>			
        </tr>
		
		
		<?php
			
			$lpers = listePersByExe($idp);
			
			$ts = 0.0;
			$tnh = 0.0;
			$tt = 0.0;
				
		?>
		
		<?php  
				  
				foreach($lpers as $p) {
				     				  
	     ?>
		 
        <tr>
	        <td>
			       <?php
                       
					     echo $p['id_personnel_execution'];
						
					?>
			</td>
			
	        <td>
			    <?php 
				     echo $p['matricule_personnel_execution'];
			    ?>
		    </td>
	        <td>
			       <?php 
                        echo $p['fonction_personnel_execution'];				   
			       ?>
		    </td>		
	        <td>
			    <?php
				        $ts += $p['salaire_horaire_personnel_execution'];
                        echo number_format($p['salaire_horaire_personnel_execution'], 2, ".", " ");           					   
				?>
			</td>
			<td>
			     <?php
				     $tnh += $p['nombre_horaire_personnel_execution'];
				     echo number_format($p['nombre_horaire_personnel_execution'], 2, ".", " ");
				?>
		    </td>		
	        <td>
			    <?php
				    $t = $p['salaire_horaire_personnel_execution'] * $p['nombre_horaire_personnel_execution'];
					$tt += $t;
				     echo number_format($t, 2, ".", " ");      					   
			    ?>		
	        </td>
			
		
		 </tr> 
		 
		<?php } ?>
		
		
         
		 <tr class="trtp">
			<td colspan="3" style="background-color: #b5ecb5"><center><strong>Total Projet</strong></center></td>
			<td style="background-color: #b5ecb5">
			    <?php
                       echo number_format($ts, 2, ".", " ");
				 ?>
		    </td>
			
			<td style="background-color: #b5ecb5">
			    <?php
                    	echo number_format($tnh, 2, ".", " ");
				 ?>
		    </td>
			
			<td style="background-color: #b5ecb5">
			    <?php
					echo number_format($tt, 2, ".", " ");
                     					 
				 ?>
		    </td>
			
			
			
		</tr>
		 
</table>




     <?php 
	        } else if (isset($_GET['idp']) && !empty($_GET['idp']) && is_projet_exist(htmlspecialchars($_GET['idp'])) == true) {
			     
				        $id =  (int) trim(htmlspecialchars($_GET['idp']));
		
					    $projet = infos_projet($id);
						$projet_id = $projet['id_projet'];
			
			     echo 'Le projet <span style="color: #08c;">'.$projet['objet_projet'].'</span> n\'a pas de données d\'execution, donc aucun aperçu de resultat ne peut être affiché!<br/><br/>';
				 echo '<a href="donnee_exec.php?idp='.$projet_id.'"><button style="margin-top: 20px;" class="btn btn-mini btn-primary" type="button"><i class="icon icon-arrow-left icon-white"></i>  Ajouter des données d\'execution</button></a>';
			} else {
			  echo '<h3 style="color: red;">Erreur: Aucun projet selectioné!</h3><br/>';
			}
        ?>
	
	

	  <p>
	      <a href="resultats_execution.php?idp=<?php echo $idp; ?>"><button style="margin-top: 20px;" class="btn btn-primary btn-mini" type="button"><i class="icon icon-arrow-left icon-white"></i> Retour</button></a>
		  <a href="index.php"><button style="margin-top: 20px;" class="btn btn-primary btn-mini" type="button">Accueil  <i class="icon icon-home icon-white"></i></button></a>
		  <a href="nouveau_projet.php"><button style="margin-top: 20px;" class="btn btn-mini btn-primary" type="button">Créer un nouveau projet</button></a>
		  
      </p>

    </center>



<?php include 'footer.php'; ?>