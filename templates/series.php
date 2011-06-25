<!-- SERIES -->
<div id="icon-edit-pages" class="icon32"></div>
<h2><?php _e('Series', 'theatre-troupe') ?></h2>

<div id="ajax-response"></div>
<br class="clear"/>
<!-- Add new series -->
<form action="" method="post"/>
<?php
        if ( function_exists('wp_nonce_field') ) {
    wp_nonce_field('ttroupe_series');
}
?>
<table>
    <tr>
        <td><?php _e('Add new series', 'theatre-troupe') ?>: *</td>
        <td><input type="text"
                   placeholder="<?php _e('Series title', 'theatre-troupe') ?>"
                   name="series-title" size="30"
                   maxlength="255"/></td>
    </tr>
    <tr>
        <td><?php _e('Description', 'theatre-troupe') ?></td>
        <td><textarea name="series-description" placeholder="<?php _e('Description', 'theatre-troupe') ?>" cols="30"
                      rows="5"></textarea></td>
    </tr>
    <tr>
        <td></td>
        <td>
            <input type="submit" name="add-series" class="button-primary"
                   value="<?php _e('Create', 'theatre-troupe') ?>"/>
        </td>
    </tr>
</table>
<br class="clear"/>


<!-- List existing series -->
<h3><?php (isset($_GET['deleted'])) ? _e('List of deleted series', 'theatre-troupe')
        : _e('List of inserted series', 'theatre-troupe')?></h3>
<table class="widefat">
    <thead>
    <tr>
        <th><?php _e('Title', 'theatre-troupe') ?></th>
        <th><?php _e('Description', 'theatre-troupe') ?></th>
        <th><?php _e('Delete', 'theatre-troupe') ?></th>
    </tr>
    </thead>
    <tbody>
    <?php if ( !empty($series) ):
        foreach ( $series as $row ): ?>
        <tr>
            <td><?php echo $row->title ?></td>
            <td><?php echo $row->description ?></td>
            <td>
                <?php if ( isset($_GET['deleted']) ): ?>

                <input type="button" class="button-secondary" onclick="restore('series', <?php echo $row->id ?>, this);"
                       value="<?php _e('Restore', 'theatre-troupe') ?>"/>
                <input type="button" class="button-secondary" onclick="trash('series', <?php echo $row->id ?>, this)"
                       value="<?php _e('Delete permanently', 'theatre-troupe') ?>"/>
                <?php else: ?>

                <a class="button-secondary" href="<?php echo add_query_arg('edit', $row->id) ?>"
                   title="<?php _e('Edit', 'theatre-troupe') ?>">
                    <?php _e('Edit', 'theatre-troupe') ?></a>

                <input type="button" class="delete-series" class="button-secondary"
                       onclick="trash('series', <?php echo $row->id ?>, this)"
                       value="<?php _e('Trash', 'theatre-troupe') ?>"/>

                <?php endif; ?>
            </td>
        </tr>
            <?php endforeach;
    else: ?>
    <tr>
        <td colspan="3"><?php _e('Empty', 'theatre-troupe')?></td>
    </tr>
        <?php endif; ?>
    </tbody>
    <tfoot>
    <tr>
        <th colspan="3">&nbsp;</th>
    </tr>
    </tfoot>
</table>
<br class="clear"/>


<?php
 /* Link to deleted or active entries */
if ( isset($_GET['deleted']) ): ?>
<a href="<?php echo remove_query_arg('deleted') ?>" class="button-secondary"
   style="float: right; margin-top: 20px;"
   title="<?php _e('View active')?>"><?php _e('View active')?></a>
<?php else: ?>
<a href="<?php echo add_query_arg('deleted', 'true') ?>" class="button-secondary"
   style="float: right; margin-top: 20px;"
   title="<?php _e('View deleted')?>"><?php _e('View deleted')?></a>
<?php endif; ?>

</form>



