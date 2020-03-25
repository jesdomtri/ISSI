$(document).ready(function(){


$("#email").blur(function(){
	var re = new RegExp('[a-zA-Z]{1,}@(gmail.com|gradhermetic.com)');
	var mail = $(this).val();
	var valid = re.test(mail);
	console.log(valid);
	if(!valid){
		$(this).parent().prepend("<div id=err class=error>El email introducido no vale. <br>Debe ser del domino 'gmail.com' o 'gradhermetic.com'</div>");

	}else{
		$("#err").remove()
	}
	

});


});

