<?php

require __DIR__ . '/../vendor/autoload.php';

require_once dirname(__FILE__).'/'.'config.php';
require_once dirname(__FILE__).'/'.'database.php';
require_once dirname(__FILE__).'/'.'utils.php';



class Base {

    var $DB;
    var $TIME;
    var $INS;
    var $UTIL;
    var $ACCOUNT;

    function __construct() {
        $this->DB = new DB();
        $this->TIME = time();
        $this->UTIL = new Utils();
        $this->INS = \InstagramScraper\Instagram::withCredentials(BASEACC, BASEPW, '');
        $this->INS->login();
        $this->ACCOUNT = $this->INS->getAccount(BASEACC);
    }

    /**
     * Get Account by Username
     * @param $username
     * @return \InstagramScraper\Model\Account
     */
    function getAccount($username) {
        try {
            $account = $this->INS->getAccount($username);
        } catch (Exception $exception) {
            echo $exception->getMessage();
            $account = $this->INS->getAccount(BASEACC);
        }
        return $account;
    }

    /**
     * Get the list of followers of the User
     * @return array
     */
    function getFollowers() {
        $followers = $this->INS->getFollowers($this->ACCOUNT->getId(), $this->ACCOUNT->getFollowedByCount(), $this->ACCOUNT->getFollowedByCount(), true);
        return $followers;
    }

    /**
     * Get the list of followings of the User
     * @return array
     */
    function getFollowing() {
        $followers = $this->INS->getFollowing($this->ACCOUNT->getId(), $this->ACCOUNT->getFollowsCount(), $this->ACCOUNT->getFollowsCount(), true);
        return $followers;
    }


    /**
     * Get User's All Media Lists
     * @param \InstagramScraper\Model\Account $account
     * @return \InstagramScraper\Model\Media[]
     */
    function getPosts(\InstagramScraper\Model\Account $account) {
        $medias = $this->INS->getMedias($account->getUsername(), $account->getMediaCount());
        foreach ($medias as $media) {
            $result = array(
                "Id" => $media->getId(),
                "Shotrcode" => $media->getShortCode(),
                "Created" => $media->getCreatedTime(),
                "Caption" => $media->getCaption(),
                "Number of comments" => $media->getCommentsCount(),
                "Number of likes" => $media->getLikesCount(),
                "Get link:" => $media->getLink(),
                "High resolution image" => $media->getImageHighResolutionUrl(),
                "Media type (video or image)" => $media->getType(),
                "LocationId" => $media->getLocationId(),
                "Timestamp" => $media->getCreatedTime()
            );
            /* Save the media into DB */
            $this->savePostIntoDB($result);
        }
        return $medias;
    }

    /**
     * Save the post into MySQL DB
     * @param $post
     * @return bool
     */
    function savePostIntoDB($post) {
        /* Generate the destination table name for current post */
        $tableName = $this->UTIL->formTableName($post["Id"]);
        /* Gather information needed to insert into the table */
        $id = $post['Id'];
        $shortcode = $post["Shotrcode"];
        $created = $post["Created"];
        $num_comment = $post["Number of comments"];
        $num_like = $post["Number of likes"];
        $image_link = $post["High resolution image"];
        $media_type = $post["Media type (video or image)"];
        $localtionid = $post["LocationId"];

        /* MySQL query, but when duplicate key appears, update num_likes */
        $query = $this->DB->query("INSERT INTO `".$tableName."` (id, shortcode, created, num_comment, num_like, image_link, media_type, locationid) 
                                VALUES($id, $shortcode, $created, $num_comment, $num_like, $image_link, $media_type, $localtionid) ON DUPLICATE KEY UPDATE num_like = $num_like");

        /* Check if the query was successful */
        if ($query) return false;
        return true;
    }

}

