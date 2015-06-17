<?php 
           require_once 'model.php'; 

           start_session();
           logout_protected();
           expired();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Faj - Enregistrement des depenses sur projets</title>
    
    <!-- bootstrap frameworks -->
    <link href="assets/css/opscss/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/opscss/bootstrap-theme.min.css" rel="stylesheet" type="text/css">
	<!-- <link href="assets/css/bootstrap-responsive.min.css" rel="stylesheet"> -->
    
    <!-- custom style -->
    <link href="assets/css/opscss/style.css" rel="stylesheet" type="text/css">
    
    <link href="assets/css/opscss/dataTables.bootstrap.css" rel="stylesheet">
    <link href="assets/css/opscss/jquery-ui.min.css" rel="stylesheet">
    
    
  </head>
  
  <body>
  
                     <center>
         <a href="index.php"><img src="assets/img/logo.jpg" style="margin-top: 30px;"></a>
         <div style="margin-top: 5px; margin-bottom: 0px; margin-left: 70px;">
		 
		      <?php if(is_logged() === true) { ?> 
		      <div class="input-append">
			     <form method="get" action="search.php" class="form-inline">
				   <?php
				                  $pros = liste_projets();
                                  foreach($pros as $p) {
		                              if(is_projet_has_donnee_operation($p['id_projet']) === true)
			                              $projets[] = $p;
                                  }										  
				   ?>
			      <select name="pro" class="form-control">
				           <?php   
						                if(isset($_GET['pro']))  $pro_select = $_GET['pro'];
                                        foreach($projets as $pi) {
                                             if(isset($pro_select)) {
											     if($pi['objet_projet'] == $pro_select)
											         echo '<option selected="selected">'.$pi['objet_projet'].'</option>';
												 else
												     echo '<option>'.$pi['objet_projet'].'</option>';
											 } else 
                                                   echo '<option>'.$pi['objet_projet'].'</option>';
                                        }											 
					         ?> 
				  </select>
                  <input class="form-control input-medium" type="text" name="se" placeholder="Rechercher operation" value="<?php if(isset($_GET['se'])) echo $_GET['se']; ?>">
                  <button type="submit" class="btn btn-default"><i class="icon icon-search"></i> Rechercher</button>
                 </form>
              </div>
			  <?php } ?>
			  
		     <?php //if(isset($_SESSION['section'])) echo 'Service '.$_SESSION['section']; else echo 'AUDIT ET CONTROLE'; ?>
	    </div>
	</center>
		 <?php if(is_logged() === true) { 
		    $tu = getUserIdByName($_SESSION['login']);
	        $tuid = $tu['id_utilisateur'];
			$u = getUserById($tuid);
			?>
		     
				 
				 <div class="btn-group" style="margin-left: 1050px; top: -90px;">
                                        <a class="btn btn-<?php 
										                                  if(isUserIsChef($u['id_utilisateur'])) 
																		      echo 'warning';
                                					                       else if(IsUserIsDg($u['id_utilisateur']))
																		       echo 'danger';
																		   else if(IsSuperUser($u['login']))
																		       echo 'inverse';
																		   else echo 'success'; 
																		 ?>
										                              " href="#"><i class="icon- icon-user icon-white"></i> <?php echo $u['login']; ?></a>
                                        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
                                        <ul class="dropdown-menu">
										<li><a href="gestion.php"><i class="icon-home"></i> Acceuil</a></li>
                                        <li><a href="change_password.php"><i class="icon-pencil"></i> Changer mot de passe</a></li>
                                        
										<?php if(IsUserIsDg($tu['id_utilisateur']) === false && IsSuperUser($u['login']) === false ) { ?>
										<li><a href="loguser.php?oid=<?php echo $tu['id_utilisateur'].'&in='.$u['matricule']; ?>"><i class=" icon-th"></i>  Historique</a></li>
										<?php } ?>
										
                                        <?php if(isSuperUser($_SESSION['login']) || isUserIsChef($tuid)) { ?>
                                            <li class="divider"></li>										
		                                    <li><a href="admin.php"><i class="icon icon-cog"></i> Administration</a></li>
			                            <?php  } ?>
                                                         
                                        
										<li class="divider"></li>
                                        
										
										
										
										<li><a href="logout.php"><i class="icon-off"></i> Deconnexion</a></li>
										
									</ul>	
										
                </div>
				 
				 
				 
				 
             <!-- </span> -->
		
          <?php } ?>	
      
  
  <div id="notification" class="center"></div>
  
			
<div class="container main-container">
     	
<form id='opsSaveForm' action='#' method='post' accept-charset='UTF-8'>
    	<div class="row">
        	<div class="col-md-4">
        	
    		</div>
            
            <div class="col-md-12">
            		<div class="panel panel-default">
                    		<div class="panel-heading"><b><center>Opération sur projets</center></b></div>
                    
                    		<div class="panel-body">
                            		<div class="error">
                                                                        </div>
                    		    <div class="form-group">		
                                    	Projet:
                                    	<select id="projet" class="form-control" name="projet">
                                        </select>
                                    </div>

                              <div class="form-group">


                                <div class="panel-heading">
                                <button type="button" id="buttonNewRub" class="btn btn-sm btn-primary pull-right post" data-toggle="modal" data-target="#rubriqueModal">
                	                  <i class="glyphicon glyphicon-plus"></i> Créer une nouvelle rubrique</button>

           <button type="button" id="buttonRemoveRub" class="btn btn-sm btn-danger pull-right post" data-toggle="modal" data-target="#removeRubrique">
                	                  <i class="glyphicon glyphicon-minus"></i> Supprimer une rubrique</button>
                                </div>

                                    	Rubrique:                                                       

                                    	<select id="rubriques" class="form-control" name="rubriques">
                                        </select>
                                        <span id='' class='error'></span>
                                    </div>

                                    <div class="form-group">
                                    	Date:
                                        <input id="dateOp" type="date" style="width: 24%;" class="form-control" name="dateOp">
                                        <span id='' class='error'></span>
                                    </div>

                    		
        					
                            
                    
               
               <!-- Start liste opération  -->
                    
                    
      <div id="liste_ops" class="panel panel-default">
            		<div class="panel-heading"><b>Liste opérations</b>
                     <!-- <a href="#" class="btn btn-sm btn-success pull-right post">
                	<i class="glyphicon glyphicon-minus"></i> Cache cette liste</a> -->
                    </div>
            		
                    <div class="panel-body">
            				
                            
    	<table class="table table-bordered table-hover" id="agentlist">
    
                									<thead class="tbody">
                                                      <tr>
                                                        <th><div class="text-center">Code Operation</div></th>
                                                        <th><div class="text-center">Date</div></th>
                                                        <th><div class="text-center">Désignation</div></th>
                                                        <th><div class="text-center">Montant</div></th>
                                                        <th><div class="text-center">Action</div></th>
                                                      </tr>
                                                    </thead>
    
                <tbody id="tabListOps" class="tbody">
                </tbody>
                
    	</table>
            			
                        
                   	</div>
                    
                    
            </div><!--End panel-default-->
                    
                    
             
             <!-- End list opération -->	
                        
                    
                            
                    <div class="panel panel-default">
            		<div class="panel-heading"><b>Entrer opération</b>
                    <!-- <a href="?page=register" class="btn btn-sm btn-danger pull-right post">
                	<i class="glyphicon glyphicon-plus"></i> Add Agent</a> -->
                    </div>
            		
                    <div class="panel-body">
            				
                            
    	<table class="table table-bordered table-hover" id="agentlist">
    
                									<thead class="tbody">
                                                      <tr>
                                                        <th><div class="text-center">Code Opération</div></th>
                                                        <th><div class="text-center">Désignation</div></th>
														<th><div class="text-center">Mode de payement</div></th>
                                                        <th><div class="text-center">Montant</div></th>
                                                      </tr>
                                                    </thead>
    
                <tbody class="tbody">
                	<?php //foreach($agents as $key=> $row){?>
                        <tr>
                            <td><div class="text-center"><input type="text" class="form-control" id="codeOp" name="codeOp" /></div></td>
                            <td><div class="text-center"><input type="text" class="form-control" id="libeleOp" name="libeleOp" /></div></td>
							<td>
							        <div class="text-center">
									    <select  class="form-control" id="modePay" name="modePay">
										    <option>Espèce</option>
											<option>Chèque</option>
										</select>
							        </div>
							</td>
                            <td><div class="text-center"><input type="text" class="form-control" id="montantOp" name="montantOp" /></div></td>
                        </tr>
             
                  	<?php //}?>      
                </tbody>
                
    	</table>
            			
                        
                   	</div>
                    
                    
            </div><!--End panel-default-->
                    
                    
                    
                    
                    
                    
                    <div class="panel-footer clearfix">

                                 <div class="pull-left">
                                 <a href="<?php echo $_SERVER['PHP_SELF']; ?>"><button class="btn btn-sm btn-success" type="button" onClick="get_list_op();" name="submit">
                                     <i class=""></i>
                                     Actualiser</button></a>
                                </div>

                                
                                <div class="pull-left" style="margin-left: 20px;">
                                 <a id="aplink" href="c_resultats.php?idp="><button class="btn btn-sm btn-danger" type="button" name="submit">
                                     <i class=""></i>
                                     Voir aperçu de resultat</button></a>
                                </div>


                                <div class="pull-left" style="margin-left: 20px;">
                                 <a id="blin" href="bord.php?idp="><button class="btn btn-sm btn-danger" type="button" name="submit">
                                     <i class="icon icon-home "></i>
                                     Voir detail (bauderau général des depenses)</button></a>
                                </div>


								
								<div class="pull-left" style="margin-left: 20px;">
                                 <a id="edl" href="edit_projet.php?idp="><button class="btn btn-sm btn-primary" type="button" name="submit">
                                     <i class=""></i>
                                     Modifier projet</button></a>
                                </div>
								
								

                                <div class="pull-right">
                                    <button class="btn btn-sm btn-primary" type="submit" name="submit">
                                     <i class=""></i>
                                    Enregistrer</button>
                                </div>
                    </div>
                    
                   
                   </div>
                   
                   
                    </div>
                    
                    
                    
                    
    		</div><!--End col-md-12-->
            
            <div class="col-md-4">
        
    		</div>
            
        </div>


        

</form>




    

</div>
    
    
    <!-- Modal -->
    
    
    
    
    
     <!-- add rubrique modal--> 
    <div class="modal fade" id="rubriqueModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fermer</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Créer une nouvelle rubrique sur le projet selectionné</h4>
      </div>
      <div class="modal-body">
        <form role="form" id="saveNewRubForm">
          <div class="form-group">
          <label for="recipient-name" class="control-label">Rubrique:</label> <span id="msg-saved" style="float: right; margin-top: -16px; color: green;"></span>
            <input type="text" class="form-control" id="rubrique_name" name="rubrique_name">
          </div>
            <input type="hidden" value="" id="proid" name="proid">
          
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
        <!-- <input type="submit" class="btn btn-primary" id="saveNewRub" value="Enregistrer"> -->
      </div>
    </div>
  </div>
</div>
  <!-- end add rubrique modal -->
    
    
    
<!-- modal remove rubrique --> 
 <div class="modal fade" id="removeRubrique"  role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fermer</span></button>
        <center><h4 class="modal-title" id="exampleModalLabel">Est vous sure de vouloir supprimer cette rubrique <strong><em><span id="rubname"></span></em></strong> ?</h4></center>
      </div>
      <div class="modal-body"> 
          <form>
          <center>
             <button type="button" id="nrr" class="btn btn-success" data-dismiss="modal">Non</button>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
             <button type="button" id="yrr" class="btn btn-danger">Oui</button>
          </center>
            <input type="hidden" value="" id="rrid" name="rrid"> 
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>
<!-- end modal revome rubrique -->

 


  
 


<!-- edit op modal--> 
    <div class="modal fade" id="editOpModal"  role="dialog"  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fermer</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Modifier l'opération selectionnée</h4>
      </div>
      <div class="modal-body">


        <form role="form" id="fops" action='#' method='post' accept-charset='UTF-8'>
        
          <div class="form-group">
          <label for="" class="control-label">Code:</label> <span id="msgedit" style="float: right; margin-top: -16px; color: red;"></span>
              <input type="text" class="form-control" id="edit_op_code" name="edit_op_code">
              <span class="error"></span>
          </div>          

          <div class="form-group">
          <label for="" class="control-label">Désignation:</label> 
              <input type="text" class="form-control" id="edit_op_libele" name="edit_op_libele">
              <span class="error"></span>
          </div> 
         
         <div class="form-group">
            <label for="" class="control-label">Mode de payment:</label>
            <select class="form-control" id="edit_op_mode_pay" name="edit_op_mode_pay">
                <option>Espèce</option>
                <option>Montant</option>
            </select>
         </div>

         <div class="form-group">
          <label for="" class="control-label">Montant:</label>
              <input type="text" class="form-control" id="edit_op_montant" name="edit_op_montant">
          </div>  
         


         <div class="form-group" style="margin-top: 50px;">
              <input type="submit" class="form-control" id="submitEdit" value="Modifier">
          </div>          


         
            <input type="hidden" value="" id="opid" name="opid"> 

        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
        <!-- <input type="submit" class="btn btn-primary" id="saveNewRub" value="Enregistrer"> -->
      </div>
    </div>
  </div>
</div>
  <!-- end edit op modal -->






  
  
 <!-- modal remove operation --> 
 <div class="modal fade" id="opremovemo"  role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fermer</span></button>
        <center><h4 class="modal-title" id="exampleModalLabel">Est vous sure de vouloir supprimer cette opération?</h4></center>
      </div>
      <div class="modal-body"> 
          <form>
          <center>
             <button type="button" id="nr" class="btn btn-success" data-dismiss="modal">Non</button>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
             <button type="button" id="yr" class="btn btn-danger">Oui</button>
          </center>
            <input type="hidden" value="" id="opidr" name="opidr"> 
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>
<!-- end modal revome operation -->

 
  
  
  
  
  
 







<!-- modal operation infos --> 
    <div class="modal" id="modalOp" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fermer</span></button>
        <center><h4 class="modal-title" id="exampleModalLabel">Une erreur s'est produite</h4></center>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>
<!-- end modal operation infos  -->






    

        

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script type="text/javascript" src="assets/js/bootstrap-dropdown.js"></script>
	<script type="text/javascript" src="assets/js/jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="assets/js/jquery-ui.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        
        
	<script src="assets/js/opsjs/js/ops.js"></script>
    

   
    
	<script type="text/javascript" charset="utf-8">$(prettyPrint);</script>

	   <center>
           <div>
              <p>Copyright (c) 2014 - By CRIXUS</p>
          </div>
      </center>

	 
    
  </body>
</html>

 <?php  $_SESSION['la'] = time();  ?>
