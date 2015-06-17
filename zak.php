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
                                                        <li><a href="bord.php?idp=<?php echo $p['id_projet']; ?>"><?php echo $p['objet_projet']; ?></a>
                                                       </li>
                                                            <?php } ?>
                                                    <?php } ?>
                                        </ul>
										
                                      										
										
                               </div>
             
             
             
             
             
                 
             </div>
            <table border="2 solid #ccc">
                <tr><td><h1>BORDERAU GENERAL DES DEPENSES</h1></td><tr/>
            </table>
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
	


         <div>
                 <?php
				                  $months = array();
								  
								  $flag = 0;
						
                         
                 ?>
         </div>
                 
         
         
                  <!-- start nested rubrique loop -->
                  <?php
                         $rubriques = listRubByPro($idp);
                         foreach($rubriques as $rubrique) {
                         
                                   
                  ?>
                  <div style="width: 20%; margin-left: 0px; margin-bottom: 10px; margin-top: 50px;"><h4><span  style="background-color: <?php echo randomColor2(); ?>;"><?php echo $rubrique['rubrique_name']; ?></span></h4></div>
				                     
                    <div style="background-color: ; width: 70%; margin-left: 100px;"  class="panel panel-default">
					     
						    
                         <table class="table table-bordered table-hover" border="1 solid #ccc">
						 
						      <thead class="tbody">
                              <tr>
                                  <th>Code op.</th>
                                  <th>Date</th>
                                  <th>Designation</th>
                                  <th>Montant</th>
								  
                              </tr>
							  </thead>
							  
							       <?php      
								                   $p = '';
									               $ops = listOpByRubAndByPro($rubrique['rubrique_name'], $idp);
												   foreach($ops as $op) {
												       $p = $op;
									  ?>
						     <tbody class="tbody">
                              <tr>
                              <td><?php echo $op['operation_code']; ?></td>
                              <td><?php echo $op['operation_formated_date'];?></td>
                              <td><?php echo $op['operation_libele']; ?></td>
                              <td><?php echo $op['operation_formated_montant']; ?></td>
                              </tr>
							  
							   <?php if ($op === end($ops)) $flag = 1; ?>
							  
							       <?php if($flag == 1) { ?>
								       <tr>
									       <td colspan="3" ><center><em><h5>TOTAL</em></h5></center></td>
									       <td style="background-color: #eee;"><h4><?php echo number_format(totalOpByRub($idp, $rubrique['rubrique_name']), 0, ".", " "); ?></h4></td>
									   </tr>
									<?php $flag = 0; } ?>
								   
							  </tbody>
                               
							  
							   
							   
							   <?php } ?>
							   
                         </table>
						 
                    </div>
						    
                   
                
               <?php } ?> <!-- end nested rubrique loop -->
                 
				 
				 

         </div> <!-- end bord -->
         
         <?php //} ?> <!-- end main foreach loop -->


		<?php if ($montpro > 0) { ?>
		 
<div style="margin-right: 300px;">
<strong style="margin-left: -220px; font-size: 1.2em;">Résultat net</strong>
 <table border="2 solid #ccc" width="30%;" style="background-color: #ccc; width: 50%;">
     <tr>
	     <td><strong>Montant projet</strong></td>
		 <td><strong><?php echo number_format($montpro, 2, ".", " "); ?></strong></td>
	 </tr>
	 <tr>
	     <td><strong>Dépenses effectuées</strong></td>
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
   <h3><u>Soit un taux d'exécution de</u>   &nbsp;<span style="color: <?php echo $col; ?>;"><?php echo number_format($te, 3, ".", " ").'%'; ?></span></h3>

   </div>
  
    <?php } ?>
   
   <p>
	     <form>
	          <button style="margin-top: 20px;" class="btn btn-primary btn-mini" type="button" onclick="imprimer_page()" name="impression">Imprimer  <i class="icon icon-print icon-white"></i></button>
		  </form>
   </p>
   
   <a href="c_resultats.php?idp=<?php echo $idp;?>"><button class="btn btn-primary">Voir aperçu de resultat</button></a>
   

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
