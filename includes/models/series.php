<?php

/**
 * Series model
 */

class Theatre_Troupe_Series extends Theatre_Troupe {


    /**
     * Returns series
     * @param int $series_id
     * @param string $status
     * @return mixed
     */
    public function get($series_id = NULL, $status = 'active') {
        global $wpdb;
        if ( !empty($series_id) ) {
            $series_id = " AND id='$series_id'";
        }
        $query = $wpdb->get_results("SELECT * FROM $wpdb->ttroupe_series
				WHERE status = '$status' $series_id", OBJECT);

        if ( empty($series_id) ) {
            return $query;
        }
        return $query[0];
    }


    /**
     * Insert a new series to the database.
     * @param string $title
     * @param string $description
     * @return bool|int New row ID
     */
    public function add($title, $description) {
        if ( empty($title) ) {
            return FALSE;
        }
        global $wpdb;
        $wpdb->insert($wpdb->ttroupe_series, array( 'title' => $title, 'description' => $description ));
        return $wpdb->insert_id;
    }


    /**
     * Updates series information
     * @param  $series_id
     * @param  $title Required
     * @param  $description
     * @return bool
     */
    public function update($series_id, $title, $description) {
        $series_id = (int) $series_id;
        if ( empty($title) ||
             !$this->check_existence('series', $series_id)
        ) {
            return FALSE;
        }

        global $wpdb;
        $wpdb->update($wpdb->ttroupe_series, array( 'title' => $title,
                                                  'description' => $description ),
                      array( 'id' => $series_id ));
        return TRUE;
    }


    /**
     * Returns a DB object of show_id's for all shows whose parent (series_id) matches
     * @param $series_id The ID of the parent series
     * @return null|object
     */
    public function get_children($series_id) {
        global $wpdb;
        if ( empty($series_id) ) {
            return NULL;
        }

        $sql = "SELECT id
                    FROM $wpdb->ttroupe_shows
                    WHERE series_id = '$series_id'";

        $query = $wpdb->get_results($sql, OBJECT);

        return $query;
    }


}

?>