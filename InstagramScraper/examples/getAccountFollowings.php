<?php

/**
 * @SWG\GET(
 *     path="/getAccountFollowings.php",
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
 *     ),
 *     @SWG\Parameter(
 *         name="count",
 *         in="query",
 *         description="count",
 *         required=false,
 *         type="integer",
 *     ),
 *     @SWG\Parameter(
 *         name="pageSize",
 *         in="query",
 *         description="pageSize",
 *         required=false,
 *         type="integer",
 *     )
 *
 * )
 */

require __DIR__ . '/../vendor/autoload.php';

$username = $_GET['username'];
$password = $_GET['password'];
$count = $_GET['count'];
$pageSize = $_GET['pageSize'];

$instagram = \InstagramScraper\Instagram::withCredentials($username, $password, '');
$instagram->login();
sleep(2); // Delay to mimic user

$followers = [];
$account = $instagram->getAccount($username);
sleep(1);
$followers = $instagram->getFollowing($account->getId(), $count, $pageSize, true);
echo json_encode($followers, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);