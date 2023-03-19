$(document).ready(function() {
    $("a[id*='_page_category_videos_']").livequery('click', function(event) {
        event.preventDefault();
        var button_id   = $(this).attr('id');
        var id_split    = button_id.split('_');
        var move        = id_split[0];
        var category    = id_split[4];
        var page        = $("input[id='current_page_" + category + "']").val();
        $.post(base_url + '/ajax/category_videos', { category_id: category, move: move, page: page },
        function(response) {
            if ( response.status == '1' ) {
                var categ_videos = $('#category_videos_' + category);
                $(categ_videos).hide();
                $(categ_videos).html('');
                $(categ_videos).html(response.videos);
                $(categ_videos).fadeIn();
                $("input[id='current_page_" + category + "']").val(response.page);
            }
            if ( response.pages <= 1 ) {
                $('#prev_page_category_videos_' + category).hide();
                $('#next_page_category_videos_' + category).hide();
            }
            
            if ( response.page > 1 ) {
                $('#prev_page_category_videos_' + category).show();
            } else {
                $('#prev_page_category_videos_' + category).hide();
            }
            
            if ( response.page >= response.pages ) {
                $('#next_page_category_videos_' + category).hide();
            } else {
                $('#next_page_category_videos_' + category).show();
            }
        }, "json");
    });
});