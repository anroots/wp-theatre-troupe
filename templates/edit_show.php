<?php
/*
 * View file used when editing show information
 */
?>
<div class="wrap">
    <div id="icon-users" class="icon32"></div>
    <h2><?php _e('Edit Show', 'theatre-troupe')?></h2>

    <div id="ajax-response"></div>


    <!-- Edit show -->
    <form action="<?php echo remove_query_arg('edit') ?>" method="POST"/>
<?php
if ( function_exists('wp_nonce_field') ) {
    wp_nonce_field('ttroupe_shows');
}
    ?>
    <table>
        <tr>
            <td><?php _e('Title', 'theatre-troupe') ?></td>
            <td><input type="text" placeholder="<?php _e('Title', 'theatre-troupe') ?>" size="20" maxlength="255"
                       name="title" value="<?php echo $show->title ?>"/></td>
        </tr>
        <tr>
            <td><?php _e('Series', 'theatre-troupe') ?></td>
            <td>
                <select name="series_id">
                    <?php echo ttroupe_series_options($show->series_id) ?>
                </select>
            </td>
        </tr>
        <tr>
            <td><?php _e('Location', 'theatre-troupe') ?></td>
            <td><input type="text" placeholder="<?php _e('Location', 'theatre-troupe') ?>" size="20" maxlength="255"
                       name="location" value="<?php echo $show->location ?>"/></td>
        </tr>
        <tr>
            <td><?php _e('Start date / time', 'theatre-troupe') ?></td>
            <td><input type="text" size="19" maxlength="19" name="start-date"
                       value="<?php echo $show->start_date ?>"/></td>
        </tr>
        <tr>
            <td><?php _e('End date / time', 'theatre-troupe') ?></td>
            <td><input type="text" size="19" maxlength="19" name="end-date"
                       value="<?php echo $show->end_date ?>"/></td>
        </tr>
        <tr>
            <td><a class="button-secondary" href="<?php echo remove_query_arg('edit') ?>"
                   title="<?php _e('Back', 'theatre-troupe') ?>"><?php _e('Back', 'theatre-troupe') ?></a></td>
            <td>
                <input type="hidden" name="show_id" value="<?php echo $show->id ?>"/>
                <input type="submit" name="save-show" class="button-primary"
                       value="<?php _e('Save', 'theatre-troupe') ?>"/>
            </td>
        </tr>
    </table>
    </form>
    <br class="clear"/>
</div>

