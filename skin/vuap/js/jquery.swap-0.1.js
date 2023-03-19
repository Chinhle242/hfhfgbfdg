var swap = 1;
function swap_viewed()
{
    if ( swap ) {
        swap = 0;
        $('#videos_row_one').hide();
        $('#videos_row_two').fadeIn();
    } else {
        swap = 1;
        $('#videos_row_two').hide();
        $('#videos_row_one').fadeIn();
    }
    setTimeout("swap_viewed()", 5000);
}

$(document).ready(function() {
    if ( $('#videos_row_two').length ) {
        setTimeout("swap_viewed()", 5000);
    }
});