<?php


/**
 * User.class
 */


require_once dirname(__FILE__).'/'.'Database.php';
require_once dirname(__FILE__).'/'.'JSON.php';





class User{

	var $time;
	var $db;
	var $json;

	function __construct() {
        $this->time = time();
        $this->db = new DB();
        $this->json = new JSON();
	}

    /* ----------- */
    /* 账号操作相关 */
    /* ---------- */

    /**
     * 使用账号密码登录，验证通过，返回用户信息
     * @param string $acc
     * @param string $pw
     */
    function login($acc = '', $pw = ''){

        $sql = "SELECT uid,username,password,salt FROM `".DB_PRE."members` WHERE username = '".$acc."'";
        $pwcheck = $this->db->fetch_all($sql);

        if(!empty($pwcheck)) { //用户名正确
            if(md5(md5($pw).$pwcheck[0]['salt']) == $pwcheck[0]['password']) { //密码正确
                //查是否登陆过
                $sql = "SELECT sid FROM `".DB_PRE."session` WHERE uid = '".$pwcheck[0]['uid']."'";
                $sescheck = $this->db->fetch_all($sql);
                // 生成过期时间
                $expire = time() + 30*24*3600;
                // 生成token
                $token = md5($pwcheck[0]['password'].time()).md5($pwcheck[0]['uid'].time());

                if(empty($sescheck)) { //初次登陆
                    //设置sid
                    $sql = "INSERT INTO `".DB_PRE."session` (`sid`, `ip`, `uid`, `username`, `lastlogin`, `token`, `expiretime`) VALUES ('".md5($pwcheck[0]['password'].time())."', '".$_SERVER['REMOTE_ADDR']."', '".$pwcheck[0]['uid']."', '".$pwcheck[0]['username']."', '".time()."', '".$token."', '".$expire."');";
                    $sesset = $this->db->query($sql);
                    if($sesset) { //设置成功
                        $sid = md5($pwcheck[0]['password'].time());
                    } else { //设置失败
                        $sid = 500;
                    }
                } else { //已登陆
                    //更新最近登陆时间
                    $sql = "UPDATE `".DB_PRE."session` SET `lastlogin` = '".time()."', `token` = '".$token."', `expiretime` = '".$expire."' WHERE `sid` = '".$sescheck[0]['sid']."'";
                    $upsid = $this->db->query($sql);
                    if($upsid) { //更新成功
                        $sid = $sescheck[0]['sid'];
                    } else {//更新失败
                        $sid = 500;
                    }
                }
            } else { //密码错误
                $sid = 'aperror';
                $error = "Password not match!";
                $success = false;
                $data = array();
            }
        } else { //用户名不存在
            $sid = 'aperror';
            $error = "User not found!";
            $success = false;
            $data = array();
        }


        //输出json
        if(empty($sid)) {
            $error = "Server error!";
            $success = false;
            $data = array();
        } else {
            if(!empty($sid) && $sid != 500 && $sid != 'aperror') {
                $sql = "SELECT * FROM `".DB_PRE."member_profile` WHERE uid = '".$pwcheck[0]['uid']."'";
                $userInfo = $this->db->fetch_all($sql);
                if(!empty($userInfo)){
                    $error= "";
                    $success = true;
                    $data = array(
                        'userInfo'=> array(
                            'uid' => $userInfo[0]['uid'],
                            'username' => $userInfo[0]['username'],
                            'ins_username' => $userInfo[0]['ins_username'],
                            'ins_cached_time' => $userInfo[0]['ins_cached_time']
                        ),
                        'authenInfo' => array(
                            'token' => $token,
                            'sessionId' => $sid
                        )
                    );
                } else {
                    $error = "Failed fetching info!";
                    $success = false;
                    $data = array();

                }
            }
        }
        $json_array = array(
            'error' => $error,
            'success' => $success,
            'data' => $data
        );
        echo json_encode($json_array,JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }


    /**
     * 使用uid和token进行登录，验证通过，便返回用户信息
     * @param string $uid
     * @param string $token
     */
    function loginVerify($uid = '', $token = ''){
        if(!empty($uid) && !empty($token)){
            $sql = "SELECT username,sid, token, expiretime FROM `".DB_PRE."session` WHERE uid = '".$uid."'";
            $sescheck = $this->db->fetch_all($sql);
            if(count($sescheck)=='1'){
                if ($token == $sescheck[0]['token']) {
                    if (time() >= $sescheck[0]['expiretime']) {
                        $error= "token expired!";
                        $success = false;
                        $data = array();
                    } else {
                        $sql = "SELECT * FROM `".DB_PRE."member_profile` WHERE uid = '".$uid."'";
                        $userInfo = $this->db->fetch_all($sql);

                        if(!empty($userInfo)){
                            $error= "";
                            $success = true;
                            $data = array(
                                'userInfo'=> array(
                                    'uid' => $userInfo[0]['uid'],
                                    'username' => $userInfo[0]['username'],
                                    'ins_username' => $userInfo[0]['ins_username'],
                                    'ins_cached_time' => $userInfo[0]['ins_cached_time']
                                ),
                                'authenInfo' => array(
                                    'token' => $sescheck[0]['token'],
                                    'sessionId' => $sescheck[0]['sid']
                                )
                            );
                        } else {
                            $error= "Server error!";
                            $success = false;
                            $data = array();
                        }
                    }
                } else {
                    $error= "Authentication failed";
                    $success = false;
                    $data = array();
                }
            }else{
                $error= "Sessionid error!";
                $success = false;
                $data = array();
            }
        }else {
            $error= "Parameters empty!";
            $success = false;
            $data = array();
        }

        $json_array = array(
            'error' => $error,
            'success' => $success,
            'data' => $data
        );
        echo json_encode($json_array,JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }


    /**
     * 添加用户进入数据库，用户状态为未激活用户，需要后续进行邮件激活
     * @param $username
     * @param $password
     * @param $email
     * @param $regip
     * @return int
     */
	function register($username, $password, $email) {
	    $checkUser = $this->db->fetch_all("SELECT * FROM ".DB_PRE."members WHERE username = '$username'");
	    if ($checkUser) {
	        return NAME_ALREADY_REGISTERED;
        }
        $checkEmail = $this->db->fetch_all("SELECT * FROM ".DB_PRE."members WHERE email = '$email'");
        if ($checkEmail) {
            return EMAIL_ALREADY_REGISTERED;
        }

		$salt = substr(uniqid(rand()), -6);
		$password = md5(md5($password).$salt);
		$this->db->query("INSERT INTO ".DB_PRE."members (username, password, email,salt) VALUES('$username', '$password','$email','$salt')");
		$uid = $this->db->insert_id();
        $this->db->query("INSERT INTO ".DB_PRE."member_profile (uid, username) VALUES('$uid', '$username')");
        return $uid;
	}


    /* ------------------- */
    /* 后端HelperFunctions */
    /* ------------------ */

    /**
     * 验证用户token，仅为后端使用
     * @param $uid
     * @param $token
     * @return array
     */
    function tokenVerify($uid, $token) {
        if (!empty($uid) && !empty($token)) {
            $sql = "SELECT sid, token, expiretime FROM `".DB_PRE."common_session_app` WHERE uid = '".$uid."'";
            $sescheck = $this->db->fetch_all($sql);
            if(count($sescheck)==1){
                if ($token == $sescheck[0]['token']) {
                    if (time() >= $sescheck[0]['expiretime']) {
                        $error= "token已过期！";
                        $success = false;
                    } else {
                        $error= "";
                        $success = true;
                    }
                } else {
                    $error= "token不匹配！";
                    $success = false;
                }
            } else {
                $error= "服务器出错！";
                $success = false;
            }
        } else {
            $error= "无法读取参数！";
            $success = false;
        }

        $json_array = array(
            'error' => $error,
            'success' => $success
        );
        return $json_array;
    }
}