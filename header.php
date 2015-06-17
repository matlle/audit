<?php 
           require_once 'model.php'; 
           start_session();

 ?>          
 <!DOCTYPE html>
 <html lang="en">
  <head>
    <meta charset="utf-8">
    <title>FAJ-EXPERT AUDIT ET CONTROLE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="MATLLE">
    <link rel="shortcut icon" href="assets/img/edchfoods_favicon.ico">
    <!-- Le styles -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link href="assets/css/custom.css" rel="stylesheet">
	<link rel="stylesheet" href="print.css" type="text/css" media="print" />
	<script type="text/javascript" src="assets/js/javascript.js"></script>
	<script type="text/javascript" src="assets/js/jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="assets/js/bootstrap-dropdown.js"></script>
	
	
  
 </head>
 <body class="bg">
      <center>
         <a href="index.php"><img src="assets/img/logo.jpg" style="margin-top: 30px;"></a>
         <div style="margin-top: 10px; margin-bottom: -20px; margin-left: 70px;">
		      <?php if(is_logged() === true) { ?> 
		      <div class="input-append">
			  <?php $pro_select = ''; ?>
			     <form method="get" action="search.php">
				   <?php
				                  $pros = liste_projets();
                                  foreach($pros as $p) {
		                              if(is_projet_has_donnee_operation($p['id_projet']) === true)
			                              $projets[] = $p;
                                  }										  
				   ?>
			      <select name="pro">
				           <?php   
						                if(isset($_GET['pro']) && !empty($_GET['pro'])) 
										    $pro_select = $_GET['pro'];
                                        foreach($projets as $pi) {
                                             if(isset($pro_select)) { 
											     if($pi['objet_projet'] === $pro_select)
											         echo '<option selected="selected">'.$pi['objet_projet'].'</option>';
												 else
												     echo '<option>'.$pi['objet_projet'].'</option>';
											 } else 
                                                   echo '<option>'.$pi['objet_projet'].'</option>';
                                        }											 
					         ?> 
				  </select>
                  <input class="input-xlarge" type="text" name="se" placeholder="Rechercher operation" value="<?php if(isset($_GET['se'])) echo $_GET['se']; ?>">
                  <button class="btn"><i class="icon icon-search"></i></button>
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
		     
				 
				 
				 
				 <div class="btn-group" style="margin-left: 1000px; top: -85px;">
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
	     
    <!-- </center> -->
