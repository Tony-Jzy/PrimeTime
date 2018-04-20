<?php

     /**
     * @SWG\Post(
     *     path="/user/account/login.php",
     *     tags={"Account"},
     *     summary="登录接口",
     *     description="用户登录接口",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="useracc",
     *         in="formData",
     *         description="用户登录用户名",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="userpw",
     *         in="formData",
     *         description="用户登录密码",
     *         required=true,
     *         type="string",
     *     ),
     *    @SWG\Response(
     *         response=200,
     *         description="登录响应码", 
     *         @SWG\Schema(ref="#/definitions/CustomResponse"),
     *     ),
     * )
     */


require_once dirname(__FILE__).'/'.'../Class/User.php';
$User = new User();

$postJson = file_get_contents("php://input");
$postArray = json_decode($postJson, true);

/* Get request body json values */
$username = $postArray['username'];
$password = $postArray['password'];


/* make sure no empty value in the json body */
$User->login($username, $password);
















