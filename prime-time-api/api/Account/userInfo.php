<?php
/**
 * Created by PhpStorm.
 * User: shinji
 * Date: 2018/4/18
 * Time: 下午1:53
 */

	/**
     * @SWG\GET(
     *     path= "/user/userinfo/getMyInfos.php",
     *     tags={"UserInfo"},
     *     summary="获取个人信息",
     *     description="获取个人信息接口",
     *     @SWG\Parameter(
     *         name="uid",
     *         in="query",
     *         description="SessionID",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="token",
     *         in="query",
     *         description="用户存于手机中的token值",
     *         required=true,
     *         type="string",
     *     ),
     *    @SWG\Response(
     *         response=200,
     *         description="登录响应码",
     *         @SWG\Schema(type="array",
     *                     @SWG\Items(ref="#/definitions/CustomResponse")),
     *     ),
     * )
     */

require_once dirname(__FILE__).'/'.'../Class/User.php';
$User = new User();

$uid = $_GET['uid'];
$token = $_GET['token'];

$User->loginVerify($uid,$token);
