<?php
/**
 * Prints out all available information about a given show
 * Show data is passed in from the controller via the $show variable.
 * Not an wp-admin template!
 */
?>
<h2 class="entry-title"><?php echo $show->title?></h2>

    <table>
        <thead>
        <tr>
            <th colspan="2"><?php _e('Show Details', 'theatre-troupe')?></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><?php _e('Timeframe', 'theatre-troupe')?></td>
            <td>
        <?php echo $start_date?>
        <?php echo $end_date?>
            </td>
        </tr>
        <tr>
            <td><?php _e('Series', 'theatre-troupe')?></td>
            <td><?php echo $series->title?></td>
        </tr>
         <?php if (!empty($show->description)):?>
        <tr>
            <td><?php _e('Series description', 'theatre-troupe')?></td>
            <td><?php echo $series->description?></td>
        </tr>
        <? endif; ?>

        <?php if (!empty($show->location)):?>
        <tr>
            <td><?php _e('Location', 'theatre-troupe')?></td>
            <td><?php echo $show->location?></td>
        </tr>
        <?php endif; ?>


        <?php if (!empty($show->linkurl)):?>
        <tr>
            <td><?php _e('Link', 'theatre-troupe')?></td>
            <td><a href="<?php echo $show->linkurl?>" title="Link"><?php echo $show->linkname?></a></td>
        </tr>
        <?php endif; ?>
        
        </tbody>
    </table>

<!-- List of actors who play in this show -->
<?php echo ttroupe_actors_list($show->id) ?>