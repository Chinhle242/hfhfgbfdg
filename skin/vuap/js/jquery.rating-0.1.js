    var rating_user_text     = $('#rating_text').html();
    var rating_user_current  = $("input[id='current_rating']").val();
  /*          
    $("[id*='star_']").click(function(event) {
        event.preventDefault();
        var star_id     = $(this).attr("id");
        var id_split    = star_id.split('_');
        var rating      = id_split[2];
        var item_id     = id_split[3];
        $("#rating_text").html('Thanks for rating!');
        $.post(base_url + '/ajax/rate_photo', { item_id: item_id, rating: rating },
            function (response) {
                alert(response.debug);
                $("#rating").html(response.rating_code);
                $("#rating_text").html(response.msg);
        }, "json");            
    });
*/
    $("[id*='star_']").mouseover(function() {
        var star_id     = $(this).attr('id');
        var id_split    = star_id.split('_');
        var rating      = id_split[2];
        var item_id     = id_split[3];
        for ( var i = 1; i<=5; i++ ) {
            var star_sel = $("a[id='star_photo_" + i + "_" + item_id + "']")
            if ( i <= rating )
                $(star_sel).removeClass().addClass('full');
            else
                $(star_sel).removeClass();
        }
        if ( rating == 1 ) {
            $('#rating_text').html('Bad');
        } else if ( rating == 2 ) {
            $('#rating_text').html('Not Bad');
        } else if ( rating == 3 ) {
            $('#rating_text').html('Good');
        } else if ( rating == 4 ) {
            $('#rating_text').html('Very Good');
        } else if ( rating == 5 ) {
            $('#rating_text').html('Best');
        }
    });
    
    $("ul[id='rating_container_photo']").mouseout(function(){
        var star_id     = $("[id*='star_photo_1']").attr('id');
        var id_split    = star_id.split('_');
        var item_id     = id_split[3];
        for ( var i = 0; i < 5; i++ ) {
            var star        = i+1;
            var star_sel    = $("a[id='star_photo_" + star + "_" + item_id + "']");
            if ( rating_current >= i+1 ) {
                $(star_sel).removeClass().addClass('full');
            } else if ( rating_current >= i+0.5 ) {
                $(star_sel).removeClass().addClass('half');
            } else {
                $(star_sel).removeClass();
            }     
        }
        $('#rating_text').html(rating_text);
    });
