<?php

      /**
      * @SWG\Post(
      *     path="/Account/register.php",
      *     tags={"Account"},
      *     summary="用户注册",
      *     description="用户注册接口",
      *     consumes={"application/json"},
      *     produces={"application/json"},
       *     @SWG\Parameter(
       *         name="registerReq",
       *         in="body",
       *         description="用户注册信息json",
       *         required=true,
       *         type="application/json",
       *         @SWG\Schema(ref="#/definitions/registerReq"),
       *     ),
      *    @SWG\Response(
      *         response=200,
      *         description="登录响应码",
      *         @SWG\Schema(ref="#/definitions/Response"),
      *     ),
      * )
      */

require_once dirname(__FILE__).'/'.'../Class/JSON.php';
require_once dirname(__FILE__).'/'.'../Class/User.php';
$User = new User();
$JSON = new JSON();


$postJson = file_get_contents("php://input");
$postArray = json_decode($postJson, true);

/* Get request body json values */
$username = $postArray['username'];
$password = $postArray['password'];
$email = $postArray['email'];


/* make sure no empty value in the json body */
if (!empty($username) && !empty($password) && !empty($email)) {

	$result = $User->register($username, $password, $email);
	$success = false;
	switch ($result) {
        case -3:
             $error = 'Username Existed, please change to another username.';
             break;
        case -4:
             $error = 'Email already registered, please change another email.';
             break;
        default:
             $success = true;
             $error = '';
    }

} else {
     $error = 'Input value error, please check the values and retry.';
     $success = false;
}

$json_array = array(
          'success' => $success,
          'error' => $error
          );

echo json_encode($json_array,JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);







