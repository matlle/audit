$(document).ready(function(){


  $("#liste_ops").hide();
  
  
    getProjets();
  
  get_list_op();

  $("#projet").change(function() {
      get_list_op();

   });

  $("#rubriques").change(function() {
      get_list_op();
  });

  $("#dateOp").change(function() {
      get_list_op();
  });
  

 $("#projet").change(function() {;
      var lin = $("#aplink");
           lin.attr('href', '');
          lin.attr('href', 'c_resultats.php?idp=' + $("#projet").val());

     var blin = $("#blin");
                       blin.attr('href', '');
                       blin.attr('href', 'bord.php?idp=' + $("#projet").val());
        
		
	  var edl = $("#edl");
                       edl.attr('href', '');
                       edl.attr('href', 'edit_projet.php?idp=' + $("#projet").val());	

});



$("#closeRub").click(function() {
    $("#rubrique_name").val("");
});



/*$("#buttonNewRub").click(function() {
    saveNewRubrique();
});*/









 // Get all projets and append them 
function getProjets() {

 $.getJSON("xhr/ops_getdata.php", function(json) {
	   if(json.projets.length > 0) {
	       
		   $.each(json.projets, function(i, item) {
		   
               if(i == 0) {
                   var lin = $("#aplink");
                       lin.attr('href', '');
                       lin.attr('href', 'c_resultats.php?idp=' + item.id_projet);

                   var blin = $("#blin");
                       blin.attr('href', '');
                       blin.attr('href', 'bord.php?idp=' + item.id_projet);
                    
				  var edl = $("#edl");
                       edl.attr('href', '');
                       edl.attr('href', 'edit_projet.php?idp=' + item.id_projet);


               }
		       var proname = '<option class="pr" value=' + this['id_projet'] + '>' + this['objet_projet'] + '</option>';
			   $("#projet").append(proname);
			   
		   
		   });
		   
           getRubriques();

          $("#projet").change(function() {
              getRubriques();
          });      

	   }
	   
  });


}
  
  

// Get any rubrique by projet and append them
function getRubriques() {
   
        $("#rubriques").empty();

        var idpro = $("#projet").val();

    $.getJSON("xhr/ops_getrub.php", {'idp': idpro}, function(data, statut, erreur) {


        if(data.rubriques.length > 0) {
            
            $.each(data.rubriques, function() {
                var rubname = '<option value=' + this['rubrique_id'] + '>' + this['rubrique_name'] + '</option>';
                $("#rubriques").prepend(rubname);
            });
        }


     });


}




  // Save new rubrique
//function saveNewRubrique () {

      var msg = $("#msg-saved");


      $("#saveNewRubForm").submit(function(e) {
          e.preventDefault();
          e.stopPropagation();
          
          var cuidp = $("#projet").val();
          $("#proid").val(cuidp);
          var rubdata = $(this).serialize();

          $.post('xhr/ops_saverub.php',
              rubdata,
              function(datas) {
                  saveData(datas);
                  //alert(datas);
              },
              'json'
          );

          function saveData(datas) {
              if(datas.msg.error.length > 0) {
              $("#rubrique_name").val("");  
                  msg.html(datas.msg.error);
                  msg.fadeIn(5000);
                  msg.fadeOut(5000);
              } else if(datas.msg.ok.length > 0) {
              $("#rubrique_name").val("");  
                  msg.html(datas.msg.ok);
                  msg.fadeIn("slow");
                  msg.fadeOut("slow");
                  getRubriques(); 
           }
           

      }

  });


//}








$("#opsSaveForm").submit(function(e) {

    e.preventDefault();
    e.stopPropagation();
       
  
    $.ajax({
        type: "POST",
        url: "xhr/ops_proc.php",
        data: {
            'projet': $("#projet").val(),
            'rubriques': $("#rubriques").val(),
            'dateOp': $("#dateOp").val(),
            'codeOp': $("#codeOp").val(),
            'libeleOp': $("#libeleOp").val(),
            'modePay': $("#modePay").val(),
            'montantOp': $("#montantOp").val()
 
        },
        dataType: "json",
        success: function(response) {
            //alert(response);
            if(response.statut.statut == 'failed') {
                $(".modal-body").empty();
                $(".modal-body").append(response.statut.message);
                $("#modalOp").modal("show");
                
            } else if(response.statut.statut == 'ok') {
                $("#codeOp").val("");
                $("#libeleOp").val("");
                $("#modePay").val();
                $("#montantOp").val("");
                get_list_op();

            }
        }
    });


});






function get_list_op() {

  
    $.ajax({
        type: "POST",
        url: "xhr/ops_checkOpList.php",
        data: {
            'projet': $("#projet").val(),
            'rubrique': $("#rubriques").val(),
            'dateOp': $("#dateOp").val()
 
        },
        dataType: "json",
        success: function(response) {
            //alert(response.statut.statut);
            if(response.statut.statut == 'yes') {
               list_op(); 
            } else if(response.statut.statut == 'no') {
                $("#liste_ops").hide();
                $("#tabListOps").empty(); 
            }

        }
    });



}





function list_op() {

    $.ajax({
        type: "GET",
        url: "xhr/ops_getOpList.php",
        data: {
            'projet': $("#projet").val(),
            'rubrique': $("#rubriques").val(),
            'dateOp': $("#dateOp").val()
 
        },
        dataType: "json",
        success: function(response) {
            //alert(response);
            if(response.liste.length > 0) {
                $("#tabListOps").empty(); 
                $.each(response.liste, function() {

                    var nr = '<tr class="editr" id='+ this['operation_id']+'>';
                        nr +=  '<td><div class="text-center">' + this['operation_code'] + '</div></td>';
                        nr +=  '<td><div class="text-center">' + this['operation_formated_date'] + '</div></td>';
                        nr +=  '<td><div class="text-center">' + this['operation_libele'] + '</div></td>';
                        nr +=  '<td><div class="text-center">' + this['operation_formated_montant'] + '</div></td>';
                        nr +=  '<td><div class="text-center">' + '<a href="#" class="act" id="'+ this['operation_id'] +'" data-toggle="modal" data-target="#editOpModal">Modifier</a> | <a href="#"  class="ract" data-toggle="modal" data-target="#opremovemo" id="'+ this['operation_id'] +'">Supprimer</a>' + '</div></td>';
                        nr += '</tr>';
                        
                        $("#tabListOps").append(nr); 
						
                });
                $("#liste_ops").show();
           }
           

        }
    });


}



/////////
$("div").on('click', 'a.act', function() {
    var myid = $(this).attr("id");
    $("#opid").val(myid);
    //alert(myid);
});


$("div").on('click', 'a.ract', function() {
    var yid = $(this).attr("id");
    $("#opidr").val(yid);
    //alert(myid);
});





//$("#opremovemo").on("show", function(e) {
    //alert($("#opidr").val());
//});
//////////







// edit op

var msg_edit = $("#msgedit");

$("#fops").submit(function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        var code = $("#edit_op_code").val();
        var libele = $("#edit_op_libele").val();
        var mode = $("#edit_op_mode_pay").val();
        var montant = $("#edit_op_montant").val();

        $.ajax({
            type: "POST",
            url: "xhr/ops_edit.php", 
            data: $("#fops").serialize(),
            dataType: "json",
            success: function(response) {
              //alert(response);
                if(response.statut.statut == 'success') {
                    alert(response.statut.message);
                    get_list_op();
                    $("#editOpModal").modal("hide");
                } else if(response.statut.statut == 'failed') {
                    $("#edit_op_code").val(code);
                    $("#edit_op_libele").val(libele);
                    $("#edit_op_mode_pay").val(mode);
                    $("#edit_op_montant").val(montant);
                    msg_edit.html(response.statut.message);
                    msg_edit.fadeIn(1000);
                    msg_edit.fadeOut(1000);
                }
            }
       });

  
});






// remove op

$("#yr").click(function() {
        
        $.ajax({
            type: "POST",
            url: "xhr/ops_remove.php",
            data: {
                'opid': $("#opidr").val()
            },
            //data: $("#editOpForm").serialize(),
            dataType: "json",
            success: function(response) {
              //alert(response);
                if(response.statut.statut == 'success') {
                    alert("Opération supprimée!");
                    $("#opremovemo").modal("hide");
                    get_list_op(); 
                } else if(response.statut.statut == 'failed') {
                }
            }
       });

  
});




$("#buttonRemoveRub").click(function() {
    $("#rubname").empty();
    $("#rrid").val($("#rubriques").val());
    var rbn = $("#rubriques option:selected").text();
    $("#rubname").append(rbn);
});





// remove rub

$("#yrr").click(function() {
        
        $.ajax({
            type: "POST",
            url: "xhr/rub_remove.php",
            data: {
                'rrid': $("#rrid").val()
            },
            dataType: "json",
            success: function(response) {
              //alert(response);
                if(response.statut.statut == 'success') {
                    alert("Rubrique supprimée!");
                    getRubriques();
                    get_list_op(); 
                    $("#removeRubrique").modal("hide");
                } else if(response.statut.statut == 'failed') {
                    alert("Rubrique non supprimée!");
                }
            }
       });

  
});


// for autocompletion
var liste = [
	"items",
	"items"
];


$('#codeOp').autocomplete({
    source : liste
});
















// end of document
});
