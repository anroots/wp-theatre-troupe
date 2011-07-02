<?php
/*
 * View file used when editing series information
 */
?>
<div class="wrap">
    <div id="icon-edit-pages" class="icon32"></div>
    <h2><?php _e('Edit Series', 'theatre-troupe')?></h2>

    <div id="message"></div>


    <!-- Edit series -->
    <form action="<?php echo remove_query_arg('edit') ?>" method="post">
        <?php wp_nonce_field('edit-series'); ?>
        <table>
            <tr>
                <td><?php _e('Title', 'theatre-troupe') ?></td>
                <td><input type="text" placeholder="<?php _e('Title', 'theatre-troupe') ?>" size="20" maxlength="255"
                           name="title" value="<?php echo $series->title ?>"/></td>
            </tr>

            <tr>
                <td><?php _e('Description', 'theatre-troupe') ?></td>
                <td><textarea cols="30" rows="5" placeholder="<?php _e('Description', 'theatre-troupe') ?>"
                              name="description"><?php echo $series->description ?></textarea></td>
            </tr>

            <tr>
                <td><a class="button-secondary" href="<?php echo remove_query_arg('edit') ?>"
                       title="<?php _e('Back', 'theatre-troupe') ?>"><?php _e('Back', 'theatre-troupe') ?></a></td>
                <td>
                    <input type="hidden" name="series_id" value="<?php echo $series->id ?>"/>
                    <input type="submit" name="save-series" class="button-primary"
                           value="<?php _e('Save', 'theatre-troupe') ?>"/>
                </td>
            </tr>
        </table>
    </form>
    <br class="clear"/>
</div>

