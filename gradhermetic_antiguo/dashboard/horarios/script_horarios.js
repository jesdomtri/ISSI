$(document).ready(function(){

		$("select").on("change",function(){
		$("option:selected", this).each(function(){
			var obid = $(this).attr("value");
			$("table").remove();
		$.post("horarios/peticion_datos.php", {TABLA: "on", OBID: obid}, function(data, status){
			
			$("#tabla-horario").append($.parseHTML(data)); 
			$(".asignaciones").on("click", function(){
				var hid = $(this).attr("value");
				var nombre = $("option:selected").html();
				$("#modal-datos").remove();
				$.post("horarios/peticion_datos.php", {ASIGNACIONES: "on", HID: hid, NOMBRE: nombre}, function(data, status){
					$("#obras").append($.parseHTML(data));
					$(".asignarHorario").on("click", function(){
						var dni = $("#select_trabajadores").children(":selected").attr("value");
						
					$.post("horarios/peticion_datos.php", {ASIGNACIONES: "on", NUEVA: "on", HID: hid, DNI: dni}, function(data,status){
						$("#modal-datos").remove();
					});
					});
					$("#modal-datos").show();

				});

			});

		});

		});
		
	});

$(window).click(function(event){
		var form_modal = $("#form-modal");
		var modal_datos = $("#modal-datos");
		if(form_modal.is(event.target)){
			form_modal.hide();}
		if(modal_datos.is(event.target)){
			modal_datos.remove();}
	});

    $(".botonHorario").on("click", function() {
        $("#form-modal").show();
    });

});

