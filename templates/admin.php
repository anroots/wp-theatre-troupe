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
    <h3><?php _e('General Settings', 'theatre-troupe')?></h3>
    <form action="" method="post">
        <?php _e('Select the page that contains the shortcode [ttroupe-show-details]', 'theatre-troupe')?><br />
        <select name="show_details_page">
            <?php echo ttroupe_pages_options() ?>
        </select>
        
        <input type="submit" name="save_settings" value="<?php _e('Update')?>" />
    </form>


    <!-- ABOUT -->
    <br />
    <h3><?php echo __('About Theatre Troupe', 'theatre-troupe') . ' v' . TTROUPE_VERSION?></h3>


    <div style="text-align: justify; max-width: 800px;">
        <?php _e('<p><strong>TheatreTroupe</strong> is a Wordpress plugin for small performing groups
            for listing shows and associated actors. The plugin enables You, the group admin, display information
             about actors, upcoming and previous shows/performances easily on the sidebar using widgets or more
             detailed information anywhere on the site with shortcodes.</p>

            <p>The plugin was developed for the Estonian improvisation comedy
            troupe "<a href="http://jaa.ee">Improgrupp Jaa!</a> and is available for free under the GPL2 licence.
             Support-, feature requests and bug reports are welcome
            to andoroots+dev@gmail.com or directly to <a href="https://github.com/anroots/wp-theatre-troupe">github</a>.</p>

             <h4>Widgets</h4>

             <p>TheatreTroupe includes two widgets.</p>
             <p>The <strong>Theatre Troupe Shows</strong> widget is able to list either past or upcoming shows on the sidebar. You can choose
             the behaviour of the widget from a dropdown menu.</p>
             <p>The <strong>Theatre Troupe Next Show</strong> widget will display basic information about the next upcoming show and a
                list of actors who will be performing. If no next show exists, the last show is displayed instead.</p>', 'theatre-troupe'); ?>
    </div>
    <br/>


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
            <td style="white-space: nowrap;">[ttroupe-show-details]</td>
            <td><?php _e('None', 'theatre-troupe')?></td>
            <td><?php _e('None', 'theatre-troupe')?></td>
            <td><?php _e('Creates a page for displaying details about a show. <strong>The creation of this page is important.</strong>
                            The links from sidebar widgets and other shortcodes link to this page. You have to choose the page you pasted the shortcode from the options menu above,
                              otherwise the links will be broken.', 'theatre-troupe')?></td>
            <td style="white-space: nowrap;"><code>[ttroupe-show-details]</code></td>
        </tr>
        <tr>
            <td style="white-space: nowrap">[ttroupe-actor-shows]</td>
            <td>actor_id (<?php _e('required', 'theatre-troupe')?>)*</td>
            <td><?php _e('Optional title', 'theatre-troupe')?></td>
            <td><?php _e('Prints a list of shows the actor, specified by the actor_id parameter <i>(you can see actor ID-s in the Actors subpage)</i>, has played in.', 'theatre-troupe')?></td>
            <td><code>[ttroupe-actor-shows
                actor_id="5"]<?php _e('List of shows actor #5 has played in', 'theatre-troupe')?>
                [/ttroupe-actor-shows]</code></td>
        </tr>

        <tr>
            <td style="white-space: nowrap">[ttroupe-series-list]</td>
            <td><?php _e('None', 'theatre-troupe')?></td>
            <td><?php _e('Optional title', 'theatre-troupe')?></td>
            <td><?php _e('Prints a list of all active series, shows and and actor who have played in any of the shows.', 'theatre-troupe')?></td>
            <td><code>[ttroupe-series-list]<?php _e('List of all series', 'theatre-troupe')?>
                [/ttroupe-series-list]</code></td>
        </tr>
        <tr>
            <td style="white-space: nowrap">[ttroupe-actors-list]</td>
            <td>status (<?php _e('required', 'theatre-troupe')?>)* <?php _e('Accepted values are:', 'theatre-troupe')?>
                passive, active, previous
            </td>
            <td><?php _e('Optional title', 'theatre-troupe')?></td>
            <td><?php _e('Prints a list of actors who have the specified status.', 'theatre-troupe')?></td>
            <td><code>[ttroupe-actors-list
                status="active"]<?php _e('The following actors are actively participating in shows', 'theatre-troupe')?>
                [/ttroupe-actors-list]</code></td>
        </tr>
        </tbody>
    </table>
    <p>
        <i>
            <?php _e('Credits', 'theatre-troupe')?>: <a href="http://ando.roots.ee/" title="Blog">Ando Roots</a>,
            <a href="http://pullerits.wordpress.com/" title="Blog">Peep Pullerits</a>,
            <a href="http://jaa.ee/" title="Website">Improgrupp Jaa!</a>
        </i>
    </p>
</div>

