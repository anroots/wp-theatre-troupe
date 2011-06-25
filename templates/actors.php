<!-- ACTORS -->
<div id="icon-users" class="icon32"></div>
<h2><?php _e('Actors', 'theatre-troupe') ?></h2>

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