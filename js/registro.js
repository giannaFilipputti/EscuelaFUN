  jQuery(function($) {
  
	$('#usu_codperfil').change(function() {
		if ($(this).val() == 'ME') {
			$('#usu_codespecialidad').removeAttr('disabled');
		}
			
		else {
		    //alert("aqui");
			$('#usu_codespecialidad').attr('disabled','disabled');
			$("#usu_codespecialidad").val('').change();
		}
			
	});
	

	
	$("#usu_codpais").change(function () {
           $("#usu_codpais option:selected").each(function () {
            elegido=$(this).val();
            $.post("cargar_provincia.php", { pais: elegido }, function(data){
            $("#dv_provincia").html(data);
            }); 
			$.post("cargar_poblacion2.php", { pais: elegido }, function(data){
            $("#dv_poblacion").html(data);
            });            
        });
   })


});


/* validaciones */




  jQuery(document).ready(function(){
	 // alert("cargo");

$("#registro").validate({
		rules: {
			
          usu_nombre: {
				required: true
			},
		 usu_ape1: {
				required: true
			},
		  
		  usu_email: {
				required: true
			},
		 usu_password: {
				required: true
			},
		 usu_password2: {
				required: true,
				equalTo: "#usu_password"
			},
		usu_codperfil: {
				required: true
			},
		usu_numcolegiado: {
			required: true
			},
		usu_codpais: {
			required: true
			},
		usu_direccion: {
			required: true
			},
		usu_cp: {
			required: true
			},
		usu_telefono: {
			required: true
			},
		acepto: {
			required: true
			}
		    
		},
		messages: {
			
			usu_nombre: {
				required: "Requerido"
             },
			 usu_ape1: {
				required: "Requerido"
			 },
			 usu_ape2: {
				required: "Requerido"
             },
			 usu_email: {
				required: "Requerido",
				email: jQuery.validator.format("Email invalido")
             },
		 usu_password: {
				required: "Requerido"
			},
		 usu_password2: {
				required: "Requerido",
				equalTo: jQuery.validator.format("Password no coincide")
			},
		usu_codperfil: {
				required: "Requerido"
			},
		usu_numcolegiado: {
			required: "Requerido"
			},
		usu_codpais: {
			required: "Requerido"
			},
		usu_direccion: {
			required: "Requerido"
			},
		usu_cp: {
			required: "Requerido"
			},
		usu_telefono: {
			required: "Requerido"
			},
		acepto: {
			required: "Requerido"
			}
		},
		errorPlacement: function(error, element) 
    {
        element.attr('title', error.text());
        $(".error").tooltip(
        {   
            position: 
            {
                my: "left+5 center",
                at: "right center"
            },
            tooltipClass: "ttError"
        }); 
    }

		

	});
	
	  const newLocal = "#registro_s";
/* fin validaciones */

$(newLocal).validate({
		rules: {
			
          usu_nombre: {
				required: true
			},
		 usu_ape1: {
				required: true
			},
			usu_ape2: {
				required: true
			},

			usu_codpais: {
				required: true
			},
		
	
		usu_telefono: {
				required: "Requerido"
				},
		acepto: {
			required: true
			}
		    
		},
		messages: {
			
			usu_nombre: {
				required: "Requerido"
             },
			 usu_ape1: {
				required: "Requerido"
			 },
			 usu_ape2: {
				required: "Requerido"
             },
			
		
		usu_codpais: {
			required: "Requerido"
			},
		
		usu_telefono: {
			required: "Requerido"
			},
		acepto: {
			required: "Requerido"
			}
		},
		errorPlacement: function(error, element) 
    {
        element.attr('title', error.text());
        $(".error").tooltip(
        {   
            position: 
            {
                my: "left+5 center",
                at: "right center"
            },
            tooltipClass: "ttError"
        }); 
    }

		

	});


$("#registro_p").validate({
		rules: {
			
         
		 usu_pass: {
				required: true
			},
			usu_password: {
				required: true
			},
		 usu_password2: {
				required: true,
				equalTo: "#usu_password"
			}
		    
		},
		messages: {
			
			
		 usu_pass: {
				required: "Requerido"
			},
			usu_password: {
				required: "Requerido"
			},
		 usu_password2: {
				required: "Requerido",
				equalTo: jQuery.validator.format("Password no coincide")
			}
		},
		errorPlacement: function(error, element) 
    {
        element.attr('title', error.text());
        $(".error").tooltip(
        {   
            position: 
            {
                my: "left+5 center",
                at: "right center"
            },
            tooltipClass: "ttError"
        }); 
    }

		

	});




$("#registro_e").validate({
		rules: {
			
         
		 usu_password: {
				required: true
			},
		  usu_email_new: {
				required: true,
				email: jQuery.validator.format("Email invalido")
             }
		    
		},
		messages: {
			
			
		 usu_password: {
				required: "Requerido"
			},
		 usu_email_new: {
				required: "Requerido",
				email: jQuery.validator.format("Email invalido")
			}
		},
		errorPlacement: function(error, element) 
    {
        element.attr('title', error.text());
        $(".error").tooltip(
        {   
            position: 
            {
                my: "left+5 center",
                at: "right center"
            },
            tooltipClass: "ttError"
        }); 
    }

		

	});
	
	
	
$("#contacto_1").validate({
		rules: {         
		 usu_nombre: {
				required: true
			},
		  usu_email: {
				required: true,
				email: jQuery.validator.format("Email invalido")
             },
		  usu_mensaje: {
				required: true
             },
		acepto: {
			required: true
			}
		    
		},
		messages: {
			
			
		 usu_nombre: {
				required: "Requerido"
			},
		 usu_email: {
				required: "Requerido",
				email: jQuery.validator.format("Email invalido")
			},
		 usu_mensaje: {
				required: "Requerido"
			},
			acepto: {
				required: "Requerido"
			}
		},
		errorPlacement: function(error, element) 
    {
        element.attr('title', error.text());
        $(".error").tooltip(
        {   
            position: 
            {
                my: "left+5 center",
                at: "right center"
            },
            tooltipClass: "ttError"
        }); 
    }

		

	});
	
	
	
	$("#sugerencia").validate({
		rules: {         
		 
		  usu_email: {
				required: true,
				email: jQuery.validator.format("Email invalido")
             },
		  usu_mensaje: {
				required: true
             }, 
		  acepto: {
				required: true
             }
		    
		},
		messages: {
			
			
		
		 usu_email: {
				required: "Requerido",
				email: jQuery.validator.format("Email invalido")
			},
		 usu_mensaje: {
				required: "Requerido"
			},
		 acepto: {
				required: "Requerido"
			}
		},
		errorPlacement: function(error, element) 
    {
        element.attr('title', error.text());
        $(".error").tooltip(
        {   
            position: 
            {
                my: "left+5 center",
                at: "right center"
            },
            tooltipClass: "ttError"
        }); 
    }

		

	});
	
	
	
/* fin validaciones */	


   
});

