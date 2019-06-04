/* Helpers for front end */
$ = jQuery;

function do_shortcode( description ) {

    var data = {
        'action' : 'flex_do_shortcode',
        '_ajax_nonce' :  map_data._nonce_,
        'description' : description
    };

    $.post(map_data.ajax_url, data, function ( description ) {
        if(description.error)
            console.log(description.error);

        return description.content;
    });
}
