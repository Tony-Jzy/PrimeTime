<?php

//ob_implicit_flush();
/* Start the Output buffering */
//ob_start();

require_once dirname(__FILE__).'/'.'base.php';

$username = $_GET['username'];
$password = $_GET['password'];
$depth = $_GET['depth'];

/* Heads up that is fetching User posts */
//echo '<div style="border: 2px solid #000;">';
//echo '<h1 style="font-size:120%;">&nbsp;&nbsp;&nbsp;&nbsp;Fetching Media Posts from Base User&nbsp;.&nbsp;.&nbsp;.&nbsp; </h1>';
//ob_flush();

$base = new Base();
$base->initInstagram($username, $password, 20);
//$base->getPosts($base->ACCOUNT);
//echo "<br />\n";
//echo '</div>';



/* If depth bigger than 1, then start fetching from other followers */
if ($depth > 1) {
    /* Heads up that is fetching User posts */

//    echo '<div style="border: 2px solid #000;">';
//    echo '<h1 style="font-size:120%;">&nbsp;&nbsp;&nbsp;&nbsp;Fetching Media Posts from Followers&nbsp;.&nbsp;.&nbsp;.&nbsp; </h1>';
//    ob_flush();
    /* Get Followers Media Posts */
    $followers = $base->getFollowers();
    foreach ($followers as $follower) {
        $followerAccount = $base->getAccount($follower['username']);
        if ($followerAccount) {
            /* Heads up that is fetching User posts */
//            echo('&nbsp;&nbsp;----Fetching Media Posts from User -- [ '.$follower['username'].' ]&nbsp;.&nbsp;.&nbsp;.&nbsp;');
//            echo "<br />\n";
//            ob_flush();
            $base->getPosts($followerAccount, 20);
//            ob_flush();
        }
    }

//    echo '</div>';
//    echo "<br />\n";


    /* If depth bigger than 2, then start fetching from other followers */
    if ($depth > 2) {
//        echo '<div style="border: 2px solid #000;">';
//        echo '<h1 style="font-size:120%;">&nbsp;&nbsp;&nbsp;&nbsp;Fetching Media Posts from Following&nbsp;.&nbsp;.&nbsp;.&nbsp; </h1>';
//        ob_flush();

        /* Get Following Media Posts */
        $followings = $base->getFollowing();
        foreach ($followings as $following) {
            $followingAccount = $base->getAccount($following['username']);
            if ($followingAccount) {
                /* Heads up that is fetching User posts */
//                echo('&nbsp;&nbsp;&nbsp;&nbsp;---- Fetching Media Posts from User -- [ '.$following['username'].' ]&nbsp;.&nbsp;.&nbsp;.&nbsp;');
//                echo "<br />\n";
//                ob_flush();
                $base->getPosts($followingAccount, 20);
//                ob_flush();
            }
        }
//        echo '</div>';
//        echo "<br />\n";
    }
}

//echo '<div style="border: 2px solid #000;">';
//echo '<h1 style="font-size:300%;">&nbsp;&nbsp;&nbsp;&nbsp;Program Finished </h1>';
//echo '</div>';

//ob_end_flush();

echo json_encode(
    array(
    "success" => true,
    "error" => ""),
    JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);