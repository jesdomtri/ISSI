$(document).ready(function() {
    $(".botonVehiculo").on("click", function() {
        $("#form-modal").show();
    });
    $(".info").on("click", function() {
        var id = $(this).attr("value");
        $.post("vehiculos/peticion_datos.php", {
            info: "on",
            MATRICULA: id
        }, function(data, status) {
            $("#vehiculos").append($.parseHTML(data));
            $("#modal-datos").show();
        });
    });
    $(".revitv").on("click", function() {
        var id = $(this).attr("value");
        $.post("vehiculos/peticion_datos.php", {
            revitv: "on",
            MATRICULA: id
        }, function(data, status) {
            $("#vehiculos").append($.parseHTML(data));
            $("#modal-datos").show();
            $("select").on("change", function() {
                $("option:selected", this).each(function() {
                    var itvid = $(this).parent().attr("value");
                    console.log(itvid);
                    $(this).parent().attr("disabled", true);
                    $.post("vehiculos/peticion_datos.php", {
                        modRev: "on",
                        ITVID: itvid
                    }, function(data, status) {
                        console.log(data);
                    });
                });
            });
        });
    });
    $("#matricula").on("blur", function() {
        var exprMatricula = new RegExp("[0-9]{4}[A-Z]{3}")
        $("#erroresForm").empty(".error");
        $("input[type=submit]").removeAttr('disabled');
        console.log($(this).val())
        if (!exprMatricula.test($(this).val())) {
            $("#erroresForm").append("<h4 class=error>Matrícula no válida</h4>");
            $("input[type=submit]").attr('disabled', 'disabled');
        }
    });
    $(window).click(function(event) {
        var form_modal = $("#form-modal");
        var modal_datos = $("#modal-datos");
        if (form_modal.is(event.target)) {
            form_modal.hide();
        }
        if (modal_datos.is(event.target)) {
            modal_datos.remove();
        }
    });
});