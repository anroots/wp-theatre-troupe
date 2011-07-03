<?php
/**
 * Prints out all available information about a given show
 * Show data is passed in from the controller via the $show variable.
 * Not an wp-admin template!
 */
?>
<h2 class="entry-title"><?php echo $show->title?></h2>
    <div class="entry-meta">
        <?php echo $start_date?>  
        <?php echo $end_date?>
    </div>

    <table>
        <thead>
        <tr>
            <th colspan="2">&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><?php _e('Series', 'theatre-troupe')?></td>
            <td><?php echo $series->title?></td>
        </tr>
        <tr>
            <td><?php _e('Series description', 'theatre-troupe')?></td>
            <td><?php echo $series->description?></td>
        </tr>

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


<h2><?php _e('Participating actors', 'theatre-troupe')?></h2>
    <ul>
    <?php if (!empty($actors)):
        foreach ($actors as $actor):?>
            <li><?php echo $actor->display_name?></li>
        <?php endforeach;
        else: ?>
            <li><?php _e('The roster is empty at the moment', 'theatre-troupe')?></li>
        <?php endif; ?>
</ul>