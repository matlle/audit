<?php
    require_once 'header.php';
    require_once 'model.php';
    
	
	start_session();
    logout_protected();
	expired();
	
	$i = 0;
	$j = 0;
	
	
	    if(isset($_GET['idp']) && !empty($_GET['idp']) && is_projet_exist(htmlspecialchars($_GET['idp'])) == true  &&  is_projet_has_donnee_prevision(htmlspecialchars($_GET['idp']))) {
					    
						$idp =  (int) trim(htmlspecialchars($_GET['idp']));
					
	
	                   $projets = infos_projet($idp);
	                   $prev_res = liste_donnees_prevision($idp);
                      
					   $tp = 0.0;
					   $top = array();
	                   $spar = array();
					   $engar = array();
					   $roular = array();
					   $ccar = array();
					   $pfar = array();
					   $r = 0.0;
					   
	
?>


        <center>
    
	
		<h3><u>Résulat previsionnel</u></h3>
		
		
		<h2>Projet - <span style="background-color: #6DCCF4; width: 40%;"><?php echo $projets['objet_projet']; ?></span></h2>
		
		
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
	        <th style="color: white; background-color: #555555;">Id prevision</th>
	        <th style="color: white; background-color: #555555;">Nature des travaux</th>		
	        <th style="color: white; background-color: #555555;">Frais personnelles</th>
			<th style="color: white; background-color: #555555;">Frais engin</th>		
	        <th style="color: white; background-color: #555555;">Frais materiel roulant</th>
			<th style="color: white; background-color: #555555;">Frais materiel chantier</th>
            <th style="color: white; background-color: #555555;">Autres frais</th>
            <th style="color: white; background-color: #555555;">Total opéra.</th>
            <th style="color: white; background-color: #555555;">Pourcentage</th>			
        </tr>
		
		
		<?php		
                for($i; $i < count($prev_res); $i++) {
				
				
				$salper = salairePerPrev($prev_res[$i]['id_previsionnelle']);
			    $sp = $salper['SUM(salaire_horaire_personnel_previsionnelle * nombre_horaire_personnel_previsionnelle)']; 
				$spar[] = ($sp != null ? $sp : 0);
				
				
				
				$fraieng = fraisEngPrev($prev_res[$i]['id_previsionnelle']);
		        $loc = $fraieng['SUM(location_par_jour_engin_previsionnel)'];
				$pricar = $fraieng['SUM(prix_carburant_engin_previsionnel)'];
				$prilub = $fraieng['SUM(prix_lubrifiant_engin_previsionnel)'];
				$someng = $loc + $pricar + $prilub;
				$engar[] = ($someng != null ? $someng : 0);
				
				
				 $frairoul = fraisRoulPrev($prev_res[$i]['id_previsionnelle']);
				 $loc = $frairoul['SUM(location_par_jour_matroulant_previsionnel)'];
				 $pricar = $frairoul['SUM(prix_carburant_matroulant_previsionnel)'];
				 $prilub = $frairoul['SUM(prix_lubrifiant_matroulant_previsionnel)'];
				 $somroul = $loc + $pricar + $prilub;
				 $roular[] = ($somroul != null ? $somroul : 0);
				
				
				
				$coutchant = fraisMatChantPrev($prev_res[$i]['id_previsionnelle']);
				$cc = $coutchant['SUM(cout_materiel_previsionnel * quantite_materiel_previsionnel)'];
				$ccar[] = ($cc != null ? $cc : 0);
				
				
				
                $prixautresfrais = autresFraisPrev($prev_res[$i]['id_previsionnelle']);
				$pf = $prixautresfrais['SUM(quantite_autresfrais_previsionnel * prix_autresfrais_previsionnel)'];
				$pfar[] = ($pf != null ? $pf : 0);
				
				
				$top[] = $sp + $someng + $somroul + $cc + $pf;
				
			
				
				  $sper = 0;
				   $seng = 0;
				   $sroul = 0;
				   $scc = 0;
				   $spf  = 0;
				   				
                				   
				if($i + 1 == count($prev_res)) {
				   
				   
					$sper = 0;
					foreach($spar as $it) {
					    $sper += $it;
					}					
					
                    
					$seng = 0;
					
					foreach($engar as $it) {
					    $seng += $it;
					}				
					 					 
			
                    
					$sroul = 0;
					foreach($roular as $it) {
					    $sroul += $it;
					}				
					
                    
					$scc = 0;
					foreach($ccar as $it) {
					    $scc += $it;
					}				
					
                    
					$spf = 0;
                    foreach($pfar as $it) {
					    $spf += $it;
					}				
				  
				  
				  $tp = $sper + $seng + $sroul + $scc + $spf;
				  
				  		  
			  }
				
				
				
		 }
			
				
				
				
		?>
		
		<?php 
		          for($j; $j < count($prev_res); $j++) {
	     ?>
		 
        <tr>
	        <td><?php echo $prev_res[$j]['id_previsionnelle']; ?></td>
	        <td><?php echo $prev_res[$j]['nature_travaux_previsionnelle']; ?></td>
	        <td>
			       <?php 
				       
					   echo number_format($spar[$j], 2, ".", " ");
					  
                        					   
			       ?>
		    </td>		
	        <td>
			    <?php
                         
						 echo number_format($engar[$j], 2, ".", " ");
                       					   
				?>
			</td>
			<td>
			     <?php

						 echo number_format($roular[$j], 2, ".", " ");
                       					   
				?>
		    </td>		
	        <td>
			    <?php 
				       
					   echo number_format($ccar[$j], 2, ".", " ");
                        					   
			    ?>		
	        <td>
			    <?php 
				       
					   echo number_format($pfar[$j], 2, ".", " ");
                        					   
			    ?>
			</td>
			<td>
			    <?php
				     
					 echo number_format($top[$j], 2, ".", " ");
                     
				?>
			</td>		
			
			
          <td>
			    <?php
				        
						if($tp == 0)
						    echo number_format(0, 3, ".", " ").'%';
					    else {
				             $rate =  ($top[$j] / $tp) * 100;
					         echo number_format($rate, 3, ".", " ").'%';
						     $r += $rate;
						}
					 
				?>
			</td>
		
		 </tr> 
		 
		<?php } ?>
		
		
         
		 <tr class="trtp">
			<td colspan="2" style="background-color: #b5ecb5"><center><strong>Total Projet</strong></center></td>
			<td style="background-color: #b5ecb5">
			    <?php
                    					
					echo number_format($sper, 2, ".", " ");
                     					 
				 ?>
		    </td>
			
			<td style="background-color: #b5ecb5">
			    <?php
                    			
					echo number_format($seng, 2, ".", " ");
					
                     					 
				 ?>
		    </td>
			
			<td style="background-color: #b5ecb5">
			    <?php
                    			
					echo number_format($sroul, 2, ".", " ");
                     					 
				 ?>
		    </td>
			
			<td style="background-color: #b5ecb5">
			    <?php
                    				
					echo number_format($scc, 2, ".", " ");
                     					 
				 ?>
		    </td>
			
			<td style="background-color: #b5ecb5">
			    <?php
                    		
					echo number_format($spf, 2, ".", " ");
                     					 
				 ?>
		    </td>
			
			
			<td style="background-color: #b5ecb5">
			    <?php
				    
					echo number_format($tp, 2, ".", " ");
                     					 
				 ?>
		    </td>
			
			<td style="background-color: #b5ecb5">
			    <?php                  	
			        
                     echo number_format($r, 3, ".", " ").'%';					
				 ?>
		    </td>
			
			
		</tr>
		
		
		<tr>
		    <td colspan="2"></td>
		    <td>
			    <?php
                     $t1 = 0.0;
                     $t2 = 0.0;
                     $t3 = 0.0;
                     $t4 = 0.0;
                     $t5 = 0.0;					 
				     if($tp == 0) 
					 echo number_format(0, 3, ".", " ").'%';
                    else {
                        $t1 = ($sper / $tp) * 100;
                        echo number_format($t1, 3, ".", " ").'%';
                    }						
			     ?>
		    </td>
			
			<td>
			    <?php
				    if($tp == 0)
					    echo number_format(0, 3, ".", " ").'%';
					else {
				        $t2 = ($seng / $tp) * 100; 
						echo number_format($t2, 3, ".", " ").'%';
                    }						
			    ?>
		    </td>
			
			<td>
			     <?php
                     if($tp == 0)
                         echo number_format(0, 3, ".", " ").'%';
					 else {
				         $t3 = ($sroul / $tp) * 100; 
						 echo number_format($t3, 3, ".", " ").'%';
                    }						 
				  ?>
		    </td>
			
			<td>
			    <?php
                 if($tp == 0) 
                     echo number_format(0, 3, ".", " ").'%';
                 else {					 
				     $t4 = ($scc / $tp) * 100; 
					 echo number_format($t4, 3, ".", " ").'%';
                }					 
				?>
		    </td>
			
			<td>
			    <?php
                     if($tp == 0)
                        echo number_format(0, 3, ".", " ").'%';
                     else {						
				         $t5 = ($spf / $tp) * 100; 
						 echo number_format($t5, 3, ".", " ").'%';
                    }						 
				?>
			</td>
			<td><?php echo number_format($t1 + $t2 + $t3 + $t4 + $t5, 3, ".", " ").'%'; ?></td>
		<tr/>
		 
</table>


<strong style="margin-left: -250px; font-size: 1.2em;">Résultat net</strong>
 <table border="2 solid #ccc" width="30%;" style="background-color: #ccc;">
     <tr>
	     <td><strong>Montant projet</strong></td>
		 <td><strong><?php echo number_format($montpro, 2, ".", " "); ?></strong></td>
	 </tr>
	 <tr>
	     <td><strong>Dépenses exécutées</strong></td>
		 <td><strong><?php echo number_format($tp, 2, ".", " "); ?></strong></td>
	 </tr>
	 <tr>
	     <td><strong>Resultat net</strong></td>
		 <td><strong><?php echo number_format($montpro - $tp, 2, ".", " "); ?></strong></td>
	 </tr>
 </table>
 
     <?php 
	     $te = ($tp / $montpro * 100);
		 //$te = 100.01;
         $col = ($te < 100.0) ? 'green' : 'red';		 
	 ?> 
   <h3><u>Soit un taux d'exécution de</u>   &nbsp;<span style="color: <?php echo $col; ?>;"><?php echo number_format($te, 3, ".", " ").'%'; ?></span></h3>



     <?php 
	        } else if (isset($_GET['idp']) && !empty($_GET['idp']) && is_projet_exist(htmlspecialchars($_GET['idp'])) == true) {
			     
				        $id =  (int) trim(htmlspecialchars($_GET['idp']));
		
					    $projet = infos_projet($id);
						$projet_id = $projet['id_projet'];
			
			     echo '<center><h4>Le projet <span style="color: #08c;">'.$projet['objet_projet'].'</span> n\'a pas de données de prevision, donc aucun aperçu de resultat ne peut être affiché!</h4><br/></center>';
				 echo '<center><a href="donnee_previ.php?idp='.$projet_id.'"><button style="margin-top: 20px;" class="btn btn-mini btn-primary" type="button"><i class="icon icon-arrow-left icon-white"></i>  Ajouter des données de prevision</button></a></center>';
			} else {
			  echo '<center><h3 style="color: red;">Erreur: Aucun projet selectioné!</h3><br/></center>';
			}
        ?>
	
	
    <center>
	 <p> 
		  <form>
	          <button style="margin-top: 20px;" class="btn btn-primary btn-mini" type="button" onclick="imprimer_page()" name="impression">Imprimer  <i class="icon icon-print icon-white"></i></button>
		  </form>
	  
		  <a href="index.php"><button style="margin-top: 20px;" class="btn btn-primary btn-mini" type="button">Accueil  <i class="icon icon-home icon-white"></i></button></a>
		  <a href="nouveau_projet.php"><button style="margin-top: 20px;" class="btn btn-mini btn-primary" type="button">Créer un nouveau projet</button></a>
		  
      </p>

    </center>



<?php include 'footer.php'; ?>