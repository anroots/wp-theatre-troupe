<?php
/*
 * Admin panel view file
 */
?>
<div class="wrap">
    <div id="icon-users" class="icon32"></div>
    <h2><?php _e('About Theatre Troupe', 'theatre-troupe')?></h2>

    <div id="message"></div>

    <br />


    <!-- ABOUT -->
    <br/>

    <h3><?php echo __('About Theatre Troupe', 'theatre-troupe') . ' v' . TTROUPE_VERSION?></h3>


    <div style="text-align: justify; max-width: 800px;">
        <?php _e('<p><strong>TheatreTroupe</strong> is a Wordpress plugin for small performing groups
            for managing actor profile pages.</p>

            <p>The plugin was developed for the Estonian improvisation comedy
            troupe "<a href="http://jaa.ee">Improgrupp Jaa!</a> and is available for free under the GPL2 licence.
             Support-, feature requests and bug reports are welcome
            to andoroots+dev@gmail.com or directly to <a href="https://github.com/anroots/wp-theatre-troupe">github</a>.</p>')?>

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

