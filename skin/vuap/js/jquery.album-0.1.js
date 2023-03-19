var random = Math.random();
function selectChange(img, selection) {
    document.getElementById("x1").value = selection.x1;
    document.getElementById("y1").value = selection.y1;
    document.getElementById("x2").value = selection.x2;
    document.getElementById("y2").value = selection.y2;
    document.getElementById("width").value = selection.width;
    document.getElementById("height").value = selection.height;
}
            
$(document).ready(function(){
    $("#random").val(random);
    $("img[id*='album_photo_']").click(function(event) {
        event.preventDefault();
        var photo_id    = $(this).attr('id');
        var id_split    = photo_id.split('_');
        var photo_nr    = id_split[2];
        $("input[name='photo']").val(photo_nr);
        $.post(base_url + '/ajax/album_cover', { PID: photo_nr, random: random },
            function(response) {
                if ( response.status ) {
                    var cover_url   = base_url + '/tmp/albums/' + photo_nr + '_' + random + '.jpg';
                    $('img#album_cover').attr('src', cover_url);
                    $('img#album_cover').attr('width', response.width);
                    $('img#album_cover').attr('height', response.height);
                    $('img#album_cover').imgAreaSelect({ selectionOpacity: 0.2, x1:0, y1: 0, x2: 120, y2: 160, selectionColor: 'blue', resizable: false, onSelectChange: selectChange });
                } else {
                    $('img#album_cover').attr('src', base_url + '/media/photos/tmb/' + photo_nr + '.jpg');                                
                }
            }, "json");
    });                
});                            
