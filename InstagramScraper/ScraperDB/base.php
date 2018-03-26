<?php

require __DIR__ . '/../vendor/autoload.php';

require_once 'config.php';
require_once 'database.php';
require_once 'utils.php';



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
        $this->INS = \InstagramScraper\Instagram::withCredentials(BASEACC, BASEPW, '');
        try {
            $this->INS->login();
        } catch (Exception $exception) {
            $this->handleException($exception);
        }
        // $this->INS = new \InstagramScraper\Instagram();
        try {
            $this->ACCOUNT = $this->INS->getAccount(BASEACC);
        } catch (Exception $exception) {
            $this->handleException($exception);
        }
        $this->TIMEOUT = 100;
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
     * Get User's All Media Lists
     * @param \InstagramScraper\Model\Account $account
     */
    function getPosts(\InstagramScraper\Model\Account $account) {
        try {
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
                $this->savePostIntoDB($result, $account->getFollowedByCount());
            }
        } catch (\InstagramScraper\Exception\InstagramException $exception) {
            $this->handleException($exception);
            $this->getPosts($account);
        }
    }

    /**
     * Save the post into MySQL DB
     * @param $post
     * @param $expectValue
     * @return bool
     */
    function savePostIntoDB($post, $expectValue) {
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
        echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;------ Inserted media with ID -- [ ".$id." ] <br>";
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

