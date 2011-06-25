<?php
/*
 * Admin panel view file
 */
?>
<div class="wrap">
    <div id="icon-users" class="icon32"></div>
    <h2><?php _e('Theatre Troupe Options', 'theatre-troupe')?></h2>

    <div id="ajax-response"></div>

    <!-- GENERAL SETTINGS -->
    <h3><?php _e('General settings', 'theatre-troupe') ?></h3>

    <table>
        <tr>
            <td><?php _e('Main actor page (has subpages with actor profiles)', 'theatre-troupe') ?></td>
            <td><select name="actors-main-page">
                <?php echo ttroupe_actor_page_options() ?>
            </select>
            </td>
        </tr>
        <tr>
            <td colspan="2"><br class="clear"/></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <button id="save-settings" class="button-primary"><?php _e('Save', 'theatre-troupe') ?></button>
            </td>
        </tr>
    </table>


</div>

