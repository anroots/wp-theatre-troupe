jQuery(document).ready(function() {


    /*
    // AJAX query to delete a series
    jQuery('.delete-series').click(function() {
        var data = {
            action: 'ttroupe_delete_series',
            series_id:     jQuery(this).prev().prev().html()
        };
        var row = jQuery(this).closest('tr');


        // Send data
        jQuery.post(ajaxurl, data, function(response) {
            if (response == '1') {
                jQuery(row).fadeOut('fast');
            } else {
                jQuery('#ajax-response').html(response);
            }
        });

    });


    // AJAX query to delete a show
    jQuery('.delete-show').click(function() {
        var data = {
            action: 'ttroupe_delete_show',
            show_id:     jQuery(this).prev().prev().html()
        };
        var row = jQuery(this).closest('tr');


        // Send data
        jQuery.post(ajaxurl, data, function(response) {
            if (response == '1') {
                jQuery(row).fadeOut('fast');
            } else {
                jQuery('#ajax-response').html(response);
            }
        });

    });


    // AJAX query to un-delete a show
    jQuery('.restore-show').click(function() {
        var data = {
            action: 'ttroupe_restore_show',
            show_id:     jQuery(this).prev().prev().html()
        };
        var row = jQuery(this).closest('tr');

        // Send data
        jQuery.post(ajaxurl, data, function(response) {
            if (response == '1') {
                jQuery(row).fadeOut('fast');
            } else {
                jQuery('#ajax-response').html(response);
            }
        });

    });
*/
    

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
});



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