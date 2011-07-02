<?php
/*
 * View file used when editing show information
 */
?>
<div class="wrap">
    <div id="icon-users" class="icon32"></div>
    <h2><?php _e('Edit Show', 'theatre-troupe')?></h2>

    <div id="message"></div>


    <!-- Edit show -->
    <form action="<?php echo remove_query_arg('edit') ?>" method="post">
        <?php wp_nonce_field('edit-shows'); ?>
        <table>
            <tr>
                <td><?php _e('Title', 'theatre-troupe') ?></td>
                <td><input type="text" placeholder="<?php _e('Title', 'theatre-troupe') ?>" size="50" maxlength="255"
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
                <td><input type="text" placeholder="<?php _e('Location', 'theatre-troupe') ?>" size="50" maxlength="255"
                           name="location" value="<?php echo $show->location ?>"/></td>
            </tr>
            <tr>
                <td><?php _e('Link URL', 'theatre-troupe') ?></td>
                <td><input type="text" placeholder="<?php _e('Link URL', 'theatre-troupe') ?>" size="50" maxlength="255"
                           name="linkurl" value="<?php echo $show->linkurl ?>"/></td>
            </tr>
            <tr>
                <td><?php _e('Link name', 'theatre-troupe') ?></td>
                <td><input type="text" placeholder="<?php _e('Link name', 'theatre-troupe') ?>" size="50"
                           maxlength="255"
                           name="linkname" value="<?php echo $show->linkname ?>"/></td>
            </tr>

            <tr>
                <td><?php _e('Start date / time', 'theatre-troupe') ?></td>
                <td><input type="text" size="25" maxlength="19" name="start_date"
                           value="<?php echo $show->start_date ?>"/></td>
            </tr>
            <tr>
                <td><?php _e('End date / time', 'theatre-troupe') ?></td>
                <td><input type="text" size="25" maxlength="19" name="end_date"
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

    <h3><?php _e('Actors associated with the show', 'theatre-troupe') ?></h3>

    <?php _e('Add actor to the show', 'theatre-troupe') ?>:
    <select id="actor_select"><?php echo ttroupe_actor_options()?></select>
    <button class="button-secondary"
            onclick="manage_show_participants('add', <?php echo $show->id ?>, jQuery('#actor_select').val());"><?php _e('Add', 'theatre-troupe') ?></button>
    <br class="clear"/>

    <table class="widefat" id="list-of-actors">
        <thead>
        <tr>
            <th><?php _e('Name', 'theatre-troupe') ?></th>
            <th><?php _e('Remove', 'theatre-troupe') ?></th>
        </tr>
        </thead>
        <tbody>
        <?php echo ttroupe_show_actors($show->id) ?>
        </tbody>
        <tfoot>
        <tr>
            <th colspan="2">&nbsp;</th>
        </tr>
        </tfoot>
    </table>
    <?php wp_nonce_field('manage_participants', 'participants_nonce'); ?>
</div>

