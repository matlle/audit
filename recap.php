<?php
    require_once 'header.php';
    require_once 'model.php';
    
	
	start_session();
    logout_protected();
	expired();
	
	$i = 0;
	$j = 0;
	
	
	    if(isset($_GET['pn']) && !empty($_GET['pn'])  && isset($_GET['y']) && !empty($_GET['y'])) {
					    
					   $pname =  (string) trim(htmlspecialchars($_GET['pn']));
					   $year =  (int) trim(htmlspecialchars($_GET['y']));
					   
					   $spro = getProByName($pname);
					   
					   $montpro = $spro['montant_ht_projet'] + ($spro['montant_ht_projet'] * $spro['taux'] / 100);
					   
					   $tdo = totalDepByProAndPyYear($year, $pname);
					   				   
	
?>


        <center>
    
	
		<h3><u>Résulat d'opérations pour l'année <strong style="color: #0099cc;"><?php echo $year; ?></strong></u></h3>
			 
			 <table border="2 solid #ccc">
			     <tbody>
			         <tr>   
					   <td><h1>Projet: <?php echo $pname; ?></h1></td>
				     </tr>
				 </tbody>
		     </table>
			 
		<div style="width: 90%; margin-left: 5px; margin-top: 20px;"  class="panel panel-default">
		
    <table class="table table-bordered table-hover">
	
	    <thead class="tbody">
	    <tr>
	        <th>Rubrique</th>
			<th>Montant</th>
			<th>Pourcentage</th>
        </tr>
		</thead>
		
		
		
		<?php 
		          
		              $rubriques = listRubByYearAndByPro($year, $pname);
					  
					  foreach($rubriques as $rub) {
					  
	     ?>
		 
		 <tbody class="tbody">
		 
        <tr>
	        <td><?php echo $rub['rubrique_name']; ?></td>
			<td><?php echo number_format(totalRubByYearByPro($year, $rub['rubrique_name'], $pname), 0, ".", " ");?></td>
			<td><?php 
			                $pou = (totalRubByYearByPro($year, $rub['rubrique_name'], $pname) / $tdo) * 100;
							echo number_format($pou, 3, ".", " ");
					?>
			</td>
		</tr>
		
		 </tbody>
		
		<?php } ?>
		
		 
</table>

 </div>
 
 
     
    <?php if($montpro > 0) { ?>

<div style="margin-right: 300px;">
<strong style="margin-left: -220px; font-size: 1.2em;">Résultat net</strong>

 <table border="2 solid #ccc"  class="table table-bordered table-hover"  width="30%;" style="background-color: #ccc; width: 50%;">
     <tbody>
     <tr>
	     <td><strong>Montant projet</strong></td>
		 <td><strong><?php echo number_format($montpro, 0, ".", " "); ?></strong></td>
	 </tr>
	 <tr>
	     <td><strong>Total des dépenses</strong></td>
		 <td style="background-color: #EEB111;"><strong><?php echo number_format($tdo, 0, ".", " "); ?></strong></td>
	 </tr>
	 <tr>
	     <td><strong>Resultat net</strong></td>
		 <td style="background-color: #fbf11f;"><strong><?php echo number_format($montpro - $tdo, 0, ".", " "); ?></strong></td>
	 </tr>
	 </tbody>
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
   

     <?php 
			} else {
			  echo '<center><h3 style="color: red;">Erreur: Aucun projet selectionné!</h3><br/></center>';
			}
        ?>
	

 <center>	
       
	   <a href="choose_pro_on_year.php"><button style="margin-top: 10px; margin-bottom: 10px;" class="btn btn-mini btn-primary" type="button"><i class="icon icon-arrow-left icon-white"></i>  Retour</button></a>
	   
	  <p>
		  <a href="index.php"><button style="margin-top: 20px;" class="btn btn-primary btn-mini" type="button">Accueil  <i class="icon icon-home icon-white"></i></button></a>
		  <a href="nouveau_projet.php"><button style="margin-top: 20px;" class="btn btn-mini btn-primary" type="button">Créer un nouveau projet</button></a>
		  
      </p>

    </center>



<?php include 'footer.php'; ?>