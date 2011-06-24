<!-- SERIES -->
<div id="icon-edit-pages" class="icon32"></div>
<h2><?php _e('Series', 'theatre-troupe') ?></h2>

<!-- Add new series -->
<form action="" method="post"/>
<?php
		if ( function_exists('wp_nonce_field') ) {
	wp_nonce_field('ttroupe_series');
}
?>
<?php _e('Add new series', 'theatre-troupe') ?>: * <input type="text"
                                                          placeholder="<?php _e('Series title', 'theatre-troupe') ?>"
                                                          name="series-title" size="30"
                                                          maxlength="255"/>
<input type="submit" name="add-series" class="button-primary"
       value="<?php _e('Create', 'theatre-troupe') ?>"/>
<br class="clear"/>

<!-- List existing series -->
<table class="widefat">
	<thead>
	<tr>
		<th><?php _e('Series title', 'theatre-troupe') ?></th>
		<th><?php _e('Delete', 'theatre-troupe') ?></th>
	</tr>
	</thead>
	<tbody>
	<?php if ( !empty($series) ):
		foreach ( $series as $row ): ?>
		<tr>
			<td><?php echo $row->title ?></td>
			<td>
				<span class="hidden"><?php echo $row->id ?></span>
				<input type="button" name="delete-series" class="button-secondary delete-series"
				       value="<?php _e('Delete', 'theatre-troupe') ?>"/>
			</td>
		</tr>
			<?php endforeach;
	endif; ?>
	</tbody>
	<tfoot>
	<tr>
		<th colspan="2">&nbsp;</th>
	</tr>
	</tfoot>
</table>
</form>



