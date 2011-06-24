<?php
/*
 * Admin panel view file
 */
?>
<div class="wrap">
	<div id="icon-users" class="icon32"></div>
	<h2><?php _e('Theatre Troupe Options', 'theatre-troupe')?></h2>

	<div id="ajax-response"></div>

	<!-- GENERAL SETTINGS -->
	<h3><?php _e('General settings', 'theatre-troupe') ?></h3>

	<table>
		<tr>
			<td><?php _e('Main actor page (has subpages with actor profiles)', 'theatre-troupe') ?></td>
			<td><select name="actors-main-page">
				<?php echo ttroupe_actor_page_options() ?>
			</select>
			</td>
		</tr>
		<tr>
			<td colspan="2"><br class="clear"/></td>
		</tr>
		<tr>
			<td></td>
			<td>
				<button id="save-settings" class="button-primary"><?php _e('Save', 'theatre-troupe') ?></button>
			</td>
		</tr>
	</table>


	<!-- SERIES -->
	<h3><?php _e('Series', 'theatre-troupe') ?></h3>

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


	<!-- SHOWS -->
	<h3><?php _e('Shows', 'theatre-troupe') ?></h3>

	<?php if ( count($series) > 0 ): ?>

	<!-- Create a show -->
	<form action="" method="POST"/>
	<?php
if ( function_exists('wp_nonce_field') ) {
		wp_nonce_field('ttroupe_shows');
	}
	?>
	<table>
		<tr>
			<td><?php _e('Title', 'theatre-troupe') ?></td>
			<td><input type="text" placeholder="<?php _e('Title', 'theatre-troupe') ?>" size="20" maxlength="255"
			           name="title"/></td>
		</tr>
		<tr>
			<td><?php _e('Series', 'theatre-troupe') ?></td>
			<td>
				<select name="series">
					<?php echo ttroupe_series_options() ?>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php _e('Location', 'theatre-troupe') ?></td>
			<td><input type="text" placeholder="<?php _e('Location', 'theatre-troupe') ?>" size="20" maxlength="255"
			           name="location"/></td>
		</tr>
		<tr>
			<td><?php _e('Start date / time', 'theatre-troupe') ?></td>
			<td><input type="text" size="16" maxlength="16" name="start-date"
			           value="<?php echo date('Y-m-d H:i', time() + 604800) ?>"/></td>
		</tr>
		<tr>
			<td><?php _e('End date / time', 'theatre-troupe') ?></td>
			<td><input type="text" size="16" maxlength="16" name="end-date"
			           value="<?php echo date('Y-m-d H:i', time() + 604800) ?>"/></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" name="create-show" class="button-primary"
			           value="<?php _e('Create show', 'theatre-troupe') ?>"/></td>
		</tr>
	</table>
	</form>

	<!-- List existing shows -->
	<table class="widefat">
		<thead>
		<tr>
			<th><?php _e('Show title', 'theatre-troupe') ?></th>
			<th><?php _e('Series', 'theatre-troupe') ?></th>
			<th><?php _e('Location', 'theatre-troupe') ?></th>
			<th><?php _e('Start', 'theatre-troupe') ?></th>
			<th><?php _e('End', 'theatre-troupe') ?></th>
			<th><?php _e('Edit', 'theatre-troupe') ?></th>
		</tr>
		</thead>
		<tbody>
			<?php if ( !empty($shows) ):
			foreach ( $shows as $show ): ?>
			<tr>
				<td><?php echo $show->title ?></td>
				<td><?php echo $show->series_name ?></td>
				<td><?php echo $show->location ?></td>
				<td><?php echo $show->start ?></td>
				<td><?php echo $show->end ?></td>
				<td>

					<input type="button" name="delete-series" class="button-secondary"
					       value="<?php _e('Edit', 'theatre-troupe') ?>"/>
				</td>
			</tr>
				<?php endforeach;
		endif; ?>
		</tbody>
		<tfoot>
		<tr>
			<th colspan="6">&nbsp;</th>

		</tr>
		</tfoot>
	</table>

	<?php else: ?>
	<div class="update-nag"><?php _e('You must add a series first.', 'theatre-troupe') ?></div>
	<?php endif; ?>


	<!-- ACTORS -->
	<h3><?php _e('Actors', 'theatre-troupe') ?></h3>

	<!-- List actors -->
	<table class="widefat">
		<thead>
		<tr>
			<th><?php _e('Actor name', 'theatre-troupe') ?></th>
			<th><?php _e('Change Status', 'theatre-troupe') ?></th>
		</tr>
		</thead>
		<tfoot>
		<tr>
			<th><?php _e('Actor name', 'theatre-troupe') ?></th>
			<th><?php _e('Change Status', 'theatre-troupe') ?></th>
		</tr>
		</tfoot>
		<tbody>
		<?php echo ttroupe_actor_rows() ?>
		</tbody>
	</table>

</div>

