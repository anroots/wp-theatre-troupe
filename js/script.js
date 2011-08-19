var loading_image_src = 'images/loading.gif'; // Loading image to show the user during AJAX query execution

/**
 * Un-deletes an item
 * @param what shows|series
 * @param id
 * @param that this, passed from onclick @todo fix that
 */
function restore(what, id, that) {

    var data = {
        action: 'ttroupe_restore',
        what: what,
        id:     id,
        _ajax_nonce: jQuery('#restore_nonce').val()
    };

    jQuery('#message').html('');
    // Send data
    jQuery.post(ajaxurl, data, function(response) {
        if (response == '1') {
            jQuery(that).closest('tr').fadeOut('fast');
        }
        process_response_msg(response);
    });
}


/**
 * Deletes an item
 * @param what shows|series
 * @param id
 * @param that this, passed from onclick @todo fix that
 */
function trash(what, id, that) {

    var data = {
        action: 'ttroupe_delete',
        what: what,
        id:     id,
        _ajax_nonce: jQuery('#delete_nonce').val()
    };

    jQuery('#message').html('');
    // Send data
    jQuery.post(ajaxurl, data, function(response) {
        if (response == '1') {
            jQuery(that).closest('tr').fadeOut('fast');
        }
        process_response_msg(response);
    });
}


/**
 * Change actor's status (active|passive|previous)
 * Used on Ttroupe Actors admin page
 * @param int actor_id
 * @param that JS this, passed from the calling button
 */
function change_actor_info(actor_id, that) {

    var data = {
        action: 'ttroupe_change_actor_info',
        status: jQuery(that).closest('tr').find('.status_select').val(),
        profile_page: jQuery(that).closest('tr').find('.page_select').val(),
        actor_id: actor_id,
        _ajax_nonce: jQuery('#actor_info_nonce').val()
    };
    jQuery('#message').html('');
    jQuery(that).after('<img style="margin-left: 15px;" alt="Loading..." title="Loading..." src="' + loading_image_src + '" />');
    jQuery(that).attr('disabled', 'disabled');
    // Send data
    jQuery.post(ajaxurl, data, function(response) {
        jQuery(that).next('img').remove();
        jQuery(that).removeAttr('disabled');
        process_response_msg(response);
    });

}


/**
 * Handles displaying AJAX responses to the user
 * @param response Server's response, usually 0 or 1
 * @param success_msg A custom success message
 */
function process_response_msg(response, success_msg) {

    if (typeof(success_msg) == 'undefined') {
        success_msg = 'Changes saved.';
    }
    if (response == '1') {
        jQuery('#message').attr('class', 'updated below-h2').html(success_msg);
    } else {
        jQuery('#message').attr('class', 'error below-h2');
        if (response == '0') {
            response = 'Something went wrong, the data didn\'t validate...';
        } else if (response == '-1') {
            response = 'The action has expired. Try reloading the page.';
        }
        jQuery('#message').html(response);
    }
}