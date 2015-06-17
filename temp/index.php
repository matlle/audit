<!DOCTYPE html>
<html>
<head>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>

$(document).ready(function(){
  
  $("#formulaire").submit(function(e){
  
    e.preventDefault();
    var  donnees = $(this).serialize();
  
    $.post("co.php",
    donnees,
    function(data, status){
      //alert("Data: " + data + "\nStatus: " + status);
	  $("#msg").html(data);
    });
	"html"
	
  });
});

</script>
</head>
<body>

  <div id="msg">
  </div>

<form id="formulaire">
    Nom: <input type="text" name="username"><br/>
	Mot de passe: <input type="password" name="password"><br/>
	<input type="submit" value="Enregistrer">
</form>






</body>
</html>