<?php
/*
 * View file used to manage shows
 */
?>
<div class="wrap">
    <div id="icon-upload" class="icon32"></div>
    <h2><?php _e('Theatre Troupe Shows', 'theatre-troupe')?></h2>

    <div id="message"></div>
    <?php echo @$error ?>

    <!-- SHOWS -->
    <h3><?php _e('Add a new show', 'theatre-troupe') ?></h3>

    <?php if ( count($series) > 0 ): ?>

    <!-- Create a show -->
    <form action="" method="post">
        <?php wp_nonce_field('create-show'); ?>
        <table>
            <tr>
                <td><?php _e('Title', 'theatre-troupe') ?></td>
                <td><input type="text" placeholder="<?php _e('Title', 'theatre-troupe') ?>" size="50" maxlength="255"
                           name="title"/></td>
            </tr>
            <tr>
                <td><?php _e('Series', 'theatre-troupe') ?> *</td>
                <td>
                    <select name="series_id">
                        <?php echo ttroupe_series_options() ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><?php _e('Location', 'theatre-troupe') ?></td>
                <td><input type="text" placeholder="<?php _e('Location', 'theatre-troupe') ?>" size="50" maxlength="255"
                           name="location"/></td>
            </tr>
            <tr>
                <td><?php _e('Link URL', 'theatre-troupe') ?></td>
                <td><input type="text" placeholder="<?php _e('Link URL', 'theatre-troupe') ?>" size="50" maxlength="255"
                           name="linkurl"/></td>
            </tr>
            <tr>
                <td><?php _e('Link name', 'theatre-troupe') ?></td>
                <td><input type="text" placeholder="<?php _e('Link name', 'theatre-troupe') ?>" size="50"
                           maxlength="255"
                           name="linkname"/></td>
            </tr>

            <tr>
                <td><?php _e('Start date / time', 'theatre-troupe') ?> *</td>
                <td><input type="text" size="25" maxlength="16" name="start_date"
                           value="<?php echo date('Y-m-d H:i', time() + 604800) ?>"/>
                </td>
            </tr>
            <tr>
                <td><?php _e('End date / time', 'theatre-troupe') ?></td>
                <td><input type="text" size="25" maxlength="16" name="end_date"
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
    <br class="clear"/>
    <!-- List existing shows -->
    <h3><?php (isset($_GET['deleted'])) ? _e('List of deleted shows', 'theatre-troupe')
            : _e('List of inserted shows', 'theatre-troupe')?></h3>
    <table class="widefat">
        <thead>
        <tr>
            <th><?php _e('Show title', 'theatre-troupe') ?></th>
            <th><?php _e('Series title', 'theatre-troupe') ?></th>
            <th><?php _e('Location', 'theatre-troupe') ?></th>
            <th><?php _e('Start', 'theatre-troupe') ?></th>
            <th><?php _e('End', 'theatre-troupe') ?></th>
            <th><?php _e('Manage', 'theatre-troupe') ?></th>
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

                    <?php if ( isset($_GET['deleted']) ): ?>
                    <input type="button" class="button-secondary"
                           onclick="trash('shows', <?php echo $show->id ?>, this);"
                           value="<?php _e('Delete permanently', 'theatre-troupe') ?>"/>
                    <input type="button" class="button-secondary"
                           onclick="restore('shows', <?php echo $show->id ?>, this);"
                           value="<?php _e('Restore', 'theatre-troupe') ?>"/>

                    <?php else: ?>

                    <a class="button-secondary" href="<?php echo add_query_arg('edit', $show->id) ?>"
                       title="<?php _e('Edit', 'theatre-troupe') ?>">
                        <?php _e('Edit', 'theatre-troupe') ?></a>

                    <input type="button" class="button-secondary"
                           onclick="trash('shows', <?php echo $show->id ?>, this);"
                           value="<?php _e('Trash', 'theatre-troupe') ?>"/>

                    <?php endif; ?>

                </td>
            </tr>
                <?php endforeach;
        else: ?>
        <tr>
            <td colspan="6"><?php _e('Empty', 'theatre-troupe')?></td>
        </tr>
            <?php endif; ?>
        </tbody>
        <tfoot>
        <tr>
            <th colspan="6">&nbsp;</th>

        </tr>
        </tfoot>
    </table>
    <br class="clear"/>


    <?php
    wp_nonce_field('delete_item', 'delete_nonce');

    /* Link to deleted or active entries */
    if ( isset($_GET['deleted']) ):
        wp_nonce_field('restore_item', 'restore_nonce'); ?>

        <a href="<?php echo remove_query_arg('deleted') ?>" class="button-secondary"
           style="float: right; margin-top: 20px;"
           title="<?php _e('View active', 'theatre-troupe')?>"><?php _e('View active', 'theatre-troupe')?></a>
        <?php else: ?>
        <a href="<?php echo add_query_arg('deleted', 'true') ?>" class="button-secondary"
           style="float: right; margin-top: 20px;"
           title="<?php _e('View deleted', 'theatre-troupe')?>"><?php _e('View deleted', 'theatre-troupe')?></a>
        <?php endif; ?>


    <?php else: ?>
    <div class="error"><?php _e('You must add a series first.', 'theatre-troupe') ?></div>
    <?php endif; ?>


</div>

