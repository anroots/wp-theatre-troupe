<?php
/*
 * Admin panel view file
 */
?>
<div class="wrap">
    <div id="icon-users" class="icon32"></div>
    <h2><?php _e('Theatre Troupe Options', 'theatre-troupe')?></h2>

    <div id="message"></div>

    <!-- GENERAL SETTINGS -->
    <h3><?php _e('About Theatre Troupe', 'theatre-troupe') ?></h3>
    <p>
        Instructions here
    </p>


    <br/>
    <a href="<?php echo add_query_arg('install', 'true') ?>" class="button-primary">Run MYSQL installation routine</a>

</div>

