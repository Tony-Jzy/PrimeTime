<?php

/**
 * @SWG\GET(
 *     path="/getAccountById.php",
 *     tags={"Account"},
 *     summary="",
 *     description="",
 *     @SWG\Parameter(
 *         name="username",
 *         in="query",
 *         description="username",
 *         required=false,
 *         type="string",
 *     ),
 *     @SWG\Parameter(
 *         name="password",
 *         in="query",
 *         description="password",
 *         required=false,
 *         type="string",
 *     )
 * )
 */


require __DIR__ . '/../vendor/autoload.php';

$username = $_GET['username'];
$password = $_GET['password'];

$instagram = \InstagramScraper\Instagram::withCredentials($username, $password, '');
$instagram->login();

$account  = $instagram -> getAccount($username);



//// Available fields
//echo "Account info:\n";
//echo "Id: {$account->getId()}\n";
//echo "Username: {$account->getUsername()}\n";
//echo "Full name: {$account->getFullName()}\n";
//echo "Biography: {$account->getBiography()}\n";
//echo "Profile picture url: {$account->getProfilePicUrl()}\n";
//echo "External link: {$account->getExternalUrl()}\n";
//echo "Number of published posts: {$account->getMediaCount()}\n";
//echo "Number of followers: {$account->getFollowedByCount()}\n";
//echo "Number of follows: {$account->getFollowsCount()}\n";
//echo "Is private: {$account->isPrivate()}\n";
//echo "Is verified: {$account->isVerified()}\n";


$jsonArray = array(
    "Id" => $account->getId(),
    "Username" => $account->getUsername(),
    "Full name" => $account->getFullName(),
    "Biography" => $account->getBiography(),
    "Profile picture url" => $account->getProfilePicUrl(),
    "External link" => $account->getExternalUrl(),
    "Number of published posts" => $account->getMediaCount(),
    "Number of followers" => $account->getFollowedByCount(),
    "Number of follows" => $account->getFollowsCount(),
    "Is private" => $account->isPrivate(),
    "Is verified" => $account->isVerified()

);


echo json_encode($jsonArray, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

