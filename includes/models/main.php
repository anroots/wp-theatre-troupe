<?php
/**
 * Main plugin class
 */
class Theatre_Troupe {


    /**
     * Check for series/show existence
     * @param string $where Either series or shows
     * @param int $id
     * @return bool
     */
    public function check_existence($where, $id) {
        global $wpdb;

        if ( $where == 'series' ) {
            $table = $wpdb->ttroupe_series;
        } elseif ( $where == 'actors' ) {
            $table = $wpdb->prefix . 'users';
        } else {
            $table = $wpdb->ttroupe_shows;
        }
        $result = $wpdb->get_row("SELECT id FROM $table WHERE id='$id'");
        if ( !empty($result) ) {
            return TRUE;
        }
        return FALSE;
    }


}


?>
