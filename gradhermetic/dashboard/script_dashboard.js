$(document).ready(function() {
    $("#mostrar").click(function() {
        if ($(this).attr("value") == "no") {
            $(this).attr("value", "si");
            $("#contrasena").attr("type", "text");
        } else {
            $(this).attr("value", "no");
            $("#contrasena").attr("type", "password");
        }
    });
    mostrarActivo();

    function mostrarActivo() {
        var id = "#" + $("ul").attr("pagActiva");
        $(id).toggleClass("activo");
    }
});