<!-- ACTORS -->
<div id="icon-users" class="icon32"></div>
<h2><?php _e('Actors', 'theatre-troupe') ?></h2>

<!-- List actors -->
<h3><?php _e('Change actor membership status', 'theatre-troupe') ?></h3>
<table class="widefat">
    <thead>
    <tr>
        <th><?php _e('Actor name', 'theatre-troupe') ?></th>
        <th width="50%"><?php _e('Change Status', 'theatre-troupe') ?></th>
    </tr>
    </thead>

    <tbody>
    <?php echo ttroupe_actor_rows() ?>
    </tbody>
     <tfoot>
    <tr>
        <th><?php _e('Actor name', 'theatre-troupe') ?></th>
        <th><?php _e('Change Status', 'theatre-troupe') ?></th>
    </tr>
    </tfoot>
</table>