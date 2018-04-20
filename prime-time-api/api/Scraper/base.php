<?php

require __DIR__ . '/../vendor/autoload.php';

require_once '../Class/Config.php';
require_once '../Class/Database.php';
require_once '../Class/Utils.php';



class Base {

    var $DB;
    var $TIME;
    var $INS;
    var $UTIL;
    var $ACCOUNT;
    var $TIMEOUT;

    function __construct() {
        $this->DB = new DB();
        $this->TIME = time();
        $this->UTIL = new Utils();
        $this->TIMEOUT = 100;
    }

    /**
     * Initialize InstagramScraper Base Account
     * @param $username
     * @param $password
     * @param $total
     */
    function initInstagram($username, $password, $total) {
        $password = $username ? $password : BASEPW;
        $username = $username ? $username : BASEACC;
        $this->INS = \InstagramScraper\Instagram::withCredentials($username, $password, '');

        try {
            $this->INS->login();
        } catch (Exception $exception) {
            $this->handleException($exception);
        }
        // $this->INS = new \InstagramScraper\Instagram();
        try {
            $this->ACCOUNT = $this->INS->getAccount($username);
        } catch (Exception $exception) {
            $this->handleException($exception);
        }

        $this->getPosts($this->ACCOUNT, $total);
    }


    /**
     * Get Account by Username
     * @param $username
     * @return \InstagramScraper\Model\Account
     */
    function getAccount($username) {
        try {
            $account = $this->INS->getAccount($username);
            return $account;
        } catch (Exception $exception) {
            $this->handleException($exception);
            return $this->getAccount($username);
        }
    }

    /**
     * Get the list of followers of the User
     * @return array
     */
    function getFollowers() {
        try {
            $followers = $this->INS->getFollowers($this->ACCOUNT->getId(), $this->ACCOUNT->getFollowedByCount(), $this->ACCOUNT->getFollowedByCount(), true);
            return $followers;
        } catch (\InstagramScraper\Exception\InstagramException $exception) {
            $this->UTIL->timeOut($this->TIMEOUT);
            return $this->getFollowers();
        }
    }

    /**
     * Get the list of followings of the User
     * @return array
     */
    function getFollowing() {
        try {
            $following = $this->INS->getFollowing($this->ACCOUNT->getId(), $this->ACCOUNT->getFollowsCount(), $this->ACCOUNT->getFollowsCount(), true);
            return $following;
        } catch (\InstagramScraper\Exception\InstagramException $exception) {
            $this->UTIL->timeOut($this->TIMEOUT);
            return $this->getFollowing();
        }
    }


    /**
     * Get User's Last 20 Media Lists
     * @param \InstagramScraper\Model\Account $account
     * @param $total
     */
    function getPosts(\InstagramScraper\Model\Account $account, $total) {
        $insUsername = $account->getUsername();
        $userId = $this->DB->fetch_all("SELECT uid FROM ".DB_PRE."member_profile WHERE ins_username ='$insUsername'");
        $userId = !$userId[0]['uid'] ? 0 : $userId[0]['uid'];
        try {
            $medias = $this->INS->getMedias($account->getUsername(), $total);
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
                $this->savePostIntoDB($result, $account->getFollowedByCount(), !$userId  ? 0 : $userId);
            }
            $this->DB->query("UPDATE ".DB_PRE."member_profile SET ins_cached_time = ".time().", avatar = ".$account->getProfilePicUrl()." WHERE uid = $userId");
        } catch (\InstagramScraper\Exception\InstagramException $exception) {
            $this->handleException($exception);
            $this->getPosts($account, $total);
        }
    }

    /**
     * Save the post into MySQL DB
     * @param $post
     * @param $expectValue
     * @param int $userId
     * @return bool
     */
    function savePostIntoDB($post, $expectValue, $userId) {
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
        $query = $this->DB->query("INSERT INTO `".$tableName."` (id, shortcode, created, num_comment, num_like, image_link, media_type, locationid, expect_like) VALUES('$id', '$shortcode', '$created', '$num_comment', '$num_like', '$image_link', '$media_type', '$localtionid','$expectValue') ON DUPLICATE KEY UPDATE num_like = '$num_like', expect_like = '$expectValue'");

        /* Check if the query was successful */
        if (!$query) return false;
//        echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;------ Inserted media with ID -- [ ".$id." ] <br>";
        /* If userId is provided, then store the relation into user_media table */
        if ($userId) {
            $this->DB->query("INSERT INTO `".DB_PRE."user_media` (uid, mid, created) VALUES($userId, $id, $created)");
        }

        return true; 
    }


    /**
     * Instagram Exception Handler
     * @param Exception $exception
     */
    function handleException(Exception $exception) {
        if ($exception->getCode() == 429) {
            $this->UTIL->timeOut($this->TIMEOUT);
        }
    }

}

