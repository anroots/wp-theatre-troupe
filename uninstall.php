<?php

/**
 * Included during plugin uninstall.
 * Removes database tables
 */
if ( defined(WP_UNINSTALL_PLUGIN) ) {
    require_once (ABSPATH . 'config.php');
    require_once ('includes/models/main.php');
    global $wpdb;

    $theatreTroupe = New Theatre_Troupe();

    // Delete TheatreTroupe database tables
    $sql = "DROP TABLE IF EXISTS $wpdb->ttroupe_series;";
    dbDelta($sql);
    $sql = "DROP TABLE IF EXISTS $wpdb->ttroupe_shows;";
    dbDelta($sql);
    $sql = "DROP TABLE IF EXISTS $wpdb->ttroupe_show_participants;";
    dbDelta($sql);

    $table = $wpdb->prefix . 'usermeta';
    $sql = "DELETE FROM $table WHERE meta_key LIKE '%ttroupe_%';";
    dbDelta($sql);
}

?>