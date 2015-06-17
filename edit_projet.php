<?php
    require_once 'header.php';
	require_once 'model.php';

	start_session();
    logout_protected();
	expired();
	
    $cid = getUserIdByName($_SESSION['login']);
	$cid = $cid['id_utilisateur'];
	
	
    $error = '';
	$code = '';
	$objet = '';
	$date = '';
	$taxe = '';
	$taux = '';
	$mht = '';
	
	
	if (isset($_POST['submit']) && isset($_POST['code']) && isset($_POST['objetprojet']) && isset($_POST['dateprojet'])  && isset($_POST['taxe'])  && isset($_POST['taux']) && isset($_POST['mht']) ) {
        
		$code =  htmlspecialchars($_POST['code']);
        $objet =  htmlspecialchars($_POST['objetprojet']);
        $date =  htmlspecialchars($_POST['dateprojet']);
	    $taxe =  htmlspecialchars($_POST['taxe']);
	    $taux =  htmlspecialchars($_POST['taux']);
        $mht =  htmlspecialchars($_POST['mht']);
		$idp = htmlspecialchars($_POST['idp']);
    
    if(empty($code) || empty($objet) || empty($date) || empty($taxe) || empty($taux) || empty($mht)) 
        $error = "Veuillez remplir tous les champs svp.";
    else {
	 
	     editProjet($idp, $code, $objet, $date, $taxe, $taux, $mht, $cid);
		 
		 $_SESSION['edited_projet'] = 'Projet modifié!';
		 
		 header('Location: liste_projet.php');
     }	 
    
 } 
	
	
	
?>


    <center>
	
	

	     <?php
                    if(isset($_GET['idp']) && !empty($_GET['idp']) && is_projet_exist(htmlspecialchars($_GET['idp'])) == true) {
					    
						$id =  (int) trim(htmlspecialchars($_GET['idp']));
		
					    $projet = infos_projet($id);
										
						
          ?>
	
	          <h4>Modification du projet, <a href="#"><?php echo '<span style="color: #08c;;">'.$projet['objet_projet'].'</span>'; ?></a></h4>
	
	
	     <p>
		     
			  <div class="" style="background-color:#6DCCF4; margin-top: 20px; width: 600px; border: 2px solid black; border-radius: 4px;">
	     
		        <u><h5>Modification d'un nouveau projet</h5></u>
	  
          <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'].'?idp='.$id; ?>" method="post" enctype="multipart/form-data" id="" style="padding-top: 10px;">
		                                
              <center style="color: red; margin-bottom: 10px;"><?php if($error) echo $error; ?></center> 
			  
			    <div class="control-group">
			  
               <label class="control-label" for="login">Code projet:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="text" name="code" id="code" value="<?php if($code) echo $code; else echo $projet['code_projet']; ?>" placeholder="Objet du projet">
                   
               </div>
             </div>
			  
              <div class="control-group">
			  
               <label class="control-label" for="login">Objet du projet:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="text" name="objetprojet" id="objetprojet" value="<?php if($objet) echo $objet; else echo $projet['objet_projet']; ?>" placeholder="Objet du projet">
                   
               </div>
             </div>

           <div class="control-group">
               <label class="control-label" for="password">Date du projet:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="date" name="dateprojet" id="dateprojet" value="<?php if($date) echo $date; else echo $projet['date_projet']; ?>">

               </div>
           </div>
		   
		   
		   <div class="control-group">
			  
               <label class="control-label" for="login">Taxe:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="radio" name="taxe" id="taxe" value="tva" onClick="afficher();">Tva 
				   <input type="radio" name="taxe" id="taxe" value="airsi" onClick="afficher();"> AIRSI 
				   <input type="radio" name="taxe" id="taxe" value="autre" onClick="afficher();"> Autre<br/>
                   				   
                
<p id="champ_cache">

<input type="text" name="taux" placeholder="Entrez le taux svp"/><br/>

</p>
                   
               </div>
             </div>
			 
			 
			 <div class="control-group">
			  
               <label class="control-label" for="login">Montant hors taxe:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="text" name="mht" id="mht" value="<?php if($mht) echo $mht; else echo $projet['montant_ht_projet']; ?>" placeholder="Montant hors taxe">
                   
               </div>
             </div>
			 
			 <input type="hidden" name="idp" value="<?php echo $id; ?>">
			 
           
		     
			 <span id="champ_cacheee">
                  <button type="submit" class="btn" name="submit" style="">Modifier</button>
			      <a href="liste_projet.php">
			         <button style="margin-top: 0px;" class="btn btn-success" type="button" >Annuler</button>
				  </a>
		      </span>
             
			 
			 
			 
          </form>		  
		  
      </div>
			 
         </p>
	  
	             

				 

        			
	  <?php 
	        } else {
			  echo '<h3 style="color: red;">Erreur: Aucun projet selectioné!</h3><br/>';
			}
        ?>
		
                   				   
		
		<p>
		    &nbsp; <a href="liste_projet.php"><button style="margin-top: 20px;" class="btn btn-mini btn-primary" type="button"><i class="icon icon-arrow-left icon-white"></i>  Liste des projets</button></a>
		</p>

		
		
	  
	</center>


<?php include 'footer.php'; ?>