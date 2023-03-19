$(document).ready(function(){
    $("a[id*='prev_users_'],a[id*='next_users_']").livequery('click', function(event) {
        event.preventDefault();
        var bar_id      = $(this).attr('id');
        var id_split    = bar_id.split('_');
        var move        = id_split[0];
        var gender      = id_split[2];
        var order       = id_split[3];
        var page        = $("input[id='current_page_" + order + '_' + gender + "']").val();
        $('#loader_users_' + gender + '_' + order).fadeIn();
        $.post(base_url + '/ajax/users', { gender: gender, order: order, page: page, move: move },
        function(response) {
            if ( response.status == '1' ) {
                var users_div = $('#users_' + order + '_' + gender);
                $(users_div).hide();
                $(users_div).html(response.users);
                $(users_div).fadeIn();
                $("input[id='current_page_" + order + "_" + gender + "']").val(response.page);
                var prev_bar = $('#prev_users_' + gender + '_' + order);
                var next_bar = $('#next_users_' + gender + '_' + order);
                if ( response.pages <= 1 ) {
                    $(prev_bar).hide();
                    $(next_bar).hide();
                }
            
                if ( response.page > 1 ) {
                    $(prev_bar).show();
                } else {
                    $(prev_bar).hide();
                }
            
                if ( response.page >= response.pages ) {
                    $(next_bar).hide();
                } else {
                    $(next_bar).show();
                }
            }
            $('#loader_users_' + gender + '_' + order).hide();
        }, 'json');
    });
    
    $('#advanced_users_search').click(function(event){
        event.preventDefault();
        
    });
});