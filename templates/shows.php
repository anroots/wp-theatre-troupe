<?php
/*
 * View file used to manage shows
 */
?>
<div class="wrap">
	<div id="icon-users" class="icon32"></div>
	<h2><?php _e('Theatre Troupe Shows', 'theatre-troupe')?></h2>

	<div id="ajax-response"></div>


	<!-- SHOWS -->
	<h3><?php _e('Add a new show', 'theatre-troupe') ?></h3>

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
				<select name="series_id">
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
	<br class="clear"/>
	<!-- List existing shows -->
	<table class="widefat">
		<thead>
		<tr>
			<th><?php _e('Show title', 'theatre-troupe') ?></th>
			<th><?php _e('Series title', 'theatre-troupe') ?></th>
			<th><?php _e('Location', 'theatre-troupe') ?></th>
			<th><?php _e('Start', 'theatre-troupe') ?></th>
			<th><?php _e('End', 'theatre-troupe') ?></th>
			<th><?php _e('Edit / Delete', 'theatre-troupe') ?></th>
		</tr>
		</thead>
		<tbody>
			<?php if ( !empty($shows) ):
			foreach ( $shows as $show ): ?>
			<tr>
				<td><?php echo $show->title ?></td>
				<td><?php echo $show->series_title ?></td>
				<td><?php echo $show->location ?></td>
				<td><?php echo $show->start_date ?></td>
				<td><?php echo $show->end_date ?></td>
				<td>
					<a class="button-secondary" href="<?php echo add_query_arg('edit', $show->id) ?>"
					   title="<?php _e('Edit', 'theatre-troupe') ?>">
						<?php _e('Edit', 'theatre-troupe') ?></a>
					<span class="hidden"><?php echo $show->id ?></span>
					<input type="button" class="delete-show" class="button-secondary"
					       value="<?php _e('Delete', 'theatre-troupe') ?>"/>
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


</div>

