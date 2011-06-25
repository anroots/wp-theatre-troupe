<?php

class Theatre_Troupe_Actors extends Theatre_Troupe {



    /**
     * Return information about the actors
     * @return mixed
     */
    public function get() {
        $profile_parent = $this->options['actors_main_page']; // ID of the page whose subpages are actors.
        return get_pages('child_of=' . $profile_parent);
    }
}
?>