$(document).ready(function() {
    $(".personal").on("click", peticion_personal);
    $(".nominas").on("click", function() {
        peticion_nominas(this, false);
    });
    $(".contratar").on("click", function() {
        $("#form-modal").show();
    });

    function peticion_personal() {
        var dni = $(this).attr("value");
        $.post("trabajadores/peticion_datos.php", {
            personal: "on",
            DNI: dni
        }, function(data, status) {
            $("#trabajadores").append($.parseHTML(data));
            console.log($("#modal-datos"));
            $("#modal-datos").show();
        });
    }

    function peticion_nominas(btn, calcular_nomina) {
        var dni = $(btn).attr("value");
        $.post("trabajadores/peticion_datos.php", {
            nominas: "on",
            DNI: dni,
            calcular: calcular_nomina
        }, function(data, status) {
            $("#trabajadores").append($.parseHTML(data));
            $(".calc_nomina").on("click", function() {
                peticion_nominas(this, true);
                $("#modal-datos").remove();
            });
            $("#modal-datos").show();
        });
    }
    $("#mostrarPass").click(function() {
        if ($(this).attr("value") == "no") {
            $(this).attr("value", "si");
            $("#pass").attr("type", "text");
        } else {
            $(this).attr("value", "no");
            $("#pass").attr("type", "password");
        }
    });
    $("input").on("blur", function() {
        validar($(this).attr("name"), $(this).val());
    });
    var cont = 0

    function validar(nombre, valor) {
        var letras_dni = ['T', 'R', 'W', 'A', 'G', 'M', 'Y', 'F', 'P', 'D', 'X', 'B', 'N', 'J', 'Z', 'S', 'Q', 'V', 'H', 'L', 'C', 'K', 'E']
        var numeros = valor.substr(0, valor.length - 1)
        var letra = valor.substr(valor.length - 1)
        var letra_correcta = letras_dni[numeros % 23]
        switch (nombre) {
            case ":DNI":
                $("#erroresForm").empty(".error");
                if ((valor.length - 1) != 8) {
                    cont++
                    $("#erroresForm").append("<h4 class=error>El DNI debe tener 8 dígitos y una letra</h4>");
                } else if (letra_correcta != letra) {
                    cont++
                    $("#erroresForm").append("<h4 class=error>La letra no es correcta<h4>")
                } else if (cont > 0) {
                    cont--;
                }
                break;
            case ":EMAIL":
                $("#erroresForm").empty(".error");
                var expEmail = new RegExp("([A-Z|a-z|0-9])+\@([a-z])+((\.){1}[a-z]){2,3}")
                if (!expEmail.test(valor)) {
                    cont++
                    $("#erroresForm").append("<h4 class=error>El email no es válido<h4>");
                } else if (cont > 0) {
                    cont--;
                }
                break;
            case ":NSS":
                $("#erroresForm").empty(".error");
                if (valor.length != 12) {
                    cont++;
                    $("#erroresForm").append("<h4 class=error>El NSS debe tener 12 dígitos</h4>");
                } else if (cont > 0) {
                    cont--;
                }
                break;
            case ":PSW":
                $("#erroresForm").empty(".error");
                var expPassMayus = new RegExp("[A-Z]{1,}")
                var expPassMinus = new RegExp("[a-z]{1,}")
                var expPassLetra = new RegExp("[0-9]{1,}")
                if (valor.length < 8) {
                    cont++
                    $("#erroresForm").append("<h4 class=error>Contraseña muy corta. Debe tener 8 dígitos</h4>")
                } else if (!expPassMayus.test(valor)) {
                    cont++
                    $("#erroresForm").append("<h4 class=error>La constraseña debe tener mayúsculas</h4>")
                } else if (!expPassLetra.test(valor)) {
                    cont++
                    $("#erroresForm").append("<h4 class=error>La contraseña deber tener números</h4>")
                } else if (!expPassMinus.test(valor)) {
                    cont++
                    $("#erroresForm").append("<h4 class=error>La constraseña debe tener minúsculas</h4>")
                } else if (cont > 0) {
                    cont--
                }
                break;
        }
        if (cont == 0) {
            $("input[type=submit]").removeAttr('disabled');
        } else {
            $("input[type=submit]").attr('disabled', 'disabled');
        }
    }
    $(window).click(function(event) {
        var data_modal = $("#modal-datos");
        var form_modal = $("#form-modal");
        if (data_modal.is(event.target)) {
            $("#modal-datos").remove();
        }
        if (form_modal.is(event.target)) {
            form_modal.hide();
        }
    });
});