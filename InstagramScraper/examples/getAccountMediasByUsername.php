<?php

/**
 * @SWG\GET(
 *     path="/getAccountMediasByUsername.php",
 *     tags={"Account"},
 *     summary="",
 *     description="",
 *     @SWG\Parameter(
 *         name="username",
 *         in="query",
 *         description="username",
 *         required=true,
 *         type="string",
 *     ),
 *     @SWG\Parameter(
 *         name="password",
 *         in="query",
 *         description="password",
 *         required=true,
 *         type="string",
 *     ),
 *     @SWG\Parameter(
 *         name="count",
 *         in="query",
 *         description="count",
 *         required=false,
 *         type="integer",
 *     )
 * )
 */


require __DIR__ . '/../vendor/autoload.php';


$username = $_GET['username'];
$password = $_GET['password'];
$count = $_GET['count'];

if (!$count) {
    $count = 20;
}

if ($password) {
    // If account private you should be subscribed and after auth it will be available
    $instagram = \InstagramScraper\Instagram::withCredentials($username, $password, '');
    $instagram->login();
    $medias = $instagram->getMedias($username, $count);
} else {
    // If account is public you can query Instagram without auth
    $instagram = new \InstagramScraper\Instagram();
    $medias = $instagram->getMedias($username, $count);
}


$account = $medias[0]->getOwner();
$accountInfo = array(
    "Id" => $account->getId(),
    "Username" => $account->getUsername(),
    "Full name" => $account->getFullName(),
    "Profile pic url" => $account->getProfilePicUrl()
);

$data = array();

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
    array_push($data, $result);
}

$jsonArray = array(
    "AccountInfo" => $accountInfo,
    "Data" => $data
);

echo json_encode($jsonArray, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);





