$(document).ready(function () {
    var $tagRow = $('.tag_row');
    var triggered = false;

    $tagRow.each(function() {
        var id = $(this).attr('data-id');
        var $current = $(this);
        //console.log(id);

        $current.find('.tag_link').click(function (e) {
            e.preventDefault();
            if(triggered == false) {
                $.ajax({
                    url: "modif_tag.php?id="+id,
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
                $tagRow.next(".tag_form").remove();
                triggered = false;
            }
            return false;
        });
    });
});