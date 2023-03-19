$(document).ready(function(){
    $("a[id*='accept_friend_']").click(function(event) {
        event.preventDefault();
        var accept_id       = $(this).attr('id');
        var id_split        = accept_id.split('_');
        var friend_id       = id_split[2];
        var request_message = '#request_message_' + friend_id;
        $("#request_" + friend_id).hide();
        user_response(request_message, 'Successfully approved friendship request!');
        $.post(base_url + '/ajax/accept_friend', { friend_id: friend_id });
    });

    $("a[id*='reject_friend_']").click(function(event) {
        event.preventDefault();
        var accept_id       = $(this).attr('id');
        var id_split        = accept_id.split('_');
        var friend_id       = id_split[2];
        var request_message = '#request_message_' + friend_id;
        $("#request_" + friend_id).hide();
        user_response(request_message, 'Successfully rejected friendship request!');
        $.post(base_url + '/ajax/reject_friend', { friend_id: friend_id });
    });
    
	$("a[id*='remove_profile_friend_']").click(function(event) {
		event.preventDefault();
        var remove_confirm  = confirm('Are you sure you want to remove this user from your friends?');
        if ( !remove_confirm ) {
            return false;
        }

		var remove_id 	= $(this).attr('id');
		var id_split	= remove_id.split('_');
		var user_id		= id_split[3];
        var remove_msg_sel  = '#remove_friend_message';
        user_posting(remove_msg_sel, 'Removing...');
		$.post(base_url + '/ajax/remove_friend', { user_id: user_id },
		function (response) {
			if (response == '') {
				response = 'Successfully removed friendship!';
				$('#friend_' + user_id).hide();
			}
			
			user_posting(remove_msg_sel, response);
		});
	});
	
	$("[id*='remove_subscriber_']").click(function(event) {
        event.preventDefault();
        var subscribe_id    = $(this).attr('id');
        var id_split        = subscribe_id.split('_');
        var user_id         = id_split[2];
		var remove_msg_sel  = '#remove_subscriber_message';
        user_posting(remove_msg_sel, 'Removing...');
        $.post(base_url + '/ajax/remove_subscriber', { user_id: user_id },
        function (response) {
            if (response == '') {
                response = 'Successfuly removed subscriber!';
				$('#subscriber_' + user_id).hide();
            }
          	
			user_response(remove_msg_sel, response);
        });
    });

	$("[id*='remove_subscription_']").click(function(event) {
        event.preventDefault();
        var subscription_id = $(this).attr('id');
        var id_split        = subscription_id.split('_');
        var user_id         = id_split[2];
		var remove_msg_sel  = '#remove_subscription_message';
        user_posting(remove_msg_sel, 'Removing...');
        $.post(base_url + '/ajax/remove_subscription', { user_id: user_id },
        function (response) {
            if (response == '') {
                response = 'Successfuly removed subscription!';
				$('#subscription_' + user_id).hide();
            }
          	
			user_response(remove_msg_sel, response);
        });
    });

	
    $("a[id*='remove_video_from_']").click(function(event) {
        event.preventDefault();
        var remove_id       = $(this).attr('id');
        var id_split        = remove_id.split('_');
        var list            = id_split[3];
        var remove_confirm  = confirm('Are you sure you want to remove this video from your ' + list + '?');
        if ( !remove_confirm ) {
            return false;
        }
        var video_id        = id_split[4];
        var remove_msg_sel  = '#remove_' + list + '_message';
        user_posting(remove_msg_sel, 'Removing...');
        $.post(base_url + '/ajax/remove_video_' + list, { video_id: video_id },
        function (response) {
            if ( response != '' ) {
                user_posting(remove_msg_sel, response);
            } else {
                user_response(remove_msg_sel, 'Successfully removed video from ' + list + '!');
                $('#' + list + '_video_' + video_id).hide();
            }
        });
    });

    $("a[id*='remove_photo_from_favorite']").click(function(event) {
        event.preventDefault();
        var remove_confirm  = confirm('Are you sure you want to remove this photo from your favorites?');
        if ( !remove_confirm ) {
            return false;
        }
        var remove_id       = $(this).attr('id');
        var id_split        = remove_id.split('_');
        var photo_id        = id_split[4];
        var remove_msg_sel  = '#remove_favorite_photo_message';
        user_posting(remove_msg_sel, 'Removing...');
        $.post(base_url + '/ajax/remove_photo_favorite', { photo_id: photo_id },
        function (response) {
            if ( response != '' ) {
                user_posting(remove_msg_sel, response);
            } else {
                user_response(remove_msg_sel, 'Successfully removed photo from favorites!');
                $('#favorite_photo_' + photo_id).hide();
            }
        });
    });

    $("a[id*='remove_game_from_favorite']").click(function(event) {
        event.preventDefault();
        var remove_confirm  = confirm('Are you sure you want to remove this game from your favorites?');
        if ( !remove_confirm ) {
            return false;
        }
        var remove_id       = $(this).attr('id');
        var id_split        = remove_id.split('_');
        var game_id        = id_split[4];
        var remove_msg_sel  = '#remove_favorite_game_message';
        user_posting(remove_msg_sel, 'Removing...');
        $.post(base_url + '/ajax/remove_game_favorite', { game_id: game_id },
        function (response) {
            if ( response != '' ) {
                user_posting(remove_msg_sel, response);
            } else {
                user_response(remove_msg_sel, 'Successfully removed game from favorites!');
                $('#favorite_game_' + game_id).hide();
            }
        });
    });
    
    $("input[id*='post_wall_comment_']").click(function(event) {
        event.preventDefault();
        var wall_msg    = $("#post_message");
        var input_id    = $(this).attr('id');
        var id_split    = input_id.split('_');
        var user_id     = id_split[3];
        var comment     = $("textarea[id='wall_comment']").val();
        if ( comment == '' ) {
            wall_msg.show();
            return false;
        }
        if ( comment.length > 1000 ) {
            wall_msg.html('Your message can contain maximum 1000 characters!');
            wall_msg.show();
            return false;
        }
                    
        wall_msg.hide();
        user_posting_load('#wall_response', 'Posting...');
        $.post(base_url + '/ajax/wall_comment', { user_id: user_id, comment: comment },
        function(response) {
            if ( response.msg != '' ) {
                user_posting('#wall_response', response.msg);
            } else {
                $("textarea[id='wall_comment']").val('');
                var bDIV = $("#comments_delimiter");
                var cDIV = document.createElement("div");
                $(cDIV).html(response.code);
                $(bDIV).after(cDIV);
                user_response('#wall_response', 'Message Successfully Posted!');
            }
        }, "json");
    });
    
    $("a[id*='p_wall_comments_']").livequery('click', function(event) {
        event.preventDefault();
        var page_id     = $(this).attr('id');
        var id_split    = page_id.split('_');
        var user_id     = id_split[3];
        var page        = id_split[4];
        $.post(base_url + '/ajax/wall_pagination', { user_id: user_id, page: page },
        function(response) {
            if ( response != '' ) {
                var comments_id = $('#wall_comments_' + user_id);
                $(comments_id).hide();
                $(comments_id).html(response);
                $(comments_id).show();
            }
        });
    });
    
    $("a[id='attach_photo']").click(function(event) {
        event.preventDefault();
        insert_media('favorite_photos', 1);
    });

    $("a[id='attach_video']").click(function(event) {
        event.preventDefault();
        insert_media('playlist_videos', 1);
    });
});
