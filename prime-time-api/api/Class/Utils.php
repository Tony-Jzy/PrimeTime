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


    /**
     * Time Out for certain amount of seconds
     * @param $seconds
     */
    function timeOut($seconds) {
        echo '<h1 style="font-size:200%;">&nbsp;&nbsp;&nbsp;&nbsp;Reach out max rate limit and start timer </h1>';
        sleep($seconds);
    }


    /**
     * Check if timestamp is in range of today
     * @param $timestamp
     * @return bool
     */
    function checkIfToday($timestamp) {
        $date = date('Y-m-d', $timestamp);
        $today = date('Y-m-d');
        return $date == $today;
    }
}