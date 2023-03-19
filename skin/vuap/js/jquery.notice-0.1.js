$(document).ready(function(){
    $("input[id*='post_notice_comment_']").click(function() {
        var notice_msg  = $("#post_message");
        var input_id    = $(this).attr('id');
        var id_split    = input_id.split('_');
        var notice_id    = id_split[3];
        var comment     = $("textarea[id='notice_comment']").val();
        if ( comment == '' ) {
            notice_msg.fadeIn();
            return false;
        }
        
        if ( comment.length > 1000 ) {
            notice_msg.html('Comment can contain maximum 1000 characters!');
            $("textarea[id='notice_comment']").val('');
        }
                    
        notice_msg.hide();
        user_posting('#notice_response', 'Posting...');
        reset_chars_counter();
        $.post(base_url + '/ajax/notice_comment', { notice_id: notice_id, comment: comment },
        function(response) {
            if ( response.msg != '' ) {
                $("textarea[id='notice_comment']").val('');
                user_posting('#notice_response', response.msg);
            } else {
                $("textarea[id='notice_comment']").val('');
                var bDIV = $("#comments_delimiter");
                var cDIV = document.createElement("div");
                $(cDIV).html(response.code);
                $(bDIV).after(cDIV);
                user_response('#notice_response', 'Comment successfully posted!');
            }
        }, "json");
    });
    
    $("a[id*='p_notice_comments_']").livequery('click', function(event) {
        event.preventDefault();
        var page_id     = $(this).attr('id');
        var id_split    = page_id.split('_');
        var notice_id   = id_split[3];
        var page        = id_split[4];
        $.post(base_url + '/ajax/notice_pagination', { notice_id: notice_id, page: page },
        function(response) {
            if ( response.comments_code != '' ) {
                var comments_id = $('#notice_comments_' + notice_id);
                $(comments_id).hide();
                $(comments_id).html(response.comments_code);
                $(comments_id).fadeIn();
            }
        }, "json");
    });
    
    $("a[id*='delete_comment_']").livequery('click', function(event) {
        event.preventDefault();
        var click_id    = $(this).attr('id');
        var id_split    = click_id.split('_');
        var type        = id_split[2];
        var comment_id  = id_split[3];
        var parent_id   = id_split[4];
        user_posting('#delete_response_' + comment_id, 'Deleting...');
        $.post(base_url + '/ajax/' + type + '_comment_delete', { comment_id: comment_id, parent_id: parent_id },
        function(response) {
            if ( response.status == 0 ) {
                user_posting('#delete_response_' + comment_id, response.msg);
            } else {
                $('#' + type + '_comment_' + comment_id).fadeOut();
            }
        }, 'json');
    });
});
