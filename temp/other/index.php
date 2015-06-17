<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Faj - Opérations</title>
    
    <!-- bootstrap frameworks -->
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="css/bootstrap-theme.min.css" rel="stylesheet" type="text/css">
    
    <!-- custom style -->
    <link href="css/style.css" rel="stylesheet" type="text/css">
    
    <link href="css/dataTables.bootstrap.css" rel="stylesheet">
    
    <link href="css/bootstrapValidator.min.css" rel="stylesheet" type="text/css">
    
    <link href="css/bootstrap-wysihtml5.css" rel="stylesheet">
    
    <link href="css/jquery.jgrowl.min.css" rel="stylesheet">
    
  </head>
  
  <body>
  <div id="notification" class="center"></div>
  
			
<div class="container main-container">
     	
<form id='login' action='/oscar/script/index.php' method='post' accept-charset='UTF-8'>
    <input type='hidden' name='submitted' id='submitted' value='1'/>
    	<div class="row">
        	<div class="col-md-4">
        	
    		</div>
            
            <div class="col-md-12">
            		<div class="panel panel-default">
                    		<div class="panel-heading"><b>Opération sur projets</b></div>
                    
                    		<div class="panel-body">
                            		<div class="error">
                                                                        </div>
                    		    <div class="form-group">		
                                    	Projet:
                                    	<select id="projetOp" class="form-control" name="projetOp">
                                    	    <option>Fonctionnement</option>
                                    	    <option>Construction d'école (Akpa Gnagne)</option>
                                    	    <option>Terrassement de térrain</option>
                                    	    <option>Réprofilage de voie</option>
                                        </select>
                                        <span id='login_username_errorloc' class='error'></span>
                                    </div>
                                    <div class="form-group">
                                    	Rubrique:
                                    	<select id="rubriqueOp" class="form-control" name="rubriqueOp">
                                    	    <option>Carburant/Lubrifiant</option>
                                    	    <option>Restauration</option>
                                    	    <option>Location d'engin</option>
                                    	    <option>Materiels et materiaux</option>
                                    	    <option>Frais de téléphone</option>
                                        </select>
                                        <span id='login_password_errorloc' class='error'></span>
                                    </div>

                                    <div class="form-group">
                                    	Date:
                                    	<input id="password" type="date" class="form-control" name="password">
                                        <span id='login_password_errorloc' class='error'></span>
                                    </div>

                    		
        					
                            
                    
               
               <!-- Start liste opération  -->
                    
                    
                  <div class="panel panel-default">
            		<div class="panel-heading"><b>Liste opérations</b>
                     <a href="#" class="btn btn-sm btn-success pull-right post">
                	<i class="glyphicon glyphicon-minus"></i> Cache cette liste</a>
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
    
                <tbody class="tbody">
                	<?php //foreach($agents as $key=> $row){?>
                        <tr>
                            <td><div class="text-center"><?php echo "6676";?></div></td>
                            <td><div class="text-center"><?php echo "09/11/2011";?></div></td>
                            <td><div class="text-center"><?php echo "Achat materiel";?></div></td>
                            <td><div class="text-center"><?php echo "45 000";?></div></td>
                            <td><div class="text-center"><?php echo "Supprimer | Modifier";?></div></td>
                        </tr>
                        <tr>
                            <td><div class="text-center"><?php echo "6676";?></div></td>
                            <td><div class="text-center"><?php echo "09/11/2011";?></div></td>
                            <td><div class="text-center"><?php echo "Achat materiel";?></div></td>
                            <td><div class="text-center"><?php echo "45 000";?></div></td>
                            <td><div class="text-center"><?php echo "Supprimer | Modifier";?></div></td>
                        </tr>
                        <tr>
                            <td><div class="text-center"><?php echo "6676";?></div></td>
                            <td><div class="text-center"><?php echo "09/11/2011";?></div></td>
                            <td><div class="text-center"><?php echo "Achat materiel";?></div></td>
                            <td><div class="text-center"><?php echo "45 000";?></div></td>
                            <td><div class="text-center"><?php echo "Supprimer | Modifier";?></div></td>
                        </tr>
                        <tr>
                            <td><div class="text-center"><?php echo "6676";?></div></td>
                            <td><div class="text-center"><?php echo "09/11/2011";?></div></td>
                            <td><div class="text-center"><?php echo "Achat materiel";?></div></td>
                            <td><div class="text-center"><?php echo "45 000";?></div></td>
                            <td><div class="text-center"><?php echo "Supprimer | Modifier";?></div></td>
                        </tr>


                  	<?php //}?>      
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
                            <td><div class="text-center"><input type="text" class="form-control" name="codeOp" /></div></td>
                            <td><div class="text-center"><input type="text" class="form-control" name="libeleOp" /></div></td>
							<td>
							        <div class="text-center">
									    <select  class="form-control">
										    <option>Chèque</option>
											<option>Montant</option>
										</select>
							        </div>
							</td>
                            <td><div class="text-center"><input type="text" class="form-control" name="montantOp" /></div></td>
                        </tr>
             
                  	<?php //}?>      
                </tbody>
                
    	</table>
            			
                        
                   	</div>
                    
                    
            </div><!--End panel-default-->
                    
                    
                    
                    
                    
                    
                    <div class="panel-footer clearfix">
                                <div class="pull-right">
                                    <button class="btn btn-sm btn-primary" type="submit" name="submit">
                                    <i class="glyphicon glyphicon-log-in"></i>
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
        

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    
    <script src="ss-agent/ss-content/ss-themes/siblingstheme/frames/bootstrap/js/bootstrap.min.js"></script>
    
    <script src="ss-agent/ss-content/ss-themes/siblingstheme/frames/wysihtml5/js/wysihtml5-0.3.0.min.js"></script>
    
    <script src="ss-agent/ss-content/ss-themes/siblingstheme/frames/wysihtml5/js/bootstrap3-wysihtml5.js"></script>
    
    <script src="ss-agent/ss-content/ss-themes/siblingstheme/frames/validator/js/bootstrapValidator.js"></script>
    
    <script src="ss-agent/ss-content/ss-themes/siblingstheme/frames/jgrowl/js/jquery.jgrowl.min.js"></script>
    
    <script src="ss-agent/ss-content/ss-themes/siblingstheme/frames/ajax.js"></script>
    
    
    <script src="ss-agent/ss-content/ss-themes/siblingstheme/frames/datatable/js/bootstrap.min.js"></script>
    <script src="ss-agent/ss-content/ss-themes/siblingstheme/frames/datatable/js/jquery.dataTables.js"></script>
    <script src="ss-agent/ss-content/ss-themes/siblingstheme/frames/datatable/js/dataTables.bootstrap.js"></script>
   
    
	<script type="text/javascript" charset="utf-8">$(prettyPrint);</script>
    
  </body>
</html>

