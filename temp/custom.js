$(document).ready(function() {

       $("<div id='loading'></div>").insertAfter("#submit");

           $("#loading").css(
               background: "url(small_loader.gif)",
               display: "none" // hide 
           );

                    $("#submit").click(function() {

                        $.ajax(
                            'co.php',
                            {
                                username: $("#username").val();
                                password: $("#password").val();
                            },
                            
                            'text',

                            function(data) {
                            
                                if (data == 'Success') {
                                    $("#resultat").html("<p>Vous avez été connecté avec succèss !</p>");
                                } else if(data == 'Failed') {
                                    $("#resultat").html("<p>Error lors de la connection...</p>");
                                }
                            },


                            success: function(data) {
                                alert("Yo!");
                            },

                            error: function(resulat, statut, erreur) [
                                $("#resultat").html(resultat + erreur);
                            }



                       );

                       $("#loading").ajaxStart(function() {
                           $(this).show();
                       });

                   });


});
