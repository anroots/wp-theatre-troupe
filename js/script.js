jQuery(document).ready(function() {

    // AJAX query to save plugin settings
    jQuery('#save-settings').click(function() {
        var data = {
            action: 'ttroupe_save_settings',
            actors_main_page: jQuery('select[name=actors-main-page]').val()
        };

        // Send data
        jQuery.post(ajaxurl, data, function(response) {
            if (response == '1') {
                jQuery('#ajax-response').html('Settings saved.');
            } else {
                jQuery('#ajax-response').html(response);
            }
        });

    });


}); // End of .ready()


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
        id:     id
    };

    // Send data
    jQuery.post(ajaxurl, data, function(response) {
        if (response == '1') {
            jQuery(that).closest('tr').fadeOut('fast');
        } else {
            if (response == '0') {
                response = 'Validation error - check required fields and formatting.'
            }
            jQuery('#ajax-response').html(response).attr('class', 'error');

        }
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
        id:     id
    };

    // Send data
    jQuery.post(ajaxurl, data, function(response) {
        if (response == '1') {
            jQuery(that).closest('tr').fadeOut('fast');
        } else {
            if (response == '0') {
                response = 'Validation error - check required fields and formatting.'
            }
            jQuery('#ajax-response').html(response).attr('class', 'error');

        }
    });
}

/**
 * Add or remove participating actors from shows
 * @param type add|remove
 * @param show_id
 * @param actor_id
 * @param that this, passed from a calling onclick
 */
function manage_show_participants(type, show_id, actor_id, that) {
    var data = {
        action: 'ttroupe_manage_show_participants',
        type: type,
        show_id: show_id,
        actor_id: actor_id
    };

    // Send data
    jQuery.post(ajaxurl, data, function(response) {
        if (response == '1') {
            if (type == 'remove') {
                jQuery(that).closest('tr').fadeOut('fast');
            } else {
                var name = jQuery("#actor_select option[value='" + actor_id + "']").text();
                jQuery('#list-of-actors > tbody:last').append('<tr><td colspan="2">' + name + '</td> </tr>');
            }
        } else {
            if (response == '0') {
                response = 'Validation error - is the actor a participant already?'
            }
            jQuery('#ajax-response').html(response).attr('class', 'error');
        }
    });

}
