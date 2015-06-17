<?php
    include 'header.php';
	require_once 'model.php';
	
	
	start_session();
    logout_protected();
	expired();
	
	
	$error = '';
	$dateOperation = '';
	$libeleOperation = '';
	$montantOperation = '';
	$idp = '';
	
	if (isset($_POST['submit'])) {

        $dateOperation =  (string) htmlspecialchars($_POST['dateOperation']);
        $libeleOperation =  (string) htmlspecialchars($_POST['libeleOperation']);
	    $montantOperation =  (double) htmlspecialchars($_POST['montantOperation']);
		$idp = (int) htmlspecialchars($_POST['prid']);
                            
        if(empty($dateOperation) || empty($libeleOperation) || empty($montantOperation)) 
             $error = "Veuillez remplir tous les champs svp.";
        else if(!is_numeric($montantOperation))
		     $error = "Veuillez saisie une valeur numerique pour le montant.";
		else {
			     enregistrer_operation($dateOperation, $libeleOperation, $montantOperation, $idp, $_SESSION['login']);
		         
		 
		         $_SESSION['saved_operation'] = 'Donnée d\'operation enregistrée!';
		 
		         header('Location: liste_operation.php?idp='.$idp);
             }	 
    
      }
	
	
	
	
?>


<center>

    <?php
                    if(isset($_GET['idp']) && !empty($_GET['idp']) && is_projet_exist(htmlspecialchars($_GET['idp'])) == true) {
					    
						$id =  (int) trim(htmlspecialchars($_GET['idp']));
		
					    $projet = infos_projet($id);
										
						
          ?>
		  
		  
		  	          <h4>Projet : <?php echo '<span style="color: #08c;">'.$projet['objet_projet'].'</span>'; ?></h4>


<div class="" style="background-color:#6DCCF4; margin-top: 20px; width: 600px; border: 2px solid black; border-radius: 4px;">
	     
		        
       <u><h4>Saisie donnée d'operation </h4></u>
	  
              <center style="color: red;"><h4><?php if($error) echo $error; ?></h4></center>
		 
          <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'].'?idp='.$projet['id_projet']; ?>" method="post" enctype="multipart/form-data" id="" style="padding-top: 10px;">
		                                
           <div class="control-group">
               <label class="control-label" for="password">Date de l'opération:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="date" name="dateOperation" id="dateOperation" value="<?php if($dateOperation) echo $dateOperation; ?>">

               </div>
           </div>              
			  
              <div class="control-group">
			  
               <label class="control-label" >Libelé:</label>
			   
								<div class="controls" style="margin-right: 150px;">
                   <input type="text" name="libeleOperation" id="libeleOperation" value="<?php if($libeleOperation) echo $libeleOperation; ?>" placeholder="Entrez le libele de l'operation">
                              </div>
             </div>
			 
			 
			 
			 
			 
              <div class="control-group">
			  
               <label class="control-label">Montant:</label>
			   
								<div class="controls" style="margin-right: 150px;">
                   <input type="text" name="montantOperation" id="montantOperation"  value="<?php if($montantOperation) echo $montantOperation; ?>"  placeholder="Entrez le montant de l'operation">
                              </div>
             </div>
			 
			 			 
			 
			 <input type="hidden" value="<?php echo $projet['id_projet']; ?>" name="prid">
			 
			 
         
             <button type="submit" class="btn" name="submit" style="">Enregistrer</button>
			 
          </form>	
</div>

 <?php 
	        } else {
			  echo '<h3 style="color: red;">Erreur: Aucun projet selectioné!</h3><br/>';
			  
			}
        ?>
		
		
		<p>
		
		
		    <?php
                    if(isset($_GET['idp']) && !empty($_GET['idp']) && is_projet_exist(htmlspecialchars($_GET['idp'])) == true) {
					    
						$id =  (int) trim(htmlspecialchars($_GET['idp']));
		
					    $projet = infos_projet($id);
										
						
          ?>
		    
		  <a href="c_inter.php?idp=<?php echo $projet['id_projet']; ?>"><button style="margin-top: 20px;" class="btn btn-primary btn-mini" type="button"><i class="icon icon-arrow-left icon-white"></i>  Retour</button></a>
		  &nbsp;<a href="liste_operation.php?idp=<?php echo $projet['id_projet']; ?>"><button style="margin-top: 20px;" class="btn btn-primary btn-mini" type="button">Voir la liste des données d'opérations</button></a>
		  
		  <?php } ?>
		  
		  &nbsp; <a href="apercu_resultat.php"><button style="margin-top: 20px;" class="btn btn-mini btn-primary" type="button">Aperçu de resultat</button></a>
		  
		  &nbsp; <a href="liste_projet.php"><button style="margin-top: 20px;" class="btn btn-mini btn-primary" type="button">Liste des projets</button></a>
		  &nbsp; <a href="index.php"><button style="margin-top: 20px;" class="btn btn-primary btn-mini" type="button">Accueil  <i class="icon icon-home icon-white"></i></button></a>
      </p>
		

</center>





<?php include 'footer.php'; ?>