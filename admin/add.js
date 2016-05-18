$(document).ready(function () {
    var triggered = false;

    $('#add_btn').click(function (e) {
        e.preventDefault();
        if (triggered == false) {
            $.ajax({
                url: 'add.php',
                type: "POST",
                cache: false,

                success: function (data) {
                    //console.log(data);
                    $('#add_btn').after(data);
                    triggered = true;
                }
            });
        }
        else {
            $('#add_btn').next().remove();
            triggered = false;
        }
        return false;
    });
});