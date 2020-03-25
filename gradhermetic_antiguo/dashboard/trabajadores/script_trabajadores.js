$(document).ready(function(){

	$(".personal").on("click", peticion_personal);
	$(".nominas").on("click", function(){
		peticion_nominas(this, false);
	});
	
	$(".contratar").on("click", function(){
		$("#form-modal").show();
	});
	


	function peticion_personal(){
		
		var dni =$(this).attr("value");
		
		$.post("trabajadores/peticion_datos.php", {personal: "on", DNI: dni}, function(data, status){
			$("#trabajadores").append($.parseHTML(data));
			console.log($("#modal-datos"));
			$("#modal-datos").show();

		});
	}


	function peticion_nominas(btn,calcular_nomina){
		var dni =$(btn).attr("value");
		
		$.post("trabajadores/peticion_datos.php", {nominas: "on", DNI: dni, calcular:calcular_nomina}, function(data, status){
			$("#trabajadores").append($.parseHTML(data));
			$(".calc_nomina").on("click", function(){
				peticion_nominas(this,true);
				$("#modal-datos").remove();
			});
			$("#modal-datos").show();

		});

	}


	$("input").on("blur", function(){
		validar($(this).attr("name"), $(this).val());	
	});
	var cont = 0
	function validar(nombre, valor){
		var letras_dni = ['T','R','W','A','G','M',	'Y',	'F',	'P',	'D',	'X',	'B',	'N',	'J',	'Z',	'S',	'Q',	'V',	'H',	'L',	'C',	'K',	'E']
		var numeros = valor.substr(0, valor.length-1)
		var letra = valor.substr(valor.length-1)
		var letra_correcta = letras_dni[numeros%23]

	

		switch(nombre){
			
			case ":DNI":
				
				if(valor.length !=9){
					cont++
					alert("El DNI debe tener 9 dígitos");

				}else if(letra_correcta != letra){
					cont++
					alert("La letra no es correcta")
				}else if(cont>0){
					cont--;
				}
				break;

			case ":EMAIL":
		
			var expEmail = new RegExp("([A-Z|a-z|0-9])+\@([a-z])+((\.){1}[a-z]){2,3}")
	       	 if (!expEmail.test(valor)) {
	       	 	cont++
	            alert("El email no cumple los requisitos");
	            
	        }else if(cont>0){
					cont--;
				}

	        case ":NSS":
	        	if(valor.length!=12){
	        		cont++
					alert("El NSS debe tener 12 dígitos");
	        	}else if(cont>0){
					cont--;
				}
			case ":PSW":
				var expPass = new RegExp("")
				if(valor.length < 8){
					alert("Contraseña muy corta. Debe tener 8 dígitos")
				}else if()
		}
		if(cont ==0){
					$("input[type=submit]").removeAttr('disabled');
		}else{
				$("input[type=submit]").attr('disabled','disabled');
				}
	}
	
	$(window).click(function(event){
		var data_modal = $("#modal-datos");
		var form_modal = $("#form-modal");
		if(data_modal.is(event.target)){
			$("#modal-datos").remove();
		}
		if(form_modal.is(event.target)){
			form_modal.hide();
		}
		
	
	});



	});	
	