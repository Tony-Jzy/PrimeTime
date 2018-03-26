<?php

class Utils{

    /**
     * Produce the correct table for current post
     * @param $postId
     * @return string
     */
    function formTableName($postId) {
        $id = substr((string)$postId, -1, 1);
        return 'instagram_cache_'.intval($id);
    }

}