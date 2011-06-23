<div class="wrap">
	<div id="icon-users" class="icon32"></div>
	<h2><?php _e('Theatre Troupe Options', 'theatre-troupe')?></h2>


	<!-- SERIES -->
	<h3><?php _e('Series', 'theatre-troupe') ?></h3>

	<form action="" method="post"/>
	<table class="widefat">
		<thead>
		<tr>
			<th><?php _e('Title', 'theatre-troupe') ?></th>
			<th><?php _e('Status', 'theatre-troupe') ?></th>
			<th><?php _e('Change Status', 'theatre-troupe') ?></th>
		</tr>
		</thead>
		<tbody>
		<?php if ( !empty($series) ):
			foreach ( $series as $row ): ?>
			<tr>
				<td><?php echo $row->title ?></td>
				<td><?php echo $row->status ?></td>
				<td>
					<select name="">
						<option value="">Aktiivne</option>
						<option value="">Kustutatud</option>
					</select>
					<input type="button" name="change-series-status" class="button-secondary" value="<?php _e('Save', 'theatre-troupe') ?>"/>
				</td>
			</tr>
				<?php endforeach;
		endif; ?>
		</tbody>
		<tfoot>
		<tr>
			<th colspan="3">
				<?php _e('Add new series', 'theatre-troupe') ?>: * <input type="text"
				                                                          placeholder="<?php _e('Series title', 'theatre-troupe') ?>"
				                                                          name="title" size="30" maxlength="255"/>
				<input type="submit" name="add-series" class="button-primary"
				       value="<?php _e('Create', 'theatre-troupe') ?>"/>
			</th>
		</tr>
		</tfoot>
	</table>
	</form>

	<!-- SHOWS -->
	<h3><?php _e('Shows', 'theatre-troupe') ?></h3>


	<!-- ACTORS -->
	<h3><?php _e('Actors involvement', 'theatre-troupe') ?></h3>

	<table class="widefat">
		<thead>
		<tr>
			<th><?php _e('Actor name', 'theatre-troupe') ?></th>
			<th><?php _e('Status', 'theatre-troupe') ?></th>
			<th><?php _e('Change Status', 'theatre-troupe') ?></th>
		</tr>
		</thead>
		<tfoot>
		<tr>
			<th><?php _e('Actor name', 'theatre-troupe') ?></th>
			<th><?php _e('Status', 'theatre-troupe') ?></th>
			<th><?php _e('Change Status', 'theatre-troupe') ?></th>
		</tr>
		</tfoot>
		<tbody>
		<tr>
			<td>Ando Roots</td>
			<td>Aktiivne</td>
			<td>
				<select name="">
					<option value="">Aktiivne</option>
					<option value="">Passiivne</option>
					<option value="">Endine liige</option>
					<option value="">Kustutatud</option>
				</select>
				<input type="button" name="change-actor-status" class="button-secondary" value="<?php _e('Save', 'theatre-troupe') ?>"/>
			</td>
		</tr>
		</tbody>
	</table>

</div>

