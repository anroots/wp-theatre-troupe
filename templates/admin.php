<?php
/*
 * Admin panel view file
 */
?>
<div class="wrap">
    <div id="icon-users" class="icon32"></div>
    <h2><?php _e('About Theatre Troupe', 'theatre-troupe')?></h2>

    <div id="message"></div>

    <!-- GENERAL SETTINGS -->
    <h3><?php echo __('About Theatre Troupe', 'theatre-troupe') .' v'.TTROUPE_VERSION?></h3>


        <?php _e('<p><strong>TheatreTroupe</strong> is a Wordpress plugin for small performing groups
        for listing shows and associated actors.<br /> As your group admin, you can easily enter and display your previous and
        upcoming shows/performances anywhere on your pages sidebar.</p>

        <p>The plugin was developed for the Estonian improvisation comedy
        troupe "<a href="http://jaa.ee">Improgrupp Jaa!</a>" and is available for free under the GPL2 licence.
        <br />Support-, feature requests and bug reports are welcome
        to andoroots+devel@gmail.com or directly to <a href="https://github.com/anroots/wp-theatre-troupe">github</a>.</p>

         <h4>Widgets</h4>

         <p>
         The plugin includes a widget that is able to list either past or upcoming shows on the sidebar.
         </p>', 'theatre-troupe'); ?>

    <br />
    <table class="widefat">
        <caption>
            <h3><?php _e('Available <a href="http://en.support.wordpress.com/shortcodes/" title="Documentation">Shortcodes</a>', 'theatre-troupe')?></h3>
        </caption>
        <thead>
        <tr>
            <th><?php _e('Shortcode', 'theatre-troupe')?></th>
            <th><?php _e('Parameters', 'theatre-troupe')?></th>
            <th><?php _e('Content <i>(between [code][/code])</i>', 'theatre-troupe')?></th>
            <th><?php _e('Description', 'theatre-troupe')?></th>
            <th><?php _e('Usage Example', 'theatre-troupe')?></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td style="white-space: nowrap">[ttroupe-actor-shows]</td>
            <td>actor_id (<?php _e('required', 'theatre-troupe')?>)*</td>
            <td><?php _e('Optional title', 'theatre-troupe')?></td>
            <td><?php _e('Prints a list of shows the actor, specified by the actor_id parameter <i>(you can see actor ID-s in the Actors subpage)</i>, has played in.', 'theatre-troupe')?></td>
            <td><code>[ttroupe-actor-shows actor_id="5"]<?php _e('List of shows actor #5 has played in', 'theatre-troupe')?>[/ttroupe-actor-shows]</code></td>
        </tr>

        <tr>
            <td style="white-space: nowrap">[ttroupe-series-list]</td>
            <td>None</td>
            <td><?php _e('Optional title', 'theatre-troupe')?></td>
            <td><?php _e('Prints a list of all active series, shows and and actor who have played in any of the shows.', 'theatre-troupe')?></td>
            <td><code>[ttroupe-series-list]<?php _e('List of all series', 'theatre-troupe')?>[/ttroupe-series-list]</code></td>
        </tr>
        <tr>
            <td style="white-space: nowrap">[ttroupe-actors-list]</td>
            <td>status (<?php _e('required', 'theatre-troupe')?>)* <?php _e('Accepted values are:', 'theatre-troupe')?> passive, active, previous</td>
            <td><?php _e('Optional title', 'theatre-troupe')?></td>
            <td><?php _e('Prints a list of actors who have the specified status.', 'theatre-troupe')?></td>
            <td><code>[ttroupe-actors-list status="active"]<?php _e('The following actors are actively participating in shows', 'theatre-troupe')?>[/ttroupe-actors-list]</code></td>
        </tr>
        </tbody>
    </table>
</div>

