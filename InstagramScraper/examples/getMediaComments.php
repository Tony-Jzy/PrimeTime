<?php
/**
 * @SWG\GET(
 *     path="/getMediaComments.php",
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
 *         name="code",
 *         in="query",
 *         description="code",
 *         required=false,
 *         type="string",
 *     ),
 *     @SWG\Parameter(
 *         name="id",
 *         in="query",
 *         description="commentId",
 *         required=false,
 *         type="string",
 *     ),
 *     @SWG\Parameter(
 *         name="count",
 *         in="query",
 *         description="count",
 *         required=false,
 *         type="string",
 *     )
 * )
 */


require __DIR__ . '/../vendor/autoload.php';

$username = $_GET['username'];
$password = $_GET['password'];
$code = $_GET['code'];
$id = $_GET['id'];
$count = $_GET['count'];

$instagram = \InstagramScraper\Instagram::withCredentials($username, $password, '');
$instagram->login();


if ($code) {
// Get media comments by shortcode
    $comments = $instagram->getMediaCommentsByCode($code, $count);
}

if ($id) {
// or by id
    $comments = $instagram->getMediaCommentsById($id, $count);
}

$data = array();

foreach ($comments as $comment) {
    $account = $comment->getOwner();
    $result = array(
        "Id" => $comment->getId(),
        "Created at" => $comment->getCreatedAt(),
        "Comment text" => $comment->getText(),
        "CommentOwner" => array(
        "Id" => $account->getId(),
        "Username" => $account->getUsername(),
        "Profile picture url" => $account->getProfilePicUrl()
        )
    );
    array_push($data, $result);
}

echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);




//// Let's take first comment in array and explore available fields
//$comment = $comments[0];
//
//echo "Comment info: \n";
//echo "Id: {$comment->getId()}\n";
//echo "Created at: {$comment->getCreatedAt()}\n";
//echo "Comment text: {$comment->getText()}\n";
//$account = $comment->getOwner();
//echo "Comment owner: \n";
//echo "Id: {$account->getId()}";
//echo "Username: {$account->getUsername()}";
//echo "Profile picture url: {$account->getProfilePicUrl()}\n";
//
//// You can start loading comments from specific comment by providing comment id
//$comments = $instagram->getMediaCommentsByCode('BG3Iz-No1IZ', 200, $comment->getId());
//
//// ...



