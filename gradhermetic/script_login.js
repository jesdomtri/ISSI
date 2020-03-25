$(document).ready(function() {
    $("#email").blur(function() {
        $("#err").remove();
        var expEmail = new RegExp("([A-Z|a-z|0-9])+\@([a-z])+((\.){1}[a-z]){2,3}")
        var mail = $(this).val();
        var valid = expEmail.test(mail);
        if (!valid) {
            $(this).parent().prepend("<div id=err class=error>El email introducido no es un email válido</div>");
            $("input[type=submit]").attr('disabled', 'disabled');
        } else {
            $("input[type=submit]").removeAttr('disabled');
        }
    });
});