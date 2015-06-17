<?php
    require_once 'header.php';
	require_once 'model.php';
	
	
	start_session();
    logout_protected();
	expired();
	
	$i = 0;
	

    if(isset($_GET['oid']) && !empty($_GET['oid']) && isset($_GET['in']) && !empty($_GET['in'])) { 
					    
	    $oid =  (int) trim(htmlspecialchars($_GET['oid']));
	    $info =  (string) trim(htmlspecialchars($_GET['in']));

        $history = getLogAutresfraisExecution($oid);

        if(count($history) > 0) {


 ?>

              <center>               
	
	          <h4>Changement(s) effectué(s) sur <span style="color: #08c;"><?php echo $info; ?></span></h4>
	
	
	
	     <div class="container main-container">
     
	 
<div class="col-md-12">
            			
       
            		
             <div class="panel-body">
            				
                            
    	<table class="table table-bordered table-hover table-striped">
    
             									<thead class="tbody">
                                                      <tr>
                                                        <th><div class="text-center">Date/heure</div></th>
                                                        <th><div class="text-center">Utilisateur</div></th>
                                                        <th><div class="text-center">Actions</div></th>
                                                      </tr>
                                                    </thead>
    
                <tbody class="tbody">
				
				    <?php	    
                        for($i; $i < count($history); $i++) {
						
					?>
				             
                	  <tr>
                      <td><div class="text-center">
                                              <?php 
                                                  $date = date_create($history[$i]['log_autresfrais_execution_time']);
                                                 echo date_format($date, 'j F Y H:i:s'); 
                                              ?>
                     </div></td>
                            <td><div class="text-center"><?php 
                                                               
                                                               $clogin = getUserById($history[$i]['log_autresfrais_execution_current_user_id']);    
                                                               echo $clogin['login']; 
                                                         ?>
                            </div></td>
                            <td><div class="text-center"><?php echo $history[$i]['log_autresfrais_execution_msg']; ?></div></td>
                            
                    </tr>
                  
				  <?php } ?>
					
                </tbody>
                
    	</table>
            			
                        
                   	</div>
                    
                    
            </div><!--End panel-default-->
        	
</div><!--End col-md-12-->
            
            
           	</div>
			
			 
			 <?php
              } else { 
                  echo '<h4>Accun changement effectué sur <span style="color: #08c;">'.$info.'</span></h3>'; 
              } 
         } else {
						   echo "<span style='color: red;'>Error: Aucun frais selectionné</span>";
              }						  
			 ?>
				          
		
		<p>
		    &nbsp; <a href="#"><button style="margin-top: 20px;" class="btn btn-mini btn-primary" type="button"><i class="icon icon-arrow-left icon-white"></i>  Retour</button></a>
			&nbsp; <a href="liste_projet.php"><button style="margin-top: 20px;" class="btn btn-mini btn-primary" type="button">Liste des projets</button></a>
		</p>

		
		
	  
	</center>


<?php include 'footer.php'; ?>
