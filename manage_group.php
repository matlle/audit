<?php
    require_once 'header.php';
	require_once 'model.php';
	
	
	start_session();
    logout_protected();
	expired();
	
	$cid = getUserIdByName($_SESSION['login']);
	$cid = $cid['id_utilisateur'];
	super_protected($_SESSION['login'], $cid);
	
	$i = 0;
	
	$accounts = getAllAccounts();

	
?>

    <center>
               
			   
			   <?php
			                  if(isset($_SESSION['saved_group'])) {
			                      echo '<em><h3 style="color: #8AC007;">'.$_SESSION['saved_group'].'</h3></em>';
				                  unset($_SESSION['saved_group']);
                              }
                              
                              if(isset($_SESSION['updated_group'])) {
			                      echo '<em><h3 style="color: #8AC007;">'.$_SESSION['updated_group'].'</h3></em>';
				                  unset($_SESSION['updated_group']);
                              }

                              if(isset($_SESSION['removed_group'])) {
			                      echo '<em><h3 style="color: #8AC007;">'.$_SESSION['removed_group'].'</h3></em>';
				                  unset($_SESSION['removed_group']);
		                      }


			    ?>
			   
	
	          <h4 style="color: #08c;">Liste des services</h4>
	
	
	     <div style="margin-right: 215px; margin-bottom: 50px;" class="">		
                    <a href="create_group.php" class="btn btn-sm btn-info pull-right post">
                	    <i class="icon icon-plus-sign icon-white"></i> Ajouter un service</a>
              </div>
	
	
	     <div class="container main-container">
     
	 
<div class="col-md-12">
            			
       
            		
             <div class="panel-body">
            				
                            
    	<table class="table table-bordered table-hover table-striped">
    
                									<thead class="tbody">
                                                      <tr>
                                                        <th><div class="text-center">ID.</div></th>
                                                        <th><div class="text-center">Nom service</div></th>
                                                        <th><div class="text-center">Créer par</div></th>
                                                        <th><div class="text-center">Date saisie service</div></th>
                                                        <th style="color: white; background-color: #aaa;"><div class="text-center">Actions</div></th>
                                                      </tr>
                                                    </thead>
    
                <tbody class="tbody">
				
				    <?php	    
                        for($i; $i < count($accounts); $i++) {
						
					?>
				             
                	  <tr>
                            <td><div class="text-center"><?php echo $accounts[$i]['account_id']; ?></div></td>
                            <td><a href="service.php?aid=<?php echo $accounts[$i]['account_id']; ?>"><div class="text-center"><?php echo $accounts[$i]['account_type']; ?></div></a></td>
                            <td><div class="text-center"><?php echo $accounts[$i]['created_by']; ?></div></td>
                            <td><div class="text-center"><?php
																						  $date = date_create($accounts[$i]['account_created_at']);
							                                                              echo date_format($date, 'j F Y  H:i:s');
                                                                                																						  
																			?></div></td>
                            <td>
							    
								<div class="btn-group">
                                        <a class="btn btn-primary" href="#"><i class="icon-user icon-white"></i><i class="icon-user icon-white"></i> Service</a>
                                        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                        <li><a href="update_group.php?aid=<?php echo $accounts[$i]['account_id']; ?>"><i class="icon-pencil"></i> Modifier</a></li>
										<?php if(IsSuperUser($_SESSION['login'])) { ?>
                                        <li><a href="remove_group.php?aid=<?php echo $accounts[$i]['account_id']; ?>"><i class="icon-trash"></i> Supprimer</a></li>
										<?php } ?>
										<li><a href="loggroup.php?oid=<?php echo $accounts[$i]['account_id'].'&in='.$accounts[$i]['account_type']; ?>"><i class=" icon-th"></i>  Historique</a></li>
                                        </ul>
                                  </div>
								
						    </td>
                            
                    </tr>
                  
				  <?php } ?>
					
                </tbody>
                
    	</table>
            			
                        
                   	</div>
                    
                    
            </div><!--End panel-default-->
        	
</div><!--End col-md-12-->
            
            
           	</div>

				                    				   
		
		<p>
		    &nbsp; <a href="liste_projet.php"><button style="margin-top: 20px;" class="btn btn-mini btn-primary" type="button"><i class="icon icon-arrow-left icon-white"></i>  Retour</button></a>
			&nbsp; <a href="liste_projet.php"><button style="margin-top: 20px;" class="btn btn-mini btn-primary" type="button">Liste des projets</button></a>
		</p>

		
		
	  
	</center>


<?php include 'footer.php'; ?>
