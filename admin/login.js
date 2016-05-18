$(document).ready(function () {

    $('.login-form').submit(function (e) {
        e.preventDefault();

        var username = $("#username").val();
        var password = $("#password").val();
        var dataString = 'username=' + username + '&password=' + password;

        $.ajax({
            type: "POST",
            url: "connect.php",
            data: dataString,
            cache: false,
            beforeSend: function () {
                $(".btn").val('Connecting...');
            },
            success: function (data) {
                console.log(data);

                if (data == 'Nom d\'utilisateur ou mot de passe incorrect') {
                    $("#error").html("<span style='color:red'>Erreur :</span> Identifiant ou mot de passe incorrect.");
                    $("#error").css({
                        "text-align": "center",
                        "margin-bottom": "20px"
                    });
                    $('#username').val('');
                    $('#password').val('');
                }
                else {
                    window.location.href = "index.php";
                }
            }

        });
        return false;
    });
});