<?php

require_once dirname(__FILE__).'/'.'Database.php';
require_once dirname(__FILE__).'/'.'JSON.php';
require_once dirname(__FILE__).'/'.'Utils.php';
require_once dirname(__FILE__).'/'.'../Scraper/base.php';



class Media {

    var $time;
    var $db;
    var $json;
    var $utils;
    var $base;

    function __construct() {
        $this->time = time();
        $this->db = new DB();
        $this->json = new JSON();
        $this->utils = new Utils();
        $this->base = new Base();
    }

    /**
     * Fetch media info for user
     * @param $uid
     * @param $start
     * @param $pageSize
     */
    function fetchMedia($uid, $start, $pageSize) {
        $cacheCheck = $this->db->fetch_all("SELECT * FROM ".DB_PRE."member_profile WHERE uid = $uid");
        $cachedTime = $cacheCheck[0]['ins_cached_time'];

        if ($this->utils->checkIfToday($cachedTime)) {
            $medias = $this->db->fetch_all("SELECT * FROM ".DB_PRE."user_media WHERE uid = $uid ORDER BY created DESC LIMIT $start, $pageSize");
            $data = array();
            foreach ($medias as $key => $media) {
                $tableName = $this->utils->formTableName($media['mid']);
                $insMedia = $this->db->fetch_all("SELECT * FROM $tableName WHERE id = '".$media['mid']."'");
                $data[] = $insMedia[0];
            }
            echo json_encode(array(
                'error' => '',
                'success' => true,
                'data' => $data
            ),JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        } else {
//            $this->fetchMedia($uid, $start, $pageSize);
            $medias = $this->db->fetch_all("SELECT * FROM ".DB_PRE."user_media WHERE uid = $uid ORDER BY created DESC LIMIT $start, $pageSize");
            $data = array();
            foreach ($medias as $key => $media) {
                $tableName = $this->utils->formTableName($media['mid']);
                $insMedia = $this->db->fetch_all("SELECT * FROM $tableName WHERE id = '".$media['mid']."'");
                $data[] = $insMedia[0];
            }
            echo json_encode(array(
                'error' => '',
                'success' => true,
                'data' => $data
            ),JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            $this->base->initInstagram($cacheCheck[0]['ins_username'], $cacheCheck[0]['ins_password'], $start+$pageSize);

        }
    }


}