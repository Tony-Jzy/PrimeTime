<?php

/* Start the Output buffering */
ob_start();

require_once dirname(__FILE__).'/'.'base.php';

/* Heads up that is fetching User posts */
echo('Fetching Media Posts from Base User');
ob_flush();

$base = new Base();
$base->getPosts($base->getAccount(BASEACC));

/* Heads up that program done fetching User posts */
echo('Done fetching Media Posts from Base User');


/* Heads up that is fetching User posts */
echo('Fetching Media Posts from Followers');
ob_flush();
/* Get Followers Media Posts */
$followers = $base->getFollowers();
foreach ($followers as $follower) {
    $followerAccount = $base->getAccount($follower['username']);
    if ($followerAccount) {
        /* Heads up that is fetching User posts */
        echo('Fetching Media Posts from User'.$follower['username']);
        ob_flush();
        $base->getPosts($followerAccount);
        echo('Done fetching Media Posts from User'.$follower['username']);
        ob_flush();
    }
}

/* Get Following Media Posts */
$followings = $base->getFollowing();
foreach ($followings as $following) {
    $followingAccount = $base->getAccount($following['username']);
    if ($followingAccount) {
        /* Heads up that is fetching User posts */
        echo('Fetching Media Posts from User'.$following['username']);
        ob_flush();
        $base->getPosts($followingAccount);
        echo('Done fetching Media Posts from User'.$following['username']);
        ob_flush();
    }
}

echo('Done all work');
ob_end_flush();