jQuery(document).ready(function() {

	// AJAX query to delete a series
	jQuery('.delete-series').click(function() {
		var data = {
			action: 'ttroupe_delete_series',
			series_id:     jQuery(this).prev().html()
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
			show_id:     jQuery(this).prev().html()
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