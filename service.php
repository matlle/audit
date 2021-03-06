<?php
    require_once 'header.php';
	require_once 'model.php';
	
	
	start_session();
    logout_protected();
	expired();
	
	$cid = getUserIdByName($_SESSION['login']);
	$cid = $cid['id_utilisateur'];
    //super_AND_chef_protected($_SESSION['login'], $cid);
	super_protected($_SESSION['login'], $cid);
	
	$i = 0;
	

    if(isset($_GET['aid']) && !empty($_GET['aid']) && is_account_exist(htmlspecialchars($_GET['aid'])) == true) {
					    
	    $aid =  (int) trim(htmlspecialchars($_GET['aid']));
		
		$users = getAllUsersByAccount($aid);
		$account = getAccountById($aid);
										

	
?>

    <center>
               
			   
			   <?php
			                  if(isset($_SESSION['saved_user'])) {
			                      echo '<em><h3 style="color: #8AC007;">'.$_SESSION['saved_user'].'</h3></em>';
				                  unset($_SESSION['saved_user']);
		                      }

                             if(isset($_SESSION['removed_user'])) {
			                      echo '<em><h3 style="color: #8AC007;">'.$_SESSION['removed_user'].'</h3></em>';
				                  unset($_SESSION['removed_user']);
		                      }

                             if(isset($_SESSION['updated_user'])) {
			                      echo '<em><h3 style="color: #8AC007;">'.$_SESSION['updated_user'].'</h3></em>';
				                  unset($_SESSION['updated_user']);
		                      }

                             


			    ?>
			   
	
	          <h4>Liste d'utilisateurs du service <span style="color: #08c;"><?php echo $account['account_type']; ?></span></h4>
	
	
	     <div style="margin-right: 215px; margin-bottom: 50px;" class="">		
                    <a href="create_user_in_account.php?aid=<?php echo $account['account_id']; ?>" class="btn btn-sm btn-info pull-right post">
                	    <i class="icon icon-plus-sign icon-white"></i> Ajouter un utilisateur au service <?php echo $account['account_type']; ?></a>
              </div>
	
	
	     <div class="container main-container">
     
	 
<div class="col-md-12">
            			
       
            		
             <div class="panel-body">
            				
                            
    	<table class="table table-bordered table-hover table-striped">
    
                									<thead class="tbody">
                                                      <tr>
                                                        <th><div class="text-center">ID.</div></th>
                                                        <th><div class="text-center">Matricule</div></th>
                                                        <th><div class="text-center">Nom</div></th>
                                                        <th><div class="text-center">Mot de passe</div></th>
                                                        <th><div class="text-center">Service</div></th>
														<th><div class="text-center">Est chef de service?</div></th>
														<th><div class="text-center">Créer par</div></th>
														<th><div class="text-center">Date saisie</div></th>
                                                        <th style="color: white; background-color: #aaa;"><div class="text-center">Actions</div></th>
                                                      </tr>
                                                    </thead>
    
                <tbody class="tbody">
				
				    <?php	    
                        for($i; $i < count($users); $i++) {
						
					?>
				             
                	  <tr>
                            <td><div class="text-center"><?php echo $users[$i]['id_utilisateur']; ?></div></td>
                            <td><div class="text-center"><?php echo $users[$i]['matricule']; ?></div></td>
                            <td><div class="text-center"><?php echo $users[$i]['login']; ?></div></td>
                            <td><div class="text-center"><?php echo $users[$i]['password']; ?></div></td>
                            <td><div class="text-center"><?php  $aname = getAccountById($users[$i]['account_id']); 
							                                                              echo $aname['account_type']; ?></div>
							</td>
							<td><div class="text-center"><?php if($users[$i]['account_chef'] > 0)
 							                                                 echo '<span class="badge badge-warning">Oui</span> '; else echo 'Non'; ?>
																			 </div></td>
							<td><div class="text-center"><?php echo $users[$i]['created_by']; ?></div></td>
                            <td><div class="text-center"><?php
																						  $date = date_create($users[$i]['date_saisie_user']);
							                                                              echo date_format($date, 'j F Y  H:i:s');
                                                                                																						  
																			?></div></td>
                            <td>
							    
								<div class="btn-group">
                                        <a class="btn btn-<?php 
										                                  if(isUserIsChef($users[$i]['id_utilisateur'])) 
																		      echo 'warning';
                                					                       else if(IsUserIsDg($users[$i]['id_utilisateur']))
																		       echo 'danger';
																		   else if(IsSuperUser($users[$i]['login']))
																		       echo 'inverse';
																		   else echo 'success'; 
																		 ?>" href="#"><i class="icon-user icon-white"></i> Utilisateur</a>
										<?php if(IsUserIsDg($users[$i]['id_utilisateur']) === false && IsSuperUser($users[$i]['login']) === false ) { ?>	 
																	
                                        <a class="btn btn-info dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
                                        <ul class="dropdown-menu">

                                        <?php $p = basename($_SERVER['PHP_SELF']).'?aid=';?>

                                        <li><a href="update_user.php?uid=<?php echo $users[$i]['id_utilisateur'].'&p='.$p.'&aid='.$aid; ?>"><i class="icon-pencil"></i> Modifier</a></li>

                                        <?php $p = basename($_SERVER['PHP_SELF']).'?aid='.$aid;?>
										
										<?php if(IsSuperUser($_SESSION['login'])) { ?>
                                        <li><a href="remove_user.php?uid=<?php echo $users[$i]['id_utilisateur'].'&p='.$p; ?>"><i class="icon-trash"></i> Supprimer</a></li>
										<?php } ?>
										<li class="divider"></li>
                                        <li><a href="loguser.php?oid=<?php echo $users[$i]['id_utilisateur'].'&in='.$users[$i]['matricule'].' - '.$users[$i]['login']; ?>"><i class=" icon-th"></i> Historique</a></li>
										<?php
                                                    if(isUserIsChef($users[$i]['id_utilisateur']) === false && accountHasChef($users[$i]['id_utilisateur'], $users[$i]['account_id']) === false) {
                                                          $tuid = $users[$i]['id_utilisateur'];
                                                          $taid = $users[$i]['account_id'];
                                                          $tpp = basename($_SERVER['PHP_SELF']);
                                                          $p = $aid;								  
										?>
                                        <li class="divider"></li>
                                        <li><a href="dochef.php?aid=<?php echo $taid.'&uid='.$tuid.'&pp='.$tpp.'&paid='.$p; ?>"><i class=" icon-star"></i> Faire chef de service</a></li>
										
										<?php } ?>
										
                                        </ul>
										
										<?php } ?>
										
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
			
			 
			 <?php
                          } else {
						          echo "<span style='color: red;'>Error: Aucun service selectionné</span>";
                          }						  
			 ?>
				          
		
		<p>
		    &nbsp; <a href="manage_group.php"><button style="margin-top: 20px;" class="btn btn-mini btn-primary" type="button"><i class="icon icon-arrow-left icon-white"></i>  Retour</button></a>
			&nbsp; <a href="liste_projet.php"><button style="margin-top: 20px;" class="btn btn-mini btn-primary" type="button">Liste des projets</button></a>
		</p>

		
		
	  
	</center>


<?php include 'footer.php'; ?>
