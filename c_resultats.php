<?php
    require_once 'header.php';
    require_once 'model.php';
    include "libchart/classes/libchart.php";
	
	start_session();
    logout_protected();
	expired();
	
	$i = 0;
	$j = 0;
	
	
	    if(isset($_GET['idp']) && !empty($_GET['idp']) && is_projet_exist(htmlspecialchars($_GET['idp'])) == true  &&  is_projet_has_donnee_operation(htmlspecialchars($_GET['idp']))) {
					    
						$idp =  (int) trim(htmlspecialchars($_GET['idp']));
	
	                   $projets = infos_projet($idp);
	                   $ops_res = liste_donnees_operation($idp);
					   
					   $tdo = totalMontantOperatioByProjet($idp);
                    
					   $pi = array();
					   $tp = 0.0;
					   
	
?>



        <center>    
	
        <h3>
             <div>
             
             
                                               
             		    
                                       <a href="ops.php"><button class="btn btn-primary" style="margin-right: 10px;">Saisir oprération</button></a>
                                <div class="btn-group">
                                        <a class="btn btn-" href="#">Selectionner un projet</a>
										
                                        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                              <?php 
                                                $pros = liste_projets();
                                                    foreach($pros as $p) {
                                                        if(is_projet_has_donnee_operation($p['id_projet']) === true) {
                                                    ?>
                                                        <li><a href="c_resultats.php?idp=<?php echo $p['id_projet']; ?>"><?php echo $p['objet_projet']; ?></a>
                                                       </li>
                                                            <?php } ?>
                                                    <?php } ?>
                                        </ul>
										
                                      										
										
                               </div>
             
             
             
             
             
                 
             </div>
        <u>Aperçu de résulat</u>
        </h3>
		
		
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
		
		<?php
		    if(isset($_POST['fsubmit'])) {
		        if(isset($_POST['date1'])  && !empty($_POST['date1']) && isset($_POST['date2']) && !empty($_POST['date2'])) {
				    $date1 = $_POST['date1'];
				    $date2 = $_POST['date2'];
				    $ops_res = liste_donnees_operation_date_filter($idp, $date1, $date2);
					$filter_tdo = totalMontantOperatioByProjetOnDateFilter($idp, $date1, $date2);
		        }
		    }
		?> 
		
		<div style="margin-top: 20px;">
		<form method="post" action="<?php echo $_SERVER['PHP_SELF'].'?idp='.$idp; ?>">
			    <input type="date" name="date1" value="<?php if(isset($date1) && !empty($date1)) echo $date1; else echo $projets['date_projet']; ?>"> - 
				<input type="date" name="date2" value="<?php if(isset($date2)  && !empty($date2)) echo $date2; ?>">
				<button type="submit" name="fsubmit" class="btn" style="margin-top: -10px;">Filtrer</button>
			</form>
		</div>
		
		<?php if(isset($date1) && isset($date2)) { ?>
		    <div style="margin-top: -20px;">
			    Aperçu de resultat du 
				    <strong><em><?php echo date_format(date_create($date1), 'd/m/Y'); ?></em></strong> au
                    <strong><em><?php echo date_format(date_create($date2), 'd/m/Y'); ?></em></strong>
			</div>
		<?php } ?>
		
    <table border="2 solid #ccc" class="tbliste table table-striped">
	
	    <tr>
	        <th style="color: white; background-color: #555555;">Code opération</th>
	        <th style="color: white; background-color: #555555;">Libelé</th>
            <th style="color: white; background-color: #555555;">Montant</th>
            <th style="color: white; background-color: #555555;">Date  <!-- <select><option></option><option>Septembre</option></select> --></th>
            <th style="color: white; background-color: #555555;">Pourcentage</th>
        </tr>
		
		
		
		<?php		
                for($i; $i < count($ops_res); $i++) {
				   
				   $tp += ($ops_res[$i]['operation_montant'] / $tdo) * 100;
				   $pi[] = ($ops_res[$i]['operation_montant'] / $tdo) * 100;
                				 
			    }
				

		?>
		
		<?php 
		          for($j; $j < count($ops_res); $j++) {
	     ?>
		 
        <tr>
	        <td><?php echo $ops_res[$j]['operation_id']; ?></td>
	        <td><?php echo $ops_res[$j]['operation_libele']; ?></td>
	        <td>
			       <?php 
				       echo number_format($ops_res[$j]['operation_montant'], 2, ".", " ");    					   
			       ?>
		    </td>		
	        <td>
			    <?php
                       
						 echo date_format(date_create($ops_res[$j]['opdate_date']), 'd/m/Y H:m:i');
                       					   
				?>
			</td>
					
			
          <td <?php if($pi[$j] == max($pi)) echo 'style="background-color: #FF0000;"'; else if($pi[$j] == min($pi)) echo 'style="background-color: gray;"'; ?>>
			    <?php
				        
						echo number_format($pi[$j], 3, ".", "").'%';
					 
				?>
			</td>
		
		 </tr> 
		 
		<?php } ?>
		
         
		 <tr class="trtp">
			<td colspan="2" style="background-color: #b5ecb5"><center><strong>Total Opération</strong></center></td>
			<td style="background-color: #EEB111;">
			    <?php
                    
					if(isset($filter_tdo))
						echo number_format($filter_tdo, 2, ".", " ");
					else
						echo number_format($tdo, 2, ".", " ");
                     					 
				 ?>
		    </td>
			
			<td style="background-color: #b5ecb5">
			   
		    </td>
			
			<td style="background-color: #b5ecb5">
			    <?php
                    			
					echo number_format($tp, 3, ".", " ").'%';
                     					 
				 ?>
		    </td>
			
			
		</tr>
		
		
		 
</table>

    <?php if($montpro > 0) { ?>

<div style="margin-right: 300px;">
<strong style="margin-left: -220px; font-size: 1.2em;">Résultat net</strong>
 <table border="2 solid #ccc" width="30%;" style="background-color: #ccc; width: 50%;">
     <tr>
	     <td><strong>Montant total du projet (TTC)</strong></td>
		 <td><strong><?php echo number_format($montpro, 2, ".", " "); ?></strong></td>
	 </tr>
	 <tr>
	     <td><strong>Dépenses total effectuées</strong></td>
		 <td style="background-color: #EEB111;"><strong><?php echo number_format($tdo, 2, ".", " "); ?></strong></td>
	 </tr>
	 <tr>
	     <td><strong>Resultat net</strong></td>
		 <td style="background-color: #fbf11f;"><strong><?php echo number_format($montpro - $tdo, 2, ".", " "); ?></strong></td>
	 </tr>
 </table>
 
     <?php 
	     $te = ($tdo / $montpro * 100);
         $col = ($te < 100.0) ? 'green' : 'red';		 
	 ?> 
   <h3><u>Soit un taux d'exécution total de</u>   &nbsp;<span style="color: <?php echo $col; ?>;"><?php echo number_format($te, 3, ".", " ").'%'; ?></span></h3>

   </div>

   <?php } ?>
   
   
   <?php
        
	    $chart = new PieChart(500, 250);

	   $dataSet = new XYDataSet();
	   	
		for($k = 0; $k < count($ops_res); $k++) {
		    $dataSet->addPoint(new Point($ops_res[$k]['operation_libele'], $pi[$k]));
		}
			
	   $chart->setDataSet($dataSet);

	  $chart->setTitle("Repartition par depenses");
	  $chart->render("assets/img/out.png");   
		
?>
   
   
   <div style="float: right; margin-right: 20px; margin-top: -160px; margin-top: 5px;">
       <img src='assets/img/out.png' />
   </div>
   
   <p>
	     <form>
	          <button style="margin-top: 20px;" class="btn btn-primary btn-mini" type="button" onclick="imprimer_page()" name="impression">Imprimer  <i class="icon icon-print icon-white"></i></button>
		  </form>
   </p>
   
   <a href="bord.php?idp=<?php echo $idp; ?>"><button class="btn btn-primary">Voir detail (Bordereau des depenses)</button></a> 
   

     <?php 
	        } else if (isset($_GET['idp']) && !empty($_GET['idp']) && is_projet_exist(htmlspecialchars($_GET['idp'])) == true) {
			     
				        $id =  (int) trim(htmlspecialchars($_GET['idp']));
		
					    $projet = infos_projet($id);
						$projet_id = $projet['id_projet'];
			
			     echo '<center><h4>Le projet <span
				 style="color: #08c;">'.$projet['objet_projet'].'</span> n\'a pas de données d\'operation, donc aucun aperçu de resultat ne peut être affiché!</h4><br/></center>';
				 echo '<center><a href="ops.php"><button style="margin-top: 20px;" class="btn btn-mini btn-primary" type="button"><i class="icon icon-arrow-left icon-white"></i>  Ajouter des données d\'operation</button></a></center>';
			} else {
			  echo '<center><h3 style="color: red;">Erreur: Aucun projet selectioné!</h3><br/></center>';
			}
        ?>
	
	
   <center>
	  <p>
		  <a href="index.php"><button style="margin-top: 20px;" class="btn btn-primary btn-mini" type="button">Accueil  <i class="icon icon-home icon-white"></i></button></a>
		  &nbsp;
		  <?php if(isset($idp) && $idp != NULL)  { ?>
               		      <a href="ops.php"><button style="margin-top: 20px;" class="btn btn-mini btn-primary" type="button">Nouvelle donnée d'opération</button></a>
		  <?php } ?>
		  &nbsp;
		  <a href="nouveau_projet.php"><button style="margin-top: 20px;" class="btn btn-mini btn-primary" type="button">Créer un nouveau projet</button></a>
		  
      </p>

    </center>



<?php include 'footer.php'; ?>
