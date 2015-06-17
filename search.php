<?php
    
	$p = '';
	$s = '';
	
	require_once 'header.php';
    require_once 'model.php';
    
	start_session();
    logout_protected();
	expired();

   

    if (isset($_GET['pro']) && !empty($_GET['pro']) && isset($_GET['se']) && !empty($_GET['se']) &&  strlen(trim($_GET['se'])) >= 1 ) {
        $search_term = htmlspecialchars($_GET['se']);
		$pro_name = htmlspecialchars($_GET['pro']);
		$pid = getProIdByName($pro_name);
        $sql = build_query($search_term);
		$result = getSearchResult($sql, $pid);
		
		$nb_result = count($result);
				
	?>

	
	
	<center>
    
	
		<p style="margin-top: -30px; margin-bottom: 30px;">
		    <u>
		        La recherche "<em><strong><?php echo $search_term; ?></strong></em>" a retourné  
				<strong>
				    <?php if($nb_result > 1) echo $nb_result.' resultats'; else echo $nb_result.' resultat'; ?>
			   </strong>
		    </u>
	    </p>
			 
			 <table border="2 solid #ccc">
			     <tbody>
			         <tr>   
					   <td><h1>Projet: <?php echo $pro_name; ?></h1></td>
				     </tr>
				 </tbody>
		     </table>
			 
		<div style="width: 90%; margin-left: 5px; margin-top: 20px;"  class="panel panel-default">
		
    <table class="table table-bordered table-hover">
	
	    <thead class="tbody">
	    <tr>
	        <th>Code operation</th>
			<th>Date</th>
			<th>Designation</th>
			<th>Mode payement</th>
			<th>Montant</th>
        </tr>
		</thead>
		
		
		
		<?php 
		          
					  foreach($result as $re) {
					  
	     ?>
		 
		 <tbody class="tbody">
		 
        <tr>
	        <td><?php echo $re['operation_code']; ?></td>
			<td><?php echo $re['operation_formated_date']; ?></td>
			<td><?php echo $re['operation_libele']; ?></td>
			<td><?php echo $re['operation_mode_pay']; ?></td>
			<td><?php echo number_format($re['operation_montant'], 0, ".", " "); ?></td>
		</tr>
		
		 </tbody>
		
		<?php } ?>
		
		 
</table>

 </div>
 
 <?php } else { ?>
 
     <p><center  style="margin-bottom: 40px;">Veuillez selectionner un projet <strong>ET</strong> entrez l'operation recherchée.</center></p>
<?php } ?>
	
</center>
	
	
	
<?php include 'footer.php'; ?>