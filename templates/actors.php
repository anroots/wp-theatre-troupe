<!-- ACTORS -->
<div id="icon-users" class="icon32"></div>
<h2><?php _e('Actors', 'theatre-troupe') ?></h2>
<div id="message"></div>
<br/>
<p>
    <?php _e('Actors are your current Wordpress users. To create a new actor, simply add a new user from
        <a href="user-new.php">the users page</a>.', 'theatre-troupe'); ?>
</p>
<h3><?php _e('Actor statuses', 'theatre-troupe') ?></h3>
<ul>
    <li><?php _e('<strong>Unassigned</strong> - Do nothing with this actor, can not add to shows.', 'theatre-troupe') ?></li>
    <li><?php _e('<strong>Active</strong> - Will show in all associated actions (shows page, show details etc).', 'theatre-troupe') ?></li>
    <li><?php _e('<strong>Passive</strong> - Can not be added as a participant in future shows. ', 'theatre-troupe') ?></li>
    <li><?php _e('<strong>Previous Member</strong> - Same as Unassigned, but shows up in the Members page. ', 'theatre-troupe') ?></li>
</ul>

<!-- List actors -->
<h3><?php _e('Change actor membership status', 'theatre-troupe') ?></h3>
<?php wp_nonce_field('manage_actor_status', 'actor_status_nonce'); ?>
<table class="widefat">
    <thead>
    <tr>
        <th><?php _e('ID', 'theatre-troupe') ?></th>
        <th><?php _e('Actor name', 'theatre-troupe') ?></th>
        <th width="50%"><?php _e('Change Status', 'theatre-troupe') ?></th>
    </tr>
    </thead>

    <tbody>
    <?php echo ttroupe_actor_rows() ?>
    </tbody>
    <tfoot>
    <tr>
        <th><?php _e('ID', 'theatre-troupe') ?></th>
        <th><?php _e('Actor name', 'theatre-troupe') ?></th>
        <th><?php _e('Change Status', 'theatre-troupe') ?></th>
    </tr>
    </tfoot>
</table>
