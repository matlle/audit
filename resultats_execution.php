<?php
    require_once 'header.php';
    require_once 'model.php';
    include "libchart/classes/libchart.php";
	
	start_session();
    logout_protected();
	expired();
	
	$i = 0;
	$j = 0;
	
	
	    if(isset($_GET['idp']) && !empty($_GET['idp']) && is_projet_exist(htmlspecialchars($_GET['idp'])) == true  &&  is_projet_has_donnee_execution(htmlspecialchars($_GET['idp']))) {
					    
						$idp =  (int) trim(htmlspecialchars($_GET['idp']));
	
	                   $projets = infos_projet($idp);
	                   $exe_res = liste_donnees_execution($idp);
                      
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
	
		<h3><u>Résulat d'exécution</u></h3>
		
		
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
					 <td style="background-color: #1ffb4f;"><strong><?php echo number_format($montpro, 2, ".", " "); ?></strong></td>
				 </tr>
				 
			 </table>
			 
			
			 
		</div>
		
    <table border="2 solid #ccc" class="tbliste table table-striped">
	
	    <tr>
	        <th style="color: white; background-color: #555555;">Id execution</th>
	        <th style="color: white; background-color: #555555;">Nature des travaux</th>		
	        <th style="color: white; background-color: #555555;"><a href="res_pers.php?idp=<?php echo $idp; ?>">Frais personnelles</a></th>
			<th style="color: white; background-color: #555555;"><a href="res_eng.php?idp=<?php echo $idp; ?>">Frais engin</a></th>		
	        <th style="color: white; background-color: #555555;"><a href="res_roul.php?idp=<?php echo $idp; ?>">Frais materiel roulant</a></th>
			<th style="color: white; background-color: #555555;"><a href="res_mchat.php?idp=<?php echo $idp; ?>">Frais materiel chantier</a></th>
            <th style="color: white; background-color: #555555;"><a href="res_afrai.php?idp=<?php echo $idp; ?>">Autres frais</a></th>
            <th style="color: white; background-color: #555555;">Total opéra.</th>
            <th style="color: white; background-color: #555555;">Pourcentage</th>
        </tr>
		
		
		<?php		
                for($i; $i < count($exe_res); $i++) {
				
				
				$salper = salairePerExe($exe_res[$i]['id_execution']);
			    $sp = $salper['SUM(salaire_horaire_personnel_execution * nombre_horaire_personnel_execution)']; 
				$spar[] = ($sp != null ? $sp : 0);
				
				
				
				$fraieng = fraisEngExe($exe_res[$i]['id_execution']);
		        $nbjo = $fraieng['SUM(nombre_jour_engin_execution)'];
				$loc = $fraieng['SUM(location_par_jour_engin_execution)'];
				$pricar = $fraieng['SUM(prix_carburant_engin_execution)'];
				$prilub = $fraieng['SUM(prix_lubrifiant_engin_execution)'];
				$someng = ($loc * $nbjo) + $pricar + $prilub;
				$engar[] = ($someng != null ? $someng : 0);
				
				
				 $frairoul = fraisRoulExe($exe_res[$i]['id_execution']);
				 $nbjor = $frairoul['SUM(nombre_jour_matroulant_execution)'];
				 $loc = $frairoul['SUM(location_par_jour_matroulant_execution)'];
				 $pricar = $frairoul['SUM(prix_carburant_matroulant_execution)'];
				 $prilub = $frairoul['SUM(prix_lubrifiant_matroulant_execution)'];
				 $somroul = ($loc * $nbjor) + $pricar + $prilub;
				 $roular[] = ($somroul != null ? $somroul : 0);
				
				
				
				$coutchant = fraisMatChantExe($exe_res[$i]['id_execution']);
				$cc = $coutchant['SUM(cout_materiel_execution * quantite_materiel_execution)'];
				$ccar[] = ($cc != null ? $cc : 0);
				
				
				
                $prixautresfrais = autresFraisExe($exe_res[$i]['id_execution']);
				$pf = $prixautresfrais['SUM(quantite_autresfrais_execution * prix_autresfrais_execution)'];
				$pfar[] = ($pf != null ? $pf : 0);
				
				
				$top[] = $sp + $someng + $somroul + $cc + $pf;
				
			
				
				  $sper = 0;
				   $seng = 0;
				   $sroul = 0;
				   $scc = 0;
				   $spf  = 0;
				   				
                				   
				if($i + 1 == count($exe_res)) {
				   
				   
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
		          for($j; $j < count($exe_res); $j++) {
	     ?>
		 
        <tr>
	        <td><?php echo $exe_res[$j]['id_execution']; ?></td>
	        <td><?php echo $exe_res[$j]['nature_travaux_execution']; ?></td>
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
			
			
			<td style="background-color: #EEB111;"">
			    <?php
				    
					echo number_format($tp, 2, ".", " ");
					/*$d = depexByPro($idp);
					echo number_format($d[0], 2, ".", " ");*/
                     					 
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

<div style="margin-right: 300px;">
<strong style="margin-left: -220px; font-size: 1.2em;">Résultat net</strong>
 <table border="2 solid #ccc" width="30%;" style="background-color: #ccc;">
     <tr>
	     <td><strong>Montant projet</strong></td>
		 <td><strong><?php echo number_format($montpro, 2, ".", " "); ?></strong></td>
	 </tr>
	 <tr>
	     <td><strong>Dépenses exécutées</strong></td>
		 <td style="background-color: #EEB111;"><strong><?php echo number_format($tp, 2, ".", " "); ?></strong></td>
	 </tr>
	 <tr>
	     <td><strong>Resultat net</strong></td>
		 <td style="background-color: #fbf11f;"><strong><?php echo number_format($montpro - $tp, 2, ".", " "); ?></strong></td>
	 </tr>
 </table>
 
     <?php 
	     $te = ($tp / $montpro * 100);
		 //$te = 100.01;
         $col = ($te < 100.0) ? 'green' : 'red';		 
	 ?> 
   <h3><u>Soit un taux d'exécution de</u>   &nbsp;<span style="color: <?php echo $col; ?>;"><?php echo number_format($te, 3, ".", " ").'%'; ?></span></h3>

   </div>

   
   <?php
        
	    $chart = new PieChart(500, 250);

	   $dataSet = new XYDataSet();
	   
	   if($t1 != 0)
	       $dataSet->addPoint(new Point("Personnelle", $t1));
	    else
	       $dataSet->addPoint(new Point("Personnelle", 0));
		   
		if($t2 != 0)		
	       $dataSet->addPoint(new Point("Engin", $t2));
		else
		    $dataSet->addPoint(new Point("Engin", 0));
			
	    if($t3 != 0)
	        $dataSet->addPoint(new Point("Materiel roulant", $t3));
		else
		    $dataSet->addPoint(new Point("Materiel roulant", 0));
			
		if($t4 != 0)
	        $dataSet->addPoint(new Point("Materiel chantier", $t4));
	    else
		    $dataSet->addPoint(new Point("Materiel chantier", 0));
			
		if($t5 != 0)
	        $dataSet->addPoint(new Point("Autres frais", $t5));
		else
		    $dataSet->addPoint(new Point("Autres frais", 0));
	   $chart->setDataSet($dataSet);

	  $chart->setTitle("Repartition par depenses");
	  $chart->render("assets/img/out.png");   
		
   ?>
   
   
   <div style="float: right; margin-right: 20px; margin-top: -160px;">
       <img src='assets/img/out.png' />
   </div>
   
   <p>
	     <form>
	          <button style="margin-top: 20px;" class="btn btn-primary btn-mini" type="button" onclick="imprimer_page()" name="impression">Imprimer  <i class="icon icon-print icon-white"></i></button>
		  </form>
   </p>
   
   
   

     <?php 
	        } else if (isset($_GET['idp']) && !empty($_GET['idp']) && is_projet_exist(htmlspecialchars($_GET['idp'])) == true) {
			     
				        $id =  (int) trim(htmlspecialchars($_GET['idp']));
		
					    $projet = infos_projet($id);
						$projet_id = $projet['id_projet'];
			
			     echo '<center><h4>Le projet <span style="color: #08c;">'.$projet['objet_projet'].'</span> n\'a pas de données d\'execution, donc aucun aperçu de resultat ne peut être affiché!</h4><br/></center>';
				 echo '<center><a href="donnee_exec.php?idp='.$projet_id.'"><button style="margin-top: 20px;" class="btn btn-mini btn-primary" type="button"><i class="icon icon-arrow-left icon-white"></i>  Ajouter des données d\'execution</button></a></center>';
			} else {
			  echo '<center><h3 style="color: red;">Erreur: Aucun projet selectioné!</h3><br/></center>';
			}
        ?>
	
	
   <center>
	  <p>
		  <a href="index.php"><button style="margin-top: 20px;" class="btn btn-primary btn-mini" type="button">Accueil  <i class="icon icon-home icon-white"></i></button></a>
		  <a href="nouveau_projet.php"><button style="margin-top: 20px;" class="btn btn-mini btn-primary" type="button">Créer un nouveau projet</button></a>
		  
      </p>

    </center>



<?php include 'footer.php'; ?>
