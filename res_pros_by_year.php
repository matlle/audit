<?php
    require_once 'header.php';
    require_once 'model.php';
    
	
	start_session();
    logout_protected();
	expired();
	
	$i = 0;
	$j = 0;
	
	
	    if(isset($_GET['y']) && !empty($_GET['y'])) {
					    
					   $year =  (int) trim(htmlspecialchars($_GET['y']));
	
	                   $f = liste_projets_by_year($year);
					   $projets = array();
					   $n = 0;
					   for($n; $n < count($f); $n++) {
					       if(is_projet_has_donnee_execution($f[$n]['id_projet']) === true)
					        $projets[] = $f[$n];
						   //else if(is_projet_has_donnee_operation($f[$n]['id_projet']) === true)
						    //   $projets[] = $f[$n];
					   }
	          	       					   
					   
					   $tmht = 0.0;
                       $tdepex = 0.0;
                       $trnet = 0.0;
                       $tmttc = 0.0;					   
					   
	
?>


        <center>
    
	
		<h3><u>Résulat d'exécution de <strong style="color: #0099cc;"><?php echo count($projets); ?> projet(s)</strong> pour l'année <strong style="color: #0099cc;"><?php echo $year; ?></strong></u></h3>
			 
			
			 
		</div>
		
    <table border="2 solid #ccc" class="tbliste table table-striped">
	
	    <tr>
	        <th style="color: white; background-color: #555555;">Id projet</th>
			<th style="color: white; background-color: #555555;">Objet projet</th>
	        <th style="color: white; background-color: #555555;">Date</th>		
	        <th style="color: white; background-color: #555555;">Montant HT</th>
			<th style="color: white; background-color: #555555;">Taxe</th>		
	        <th style="color: white; background-color: #555555;">Montant TTC</th>
			<th style="color: white; background-color: #555555;">Dépense exécutée</a></th>
            <th style="color: white; background-color: #555555;">Résulat Net</th>
            <th style="color: white; background-color: #555555;">Taux execution</th>
        </tr>
		
		
		
				
	
		
		<?php 
		          
		          for($j; $j < count($projets); $j++) {
				  
				      if(is_projet_has_donnee_execution($projets[$j]['id_projet']) === true) {
					  
	     ?>
		 
        <tr>
	        <td><?php echo $projets[$j]['id_projet']; ?></td>
			<td><?php echo $projets[$j]['objet_projet']; ?></td>
	        <td><?php echo date_format(date_create($projets[$j]['date_projet']), 'd/m/Y'); ?></td>
	        <td>
			       <?php 
				       $mht = $projets[$j]['montant_ht_projet'];
					   $tmht += $mht;
					   echo number_format($mht, 2, ".", " ");
					  
                        					   
			       ?>
		    </td>		
	        <td>
			    <?php
                         
						 echo ucfirst($projets[$j]['taxe_projet']).'('.$projets[$j]['taux'].'%)';
                       					   
				?>
			</td>
			<td>
			     <?php
                          $taxe = ($projets[$j]['taux'] / 100) * $projets[$j]['montant_ht_projet'];
                          $mttc = $projets[$j]['montant_ht_projet'] + $taxe;
                          $tmttc += $mttc; 						  
						 echo number_format($mttc, 2, ".", " ");
                       					   
				?>
		    </td>
            
					
	        <td>
			    <?php 
                       $dex = DepexByPro($projets[$j]['id_projet']);					   
					   $tdepex += $dex;
					   echo number_format($dex, 2, ".", " ");
					                          					   
			    ?>		
	        <td>
			    <?php 
				       $rnet = $mttc - $dex;
					   $trnet += $rnet;
					   echo number_format($rnet, 2, ".", " ");
                        					   
			    ?>
			</td>
			<td>
			    <?php
				     
					 echo number_format(($dex/$mttc) * 100, 3, ".", " ").'%';
                     
				?>
			</td>		
			
					
    
		
		 </tr> 
		 
		<?php } ?>
		
		<?php } ?>
		
		
		 <tr class="trtp">
			<td colspan="2" style="background-color: #b5ecb5"><center><strong>Total depenses année <?php echo $year; ?></strong></center></td>
			
			<td style="background-color: white;">
		    </td>
			
			<td style="background-color: #5be7a7;">
			     <?php
                    				
					echo number_format($tmht, 2, ".", " ");
                     					 
				 ?>
		    </td>
			
			<td style="background-color: white;">
			</td>
			
			<td style="background-color: #B8FF5C;">
			    <?php
                    				
					echo number_format($tmttc, 2, ".", " ");
                     					 
				 ?>
		    </td>
			
			<td style="background-color: #b5ecb5;">
			    <?php
                    				
					echo number_format($tdepex, 2, ".", " ");
                     					 
				 ?>
		    </td>
			
			<td style="background-color: #EEB111;">
			    <?php
                    		
					echo number_format($trnet, 2, ".", " ");
                     					 
				 ?>
		    </td>
			
			
			
		</tr>
		
		
		
		 
</table>


<strong style="margin-left: -250px; font-size: 1.2em;">Résultat net <?php echo $year; ?></strong>
 <table border="2 solid #ccc" width="30%;" style="background-color: #ccc;">
     <tr>
	     <td><strong>Montant des projets</strong></td>
		 <td><strong><?php echo number_format($tmttc, 2, ".", " "); ?></strong></td>
	 </tr>
	 <tr>
	     <td><strong>Dépenses exécutées</strong></td>
		 <td style="background-color: #b5ecb5;"><strong><?php echo number_format($tdepex, 2, ".", " "); ?></strong></td>
	 </tr>
	 <tr>
	     <td><strong>Resultat net</strong></td>
		 <td style="background-color: #EEB111;;"><strong><?php echo number_format($trnet, 2, ".", " "); ?></strong></td>
	 </tr>
 </table>
 
     <?php
	     if($tmttc == 0) {
		     $te = 0;
			 $col = 'green';
		} else {
	     $te = ($tdepex / $tmttc) * 100;
		 //$te = 100.01;
         $col = ($te < 100.0) ? 'green' : 'red';
        }		 
	 ?> 
   <h3><u>Soit un taux d'exécution de</u>   &nbsp;<span style="color: <?php echo $col; ?>;"><?php echo number_format($te, 3, ".", " ").'%'; ?></span></h3>


   
	  <p>
	      <form>
	          <button style="margin-top: 20px;" class="btn btn-primary btn-mini" type="button" onclick="imprimer_page()" name="impression">Imprimer  <i class="icon icon-print icon-white"></i></button>
		  </form>
	  </p>
   

     <?php 
			} else {
			  echo '<center><h3 style="color: red;">Erreur: Aucune date selectionée!</h3><br/></center>';
			}
        ?>
	

 <center>	

	  <p>
		  <a href="index.php"><button style="margin-top: 20px;" class="btn btn-primary btn-mini" type="button">Accueil  <i class="icon icon-home icon-white"></i></button></a>
		  <a href="nouveau_projet.php"><button style="margin-top: 20px;" class="btn btn-mini btn-primary" type="button">Créer un nouveau projet</button></a>
		  
      </p>

    </center>



<?php include 'footer.php'; ?>