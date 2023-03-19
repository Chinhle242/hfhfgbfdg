var index   = 1;
var pic     = 2;

function update_progress(upload_id)
{
    $.post(base_url + '/ajax/upload_progress', { upload_id: upload_id },
    function (response) {
        if ( response.status == '2' ) {
            $("#upload_status").fadeOut();
        } else {
            if ( response.status = '1' ) {
                $(".bar").css('width', response.progress + '%');
                $("#upload_time").html(response.time);
                $("#upload_size").html(response.size);
            }
            setTimeout("update_progress('" + upload_id + "')", 300);
        }
    }, "json");    
}

$(document).ready(function(){
    $("#upload_game_submit").click(function(event){
        event.preventDefault();
        var error           = false;
        var game_title      = $("input[id='upload_game_title']").val();
        var game_tags       = $("textarea[id='upload_game_keywords']").val();
        var game_category   = $("select[id='upload_game_category']").val();
        var game_file       = $("input[id='upload_game_file']").val();
        var game_thumb_file = $("input[id='upload_game_thumb_file']").val();
        var title_error     = $("span[id='game_title_error']");
        var tags_error      = $("span[id='game_tags_error']");
        var category_error  = $("span[id='game_category_error']");
        var file_error      = $("span[id='game_file_error']");
        var thumb_error     = $("span[id='game_thumb_file_error']");
        
        if ( game_title == '' ) {
            error   = true;
            $(title_error).fadeIn();            
        } else {
            if ( $(title_error).is(':visible') ) {
                $(title_error).hide();
            }
        }
        if ( game_tags == '' ) {
            error   = true;
            $(tags_error).fadeIn();            
        } else {
            if ( $(tags_error).is(':visible') ) {            
                $(tags_error).hide();
            }
        }
        if ( game_category == '0' ) {
            error   = true;
            $(category_error).fadeIn();
        } else {
            if ( $(category_error).is(':visible') ) {
                $(category_error).hide();
            }    
        }
        if ( game_file == '' ) {
            error   = true;
            $(file_error).fadeIn();
        } else {
            if ( $(file_error).is(':visible') ) {
                $(file_error).hide();
            }    
        }
        if ( game_thumb_file == '' ) {
            error   = true;
            $(thumb_error).fadeIn();
        } else {
            if ( $(thumb_error).is(':visible') ) {
                $(thumb_error).hide();
            }
        }
        
        
        if ( !error ) {
            var ext_error   = $("span[id='game_file_ext_error']");
            var extension   = game_file.slice(game_file.indexOf(".")).toLowerCase();
            if ( !extension.match(game_allowed_extensions) ) {
                error = true;
                $(ext_error).html('Extension ' + extension + ' is not allowed!');
                $(ext_error).fadeIn();
            } else {
                if ( $(ext_error).is(':visible') ) {
                    $(ext_error).hide();
                }
            }
            
            var tmb_ext_err = $("span[id='game_thumb_file_ext_error']");
            var tmb_ext     = game_thumb_file.slice(game_thumb_file.indexOf(".")).toLowerCase();
            if ( !tmb_ext.match(image_allowed_extensions) ) {
                error = true;
                $(tmb_ext_err).html('Extension ' + tmb_ext + ' is not allowed!');
                $(tmb_ext_err).fadeIn();
            } else {
                if ( $(tmb_ext_err).is(':visible') ) {
                    $(tmb_ext_err).hide();
                }
            }
        }
        
        if ( !error ) {
            var upload_id = $("input[id='UPLOAD_IDENTIFIER']").val();
            $.post(base_url + '/ajax/upload_progress', { upload_id: upload_id },
            function (response) {
                if ( response.status == '0' ) {
                    $("#upload_message").html(response.msg);
                    $("#upload_message").fadeIn();
                } else {
                    if ( response.status == '3' ) {
                        $("#upload_loader").fadeIn();
                    } else {
                        $("#upload_status").fadeIn();                    
                        setTimeout("update_progress('" + upload_id + "')", 1200);
                    }

                    $("#upload_game_submit").val('Uploading...Please wait!');
                    $("#uploadGame").submit();
                }            
            }, "json");                                                                        
        }
    });
    
    $("#upload_video_submit").click(function(event){
        event.preventDefault();
        var error           = false;
        var video_title     = $("input[id='upload_video_title']").val();
        var video_tags      = $("textarea[id='upload_video_keywords']").val();
        var video_category  = $("select[id='upload_video_category']").val();
        var video_file      = $("input[id='upload_video_file']").val();
        var title_error     = $("span[id='video_title_error']");
        var tags_error      = $("span[id='video_tags_error']");
        var category_error  = $("span[id='video_category_error']");
        var file_error      = $("span[id='video_file_error']");
        
        if ( video_title == '' ) {
            error   = true;
            $(title_error).fadeIn();            
        } else {
            if ( $(title_error).is(':visible') ) {
                $(title_error).hide();    
            }
        }
        if ( video_tags == '' ) {
            error   = true;
            $(tags_error).fadeIn();            
        } else {
            if ( $(tags_error).is(':visible') ) {            
                $(tags_error).hide();
            }
        }
        if ( video_category == '0' ) {
            error   = true;
            $(category_error).fadeIn();
        } else {
            if ( $(category_error).is(':visible') ) {
                $(category_error).hide();
            }    
        }
        if ( video_file == '' ) {
            error   = true;
            $(file_error).fadeIn();
        } else {
            if ( $(file_error).is(':visible') ) {
                $(file_error).hide();
            }    
        }
        
        if ( !error ) {
            var ext_error   = $("span[id='video_file_ext_error']");
            var extension   = video_file.slice(video_file.indexOf(".")).toLowerCase();
            if ( !extension.match(video_allowed_extensions) ) {
                error = true;
                $(ext_error).html('Extension ' + extension + ' is not allowed!');
                $(ext_error).fadeIn();
            } else {
                if ( $(ext_error).is(':visible') ) {
                    $(ext_error).hide();
                }
            }
        }
        
        if ( !error ) {
            var upload_id = $("input[id='UPLOAD_IDENTIFIER']").val();
            $.post(base_url + '/ajax/upload_progress', { upload_id: upload_id },
            function (response) {
                if ( response.status == '0' ) {
                    $("#upload_message").html(response.msg);
                    $("#upload_message").fadeIn();
                } else {
                    if ( response.status == '3' ) {
                        $("#upload_loader").fadeIn();
                    } else {
                        $("#upload_status").fadeIn();                    
                        setTimeout("update_progress('" + upload_id + "')", 1200);
                    }

                    $("#upload_video_submit").val('Uploading...Please wait!');
                    $("#uploadVideo").submit();
                }            
            }, "json");                                                                        
        }
    });
    
    $('#add_photo').click(function(event) {
        event.preventDefault();
        var pCODE = '<div id="upload_photo_container_' + pic + '" class="upload_photo_container">';
        var pCODE = pCODE + '<div class="separator"><label for="photo_' + pic + '">File:</label><input name="photo_' + pic + '" type="file" id="photo_' + pic + '"><br /><span id="photo_' + pic + '_error" style="display: none;"></span></div>';
        var pCODE = pCODE + '<div class="separator"><label for="caption_' + pic + '">Caption(optional):</label><input name="caption_' + pic + '" type="text" value="" maxlength="100" id="caption_' + pic + '">';
        var pCODE = pCODE + '<br /><br /><a href="#remove_photo" id="remove_photo_' + pic + '" class="remove_photo">Remove</a><br /></div>';
        var pDIV  = document.createElement("div");
        $(pDIV).html(pCODE);
        $(this).before(pDIV);
        pic++;
    });
    
    $("a[id*='remove_photo_']").livequery('click', function(event) {
        event.preventDefault();
        var remove_id   = $(this).attr('id');
        var id_split    = remove_id.split('_');
        var photo_nr    = id_split[2];
        $('#photo_' + photo_nr).html('');
        $('#upload_photo_container_' + photo_nr).hide();
    });
    
    $("#add_photos_submit").click(function() {
        var error       = false;
        var photo_first = $("input[id='photo_1']").val();

        if ( photo_first == '' ) {
            error       = true;
            $("span[id='album_photo_error']").fadeIn();
        } else {
            $("span[id='album_photo_error']").hide();
        }

        if ( !error ) {
            jQuery.each($("input[id*='photo_']"), function() {
                var photo_id    = $(this).attr('id');
                var filename    = $(this).val();
                var extension   = filename.slice(filename.indexOf(".")).toLowerCase();
                var span        = photo_id + '_error';  
                if ( extension != '.jpg' && extension != '.jpeg' && extension != '.png' && extension != '.gif' && extension != '.bmp' ) {
                    error       = true;
                    $("span[id='" + span + "']").html('Invalid image extension. Allowed extensions: jpg, jpeg, gif, png and bmp!');
                    $("span[id='" + span + "']").fadeIn();
                } else {
                    var visible = $("span[id='" + span + "']").is(':visible');
                    if ( visible ) {
                        $("span[id='" + span + "']").hide();
                    }
                }
            });
        }
                
        if ( error ) {
            return false;
        }
        
        $("#upload_message_photos").fadeIn();
    });
    
    $("#upload_submit").click(function() {
        var error       = false;
        var album_name  = $("input[id='upload_album_name']").val();
        var album_cat   = $("select[id='upload_album_category']").val();
        var album_tags  = $("textarea[id='upload_album_tags']").val();
        var photo_first = $("input[id='photo_1']").val();
        
        if ( album_name == '' ) {
            error       = true;
            $("span[id='album_name_error']").fadeIn();
        } else {
            $("span[id='album_name_error']").hide();
        }
        
        if ( album_cat == '0' ) {
            error       = true;
            $("span[id='album_category_error']").fadeIn();
        } else {
            $("span[id='album_category_error']").hide();
        }
                       
        if ( album_tags == '' ) {
            error       = true;
            $("span[id='album_tags_error']").fadeIn();
        } else {
            $("span[id='album_tags_error']").hide();
        }
        
        if ( photo_first == '' ) {
            error       = true;
            $("span[id='album_photo_error']").fadeIn();
        } else {
            $("span[id='album_photo_error']").hide();
        }
                
        if ( !error ) {
            jQuery.each($("input[id*='photo_']"), function() {
                var photo_id    = $(this).attr('id');
                var filename    = $(this).val();
                var extension   = filename.slice(filename.indexOf(".")).toLowerCase();
                var span        = photo_id + '_error';  
                if ( extension != '.jpg' && extension != '.jpeg' && extension != '.png' && extension != '.gif' && extension != '.bmp' ) {
                    error       = true;
                    $("span[id='" + span + "']").html('Invalid image extension. Allowed extensions: jpg, jpeg, gif, png and bmp!');
                    $("span[id='" + span + "']").fadeIn();
                } else {
                    var visible = $("span[id='" + span + "']").is(':visible');
                    if ( visible ) {
                        $("span[id='" + span + "']").hide();
                    }
                }
            });
        }
                
        if ( error ) {
            return false;
        } 
        
        $("input[id='upload_submit']").value = 'Uploading Album...Please wait!';
        $("#upload_message_photos").fadeIn();
    });
});
