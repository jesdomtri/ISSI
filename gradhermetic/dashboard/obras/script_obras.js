$(document).ready(function() {
    $(".botonObra").on("click", function() {
        $("#form-modal").show();
    });
    $(".info").on("click", function() {
        var id = $(this).attr("value");
        $.post("obras/peticion_datos.php", {
            info: "on",
            OBID: id
        }, function(data, status) {
            $("#obras").append($.parseHTML(data));
            $("#modal-datos").show();
        });
    });
    $("select").on("change", function() {
        $("option:selected", this).each(function() {
            var obid = $(this).parent().attr("value");
            var hid = $(this).attr("value");
            console.log("OBID: " + obid, " HORARIO: " + hid);
            $.post("obras/peticion_datos.php", {
                horario: "on",
                HID: hid
            }, function(data, status) {
                obj = data.split(" ");
                $("#e" + obid).html(obj[0]);
                $("#s" + obid).html(obj[1]);
            });
        });
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