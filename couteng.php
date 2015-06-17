<?php
    require_once 'header.php';
    require_once 'model.php';
    
	start_session();
    logout_protected();
	expired();

	$i = 0;
	$j = 0;
	
	
	
	    if(isset($_GET['idp']) && !empty($_GET['idp']) && is_projet_exist(htmlspecialchars($_GET['idp'])) == true  &&  is_projet_has_donnee_execution(htmlspecialchars($_GET['idp'])) === true)  {
					    
						$idp =  (int) trim(htmlspecialchars($_GET['idp']));
						
	                   $projets = infos_projet($idp);
	                   $exe_res = liste_donnees_execution($idp);
                      
					  
					   
	
?>


        <center>
     
	
		<h3><u>Résultats d'exécution</u></h3>
		
		<h2 style="background-color: #b5ecb5;; width: 40%;">Detail engin</h2>
		
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
	        <th style="color: white; background-color: #555555;">Id</th>
	        <th style="color: white; background-color: #555555;">Code</th>		
	        <th style="color: white; background-color: #555555;">Nom</th>
			<th style="color: white; background-color: #555555;">Puissance</th>		
	        <th style="color: white; background-color: #555555;">Marque</th>
			<th style="color: white; background-color: #555555;">Nbr jour location</th>
			<th style="color: white; background-color: #555555;">Prix location</th>
			<th style="color: white; background-color: #555555;">Carburant cons</th>
			<th style="color: white; background-color: #555555;">Prix carburant</th>
			<th style="color: white; background-color: #555555;">Lubrifiant cons</th>
			<th style="color: white; background-color: #555555;">Prix lubrifiant</th>
			<th style="color: white; background-color: #555555;">Prime</th>
            <th style="color: white; background-color: #555555;">Total</th>			
        </tr>
		
		
		<?php
			
			$leng = listeEngByExe($idp);
			
			$tjl = 0.0;
			$tlj = 0.0;
			$tpcar = 0.0;
			$tplub = 0.0;
			$tprime = 0.0;
			$tt = 0.0;
				
		?>
		
		<?php  
				  
				foreach($leng as $e) {
				     				  
	     ?>
		 
        <tr>
	        <td>
			       <?php
                       
					     echo $e['id_engin_execution'];
						
					?>
			</td>
			
	        <td>
			    <?php 
				     echo $e['code_engin_execution'];
			    ?>
		    </td>
	        <td>
			       <?php 
                        echo $e['nom_engin_execution'];				   
			       ?>
		    </td>		
	        <td>
			    <?php
                        echo $e['puissance_engin_execution'];           					   
				?>
			</td>
			<td>
			     <?php
				     echo $e['marque_engin_execution'];
				?>
		    </td>		
	        <td>
			    <?php
				    $jl = $e['nombre_jour_engin_execution'];
					$tjl += $jl;
				     echo number_format($jl, 2, ".", " ");      					   
			    ?>		
			</td>
			
			
			<td>
			    <?php
				    $lj = $e['location_par_jour_engin_execution'];
					$tlj += $lj;
				     echo number_format($lj, 2, ".", " ");      					   
			    ?>		
			</td>
			
			
			<td>
			    <?php
				    echo $e['consommation_carburant_par_jour_engin_execution'];
				           					   
			    ?>		
			</td>
			
			
			<td>
			    <?php
				    $pcar = $e['prix_carburant_engin_execution'];
					$tpcar += $pcar;
				     echo number_format($pcar, 2, ".", " ");      					   
			    ?>		
			</td>
			
			
			<td>
			    <?php
				     echo $e['consommation_lubrifiant_par_jour_engin_execution'];
				           					   
			    ?>		
			</td>
			
			<td>
			    <?php
				    $plub = $e['prix_lubrifiant_engin_execution'];
					$tplub += $plub;
				     echo number_format($plub, 2, ".", " ");      					   
			    ?>		
			</td>
			
			
			 <td>
			     <?php
			         $prime = $e['prime_engin_execution'];
					 $tprime += $prime;
					 echo number_format($prime, 2, ".", " ");
				?>
			 </td>
			
			
			<td>
			    <?php
				    $t = ($jl * $lj) + $pcar + $pcar + $prime;
					$tt += $t;
				     echo number_format($t, 2, ".", " ");      					   
			    ?>		
			</td>
			
			
		
		 </tr> 
		 
		<?php } ?>
		
		
         
		 <tr class="trtp">
			<td colspan="5" style="background-color: #b5ecb5"><center><strong>Total Projet</strong></center></td>
			<td style="background-color: #b5ecb5">
			    <?php
                       echo number_format($tjl, 2, ".", " ");
				 ?>
		    </td>
			
			<td style="background-color: #b5ecb5">
			    <?php
                    	echo number_format($tlj, 2, ".", " ");
				 ?>
		    </td>
			
			<td style="background-color: #b5ecb5">
			    <?php
					echo "NULL";
                     					 
				 ?>
		    </td>
			
			<td style="background-color: #b5ecb5">
			    <?php
					echo number_format($tpcar, 2, ".", " ");
                     					 
				 ?>
		    </td>
			
			<td style="background-color: #b5ecb5">
			    <?php
					echo "NULL";
                     					 
				 ?>
		    </td>
			
			
			<td style="background-color: #b5ecb5">
			    <?php
					echo number_format($tplub, 2, ".", " ");
                     					 
				 ?>
		    </td>
			
			
			<td style="background-color: #b5ecb5">
			    <?php
					echo number_format($tprime, 2, ".", " ");  					 
				 ?>
		    </td>
			
			
			<td style="background-color: #b5ecb5">
			    <?php
					echo number_format($tt, 2, ".", " ");
                     					 
				 ?>
		    </td>
			
		</tr>
		 
</table>







 <table border="2 solid #ccc" class="tbliste table table-striped" style="margin-top: 50px;">
		
    <tr>
         <th></th>
         <th colspan="3" style="color: white; background-color: #555555;">Coût journalier de location</th>
         <th colspan="3" style="color: white; background-color: #555555;">Coût consommation carburant</th>
		 <th colspan="3" style="color: white; background-color: #555555;">Coût consommation lubrifiant</th>
		 <th></th>
         <th rowspan="2" style="color: white; background-color: #555555;"><center>Total</center></th>

    </tr>
    <tr>
         <th style="color: white; background-color: #555555;">Date</th>
         <th style="color: white; background-color: #555555;">Jour</th>
         <th style="color: white; background-color: #555555;">Prix horaire</th>
         <th style="color: white; background-color: #555555;">Montant</th>
         <th style="color: white; background-color: #555555;">Litre</th>
         <th style="color: white; background-color: #555555;">Prix litre</th>
		 <th style="color: white; background-color: #555555;">Montant</th>
		 <th style="color: white; background-color: #555555;">Litre</th>
		 <th style="color: white; background-color: #555555;">Prix litre</th>
		 <th style="color: white; background-color: #555555;">Montant</th>
		 <th style="color: white; background-color: #555555;">Prime</th>
    </tr>
		
		
		<?php
			
			$leng = listeEngByExe($idp);
			
			$tjl = 0.0;
			$tlj = 0.0;
			$tpcar = 0.0;
			$tplub = 0.0;
			$tmcarb = 0.0;
			$tmlub = 0.0;
			$tt = 0.0;
				
		?>
		
		<?php  
				  
				foreach($leng as $e) {
				     				  
	     ?>
		 
        <tr>
	        <td>
			       <?php
                       
						 echo date_format(date_create($e['date_saisie_engin_execution']), 'd/m/Y');
						
					?>
			</td>
			
	        <td>
			    <?php 
				     echo number_format($e['nombre_jour_engin_execution'], 2, ".", " ");
			    ?>
		    </td>
	        <td>
			       <?php 
                        echo number_format($e['location_par_jour_engin_execution'], 2, ".", " ");				   
			       ?>
		    </td>		
	        <td>
			    <?php
                        $ml = $e['nombre_jour_engin_execution'] * $e['location_par_jour_engin_execution'];
                         echo number_format($ml, 2, ".", " ");						
				?>
			</td>
			<td>
			     <?php
				     echo $e['consommation_carburant_par_jour_engin_execution'];
					 $litre_carb = (float) $e['consommation_carburant_par_jour_engin_execution'];
				?>
		    </td>		
	        <td>
			    <?php
				    $pcarb = $e['prix_carburant_engin_execution'];;
				     echo number_format($pcarb, 2, ".", " ");      					   
			    ?>		
			</td>
			
			
			<td>
			    <?php
				    $mcarb = $pcarb * $litre_carb;
				    echo number_format($mcarb, 2, ".", " ");      					   
			    ?>		
			</td>
			
			
			<td>
			    <?php
				     echo $e['consommation_lubrifiant_par_jour_engin_execution'];
					 $litre_lub = (float) $e['consommation_lubrifiant_par_jour_engin_execution'];
			    ?>		
			</td>
			
			
			<td>
			    <?php
				    $plub = $e['prix_lubrifiant_engin_execution'];
				     echo number_format($plub, 2, ".", " ");      					   
			    ?>		
			</td>
			
			
			<td>
			    <?php
				    $mlub = $plub * $litre_lub;
				     echo number_format($mlub, 2, ".", " ");      			
			    ?>		
			</td>
			
			<td>
			    <?php
				    $prime = $e['prime_engin_execution'];
				     echo number_format($prime, 2, ".", " ");      					   
			    ?>		
			</td>
			
			
			<td>
			    <?php
				     echo number_format($ml + $mcarb + $mlub + $prime, 2, ".", " ");      					   
			    ?>		
			</td>
			
			
		
		 </tr> 
		 
		<?php } ?>
		
		
         
		
		 
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
	
	
	  
		  <form>
	          <button style="margin-top: 20px;" class="btn btn-primary btn-mini" type="button" onclick="imprimer_page()" name="impression">Imprimer  <i class="icon icon-print icon-white"></i></button>
		  </form>
	

	  <p>
          <?php 
		          if (isset($_GET['idp']) && !empty($_GET['idp']) && is_projet_exist(htmlspecialchars($_GET['idp'])) == true) {
 		          $idp =  (int) trim(htmlspecialchars($_GET['idp']));
		   ?>
	          <a href="statiseng.php?idp=<?php echo $idp; ?>"><button style="margin-top: 20px;" class="btn btn-primary btn-mini" type="button"><i class="icon icon-arrow-left icon-white"></i> Retour</button></a>
		<?php } ?>
		
		
		
		  <a href="index.php"><button style="margin-top: 20px;" class="btn btn-primary btn-mini" type="button">Accueil  <i class="icon icon-home icon-white"></i></button></a>
		  <a href="nouveau_projet.php"><button style="margin-top: 20px;" class="btn btn-mini btn-primary" type="button">Créer un nouveau projet</button></a>
		  
      </p>

    </center>



<?php include 'footer.php'; ?>