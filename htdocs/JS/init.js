document.jcrop_api = 0;

// Remember to invoke within jQuery(window).load(...)
// If you don't, Jcrop may not initialize properly
jQuery(window).load(function(){

    document.jcrop_api = $.Jcrop('#cropbox',{
        onChange: showPreview,
        onSelect: showPreview 
    });

    document.jcrop_api.disable();

    $('#rehook').click(function(e) {
        document.jcrop_api.enable();
 
        document.jcrop_api.animateTo([ 0,0, document.templateW, document.templateH ]);

        document.jcrop_api.setOptions({
            aspectRatio: document.templateW / document.templateH,
            allowResize: true ,
            allowMove: true 
        });

        document.jcrop_api.focus();

        return nothing(e);
    });

    $('#unhook').click(function(e) {
        document.jcrop_api.release();;
        document.jcrop_api.disable();;
        return nothing(e);
    });

    $('#cancels').click(function(e) {
        document.jcrop_api.disable();
        document.jcrop_api.release();
        return nothing(e);
    });

});


//}}}

// A handler to kill the action
// Probably not necessary, but I like it
function nothing(e)
{
    e.stopPropagation();
    e.preventDefault();
    return false;
};

// Our simple event handler, called from onChange and onSelect
// event handlers, as per the Jcrop invocation above
function showPreview(coords)
{
    updateCoords(coords);
    if (parseInt(coords.w) > 0)
    {
 
        var rx = document.templateW / coords.w;
        var ry = document.templateH / coords.h;

        jQuery('#preview').css({
            width: Math.round(rx * document.photoSizeW) + 'px',
            height: Math.round(ry * document.photoSizeH) + 'px',
            marginLeft: '-' + Math.round(rx * coords.x) + 'px',
            marginTop: '-' + Math.round(ry * coords.y) + 'px'
        });

        
    }
}
 
function undetectPersona(){
    document.jcrop_api.release();
}

function updateCoords(c)
{
    jQuery('#x').val(c.x);
    jQuery('#y').val(c.y);
    jQuery('#x2').val(c.x2);
    jQuery('#y2').val(c.y2);
    jQuery('#w').val(c.w);
    jQuery('#h').val(c.h);
};

function selectPeople(name, last_name, id)
{
    document.getElementById('list_of_people').style.display = 'none';
    jQuery('#persona_id').val(id);
    jQuery('#persona_name').val(name);
    jQuery('#persona_last').val(last_name);
    document.getElementById('OverLay').style.display = 'none';
};



function hss(ones){

    //hs(false);
    //document.jcrop_api.disable();
    // document.jcrop_api.release();
    document.getElementById('list_of_people').style.display = 'block';
    document.getElementById('OverLay').style.display = 'block';

}