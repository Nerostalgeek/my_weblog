$(document).ready(function () {
    var $userRow = $('.user_row');
    var triggered = false;

    $userRow.each(function() {
        var id = $(this).attr('data-id');
        var $current = $(this);
        //console.log(id);

        $current.find('.update').click(function (e) {
            e.preventDefault();
            if(triggered == false) {
                $.ajax({
                    url: 'update.php?id='+id,
                    type: "POST",
                    cache: false,

                    success: function (data) {
                        //console.log(data);
                        $current.after(data);
                        triggered = true;
                    }
                });
            }
            else {
                //console.log($current);
                $userRow.next(".update_form").remove();
                triggered = false;
            }
            return false;
        });
    });
});