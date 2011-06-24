jQuery(document).ready(function(){

	// AJAX query to delete a series
	jQuery('.delete-series').click(function(){
		var data = {
			action: 'delete_series',
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
});