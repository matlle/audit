<?php
    require_once 'header.php';
	require_once 'model.php';

	start_session();
    logout_protected();
	expired();
	
	
    $error = '';
	$code = '';
	$objet = '';
	$date = '';
	$taxe = '';
	$taux = '';
	$mht = '';
	
	
	if (isset($_POST['submit'])) {
     $code = htmlspecialchars($_POST['code']);
    $objet =  htmlspecialchars($_POST['objetprojet']);
    $date =  htmlspecialchars($_POST['dateprojet']);
	$taxe =  htmlspecialchars($_POST['taxe']);
	//$taux =  htmlspecialchars($_POST['taux']);
	$taux = (isset($_POST['taux']) && !empty($_POST['taux']) ? $_POST['taux'] : 0.0);
    $mht =  htmlspecialchars($_POST['mht']);
    
    if(empty($code) || empty($objet) || empty($date)) 
        $error = "Le code, l'objet et la date du projet son obligatoire";
     else if(isProNameExist(strtolower($objet)) === true) {
	    $error = "Un projet avec ce nom existe dejà. Choisissez un autre nom svp";
	  } else {
	 
	     enregistrer_projet($code, $objet, $date, $taxe, $taux, $mht, $_SESSION['login']);
		 
		 
		 $_SESSION['saved_projet'] = 'Projet enregistré!';
		 
		 header('Location: ops.php');
     }	 
    
 }
	
	
?>


  <center>

      <div class="" style="background-color:#6DCCF4; margin-top: 20px; width: 600px; border: 2px solid black; border-radius: 4px;">
	     
		        <u><h5>Création d'un nouveau projet</h5></u>
	       
          <form class="form-horizontal" action="nouveau_projet.php" method="post" enctype="multipart/form-data" id="" style="padding-top: 10px;">
		                                
              <center style="color: red; margin-bottom: 10px;"><?php if($error) echo $error; ?></center> 
			  
			  <div class="control-group">
			  
               <label class="control-label" for="login">Code projet:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="text" name="code" id="code" value="<?php if($code) echo $code; ?>" placeholder="Code du projet">
                   
               </div>
             </div>
			  
              <div class="control-group">
			  
               <label class="control-label" for="login">Objet du projet:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="text" name="objetprojet" id="objetprojet" value="<?php if($objet) echo $objet; ?>" placeholder="Objet du projet">
                   
               </div>
             </div>

           <div class="control-group">
               <label class="control-label" for="password">Date du projet:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="date" name="dateprojet" id="dateprojet" value="<?php if($date) echo $date; ?>">

               </div>
           </div>
		   
		   
		   <div class="control-group">
			  
               <label class="control-label" for="login">Taxe:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="radio" name="taxe" id="taxe" value="tva">Tva 
				   <input type="radio" name="taxe" id="taxe" value="airsi"> AIRSI 
				   <input type="radio" name="taxe" id="taxe" value="autre" checked="checked"> Autre<br/>
                   				  
                   <input type="text" name="taux" placeholder="Entrez le taux svp"/><br/>

                   
               </div>
             </div>
			 
			 
			 <div class="control-group">
			  
               <label class="control-label" for="login">Montant hors taxe:</label>
               <div class="controls" style="margin-right: 150px;">
                   <input type="text" name="mht" id="mht" value="<?php if($mht) echo $mht; ?>" placeholder="Montant hors taxe">
                   
                   <!-- {% if er_fname %} <span class="profile-er"> {{ er_fname }} </span> {% endif %} -->
                   
               </div>
             </div>
			 
			 
           
             <button type="submit" class="btn" name="submit" style="">Enregistrer</button>
			 
          </form>		  
		  
      </div>
	  
	  <p>
		  <a href="index.php"><button style="margin-top: 20px;" class="btn btn-primary btn-mini" type="button">Accueil  <i class="icon icon-home icon-white"></i></button></a>
		  <a href="liste_projet.php"><button style="margin-top: 20px;" class="btn btn-mini btn-primary" type="button">Liste des projets</button></a>
		  
      </p>
	  
  </center>


<?php include 'footer.php'; ?>
